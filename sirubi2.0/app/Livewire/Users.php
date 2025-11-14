<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Yajra\DataTables\Facades\DataTables;

class Users extends Component
{
     protected $listeners = [
    'refreshTable' => '$refresh',
    'deleteRumah'  => 'deleteRumah',
    'openEdit'     => 'openEditModal',
];

    public $nama_lengkap;
    public $email;
    public $nik;
    public $jabatan;
    public $instansi;
    public $no_hp;
    public $alamat_user;
    public $level;
    public $password;
    public $edit_id;

   

    public function getData()
    {
        $request = request();

        $query = User::where('id', '!=', auth()->user()->id) // exclude user login
                 ->orderBy('id', 'desc');

        return DataTables::eloquent($query)
            ->addIndexColumn()
           
             
               ->addColumn('level',function ($r){

                if($r->level == '1'){
                    $role = 'Admin Staff';
                }else{
                    $role = 'Staff';
                }

                return $role;

               })
                ->addColumn('action', function ($r) {
                    
                     $downloadUrl = asset('storage/' . $r->source); // buat URL publik
                  $buttons = '
                      <a href="#" 
                          class="btn btn-sm btn-light btn-active-light-primary" 
                          data-kt-menu-trigger="click" 
                          data-kt-menu-placement="bottom-end">
                          Actions
                          <span class="svg-icon svg-icon-5 m-0">
                              <svg width="24" height="24" ...></svg>
                          </span>
                      </a>

                      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                  menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                  w-150px py-4" data-kt-menu="true">

                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" 
                                class="menu-link px-3"
                                onclick="editUser(' . $r->id . ')">
                                Edit
                            </a>
                        </div>


                          <div class="menu-item px-3">
                              <a href="javascript:void(0)" 
                                  class="menu-link px-3" 
                                  onclick="confirmDelete(' . $r->id . ')">
                                  Hapus
                              </a>
                          </div>

                      </div>
                  ';

                  return '<div wire:ignore>' . $buttons . '</div>';
              })

            ->rawColumns(['action','level'])
            ->toJson();
    }


    
   public function rules()
{
    $emailRule = 'required|email';

    // Kalau EDIT → email harus ignore email user saat ini
    if ($this->edit_id) {
        $emailRule .= '|unique:users,email,' . $this->edit_id;
    } 
    // Kalau ADD → email harus unik
    else {
        $emailRule .= '|unique:users,email';
    }

    return [
        'nama_lengkap' => 'required|string|max:255',
        'email'        => $emailRule,
        'nik'          => 'nullable|string|max:16',
        'jabatan'      => 'nullable|string|max:255',
        'instansi'     => 'nullable|string|max:255',
        'no_hp'        => 'nullable|string|max:14',
        'alamat_user'  => 'nullable|string',
        'level'        => 'required|in:1,2',
        'password'     => $this->edit_id ? 'nullable|string|min:5' : 'required|string|min:5',
    ];
}

    

    public function resetForm()
    {
        $this->nama_lengkap = '';
        
        $this->email = '';
        $this->nik = '';
        $this->jabatan = '';
        $this->instansi = '';
        $this->no_hp = '';
        $this->alamat_user = '';
        $this->level = '';
        $this->password = '';
    }

    public function saveUser()
    {
        // Validasi
        try {
        $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ambil pesan error pertama
            $firstError = collect($e->validator->errors()->all())->first();

            // Kirim ke JS
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => $firstError
            ]);

            return; // STOP proses saveUser()
        }

        // ================================
        //  🔥 MODE UPDATE (EDIT)
        // ================================
        if ($this->edit_id) {

            $user = User::find($this->edit_id);

            if (!$user) {
                $this->dispatch('showAlert', [
                    'type' => 'error',
                    'message' => 'User tidak ditemukan!'
                ]);
                return;
            }

            $user->update([
                'nama_lengkap' => $this->nama_lengkap,
                'name'         => $this->nama_lengkap,
                'email'        => $this->email,
                'nik'          => $this->nik,
                'jabatan'      => $this->jabatan,
                'instansi'     => $this->instansi,
                'no_hp'        => $this->no_hp,
                'alamat_user'  => $this->alamat_user,
                'level'        => $this->level,
            ]);

            // Kalau password diisi → update
            if ($this->password) {
                $user->update([
                    'password' => Hash::make($this->password)
                ]);
            }

            $message = "User berhasil diperbarui!";
        }

        // ================================
        //  ✨ MODE CREATE (ADD)
        // ================================
        else {

            User::create([
                'nama_lengkap' => $this->nama_lengkap,
                'name'         => $this->nama_lengkap,
                'email'        => $this->email,
                'nik'          => $this->nik,
                'jabatan'      => $this->jabatan,
                'instansi'     => $this->instansi,
                'no_hp'        => $this->no_hp,
                'alamat_user'  => $this->alamat_user,
                'level'        => $this->level,
                'password'     => Hash::make($this->password),
            ]);

            $message = "User berhasil ditambahkan!";
        }

        // Tutup modal
        $this->dispatch('hideModalTambahData');

        // Refresh datatable
        $this->dispatch('refreshTable');

        // Notifikasi
        $this->dispatch('showAlert', [
            'type'    => 'success',
            'message' => $message
        ]);

        // Reset form
        $this->resetForm();

        // Reset edit mode
        $this->edit_id = null;
    }


    public function openEditModal($id)
    {
        //$id = $data['id'];

        $user = User::find($id);

        if (!$user) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'User tidak ditemukan!'
            ]);
            return;
        }

        // isi modal
        $this->nama_lengkap = $user->nama_lengkap;
       
        $this->nik          = $user->nik;
        $this->email        = $user->email;
        $this->jabatan      = $user->jabatan;
        $this->instansi     = $user->instansi;
        $this->no_hp        = $user->no_hp;
        $this->alamat_user  = $user->alamat_user;
        $this->level        = $user->level;

        $this->edit_id = $id;

        // tampilkan modal
        $this->dispatch('showModalTambahData');
    }


    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $deleted = User::find($id)->delete();

        if ($deleted > 0) {
            $this->dispatch('rumahDeleted', [
                'message' => "Data  berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('rumahDeleted', [
                'message' => "Data  tidak ditemukan!"
            ]);
        }
    }

    public function render()
    {
        return view('livewire.users')
            ->extends('layouts.master')
            ->section('content');
    }
}
