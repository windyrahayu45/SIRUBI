<?php
// app/Jobs/ExportKepalaKeluargaJob.php

namespace App\Jobs;

use App\Exports\KepalaKeluargaSheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportKKChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600;
    public $tries = 3;
    public $backoff = [60, 180, 300];

    protected $offset;
    protected $limit;
    protected $folder;
    protected $filename;
    protected $query;

    public function __construct($offset, $limit, $folder, $filename, $query = null)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->folder = $folder;
        $this->filename = $filename;
        $this->query = $query;
        
        $this->onQueue('exports');
    }

    public function handle()
    {
        Log::info("🚀 ExportKepalaKeluargaJob started - Offset: {$this->offset}, Limit: {$this->limit}");
        
        try {
            Excel::store(
                new KepalaKeluargaSheet($this->offset, $this->limit, $this->query),
                "{$this->folder}/{$this->filename}",
                'public'
            );
            
            Log::info("✅ ExportKepalaKeluargaJob completed: {$this->filename}");
            
        } catch (\Exception $e) {
            Log::error("❌ ExportKepalaKeluargaJob failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 ExportKepalaKeluargaJob failed permanently: " . $exception->getMessage());
    }
}