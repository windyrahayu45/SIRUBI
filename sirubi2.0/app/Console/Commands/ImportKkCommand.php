<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportKkCommand extends Command
{
    protected $signature = 'import:kk';
    protected $description = 'Import data KK dan anggota (setiap kk_a–kk_f dianggap KK berbeda per rumah)';

    public function handle()
    {
        $oldDb = DB::connection('mysql_old');
        $this->info(' Mulai import data KK (multi KK per rumah)...');

        $chunkSize = 2500;
        $offset = 0;
        $totalKK = 0;
        $totalAnggota = 0;

        do {
            $rows = $oldDb->table('tbl_kk')->offset($offset)->limit($chunkSize)->get();
            if ($rows->isEmpty()) break;

            foreach ($rows as $row) {
                $rumah = DB::table('rumah')->where('id_rumah_lama', $row->rumah_id)->first();
                if (!$rumah) continue;

                // proses setiap blok KK: A sampai F
                foreach (range('a', 'f') as $kkCode) {
                    $kkField = "kk_{$kkCode}";
                    $hasKk = !empty($row->$kkField);

                    // cek kalau ada anggota walau kk kosong
                    $hasMember = false;
                    foreach (range('a', 'j') as $anggotaCode) {
                        $nikField = "nik_{$kkCode}{$anggotaCode}";
                        $namaField = "nama_{$kkCode}{$anggotaCode}";
                        if (!empty($row->$nikField) || !empty($row->$namaField)) {
                            $hasMember = true;
                            break;
                        }
                    }

                    // lewati kalau tidak ada kk dan anggota
                    if (!$hasKk && !$hasMember) continue;

                    // buat KK dummy kalau kk kosong
                    $noKk = $hasKk ? $row->$kkField : "DUMMY-{$rumah->id_rumah}-".strtoupper($kkCode);

                    // insert kepala keluarga
                    $kkId = DB::table('kepala_keluarga')->insertGetId([
                        'rumah_id' => $rumah->id_rumah,
                        'kode_kk' => strtoupper($kkCode),
                        'no_kk' => $noKk,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $totalKK++;

                    // insert anggota
                    foreach (range('a', 'j') as $anggotaCode) {
                        $nikField = "nik_{$kkCode}{$anggotaCode}";
                        $namaField = "nama_{$kkCode}{$anggotaCode}";
                        $nik = $row->$nikField ?? null;
                        $nama = $row->$namaField ?? null;

                        if (empty($nik) && empty($nama)) continue;

                        DB::table('anggota_keluarga')->insert([
                            'kepala_keluarga_id' => $kkId,
                            'kode_anggota' => "{$kkCode}{$anggotaCode}",
                            'nik' => $nik,
                            'nama' => $nama,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        $totalAnggota++;
                    }
                }
            }

            $offset += $chunkSize;
            $this->info(" Batch ke-" . ($offset / $chunkSize) . " selesai. KK: {$totalKK}, Anggota: {$totalAnggota}");
        } while (true);

        $this->info(" Import selesai. Total KK: {$totalKK}, Total Anggota: {$totalAnggota}");
    }
}
