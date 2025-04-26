<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editor</title>
</head>

<body>
    <div id="html-editor">
        <textarea name="content" id="editor" cols="30" rows="10" class="ckeditor form-control">
            {!! $page->content !!}
        </textarea>
    </div>
    <button id="save-button" class="btn btn-primary"
        style="background-color: blue; color: white; padding: 5px; margin: 10px;">Opslaan
    </button>
    <button id="cancel-button" class="btn btn-primary"
        style="background-color: red; color: black; padding: 5px; margin: 10px;">Annuleer
    </button>

    <script src="ckeditor/ckeditor.js"></script>
    <script>
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