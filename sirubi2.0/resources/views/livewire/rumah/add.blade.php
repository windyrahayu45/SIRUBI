<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    
    <div class="d-flex flex-column flex-column-fluid">
							<!--begin::Toolbar-->
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<!--begin::Toolbar container-->
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Pendataan Rumah</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										  <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                            <li class="breadcrumb-item text-muted">
                                                <a href="{{ url('/') }}" class="text-muted text-hover-primary">Beranda</a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                            </li>
                                            <li class="breadcrumb-item text-muted">Rumah</li>
                                            <li class="breadcrumb-item">
                                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                                            </li>
                                            <li class="breadcrumb-item text-muted">Tambah Data</li>
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
									<!--begin::Careers - Apply-->
									<div class="card">
										<!--begin::Body-->
										<div class="card-body p-lg-17">
											<!--begin::Hero-->


											<div class="stepper stepper-links d-flex flex-column" id="kt_modal_create_campaign_stepper" wire:ignore.self>
                                                <!--begin::Nav-->
                                                <div class="stepper-nav justify-content-center py-2">
                                                    <!--begin::Step 1-->
                                                    <div id="step-header-1" class="stepper-item me-5 me-md-15 {{ $currentStep === 1 ? 'current' : ($currentStep > 1 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Lokasi</h3>
                                                    </div>
                                                    <!--end::Step 1-->
                                                    <!--begin::Step 2-->
                                                    <div  id="step-header-2" class="stepper-item me-5 me-md-15 {{ $currentStep === 2 ? 'current' : ($currentStep > 2 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Penghuni Rumah</h3>
                                                    </div>

                                                     <div  id="step-header-2" class="stepper-item me-5 me-md-15 {{ $currentStep === 3 ? 'current' : ($currentStep > 3 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Identitas Rumah</h3>
                                                    </div>
                                                    <!--end::Step 2-->
                                                    <!--begin::Step 3-->
                                                    <div id="step-header-3" class="stepper-item me-5 me-md-15 {{ $currentStep === 4 ? 'current' : ($currentStep > 4 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Aspek Keselamatan</h3>
                                                    </div>
                                                    <!--end::Step 3-->
                                                    <!--begin::Step 4-->
                                                    <div id="step-header-4" class="stepper-item me-5 me-md-15 {{ $currentStep === 5 ? 'current' : ($currentStep > 5 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Aspek Kesehatan</h3>
                                                    </div>

                                                   

                                                    <div id="step-header-7" class="stepper-item me-5 me-md-15 {{ $currentStep === 6 ? 'current' : ($currentStep > 6 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title"> Aspek Persyaratan Luas Dan Kebutuhan Ruang</h3>
                                                    </div>

                                                     <div id="step-header-8" class="stepper-item me-5 me-md-15 {{ $currentStep === 7 ? 'current' : ($currentStep > 7 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title"> Aspek Komponen Bahan Bangunan</h3>
                                                    </div>
                                                    <!--end::Step 4-->
                                                    <!--begin::Step 5-->
                                                    <div class="stepper-item {{ $currentStep === 8 ? 'current' : ($currentStep > 8 ? 'completed' : '') }}" data-kt-stepper-element="nav">
                                                        <h3 class="stepper-title">Foto/Dokumentasi</h3>
                                                    </div>
                                                    <!--end::Step 5-->
                                                </div>
                                                <!--end::Nav-->
                                                <!--begin::Form-->
                                                <form class="mx-auto w-100 mw-600px pt-15 pb-10" novalidate="novalidate" id="kt_modal_create_campaign_stepper_form">
                                                    <!--begin::Step 1-->
                                                    <div  class="{{ $currentStep === 1 ? 'current' : ($currentStep > 1 ? 'completed' : '') }}" data-kt-stepper-element="content">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-10 pb-lg-15">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Atur Lokasi Rumah
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Gunakan fitur ini untuk menentukan lokasi rumah secara akurat pada peta pendataan.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->
                                                                <!--begin::Notice-->
                                                                <div class="text-muted fw-semibold fs-6">
                                                                    Jika Anda memerlukan panduan lebih lanjut, silakan buka
                                                                    <a href="#" class="link-primary fw-bold">Halaman Bantuan</a>.
                                                                </div>
                                                                <!--end::Notice-->
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Input group-->
                                                            <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;" wire:ignore></div>

                                                            <div class="row mt-5">
                                                                <div class="col-md-6 fv-row">
                                                                    <label class="required form-label fw-semibold">Latitude</label>
                                                                    <input type="text" id="latitude" wire:model="latitude" class="form-control form-control-solid"
                                                                        placeholder="Latitude akan muncul di sini" readonly style="border-color: rgb(54 54 96);">
                                                                </div>
                                                                <div class="col-md-6 fv-row">
                                                                    <label class=" required form-label fw-semibold">Longitude</label>
                                                                    <input type="text" id="longitude" wire:model="longitude" class="form-control form-control-solid"
                                                                        placeholder="Longitude akan muncul di sini" readonly style="border-color: rgb(54 54 96);">
                                                                </div>
                                                            </div>
                                            
                                                           
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Step 1-->
                                                    <!--begin::Step 2-->
                                                    <div  data-kt-stepper-element="content" class="{{ $currentStep === 2 ? 'current' : ($currentStep > 2 ? 'completed' : '') }}">
                                                        <div class="w-100">
                                                            <div class="pb-10 pb-lg-15">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Penghuni Rumah
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Isi data penghuni rumah sesuai kondisi sebenarnya untuk keperluan pendataan.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Notice-->
                                                                <div class="text-muted fw-semibold fs-6">
                                                                    Untuk informasi lebih lanjut, silakan kunjungi
                                                                    <a href="#" class="link-primary fw-bold">Halaman Bantuan</a>.
                                                                </div>
                                                                <!--end::Notice-->
                                                            </div>

                                                            {{-- Jumlah KK --}}
                                                            <div class="mb-5">
                                                                <label class="form-label fw-semibold">Jumlah KK dalam rumah ini</label>
                                                                <select id="jumlahKK" class="form-select form-select-solid w-100" wire:model="jumlahKK" style="border-color: rgb(54 54 96);">
                                                                    <option value="">Pilih Jumlah KK</option>
                                                                    @foreach($iJumlahKK as $item)
                                                                        <option value="{{ $item->id_jumlah_kk }}">{{ $item->jumlah_kk }}</option>
                                                                    @endforeach
                                                                </select>

                                                                @if ($jumlahKK > 6)
                                                                    <small class="text-danger">❌ Maksimal 6 KK per rumah.</small>
                                                                @endif
                                                            </div>

                                                            {{-- Daftar KK --}}
                                                            @foreach ($kks as $kkIndex => $kk)
                                                                <div class="card card-bordered border-dashed border-gray-300 mb-6">
                                                                    <div class="card-body">
                                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                                            <h5 class="fw-bold text-primary mb-0">KK {{ $kkIndex + 1 }}</h5>
                                                                            <button type="button" class="btn btn-sm btn-light-danger"
                                                                                    wire:click="hapusKK({{ $kkIndex }})">
                                                                                <i class="ki-duotone ki-trash fs-5"></i> Hapus KK
                                                                            </button>
                                                                        </div>

                                                                        {{-- Nomor KK --}}
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nomor KK</label>
                                                                            <input type="text"
                                                                                wire:model="kks.{{ $kkIndex }}.no_kk"
                                                                                class="form-control form-control-solid"
                                                                                maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);"
                                                                                placeholder="Masukkan nomor KK" style="border-color: rgb(54 54 96);"/>
                                                                        </div>

                                                                        {{-- Jumlah Anggota --}}
                                                                        <div class="mb-4">
                                                                            <label class="form-label fw-semibold">Jumlah Anggota KK {{ $kkIndex + 1 }}</label>
                                                                            {{-- <input type="number"
                                                                                wire:model="kks.{{ $kkIndex }}.jumlahAnggota"
                                                                                min="1"
                                                                                max="10"
                                                                                class="form-control form-control-solid"
                                                                                placeholder="Masukkan jumlah anggota (maksimal 10)" />
                                                                            @if ($kk['jumlahAnggota'] > 10)
                                                                                <small class="text-danger">❌ Maksimal 10 anggota per KK.</small>
                                                                            @endif --}}
                                                                        </div>

                                                                        {{-- Field anggota --}}
                                                                        @foreach ($kk['anggota'] as $anggotaIndex => $anggota)
                                                                            <div class="border border-dashed rounded p-4 mb-3 bg-light">
                                                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                                                    <h6 class="fw-bold text-gray-700 mb-0">Anggota {{ $anggotaIndex + 1 }}</h6>
                                                                                    <button type="button" class="btn btn-sm btn-light-danger"
                                                                                            wire:click="hapusAnggota({{ $kkIndex }}, {{ $anggotaIndex }})">
                                                                                        <i class="ki-duotone ki-trash fs-5"></i> Hapus
                                                                                    </button>
                                                                                </div>
                                                                                <div class="row g-3">
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">Nama</label>
                                                                                        <input type="text"
                                                                                            wire:model="kks.{{ $kkIndex }}.anggota.{{ $anggotaIndex }}.nama"
                                                                                            class="form-control form-control-solid"
                                                                                            placeholder="Nama anggota KK" style="border-color: rgb(54 54 96);"/>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label class="form-label">NIK</label>
                                                                                        <input type="text"
                                                                                            wire:model="kks.{{ $kkIndex }}.anggota.{{ $anggotaIndex }}.nik"
                                                                                            class="form-control form-control-solid"
                                                                                            maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);"
                                                                                            placeholder="Nomor Induk Kependudukan" style="border-color: rgb(54 54 96);"/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach

                                                                        {{-- Tombol tambah anggota manual --}}
                                                                        <button type="button"
                                                                                class="btn btn-light-primary"
                                                                                wire:click="tambahAnggota({{ $kkIndex }})"
                                                                                @if(count($kk['anggota']) >= 10) disabled @endif>
                                                                            <i class="ki-duotone ki-plus fs-5"></i> Tambah Anggota KK
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            {{-- Tombol tambah KK manual --}}
                                                            @if (count($kks) < 6)
                                                                <button type="button" class="btn btn-light-success" wire:click="tambahKK">
                                                                    <i class="ki-duotone ki-plus fs-5"></i> Tambah KK Baru
                                                                </button>
                                                            @endif


                                                            



                                                            
                                                        </div>
                                                    </div>

                                                    <div  data-kt-stepper-element="content" class="{{ $currentStep === 3 ? 'current' : ($currentStep > 3 ? 'completed' : '') }}">
                                                        <div class="w-100">
                                                            <div class="pb-10 pb-lg-15">
                                                                <!--begin::Title-->
                                                               <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Identitas Rumah
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-7"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Lengkapi data identitas rumah dengan benar untuk memastikan keakuratan hasil pendataan.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Notice-->
                                                                <div class="text-muted fw-semibold fs-6">
                                                                    Jika Anda memerlukan panduan lebih lanjut, silakan buka
                                                                    <a href="#" class="link-primary fw-bold">Halaman Bantuan</a>.
                                                                </div>

                                                                <!--end::Notice-->
                                                            </div>

                                                            {{-- Jumlah KK --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Jenis Kelamin</label>
                                                                          <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Jenis Kelamin"
                                                                                id="jenis_kelamin_id"
                                                                                data-name="jenis_kelamin_id">
                                                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                                                            @foreach($iJenisKelamin as $item)
                                                                                <option value="{{ $item->id_jenis_kelamin }}">{{ $item->jenis_kelamin }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class=" required fs-5 fw-semibold mb-2">Usia (Tahun)</label>
                                                                        <input type="number" class="form-control form-control-solid" wire:model="usia" placeholder="e.g : 34" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 2 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Pendidikan Terakhir</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Pendidikan"
                                                                                id="pendidikan_terakhir_id"
                                                                                data-name="pendidikan_terakhir_id">
                                                                           <option value="">-- Pilih Pendidikan --</option>
                                                                            @foreach($iPendidikanTerakhir as $item)
                                                                                <option value="{{ $item->id_pendidikan_terakhir }}">{{ $item->pendidikan_terakhir }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Pekerjaan Utama</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Pekerjaan"
                                                                                id="pekerjaan_utama_id"
                                                                                data-name="pekerjaan_utama_id" >
                                                                           <option value="">-- Pilih Pekerjaan --</option>
                                                                            @foreach($iPekerjaanUtama as $item)
                                                                                <option value="{{ $item->id_pekerjaan_utama }}">{{ $item->pekerjaan_utama }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 3 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Besar Penghasilan Perbulan</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Penghasilan"
                                                                                id="besar_penghasilan_id"
                                                                                data-name="besar_penghasilan_id" >
                                                                            <option value="">-- Pilih Penghasilan --</option>
                                                                            @foreach($iBesarPenghasilan as $item)
                                                                                <option value="{{ $item->id_besar_penghasilan }}">{{ $item->besar_penghasilan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Besar Pengeluaran Perbulan</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Pengeluaran"
                                                                                id="besar_pengeluaran_id"
                                                                                data-name="besar_pengeluaran_id">
                                                                            <option value="">-- Pilih Pengeluaran --</option>
                                                                            @foreach($iBesarPengeluaran as $item)
                                                                                <option value="{{ $item->id_besar_pengeluaran }}">{{ $item->besar_pengeluaran }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 4 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-12 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Alamat</label>
                                                                        <textarea style="border-color: rgb(54 54 96);" class="form-control form-control-solid" wire:model="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 5 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">RT</label>
                                                                        <input type="number" class="form-control form-control-solid" wire:model="rt" placeholder="001" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">RW</label>
                                                                        <input type="number" class="form-control form-control-solid" wire:model="rw" placeholder="002" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 6 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kecamatan</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Kecamatan"
                                                                                id="kecamatan_id"
                                                                                data-name="kecamatan_id">
                                                                            <option value="">Pilih Kecamatan</option>
                                                                            @foreach($iKecamatan as $item)
                                                                                <option value="{{ $item->id_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore.self>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kelurahan</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kelurahan"
                                                                                id="kelurahan_id"
                                                                                data-name="kelurahan_id">
                                                                            <option value="">Pilih Kelurahan</option>
                                                                            @foreach($filteredKelurahan as $item)
                                                                                <option value="{{ $item->id_kelurahan }}">{{ $item->nama_kelurahan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 7 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Status Kepemilikan Tanah</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Status"
                                                                                id="status_kepemilikan_tanah_id"
                                                                                data-name="status_kepemilikan_tanah_id" >
                                                                            <option value="">-- Pilih Status --</option>
                                                                            @foreach($iStatusKepemilikanTanah as $item)
                                                                                <option value="{{ $item->id_status_kepemilikan_tanah }}">{{ $item->status_kepemilikan_tanah }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Bukti Kepemilikan Tanah</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Bukti"
                                                                                id="bukti_kepemilikan_tanah_id"
                                                                                data-name="bukti_kepemilikan_tanah_id" >
                                                                            <option value="">-- Pilih Bukti --</option>
                                                                            @foreach($iBuktiKepemilikanTanah as $item)
                                                                                <option value="{{ $item->id_bukti_kepemilikan_tanah }}">{{ $item->bukti_kepemilikan_tanah }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 8 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Status Kepemilikan Rumah</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Status"
                                                                                id="status_kepemilikan_rumah_id"
                                                                                data-name="status_kepemilikan_rumah_id" >
                                                                            <option value="">-- Pilih Status --</option>
                                                                            @foreach($iStatusKepemilikanRumah as $item)
                                                                                <option value="{{ $item->id_status_kepemilikan_rumah }}">{{ $item->status_kepemilikan_rumah }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="fs-5 fw-semibold mb-2">NIK Pemilik Rumah</label>
                                                                        <input type="text"
                                                                        class="form-control form-control-solid"
                                                                        wire:model="nik_kepemilikan_rumah"
                                                                        placeholder="Kosongkan jika milik sendiri"
                                                                        maxlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,16);"
                                                                        style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 9 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Status IMB</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih Status"
                                                                                id="status_imb_id"
                                                                                data-name="status_imb_id" >
                                                                            <option value="">-- Pilih Status --</option>
                                                                            @foreach($iStatusImb as $item)
                                                                                <option value="{{ $item->id_status_imb }}">{{ $item->status_imb }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="fs-5 fw-semibold mb-2">Nomor IMB</label>
                                                                        <input type="text" class="form-control form-control-solid" wire:model="nomor_imb" placeholder="Kosongkan jika tidak ada IMB" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 10 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Aset Rumah Ditempat Lain</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih"
                                                                                id="aset_rumah_ditempat_lain_id"
                                                                                data-name="aset_rumah_ditempat_lain_id" >
                                                                                 <option value="">-- Pilih Status --</option>
                                                                            @foreach($iAsetRumahTempatLain as $item)
                                                                                <option value="{{ $item->id_aset_rumah_tempat_lain }}">{{ $item->aset_rumah_tempat_lain }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Aset Tanah Ditempat Lain</label>
                                                                        <select class="form-select "  data-control="select2"
                                                                                data-placeholder="Pilih"
                                                                                id="aset_tanah_ditempat_lain_id"
                                                                                data-name="aset_tanah_ditempat_lain_id" >
                                                                                  <option value="">-- Pilih Status --</option>
                                                                            @foreach($iAsetTanahTempatLain as $item)
                                                                                <option value="{{ $item->id_aset_tanah_tempat_lain }}">{{ $item->aset_tanah_tempat_lain }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- Baris 11 --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Pernah Mendapatkan Bantuan Perbaikan Rumah</label>
                                                                        <select class="form-select "  data-control="select2"
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Jenis Kawasan Lokasi Rumah Yang Ditempati</label>
                                                                        <select class="form-select "  data-control="select2"
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

                                                                {{-- Baris 12 --}}
                                                                @if ($pernah_mendapatkan_bantuan_id == 1)
                                                                {{-- Baris KK penerima --}}
                                                                    <div class="row mb-5">
                                                                        <div class="col-md-6 fv-row">
                                                                            <label class="fs-5 fw-semibold mb-2">KK Penerima Bantuan</label>
                                                                            <input type="text" class="form-control form-control-solid"
                                                                                wire:model="no_kk_penerima"
                                                                                maxlength="16"
                                                                                pattern="\d{16}"
                                                                                inputmode="numeric"
                                                                                style="border-color: rgb(54 54 96);">
                                                                        </div>
                                                                        <div class="col-md-6 fv-row">
                                                                            <label class="fs-5 fw-semibold mb-2">Tahun Bantuan</label>
                                                                            <input type="text" class="form-control form-control-solid"
                                                                                wire:model="tahun_bantuan"
                                                                                placeholder="e.g : 2022"
                                                                                maxlength="4" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,4);"
                                                                                style="border-color: rgb(54 54 96);">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Baris Nama + Program --}}
                                                                    <div class="row mb-5">
                                                                        <div class="col-md-6 fv-row">
                                                                            <label class="fs-5 fw-semibold mb-2">Nama Bantuan</label>
                                                                            <input type="text" class="form-control form-control-solid"
                                                                                wire:model="nama_bantuan"
                                                                                style="border-color: rgb(54 54 96);">
                                                                        </div>
                                                                        <div class="col-md-6 fv-row">
                                                                            <label class="fs-5 fw-semibold mb-2">Nama Program Bantuan</label>
                                                                            <input type="text" class="form-control form-control-solid"
                                                                                wire:model="nama_program_bantuan"
                                                                                style="border-color: rgb(54 54 96);">
                                                                        </div>
                                                                    </div>

                                                                    {{-- Baris Nominal --}}
                                                                    <div class="row mb-5">
                                                                        <div class="col-md-6 fv-row">
                                                                            <label class="fs-5 fw-semibold mb-2">Nominal Bantuan</label>
                                                                            <input type="text" class="form-control form-control-solid"
                                                                                wire:model="nominal_bantuan"
                                                                                placeholder="e.g : 1500000"
                                                                                inputmode="numeric"
                                                                                style="border-color: rgb(54 54 96);">
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                               


                                                            



                                                            
                                                        </div>
                                                    </div>

                                                    <!--end::Step 2-->
                                                    <!--begin::Step 3-->
                                                    <div  data-kt-stepper-element="content" class="{{ $currentStep === 4 ? 'current' : ($currentStep > 4 ? 'completed' : '') }}">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-10 pb-lg-12">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Aspek Keselamatan
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Lengkapi data terkait kekokohan struktur bangunan, pondasi, dan keamanan rumah untuk memastikan keselamatan penghuni.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="text-muted fw-semibold fs-4">
                                                                    Pastikan data aspek keselamatan rumah diisi dengan benar untuk mendukung penilaian kondisi bangunan. 
                                                                    Jika Anda memerlukan panduan lebih lanjut, silakan buka 
                                                                    <a href="#" class="link-primary fw-bold">Halaman Panduan</a>.
                                                                </div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Input group-->
                                                            <div>
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Pondasi</label>
                                                                        <select class="form-select" 
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Pondasi"
                                                                                data-name="pondasi_id"
                                                                                id="pondasi_id"
                                                                                required>
                                                                            <option value="">-- Pilih Pondasi --</option>
                                                                            @foreach($aPondasi ?? [] as $item)
                                                                                <option value="{{ $item->id_pondasi }}">{{ $item->pondasi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Jenis Pondasi</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Jenis Pondasi"
                                                                                data-name="jenis_pondasi_id"
                                                                                id="jenis_pondasi_id"
                                                                                required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Pondasi</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kondisi Pondasi"
                                                                                data-name="kondisi_pondasi_id"
                                                                                id="kondisi_pondasi_id"
                                                                                required>
                                                                            <option value="">-- Pilih Kondisi Pondasi --</option>
                                                                            @foreach($aKondisiPondasi ?? [] as $item)
                                                                                <option value="{{ $item->id_kondisi_pondasi }}">{{ $item->kondisi_pondasi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Sloof</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kondisi Sloof"
                                                                                data-name="kondisi_sloof_id"
                                                                                id="kondisi_sloof_id"
                                                                                required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Kolom / Tiang</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kondisi Kolom / Tiang"
                                                                                data-name="kondisi_kolom_tiang_id"
                                                                                id="kondisi_kolom_tiang_id"
                                                                                required>
                                                                            <option value="">-- Pilih Kondisi Kolom / Tiang --</option>
                                                                            @foreach($aKondisiKolomTiang ?? [] as $item)
                                                                                <option value="{{ $item->id_kondisi_kolom_tiang }}">{{ $item->kondisi_kolom_tiang }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Balok</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kondisi Balok"
                                                                                data-name="kondisi_balok_id"
                                                                                id="kondisi_balok_id"
                                                                                required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Struktur Atap</label>
                                                                        <select class="form-select"
                                                                                data-control="select2"
                                                                                data-placeholder="Pilih Kondisi Struktur Atap"
                                                                                data-name="kondisi_struktur_atap_id"
                                                                                id="kondisi_struktur_atap_id"
                                                                                required>
                                                                            <option value="">-- Pilih Kondisi Struktur Atap --</option>
                                                                            @foreach($aKondisiStrukturAtap ?? [] as $item)
                                                                                <option value="{{ $item->id_kondisi_struktur_atap }}">{{ $item->kondisi_struktur_atap }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Step 3-->
                                                    <!--begin::Step 4-->
                                                    <div data-kt-stepper-element="content" class="{{ $currentStep === 5 ? 'current' : ($currentStep > 5 ? 'completed' : '') }}">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-10 pb-lg-12">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Aspek Kesehatan
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Isi data terkait pencahayaan, ventilasi, kebersihan, dan sanitasi rumah untuk menilai tingkat kesehatan lingkungan hunian.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="text-muted fw-semibold fs-4">
                                                                    Pastikan seluruh informasi mengenai aspek kesehatan rumah, seperti ventilasi, sanitasi, dan pencahayaan, telah diisi dengan benar. 
                                                                    Untuk panduan lebih lanjut, silakan buka 
                                                                    <a href="#" class="link-primary fw-bold">Halaman Panduan</a>.
                                                                </div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Input group-->
                                                            
                                                            <div>
                                                                {{-- ✅ Baris 1: Jendela & Kondisi --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Jendela / Lubang Cahaya</label>
                                                                        <select class="form-select" data-control="select2" data-name="jendela_lubang_cahaya_id"
                                                                                data-placeholder="Pilih Jendela / Lubang Cahaya" id="jendela_lubang_cahaya_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bJendelaLubangCahaya ?? [] as $item)
                                                                                <option value="{{ $item->id_jendela_lubang_cahaya }}">{{ $item->jendela_lubang_cahaya }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Jendela / Lubang Cahaya</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_jendela_lubang_cahaya_id"
                                                                                data-placeholder="Pilih Kondisi" id="kondisi_jendela_lubang_cahaya_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Ventilasi</label>
                                                                        <select class="form-select" data-control="select2" data-name="ventilasi_id"
                                                                                data-placeholder="Pilih Ventilasi" id="ventilasi_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bVentilasi ?? []  as $item)
                                                                                <option value="{{ $item->id_ventilasi }}">{{ $item->ventilasi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="fs-5 fw-semibold mb-2">Keterangan Ventilasi</label>
                                                                        <input type="text" class="form-control form-control-solid"
                                                                            wire:model="keterangan_ventilasi"
                                                                            placeholder="Kosongkan jika tidak ada"
                                                                            style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 3: Kondisi Ventilasi + Kamar Mandi --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Ventilasi</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_ventilasi_id"
                                                                                data-placeholder="Pilih Kondisi Ventilasi" id="kondisi_ventilasi_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKondisiVentilasi ?? []  as $item)
                                                                                <option value="{{ $item->id_kondisi_ventilasi }}">{{ $item->kondisi_ventilasi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kamar Mandi</label>
                                                                        <select class="form-select" data-control="select2" data-name="kamar_mandi_id"
                                                                                data-placeholder="Pilih Kamar Mandi" id="kamar_mandi_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKamarMandi ?? []  as $item)
                                                                                <option value="{{ $item->id_kamar_mandi }}">{{ $item->kamar_mandi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 4: Kondisi Kamar Mandi + Jamban --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Kamar Mandi</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_kamar_mandi_id"
                                                                                data-placeholder="Pilih Kondisi Kamar Mandi" id="kondisi_kamar_mandi_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKondisiKamarMandi ?? []  as $item)
                                                                                <option value="{{ $item->id_kondisi_kamar_mandi }}">{{ $item->kondisi_kamar_mandi }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Jamban</label>
                                                                        <select class="form-select" data-control="select2" data-name="jamban_id"
                                                                                data-placeholder="Pilih Jamban" id="jamban_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bJamban ?? []  as $item)
                                                                                <option value="{{ $item->id_jamban }}">{{ $item->jamban }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 5: Kondisi Jamban + Pembuangan Air Kotor --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Jamban</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_jamban_id"
                                                                                data-placeholder="Pilih Kondisi Jamban" id="kondisi_jamban_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKondisiJamban  ?? [] as $item)
                                                                                <option value="{{ $item->id_kondisi_jamban }}">{{ $item->kondisi_jamban }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Sistem Pembuangan Air Kotor</label>
                                                                        <select class="form-select" data-control="select2" data-name="sistem_pembuangan_air_kotor_id"
                                                                                data-placeholder="Pilih Sistem" id="sistem_pembuangan_air_kotor_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bSistemPembuanganAirKotor ?? []  as $item)
                                                                                <option value="{{ $item->id_sistem_pembuangan_air_kotor }}">{{ $item->sistem_pembuangan_air_kotor }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 6: Kondisi Pembuangan + Frekuensi Penyedotan --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Sistem Pembuangan Air Kotor</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_sistem_pembuangan_air_kotor_id"
                                                                                data-placeholder="Pilih Kondisi Sistem" id="kondisi_sistem_pembuangan_air_kotor_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKondisiSistemPembuanganAirKotor ?? []  as $item)
                                                                                <option value="{{ $item->id_kondisi_sistem_pembuangan_air_kotor }}">{{ $item->kondisi_sistem_pembuangan_air_kotor }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Frekuensi Penyedotan (5 Tahun)</label>
                                                                        <select class="form-select" data-control="select2" data-name="frekuensi_penyedotan_id"
                                                                                data-placeholder="Pilih Frekuensi" id="frekuensi_penyedotan_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bFrekuensiPenyedotan ?? []  as $item)
                                                                                <option value="{{ $item->id_frekuensi_penyedotan }}">{{ $item->frekuensi_penyedotan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 7: Sumber Air Minum + Kondisi --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Sumber Air Minum</label>
                                                                        <select class="form-select" data-control="select2" data-name="sumber_air_minum_id"
                                                                                data-placeholder="Pilih Sumber Air Minum" id="sumber_air_minum_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bSumberAirMinum ?? []  as $item)
                                                                                <option value="{{ $item->id_sumber_air_minum }}">{{ $item->sumber_air_minum }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Sumber Air Minum</label>
                                                                        <select class="form-select" data-control="select2" data-name="kondisi_sumber_air_minum_id"
                                                                                data-placeholder="Pilih Kondisi" id="kondisi_sumber_air_minum_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bKondisiSumberAirMinum ?? []  as $item)
                                                                                <option value="{{ $item->id_kondisi_sumber_air_minum }}">{{ $item->kondisi_sumber_air_minum }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 8: Sumber Listrik --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Sumber Listrik</label>
                                                                        <select class="form-select" data-control="select2" data-name="sumber_listrik_id"
                                                                                data-placeholder="Pilih Sumber Listrik" id="sumber_listrik_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($bSumberListrik  ?? [] as $item)
                                                                                <option value="{{ $item->id_sumber_listrik }}">{{ $item->sumber_listrik }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Step 4-->
                                                    <!--begin::Step 5-->
                                                    

                                                    <div  data-kt-stepper-element="content" class="{{ $currentStep === 6 ? 'current' : ($currentStep > 6 ? 'completed' : '') }}">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-12 text-center">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Aspek Persyaratan Luas dan Kebutuhan Ruang
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Isi data mengenai luas bangunan dan jumlah ruang untuk memastikan kesesuaian dengan standar kebutuhan hunian yang layak.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="text-muted fw-semibold fs-4">
                                                                    Pastikan data luas bangunan dan jumlah ruang diisi dengan benar agar dapat dinilai sesuai standar kelayakan rumah. 
                                                                    Untuk panduan lebih lanjut, silakan buka 
                                                                    <a href="#" class="link-primary fw-bold">Halaman Panduan</a>.
                                                                </div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Actions-->


                                                            <div>
                                                                {{-- ✅ Baris 1: Luas Rumah & Jumlah Penghuni Laki-laki --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Luas Rumah (m²)</label>
                                                                        <input type="text" wire:model="luas_rumah" class="form-control form-control-solid"
                                                                            placeholder="e.g : 7.08" style="border-color: rgb(54 54 96);" inputmode="decimal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Jumlah Penghuni Laki-laki</label>
                                                                        <input type="number" wire:model="jumlah_penghuni_laki" class="form-control form-control-solid"
                                                                            placeholder="e.g : 2" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 2: Penghuni Perempuan & Anak Berkebutuhan Khusus --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Jumlah Penghuni Perempuan</label>
                                                                        <input type="number" wire:model="jumlah_penghuni_perempuan" class="form-control form-control-solid"
                                                                            placeholder="e.g : 2" style="border-color: rgb(54 54 96);">
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="fs-5 fw-semibold mb-2">Jumlah Anak Berkebutuhan Khusus</label>
                                                                        <input type="number" wire:model="jumlah_abk" class="form-control form-control-solid"
                                                                            placeholder="0" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 3: Tinggi Rata-rata & Ruang Keluarga / Tidur --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Tinggi Rata-rata Bangunan (m²)</label>
                                                                        <input type="text" wire:model="tinggi_rata_rumah" class="form-control form-control-solid"
                                                                            placeholder="e.g : 3.02" style="border-color: rgb(54 54 96);" inputmode="decimal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Ruang Keluarga & Ruang Tidur</label>
                                                                        <select class="form-select" data-control="select2" data-placeholder="Pilih Opsi"
                                                                                data-name="ruang_keluarga_dan_tidur_id" id="ruang_keluarga_dan_tidur_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($cRuangKeluargaDanTidur ?? []  as $item)
                                                                                <option value="{{ $item->id_ruang_keluarga_dan_tidur }}">{{ $item->ruang_keluarga_dan_tidur }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 4: Jumlah Kamar & Luas Rata-rata Kamar --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Jumlah Kamar Tidur</label>
                                                                        <input type="number" wire:model="jumlah_kamar_tidur" class="form-control form-control-solid"
                                                                            placeholder="e.g : 2" style="border-color: rgb(54 54 96);">
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Luas Rata-rata Kamar Tidur (m²)</label>
                                                                        <input type="text" wire:model="luas_rata_kamar_tidur" class="form-control form-control-solid"
                                                                            placeholder="e.g : 4.5" style="border-color: rgb(54 54 96);" inputmode="decimal" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 5: Jenis Fisik & Jumlah Lantai --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Jenis Fisik Bangunan</label>
                                                                        <select class="form-select" data-control="select2" data-name="jenis_fisik_bangunan_id"
                                                                                data-placeholder="Pilih Jenis Fisik Bangunan" id="jenis_fisik_bangunan_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($cJenisFisikBangunan  ?? [] as $item)
                                                                                <option value="{{ $item->id_jenis_fisik_bangunan }}">{{ $item->jenis_fisik_bangunan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Jumlah Lantai Bangunan</label>
                                                                        <input type="number" wire:model="jumlah_lantai_bangunan" class="form-control form-control-solid"
                                                                            placeholder="e.g : 1" style="border-color: rgb(54 54 96);">
                                                                    </div>
                                                                </div>

                                                                {{-- ✅ Baris 6: Fungsi Rumah & Tipe Rumah --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Fungsi Rumah</label>
                                                                        <select class="form-select" data-control="select2" data-name="fungsi_rumah_id"
                                                                                data-placeholder="Pilih Fungsi Rumah" id="fungsi_rumah_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($cFungsiRumah  ?? [] as $item)
                                                                                <option value="{{ $item->id_fungsi_rumah }}">{{ $item->fungsi_rumah }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Tipe Rumah</label>
                                                                        <select class="form-select" data-control="select2" data-name="tipe_rumah_id"
                                                                                data-placeholder="Pilih Tipe Rumah" id="tipe_rumah_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Status DTKS (Data Terpadu Kesejahteraan Sosial)</label>
                                                                        <select class="form-select" data-control="select2" data-name="status_dtks_id"
                                                                                data-placeholder="Pilih Status DTKS" id="status_dtks_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($cStatusDtks ?? []  as $item)
                                                                                <option value="{{ $item->id_status_dtks }}">{{ $item->status_dtks }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row">
                                                                        <label class="required fs-5 fw-semibold mb-2">Tahun Pembangunan Rumah</label>
                                                                        <input type="text" wire:model="tahun_pembangunan_rumah" class="form-control form-control-solid"
                                                                            placeholder="e.g : 2001" style="border-color: rgb(54 54 96);" maxlength="4" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,4);">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                            <!--end::Illustration-->
                                                        </div>
                                                    </div>

                                                    <div  data-kt-stepper-element="content" class="{{ $currentStep === 7 ? 'current' : ($currentStep > 7 ? 'completed' : '') }}">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-12 text-center">
                                                                <!--begin::Title-->
                                                               <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Aspek Komponen Bahan Bangunan
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Lengkapi data mengenai jenis dan kondisi bahan bangunan seperti dinding, lantai, atap, serta struktur utama rumah untuk menilai kualitas konstruksi.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="text-muted fw-semibold fs-4">
                                                                    Pastikan seluruh informasi tentang bahan dan komponen bangunan, seperti dinding, atap, dan lantai, telah diisi dengan benar untuk mendukung penilaian kualitas rumah. 
                                                                    Untuk panduan lebih lanjut, silakan buka 
                                                                    <a href="#" class="link-primary fw-bold">Halaman Panduan</a>.
                                                                </div>
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Actions-->

                                                            <div>
                                                                {{-- ✅ Baris 1: Material Atap & Kondisi Penutup --}}
                                                                <div class="row mb-5">
                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Material Atap Terluas</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="material_atap_terluas_id"
                                                                                data-placeholder="Pilih Material Atap Terluas"
                                                                                id="material_atap_terluas_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dMaterialAtapTerluas ?? []  as $item)
                                                                                <option value="{{ $item->id_material_atap_terluas }}">{{ $item->material_atap_terluas }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Penutup Atap</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="kondisi_penutup_atap_id"
                                                                                data-placeholder="Pilih Kondisi Penutup Atap"
                                                                                id="kondisi_penutup_atap_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Material Dinding Terluas</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="material_dinding_terluas_id"
                                                                                data-placeholder="Pilih Material Dinding Terluas"
                                                                                id="material_dinding_terluas_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dMaterialDindingTerluas ?? []  as $item)
                                                                                <option value="{{ $item->id_material_dinding_terluas }}">{{ $item->material_dinding_terluas }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Dinding</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="kondisi_dinding_id"
                                                                                data-placeholder="Pilih Kondisi Dinding"
                                                                                id="kondisi_dinding_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Material Lantai Terluas</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="material_lantai_terluas_id"
                                                                                data-placeholder="Pilih Material Lantai Terluas"
                                                                                id="material_lantai_terluas_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dMaterialLantaiTerluas ?? []  as $item)
                                                                                <option value="{{ $item->id_material_lantai_terluas }}">{{ $item->material_lantai_terluas }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Kondisi Lantai</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="kondisi_lantai_id"
                                                                                data-placeholder="Pilih Kondisi Lantai"
                                                                                id="kondisi_lantai_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Akses Langsung ke Jalan</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="akses_ke_jalan_id"
                                                                                data-placeholder="Pilih Akses Jalan"
                                                                                id="akses_ke_jalan_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dAksesKeJalan ?? []  as $item)
                                                                                <option value="{{ $item->id_akses_ke_jalan }}">{{ $item->akses_ke_jalan }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Bangunan Menghadap Jalan</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="bangunan_menghadap_jalan_id"
                                                                                data-placeholder="Pilih Opsi"
                                                                                id="bangunan_menghadap_jalan_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Bangunan Menghadap Sungai</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="bangunan_menghadap_sungai_id"
                                                                                data-placeholder="Pilih Opsi"
                                                                                id="bangunan_menghadap_sungai_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dBangunanMenghadapSungai ?? []  as $item)
                                                                                <option value="{{ $item->id_bangunan_menghadap_sungai }}">{{ $item->bangunan_menghadap_sungai }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-6 fv-row" wire:ignore>
                                                                        <label class="required fs-5 fw-semibold mb-2">Bangunan Berada di Buangan Limbah Pabrik / Sutet</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="bangunan_berada_limbah_id"
                                                                                data-placeholder="Pilih Opsi"
                                                                                id="bangunan_berada_limbah_id" required>
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
                                                                        <label class="required fs-5 fw-semibold mb-2">Bangunan Berada di Atas Sempadan Sungai / Laut / Rawa</label>
                                                                        <select class="form-select" data-control="select2"
                                                                                data-name="bangunan_berada_sungai_id"
                                                                                data-placeholder="Pilih Opsi"
                                                                                id="bangunan_berada_sungai_id" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            @foreach($dBangunanBeradaSungai ?? []  as $item)
                                                                                <option value="{{ $item->id_bangunan_berada_sungai }}">{{ $item->bangunan_berada_sungai }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--end::Illustration-->
                                                        </div>
                                                    </div>

                                                    <div data-kt-stepper-element="content" class="{{ $currentStep === 8 ? 'current' : ($currentStep > 8 ? 'completed' : '') }}">
                                                        <!--begin::Wrapper-->
                                                        <div class="w-100">
                                                            <!--begin::Heading-->
                                                            <div class="pb-12 text-center">
                                                                <!--begin::Title-->
                                                                <h2 class="fw-bold d-flex align-items-center text-dark">
                                                                    Dokumentasi
                                                                    <i class="fas fa-exclamation-circle ms-2 fs-6"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Unggah foto rumah dan dokumen pendukung lainnya untuk melengkapi hasil pendataan secara visual. Pastikan file yang diunggah jelas dan sesuai ketentuan.">
                                                                    </i>
                                                                </h2>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="text-muted fw-semibold fs-4">
                                                                    Pastikan seluruh foto dan dokumen pendukung telah diunggah dengan benar agar data rumah dapat diverifikasi secara visual. 
                                                                    Untuk petunjuk lebih lanjut, silakan buka 
                                                                    <a href="#" class="link-primary fw-bold">Halaman Panduan</a>.
                                                                </div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Heading-->
                                                            <!--begin::Actions-->

                                                            <div class="row g-6">
                                                                @foreach([
                                                                    ['label' => 'Kartu Keluarga (KK)', 'id' => 'foto_kk'],
                                                                    ['label' => 'Kartu Tanda Penduduk (KTP)', 'id' => 'foto_ktp'],
                                                                    ['label' => 'Foto Rumah 1', 'id' => 'foto_rumah_satu'],
                                                                    ['label' => 'Foto Rumah 2', 'id' => 'foto_rumah_dua'],
                                                                    ['label' => 'Foto Rumah 3', 'id' => 'foto_rumah_tiga'],
                                                                    ['label' => 'Foto IMB', 'id' => 'foto_imb'],
                                                                ] as $item)
                                                                    <div class="col-md-6 fv-row" wire:ignore.self>
                                                                        <label class="fs-5 fw-semibold mb-2">{{ $item['label'] }}</label>

                                                                        <!--begin::Dropzone-->
                                                                        <div class="dropzone border border-dashed border-primary rounded-3 position-relative text-center p-5"
                                                                            onclick="document.getElementById('{{ $item['id'] }}').click()"
                                                                            style="cursor:pointer;">
                                                                            @if ($this->{$item['id']})
                                                                                <!-- ✅ Preview Thumbnail -->
                                                                                <div class="position-relative d-inline-block">
                                                                                    <img src="{{ $this->{$item['id']}->temporaryUrl() }}" class="img-fluid rounded" style="max-height: 180px;">
                                                                                    <!-- 🔹 Tombol Ganti / Hapus -->
                                                                                    <button type="button"
                                                                                            class="btn btn-icon btn-sm btn-danger position-absolute top-0 end-0 translate-middle"
                                                                                            wire:click="removePhoto('{{ $item['id'] }}')"
                                                                                            style="margin-top:-10px;margin-right:-10px;">
                                                                                        <i class="fa fa-times"></i>
                                                                                    </button>
                                                                                </div>

                                                                                <!-- 🔹 Progress Bar (Metronic style) -->
                                                                                <div class="progress mt-3 h-5px">
                                                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%"></div>
                                                                                </div>
                                                                            @else
                                                                                <!-- 🧩 Default Dropzone UI -->
                                                                                <div class="dz-message needsclick py-6">
                                                                                    <i class="fa-solid fa-cloud-arrow-up fs-2x text-primary mb-3"></i>
                                                                                    <div>
                                                                                        <h3 class="fs-6 fw-bold text-gray-800 mb-1">Klik atau Drop file di sini</h3>
                                                                                        <span class="fw-semibold fs-7 text-muted">Format: JPG, PNG. Maks 4MB</span>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <!--end::Dropzone-->

                                                                        <input type="file" id="{{ $item['id'] }}"
                                                                            wire:model="{{ $item['id'] }}" accept="image/*"
                                                                            class="d-none">

                                                                        @error($item['id'])
                                                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                @endforeach
                                                            </div>
    
                                                            
            
                                                            <!--end::Illustration-->
                                                        </div>
                                                    </div>

                                                    <!--end::Step 5-->
                                                    <!--begin::Actions-->
                                                    <div class="d-flex flex-stack pt-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="me-2">
                                                            <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous" wire:click="setStep({{ $currentStep - 1 }})" @disabled($currentStep <= 1)>
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr063.svg-->
                                                            <span class="svg-icon svg-icon-3 me-1">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1" fill="currentColor" />
                                                                    <path d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->Back</button>
                                                        </div>
                                                        <!--end::Wrapper-->
                                                        <!--begin::Wrapper-->
                                                        <div>
                                                            <button type="button" 
                                                                    class="btn btn-lg btn-primary" 
                                                                    data-kt-stepper-action="submit"
                                                                    wire:click="submitForm">
                                                                <span class="indicator-label">
                                                                    Submit
                                                                    <span class="svg-icon svg-icon-3 ms-2 me-0">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                                                            <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                                                        </svg>
                                                                    </span>
                                                                </span>
                                                                <span class="indicator-progress">
                                                                    Please wait...
                                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                                </span>
                                                            </button>

                                                            <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next" wire:click="setStep({{ $currentStep + 1 }})"@disabled($currentStep >= 9)>Continue
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                            <span class="svg-icon svg-icon-3 ms-1 me-0">
                                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                                                    <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="currentColor" />
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon--></button>
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Actions-->
                                                </form>
                                                <!--end::Form-->
                                            </div>

											
											<!--end::Card-->
										</div>
										<!--end::Body-->
									</div>
									<!--end::Careers - Apply-->
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
"use strict";

document.addEventListener("livewire:navigated", function () {
    if (window.stepperInitialized) return;
    window.stepperInitialized = true;

    const stepperElement = document.querySelector("#kt_modal_create_campaign_stepper");
    if (!stepperElement) return;

    const stepper = new KTStepper(stepperElement);
    console.log("✅ Stepper initialized");

    const btnNext = stepperElement.querySelector('[data-kt-stepper-action="next"]');
    const btnPrev = stepperElement.querySelector('[data-kt-stepper-action="previous"]');
    const btnSubmit = stepperElement.querySelector('[data-kt-stepper-action="submit"]');

    // 🔹 Ambil komponen Livewire aktif (otomatis Add)
    const livewireComponent = window.Livewire.find(
        stepperElement.closest('[wire\\:id]').getAttribute('wire:id')
    );

    if (!livewireComponent) {
        console.warn("⚠️ Tidak menemukan komponen Livewire yang aktif untuk stepper!");
        return;
    }

    // 🔄 Update tombol + sinkron step
    stepper.on("kt.stepper.changed", function () {
        const currentStep = stepper.getCurrentStepIndex();
        console.log("🔹 Step changed:", currentStep);

        if (currentStep === 7) {
            btnSubmit.classList.remove("d-none");
            btnNext.classList.add("d-none");
        } else {
            btnSubmit.classList.add("d-none");
            btnNext.classList.remove("d-none");
        }

        // ✅ Kirim ke komponen Livewire Add
        livewireComponent.dispatch('setStep', currentStep);
    });

    // ⏭️ Next button
    stepper.on("kt.stepper.next", function (step) {
        const index = step.getCurrentStepIndex();
        step.goNext();
        livewireComponent.dispatch('setStep', index + 1);
        KTUtil.scrollTop();
    });

    // ⏮️ Prev button
    stepper.on("kt.stepper.previous", function (step) {
        const index = step.getCurrentStepIndex();
        step.goPrevious();
        livewireComponent.dispatch('setStep', index - 1);
        KTUtil.scrollTop();
    });

    // ✅ Terima event dari Livewire untuk update visual stepper
    Livewire.on('stepChanged', (step) => {
        console.log("🔁 stepChanged dari Livewire:", step);
        stepper.goTo(step);

        console.log("🔹 Memperbarui tampilan stepper ke step:", step[0]);

       // 🔹 Hapus semua class 'current' & 'completed'
        document.querySelectorAll('[id^="step-header-"]').forEach(el => {
            el.classList.remove('current', 'completed');
        });

        // 🔹 Tambahkan class 'completed' ke semua step sebelum step aktif
        for (let i = 1; i < step[0]; i++) {
            const prev = document.getElementById(`step-header-${i}`);
            if (prev) prev.classList.add('completed');
        }

        // 🔹 Tambahkan class 'current' hanya ke step aktif
        const current = document.getElementById(`step-header-${step[0]}`);
        if (current) current.classList.add('current');
    });
});
</script>



<script>
document.addEventListener('livewire:navigated', () => {
    // 🔹 Pastikan stepper hanya diinisialisasi sekali
    if (window.stepperBound) return;
    window.stepperBound = true;

    // 🔹 Dengarkan perubahan currentStep dari Livewire
    Livewire.on('stepChanged', step => {
        const headers = document.querySelectorAll('.stepper-item');
        headers.forEach((el, index) => {
            el.classList.remove('current', 'completed');
            const i = index + 1;
            if (i < step) el.classList.add('completed');
            if (i === step) el.classList.add('current');
        });
    });

     Livewire.on('resetKelurahanSelect2', () => {
        const $kelurahan = $('#kelurahan_id');
        if ($kelurahan.length && $kelurahan.data('select2')) {
            $kelurahan.val('').trigger('change');
            console.log('🔁 Kelurahan di-reset (select2 + Livewire)');
        }
    });

});
</script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Titik tengah Bukittinggi
    const startLat = -0.305441;
    const startLng = 100.369164;

    // --- Layer Definitions ---
    const googleStreets = L.tileLayer(
        'https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
        { maxZoom: 19, subdomains: ['mt0','mt1','mt2','mt3'], attribution: '© Google Maps' }
    );

    const googleHybrid = L.tileLayer(
        'https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
        { maxZoom: 19, subdomains: ['mt0','mt1','mt2','mt3'], attribution: '© Google Hybrid' }
    );

    const openStreet = L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        { maxZoom: 16, attribution: '© OpenStreetMap contributors' }
    );

    // --- Map Initialization (default Google Hybrid) ---
    const map = L.map('map', {
        center: [startLat, startLng],
        zoom: 15,
        layers: [googleHybrid] // default layer
    });

    // --- Layer Control (top right) ---
    const baseLayers = {
        "Google Hybrid": googleHybrid,
        "Google Streets": googleStreets,
        "OpenStreetMap": openStreet
    };
    L.control.layers(baseLayers, null, { position: 'topright', collapsed: true }).addTo(map);

     const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // --- Marker awal ---
    const marker = L.marker([startLat, startLng], { draggable: true, icon: redIcon }).addTo(map);

    // --- Update input saat marker digeser ---
    function updateLatLng(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
        if (window.Livewire) {
            @this.set('latitude', lat.toFixed(6));
            @this.set('longitude', lng.toFixed(6));
        }
    }

    marker.on('dragend', function (e) {
        const pos = marker.getLatLng();
        updateLatLng(pos.lat, pos.lng);
    });

    // --- Klik peta pindahkan marker ---
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng(e.latlng);
        updateLatLng(lat, lng);
    });

    // --- Set nilai awal ke input ---
    updateLatLng(startLat, startLng);
});
</script>
<script>
document.addEventListener('livewire:navigated', initSelect2);
document.addEventListener('livewire:load', initSelect2);

function initSelect2() {
    console.log("✅ Init Select2 triggered");

    $('[data-control="select2"]').each(function() {
        const el = $(this);

        // Pastikan tidak diinisialisasi dua kali
        // if (el.data('select2')) {
        //     el.select2('destroy');
        // }
        // console.log(el.data('placeholder'))
        el.select2({
          
            width: '100%',
            placeholder: el.data('placeholder') ?? '',
          
        });

        // Saat value diubah, kirim ke Livewire
        el.on('change', function () {
            const value = $(this).val();
            const name = el.data('name');
           // alert(value)
             const componentId = el.closest('[wire\\:id]').attr('wire:id');

    if (componentId) {
        const component = Livewire.find(componentId);
        if (component) {
            console.log('✅ Dispatch ke komponen:', component.name);
            component.call('select2Changed', { name, value });
        }
    } else {
        console.warn('⚠️ Tidak menemukan komponen Livewire untuk select2');
    }
        });
    });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('swal:error', function (event) {
        console.log(event)
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
        }).then(() => {
            // 🔹 Redirect ke komponen Livewire lain (SPA-style)
           
            window.location.href = "{{ route('data') }}";
    
            // ubah '/rumah/data' sesuai route Livewire kamu
        });
    });

});
</script>
@endpush