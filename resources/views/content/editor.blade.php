<x-layout.home>
     <div id="newPageDiv" style="display: flex; flex-direction: row; gap: 10px; margin-left: 165px; margin-bottom: 20px;">
        <form method="POST" action="{{ route('new.page') }}" onsubmit="return handleBlur()">
            @csrf
            <label for="name">Page Name</label>
            <input type="text" id="name" name="name" value="">
            <button type="submit">Create</button>
        </form>
    </div>
    <form method="POST" action="{{ route('editor.save') }}">
    @csrf
    <div id="page-dropdown" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px;">
        <p>Selecteer de pagina:</p>
        <select id="page-select" name="page_id">
            @php
                $pagen = DB::table('pages')->get();
                $currentPageId = $page->id ?? null;

                if (str_ends_with($page->content, ".pdf")) {
                    $page->content = "";
                }
            @endphp
            
            @foreach ($pagen as $pagek)
                @if ($pagek->name != "Hotels")
                    <option value="{{ $pagek->id }}" {{ $previousRoute == $pagek->routename ? 'selected' : '' }}>
                    {{ $pagek->name }}
                    </option>
                @endif
            @endforeach
            <option value="newpage">Nieuwe Pagina</option>
        </select>
    </div>

    <div id="content-type" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px; margin-top: 5px;">
        <p>Select the content type:</p>
        <select id="content-select" name="content_type">
            <option value="HTML">HTML</option>
            <option value="PDF">PDF</option>
        </select>
    </div>
    {{-- HTML editor --}}
    <div id="html-editor">
        <textarea name="content" id="editor" cols="30" rows="10" class="ckeditor form-control">
            {!! $page->content ?? '' !!}
        </textarea>
    </div>
    {{-- PDF chooser --}}
    <div id="pdf-chooser">
        <div id="pdf-container">
            <div id="pdf-main">
                <h1>Choose a PDF file to upload:</h1>
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="button" id="lfm-btn" data-input="pdf-path" data-preview="pdf-preview"
                            class="btn btn-secondary">Choose PDF</button>
                    </span>
                    <input id="pdf-path" name="pdf_path" type="text" readonly class="form-control" />
                </div>
                <div id="pdf-preview" style="margin-top: 15px;"></div>
            </div>
        </div>
    </div>
    
    {{-- Access level --}}
    <div style="margin: 20px 0;">
        <label style="display: block; margin-bottom: 8px; font-weight: bold;">
            Wie mag deze content zien?
        </label>
        <select name="access_level[]" multiple required
                style="width: 100px; height: 100px; padding: 8px; border: 1px solid #ddd;">
            
            <option value="guide">Guide</option>
            <option value="traveller">Traveller</option>
            <option value="guest">Guest</option>
        </select>
        <small style="color: #666;">Hou Ctrl (Windows) of Cmd (Mac) ingedrukt om meerdere opties te selecteren</small>
    </div>

    {{-- Buttons --}}
    <button id="save-button" class="btn btn-primary"
        style="background-color: blue; color: white; padding: 5px; margin: 10px;">Opslaan
    </button>
    <button id="cancel-button" class="btn btn-primary"
        style="background-color: red; color: black; padding: 5px; margin: 10px;">Annuleer
    </button>
