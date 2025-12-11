<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\KepalaKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\PengaduanFoto;
use App\Models\Rumah;
use App\Models\PengaduanRumah;
use App\Models\PengaduanRumahFoto;

class PengaduanController extends Controller
{
    /**
     * ===========================================================
     *  API 1 → CEK NIK & KK (NO SAVE)
     * ===========================================================
     */
    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string',
            'kk'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari KK
        $kkData = KepalaKeluarga::with(['rumah', 'anggota'])
                ->where('no_kk', $request->kk)
                ->first();

        if (!$kkData) {
            return response()->json([
                'status' => true,
                'found'  => false,
                'status_verifikasi' => 'kk_tidak_ditemukan',
                'rumah'   => null,
                'anggota' => [],
            ]);
        }

        // Cek NIK pada anggota keluarga
        $anggota = $kkData->anggota->where('nik', $request->nik)->first();

        if (!$anggota) {
            return response()->json([
                'status' => true,
                'found'  => true,
                'status_verifikasi' => 'nik_tidak_cocok',
                'rumah'   => $kkData->rumah,
                'kepala_keluarga' => $kkData,
                'anggota' => $kkData->anggota,
            ]);
        }

        // ✔ Jika NIK & KK cocok
        return response()->json([
            'status' => true,
            'found'  => true,
            'status_verifikasi' => 'terverifikasi',
            'rumah'   => $kkData->rumah,
            'kepala_keluarga' => $kkData,
            'anggota' => $kkData->anggota,
        ]);
    }


    /**
     * ===========================================================
     *  API 2 → SUBMIT PENGADUAN RUMAH
     * ===========================================================
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'      => 'required|string',
            'kk'       => 'required|string',
            'alamat'   => 'required|string',
            'rt'       => 'nullable|string',
            'rw'       => 'nullable|string',
            'keterangan'       => 'required|string',


            'foto.*'      => 'required|image|max:5120',
            'deskripsi.*' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari rumah berdasarkan KK (jika ada)
        $kkData = KepalaKeluarga::with('rumah')
                ->where('no_kk', $request->kk)
                ->first();

        $rumahId = $kkData->rumah->id_rumah ?? null;

        // =======================================
        // SIMPAN DATA PENGADUAN
        // =======================================
        $pengaduan = PengaduanRumah::create([
            'rumah_id' => $rumahId,
            'nik'      => $request->nik,
            'kk'       => $request->kk,
            'alamat'   => $request->alamat,
            'rt'       => $request->rt,
            'rw'       => $request->rw,
            'keterangan' => $request->keterangan
        ]);

        // =======================================
        // SIMPAN FOTO-FOTO MULTIPLE
        // =======================================
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {

                $path = $file->store('pengaduan_rumah', 'public');

                PengaduanFoto::create([
                    'pengaduan_id' => $pengaduan->id,
                    'file_path' => $path,
                    'deskripsi' => $request->deskripsi[$index] ?? null,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Pengaduan berhasil disimpan',
            'pengaduan_id' => $pengaduan->id
        ]);
    }
}
