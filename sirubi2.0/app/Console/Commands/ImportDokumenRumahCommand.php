<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDokumenRumahCommand extends Command
{
    protected $signature = 'import:dokumen';
    protected $description = 'Import ulang kolom foto dan dokumen rumah dari database lama (CI) ke tabel dokumen_rumah';

    public function handle()
    {
        $oldDb = DB::connection('mysql_old');
        $this->info('🖼️ Mulai re-import dokumen rumah...');

        $chunkSize = 1000;
        $offset = 0;
        $total = 0;

        do {
            $data = $oldDb->table('tbl_identitas_rumah')
                ->select('id_rumah', 'foto_kk', 'foto_ktp', 'foto_imb',
                         'foto_rumah_satu', 'foto_rumah_dua', 'foto_rumah_tiga',
                         'upload_by_id', 'upload_at',
                         'kecamatan_id', 'kelurahan_id')
                ->offset($offset)
                ->limit($chunkSize)
                ->get();

            if ($data->isEmpty()) break;

            foreach ($data as $row) {

                
                $rumahBaru = DB::table('rumah')
                    ->where('id_rumah_lama', $row->id_rumah)
                    ->value('id_rumah');

                if (!$rumahBaru) continue; 

                
                $basePath = $this->detectOldPath($row);

                DB::table('dokumen_rumah')
                    ->updateOrInsert(
                        ['rumah_id' => $rumahBaru],
                        [
                            'foto_kk' => $row->foto_kk ? $basePath . $row->foto_kk : null,
                            'foto_ktp' => $row->foto_ktp ? $basePath . $row->foto_ktp : null,
                            'foto_imb' => $row->foto_imb ? $basePath . $row->foto_imb : null,
                            'foto_rumah_satu' => $row->foto_rumah_satu ? $basePath . $row->foto_rumah_satu : null,
                            'foto_rumah_dua' => $row->foto_rumah_dua ? $basePath . $row->foto_rumah_dua : null,
                            'foto_rumah_tiga' => $row->foto_rumah_tiga ? $basePath . $row->foto_rumah_tiga : null,
                            'uploaded_by' => $row->upload_by_id,
                            'uploaded_at' => $row->upload_at,
                            'updated_at' => now(),
                        ]
                    );

                $total++;
            }

            $offset += $chunkSize;
            $this->info("✅ Batch ke-" . ($offset / $chunkSize) . " selesai, total {$total} data.");
        } while (true);

        $this->info("🎉 Selesai re-import dokumen rumah: {$total} record diupdate.");
    }

   private function detectOldPath($row)
    {
        $base = "uploads/";

       
        $paths = [
            "{$base}{$row->kecamatan_id}/{$row->kelurahan_id}/{$row->id_rumah}/",
            "{$base}{$row->kelurahan_id}/{$row->id_rumah}/",
            "{$base}{$row->id_rumah}/",
            "{$base}",
        ];

        foreach ($paths as $p) {
            if (
                ($row->foto_kk && file_exists(public_path($p . $row->foto_kk))) ||
                ($row->foto_ktp && file_exists(public_path($p . $row->foto_ktp))) ||
                ($row->foto_rumah_satu && file_exists(public_path($p . $row->foto_rumah_satu)))
            ) {
                return $p; // ditemukan path yang benar
            }
        }

        // fallback terakhir jika semua path tidak ditemukan
        return "{$base}{$row->kecamatan_id}/{$row->kelurahan_id}/{$row->id_rumah}/";
    }

}
