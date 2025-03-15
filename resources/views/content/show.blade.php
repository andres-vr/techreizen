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
              
            <div class="px-5 pb-5 pt-4 border-b border-t border-r border-l border-gray-600 rounded-md">
                <span class="bg-white px-3 text-sm font-medium"> {{ $page->content }}</span>
            </div>
          </div>

       
    </div>
</x-layout.home>