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
                                @else
                                    <small class="form-text text-muted">Moet beginnen met r, u of b en gevolgd worden door 7 cijfers.</small>
                                @enderror
                            </div>
                        </div>

                        <!-- HIER LATER EEN DROPDOWN MENU VAN MAKEN DIE GEGEVENS UIT DE DATABASE HAALT -->
                        <div class="row mb-3">
                            <label for="education" class="col-md-4 col-form-label text-md-end">{{ __('Opleiding*') }}</label>
                            <div class="col-md-6">
                                <select id="education" class="form-control @error('education') is-invalid @enderror" 
                                       name="education" required>
                                    <option value="">-- Selecteer Opleiding --</option>
                                    <option value="elo_ict" {{ old('education', $registration->education) == 'elo_ict' ? 'selected' : '' }}>ELO-ICT</option>
                                </select>
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
                                <select id="major" class="form-control @error('major') is-invalid @enderror" 
                                       name="major" required>
                                    <option value="">-- Selecteer Afstudeerrichting --</option>
                                    <option value="ict" {{ old('major', $registration->major) == 'ict' ? 'selected' : '' }}>ICT</option>
                                </select>
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

<script>
    // Client side Validation 
    document.addEventListener('DOMContentLoaded', function () {
        const studentNumberInput = document.getElementById('student_number');
        const form = studentNumberInput.closest('form');
        
        // Only validate on form submission
        form.addEventListener('submit', function (event) {
            const pattern = /^[rub]\d{7}$/;  // Case insensitive regex
            
            // Reset any previous visual styling
            studentNumberInput.classList.remove('is-invalid');
            
            // Only validate client-side if there's no server validation error already
            if (!studentNumberInput.classList.contains('is-invalid') && !pattern.test(studentNumberInput.value)) {
                event.preventDefault();
                studentNumberInput.classList.add('is-invalid');
                
                // Focus on the field with error
                studentNumberInput.focus();
            }
        });
        
        // Remove invalid class on input to provide immediate feedback
        studentNumberInput.addEventListener('input', function () {
            const pattern = /^[rub]\d{7}$/;
            if (pattern.test(studentNumberInput.value)) {
                studentNumberInput.classList.remove('is-invalid');
            }
        });
    });
</script>
