<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(IKecamatanTableSeeder::class);
        $this->call(IKelurahanTableSeeder::class);
        $this->call(AKondisiBalokTableSeeder::class);
        $this->call(AKondisiKolomTiangTableSeeder::class);
        $this->call(AKondisiPondasiTableSeeder::class);
        $this->call(AKondisiSloofTableSeeder::class);
        $this->call(AKondisiStrukturAtapTableSeeder::class);
        $this->call(APondasiTableSeeder::class);
        $this->call(BFrekuensiPenyedotanTableSeeder::class);
        $this->call(BJambanTableSeeder::class);
        $this->call(BJendelaLubangCahayaTableSeeder::class);
        $this->call(BKamarMandiTableSeeder::class);
        $this->call(BKondisiJambanTableSeeder::class);
        $this->call(BKondisiJendelaLubangCahayaTableSeeder::class);
        $this->call(BKondisiKamarMandiTableSeeder::class);
        $this->call(BKondisiSistemPembuanganAirKotorTableSeeder::class);
        $this->call(BKondisiSumberAirMinumTableSeeder::class);
        $this->call(BKondisiVentilasiTableSeeder::class);
        $this->call(BSistemPembuanganAirKotorTableSeeder::class);
        $this->call(BSumberAirMinumTableSeeder::class);
        $this->call(BSumberListrikTableSeeder::class);
        $this->call(BVentilasiTableSeeder::class);
        $this->call(CFungsiRumahTableSeeder::class);
        $this->call(CJenisFisikBangunanTableSeeder::class);
        $this->call(CRuangKeluargaDanTidurTableSeeder::class);
        $this->call(CStatusDtksTableSeeder::class);
        $this->call(CTipeRumahTableSeeder::class);
        $this->call(DAksesKeJalanTableSeeder::class);
        $this->call(DBangunanBeradaLimbahTableSeeder::class);
        $this->call(DBangunanBeradaSungaiTableSeeder::class);
        $this->call(DBangunanMenghadapJalanTableSeeder::class);
        $this->call(DBangunanMenghadapSungaiTableSeeder::class);
        $this->call(DKondisiDindingTableSeeder::class);
        $this->call(DKondisiLantaiTableSeeder::class);
        $this->call(DKondisiPenutupAtapTableSeeder::class);
        $this->call(DMaterialAtapTerluasTableSeeder::class);
        $this->call(DMaterialDindingTerluasTableSeeder::class);
        $this->call(DMaterialLantaiTerluasTableSeeder::class);
        $this->call(IAsetRumahTempatLainTableSeeder::class);
        $this->call(IAsetTanahTempatLainTableSeeder::class);
        $this->call(IBesarPengeluaranTableSeeder::class);
        $this->call(IBesarPenghasilanTableSeeder::class);
        $this->call(IBuktiKepemilikanTanahTableSeeder::class);
        $this->call(IJenisKawasanLokasiTableSeeder::class);
        $this->call(IJenisKelaminTableSeeder::class);
        $this->call(IJumlahKkTableSeeder::class);
        $this->call(IPekerjaanUtamaTableSeeder::class);
        $this->call(IPendidikanTerakhirTableSeeder::class);
        $this->call(IPernahMendapatkanBantuanTableSeeder::class);
        $this->call(IStatusImbTableSeeder::class);
        $this->call(IStatusKepemilikanRumahTableSeeder::class);
        $this->call(IStatusKepemilikanTanahTableSeeder::class);
        $this->call(TblAnggotaKkTableSeeder::class);
        $this->call(TblBantuanTableSeeder::class);
        $this->call(TblDokumenTableSeeder::class);
        $this->call(TblJenisPolygonTableSeeder::class);
        $this->call(TblJenisPondasiTableSeeder::class);
        $this->call(TblPolygonTableSeeder::class);
        $this->call(TblPolygonKelurahanTableSeeder::class);
    }
}
