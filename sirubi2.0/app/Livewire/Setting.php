<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Setting extends Component
{
    public $nama_lengkap, $nik, $jabatan, $instansi, $no_hp, $alamat_user,$email;
    public $email_new, $pass_confirm;
    public $editEmail = false;

    public $confirm_delete = false;
    public $password_delete;
    public $show_password = false;

    public $editPassword = false;
    public $password_current, $password_new, $password_confirm;

    public function openEditEmail()
    {
        $this->editEmail = true;
    }

    public function askPassword()
    {
        if (!$this->confirm_delete) {
            $this->dispatch('show-error', [
                'message' => 'Silakan centang konfirmasi terlebih dahulu.'
            ]);
            return;
        }

        $this->show_password = true;
    }


    public function mount()
    {
        $user = auth()->user();

        $this->nama_lengkap = $user->nama_lengkap ?? $user->name;
        $this->nik = $user->nik;
        $this->jabatan = $user->jabatan;
        $this->instansi = $user->instansi;
        $this->no_hp = $user->no_hp;
        $this->alamat_user = $user->alamat_user;
        $this->email = $user->email;
    }



    public function deleteAccount()
    {
        try{
            $this->validate([
            'password_delete' => 'required'
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $message = collect($e->errors())->flatten()->first();

            $this->dispatch('show-error', [
                'message' => $message
            ]);

            throw $e; // penting! biar Livewire tetap tahu ada error
        }

        $user = auth()->user();

        if (!Hash::check($this->password_delete, $user->password)) {
            $this->dispatch('show-error', [
                'message' => 'Password salah.'
            ]);
            return;
        }

        $user->delete();
        auth()->logout();

        $this->dispatch('show-success', [
            'message' => 'Akun berhasil dihapus.'
        ]);

        $this->dispatch('redirect-after-delete', [
            'url' => url('/')
        ]);
    }

    public function openEditPassword()
    {
        $this->editPassword = true;
    }

    public function cancelEditPassword()
    {
        $this->editPassword = false;
        $this->password_current = '';
        $this->password_new = '';
        $this->password_confirm = '';
    }

    public function updatePassword()
    {
        try {
            $this->validate([
                'password_current'  => 'required',
                'password_new'      => 'required|min:8',
                'password_confirm'  => 'required|same:password_new',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $message = collect($e->errors())->flatten()->first();

            $this->dispatch('show-error', [
                'message' => $message
            ]);

            throw $e; // penting! biar Livewire tetap tahu ada error
        }

        $user = auth()->user();

        if (!Hash::check($this->password_current, $user->password)) {
            return $this->dispatch('show-error', [
                'message' => 'Password lama tidak sesuai!'
            ]);
        }

        $user->update([
            'password' => bcrypt($this->password_new),
        ]);

        $this->cancelEditPassword();

        $this->dispatch('show-success', [
            'message' => 'Password berhasil diperbarui!'
        ]);
    }


    public function save()
    {
        $this->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik'          => 'required|numeric|digits_between:8,16',
            'jabatan'      => 'nullable|string|max:255',
            'instansi'     => 'nullable|string|max:255',
            'no_hp'        => 'nullable|string|max:20',
            'alamat_user'  => 'nullable|string',
        ]);

        $user = auth()->user();

        $user->update([
            'nama_lengkap' => $this->nama_lengkap,
            'name' => $this->nama_lengkap,
            'nik'          => $this->nik,
            'jabatan'      => $this->jabatan,
            'instansi'     => $this->instansi,
            'no_hp'        => $this->no_hp,
            'alamat_user'  => $this->alamat_user,
        ]);

        // Notifikasi Bootstrap/Metronic
        $this->dispatch('show-success', [
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }

    public function updateEmail()
    {
        $this->validate([
            'email_new'    => 'required|email|unique:users,email,' . auth()->id(),
            'pass_confirm' => 'required',
        ]);

        $user = auth()->user();

        // cek password
        if (!Hash::check($this->pass_confirm, $user->password)) {
            return $this->dispatch('show-error', [
                'message' => 'Password tidak sesuai.'
            ]);
        }

        // update email
        $user->update([
            'email' => $this->email_new
        ]);

        // sync
        $this->email = $this->email_new;
        $this->pass_confirm = '';

        // notif sukses
        $this->dispatch('show-success', [
            'message' => 'Email berhasil diperbarui!'
        ]);
    }


    public function render()
    {
        $data = User::find(auth()->user()->id);

        // mapping level ke role
        $role = match($data->level) {
            1 => 'Admin Staff',
            2 => 'Staff',
            default => 'Tidak Diketahui',
        };

        return view('livewire.setting', compact('data', 'role'))
            ->extends('layouts.master')
            ->section('content');
    }
}
