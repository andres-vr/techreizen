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
</x-layout.home>