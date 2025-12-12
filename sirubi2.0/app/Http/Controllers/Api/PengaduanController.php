<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\KepalaKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\IKecamatan;
use App\Models\IKelurahan;
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

    public function getKecamatan()
    {
        $data = IKecamatan::orderBy('nama_kecamatan')->get([
            'id_kecamatan',
            'nama_kecamatan'
        ]);

        return response()->json([
            'status' => true,
            'kecamatan' => $data
        ]);
    }


    /**
     * ===========================================================
     *  API GET KELURAHAN BERDASARKAN KECAMATAN
     *  GET /api/kecamatan/{id}/kelurahan
     * ===========================================================
     */
    public function getKelurahan($id)
    {
        $kelurahan = IKelurahan::where('kecamatan_id', $id)
            ->orderBy('nama_kelurahan')
            ->get([
                'id_kelurahan',
                'nama_kelurahan'
            ]);

        return response()->json([
            'status' => true,
            'kecamatan_id' => $id,
            'kelurahan' => $kelurahan
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

            // rumah_id opsional → kalau ada berarti user terdata
            'rumah_id' => 'nullable|integer|exists:rumah,id_rumah',

            // alamat wajib hanya jika rumah_id kosong
            'alamat'       => 'required_if:rumah_id,null|string',
            'rt'           => 'required_if:rumah_id,null|string',
            'rw'           => 'required_if:rumah_id,null|string',
            'kecamatan_id' => 'required_if:rumah_id,null|integer',
            'kelurahan_id' => 'required_if:rumah_id,null|integer',

            'keterangan'   => 'required|string',

            'foto.*'      => 'required|image|max:5120',
            'deskripsi.*' => 'nullable|string',
        ], [
            // Custom error biar lebih ramah user
            'alamat.required_if' => 'Alamat wajib diisi jika rumah tidak ditemukan.',
            'rt.required_if' => 'RT wajib diisi jika rumah tidak ditemukan.',
            'rw.required_if' => 'RW wajib diisi jika rumah tidak ditemukan.',
            'kecamatan_id.required_if' => 'Kecamatan wajib diisi jika rumah tidak ditemukan.',
            'kelurahan_id.required_if' => 'Kelurahan wajib diisi jika rumah tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // ======================================================
        // SIMPAN DATA PENGADUAN
        // ======================================================

        $pengaduan = PengaduanRumah::create([
            'rumah_id'     => $request->rumah_id,   // langsung dari parameter
            'nik'          => $request->nik,
            'kk'           => $request->kk,

            // Jika rumah_id ada → alamat boleh null
            'alamat'       => $request->alamat,
            'rt'           => $request->rt,
            'rw'           => $request->rw,

            'kecamatan_id' => $request->kecamatan_id,
            'kelurahan_id' => $request->kelurahan_id,

            'keterangan'   => $request->keterangan
        ]);

        // ======================================================
        // SIMPAN FOTO-FOTO MULTIPLE
        // ======================================================

        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {

                $path = $file->store('pengaduan_rumah', 'public');

                PengaduanFoto::create([
                    'pengaduan_id' => $pengaduan->id,
                    'file_path'    => $path,
                    'deskripsi'    => $request->deskripsi[$index] ?? null,
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
