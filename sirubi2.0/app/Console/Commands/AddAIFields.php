<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AddAIFields extends Command
{
    protected $signature = 'master:add-ai-fields';
    protected $description = 'Add is_active, created_at, updated_at to all tables with prefix a_–i_ only';

    public function handle()
    {
        $db = DB::connection()->getDatabaseName();
        $tables = DB::select("SHOW TABLES");
        $key = "Tables_in_{$db}";

        $this->info("🔍 Mengecek tabel dengan prefix a_ hingga i_ di database: {$db}");
        $this->line("");

        foreach ($tables as $tbl) {
            $table = $tbl->$key;

            // Hanya proses tabel prefix a_ s/d i_
            if (!preg_match('/^[a-i]_/', $table)) {
                continue;
            }

            $migrationName = "add_ai_fields_to_{$table}_table";
            $fileName = date('Y_m_d_His') . "_{$migrationName}.php";
            $path = database_path("migrations/{$fileName}");

            // buat migrationnya
            $content = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('{$table}', function (Blueprint \$table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('{$table}', 'is_active')) {
                \$table->boolean('is_active')->default(1)->after('id');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('{$table}', 'created_at') &&
                !Schema::hasColumn('{$table}', 'updated_at')) {
                \$table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('{$table}', function (Blueprint \$table) {

            if (Schema::hasColumn('{$table}', 'is_active')) {
                \$table->dropColumn('is_active');
            }

            if (Schema::hasColumn('{$table}', 'created_at') &&
                Schema::hasColumn('{$table}', 'updated_at')) {
                \$table->dropTimestamps();
            }
        });
    }
};
PHP;

            File::put($path, $content);

            $this->info("✅ Migration dibuat: {$fileName} → untuk tabel {$table}");
        }

        $this->line("");
        $this->info("🎉 Semua migration prefix a_–i_ selesai dibuat!");
        $this->info("👉 Jalankan: php artisan migrate");
    }
}
