<x-layout.home>
    {{-- Pagina dropdown --}}
    <div id="page-dropdown" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px;">
        <p>Selecteer de pagina:</p>
        <select id="page-select" name="page_id">
            @php
                $pages = DB::table('pages')->get();
                $currentPageId = $page->id ?? null;
            @endphp

            @foreach ($pages as $pageItem)
                <option value="{{ $pageItem->id }}" @if ($pageItem->id == $currentPageId) selected @endif>
                    {{ $pageItem->name }}
                </option>
            @endforeach

            <option value="newpage">Nieuwe Pagina</option>
        </select>
    </div>

    {{-- Content type selectie --}}
    <div id="content-type" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px;">
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
        <select name="access_level[]" multiple
            style="width: 100px; height: 100px; padding: 8px; border: 1px solid #ddd;">
            <option value="admin">Admin</option>
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

    {{-- CKEditor --}}
    <script src="ckeditor/ckeditor.js"></script>

    <script>
        const select = document.getElementById('content-select');
        const htmlEditor = document.getElementById('html-editor');
        const pdfChooser = document.getElementById('pdf-chooser');
        const pdfPathInput = document.getElementById('pdf-path');

        // Backend content ophalen
        const initialContent = `{!! trim($page->content ?? '') !!}`;
        const defaultType = initialContent.toLowerCase().endsWith('.pdf') ? 'PDF' : 'HTML';

        // Stel selectie en invoer correct in op basis van backend
        window.addEventListener('DOMContentLoaded', function() {
            select.value = defaultType;
            updateEditorView();

            if (defaultType === 'PDF') {
                pdfPathInput.value = initialContent.split('/').pop(); // Alleen bestandsnaam
            }
        });

        select.addEventListener('change', updateEditorView);

        function updateEditorView() {
            const value = select.value;
            if (value === "HTML") {
                htmlEditor.style.display = "block";
                pdfChooser.style.display = "none";
                console.log("HTML");
            } else if (value === "PDF") {
                htmlEditor.style.display = "none";
                pdfChooser.style.display = "block";
                console.log("PDF");
            }
        }

        document.getElementById('save-button').addEventListener('click', function() {
            const contentType = select.value;
            let content = "";

            if (contentType === "HTML") {
                content = CKEDITOR.instances.editor.getData();
            } else {
                content = document.getElementById('pdf-path').value;
            }

            const accessLevels = [];
            const accessSelect = document.querySelector('select[name="access_level[]"]');
            for (const option of accessSelect.options) {
                if (option.selected) {
                    accessLevels.push(option.value);
                }
            }

            fetch("{{ route('editor.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        content: content,
                        page_id: {{ $page->id ?? 'null' }},
                        access_level: accessLevels,
                        type: contentType
                    })
                })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => alert("Error: " + error.message));
        });

        const pageSelect = document.getElementById('page-select');
        if (pageSelect) {
            pageSelect.addEventListener('change', function() {
                const selectedPageId = this.value;
                fetch(`/pages/${selectedPageId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.content !== undefined) {
                            if (data.content.toLowerCase().endsWith('.pdf')) {
                                select.value = 'PDF';
                                pdfPathInput.value = data.content.split('/').pop();
                            } else {
                                select.value = 'HTML';
                                CKEDITOR.instances.editor.setData(data.content);
                            }
                            updateEditorView();
                        }
                    })
                    .catch(error => {
                        alert("Fout bij laden van pagina: " + error.message);
                    });
            });
        }
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
</x-layout.home>
