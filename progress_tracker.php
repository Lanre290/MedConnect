<?php
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="fontawesome-free-6.4.2-web\css\all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" type = "module" defer></script>
    <script src="progress_tracker.js" type = "module" defer></script>
    <title>MedConnect | Progress Tracker</title>
</head>
<body>
    <?php 
        
        include_once "server/header.php";
        include_once "server/db.php";
        $id = $_SESSION['id'];

    ?>

    <div class="flex-column">
        <div class="pt_top_label">Progress Tracker</div>

        <div class="flex-row space-between mobile-flex-column">
            <div class="flex-row mobile-flex-column">
                <select name="tracked_items" class = "pt_dropdown" id = "current_progress">
                    <option value="blood_Pressure">Blood pressure</option>
                    <option value="calories">Calories</option>
                    <option value="glucose">Glucose</option>
                    <option value="waters">Waters</option>
                    <div id = "user_additional_progress">
                        <?php 
                            $added_progress_query = mysqli_query($conn, "SELECT * FROM user_progress WHERE user_id = '$id'");
                            while($assoc = mysqli_fetch_assoc($added_progress_query)){
                                echo '<option value="'.$assoc['progress_value'].'">'.$assoc['progress'].'</option>';
                            }
                        ?>
                    </div>
                </select>
                <div class="flex-row align-center mobile-ml-25">
                    <button class="add_new_pt placcard" id = "tp_enter_new_value">Enter Value</button>
                    <button class="tp_add_new_close_btn mobile-ml-10" title= "refresh" id = "refresh-graph-btn"><i class="fa fa-refresh"></i></button>
                </div>
            </div>
            <button class="add_new_pt placcard" id = "track_new_progress_btn">Track new Progress</button>
        </div>

        <div class="pt_chart_area" id = "pt_chart_area">
            <canvas id="progress_chart">
                
            </canvas>
        </div>

    </div>

    <div class="black_cont" id = "tp_add_new_bc">
        <div class="track_new_progress_dialog flex-column">
            <div class="flex-row space-between">
                <div></div>
                <div class="tp_add_new_label">Track new progress</div>
                <button class="tp_add_new_close_btn" id = "tp_add_new_close_btn"> <i class="fa fa-close"></i> </button>
            </div>

            <input type="text" class="custom_input tp_inputs" id = "tp_add_new_input" placeholder = "Name">

            <button class="add_new_pt placcard m-auto" id = "tp_add_new_submit_btn">Ok</button>

        </div>
    </div>


    <div class="black_cont" id = "tp_ent_val_bc">
        <div class="track_new_progress_dialog flex-column">
            <div class="flex-row space-between">
                <div></div>
                <div class="tp_add_new_label">Enter new Value</div>
                <button class="tp_add_new_close_btn" id = "tp_ent_val_close_btn"> <i class="fa fa-close"></i> </button>
            </div>

            <input type="number" id = "tp_add_new_value" class="custom_input" placeholder = "Value" />
            <input type="text" id = "tp_add_new_desc" class="custom_input tp_inputs" placeholder = "Description"/>

            <button class="add_new_pt placcard m-auto" id = "tp_add_new_submit">Ok</button>

        </div>
    </div>

    <?php 
        include_once "server/error.php"; 
        include_once "server/loading_screen.php";

        if(isset($_GET['p'])){
            $progress = $_GET['p'];

            echo '<script>document.getElementById("current_progress").value = "'.$progress.'";</script>';
        }
    ?>
</body>
</html>