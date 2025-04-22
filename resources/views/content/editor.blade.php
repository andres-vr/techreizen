<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editor</title>
</head>

<body>
    <textarea name="content" id="content" cols="30" rows="10" class="ckeditor form-control" placeholder="Enter post content here...">
        <div class="document-container">
            <div class="document-editor" id="editor" contenteditable="true">
                {!! $page->content !!}  <!-- Hier wordt de database content geladen -->
            </div>
            
        </div>
    </textarea>
    
    <script src="ckeditor/ckeditor.js"></script>
        <button id="save-button" class="btn btn-primary"
            style="background-color: blue; color: white; padding: 5px; margin: 10px;">Opslaan</button>
    <div id="content-type" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px;">
        <p>Select the content type:</p>
        <select id="content-select" name="content_type">
            <option value="HTML">HTML</option>
            <option value="PDF">PDF</option>
        </select>
    </div>
    <div id="html-editor">
        <textarea name="content" id="editor" cols="30" rows="10" class="ckeditor form-control">
            {!! $page->content !!}
        </textarea>
    </div>
    <div id="pdf-chooser">
        <div id=pdf-container>
            <div id="pdf-main">
                <h1>Choose a PDF file to upload:</h1>
                <button type="button" id="lfm-btn" class="btn btn-secondary">Choose PDF</button>
                <input id="pdf-path" name="pdf_path" type="text" readonly style="width: 300px;" />
                <br>
                <label><input type="checkbox" name="pdf_Visable">Maak pdf zichtbaar</label>
            </div>
        </div>
    </div>
    <button id="save-button" class="btn btn-primary"
        style="background-color: blue; color: white; padding: 5px; margin: 10px;">Opslaan
    </button>
    <button id="cancel-button" class="btn btn-primary"
        style="background-color: lightgray; color: black; padding: 5px; margin: 10px;">Annuleer
    </button>

    <script src="ckeditor/ckeditor.js"></script>
    <script>
        // Select HTML or PDF
        const select = document.getElementById('content-select');
        const htmlEditor = document.getElementById('html-editor');
        const pdfChooser = document.getElementById('pdf-chooser');

        htmlEditor.style.display = "block";
        pdfChooser.style.display = "none";

        select.addEventListener('change', function() {
            updateEditorView();
        });

        function updateEditorView() {
            const value = select.value;
            if (value === "HTML") {
                htmlEditor.style.display = "block";
                pdfChooser.style.display = "none";
                console.log("HTML");
            }

            if (value === "PDF") {
                htmlEditor.style.display = "none";
                pdfChooser.style.display = "block";
                console.log("PDF");
            }
        }

        // Focus the editor on load
        document.getElementById('html-editor').focus();

        // UniSharp file manager
        document.getElementById('lfm-btn').addEventListener('click', function() {
            console.log("hi");
            window.open('/laravel-filemanager?type=file', 'FileManager', 'width=900,height=600');
            window.SetUrl = function(url) {
                document.getElementById('pdf-path').value = url;
            };
        });

        document.getElementById('save-button').addEventListener('click', function() {
            const content = CKEDITOR.instances.editor.getData(); // gebruik CKEditor API!

            fetch("{{ route('editor.save') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        content: content,
                        page_id: {{ $page->id }}
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error("Failed to save");
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                })
                .catch(error => {
                    alert("Error: " + error.message);
                });
        });
    </script>
</body>

</html>