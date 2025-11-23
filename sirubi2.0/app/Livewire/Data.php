<?php

namespace App\Livewire;

use App\Exports\BantuanSheet;
use App\Exports\KepalaKeluargaSheet;
use App\Exports\RumahExport;
use App\Exports\RumahSheet;
use App\Jobs\ExportRumahJob;
use App\Jobs\ProcessCompleteExportJob;
use App\Models\Rumah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class Data extends Component
{
   protected $listeners = ['refreshTable' => '$refresh', 'loadDetailRumah','deleteRumah','checkExportProgress','check-file-ready' => 'checkFile'];
    
   public $exportFormat = '';

 public $exporting = false;
    public $exportProgress = 0;
    public $exportMessage = '';
    public $exportCompleted = false;
   
    public $timestamp = '';
    public $queueId = '';
    public $isProcessing = false;
    public $downloadUrl = null;
    public $jobFile = null;
    public $isExporting = false;

   
    
    // public $progressSteps = [
    //     'dispatching' => 5,
    //     'processing_rumah' => 30,
    //     'processing_kk' => 60,
    //     'processing_bantuan' => 80,
    //     'creating_zip' => 95,
    //     'completed' => 100
    // ];

 

    // public function exportExcel()
    // {
    //     //$this->resetExportState();
    //     $this->exporting = true;
    //     $this->exportMessage = 'Memulai proses export...';
    //     $this->exportProgress = $this->progressSteps['dispatching'];

    //     try {
    //         $userId = auth()->user()->id;
    //         $this->timestamp = now()->format('Ymd_His');
    //         $this->queueId = uniqid();

    //         Log::info("👤 User {$userId} requested export via Livewire - Chunk 1000");

    //         // Dispatch main export job dengan chunk 1000
    //         ProcessCompleteExportJob::dispatch($userId, null, 'excel', $this->queueId);

    //         $this->exportMessage = 'Proses export sedang berjalan di background...';
            
    //         // Mulai polling untuk check progress
    //         $this->dispatch('start-export-polling');

    //     } catch (\Throwable $e) {
    //         Log::error('Export dispatch failed: ' . $e->getMessage());
    //         $this->exportMessage = 'Error: ' . $e->getMessage();
    //         $this->exporting = false;
    //     }
    // }

    // public function checkExportProgress()
    // {
    //     if (!$this->exporting) {
    //         return;
    //     }

    //     try {
    //         // Check file progress berdasarkan timestamp
    //         $zipFilename = "export_complete_{$this->timestamp}.zip";
    //         $zipPath = storage_path("app/public/{$zipFilename}");

    //         if (file_exists($zipPath)) {
    //             // Export selesai
    //             $this->exportCompleted = true;
    //             $this->exporting = false;
    //             $this->exportProgress = 100; // Fixed: harus 100, bukan 1000
    //             $this->exportMessage = 'Export berhasil! File siap didownload.';
    //             $this->downloadUrl = route('download.export', ['timestamp' => $this->timestamp]);
                
    //             $this->dispatch('export-completed');
    //             return;
    //         }

    //         // Check progress berdasarkan file temporary yang sudah dibuat
    //         $this->estimateProgress();

    //     } catch (\Throwable $e) {
    //         Log::error('Progress check failed: ' . $e->getMessage());
    //     }
    // }

    // private function estimateProgress()
    // {
    //     $disk = 'public';
    //     $folder = "exports_{$this->timestamp}";

    //     // Check jika folder exists
    //     if (!Storage::disk($disk)->exists($folder)) {
    //         $this->exportProgress = $this->progressSteps['dispatching'];
    //         $this->exportMessage = 'Mempersiapkan export...';
    //         return;
    //     }

    //     // Check existing files untuk estimate progress
    //     $allFiles = Storage::disk($disk)->files($folder);
        
    //     $rumahFiles = array_filter($allFiles, fn($file) => str_contains($file, 'rumah_part_'));
    //     $kkFiles = array_filter($allFiles, fn($file) => str_contains($file, 'kk_part_'));
    //     $bantuanExists = in_array("{$folder}/bantuan_data.xlsx", $allFiles);
        
    //     $rumahCount = count($rumahFiles);
    //     $kkCount = count($kkFiles);

    //     // Hitung total chunks yang diharapkan
    //     $totalData = DB::table('rumah')->count();
    //     $expectedChunks = ceil($totalData / 1000); // Chunk size 1000

    //     Log::info("Progress Check - Rumah: {$rumahCount}/{$expectedChunks}, KK: {$kkCount}/{$expectedChunks}, Bantuan: " . ($bantuanExists ? 'Yes' : 'No'));

    //     // Estimate progress berdasarkan files yang sudah dibuat
    //     if ($bantuanExists && $rumahCount >= $expectedChunks && $kkCount >= $expectedChunks) {
    //         $this->exportProgress = $this->progressSteps['creating_zip'];
    //         $this->exportMessage = 'Membuat file ZIP...';
    //     } elseif ($bantuanExists) {
    //         $this->exportProgress = $this->progressSteps['creating_zip'] - 5;
    //         $this->exportMessage = 'Menyelesaikan proses data...';
    //     } elseif ($kkCount > 0) {
    //         // Progress berdasarkan jumlah KK files yang sudah selesai
    //         $kkProgress = min(
    //             $this->progressSteps['processing_bantuan'] - 10,
    //             $this->progressSteps['processing_kk'] + (($kkCount / $expectedChunks) * 20)
    //         );
    //         $this->exportProgress = $kkProgress;
    //         $this->exportMessage = "Memproses data kepala keluarga... ({$kkCount}/{$expectedChunks} bagian)";
    //     } elseif ($rumahCount > 0) {
    //         // Progress berdasarkan jumlah rumah files yang sudah selesai
    //         $rumahProgress = min(
    //             $this->progressSteps['processing_kk'] - 10,
    //             $this->progressSteps['processing_rumah'] + (($rumahCount / $expectedChunks) * 25)
    //         );
    //         $this->exportProgress = $rumahProgress;
    //         $this->exportMessage = "Memproses data rumah... ({$rumahCount}/{$expectedChunks} bagian)";
    //     } else {
    //         $this->exportProgress = $this->progressSteps['dispatching'];
    //         $this->exportMessage = 'Mempersiapkan export...';
    //     }
    // }

    // public function downloadExport()
    // {
    //     if ($this->downloadUrl) {
    //         return redirect()->away($this->downloadUrl);
    //     }
        
    //     $this->exportMessage = 'File belum tersedia untuk didownload.';
    // }

    // private function resetExportState()
    // {
    //     $this->exporting = false;
    //     $this->exportProgress = 0;
    //     $this->exportMessage = '';
    //     $this->exportCompleted = false;
    //     $this->downloadUrl = '';
    //     $this->timestamp = '';
    //     $this->queueId = '';
    // }

    public function exportData()
    {
          $this->isExporting = true;
        if (empty($this->exportFormat)) {
            $this->dispatch('swal:error', [
                'title' => 'Format belum dipilih!',
                'text'  => 'Silakan pilih format export terlebih dahulu.',
            ]);
            return;
        }

        if ($this->exportFormat === 'excel') {
             $this->isExporting = false;
            return $this->exportExcel();
        }

        if ($this->exportFormat === 'geojson') {
            return $this->exportGeoJson();
        }

         
    }

    
    // public function exportExcel()
    // {
    //     try {
    //         ini_set('memory_limit', '4096M');
    //         ini_set('max_execution_time', '1800');

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public'; // gunakan disk Laravel agar lebih aman

    //         // Buat folder public/storage/exports_20251109_1900/
    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

    //         $files = [];
    //         $maxRows = 1000;

    //         // 🏠 1️⃣ Ekspor Rumah & KK (chunked)
    //         $total = DB::table('rumah')->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
    //             $filename = "data_rumah_" . ($i + 1) . ".xlsx";

    //             // Simpan file ke disk public
    //             Excel::store(
    //                 new RumahExport($offset, $maxRows),
    //                 "$folder/$filename",
    //                 $disk
    //             );

    //             // Ambil path absolut setelah tersimpan
    //             $files[] = storage_path("app/public/$folder/$filename");
    //         }

    //         // 💰 2️⃣ Ekspor Bantuan
    //         $bantuanFile = "data_bantuan.xlsx";
    //         Excel::store(
    //             new BantuanSheet(),
    //             "$folder/$bantuanFile",
    //             $disk
    //         );
    //         $files[] = storage_path("app/public/$folder/$bantuanFile");

    //         // 🗜️ 3️⃣ Buat ZIP
    //         $zipFile = storage_path("app/public/export_data_$timestamp.zip");
    //         $zip = new \ZipArchive();

    //         if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
    //             foreach ($files as $f) {
    //                 if (file_exists($f)) {
    //                     $zip->addFile($f, basename($f));
    //                 } else {
    //                     Log::warning("⚠️ File tidak ditemukan: $f");
    //                 }
    //             }
    //             $zip->close();
    //         } else {
    //             throw new \Exception("Gagal membuat ZIP file di: $zipFile");
    //         }

    //         // 🧹 4️⃣ Bersihkan file sementara
    //         foreach ($files as $f) {
    //             if (file_exists($f)) @unlink($f);
    //         }
    //         if (is_dir($exportPath)) @rmdir($exportPath);

    //         // 🚀 5️⃣ Download ZIP
    //         return response()->download($zipFile)->deleteFileAfterSend(true);

    //     } catch (\Throwable $e) {
    //         dd($e->getMessage(), $e->getFile(), $e->getLine());
    //     }
    // }

    // public function exportExcel()
    // {
    //     try {
    //         // 🔥 OPTIMAL UNTUK PRODUCTION
    //         ini_set('memory_limit', '2048M'); // Jangan -1, beri batas reasonable
    //         ini_set('max_execution_time', 1800); // 30 menit
    //         ini_set('max_input_time', 1800);
            
    //         // Untuk NGINX/Apache timeout
    //         if (function_exists('apache_setenv')) {
    //             apache_setenv('no-gzip', '1');
    //         }

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public';

    //         Log::info("🚀 Starting PRODUCTION export - Folder: {$folder}");

    //         // Buat folder temporary
    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) {
    //             mkdir($exportPath, 0777, true);
    //         }

    //         $files = [];
    //         $maxRows = 50; // 🔥 KECILKAN DRASTIS untuk production
    //         $filesPerZip = 2;

    //         // 🏠 Ekspor Rumah dengan 2 Sheet - DIPISAH
    //         $total = DB::table('rumah')->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         Log::info("📊 Production - Total: {$total}, Chunks: {$chunkCount}, MaxRows: {$maxRows}");

    //         $zipCounter = 1;
    //         $currentZipFiles = [];

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
                
    //             // 🔄 BUAT 2 FILE TERPISAH dengan nama berbeda
    //             $rumahFilename = "rumah_part_" . ($i + 1) . ".xlsx";
    //             $kkFilename = "kk_part_" . ($i + 1) . ".xlsx";

    //             Log::info("🔄 Processing chunk {$i}/{$chunkCount} - Offset: {$offset}");

    //             // 🔹 1. Export Sheet Rumah DULU
    //             Log::info("📝 Exporting RumahSheet...");
    //             try {
    //                 Excel::store(
    //                     new RumahSheet($offset, $maxRows),
    //                     "$folder/$rumahFilename",
    //                     $disk
    //                 );
    //                 Log::info("✅ RumahSheet exported: {$rumahFilename}");
    //             } catch (\Exception $e) {
    //                 Log::error("❌ RumahSheet export failed: " . $e->getMessage());
    //                 continue; // Skip ke chunk berikutnya
    //             }

    //             // 🔥 BERI JEDA LEBIH LAMA untuk production
    //             sleep(3);
    //             gc_collect_cycles();
                
    //             Log::info("💾 Memory after RumahSheet: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB");

    //             // 🔹 2. Export Sheet KK SETELAHNYA  
    //             Log::info("👨‍👩‍👧‍👦 Exporting KepalaKeluargaSheet...");
    //             try {
    //                 Excel::store(
    //                     new KepalaKeluargaSheet($offset, $maxRows),
    //                     "$folder/$kkFilename",
    //                     $disk
    //                 );
    //                 Log::info("✅ KepalaKeluargaSheet exported: {$kkFilename}");
    //             } catch (\Exception $e) {
    //                 Log::error("❌ KepalaKeluargaSheet export failed: " . $e->getMessage());
    //                 // Tetap lanjut, tapi log error
    //             }

    //             $rumahPath = storage_path("app/public/$folder/$rumahFilename");
    //             $kkPath = storage_path("app/public/$folder/$kkFilename");
                
    //             if (file_exists($rumahPath)) {
    //                 $currentZipFiles[] = $rumahPath;
    //                 $files[] = $rumahPath;
    //             }
    //             if (file_exists($kkPath)) {
    //                 $currentZipFiles[] = $kkPath;
    //                 $files[] = $kkPath;
    //             }

    //             // Buat ZIP setiap filesPerZip file
    //             if (count($currentZipFiles) >= $filesPerZip * 2 || $i === $chunkCount - 1) {
    //                 $zipFilename = "batch_{$zipCounter}_{$timestamp}.zip";
    //                 $zipPath = storage_path("app/public/$folder/$zipFilename");
                    
    //                 if ($this->createZipFile($currentZipFiles, $zipPath)) {
    //                     Log::info("📦 ZIP created: {$zipFilename} with " . count($currentZipFiles) . " files");
    //                 } else {
    //                     Log::error("❌ ZIP creation failed: {$zipFilename}");
    //                 }
                    
    //                 // Reset untuk batch berikutnya
    //                 $currentZipFiles = [];
    //                 $zipCounter++;
                    
    //                 // 🔥 JEDA LEBIH LAMA di production
    //                 sleep(5);
    //                 gc_collect_cycles();
                    
    //                 Log::info("💾 Memory after ZIP: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB");
    //             }
                
    //             // Progress logging
    //             if ($i % 5 === 0) {
    //                 $progress = round(($i / $chunkCount) * 100, 2);
    //                 Log::info("📈 Export progress: {$progress}%");
    //             }
    //         }

    //         // 🗜️ Buat ZIP Final
    //         Log::info("🎯 Creating final ZIP...");
    //         $finalZipFile = storage_path("app/public/export_complete_{$timestamp}.zip");
            
    //         if ($this->createZipFile($files, $finalZipFile)) {
    //             Log::info("🎉 Final ZIP created: {$finalZipFile}");
                
    //             // 🧹 Cleanup
    //             Log::info("🧹 Cleaning up temporary files...");
    //             foreach ($files as $f) {
    //                 if (file_exists($f) && !str_contains($f, 'batch_')) {
    //                     @unlink($f);
    //                 }
    //             }
                
    //             // Hapus folder temporary
    //             Storage::disk($disk)->deleteDirectory($folder);

    //             Log::info("✅ Export completed successfully!");

    //             // 🚀 Download ZIP Final
    //             return response()->download($finalZipFile)
    //                 ->deleteFileAfterSend(true)
    //                 ->setHeaders([
    //                     'Content-Type' => 'application/zip',
    //                     'Content-Disposition' => 'attachment; filename="export_data_' . $timestamp . '.zip"',
    //                 ]);
                    
    //         } else {
    //             throw new \Exception("Failed to create final ZIP file");
    //         }

    //     } catch (\Throwable $e) {
    //         Log::error('💥 PRODUCTION Export Error: ' . $e->getMessage(), [
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
            
    //         return response()->json([
    //             'error' => 'Export gagal di production: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Helper untuk membuat file ZIP
    //  */
    // private function createZipFile(array $files, string $zipPath): bool
    // {
    //     $zip = new \ZipArchive();
        
    //     if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
    //         foreach ($files as $file) {
    //             if (file_exists($file)) {
    //                 $zip->addFile($file, basename($file));
    //             }
    //         }
    //         $zip->close();
    //         return true;
    //     }
        
    //     return false;
    // }

    // public function exportExcel()
    // {
    //     try {
    //         ini_set('memory_limit', '4096M');
    //         ini_set('max_execution_time', '1800');

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public';

    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

    //         $files = [];
    //         $maxRows = 1000;

    //         $filteredQuery =  DB::table('rumah');
        
    //         Log::info('📌 Export Excel - Filtered Query:', [
    //             'sql' => $filteredQuery->toSql(),
    //             'bindings' => $filteredQuery->getBindings(),
    //         ]);
            

    //         $total = $filteredQuery->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
    //             $filename = "data_rumah_" . ($i + 1) . ".xlsx";

    //             Excel::store(
    //                 new RumahExport($offset, $maxRows),
    //                 "$folder/$filename",
    //                 $disk
    //             );

    //             $files[] = storage_path("app/public/$folder/$filename");
    //         }

    //         // 💰 Ekspor Bantuan
    //         $bantuanFile = "data_bantuan.xlsx";
    //         Excel::store(
    //             new BantuanSheet(),
    //             "$folder/$bantuanFile",
    //             $disk
    //         );
    //         $files[] = storage_path("app/public/$folder/$bantuanFile");

    //         // 🗜️ Buat ZIP
    //          $zipFilename = "export_data_$timestamp.zip";
    //         $zipFile = storage_path("app/public/export_data_$timestamp.zip");
    //         $zip = new \ZipArchive();

    //         if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
    //             foreach ($files as $f) {
    //                 if (file_exists($f)) $zip->addFile($f, basename($f));
    //             }
    //             $zip->close();
    //         }

    //         // 🧹 Hapus file sementara
    //         foreach ($files as $f) {
    //             if (file_exists($f)) @unlink($f);
    //         }
    //         if (is_dir($exportPath)) @rmdir($exportPath);

            

    //         // ✅ Kirim URL download ke JS
    //        // $url = asset('storage/export_data_' . $timestamp . '.zip');
    //         // $url = route('export.download', ['filename' => "export_data_$timestamp.zip"]);
    //         // Log::info('✅ Excel ZIP generated', ['url' => $url]);

    //         // $url = asset("storage/$zipFilename");
           
            
    //         $url = route('download.export', ['timestamp' => $timestamp]);
    //          Log::info('✅ Excel ZIP generated', [
    //             'url' => $url,
    //             'file_path' => $zipFile
    //         ]);
    //         //$this->dispatch('excel-ready', url: $url);
    //         $this->dispatch('geojson-ready', url: $url);
    //         // HAPUS ZIP FILE SETELAH URL DIKIRIM
    //         // register_shutdown_function(function () use ($zipFile) {
    //         //     if (file_exists($zipFile)) @unlink($zipFile);
    //         // });
    //     } catch (\Throwable $e) {
    //         Log::error('Export Excel gagal: ' . $e->getMessage());
    //         $this->dispatch('swal:error', [
    //             'title' => 'Export Gagal!',
    //             'text'  => $e->getMessage(),
    //         ]);
    //     }
    // }

    public function exportExcelLocal()
    {
        try {
            ini_set('memory_limit', '4096M');
            ini_set('max_execution_time', '1800');

            $timestamp = now()->format('Ymd_His');
            $folder = "exports_$timestamp";
            $disk = 'public';

            // buat folder storage/app/public/exports_xxx
            $exportPath = storage_path("app/public/$folder");
            if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

            // nama file excel final
            $excelFilename = "data_rumah_semua_sheet.xlsx";

            // query dasar (boleh nanti ditambah filter)
            $filteredQuery = \App\Models\Rumah::query();

            // Log::info('📌 Export Excel - Query:', [
            //     'sql' => $filteredQuery->toSql(),
            //     'bindings' => $filteredQuery->getBindings()
            // ]);

            // SIMPAN 1 FILE EXCEL MULTI-SHEET
            \Maatwebsite\Excel\Facades\Excel::store(
                new \App\Exports\RumahExportAll($filteredQuery),
                "$folder/$excelFilename",
                $disk
            );

            // buat ZIP
            $zipFilename = "export_data_$timestamp.zip";
            $zipFile = storage_path("app/public/$zipFilename");

            $zip = new \ZipArchive();
            if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

                $pathExcel = storage_path("app/public/$folder/$excelFilename");

                if (file_exists($pathExcel)) {
                    $zip->addFile($pathExcel, $excelFilename);
                }

                $zip->close();
            }

            // hapus file excel setelah dimasukkan zip
            $generated = storage_path("app/public/$folder/$excelFilename");
            if (file_exists($generated)) @unlink($generated);

            // hapus folder
            if (is_dir($exportPath)) @rmdir($exportPath);

             return response()->download($zipFile)->deleteFileAfterSend(true);

        } catch (\Throwable $e) {

            Log::error('Export Excel gagal: ' . $e->getMessage());

            $this->dispatch('swal:error', [
                'title' => 'Export Gagal!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function exportExcelProd()
    {
        try {
            // LIMIT hosting agar tidak overload
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', '600');

            $timestamp = now()->format('Ymd_His');
            $folder = "exports_$timestamp";
            $disk = 'public';

            // buat folder storage/app/public/exports_xxx
            $exportPath = storage_path("app/public/$folder");
            if (!file_exists($exportPath)) {
                mkdir($exportPath, 0777, true);
            }

            // nama file excel final
            $excelFilename = "data_rumah_semua_sheet.xlsx";

            // query dasar → AMAN karena FAST MODE tidak eagerloading
            $filteredQuery = \App\Models\Rumah::select('id_rumah');

            /**
             * ==========================
             *   EXPORT FAST MODE
             * ==========================
             */
            \Maatwebsite\Excel\Facades\Excel::store(
                new \App\Exports\ProdExportAll($filteredQuery),
                "$folder/$excelFilename",
                $disk
            );

            /**
             * ==========================
             *   ZIP hasil Excel
             * ==========================
             */
            $zipFilename = "export_data_$timestamp.zip";
            $zipFile = storage_path("app/public/$zipFilename");

            $zip = new \ZipArchive();
            if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {

                $pathExcel = storage_path("app/public/$folder/$excelFilename");

                if (file_exists($pathExcel)) {
                    $zip->addFile($pathExcel, $excelFilename);
                }

                $zip->close();
            }

            // Hapus file excel individu setelah masuk ZIP
            $generated = storage_path("app/public/$folder/$excelFilename");
            if (file_exists($generated)) @unlink($generated);

            // hapus folder kosong
            if (is_dir($exportPath)) @rmdir($exportPath);

            return response()->download($zipFile)->deleteFileAfterSend(true);

        } catch (\Throwable $e) {

            Log::error('Export Excel gagal: ' . $e->getMessage());

            $this->dispatch('swal:error', [
                'title' => 'Export Gagal!',
                'text' => $e->getMessage(),
            ]);
        }
    }

   public function exportExcel()
    {
        $this->isProcessing = true;
        $timestamp = now()->format('Ymd_His');

        $this->jobFile = "exports/export_rumah_$timestamp.xlsx";

        ExportRumahJob::dispatch($this->jobFile);

        $this->dispatch('start-export-polling');
    }


    public function checkFile()
{
        if (storage_path("app/public/{$this->jobFile}") && file_exists(storage_path("app/public/{$this->jobFile}"))) {
            $this->downloadUrl = asset("storage/{$this->jobFile}");
            $this->isProcessing = false;
              $this->dispatch('export-finished');
        }
    }

    public function refreshState()
{
    // Digunakan JS untuk update state Livewire 3
}



    public function exportGeoJson()
    {
    try {
        $features = [];

        Rumah::with(['kelurahan.kecamatan', 'penilaian','kepalaKeluarga.anggota'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->chunk(500, function ($chunk) use (&$features) {
                foreach ($chunk as $r) {
                    $kepala = $r->kepalaKeluarga?->sortBy('id')->first();
                    $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();
                    $namaPemilik =  $anggotaPertama ? e($anggotaPertama->nama) : '-';

                    $features[] = [
                        'type' => 'Feature',
                        'geometry' => [
                            'type' => 'Point',
                            'coordinates' => [(float) $r->longitude, (float) $r->latitude],
                        ],
                        'properties' => [
                            'id_rumah' => $r->id_rumah,
                            'alamat' => $r->alamat,
                            'nama' => $namaPemilik,
                            'kelurahan' => $r->kelurahan->nama_kelurahan ?? '-',
                            'kecamatan' => $r->kelurahan->kecamatan->nama_kecamatan ?? '-',
                            'status_rumah' => $r->penilaian->status_rumah ?? '-',
                        ],
                    ];
                }
            });

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        $fileName = 'export_rumah_' . now()->format('Ymd_His') . '.geojson';
        $filePath = Storage::disk('public')->path($fileName);

        Storage::disk('public')->put($fileName, json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
         $this->isExporting = false;
        return response()->download($filePath)->deleteFileAfterSend(true);
    } catch (\Throwable $e) {
        Log::error('Export GeoJSON gagal: '.$e->getMessage());
        $this->dispatch('swal:error', [
            'title' => 'Export Gagal!',
            'text' => 'Kesalahan saat export GeoJSON: ' . $e->getMessage(),
        ]);
    }
    }


   

    public function render()
    {
        return view('livewire.data')
            ->extends('layouts.master')
            ->section('content');
    }

  

    public function getData()
    {
         $request = request();

        $query = Rumah::with([
            'kepemilikan',
            'sosialEkonomi',
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan',
        ])->orderBy('id_rumah', 'desc');

        // ================================
        // 🧩 1️⃣ FILTER LOKASI LANGSUNG DI RUMAH
        // ================================
        if ($request->filled('kecamatan_id')) {
            $query->whereHas('kelurahan.kecamatan', fn($q) =>
                $q->whereIn('id_kecamatan', (array)$request->get('kecamatan_id'))
            );
        }

        if ($request->filled('kelurahan_id')) {
            $query->whereIn('kelurahan_id', (array)$request->get('kelurahan_id'));
        }

        // ================================
        // 🧩 2️⃣ FILTER KEPEMILIKAN
        // ================================
        $kepemilikanFields = [
            'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
            'status_kepemilikan_rumah_id', 'status_imb_id',
            'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',
            'jenis_kawasan_lokasi_rumah_id'
        ];

        foreach ($kepemilikanFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 3️⃣ FILTER FISIK RUMAH
        // ================================
        $fisikFields = [
            'pondasi_id', 'jenis_pondasi', 'kondisi_pondasi_id',
            'kondisi_sloof_id', 'kondisi_kolom_tiang_id', 'kondisi_balok_id',
            'kondisi_struktur_atap_id', 'material_atap_terluas_id',
            'kondisi_penutup_atap_id', 'material_dinding_terluas_id',
            'kondisi_dinding_id', 'material_lantai_terluas_id',
            'kondisi_lantai_id', 'akses_ke_jalan_id', 'bangunan_menghadap_jalan_id',
            'bangunan_menghadap_sungai_id', 'bangunan_berada_limbah_id',
            'bangunan_berada_sungai_id', 'ruang_keluarga_dan_ruang_tidur_id',
            'jenis_fisik_bangunan_id', 'fungsi_rumah_id', 'tipe_rumah_id'
        ];

        foreach ($fisikFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('fisik', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 4️⃣ FILTER SANITASI
        // ================================
        $sanitasiFields = [
            'jendela_lubang_cahaya_id', 'kondisi_jendela_lubang_cahaya_id',
            'ventilasi_id', 'kondisi_ventilasi_id', 'kamar_mandi_id',
            'kondisi_kamar_mandi_id', 'jamban_id', 'kondisi_jamban_id',
            'sistem_pembuangan_air_kotor_id', 'kondisi_sistem_pembuangan_air_kotor_id',
            'frekuensi_penyedotan_id', 'sumber_air_minum_id',
            'kondisi_sumber_air_minum_id', 'sumber_listrik_id'
        ];

        foreach ($sanitasiFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('sanitasi', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 5️⃣ FILTER SOSIAL EKONOMI
        // ================================
        if ($request->filled('jumlah_kk_id')) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('jumlah_kk_id', (array)$request->get('jumlah_kk_id'))
            );
        }

        if ($request->filled('status_dtks_id')) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('status_dtks_id', (array)$request->get('status_dtks_id'))
            );
        }

        // ================================
        // 🧩 6️⃣ FILTER BANTUAN
        // ================================
        if ($request->filled('pernah_mendapatkan_bantuan_id')) {
            $query->whereHas('bantuan', fn($q) =>
                $q->whereIn('pernah_mendapatkan_bantuan_id', (array)$request->get('pernah_mendapatkan_bantuan_id'))
            );
        }

        // ================================
        // 🧩 7️⃣ FILTER PRIORITAS
        // ================================
        if ($request->filled('prioritas')) {
            $p = $request->get('prioritas');
            $query->whereHas('penilaian', function ($q) use ($p) {
                if ($p == '1') $q->where('prioritas_a', '2');
                if ($p == '2') $q->where('prioritas_b', '2');
                if ($p == '3') $q->where('prioritas_c', '2');
            });
        }

        

        // ================================
        // 🧩 4️⃣ LIMIT DATA (OPSIONAL)
        // ================================
        // if ($request->filled('limit_data')) {
        //     $query->limit((int) $request->get('limit_data'));
        // }

        // ================================
        // 📊 5️⃣ RETURN DATATABLES
        // ================================
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('expand', fn($r) =>
                '<button class="btn btn-light btn-sm toggle-detail" data-id="'.$r->id_rumah.'">
                    <i class="fas fa-plus"></i>
                </button>'
            )
            ->addColumn('nama_pemilik', function ($r) {
                $kepala = $r->kepalaKeluarga?->sortBy('id')->first();
                $anggota = $kepala?->anggota?->sortBy('id')->first();
                return $anggota ? e($anggota->nama) : '-';
            })
            ->addColumn('alamat', fn($r) => e($r->alamat ?? '-'))
            ->addColumn('foto', function ($r) {
               
                if ($r->dokumen && $r->dokumen->foto_rumah_satu) {
                    $photoUrl = asset('storage/' . $r->dokumen->foto_rumah_satu);
                    return '<img src="' . $photoUrl . '"
                    class="img-fluid rounded shadow-sm mb-2 preview-foto"
                    style="max-height: 180px; object-fit: cover; cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#previewModal"
                    data-src="' . $photoUrl . '">';
                }
                return '<span class="text-muted">Foto rumah belum diunggah.</span>';
            })
            ->addColumn('kecamatan', fn($r) => e($r->kelurahan->kecamatan->nama_kecamatan ?? '-'))
            ->addColumn('kelurahan', fn($r) => e($r->kelurahan->nama_kelurahan ?? '-'))
            ->addColumn('status_rumah', function ($r) {
                $status = $r->penilaian->status_rumah ?? '-';
                if (strtoupper($status) === 'RTLH') {
                    return '<span class="badge badge-light-danger fw-bold px-3 py-2">' . e($status) . '</span>';
                } elseif ($status && $status !== '-') {
                    return '<span class="badge badge-light-success fw-bold px-3 py-2">' . e($status) . '</span>';
                }
                return '<span class="badge badge-light-secondary fw-bold px-3 py-2">-</span>';
            })
            ->addColumn('status_backlog', fn($r) =>
                $r->sosialEkonomi && $r->sosialEkonomi->jumlah_kk_id > 1
                    ? '<span class="badge badge-light-warning fw-bold px-3 py-2">BACKLOG</span>'
                    : '<span class="badge badge-light-primary fw-bold px-3 py-2">TIDAK BACKLOG</span>'
            )
            ->addColumn('action', function ($r) {
                $buttons = '
                    <a href="#" 
                    class="btn btn-sm btn-light btn-active-light-primary" 
                    data-kt-menu-trigger="click" 
                    data-kt-menu-placement="bottom-end">
                        Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55C6.83579 8.13579 
                                6.16421 8.13579 5.75 8.55C5.33579 8.96421 
                                5.33579 9.63579 5.75 10.05L11.2929 15.5929
                                C11.6834 15.9834 12.3166 15.9834 12.7071 15.5929
                                L18.25 10.05C18.6642 9.63579 18.6642 8.96421 
                                18.25 8.55C17.8358 8.13579 17.1642 8.13579 
                                16.75 8.55L12.5657 12.7344C12.2533 13.0468 
                                11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                w-150px py-4" data-kt-menu="true">

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                            wire:click.prevent="goToDetail(' . $r->id_rumah . ')">
                            View
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                           wire:click.prevent="goToEdit(' . $r->id_rumah . ')">
                            Edit
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                            onclick="confirmDelete(' . $r->id_rumah . ')">
                            Hapus
                            </a>
                        </div>
                    </div>
                ';

                 return '<div wire:ignore.self>' . $buttons . '</div>';
            })
             ->filter(function ($query) {
                $search = request()->get('search')['value'] ?? null;
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('alamat', 'like', "%{$search}%")
                        ->orWhereHas('kelurahan', fn($k) => $k->where('nama_kelurahan', 'like', "%{$search}%"))
                        ->orWhereHas('kelurahan.kecamatan', fn($kc) => $kc->where('nama_kecamatan', 'like', "%{$search}%"))
                        ->orWhereHas('kepalaKeluarga.anggota', fn($a) => $a->where('nama', 'like', "%{$search}%"));
                    });
                }
            })
            ->rawColumns(['expand', 'status_rumah', 'status_backlog', 'action','foto'])
            ->toJson();
    }


    // 🔹 Ambil detail rumah (expand)
    public function loadDetailRumah($id)
    {
        $rumah = Rumah::with([
            'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi', 'penilaian', 'dokumen', 'bantuan',
            'kepalaKeluarga.anggota', 'kelurahan.kecamatan'
        ])->find($id);

        if (!$rumah) return;

        $html = view('livewire.partials.detail-row', compact('rumah'))->render();

        $this->dispatch('detailRumahLoaded', $html);
    }

    public function goToDetail($id)
    {
        // Langsung redirect ke halaman detail rumah
        return redirect()->route('rumah.show', ['id' => $id]);
    }

    public function goToEdit($id)
    {
        // Redirect ke halaman edit rumah
        return redirect()->route('rumah.edit', ['id' => $id]);
    }



     public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $rumah = Rumah::find($id);

        if ($rumah) {
            //$rumah->delete();
            
            $this->dispatch('rumahDeleted', [
                'message' => "Data rumah ID {$id} berhasil dihapus!"
            ]);
        }
    }

}
