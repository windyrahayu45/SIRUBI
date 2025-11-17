<?php
// app/Jobs/ExportBantuanJob.php

namespace App\Jobs;

use App\Exports\BantuanSheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BantuanChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1800; // 30 menit
    public $tries = 3;
    public $backoff = [30, 90, 180];

    protected $folder;
    protected $filename;
    protected $query;

    public function __construct($folder, $filename, $query = null)
    {
        $this->folder = $folder;
        $this->filename = $filename;
        $this->query = $query;
        
        $this->onQueue('exports');
    }

    public function handle()
    {
        Log::info("🚀 ExportBantuanJob started");
        
        try {
            Excel::store(
                new BantuanSheet($this->query),
                "{$this->folder}/{$this->filename}",
                'public'
            );
            
            Log::info("✅ ExportBantuanJob completed: {$this->filename}");
            
        } catch (\Exception $e) {
            Log::error("❌ ExportBantuanJob failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 ExportBantuanJob failed permanently: " . $exception->getMessage());
    }
}