</form>

    {{-- CKEditor --}}
    <script src="ckeditor/ckeditor.js"></script>

    <script>
        const select = document.getElementById('content-select');
        const htmlEditor = document.getElementById('html-editor');
        const pdfChooser = document.getElementById('pdf-chooser');
        const pdfPathInput = document.getElementById('pdf-path');

        const nameDiv = document.getElementById('newPageDiv');
        nameDiv.style.display = "none";

        // Backend content ophalen
        const initialContent = `{!! trim($page->content ?? '') !!}`;
        const defaultType = initialContent.toLowerCase().endsWith('.pdf') ? 'PDF' : 'HTML';

        // Initialize CKEditor
        let editorInstance = null;

        function initializeCKEditor() {
            if (editorInstance) {
                editorInstance.destroy();
            }
            CKEDITOR.replace('editor');
            editorInstance = CKEDITOR.instances.editor;
        }

        function updateEditorView() {
            const value = select.value;
            if (value === "HTML") {
                htmlEditor.style.display = "block";
                pdfChooser.style.display = "none";
                
                // Initialize CKEditor if not already done
                if (!editorInstance || editorInstance.status !== 'ready') {
                    setTimeout(initializeCKEditor, 100);
                }
                console.log("HTML");
            } else if (value === "PDF") {
                htmlEditor.style.display = "none";
                pdfChooser.style.display = "block";
                
                // Clear PDF path when switching to PDF mode without content
                if (!pdfPathInput.value) {
                    pdfPathInput.value = '';
                }
                console.log("PDF");
            }
        }

        // Stel selectie en invoer correct in op basis van backend
        window.addEventListener('DOMContentLoaded', function() {
            select.value = defaultType;
            disablePDFifHome();
            nameDiv.style.display = "none";
            
            // Initialize editor based on content type
            updateEditorView();
            
            const previousPageId = {{ $previousId ?? 'null' }};
            console.log("Previous page ID:", previousPageId);
            
            if (previousPageId && previousPageId !== 'null') {
                loadPageContent(previousPageId);
            }
        });

        function loadPageContent(pageId) {
            fetch(`/pages/${pageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.content !== undefined) {
                        if (data.content.toLowerCase().endsWith('.pdf')) {
                            select.value = 'PDF';
                            pdfPathInput.value = data.content.split('/').pop();
                        } else {
                            select.value = 'HTML';
                            // Wait for CKEditor to be ready before setting data
                            setTimeout(() => {
                                if (CKEDITOR.instances.editor && CKEDITOR.instances.editor.status === 'ready') {
                                    CKEDITOR.instances.editor.setData(data.content);
                                } else {
                                    // If editor isn't ready, wait and try again
                                    CKEDITOR.on('instanceReady', function(evt) {
                                        if (evt.editor.name === 'editor') {
                                            evt.editor.setData(data.content);
                                        }
                                    });
                                }
                            }, 200);
                        }
                        updateEditorView();
                    } else {
                        // Clear content if no data
                        if (select.value === 'HTML') {
                            setTimeout(() => {
                                if (CKEDITOR.instances.editor && CKEDITOR.instances.editor.status === 'ready') {
                                    CKEDITOR.instances.editor.setData('');
                                }
                            }, 200);
                        } else {
                            pdfPathInput.value = '';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading page content:', error);
                });
        }

        select.addEventListener('change', updateEditorView);

        document.getElementById('save-button').addEventListener('click', function() {
            const contentType = select.value;
            let content = "";
            alert("De content is opgeslagen!");
            if (contentType === "HTML") {
                content = CKEDITOR.instances.editor.getData();
            } else {
                content = document.getElementById('pdf-path').value;
            }
        });
        
        const pageSelect = document.getElementById('page-select');

        function disablePDFifHome() {
            const contentSelect = document.getElementById('content-select');
            contentSelect.options[1].disabled = false;
            if (pageSelect.value == 1) {
                contentSelect.options[1].disabled = true;
                // If PDF was selected for home page, switch to HTML
                if (contentSelect.value === 'PDF') {
                    contentSelect.value = 'HTML';
                    updateEditorView();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            disablePDFifHome();
        });

        pageSelect.addEventListener('change', function() {
            disablePDFifHome();
            nameDiv.style.display = "none";
            pdfPathInput.value = ''; // Clear PDF path when switching pages
            
            if (this.value == "newpage") {
                console.log("New page selected");
                nameDiv.style.display = "block";
                // Clear editor for new page
                if (CKEDITOR.instances.editor && CKEDITOR.instances.editor.status === 'ready') {
                    CKEDITOR.instances.editor.setData('');
                }
                select.value = 'HTML';
                updateEditorView();
            } else {
                const selectedPageId = this.value;
                loadPageContent(selectedPageId);
            }
        });
    </script>

    {{-- File manager --}}
    <script>
        window.SetUrl = function(items) {
            let fullUrl = Array.isArray(items) ? items[0]?.url : items?.url;
            if (fullUrl) {
                let fileName = fullUrl.split('/').pop();
                document.getElementById('pdf-path').value = fileName;
                console.log("Selected file name:", fileName);
            }
        };
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $(document).ready(function() {
            $('#lfm-btn').filemanager('file', {
                prefix: '/laravel-filemanager'
            });
        });
    </script>

    <script>
        document.getElementById('cancel-button').addEventListener('click', function(e) {
            e.preventDefault();
            const bevestiging = confirm(
                "Weet je zeker dat je wilt annuleren? Alle gewijzigde gegevens zullen verloren gaan!");
            if (bevestiging) {
                history.back(); // ga terug naar de vorige pagina
            }
        });
    </script>

    <script>
    document.querySelector('select[name="access_level[]"]').addEventListener('change', function () {
        const levels = ['admin', 'guide', 'traveller', 'guest'];
        const selectedValues = Array.from(this.selectedOptions).map(opt => opt.value);

        // We maken alle opties eerst on-geselecteerd
        for (const option of this.options) {
            option.selected = false;
        }

        // Bepaal de hoogste prioriteit van de selectie
        let maxIndex = -1;
        for (const value of selectedValues) {
            const index = levels.indexOf(value);
            if (index > maxIndex) {
                maxIndex = index;
            }
        }

        // Selecteer alles tot aan de hoogste index
        for (let i = 0; i <= maxIndex; i++) {
            for (const option of this.options) {
                if (option.value === levels[i]) {
                    option.selected = true;
                    break;
                }
            }
        }
    });
</script>
</x-layout.home>