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
                            height="1250px"
                            style="border: 1px solid #ddd;"
                        ></iframe>
                    @else
                        <div class="alert alert-danger">
                            PDF not found: {{ $pdfPath }}
                        </div>
                    @endif
                @endif
                
                @if(Auth::check() && Auth::user()->role === 'admin')
                 <div class="mt-4">
                    @if (route('home') == url()->current())
                        <a href="{{ route('editor') }}" class="btn btn-primary">
                            Edit Content
                        </a>
                    @else
                    <a href="{{ route('editor-all') }}" class="btn btn-primary">
                        Edit Content
                    </a>    
                    @endif
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout.home>