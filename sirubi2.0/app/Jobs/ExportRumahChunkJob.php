<?php
// app/Jobs/ExportRumahJob.php

namespace App\Jobs;

use App\Exports\RumahSheet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportRumahChunkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // 1 jam
    public $tries = 3;
    public $backoff = [60, 180, 300]; // Retry after 1, 3, 5 minutes

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
        
        // Set queue specific
        $this->onQueue('exports');
    }

    public function handle()
    {
        Log::info("🚀 ExportRumahJob started - Offset: {$this->offset}, Limit: {$this->limit}");
        
        try {
            Excel::store(
                new RumahSheet($this->offset, $this->limit, $this->query),
                "{$this->folder}/{$this->filename}",
                'public'
            );
            
            Log::info("✅ ExportRumahJob completed: {$this->filename}");
            
        } catch (\Exception $e) {
            Log::error("❌ ExportRumahJob failed: " . $e->getMessage());
            throw $e; // Will trigger retry
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 ExportRumahJob failed permanently: " . $exception->getMessage());
    }
}