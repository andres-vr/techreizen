<x-layout.home>

    <div class = "row justify-content-center">
        <div class="text-center">
            <div id="images" class="carousel slide carousel-fade" data-bs-ride="carousel">
                <!-- slideshow images -->
                <div class="carousel-inner mx-auto">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/header1.jpg') }}" class="img-fluid " alt="header 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/header2.jpg') }}" class="img-fluid " alt="header 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/header3.jpg') }}" class="img-fluid " alt="header 2">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center p-2">
        <div class="pt-3">
            <div class="px-5 mx-auto">
                <span> <h1>{{ $page->name }}</h1></span>
            </div>
            <div class="px-5">
                <span > {{ $page->content }}</span>
            </div>
          </div>
    </div>
</x-layout.home>
