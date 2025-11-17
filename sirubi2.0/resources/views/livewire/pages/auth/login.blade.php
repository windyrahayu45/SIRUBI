<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    
    <form id="login_form" class="form w-100" novalidate>
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
            <div class="text-gray-500 fw-semibold fs-6">Masuk ke akun anda</div>
        </div>
        <!--end::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-8">
            <input type="email"
                   wire:model.defer="form.email"
                   placeholder="Email"
                   class="form-control bg-transparent @error('form.email') is-invalid @enderror"
                   required autofocus>
            @error('form.email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>

        <div class="fv-row mb-3">
            <input type="password"
                   wire:model.defer="form.password"
                   placeholder="Password"
                   class="form-control bg-transparent @error('form.password') is-invalid @enderror"
                   required>
            @error('form.password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
        </div>
        <!--end::Input group-->

        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <label class="form-check form-check-sm form-check-custom form-check-solid">
                {{-- <input class="form-check-input" type="checkbox" wire:model="form.remember" />
                <span class="form-check-label">Remember me</span> --}}
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-primary fs-6">Forgot Password?</a>
            @endif
        </div>

        <!--begin::Submit button-->
       <div class="d-grid mb-10">
            <button type="button" class="btn btn-custom-red" id="btnLogin" wire:loading.attr="disabled">
                <span wire:loading.remove>Sign In</span>
                <span wire:loading>Mohon Tunggu...</span>
            </button>
        </div>

        <!--end::Submit button-->
    </form>
</div>

