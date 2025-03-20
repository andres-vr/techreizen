@props(['currentStep' => 1])

<div class="mb-4">
    
    <div class="d-flex justify-content-between position-relative registration-steps">
        <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
            <div class="step-circle">1</div>
            <div class="step-text">Basisgegevens</div>
        </div>
        <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
            <div class="step-circle">2</div>
            <div class="step-text">Persoonlijke gegevens</div>
        </div>
        <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
            <div class="step-circle">3</div>
            <div class="step-text">Contact gegevens</div>
        </div>
        
        <!-- Progress line -->
        <div class="progress-line">
            <div class="progress-completed" style="width: {{ $currentStep == 1 ? 15 : ($currentStep == 2 ? 50 : 85) }}%"></div>
        </div>
    </div>
</div>

<style>
.registration-steps {
    padding: 0 20px;
    margin-bottom: 30px;
}

.step {
    text-align: center;
    z-index: 1;
    width: 33%;
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    border: 2px solid #e9ecef;
    color: #6c757d;
    font-weight: bold;
    transition: all 0.3s;
}

.step.active .step-circle {
    background-color: #0d6efd;
    border-color: #0d6efd;
    color: white;
}

.step-text {
    font-size: 0.9rem;
    color: #6c757d;
}

.step.active .step-text {
    color: #0d6efd;
    font-weight: bold;
}

.progress-line {
    position: absolute;
    height: 4px;
    background-color: #e9ecef;
    top: 20px;
    left: 40px;
    right: 40px;
    z-index: 0;
}

.progress-completed {
    height: 100%;
    background-color: #0d6efd;
    transition: width 0.3s;
}
</style>
