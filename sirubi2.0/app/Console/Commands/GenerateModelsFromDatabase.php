<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateModelsFromDatabase extends Command
{
    protected $signature = 'make:models-auto';
    protected $description = 'Generate Eloquent models automatically for tables with prefix a_–i_ and tbl_ (except tbl_identitas_rumah & tbl_kk)';

    public function handle()
    {
        $database = DB::connection()->getDatabaseName();
        $tables = DB::select("SHOW TABLES");
        $key = 'Tables_in_' . $database;

        $this->info("📦 Membaca struktur database: {$database}");

        $excluded = ['tbl_identitas_rumah', 'tbl_kk'];

        foreach ($tables as $table) {
            $tableName = $table->$key;

            // 🎯 Filter: hanya tabel a_ sampai i_, atau tbl_ kecuali yang dikecualikan
            $isAI = preg_match('/^[a-i]_/', $tableName);
            $isTbl = (str_starts_with($tableName, 'tbl_') && !in_array($tableName, $excluded));

            if (!($isAI || $isTbl)) {
                continue;
            }

            // Nama class otomatis: StudlyCase
            $className = Str::studly(Str::snake($tableName));

            // Buat folder Models jika belum ada
            $dir = app_path('Models');
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            // Ambil daftar kolom dari tabel
            $columns = DB::select("SHOW COLUMNS FROM {$tableName}");
            $fillable = [];
            foreach ($columns as $col) {
                if (!in_array($col->Field, ['id', 'created_at', 'updated_at'])) {
                    $fillable[] = $col->Field;
                }
            }

            $fillableStr = implode("', '", $fillable);
            $timestampFlag = $this->hasTimestamps($columns) ? 'true' : 'false';

            // Isi template model
            $content = <<<PHP
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class {$className} extends Model
{
    protected \$table = '{$tableName}';
    protected \$fillable = ['{$fillableStr}'];
    public \$timestamps = {$timestampFlag};
}

PHP;

            File::put("{$dir}/{$className}.php", $content);
            $this->info("✅ Model {$className} berhasil dibuat dari tabel {$tableName}");
        }

        $this->info("🎉 Semua model selesai dibuat di folder app/Models/");
    }

    private function hasTimestamps($columns)
    {
        $names = array_map(fn($col) => $col->Field, $columns);
        return in_array('created_at', $names) && in_array('updated_at', $names);
    }
}
