<x-layout.home>
  
    <div class="row justify-content-center p-2">
        <div class="pt-3">
            <div class="px-5 mx-auto">
                <span><h1>{{ $page->name }}</h1></span>
            </div>
            <div class="px-5">
                <span>{!! $page->content !!}</span>
            </div>
        </div>
    </div>
    <div class="row justify-content-center p-2">
        <div class="pt-3">
              
            <div class="px-5 pb-5 pt-4 border-b border-t border-r border-l border-gray-600 rounded-md">
                <span class="bg-white px-3 text-sm font-medium"> {{ $page }}</span>
            </div>
          </div>

       
    </div>
</x-layout.home>