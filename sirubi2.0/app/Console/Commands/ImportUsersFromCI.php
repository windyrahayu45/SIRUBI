<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportUsersFromCI extends Command
{
    protected $signature = 'import:users-ci';
    protected $description = 'Import user dari database lama CI ke Laravel users';

    public function handle()
    {
        $oldDb = DB::connection('mysql_old');

        $this->info(" Mulai import users dari database CI...");

        $chunk = 500;
        $offset = 0;
        $total = 0;

        do {
            $users = $oldDb->table('tbl_users')
                ->offset($offset)
                ->limit($chunk)
                ->get();

            if ($users->isEmpty()) {
                break;
            }

            foreach ($users as $u) {

                DB::table('users')->updateOrInsert(
                    ['email' => $u->email], // unique identifier
                    [
                        'name'          => $u->nama_lengkap ?? 'User',
                        'nama_lengkap'  => $u->nama_lengkap  ?? null,
                        'jabatan'       => $u->jabatan ?? null,
                        'nik'           => $u->nik ?? null,
                        'instansi'      => $u->instansi ?? null,
                        'no_hp'         => $u->no_hp ?? null,
                        'alamat_user'   => $u->alamat ?? null,
                        'level'         => $u->level ?? 1,

                        // Password default ADMIN dienkripsi Laravel
                        'password' => Hash::make('admin'),

                        // created_at jika ada
                        'created_at' => $u->created_at ?? now(),
                        'updated_at' => now()
                    ]
                );

                $total++;
            }

            $offset += $chunk;
            $this->info(" Batch " . ($offset / $chunk) . " selesai... total user: {$total}");

        } while (true);

        $this->info(" Import selesai. Total user berhasil diimport: {$total}");
    }
}
