<?php
// app/Jobs/CreateExportZipJob.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class CreateExportZipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1800;
    public $tries = 3;

    protected $folder;
    protected $files;
    protected $userId;
    protected $timestamp;
    protected $queueId;

    public function __construct($folder, $files, $userId, $timestamp, $queueId = null)
    {
        $this->folder = $folder;
        $this->files = $files;
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->queueId = $queueId;
        
        $this->onQueue('exports-zip');
    }

    public function handle()
    {
        Log::info("🗜️ CreateExportZipJob started for timestamp: {$this->timestamp}");

        $disk = 'public';
        $zipFilename = "export_complete_{$this->timestamp}.zip";
        $zipPath = storage_path("app/public/{$zipFilename}");

        $zip = new ZipArchive();
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $addedFiles = 0;
            
            foreach ($this->files as $file) {
                $fullPath = storage_path("app/public/{$file}");
                
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, basename($file));
                    $addedFiles++;
                    Log::info("📎 Added to ZIP: " . basename($file));
                } else {
                    Log::warning("⚠️ File not found: {$file}");
                }
            }
            
            $zip->close();
            Log::info("✅ ZIP created with {$addedFiles} files: {$zipFilename}");

            // Cleanup temporary files
            $this->cleanupTempFiles();
            
            Log::info("🎉 Export completed successfully for timestamp: {$this->timestamp}");

        } else {
            throw new \Exception("Failed to create ZIP file for timestamp: {$this->timestamp}");
        }
    }

    protected function cleanupTempFiles()
    {
        foreach ($this->files as $file) {
            $fullPath = storage_path("app/public/{$file}");
            if (file_exists($fullPath)) {
                @unlink($fullPath);
            }
        }
        
        // Hapus folder temporary
        Storage::disk('public')->deleteDirectory($this->folder);
        
        Log::info("🧹 Temporary files cleaned up for folder: {$this->folder}");
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 CreateExportZipJob failed - Timestamp: {$this->timestamp}, Error: " . $exception->getMessage());
        
        // Cleanup jika gagal
        Storage::disk('public')->deleteDirectory($this->folder);
    }
}