<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="fontawesome-free-6.4.2-web\css\all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" type = "module" defer></script>
    <script src="ai.js" type = "module" defer></script>
    <title>MedConnect | AI</title>
</head>
<body>
    <?php
        include_once "server/header.php";
        include_once "server/error.php";
        include_once "server/loading_screen.php";
    ?>
    <div class="flex-column" id = "home_div">
        <div class="pt_top_label primary-color-text"><i class="fa fa-robot"></i> MedConnect AI</div>

        <div class="flex-row space-evenly">
            <div class="placcard ai_placcard flex-column justify-center space-evenly">
                <i class="fa fa-glass-cheers"></i>
                <div class="ai_placcard_text">Scan Food</div>
            </div>
            <div class="placcard ai_placcard flex-column justify-center space-evenly">
                <i class="fa fa-glass-cheers"></i>
                <div class="ai_placcard_text">Scan Drug</div>
            </div>
            <div class="placcard ai_placcard flex-column justify-center space-evenly">
                <i class="fa fa-glass-cheers"></i>
                <div class="ai_placcard_text">Scan Skin</div>
            </div>
            <div class="placcard ai_placcard flex-column justify-center space-evenly" id = "toggle-chat-div">
                <i class="fa fa-comments"></i>
                <div class="ai_placcard_text">Chat with AI</div>
            </div>
        </div>
    </div>

    <div class="flex-row space-between upload_image_div" id="upload_image_div" data-display = "none">
        <button class="tp_add_new_close_btn margin-10" id = "close-image-analyser-div"><i class="fa fa-chevron-left"></i></button>
        <div class="flex-column">
            <div class="upload_div flex-row align-center" id = "upload_div">
                <input type="file" id="image_file_upload_btn" class = "image_file_upload_btn "title = "Choose file to upload">
                <div class="average-size-text" id = "upload_file_text">Click to Upload or drop images to analyze</div>
            </div>
            <button class="add_new_pt placcard m-auto" id = "analyse_image_btn" title = "analyse image" disabled>Analyze Image</button>
        </div>
        <div></div>
    </div>
    
</body>
</html>