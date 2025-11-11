<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Filter Data</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Rumah</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Careers - List-->
                <form  novalidate="novalidate" >
                <div class="card">
                    <!--begin::Body-->
                    
                    <div class="card-body p-lg-17">
                        
                        <div class="accordion" id="accordionFilter" wire:ignore>
                            {{-- ======================= DATA UMUM ======================= --}}
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingUmum">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseUmum">
                                        DATA UMUM RUMAH
                                    </button>
                                </h2>
                                <div id="collapseUmum" class="accordion-collapse collapse show" data-bs-parent="#accordionFilter">
                                    <div class="accordion-body">
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kecamatan</label>
                                                <select class="form-select " multiple  data-control="select2"
                                                        data-placeholder="Pilih Kecamatan"
                                                        id="kecamatan_id"
                                                        data-name="kecamatan_id">
                                                    <option value="">Pilih Kecamatan</option>
                                                    @foreach($iKecamatan as $item)
                                                        <option value="{{ $item->id_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore >
                                                <label class=" fs-5 fw-semibold mb-2">Kelurahan</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kelurahan"
                                                        id="kelurahan_id"
                                                        data-name="kelurahan_id">
                                                    <option value="">Pilih Kelurahan</option>
                                                    {{-- @foreach($filteredKelurahan as $item)
                                                        <option value="{{ $item->id_kelurahan }}">{{ $item->nama_kelurahan }}</option>
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class="form-label fw-semibold">Jumlah KK dalam rumah ini</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Jumlah KK"
                                                        id="jumlah_kk_id"
                                                        data-name="jumlah_kk_id" style="border-color: rgb(54 54 96);">
                                                    <option value="">Pilih Jumlah KK</option>
                                                    @foreach($iJumlahKK as $item)
                                                        <option value="{{ $item->id_jumlah_kk }}">{{ $item->jumlah_kk }}</option>
                                                    @endforeach
                                                </select>

                                               
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Status Kepemilikan Tanah</label>
                                                <select class="form-select " multiple data-control="select2"
                                                        data-placeholder="Pilih Status"
                                                        id="status_kepemilikan_tanah_id"
                                                        data-name="status_kepemilikan_tanah_id" >
                                                    <option value="">-- Pilih Status --</option>
                                                    @foreach($iStatusKepemilikanTanah as $item)
                                                        <option value="{{ $item->id_status_kepemilikan_tanah }}">{{ $item->status_kepemilikan_tanah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Bukti Kepemilikan Tanah</label>
                                                <select class="form-select " multiple data-control="select2"
                                                        data-placeholder="Pilih Bukti"
                                                        id="bukti_kepemilikan_tanah_id"
                                                        data-name="bukti_kepemilikan_tanah_id" >
                                                    <option value="">-- Pilih Bukti --</option>
                                                    @foreach($iBuktiKepemilikanTanah as $item)
                                                        <option value="{{ $item->id_bukti_kepemilikan_tanah }}">{{ $item->bukti_kepemilikan_tanah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Status Kepemilikan Rumah</label>
                                                <select class="form-select " multiple data-control="select2"
                                                        data-placeholder="Pilih Status"
                                                        id="status_kepemilikan_rumah_id"
                                                        data-name="status_kepemilikan_rumah_id" >
                                                    <option value="">-- Pilih Status --</option>
                                                    @foreach($iStatusKepemilikanRumah as $item)
                                                        <option value="{{ $item->id_status_kepemilikan_rumah }}">{{ $item->status_kepemilikan_rumah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-5">
                                            <div class="col-md-4 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Aset Rumah Ditempat Lain</label>
                                                <select class="form-select " multiple data-control="select2"
                                                        data-placeholder="Pilih"
                                                        id="aset_rumah_ditempat_lain_id"
                                                        data-name="aset_rumah_ditempat_lain_id" >
                                                            <option value="">-- Pilih Status --</option>
                                                    @foreach($iAsetRumahTempatLain as $item)
                                                        <option value="{{ $item->id_aset_rumah_tempat_lain }}">{{ $item->aset_rumah_tempat_lain }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Aset Tanah Ditempat Lain</label>
                                                <select class="form-select " multiple  data-control="select2"
                                                        data-placeholder="Pilih"
                                                        id="aset_tanah_ditempat_lain_id"
                                                        data-name="aset_tanah_ditempat_lain_id" >
                                                            <option value="">-- Pilih Status --</option>
                                                    @foreach($iAsetTanahTempatLain as $item)
                                                        <option value="{{ $item->id_aset_tanah_tempat_lain }}">{{ $item->aset_tanah_tempat_lain }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Status IMB</label>
                                                <select class="form-select " multiple  data-control="select2"
                                                        data-placeholder="Pilih Status"
                                                        id="status_imb_id"
                                                        data-name="status_imb_id" >
                                                    <option value="">-- Pilih Status --</option>
                                                    @foreach($iStatusImb as $item)
                                                        <option value="{{ $item->id_status_imb }}">{{ $item->status_imb }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                         <div class="row mb-5">
                                            

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Pernah Mendapatkan Bantuan Perbaikan Rumah</label>
                                                <select class="form-select " multiple  data-control="select2"
                                                        data-placeholder="Pilih"
                                                        id="pernah_mendapatkan_bantuan_id"
                                                        data-name="pernah_mendapatkan_bantuan_id" >
                                                        <option value="">-- Pilih Status --</option>
                                                    @foreach($iPernahMendapatkanBantuan as $item)
                                                        <option value="{{ $item->id_pernah_mendapatkan_bantuan }}">{{ $item->pernah_mendapatkan_bantuan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Jenis Kawasan Lokasi Rumah Yang Ditempati</label>
                                                <select class="form-select " multiple  data-control="select2"
                                                        data-placeholder="Pilih Jenis"
                                                        id="jenis_kawasan_lokasi_rumah_id"
                                                        data-name="jenis_kawasan_lokasi_rumah_id"  >
                                                        <option value="">-- Pilih Status --</option>
                                                    @foreach($iJenisKawasanLokasi as $item)
                                                        <option value="{{ $item->id_jenis_kawasan_lokasi }}">{{ $item->jenis_kawasan_lokasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="accordionKeselamatan" wire:ignore>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingUmum">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseKsl">
                                        ASPEK KESELAMATAN
                                    </button>
                                </h2>
                                <div id="collapseKsl" class="accordion-collapse collapse " data-bs-parent="#accordionKeselamatan">
                                    <div class="accordion-body">
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Pondasi</label>
                                                <select class="form-select" multiple 
                                                        data-control="select2"
                                                        data-placeholder="Pilih Pondasi"
                                                        data-name="pondasi_id"
                                                        id="pondasi_id"
                                                        >
                                                    <option value="">-- Pilih Pondasi --</option>
                                                    @foreach($aPondasi ?? [] as $item)
                                                        <option value="{{ $item->id_pondasi }}">{{ $item->pondasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Jenis Pondasi</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Jenis Pondasi"
                                                        data-name="jenis_pondasi_id"
                                                        id="jenis_pondasi_id"
                                                        >
                                                    <option value="">-- Pilih Jenis Pondasi --</option>
                                                    @foreach($aJenisPondasi ?? [] as $item)
                                                        <option value="{{ $item->id_jenis_pondasi }}">{{ $item->nama_jenis_pondasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 2: Kondisi Pondasi & Kondisi Sloof --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Pondasi</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kondisi Pondasi"
                                                        data-name="kondisi_pondasi_id"
                                                        id="kondisi_pondasi_id"
                                                        >
                                                    <option value="">-- Pilih Kondisi Pondasi --</option>
                                                    @foreach($aKondisiPondasi ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_pondasi }}">{{ $item->kondisi_pondasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Sloof</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kondisi Sloof"
                                                        data-name="kondisi_sloof_id"
                                                        id="kondisi_sloof_id"
                                                        >
                                                    <option value="">-- Pilih Kondisi Sloof --</option>
                                                    @foreach($aKondisiSloof ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_sloof }}">{{ $item->kondisi_sloof }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 3: Kondisi Kolom/Tiang & Kondisi Balok --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Kolom / Tiang</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kondisi Kolom / Tiang"
                                                        data-name="kondisi_kolom_tiang_id"
                                                        id="kondisi_kolom_tiang_id"
                                                        >
                                                    <option value="">-- Pilih Kondisi Kolom / Tiang --</option>
                                                    @foreach($aKondisiKolomTiang ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_kolom_tiang }}">{{ $item->kondisi_kolom_tiang }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Balok</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kondisi Balok"
                                                        data-name="kondisi_balok_id"
                                                        id="kondisi_balok_id"
                                                        >
                                                    <option value="">-- Pilih Kondisi Balok --</option>
                                                    @foreach($aKondisiBalok ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_balok }}">{{ $item->kondisi_balok }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 4: Kondisi Struktur Atap --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Struktur Atap</label>
                                                <select class="form-select" multiple
                                                        data-control="select2"
                                                        data-placeholder="Pilih Kondisi Struktur Atap"
                                                        data-name="kondisi_struktur_atap_id"
                                                        id="kondisi_struktur_atap_id"
                                                        >
                                                    <option value="">-- Pilih Kondisi Struktur Atap --</option>
                                                    @foreach($aKondisiStrukturAtap ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_struktur_atap }}">{{ $item->kondisi_struktur_atap }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>


                         <div class="accordion" id="accordionKesehatan" wire:ignore>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingUmum">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseKsh">
                                        ASPEK KESEHATAN
                                    </button>
                                </h2>
                                <div id="collapseKsh" class="accordion-collapse collapse " data-bs-parent="#accordionKesehatan">
                                    <div class="accordion-body">
                                        {{-- ✅ Baris 1: Jendela & Kondisi --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Jendela / Lubang Cahaya</label>
                                                <select class="form-select" multiple data-control="select2" data-name="jendela_lubang_cahaya_id"
                                                        data-placeholder="Pilih Jendela / Lubang Cahaya" id="jendela_lubang_cahaya_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bJendelaLubangCahaya ?? [] as $item)
                                                        <option value="{{ $item->id_jendela_lubang_cahaya }}">{{ $item->jendela_lubang_cahaya }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Jendela / Lubang Cahaya</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_jendela_lubang_cahaya_id"
                                                        data-placeholder="Pilih Kondisi" id="kondisi_jendela_lubang_cahaya_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiJendelaLubangCahaya ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_jendela_lubang_cahaya }}">{{ $item->kondisi_jendela_lubang_cahaya }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 2: Ventilasi + Keterangan --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Ventilasi</label>
                                                <select class="form-select" multiple data-control="select2" data-name="ventilasi_id"
                                                        data-placeholder="Pilih Ventilasi" id="ventilasi_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bVentilasi ?? []  as $item)
                                                        <option value="{{ $item->id_ventilasi }}">{{ $item->ventilasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                             <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Ventilasi</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_ventilasi_id"
                                                        data-placeholder="Pilih Kondisi Ventilasi" id="kondisi_ventilasi_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiVentilasi ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_ventilasi }}">{{ $item->kondisi_ventilasi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 3: Kondisi Ventilasi + Kamar Mandi --}}
                                        <div class="row mb-5">
                                          

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kamar Mandi</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kamar_mandi_id"
                                                        data-placeholder="Pilih Kamar Mandi" id="kamar_mandi_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKamarMandi ?? []  as $item)
                                                        <option value="{{ $item->id_kamar_mandi }}">{{ $item->kamar_mandi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Kamar Mandi</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_kamar_mandi_id"
                                                        data-placeholder="Pilih Kondisi Kamar Mandi" id="kondisi_kamar_mandi_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiKamarMandi ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_kamar_mandi }}">{{ $item->kondisi_kamar_mandi }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 4: Kondisi Kamar Mandi + Jamban --}}
                                        <div class="row mb-5">
                                            

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Jamban</label>
                                                <select class="form-select" multiple data-control="select2" data-name="jamban_id"
                                                        data-placeholder="Pilih Jamban" id="jamban_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bJamban ?? []  as $item)
                                                        <option value="{{ $item->id_jamban }}">{{ $item->jamban }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Jamban</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_jamban_id"
                                                        data-placeholder="Pilih Kondisi Jamban" id="kondisi_jamban_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiJamban  ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_jamban }}">{{ $item->kondisi_jamban }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 5: Kondisi Jamban + Pembuangan Air Kotor --}}
                                        <div class="row mb-5">
                                            

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Sistem Pembuangan Air Kotor</label>
                                                <select class="form-select" multiple data-control="select2" data-name="sistem_pembuangan_air_kotor_id"
                                                        data-placeholder="Pilih Sistem" id="sistem_pembuangan_air_kotor_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bSistemPembuanganAirKotor ?? []  as $item)
                                                        <option value="{{ $item->id_sistem_pembuangan_air_kotor }}">{{ $item->sistem_pembuangan_air_kotor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Sistem Pembuangan Air Kotor</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_sistem_pembuangan_air_kotor_id"
                                                        data-placeholder="Pilih Kondisi Sistem" id="kondisi_sistem_pembuangan_air_kotor_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiSistemPembuanganAirKotor ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_sistem_pembuangan_air_kotor }}">{{ $item->kondisi_sistem_pembuangan_air_kotor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 6: Kondisi Pembuangan + Frekuensi Penyedotan --}}
                                        <div class="row mb-5">
                                            

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Frekuensi Penyedotan (5 Tahun)</label>
                                                <select class="form-select" multiple data-control="select2" data-name="frekuensi_penyedotan_id"
                                                        data-placeholder="Pilih Frekuensi" id="frekuensi_penyedotan_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bFrekuensiPenyedotan ?? []  as $item)
                                                        <option value="{{ $item->id_frekuensi_penyedotan }}">{{ $item->frekuensi_penyedotan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Sumber Listrik</label>
                                                <select class="form-select" multiple data-control="select2" data-name="sumber_listrik_id"
                                                        data-placeholder="Pilih Sumber Listrik" id="sumber_listrik_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bSumberListrik  ?? [] as $item)
                                                        <option value="{{ $item->id_sumber_listrik }}">{{ $item->sumber_listrik }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 7: Sumber Air Minum + Kondisi --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Sumber Air Minum</label>
                                                <select class="form-select" multiple data-control="select2" data-name="sumber_air_minum_id"
                                                        data-placeholder="Pilih Sumber Air Minum" id="sumber_air_minum_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bSumberAirMinum ?? []  as $item)
                                                        <option value="{{ $item->id_sumber_air_minum }}">{{ $item->sumber_air_minum }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Sumber Air Minum</label>
                                                <select class="form-select" multiple data-control="select2" data-name="kondisi_sumber_air_minum_id"
                                                        data-placeholder="Pilih Kondisi" id="kondisi_sumber_air_minum_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($bKondisiSumberAirMinum ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_sumber_air_minum }}">{{ $item->kondisi_sumber_air_minum }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                       


                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        <div class="accordion" id="accordionRuang" wire:ignore>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingUmum">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseRng">
                                        ASPEK PERSYARATAN LUAS & KEBUTUHAN RUANG
                                    </button>
                                </h2>
                                <div id="collapseRng" class="accordion-collapse collapse " data-bs-parent="#accordionRuang">
                                    <div class="accordion-body">
                                        <div class="row mb-5">
                                           

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Ruang Keluarga & Ruang Tidur</label>
                                                <select class="form-select" multiple data-control="select2" data-placeholder="Pilih Opsi"
                                                        data-name="ruang_keluarga_dan_tidur_id" id="ruang_keluarga_dan_tidur_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($cRuangKeluargaDanTidur ?? []  as $item)
                                                        <option value="{{ $item->id_ruang_keluarga_dan_tidur }}">{{ $item->ruang_keluarga_dan_tidur }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Jenis Fisik Bangunan</label>
                                                <select class="form-select" multiple data-control="select2" data-name="jenis_fisik_bangunan_id"
                                                        data-placeholder="Pilih Jenis Fisik Bangunan" id="jenis_fisik_bangunan_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($cJenisFisikBangunan  ?? [] as $item)
                                                        <option value="{{ $item->id_jenis_fisik_bangunan }}">{{ $item->jenis_fisik_bangunan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 6: Fungsi Rumah & Tipe Rumah --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Fungsi Rumah</label>
                                                <select class="form-select" multiple data-control="select2" data-name="fungsi_rumah_id"
                                                        data-placeholder="Pilih Fungsi Rumah" id="fungsi_rumah_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($cFungsiRumah  ?? [] as $item)
                                                        <option value="{{ $item->id_fungsi_rumah }}">{{ $item->fungsi_rumah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Tipe Rumah</label>
                                                <select class="form-select" multiple data-control="select2" data-name="tipe_rumah_id"
                                                        data-placeholder="Pilih Tipe Rumah" id="tipe_rumah_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($cTipeRumah  ?? [] as $item)
                                                        <option value="{{ $item->id_tipe_rumah }}">{{ $item->tipe_rumah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 7: Status DTKS & Tahun Pembangunan --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Status DTKS (Data Terpadu Kesejahteraan Sosial)</label>
                                                <select class="form-select" multiple data-control="select2" data-name="status_dtks_id"
                                                        data-placeholder="Pilih Status DTKS" id="status_dtks_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($cStatusDtks ?? []  as $item)
                                                        <option value="{{ $item->id_status_dtks }}">{{ $item->status_dtks }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                          
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion" id="accordionBahan" wire:ignore>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingUmum">
                                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseBhn">
                                        ASPEK KOMPONEN BAHAN BANGUNAN
                                    </button>
                                </h2>
                                <div id="collapseBhn" class="accordion-collapse collapse " data-bs-parent="#accordionBahan">
                                    <div class="accordion-body">
                                        {{-- ✅ Baris 1: Material Atap & Kondisi Penutup --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Material Atap Terluas</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="material_atap_terluas_id"
                                                        data-placeholder="Pilih Material Atap Terluas"
                                                        id="material_atap_terluas_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dMaterialAtapTerluas ?? []  as $item)
                                                        <option value="{{ $item->id_material_atap_terluas }}">{{ $item->material_atap_terluas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Penutup Atap</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="kondisi_penutup_atap_id"
                                                        data-placeholder="Pilih Kondisi Penutup Atap"
                                                        id="kondisi_penutup_atap_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dKondisiPenutupAtap  ?? [] as $item)
                                                        <option value="{{ $item->id_kondisi_penutup_atap }}">{{ $item->kondisi_penutup_atap }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 2: Material Dinding & Kondisi Dinding --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Material Dinding Terluas</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="material_dinding_terluas_id"
                                                        data-placeholder="Pilih Material Dinding Terluas"
                                                        id="material_dinding_terluas_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dMaterialDindingTerluas ?? []  as $item)
                                                        <option value="{{ $item->id_material_dinding_terluas }}">{{ $item->material_dinding_terluas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Dinding</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="kondisi_dinding_id"
                                                        data-placeholder="Pilih Kondisi Dinding"
                                                        id="kondisi_dinding_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dKondisiDinding ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_dinding }}">{{ $item->kondisi_dinding }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 3: Material Lantai & Kondisi Lantai --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Material Lantai Terluas</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="material_lantai_terluas_id"
                                                        data-placeholder="Pilih Material Lantai Terluas"
                                                        id="material_lantai_terluas_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dMaterialLantaiTerluas ?? []  as $item)
                                                        <option value="{{ $item->id_material_lantai_terluas }}">{{ $item->material_lantai_terluas }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Kondisi Lantai</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="kondisi_lantai_id"
                                                        data-placeholder="Pilih Kondisi Lantai"
                                                        id="kondisi_lantai_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dKondisiLantai ?? []  as $item)
                                                        <option value="{{ $item->id_kondisi_lantai }}">{{ $item->kondisi_lantai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 4: Akses Jalan & Menghadap Jalan --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Akses Langsung ke Jalan</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="akses_ke_jalan_id"
                                                        data-placeholder="Pilih Akses Jalan"
                                                        id="akses_ke_jalan_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dAksesKeJalan ?? []  as $item)
                                                        <option value="{{ $item->id_akses_ke_jalan }}">{{ $item->akses_ke_jalan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Bangunan Menghadap Jalan</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="bangunan_menghadap_jalan_id"
                                                        data-placeholder="Pilih Opsi"
                                                        id="bangunan_menghadap_jalan_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dBangunanMenghadapJalan ?? []  as $item)
                                                        <option value="{{ $item->id_bangunan_menghadap_jalan }}">{{ $item->bangunan_menghadap_jalan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 5: Menghadap Sungai & Limbah --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Bangunan Menghadap Sungai</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="bangunan_menghadap_sungai_id"
                                                        data-placeholder="Pilih Opsi"
                                                        id="bangunan_menghadap_sungai_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dBangunanMenghadapSungai ?? []  as $item)
                                                        <option value="{{ $item->id_bangunan_menghadap_sungai }}">{{ $item->bangunan_menghadap_sungai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Bangunan Berada di Buangan Limbah Pabrik / Sutet</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="bangunan_berada_limbah_id"
                                                        data-placeholder="Pilih Opsi"
                                                        id="bangunan_berada_limbah_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dBangunanBeradaLimbah ?? []  as $item)
                                                        <option value="{{ $item->id_bangunan_berada_limbah }}">{{ $item->bangunan_berada_limbah }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- ✅ Baris 6: Bangunan di Atas Sempadan --}}
                                        <div class="row mb-5">
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Bangunan Berada di Atas Sempadan Sungai / Laut / Rawa</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="bangunan_berada_sungai_id"
                                                        data-placeholder="Pilih Opsi"
                                                        id="bangunan_berada_sungai_id" >
                                                    <option value="">-- Pilih --</option>
                                                    @foreach($dBangunanBeradaSungai ?? []  as $item)
                                                        <option value="{{ $item->id_bangunan_berada_sungai }}">{{ $item->bangunan_berada_sungai }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6 fv-row" wire:ignore>
                                                <label class=" fs-5 fw-semibold mb-2">Prioritas</label>
                                                <select class="form-select" multiple data-control="select2"
                                                        data-name="prioritas"
                                                        data-placeholder="Pilih Prioritas"
                                                        id="prioritas" >
                                                    <option value="">-- Pilih --</option>
                                                        <option value="1">Aspek Keselamatan</option>
                                                        <option value="2">Aspek Kesehatan</option>
                                                        <option value="3">Aspek Komponen Bahan Bangunan</option>
                                                </select>
                                            </div>
                                        </div>
                                         {{-- <div class="row mt-5">
                                            <div class="col-md-12 fv-row">
                                                <label class=" form-label fw-semibold">Limit Hasil Data</label>
                                                <input type="number" id="limit_data" wire:model="limit_data" class="form-control form-control-solid"
                                                    style="border-color: rgb(54 54 96);">
                                            </div>
                                         </div> --}}


                                    </div>
                                </div>
                            </div>
                        </div>

                           
                       {{-- <button type="button"
                    id="kt_modal_new_card_submit"
                    class="btn btn-primary"
                    wire:click="submitForm"
                    wire:loading.attr="disabled"
                    wire:target="submitForm">
                    
                    <span class="indicator-label" wire:loading.remove wire:target="submitForm">
                        Submit
                    </span>

                    <span class="indicator-progress" wire:loading wire:target="submitForm">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button> --}}

                <div class="pt-15 text-end" wire:ignore> <button type="button" id="kt_modal_new_card_submit" class="btn btn-primary" wire:click="submitForm" wire:loading.attr="disabled"> <!-- Saat belum loading --> <span class="indicator-label" wire:loading.remove> Submit </span> <!-- Saat loading --> <span class="indicator-progress" wire:loading> Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span> </button> </div>


                    </div>

                   
                    <!--end::Body-->
                </div>
                 </form>

                <div class="card mt-10"  id="tableContainer">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                            height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                            fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" id="searchRumah"
                                    class="form-control form-control-solid w-250px ps-15"
                                    placeholder="Cari rumah..." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <div class="card-toolbar" data-select2-id="select2-data-132-9owp">

                             <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
                                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Export</button>

                        </div>
                        <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true" style="display: none;"  wire:ignore.self>
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px" data-select2-id="select2-data-131-um5u">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Export Data</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            <!--begin::Form-->
                                            <form id="kt_modal_export_users_form" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                                                <div class="fv-row mb-10" wire:ignore>
                                                    <label class="required fs-6 fw-semibold form-label mb-2">Pilih Format Export</label>
                                                    <select name="format"
                                                            data-control="select2"
                                                            data-placeholder="Select a format"
                                                            data-hide-search="true"
                                                            class="form-select form-select-solid fw-bold"
                                                            id="format"
                                                            style="border-color: rgb(54 54 96);">
                                                        <option></option>
                                                        <option value="excel">Excel (.xls)</option>
                                                        <option value="geojson">Geojson (.geojson)</option>
                                                    </select>
                                                </div>

                                                <div class="text-center">
                                                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="button" id="btnExport" class="btn btn-primary">
                                                        <span class="indicator-label">Export</span>
                                                        <span class="indicator-progress" style="display:none;">
                                                            Mohon Tunggu... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </form>

                                            <!--end::Form-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                    </div>
                    <div class="card-body pt-0" >
                        <!--begin::Table-->
                        <div wire:ignore>
                        <table id="rumahTable" class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th width="10"></th>
                                    <th width="10">#</th>
                                    <th class="min-w-150px">Nama Pemilik</th>
                                    <th class="min-w-150px">Alamat</th>
                                    <th class="min-w-125px">Kecamatan</th>
                                    <th class="min-w-125px">Kelurahan</th>
                                    <th class="min-w-125px">Status Rumah</th>
                                    <th class="min-w-125px">Status Backlog</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                        <!--end::Table-->
                    </div>
                </div>
                <!--end::Careers - List-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
</div>
@push('js')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
	<script src="{{ ('assets/js/custom/widgets.js')}} "></script>


<script>
document.addEventListener('livewire:navigated', () => {
    console.log('✅ Export JS Loaded');

    const btnExport = document.getElementById('btnExport');

    btnExport.addEventListener('click', function (e) {
        e.preventDefault(); // ⛔️ cegah reload form

        // ambil format dari select2
        const format = $('#format').val();
        if (!format) {
            Swal.fire({
                icon: 'warning',
                title: 'Pilih format export!',
                text: 'Silakan pilih format file yang ingin diekspor.',
            });
            return;
        }

        // ambil semua filter aktif (select2 lain di halaman)
        const filters = {};
        $('[data-control="select2"]').each(function () {
            const name = $(this).attr('name');
            const val = $(this).val();
            if (name && val && val.length > 0) {
                filters[name] = Array.isArray(val) ? val : [val];
            }
        });

        console.log('📤 Mengirim filter ke Livewire:', filters);

        // tampilkan spinner loading di tombol export
        const label = btnExport.querySelector('.indicator-label');
        const spinner = btnExport.querySelector('.indicator-progress');
        label.style.display = 'none';
        spinner.style.display = 'inline-flex';

        // kirim event ke komponen Livewire Filter
      Livewire.dispatch('handleExportFromFilter', [{
        format: format,
        filters: filters
    }]);

        // tutup modal otomatis
        // const modalEl = document.getElementById('kt_modal_export_users');
        // const modal = bootstrap.Modal.getInstance(modalEl);
        // modal.hide();

        // kembalikan tombol ke normal setelah beberapa detik
        setTimeout(() => {
            label.style.display = 'inline-flex';
            spinner.style.display = 'none';
        }, 30000);
    });
});
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('swal:error', function (event) {
        //console.log(event)
        Swal.fire({
            icon: 'warning',
            title: event.detail[0].title,
            text: event.detail[0].text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });
    });

    Livewire.on('swal:success', data => {
        Swal.fire({
            icon: 'success',
            title: data[0].title,
            text: data[0].text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
         $('#tableContainer').css('display', 'block');
         $('#tableContainer').show();
    });

    Livewire.on('collectSelect2Values', () => {
    const data = {};

    $('[data-control="select2"]').each(function() {
        const name = $(this).data('name');
        const value = $(this).val();
        data[name] = value;
    });

    //console.log('📦 Kirim semua value ke Livewire:', data);

    // kirim balik ke Livewire sekali saja
    Livewire.dispatch('applySelect2Filters', [data]);

    




});

});
</script>
<script>
document.addEventListener('livewire:navigated', () => {
    console.log('✅ GeoJSON listener aktif');

    // Saat event dari Livewire dipancarkan
    Livewire.on('geojson-ready', ({ url }) => {
        if (!url) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'File  tidak ditemukan.',
            });
            return;
        }

        console.log('📦 File siap diunduh:', url);

        // Buat link download otomatis
        const a = document.createElement('a');
        a.href = url;
        a.download = url.split('/').pop();
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        Swal.fire({
            icon: 'success',
            title: 'Export Berhasil!',
            text: 'File  sedang diunduh.',
            timer: 2500,
        });
    });
});
</script>


<script>
document.addEventListener('livewire:navigated', function () {
    let rumahTable; // simpan instance global
    $('#tableContainer').hide();
    // 🔹 Inisialisasi DataTable sekali saja
    if (!$.fn.DataTable.isDataTable('#rumahTable')) {
        rumahTable = $('#rumahTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('livewire.datatables.rumah') }}",
                  data: function (d) {
                        const filters = window.__rumahFilters || {};

                        Object.entries(filters).forEach(([key, value]) => {
                            // ⚙️ 1. Skip semua null, undefined, atau array kosong
                            if (
                                value === null ||
                                value === undefined ||
                                (Array.isArray(value) && value.length === 0)
                            ) {
                                return;
                            }

                            // ⚙️ 2. Kalau array isi, kirim sebagai key[]
                            if (Array.isArray(value)) {
                                value.forEach(v => d[`${key}[]`] = v);
                            } else {
                                // ⚙️ 3. Kalau string / number, kirim biasa
                                d[key] = value;
                            }
                        });

                        //console.log("📤 Payload ke server:", d);
                        return d;
                    }
                
            },
            columns: [
                { data: 'expand', orderable: false, searchable: false },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama_pemilik' },
                { data: 'alamat' },
                { data: 'kecamatan' },
                { data: 'kelurahan' },
                { data: 'status_rumah' },
                { data: 'status_backlog' },
                { data: 'action', orderable: false, searchable: false }
            ]
        });

        // ✅ Jalankan setiap tabel selesai render ulang
	rumahTable.on('draw', function () {
		if (typeof KTMenu !== 'undefined') {
			KTMenu.createInstances();
		}
	});

	// ✅ Jalankan juga pertama kali load
	if (typeof KTMenu !== 'undefined') {
		KTMenu.createInstances();
	}


    } else {
        rumahTable = $('#rumahTable').DataTable();
    }

    // 🔹 Jalankan reload hanya saat tombol Submit ditekan (event Livewire)
    Livewire.on('refreshDataTable', (filters) => {
       // console.log("✅ Event refreshDataTable diterima", filters[0]);
         window.__rumahFilters = JSON.parse(JSON.stringify(filters[0] || {}));
        
        rumahTable.ajax.reload();
    });

    // ✅ Search real-time
    $('#searchRumah').on('keyup', function () {
        rumahTable.search(this.value).draw();
    });

    // ✅ Expand / Collapse detail row
    $('#rumahTable').on('click', '.toggle-detail', function () {
        const tr = $(this).closest('tr');
        const row = rumahTable.row(tr);
        const id = $(this).data('id');
        const icon = $(this).find('i');

        if (row.child.isShown()) {
            row.child.hide();
            icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            icon.removeClass('fa-plus').addClass('fa-spinner fa-spin');

            const url = "{{ route('datatable.rumah.detail', ['id' => ':id']) }}".replace(':id', id);
            $.get(url, function (html) {
                row.child(html).show();
                icon.removeClass('fa-spinner fa-spin').addClass('fa-minus');

                // re-init accordion Metronic jika ada
                if (typeof KTAccordion !== 'undefined') {
                    KTAccordion.createInstances();
                }
            }).fail(() => {
                icon.removeClass('fa-spinner fa-spin').addClass('fa-plus');
                alert('⚠️ Gagal memuat detail rumah.');
            });
        }
    });

     window.confirmDelete = function(id) {
        event.preventDefault(); // 🧩 Hindari reload form/link

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: 'Data akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // 🔥 Dispatch event ke Livewire TANPA render ulang tabel
                //console.log('🔥 Dispatch deleteRumah untuk ID:', id);
           Livewire.dispatch('deleteRumah', [{ id: id }]);

        }
        });
    };

    // ✅ Tangkap event dari Livewire
    Livewire.on('rumahDeleted', (data) => {
        if (rumahTable) {
            rumahTable.ajax.reload(null, false);
        }

        Swal.fire({
            toast: true,
            icon: 'success',
            title: 'Data berhasil dihapus!',
            text: 'Data berhasil dihapus!',
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
        
        
        });
    });



});
</script>

<script>

document.addEventListener('livewire:navigated', () => {
    // 🔹 Pastikan stepper hanya diinisialisasi sekali
    if (window.stepperBound) return;
    window.stepperBound = true;

 

    $(document).on('change', '#kecamatan_id', function() {
        const selected = $(this).val();

       // console.log('📍 Kecamatan dipilih:', selected);

        // reset kelurahan dulu
        const kelurahanSelect = $('#kelurahan_id');
        kelurahanSelect.empty().append('<option value="">Pilih Kelurahan</option>');

        if (!selected || selected.length === 0) {
            kelurahanSelect.trigger('change');
            return;
        }

        // ambil data kelurahan via AJAX
        $.ajax({
             url: "{{ route('api.kelurahan-by-kecamatan') }}",
            type: 'GET',
            data: { kecamatan_id: selected },
            success: function(data) {
                data.forEach(item => {
                    kelurahanSelect.append(new Option(item.nama_kelurahan, item.id_kelurahan));
                });
                kelurahanSelect.trigger('change');
            },
            error: function(err) {
                console.error('❌ Gagal memuat kelurahan', err);
            }
        });
    });
    

     Livewire.on('resetKelurahanSelect2', () => {
        const $kelurahan = $('#kelurahan_id');
        if ($kelurahan.length && $kelurahan.data('select2')) {
            $kelurahan.val('').trigger('change');
           // console.log('🔁 Kelurahan di-reset (select2 + Livewire)');
        }
    });


  


    window.Livewire.on('updateKelurahanOptions', (data) => {
        const kelurahanSelect = $('#kelurahan_id');
        kelurahanSelect.empty().append('<option value="">Pilih Kelurahan</option>');
       // alert(data[0].length)
        // Loop sebanyak data.length
       data.forEach((row) => {
            
            for (let i = 0; i < data[0].length; i++) {
                //console.log(row[i])
                kelurahanSelect.append(
                $('<option>', {
                    value: row[i].id_kelurahan,
                    text: row[i].nama_kelurahan
                })
            );
            }
            
        });


        // Trigger ulang Select2
        kelurahanSelect.trigger('change');
    });




});
</script>
@endpush
