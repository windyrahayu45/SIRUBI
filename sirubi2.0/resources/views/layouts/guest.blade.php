

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/logo.png') }}" />
    <title>{{ config('app.name', 'SIRUBI') }} | Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <style>

        .btn-custom-red {
            background-color: rgb(169, 88, 88) !important;
            border-color: rgb(169, 88, 88) !important;
            color: #fff !important;
            transition: 0.25s ease;
        }

        .btn-custom-red:hover,
        .btn-custom-red:focus,
        .btn-custom-red:active {
            background-color: rgb(142, 60, 60) !important; /* lebih gelap */
            border-color: rgb(142, 60, 60) !important;
            color: #fff !important;
        }

        .btn-custom-red:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

    </style>
    @livewireStyles
</head>

<body id="kt_body" class="app-blank app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            <!--begin::Aside-->
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
                style="background-image: url('{{ asset('assets/media/misc/auth-bg.png') }}')">
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <a href="#" class="mb-0">
                        <img alt="Logo" src="{{ asset('assets/media/logos/logo.png') }}" class="h-90px h-lg-195px" />
                    </a>


                    <h1 class="text-white fs-2qx fw-bolder text-center mb-7">SIRUBI</h1>

                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('assets/media/misc/auth-screens.png') }}" alt="" />
                    <h3 class="text-white  fw-bolder text-center mb-7">Sistem Informasi Rumah  <b>Kota Bukittinggi</b></h3>
                    <div class="text-white fs-base text-center" >
                         Menata data, memetakan rumah, dan mewujudkan Kota Bukittinggi<br> 
                         yang tertata, layak huni, dan berkelanjutan.
                    </div>
                </div>
            </div>
            <!--end::Aside-->
        </div>
    </div>

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

   <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('btnLogin');
        btn.addEventListener('click', function () {
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'login'})
                .then(function(token) {
                    const component = Livewire.find(btn.closest('[wire\\:id]').getAttribute('wire:id'));
                    component.set('form.recaptcha_token', token)
                        .then(() => component.call('login'));
                });
            });
        });
    });
    </script>



    @livewireScripts
</body>
</html>

