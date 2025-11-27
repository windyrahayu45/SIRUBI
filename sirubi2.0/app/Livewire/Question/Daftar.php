<?php

namespace App\Livewire\Question;

use App\Models\SurveyModule;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionOption;
use App\Models\SurveyQuestionType;
use Livewire\Component;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class Daftar extends Component
{
    public $label;
    public $key;
    public $type;
    public $is_required = false;
    public $options = [];

    public $types = [];

    public $parent_question_id = null;
    public $trigger_option_id = null;
    public $availableParents = [];
    public $availableTriggerOptions = [];

    public $editMode = false;
    public $editId   = null;
    public $module = null;
    public $modules = [];

    protected $listeners = [
        'deleteQuestion',
        'editQuestion' => 'loadEditData',
        'closeModalTambahPertanyaan' => 'resetForm'
    ];

    /* ==========================================================
     * DELETE
     * ==========================================================*/
    public function deleteQuestion($payload = [])
    {
        $id = $payload['id'] ?? null;
        if (!$id) return;

        $deleted = SurveyQuestion::where('id', $id)->update(['is_active' => 0]);

        $this->dispatch('questionDeleted', [
            'message' => $deleted ? "Data berhasil dihapus!" : "Data tidak ditemukan!"
        ]);
    }

    /* ==========================================================
     * DATATABLE
     * ==========================================================*/
    public function getData()
    {
        $query = SurveyQuestion::with('options')
            ->where('is_active', 1)
            ->orderBy('id', 'desc');

        return DataTables::eloquent($query)
            ->addIndexColumn()

            ->addColumn('required', function ($row) {
                return $row->is_required
                    ? '<span class="badge badge-light-success">Ya</span>'
                    : '<span class="badge badge-light-danger">Tidak</span>';
            })

            ->addColumn('options', function ($row) {
                if ($row->options->count() == 0) {
                    return '<span class="badge badge-light-secondary">-</span>';
                }

                return $row->options
                    ->pluck('label')
                    ->map(fn($label) =>
                        "<span class='badge badge-light-primary me-1'>$label</span>"
                    )
                    ->implode(' ');
            })

            ->addColumn('action', function ($row) {

                $buttons = '
                    <a href="#" 
                        class="btn btn-sm btn-light btn-active-light-primary" 
                        data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        Actions
                        <span class="svg-icon svg-icon-5 m-0">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
																</svg>
                        </span>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                w-150px py-4" data-kt-menu="true">

                        <div class="menu-item px-3">
                            <a href="javascript:void(0)"
                               class="menu-link px-3"
                               onclick="onEditQuestion(' . $row->id . ')">
                                Edit
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="javascript:void(0)"
                               class="menu-link px-3"
                               onclick="confirmDelete(' . $row->id . ')">
                                Hapus
                            </a>
                        </div>

                    </div>
                ';

                return '<div wire:ignore>' . $buttons . '</div>';
            })

            ->rawColumns(['required', 'options', 'action'])
            ->toJson();
    }

    /* ==========================================================
     * MOUNT
     * ==========================================================*/
    public function mount()
    {
        $this->types = SurveyQuestionType::all();

       $this->modules = SurveyModule::all();

      

    $this->availableParents = SurveyQuestion::where('is_active', 1)
        ->orderBy('order')
        ->get();
    }

    public function updatedParentQuestionId($value)
    {
        $this->trigger_option_id = null;

        $this->availableTriggerOptions = SurveyQuestionOption::where('question_id', $value)
            ->where('is_active', 1)
            ->orderBy('order')
            ->get();
    }

    public function handleParentChange($value)
{
    // pastikan nilai parent ke-set
    $this->parent_question_id = $value ?: null;

    // reset trigger yang lama
    $this->trigger_option_id = null;

    // AMBIL opsi dari parent yang dipilih
    $this->availableTriggerOptions = SurveyQuestionOption::where('question_id', $this->parent_question_id)
        ->where('is_active', 1)
        ->orderBy('order')
        ->get();
}



    /* ==========================================================
     * RESET FORM (ADD MODE)
     * ==========================================================*/
    public function resetForm()
    {
        $this->reset([
            'label', 'key', 'type', 'is_required', 'options', 'editId'
        ]);

        $this->editMode = false;
        $this->options = [];

        $this->reset([
            'parent_question_id',
            'trigger_option_id',
            'availableTriggerOptions',
        ]);
    }

    public function updatedLabel()
    {
        if (!$this->editMode && !$this->key) {
            $this->key = Str::slug($this->label, '_');
        }
    }

    /* ==========================================================
     * ADD OPTION
     * ==========================================================*/
    public function addOption()
    {
        $this->options[] = ['label' => ''];
    }

    public function removeOption($i)
    {
        unset($this->options[$i]);
        $this->options = array_values($this->options);
    }

    /* ==========================================================
     * SAVE (CREATE / UPDATE)
     * ==========================================================*/
    public function save()
    {
        if ($this->editMode) {
            return $this->update();
        }

      try {
        $this->validate([
            'label'  => 'required',
            'module' => 'required',
            'key'    => 'required|unique:survey_questions,key',
            'type'   => 'required',
        ]);

        // lanjutkan proses simpan...
    
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Ambil pesan error pertama
        $firstError = collect($e->validator->errors()->all())->first();

            // Kirim ke JS
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $firstError
            ]);

            return; 
    }
        // $q = SurveyQuestion::create([
        //     'label'       => $this->label,
        //     'key'         => $this->key,
        //     'type'        => $this->type,
        //     'is_required' => $this->is_required,
        // ]);

        $q = SurveyQuestion::create([
                'label'             => $this->label,
                'key'               => $this->key,
                'module'            => $this->module,
                'type'              => $this->type,
                'is_required'       => $this->is_required,
                'parent_question_id'=> $this->parent_question_id,
                'trigger_option_id' => $this->trigger_option_id,
            ]);

        if (in_array($this->type, ['select','radio','checkbox'])) {
            foreach ($this->options as $opt) {
                SurveyQuestionOption::create([
                    'question_id' => $q->id,
                    'label'       => $opt['label'],
                    'order'       => 0,
                ]);
            }
        }
        $this->availableParents = SurveyQuestion::where('is_active', 1)
        ->orderBy('order')
        ->get();
        $this->dispatch('closeModalTambahPertanyaan');
        $this->resetForm();
    }

    /* ==========================================================
     * UPDATE DATA (EDIT MODE)
     * ==========================================================*/
    // public function update()
    // {
    //     $this->validate([
    //         'label' => 'required',
    //         'key'   => 'required|unique:survey_questions,key,' . $this->editId,
    //         'type'  => 'required',
    //     ]);

    //     $q = SurveyQuestion::find($this->editId);
    //     if (!$q) return;

    //     // UPDATE pertanyaan utama
    //     $q->update([
    //         'label'       => $this->label,
    //         'key'         => $this->key,
    //         'type'        => $this->type,
    //         'is_required' => $this->is_required,
    //     ]);

    //     /* ---------------------------------------------------------
    //     *  OPSI: BUAT RIWAYAT — TIDAK DIHAPUS
    //     * --------------------------------------------------------- */

    //     // 1) Tandai semua opsi lama sebagai tidak aktif
    //     SurveyQuestionOption::where('question_id', $q->id)
    //         ->update(['is_active' => 0]);

    //     // 2) Tambah opsi baru
    //     if (in_array($this->type, ['select','radio','checkbox'])) {

    //         foreach ($this->options as $opt) {
    //             SurveyQuestionOption::create([
    //                 'question_id' => $q->id,
    //                 'label'       => $opt['label'],
    //                 'is_active'   => 1,      // aktif
    //                 'order'       => 0,
    //             ]);
    //         }

    //     }
    //      $this->availableParents = SurveyQuestion::where('is_active', 1)
    //     ->orderBy('order')
    //     ->get();
    //     $this->dispatch('closeModalTambahPertanyaan');
    //     $this->resetForm();
    // }

    public function update()
    {
        $this->validate([
            'label' => 'required',
            'key'   => 'required|unique:survey_questions,key,' . $this->editId,
            'type'  => 'required',
        ]);

        $q = SurveyQuestion::find($this->editId);
        if (!$q) return;

        // UPDATE pertanyaan utama
        $q->update([
            'label'             => $this->label,
            'key'               => $this->key,
            'type'              => $this->type,
            'is_required'       => $this->is_required,
            'parent_question_id'=> $this->parent_question_id, // 🔥 penting
            'trigger_option_id' => $this->trigger_option_id,  // 🔥 penting
        ]);

        /* ---------------------------------------------------------
        * OPSI: BUAT RIWAYAT — TIDAK DIHAPUS
        * --------------------------------------------------------- */

        // 1) Nonaktifkan semua opsi lama
        SurveyQuestionOption::where('question_id', $q->id)
            ->update(['is_active' => 0]);

        // 2) Tambahkan opsi baru
        if (in_array($this->type, ['select','radio','checkbox'])) {

            foreach ($this->options as $opt) {
                SurveyQuestionOption::create([
                    'question_id' => $q->id,
                    'label'       => $opt['label'],
                    'is_active'   => 1,
                    'order'       => 0,
                ]);
            }
        }

        // refresh daftar parent
        $this->availableParents = SurveyQuestion::where('is_active', 1)
            ->orderBy('order')
            ->get();

        $this->dispatch('closeModalTambahPertanyaan');
        $this->resetForm();
    }



    /* ==========================================================
     * LOAD DATA EDIT
     * ==========================================================*/
    public function loadEditData($payload = [])
    {
         $id = $payload['id'] ?? null;
        $q  = SurveyQuestion::with('options')->find($id);

        if (!$q) return;

        $this->editId      = $id;
        $this->editMode    = true;

        $this->label       = $q->label;
        $this->key         = $q->key;
        $this->type        = $q->type;
        $this->is_required = $q->is_required;
        $this->parent_question_id = $q->parent_question_id;
        $this->trigger_option_id  = $q->trigger_option_id;

        // load opsi parent untuk dropdown trigger
        if ($this->parent_question_id) {
            $this->availableTriggerOptions = SurveyQuestionOption::where('question_id', $this->parent_question_id)
                ->where('is_active', 1)
                ->get();
        }

        $this->options = in_array($q->type, ['select','radio','checkbox'])
            ? $q->options->map(fn($o) => ['label' => $o->label])->toArray()
            : [];
    }

    public function render()
    {
        return view('livewire.question.daftar')
            ->extends('layouts.master')
            ->section('content');
    }
}
