<x-layout.home>
    <div class="row justify-content-center">
        <div>
            <!-- Display the content based on type -->
            <div class="page-container">
                @if($page->type == 'html')
                    <!-- Render HTML content -->
                    
                    <span>{!! $page->content !!}</span>
                    @elseif($page->type == 'pdf')
                    @php
                        // Assuming $page->content = "test.pdf" (just the filename)
                        $pdfPath = 'pdfs/' . $page->content;
                    @endphp
                
                    @if(file_exists(storage_path('app/public/' . $pdfPath)))
                        <iframe 
                            src="{{ asset('storage/' . $pdfPath) }}" 
                            width="100%" 
                            height="auto" 
                            style="min-height: 100vh;"
                        ></iframe>
                    @else
                        <div class="alert alert-danger">
                            PDF not found: {{ $pdfPath }}
                            <br>Full path: {{ storage_path('app/public/' . $pdfPath) }}
                        </div>
                    @endif
                @endif
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