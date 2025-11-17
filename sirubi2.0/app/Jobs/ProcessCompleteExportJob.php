<?php
// app/Jobs/ProcessCompleteExportJob.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessCompleteExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 10800;
    public $tries = 1;

    protected $userId;
    protected $query;
    protected $exportFormat;
    protected $queueId;
    protected $timestamp;

    public function __construct($userId, $query = null, $exportFormat = 'excel', $queueId = null)
    {
        $this->userId = $userId;
        $this->query = $query;
        $this->exportFormat = $exportFormat;
        $this->queueId = $queueId;
        $this->timestamp = now()->format('Ymd_His');
    }

    public function handle()
    {
        Log::info("🎯 ProcessCompleteExportJob started for user: {$this->userId}, Queue: {$this->queueId}");

        $folder = "exports_{$this->timestamp}";
        $disk = 'public';

        // Buat folder temporary
        Storage::disk($disk)->makeDirectory($folder);

        $files = [];
        $maxRows = 1000;
        $total = DB::table('rumah')->count();
        $chunkCount = ceil($total / $maxRows);

        Log::info("📊 Total chunks to process: {$chunkCount}");

        // Dispatch jobs untuk setiap chunk
        for ($i = 0; $i < $chunkCount; $i++) {
            $offset = $i * $maxRows;
            
            $rumahFilename = "rumah_part_" . ($i + 1) . ".xlsx";
            $kkFilename = "kk_part_" . ($i + 1) . ".xlsx";

            // Dispatch job untuk Rumah
            ExportRumahChunkJob::dispatch($offset, $maxRows, $folder, $rumahFilename, $this->query, $this->timestamp)
                ->onQueue('exports-rumah')
                ->delay(now()->addSeconds($i * 5));

            // Dispatch job untuk KK
            ExportKKChunkJob::dispatch($offset, $maxRows, $folder, $kkFilename, $this->query, $this->timestamp)
                ->onQueue('exports-kk')
                ->delay(now()->addSeconds(($i * 5) + 2));

            $files[] = "{$folder}/{$rumahFilename}";
            $files[] = "{$folder}/{$kkFilename}";

            Log::info("📤 Dispatched jobs for chunk {$i}/{$chunkCount}");
        }

        // Dispatch job untuk Bantuan
        $bantuanFilename = "bantuan_data.xlsx";
        BantuanChunkJob::dispatch($folder, $bantuanFilename, $this->query, $this->timestamp)
            ->onQueue('exports-bantuan')
            ->delay(now()->addSeconds($chunkCount * 5 + 10));

        $files[] = "{$folder}/{$bantuanFilename}";

        // Dispatch job untuk membuat ZIP
        CreateExportZipJob::dispatch($folder, $files, $this->userId, $this->timestamp, $this->queueId)
            ->onQueue('exports-zip')
            ->delay(now()->addSeconds($chunkCount * 5 + 20));

        Log::info("✅ All export jobs dispatched for timestamp: {$this->timestamp}");
    }

    public function failed(\Throwable $exception)
    {
        Log::error("💥 ProcessCompleteExportJob failed - Queue: {$this->queueId}, Error: " . $exception->getMessage());
    }
}