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
</body>

</html>
