@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Registratie - Contactinformatie') }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <x-registration-progress :currentStep="3" />

                    <form method="POST" action="{{ route('guest.registration.contact-info.submit') }}">
                        @csrf

                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">{{ __('Contactinformatie') }}</h5>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-mailadres*') }}</label>
                            <div class="col-md-6 d-flex align-items-center">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $registration->email ?? '') }}" required>
                                <span class="ms-2">@student.ucll.be</span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Telefoonnummer*') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       name="phone" value="{{ old('phone', $registration->phone ?? '') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="emergency_contact" class="col-md-4 col-form-label text-md-end">{{ __('Noodcontact*') }}</label>
                            <div class="col-md-6">
                                <input id="emergency_contact" type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                       name="emergency_contact" value="{{ old('emergency_contact', $registration->emergency_contact ?? '') }}" required>
                                @error('emergency_contact')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('guest.registration.personal-info') }}" class="btn btn-secondary me-2">
                                    {{ __('Vorige') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Volgende') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
