{{-- filepath:
c:\Users\lucas\Downloads\Laragon\www\techreizen\resources\views\guest\registration\personal-info.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ __('Registratie - Persoonlijke Informatie') }}</span>
                        </div>
                    </div>

                    <div class="card-body">
                        <x-registration-progress :currentStep="2" />

                        <form method="POST" action="{{ route('guest.registration.personal-info.submit') }}">
                            @csrf

                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">{{ __('Persoonlijke Informatie') }}</h5>
                            </div>

                            <div class="row mb-3">
                                <label for="first_name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Voornaam*') }}</label>
                                <div class="col-md-6">
                                    <input id="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                                        value="{{ old('first_name', $registration->first_name ?? '') }}" required>
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="last_name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Achternaam*') }}</label>
                                <div class="col-md-6">
                                    <input id="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                                        value="{{ old('last_name', $registration->last_name ?? '') }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Geslacht*') }}</label>
                                <div class="col-md-6">
                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror"
                                        name="gender" required>
                                        <option value="">{{ __('-- Selecteer Geslacht --') }}</option>
                                        <option value="male" {{ (old('gender', $registration->gender ?? '') == 'male') ? 'selected' : '' }}>Man</option>
                                        <option value="female" {{ (old('gender', $registration->gender ?? '') == 'female') ? 'selected' : '' }}>Vrouw</option>
                                        <option value="other" {{ (old('gender', $registration->gender ?? '') == 'other') ? 'selected' : '' }}>Anders</option>
                                    </select>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="date_of_birth"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Geboortedatum*') }}</label>
                                <div class="col-md-6">
                                    <input id="date_of_birth" type="date"
                                        class="form-control @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth"
                                        value="{{ old('date_of_birth', $registration->date_of_birth ?? '') }}" required>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="place_of_birth"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Geboorteplaats*') }}</label>
                                <div class="col-md-6">
                                    <input id="place_of_birth" type="text"
                                        class="form-control @error('place_of_birth') is-invalid @enderror"
                                        name="place_of_birth"
                                        value="{{ old('place_of_birth', $registration->place_of_birth ?? '') }}" required>
                                    @error('place_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="nationality"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Nationaliteit') }}</label>
                                <div class="col-md-6">
                                    <input id="nationality" type="text"
                                        class="form-control @error('nationality') is-invalid @enderror" name="nationality"
                                        value="{{ old('nationality', $registration->nationality ?? '') }}" required>
                                    @error('nationality')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 mt-4">
                                <h5 class="border-bottom pb-2">{{ __('Adresinformatie') }}</h5>
                            </div>

                            <div class="row mb-3">
                                <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Adres*') }}</label>
                                <div class="col-md-6">
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror" name="address"
                                        value="{{ old('address', $registration->address ?? '') }}" required>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('Stad*') }}</label>
                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city', $registration->city ?? '') }}" required>
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="country" class="col-md-4 col-form-label text-md-end">{{ __('Land*') }}</label>
                                <div class="col-md-6">
                                    <input id="country" type="text"
                                        class="form-control @error('country') is-invalid @enderror" name="country"
                                        value="{{ old('country', $registration->country ?? '') }}" required>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="{{ route('guest.registration.basic-info') }}" class="btn btn-secondary me-2">
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