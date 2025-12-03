<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MasterCrud extends Component
{
    use WithPagination;

    public $table;
    public $columns = [];
    public $data = [];
    public $editId = null;
protected $listeners = ['confirmDelete' => 'delete'];
    public $primaryKey;

    public function mount()
    {
        $this->table = request()->t;

        if (!$this->table || !Schema::hasTable($this->table)) {
            abort(404, "Table not found");
        }

        // ambil semua kolom
        $allColumns = Schema::getColumnListing($this->table);

        // deteksi primary key otomatis
        $this->primaryKey = $this->detectPrimaryKey($this->table, $allColumns);

        // kolom untuk form: exclude PK, timestamps, is_active
        $this->columns = array_filter($allColumns, function ($col) {
            return !in_array($col, [
                $this->primaryKey,
                'created_at',
                'updated_at',
                'is_active'
            ]);
        });
    }
      public function cleanName($key)
    {
        // hilangkan prefix
        $key = preg_replace('/^(a_|b_|c_|d_|i_|tbl_)/', '', $key);

        // ubah _ ke spasi
        return ucwords(str_replace('_', ' ', $key));
    }

    public function detectPrimaryKey($table, $columns)
    {
        // cek PK langsung dari database
        try {
            $index = DB::select("SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY'");
            if (!empty($index)) {
                return $index[0]->Column_name;
            }
        } catch (\Exception $e) {
            // fallback otomatis
        }

        // pola tabel master a_ / b_ / c_
        if (preg_match('/^[a-z]_/', $table)) {
            $name = preg_replace('/^[a-z]_/', '', $table); // remove prefix
            $pk = "id_" . $name; // contoh: id_kondisi_balok
            if (in_array($pk, $columns)) {
                return $pk;
            }
        }

        // pola tabel tbl_ → id_polygon
        if (str_starts_with($table, 'tbl_')) {
            $name = str_replace('tbl_', '', $table);
            $pk = "id_" . $name;
            if (in_array($pk, $columns)) {
                return $pk;
            }
        }

        // fallback jika ada kolom id
        if (in_array('id', $columns)) {
            return 'id';
        }

        abort(500, "Primary key tidak ditemukan untuk tabel: $table");
    }

    public function render()
    {
        $rows = DB::table($this->table)
            ->where('is_active', 1)          // hanya tampil yg aktif
            ->orderBy($this->primaryKey, 'ASC')
            ->paginate(10);

        return view('livewire.master-crud', [
            'rows' => $rows,
            'primaryKey' => $this->primaryKey,
        ])->extends('layouts.master')
          ->section('content');
    }

    public function save()
    {
        $data = $this->validateDynamic();

        // auto set is_active = 1 saat create
        if (!isset($data['is_active'])) {
            $data['is_active'] = 1;
        }

        if ($this->editId) {
            DB::table($this->table)
                ->where($this->primaryKey, $this->editId)
                ->update($data);
                 $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Data berhasil diperbarui!'
        ]);
        } else {
            DB::table($this->table)->insert($data);
             $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Data berhasil ditambahkan!'
        ]);
        }
  $this->dispatch('close-modal');
        $this->resetForm();
    }

    public function edit($id)
    {
        $this->editId = $id;

        $row = DB::table($this->table)
            ->where($this->primaryKey, $id)
            ->first();

        if ($row) {
            $this->data = (array) $row;
        }
    }

    // SOFT DELETE pakai is_active
    public function delete($id)
    {
        DB::table($this->table)
            ->where($this->primaryKey, $id)
            ->update(['is_active' => 0]);
              $this->dispatch('alert', [
        'type' => 'success',
        'message' => 'Data berhasil dihapus!'
    ]);
    }

    private function validateDynamic()
    {
        $rules = [];
        foreach ($this->columns as $col) {
            $rules["data.$col"] = "nullable|string";
        }
        return $this->validate($rules)['data'];
    }

    private function resetForm()
    {
        $this->data = [];
        $this->editId = null;
    }
}
