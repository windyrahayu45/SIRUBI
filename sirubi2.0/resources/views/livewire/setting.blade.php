<div>
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Akun Saya</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Akun</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Navbar-->
                <div class="card mb-5 mb-xl-10">
                    <div class="card-body pt-9 pb-0">
                        <!--begin::Details-->
                        <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                            <!--begin: Pic-->
                            <div class="me-7 mb-4">
                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                    <div class="symbol-label fs-2 bg-light-primary text-primary">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                                </div>
                            </div>
                            <!--end::Pic-->
                            <!--begin::Info-->
                            <div class="flex-grow-1">
                                <!--begin::Title-->
                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                    <!--begin::User-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->name }}</a>
                                            <a href="#">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen026.svg-->
                                                <span class="svg-icon svg-icon-1 svg-icon-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                                        <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="currentColor" />
                                                        <path d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            {{-- <a href="#" class="btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade to Pro</a> --}}
                                        </div>
                                       
                                    </div>
                                    <!--end::User-->
                                   
                                </div>
                                <!--end::Title-->
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap flex-stack">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column flex-grow-1 pe-8">
                                        <!--begin::Stats-->
                                        <div class="d-flex flex-wrap">
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                                    <span class="svg-icon svg-icon-3 svg-icon-success me-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                                            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <div class="fs-2 fw-bold" >{{$role }}</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-400">Akses</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                <!--begin::Number-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                                    <span class="svg-icon svg-icon-3 svg-icon-danger me-2">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                            <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                    <div class="fs-2 fw-bold" >{{$data->instansi}}</div>
                                                </div>
                                                <!--end::Number-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold fs-6 text-gray-400">Instansi</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                            <!--begin::Stat-->
                                           
                                        </div>
                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Wrapper-->
                                   
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                            
                            <!--end::Nav item-->
                            <!--begin::Nav item-->
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#">Settings</a>
                            </li>
                            
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
                <!--end::Navbar-->
                <!--begin::Basic info-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Detail Profil</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_profile_details" class="collapse show">
                        <!--begin::Form-->
                        <form id="kt_account_profile_details_form" class="form">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!-- Nama Lengkap -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama Lengkap</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 fv-row">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    wire:model="nama_lengkap" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- NIK -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">NIK</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 fv-row">
                                                <input type="text"
                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                    wire:model="nik" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Jabatan -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Jabatan</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text"
                                            class="form-control form-control-lg form-control-solid"
                                            wire:model="jabatan" />
                                    </div>
                                </div>

                                <!-- Instansi -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Instansi</label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="text"
                                            class="form-control form-control-lg form-control-solid"
                                            wire:model="instansi" />
                                    </div>
                                </div>

                                <!-- Handphone -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                        <span class="required">Handphone</span>
                                        <i class="fas fa-exclamation-circle ms-1 fs-7"
                                        data-bs-toggle="tooltip"
                                        title="Phone number must be active"></i>
                                    </label>
                                    <div class="col-lg-8 fv-row">
                                        <input type="tel"
                                            class="form-control form-control-lg form-control-solid"
                                            wire:model="no_hp" />
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="row mb-6">
                                    <label class="col-lg-4 col-form-label required fw-semibold fs-6">Alamat</label>
                                    <div class="col-lg-8 fv-row">
                                        <textarea class="form-control form-control-lg form-control-solid"
                                                rows="3"
                                                wire:model="alamat_user"></textarea>
                                    </div>
                                </div>

                            </div>

                            <!--end::Card body-->
                            <!--begin::Actions-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                                <button type="button"
                                        wire:click="save"
                                        class="btn btn-primary"
                                        id="kt_account_profile_details_submit">
                                    Simpan
                                </button>

                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Basic info-->
                <!--begin::Sign-in Method-->
                <div class="card mb-5 mb-xl-10">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Metode Login</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_settings_signin_method" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Email Address-->
                            <div class="d-flex flex-wrap align-items-center">
                                <!--begin::Label-->
                                <!-- Email Lama (hidden saat edit) -->
                                <div id="kt_signin_email" class="{{ $editEmail ? 'd-none' : '' }}">
                                    <div class="fs-6 fw-bold mb-1">Email</div>
                                    <div class="fw-semibold text-gray-600">{{ $email }}</div>
                                </div>

                                <!-- Form Edit Email (show saat edit) -->
                                <div id="kt_signin_email_edit" class="flex-row-fluid {{ $editEmail ? '' : 'd-none' }}">
                                    <div class="row mb-6">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <label class="form-label fs-6 fw-bold mb-3">Masukan Email Baru</label>
                                            <input type="email"
                                                class="form-control form-control-lg form-control-solid"
                                                wire:model="email_new" />
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label fs-6 fw-bold mb-3">Konfirmasi Password</label>
                                            <input type="password"
                                                class="form-control form-control-lg form-control-solid"
                                                wire:model="pass_confirm" />
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <button type="button"
                                                class="btn btn-primary me-2 px-6"
                                                wire:click="updateEmail">
                                            Update Email
                                        </button>

                                        <button type="button"
                                                class="btn btn-color-gray-400 btn-active-light-primary px-6"
                                                wire:click="cancelEditEmail">
                                            Batal
                                        </button>
                                    </div>
                                </div>

                                <!-- Tombol Change Email (hidden saat edit) -->
                                <div id="kt_signin_email_button" class="ms-auto {{ $editEmail ? 'd-none' : '' }}">
                                    <button class="btn btn-light btn-active-light-primary"
                                            wire:click="openEditEmail">
                                        Change Email
                                    </button>
                                </div>

                                <!--end::Action-->
                            </div>
                            <!--end::Email Address-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed my-6"></div>
                            <!--end::Separator-->
                            <!--begin::Password-->
                            <div class="d-flex flex-wrap align-items-center mb-10">
                                <!--begin::Label-->
                                <div id="kt_signin_password" class="{{ $editPassword ? 'd-none' : '' }}">
                                    <div class="fs-6 fw-bold mb-1">Password</div>
                                    <div class="fw-semibold text-gray-600">************</div>
                                </div>
                                <!--end::Label-->
                                <!--begin::Edit-->
                                <div id="kt_signin_password_edit" class="flex-row-fluid {{ $editPassword ? '' : 'd-none' }}">
                                    <form class="form" novalidate="novalidate">

                                        <div class="row mb-1">

                                            <div class="col-lg-4">
                                                <label class="form-label fs-6 fw-bold mb-3">Current Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    wire:model="password_current" />
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label fs-6 fw-bold mb-3">New Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    wire:model="password_new" />
                                            </div>

                                            <div class="col-lg-4">
                                                <label class="form-label fs-6 fw-bold mb-3">Confirm Password</label>
                                                <input type="password"
                                                    class="form-control form-control-lg form-control-solid"
                                                    wire:model="password_confirm" />
                                            </div>

                                        </div>

                                        <div class="form-text mb-5">
                                            Password must be at least 8 characters and contain symbols
                                        </div>

                                        <div class="d-flex">
                                            <button type="button"
                                                    class="btn btn-primary me-2 px-6"
                                                    wire:click="updatePassword">
                                                Update Password
                                            </button>

                                            <button type="button"
                                                    class="btn btn-color-gray-400 btn-active-light-primary px-6"
                                                    wire:click="cancelEditPassword">
                                                Cancel
                                            </button>
                                        </div>

                                    </form>
                                </div>

                                <!-- TOMBOL SHOW PASSWORD FORM -->
                                <div id="kt_signin_password_button" class="ms-auto {{ $editPassword ? 'd-none' : '' }}">
                                    <button class="btn btn-light btn-active-light-primary"
                                            wire:click="openEditPassword">
                                        Reset Password
                                    </button>
                                </div>

                                <!--end::Action-->
                            </div>
                            <!--end::Password-->
                           
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->
               
                <!--end::Notifications-->
                <!--begin::Deactivate Account-->
               <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#kt_account_deactivate"
                        aria-expanded="true"
                        aria-controls="kt_account_deactivate">
                        <div class="card-title m-0">
                            <h3 class="fw-bold m-0">Hapus Akun</h3>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Content-->
                    <div id="kt_account_settings_deactivate" class="collapse show">

                        <!--begin::Form-->
                        <div class="form">

                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">

                                <!--begin::Notice-->
                                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24">
                                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"/>
                                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                                        </svg>
                                    </span>

                                    <div class="d-flex flex-stack flex-grow-1">
                                        <div class="fw-semibold">
                                            <h4 class="text-gray-900 fw-bold">Anda Akan Menghapus Akun</h4>
                                            <div class="fs-6 text-gray-700">
                                                Penghapusan akun bersifat permanen. Semua data Anda akan dihapus dan tidak dapat dikembalikan.
                                                <br>
                                                <strong>Masukkan password untuk memastikan keamanan.</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Notice-->

                                <!-- Konfirmasi Checkbox -->
                                <div class="form-check form-check-solid fv-row mb-6">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        wire:model="confirm_delete"
                                        id="confirm_delete">
                                    <label class="form-check-label fw-semibold ps-2 fs-6" for="confirm_delete">
                                        Saya yakin ingin menghapus akun saya.
                                    </label>
                                </div>

                                <!-- Password -->
                               @if($show_password)
                                <div class="mb-6">
                                    <label class="form-label fw-semibold fs-6">Masukkan Password</label>
                                    <input type="password"
                                        class="form-control form-control-lg form-control-solid"
                                        placeholder="Password"
                                        wire:model="password_delete">
                                </div>
                                @endif

                            </div>
                            <!--end::Card body-->

                            <!--begin::Card footer-->
                            <div class="card-footer d-flex justify-content-end py-6 px-9">

                                <!-- Tombol Hapus Akun -->
                              <div class="card-footer d-flex justify-content-end py-6 px-9">

                                @if(!$show_password)
                                    <!-- Tombol pertama (tampilkan password) -->
                                    <button type="button"
                                            wire:click="askPassword"
                                            class="btn btn-danger fw-semibold">
                                        Hapus Akun
                                    </button>
                                @else
                                    <!-- Tombol kedua (hapus akun final) -->
                                    <button type="button"
                                            wire:click="deleteAccount"
                                            wire:loading.attr="disabled"
                                            class="btn btn-danger fw-semibold">

                                        <span wire:loading wire:target="deleteAccount" class="spinner-border spinner-border-sm me-2"></span>
                                        Konfirmasi Hapus Akun
                                    </button>
                                @endif

                            </div>

                            </div>
                            <!--end::Card footer-->

                        </div>
                        <!--end::Form-->

                    </div>
                    <!--end::Content-->
                </div>

                <!--end::Deactivate Account-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
</div>

@push('js')

<script>
    window.addEventListener('show-success', event => {
        console.log(event)
        Swal.fire({
            text: event.detail[0].message,
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    });

      window.addEventListener('show-error', event => {
        Swal.fire({
            text: event.detail[0].message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "OK",
            customClass: { confirmButton: "btn btn-danger" }
        });
    });
</script>


@endpush