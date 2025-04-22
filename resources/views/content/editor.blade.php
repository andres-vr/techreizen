<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editor</title>
</head>

<body>
    <div id="content-type" style="display: flex; gap: 10px; margin-bottom: 20px; margin-left: 200px;">
        <p>Select the content type:</p>
        <select id="content-select" name="content_type">
            <option value="HTML">HTML</option>
            <option value="PDF">PDF</option>
        </select>
    </div>
    <div id="html-editor">
        <textarea name="content" id="content" cols="30" rows="10" class="ckeditor form-control "
            placeholder="Enter post content here...">
        <div class="document-container">
            <div class="document-editor" id="editor" contenteditable="true" >
                {!! $page->content !!}  <!-- Hier wordt de database content geladen -->
            </div>
            
        </div>
        </textarea>
    </div>    
    
        <button id="save-button" class="btn btn-primary"
            style="background-color: blue; color: white; padding: 5px; margin: 10px;">Opslaan</button>

        <div id="pdf-chooser">
            <div id=pdf-container>
                <div id="pdf-main">
                    <h1>Choose a PDF file to upload:</h1>
                    <input type="file" id="pdf-select" name="pdf-select" accept=".pdf" />
                    <br>
                    <label><input type="checkbox" name="pdf_Visable">Maak pdf zichtbaar</label>
                </div>
            </div>
        </div>

        <script src="ckeditor/ckeditor.js"></script>
        <script>
            // Focus the editor on load
            document.getElementById('editor').focus();

            // Select HTML or PDF
            document.getElementById('content-select').addEventListener('change', function() {
                const htmlEditor = document.getElementById('html-editor');
                const pdfChooser = document.getElementById('pdf-chooser');

                if ('option' === 'HTML') {
                    htmlEditor.style.display = 'block';
                    pdfChooser.style.display = 'none';
                    console.log('HTML selected');
                } else {
                    htmlEditor.style.display = 'none';
                    pdfChooser.style.display = 'block';
                    console.log('PDF selected');
                }
            });
        </script>
</body>

</html>
