<x-layout.home>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="page-container">
                @if($page->type == 'HTML')
                    <div class="trix-content">
                        {!! $page->content !!}
                    </div>
                @elseif($page->type == 'PDF')
                    @php
                        $pdfPath = $page->content;
                        $pdfName =  substr($pdfPath,33);
                    @endphp
                
                    @if(file_exists(storage_path('app/public/files/1/' . $pdfName)))
                        <iframe 
                            src="{{ url('/view-pdf/1/'.$pdfName) }}" 
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
                        <a href="{{ route('editor') }}" class="btn btn-primary">
                            Edit Content
                        </a>
                </div>
                @endif
            </div>
        </div>
</x-layout.home>