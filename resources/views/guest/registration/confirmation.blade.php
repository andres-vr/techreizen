@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Registratie - Bevestiging') }}</span>
                    </div>
                </div>

                <div class="card-body">
                    <x-registration-progress :currentStep="4" />

                    <div class="mb-4 alert alert-info">
                        <h5 class="mb-3">{{ __('Bevestig uw gegevens') }}</h5>
                        <p>Controleer of alle gegevens correct zijn voordat u uw registratie bevestigt.</p>
                    </div>

                    <form method="POST" action="{{ route('guest.registration.confirmation.submit') }}">
                        @csrf

                        <!-- Basic Info Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="border-bottom pb-2">{{ __('Basis gegevens') }}</h5>
                                <a href="{{ route('guest.registration.basic-info') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i> {{ __('Bewerken') }}
                                </a>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Reis:') }}</div>
                                <div class="col-md-8">{{ $registration->trip ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Studentnummer:') }}</div>
                                <div class="col-md-8">{{ $registration->student_number ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Opleiding:') }}</div>
                                <div class="col-md-8">
                                    @php
                                        $educationName = 'Niet ingevuld';
                                        if (isset($registration->education)) {
                                            $educationModel = App\Models\Education::find($registration->education);
                                            if ($educationModel) {
                                                $educationName = $educationModel->name;
                                            }
                                        }
                                    @endphp
                                    {{ $educationName }}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Afstudeerrichting:') }}</div>
                                <div class="col-md-8">{{ $registration->major ?? 'Niet ingevuld' }}</div>
                            </div>
                        </div>

                        <!-- Personal Info Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="border-bottom pb-2">{{ __('Persoonlijke gegevens') }}</h5>
                                <a href="{{ route('guest.registration.personal-info') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i> {{ __('Bewerken') }}
                                </a>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Naam:') }}</div>
                                <div class="col-md-8">{{ $registration->first_name ?? '' }} {{ $registration->last_name ?? '' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Geslacht:') }}</div>
                                <div class="col-md-8">
                                    @if(isset($registration->gender))
                                        @if($registration->gender == 'male')
                                            Man
                                        @elseif($registration->gender == 'female')
                                            Vrouw
                                        @else
                                            Anders
                                        @endif
                                    @else
                                        Niet ingevuld
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Geboortedatum:') }}</div>
                                <div class="col-md-8">{{ isset($registration->date_of_birth) ? date('d-m-Y', strtotime($registration->date_of_birth)) : 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Geboorteplaats:') }}</div>
                                <div class="col-md-8">{{ $registration->place_of_birth ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Nationaliteit:') }}</div>
                                <div class="col-md-8">{{ $registration->nationality ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Adres:') }}</div>
                                <div class="col-md-8">{{ $registration->address ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Gemeente:') }}</div>
                                <div class="col-md-8">{{ $registration->city ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Land:') }}</div>
                                <div class="col-md-8">{{ $registration->country ?? 'Niet ingevuld' }}</div>
                            </div>
                        </div>

                        <!-- Contact Info Section -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="border-bottom pb-2">{{ __('Contactgegevens') }}</h5>
                                <a href="{{ route('guest.registration.contact-info') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i> {{ __('Bewerken') }}
                                </a>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('E-mailadres:') }}</div>
                                <div class="col-md-8">{{ $registration->email ?? 'Niet ingevuld' }}</div>
                            </div>
                            @if(isset($registration->secondary_email))
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('E-mailadres 2:') }}</div>
                                <div class="col-md-8">{{ $registration->secondary_email }}</div>
                            </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Telefoon:') }}</div>
                                <div class="col-md-8">{{ $registration->phone ?? 'Niet ingevuld' }}</div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Noodnummer 1:') }}</div>
                                <div class="col-md-8">{{ $registration->emergency_contact ?? 'Niet ingevuld' }}</div>
                            </div>
                            @if(isset($registration->optional_emergency_contact))
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Noodnummer 2:') }}</div>
                                <div class="col-md-8">{{ $registration->optional_emergency_contact }}</div>
                            </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-md-4 text-md-end fw-bold">{{ __('Medische informatie:') }}</div>
                                <div class="col-md-8">
                                    @if(isset($registration->medical_info) && $registration->medical_info == 'yes')
                                        {{ $registration->medical_details ?? 'Geen details opgegeven' }}
                                    @else
                                        Nee
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('terms_accepted') is-invalid @enderror" type="checkbox" value="1" id="terms_accepted" name="terms_accepted" required>
                                <label class="form-check-label" for="terms_accepted">
                                    {{ __('Ik ga akkoord met de') }} <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">{{ __('algemene voorwaarden') }}</a> {{ __('en bevestig dat alle ingevulde gegevens correct zijn.') }}
                                </label>
                                @error('terms_accepted')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('guest.registration.contact-info') }}" class="btn btn-secondary me-2">
                                    {{ __('Vorige') }}
                                </a>
                                <button type="submit" class="btn btn-success">
                                    {{ __('Registratie bevestigen') }} <i class="fas fa-check ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">{{ __('Algemene Voorwaarden') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Algemeen</h6>
                <p>Door deel te nemen aan deze reis, gaat u akkoord met de volgende voorwaarden.</p>
                
                <h6>2. Annulering</h6>
                <p>Bij annulering gelden de volgende voorwaarden:</p>
                <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                    <li>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</li>
                    <li>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                </ul>
                
                <h6>3. Verantwoordelijkheid</h6>
                <p>Deelnemers zijn verantwoordelijk voor hun eigen gedrag en bezittingen tijdens de reis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                
                <h6>4. Privacy</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, justo nec convallis elementum, velit sem tristique diam, vitae hendrerit leo ipsum sit amet massa. Sed eleifend, nunc nec tincidunt ultricies, justo nisl aliquet est, nec malesuada dolor elit eu libero. Sed vitae libero eu sapien efficitur rhoncus. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Sluiten') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection
