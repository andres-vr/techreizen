@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Registratie - Basisgegevens') }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <x-registration-progress :currentStep="1" />
                    
                    <form method="POST" action="{{ route('guest.registration.basic-info.submit') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2">{{ __('Reis & Opleiding Details') }}</h5>
                        </div>

                        <div class="row mb-3">
                            <label for="trip" class="col-md-4 col-form-label text-md-end">{{ __('Reis*') }}</label>
                            <div class="col-md-6">
                                <select id="trip" class="form-control @error('trip') is-invalid @enderror" 
                                       name="trip" required>
                                    <option value="">-- Selecteer Reis --</option>
                                    <option value="london" {{ old('trip', $registration->trip) == 'london' ? 'selected' : '' }}>London</option>
                                    <option value="paris" {{ old('trip', $registration->trip) == 'paris' ? 'selected' : '' }}>Paris</option>
                                    <option value="berlin" {{ old('trip', $registration->trip) == 'berlin' ? 'selected' : '' }}>Berlin</option>
                                    <option value="rome" {{ old('trip', $registration->trip) == 'rome' ? 'selected' : '' }}>Rome</option>
                                </select>
                                @error('trip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- HIER CHECKEN OP R, U, B NUMMER -->
                        <div class="row mb-3">
                            <label for="student_number" class="col-md-4 col-form-label text-md-end">{{ __('Studentnummer*') }}</label>
                            <div class="col-md-6">
                                <input id="student_number" type="text" class="form-control @error('student_number') is-invalid @enderror" 
                                       name="student_number" value="{{ old('student_number', $registration->student_number) }}" required>
                                @error('student_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- HIER LATER EEN DROPDOWN MENU VAN MAKEN DIE GEGEVENS UIT DE DATABASE HAALT -->
                        <div class="row mb-3">
                            <label for="education" class="col-md-4 col-form-label text-md-end">{{ __('Opleiding*') }}</label>
                            <div class="col-md-6">
                                <input id="education" type="text" class="form-control @error('education') is-invalid @enderror" 
                                       name="education" value="{{ old('education', $registration->education) }}" required>
                                @error('education')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- HIER LATER EEN DROPDOWN MENU VAN MAKEN DIE GEGEVENS UIT DE DATABASE HAALT -->
                        <div class="row mb-3">
                            <label for="major" class="col-md-4 col-form-label text-md-end">{{ __('Afstudeerrichting*') }}</label>
                            <div class="col-md-6">
                                <input id="major" type="text" class="form-control @error('major') is-invalid @enderror" 
                                       name="major" value="{{ old('major', $registration->major) }}" required>
                                @error('major')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
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