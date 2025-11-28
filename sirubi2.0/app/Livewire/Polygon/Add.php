<?php

namespace App\Livewire\Polygon;

use App\Models\TblJenisPolygon;
use App\Models\TblPolygon;
use Livewire\Component;

class Add extends Component
{

    public $mode, $edit_id;
    public $nama_kawasan;
    public $jenis_id;
    public $luas;
    public $keterangan;
    public $polygon; // geojson

    #[On('setPolygonFromShp')]
    public function setPolygonFromShp($data)
    {
        $this->polygon = $data['polygon'];
    }


    public function save()
    {
        try {
            $this->validate([
                'nama_kawasan' => 'required|string|max:255',
                'jenis_id'     => 'required',
                'luas'         => 'required',
                'polygon'      => 'required', // wajib polygon
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Ambil pesan error pertama
            $message = collect($e->errors())->first()[0] ?? "Harap lengkapi semua field wajib.";

            // Tampilkan SweetAlert
            $this->dispatch('errorAlert', [
                'type'    => 'error',
                'message' => $message
            ]);

            return;
        }

        TblPolygon::create([
            'nama_kawasan' => $this->nama_kawasan,
            'jenis_id'     => $this->jenis_id,
            'luas'         => $this->luas,
            'keterangan'   => $this->keterangan,
            'polygon'      => $this->polygon,
            'create_at'    => now(),
        ]);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Data Polygon berhasil disimpan!'
        ]);

       // return redirect()->route('polygon.index'); // halaman list polygon
    }

    public function mount($id = null)
    {
        $this->mode = 'create';
        if ($id) {
            $this->mode = 'edit';
            $this->edit_id = $id;

            $data = TblPolygon::find($id);

            $this->nama_kawasan = $data->nama_kawasan;
            $this->jenis_id     = $data->jenis_id;
            $this->luas         = $data->luas;
            $this->keterangan   = $data->keterangan;
            $this->polygon      = $data->polygon;

            // kirim polygon ke javascript
            $this->dispatch('loadPolygonOnMap', polygon: $data->polygon);
        }
    }

    public function update()
    {
        $this->validate([
            'nama_kawasan' => 'required',
            'jenis_id' => 'required',
            'luas' => 'required|numeric',
            'polygon' => 'required',
        ]);

        TblPolygon::where('id_polygon', $this->edit_id)
            ->update([
                'nama_kawasan' => $this->nama_kawasan,
                'jenis_id'     => $this->jenis_id,
                'luas'         => $this->luas,
                'keterangan'   => $this->keterangan,
                'polygon'      => $this->polygon,
                'update_at'    => now(),
            ]);

        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Polygon berhasil diupdate!'
        ]);
    }


    
    public function render()
    {
        return view('livewire.polygon.add', [
            'jenisPolygon' => TblJenisPolygon::all()
        ])
          ->extends('layouts.master')
            ->section('content');

    }
}
