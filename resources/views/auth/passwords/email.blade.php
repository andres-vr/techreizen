@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Wachtwoord herstellen') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" id="reset-form">
                        @csrf

                        <div class="row mb-3">
                            <label for="studentnumber" class="col-md-4 col-form-label text-md-end">{{ __('Studentnummer') }}</label>

                            <div class="col-md-6">
                                <input id="studentnumber" type="text" class="form-control @error('studentnumber') is-invalid @enderror" 
                                       name="studentnumber" value="{{ old('studentnumber') }}" required pattern="[rubRUB][0-9]{7}" 
                                       title="Moet beginnen met r, u of b en gevolgd worden door 7 cijfers" autofocus>
                                
                                @error('studentnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <small class="form-text text-muted">Moet beginnen met r, u of b en gevolgd worden door 7 cijfers.</small>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    {{ __('Verstuur herstelmail') }}
                                </button>
                                <div id="loading-message" class="alert alert-info mt-3" style="display: none;">
                                    Verzoek wordt verwerkt... Je wordt doorgestuurd naar de loginpagina.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('reset-form').addEventListener('submit', function(event) {
    const studentNumberInput = document.getElementById('studentnumber');
    const pattern = /^[rub][0-9]{7}$/i;
    
    if (!pattern.test(studentNumberInput.value)) {
        event.preventDefault();
        studentNumberInput.classList.add('is-invalid');
        return;
    }
    
    document.getElementById('submit-btn').disabled = true;
    document.getElementById('loading-message').style.display = 'block';
});
</script>
@endsection
