<x-layout.home>
    <div class="row justify-content-center">
        <div>

            <!-- Display the content based on type -->
            <div>
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
                            height="500px"
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
</x-layout.home>