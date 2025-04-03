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
        #content-type {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            margin-left: auto;
            margin-right: auto;
            width: 300px;
        }

        #pdf-container {
            display: flex;
            min-height: 100vh;
            margin: 50px 535px;
        }
        #pdf-main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="editor-container">
        <div class="left-sidebar">
            <!-- Space for future buttons -->
        </div>
        
        <div class="editor-main">
            <div class="toolbar-container">
                <div class="toolbar-group">
                    <select class="toolbar-select font-dropdown" id="fontFamily">
                        <option value="Arial">Arial</option>
                        <option value="Calibri">Calibri</option>
                        <option value="Courier New">Courier New</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Roboto" selected>Roboto</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Verdana">Verdana</option>
                    </select>
                    
                    <select class="toolbar-select font-size-dropdown" id="fontSize">
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option selected>11</option>
                        <option>12</option>
                        <option>14</option>
                        <option>16</option>
                        <option>18</option>
                        <option>20</option>
                        <option>22</option>
                        <option>24</option>
                        <option>26</option>
                        <option>28</option>
                        <option>36</option>
                        <option>48</option>
                        <option>72</option>
                    </select>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" id="boldBtn" title="Bold">
                        <i class="material-icons">format_bold</i>
                    </button>
                    <button type="button" class="toolbar-button" id="italicBtn" title="Italic">
                        <i class="material-icons">format_italic</i>
                    </button>
                    <button type="button" class="toolbar-button" id="underlineBtn" title="Underline">
                        <i class="material-icons">format_underlined</i>
                    </button>
                    <button type="button" class="toolbar-button" id="strikeBtn" title="Strikethrough">
                        <i class="material-icons">format_strikethrough</i>
                    </button>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" id="linkBtn" title="Link">
                        <i class="material-icons">insert_link</i>
                    </button>
                    <button type="button" class="toolbar-button" id="imageBtn" title="Insert Image">
                        <i class="material-icons">insert_photo</i>
                    </button>
                    <input type="file" id="imageUpload" accept=".jpg,.jpeg,.png,.gif">
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" id="alignLeftBtn" title="Align left">
                        <i class="material-icons">format_align_left</i>
                    </button>
                    <button type="button" class="toolbar-button" id="alignCenterBtn" title="Align center">
                        <i class="material-icons">format_align_center</i>
                    </button>
                    <button type="button" class="toolbar-button" id="alignRightBtn" title="Align right">
                        <i class="material-icons">format_align_right</i>
                    </button>
                    <button type="button" class="toolbar-button" id="justifyBtn" title="Justify">
                        <i class="material-icons">format_align_justify</i>
                    </button>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" id="numberedListBtn" title="Numbered list">
                        <i class="material-icons">format_list_numbered</i>
                    </button>
                    <button type="button" class="toolbar-button" id="bulletedListBtn" title="Bulleted list">
                        <i class="material-icons">format_list_bulleted</i>
                    </button>
                    <button type="button" class="toolbar-button" id="decreaseIndentBtn" title="Decrease indent">
                        <i class="material-icons">format_indent_decrease</i>
                    </button>
                    <button type="button" class="toolbar-button" id="increaseIndentBtn" title="Increase indent">
                        <i class="material-icons">format_indent_increase</i>
                    </button>
                </div>
                
            </div>
            <div class="document-container">
                <div class="document-editor" id="editor" contenteditable="true">
                    {!! $page->content !!}  <!-- Hier wordt de database content geladen -->
                </div>
                <textarea name="content" id="hiddenContent" style="display:none;"></textarea>
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

        // Select HTML or PDF
        document.getElementById('content-select').addEventListener('change', function() {
        const htmlEditor = document.getElementById('html-editor');
        const pdfChooser = document.getElementById('pdf-chooser');
        
        if (this.value === 'HTML') {
            htmlEditor.style.display = 'block';
            pdfChooser.style.display = 'none';
        } else {
            htmlEditor.style.display = 'none';
            pdfChooser.style.display = 'block';
        }
    });
    </script>
</body>
</html>