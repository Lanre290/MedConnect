<?php
    session_start();
    header("Access-Control-Allow-Origin: *");
    // header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    // header("Access-Control-Allow-Headers: Content-Type, Authorization");
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        exit(0);
    }
    

?>

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
        include_once "server/popup_notif.php";
    ?>
    <div class="flex-column" id = "home_div">
        <div class="pt_top_label primary-color-text"><i class="fa fa-robot"></i> MedConnect AI</div>

        <div class="flex-row">
            <div class="placcard ai_placcard flex-column justify-center space-evenly">
                <i class="fa fa-search-plus"></i>
                <div class="ai_placcard_text">Analyse Image</div>
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
                <div class="average-size-text flex-row align-center" id = "upload_file_text">Click to Upload or drop images to analyze</div>
                <video src="" id="camera_stream" autoplay></video>
            </div>
            <div class = "flex-row justify-center" id="ai_analyse_image_text">
                <!-- ai generated text -->
            </div>
            <button class="add_new_pt placcard m-auto" id = "take_pic_btn" style = "margin-bottom: 10px;" data-text = "toggle">Toggle camera</button>
            <button class="add_new_pt placcard m-auto" id = "analyse_image_btn" title = "analyse image" disabled>Analyze Image</button>
        </div>
        <div></div>
    </div>

    <div class="flex-column space-between chat_screen" id = "chat_screen">
        <div class="flex-row chat_topnav placcard">
            <button class="tp_add_new_close_btn margin-10" id = "close_chat_btn"><i class="fa fa-chevron-left"></i></button>
            <div class="medium-text flex-row align-center grey-text">Chat With AI</div>
        </div>
        <div class="chat_area" id = "chat_area">
            <div class = "flex-column flex-column-reverse" id="previous_chat_area">

            </div>
        </div>
        <div class="flex-row align-center chat_bottom_nav">
            <textarea type="text" class="chat_input ml-10" id = "chat_input" placeholder = "Message..."></textarea>
            <button class="tp_add_new_close_btn chat_send_btn medium-text margin-10 primary-color-text" id = "chat_send_btn" disabled><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
    
    
</body>
</html>