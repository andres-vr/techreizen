<x-layout.home>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="page-container">
                @if($page->type == 'html')
                    <div class="trix-content">
                        {!! $page->content !!}
                    </div>
                @elseif($page->type == 'pdf')
                    @php
                        $pdfPath = 'pdfs/' . $page->content;
                    @endphp
                
                    @if(file_exists(storage_path('app/public/' . $pdfPath)))
                        <iframe 
                            src="{{ asset('storage/' . $pdfPath) }}" 
                            width="100%"
                            height="600"
                            style="border: 1px solid #ddd;"
                        ></iframe>
                    @else
                        <div class="alert alert-danger">
                            PDF not found: {{ $pdfPath }}
                        </div>
                    @endif
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('editor') }}" class="btn btn-primary">
                        Edit Content
                    </a>
                </div>
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