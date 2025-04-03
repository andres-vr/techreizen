<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document Editor</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f1f1f1;
        }
        
        .editor-container {
            display: flex;
            min-height: 100vh;
            margin: 50px 300px;
        }
        
        .left-sidebar {
            width: 60px;
            background-color: #f8f9fa;
            border-right: 1px solid #e0e0e0;
        }
        
        .editor-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .right-sidebar {
            width: 60px;
            background-color: #f8f9fa;
            border-left: 1px solid #e0e0e0;
        }
        
        .toolbar-container {
            position: sticky;
            top: 0;
            z-index: 100;
            background: white;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            padding: 8px 16px;
            display: flex;
            flex-wrap: wrap;
        }
        
        .toolbar-group {
            display: flex;
            margin-right: 15px;
            border-right: 1px solid #e0e0e0;
            padding-right: 15px;
            align-items: center;
        }
        
        .toolbar-group:last-child {
            border-right: none;
            margin-right: 0;
        }
        
        .toolbar-button {
            background: none;
            border: none;
            padding: 6px 8px;
            margin: 0 2px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .toolbar-button:hover {
            background-color: #f1f1f1;
        }
        
        .toolbar-button.active {
            background-color: #e8f0fe;
            color: #1967d2;
        }
        
        .toolbar-select {
            padding: 6px 8px;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
            margin: 0 2px;
        }
        
        .document-container {
            flex-grow: 1;
            padding: 20px 0;
            overflow-y: auto;
            display: flex;
            justify-content: center;
            background-color: #f1f1f1;
        }
        
        .document-editor {
            width: 21cm;
            min-height: 29.7cm;
            padding: 1.5cm 2cm;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            outline: none;
        }
        
        .font-dropdown {
            width: 120px;
        }
        
        .font-size-dropdown {
            width: 80px;
        }
        
        #imageUpload {
            display: none;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <textarea name="content" id="content" cols="30" rows="10" class="ckeditor form-control" placeholder="Enter post content here...">
        <div class="document-container">
            <div class="document-editor" id="editor" contenteditable="true">
                {!! $page->content !!}  <!-- Hier wordt de database content geladen -->
            </div>
            
            <div class="document-container">
                <div class="document-editor" id="editor" contenteditable="true">
                    <h1 style="font-size:24px; font-family:'Roboto'; margin-bottom:12px;">My Document</h1>
                    <p style="font-size:11px; font-family:'Roboto'; line-height:1.5; margin-bottom:12px;">
                        This is a clean document editor with all working features.
                    </p>
                    <p style="font-size:11px; font-family:'Roboto'; line-height:1.5;">
                        Select text and use the toolbar to format your content.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="right-sidebar">
            <!-- Space for future elements -->
        </div>
    </div>

    <script>
        // Formatting functions
        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            document.getElementById('editor').focus(); // Keep focus on editor
        }
        
        // Toolbar button event listeners
        document.getElementById('boldBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('bold');
        });
        
        document.getElementById('italicBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('italic');
        });
        
        document.getElementById('underlineBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('underline');
        });
        
        document.getElementById('strikeBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('strikeThrough');
        });
        
        document.getElementById('alignLeftBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('justifyLeft');
        });
        
        document.getElementById('alignCenterBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('justifyCenter');
        });
        
        document.getElementById('alignRightBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('justifyRight');
        });
        
        document.getElementById('justifyBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('justifyFull');
        });
        
        document.getElementById('numberedListBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('insertOrderedList');
        });
        
        document.getElementById('bulletedListBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('insertUnorderedList');
        });
        
        document.getElementById('increaseIndentBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('indent');
        });
        
        document.getElementById('decreaseIndentBtn').addEventListener('click', (e) => {
            e.preventDefault();
            formatText('outdent');
        });
        
        // Font family and size
        document.getElementById('fontFamily').addEventListener('change', function() {
            formatText('fontName', this.value);
        });
        
        document.getElementById('fontSize').addEventListener('change', function() {
            formatText('fontSize', this.value);
        });
        
        // Link functionality
        document.getElementById('linkBtn').addEventListener('click', (e) => {
            e.preventDefault();
            const url = prompt('Enter the URL:');
            if (url) {
                formatText('createLink', url);
            }
        });
        
        // Image upload functionality
        document.getElementById('imageBtn').addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('imageUpload').click();
        });
        
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            // Check file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, or GIF)');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                
                // Insert image at cursor position
                const selection = window.getSelection();
                if (selection.rangeCount) {
                    const range = selection.getRangeAt(0);
                    range.deleteContents();
                    range.insertNode(img);
                } else {
                    document.getElementById('editor').appendChild(img);
                }
                
            };
            reader.readAsDataURL(file);
        });
        
        // Focus the editor on load
        document.getElementById('editor').focus();
    </script>
</body>
</html>