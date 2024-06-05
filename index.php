<?php
    session_start();
    if(isset($_GET['u'])){
        $username = $_GET['u'];
        $db = mysqli_connect("localhost","root","","datican");

        $query = mysqli_query($db,"SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($query) < 1){
            header("location: signup.php");
        }
        else{
            $assoc = mysqli_fetch_assoc($query);
            $_SESSION['id'] = $assoc['id'];
            $_SESSION['name'] = $assoc['full_name'];
            $_SESSION['username'] = $assoc['username'];

            $name_arr = explode(" ",$_SESSION['name']);
            $_SESSION['last_name'] = $name_arr[1];
        }
    }
    else{
        if(isset($_SESSION['username'])){
            header("location: index.php?u=".$_SESSION['username']);
        }
        else{
            header("location: signup.php");
        }
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
    <title>MedConnect</title>
</head>
<body>
    <?php 
        include_once "server/header.php";
        include_once "server/floating_div.php";
        include_once "server/popup_notif.php";
    
    ?>
    <style>
        .floating_div_text{
            height: 200px;
            width: 250px;
            padding: 10px;
            overflow-y: auto;
        }
    </style>

    <script type="module">
        import {generateResponse} from './ai_requests.js';
            generateResponse("You are a healthcare professional, give a random advice on health lifestyle, lifestyle changes, nutrition, preventive approaches in medicine. You can also recommend specific exercises. Not more than 50 words.",document.getElementById("floating_div_text"));
            console.log(healthTips);
    </script>
    
    <div class="main_body flex-column">

        <div class="welcome_text">Hello <?php echo $_SESSION['last_name']?></div>

        <div class = "flex-row mobile-flex-column" style = "height: 100%;">
            <div class="lhs_body placcard">
                <?php 
                    include "server/circular_progress.php";
                ?>
            </div>
            <div class="rhs_body flex-column space-between">
                <div class="rhs_deck flex-row space-evenly mobile-flex-column">
                    <a href= <?php echo "progress_tracker.php?u=".$_SESSION['username']."&p=blood_Pressure"; ?> class = "home_tracker_snippet_link">
                        <div class="home_tracker_snippet placcard">
                            <div class="flex-row">
                                <i class="fa fa-heartbeat"></i>
                                Blood pressure
                            </div>

                            <?php 
                                $user_id = $_SESSION['id'];
                                $bp_query = mysqli_query($db, "SELECT * FROM progress WHERE progress = 'blood_Pressure' AND user_id = '$user_id' ORDER BY timestamp DESC LIMIT 1");
                                $bp_value = "";
                                $is_bp_value_existing = false;
                                
                                if(mysqli_num_rows($bp_query) < 1){
                                    $bp_value = "click here to start tracking !";
                                }
                                else{
                                    $bp_value = mysqli_fetch_assoc($bp_query)["value"].'<sub>mg</sub>';
                                    $is_bp_value_existing = true;
                                }

                            ?>
                                <div class="flex-column">
                                    <?php 
                                        if($is_bp_value_existing == true){
                                            echo "<div class=\"tracker_status\">Normal</div>";
                                        }
                                    ?>

                                    <div class="tracker_value"><?php echo $bp_value; ?></div>
                                </div>
                        </div>
                    </a>
                    <a href= <?php echo "progress_tracker.php?u=".$_SESSION['username']."&p=calories"; ?> class = "home_tracker_snippet_link">
                        <div class="home_tracker_snippet placcard">
                            <div class="flex-row">
                                <i class="fa fa-heartbeat"></i>
                                Calories
                            </div>

                            <?php 
                                $user_id = $_SESSION['id'];
                                $calories_query = mysqli_query($db, "SELECT * FROM progress WHERE progress = 'calories' AND user_id = '$user_id' ORDER BY timestamp DESC LIMIT 1");
                                $calories_value = "";
                                $is_calories_value_existing = false;
                                
                                if(mysqli_num_rows($calories_query) < 1){
                                    $calories_value = "click here to start tracking !";
                                }
                                else{
                                    $calories_value = mysqli_fetch_assoc($calories_query)["value"].'<sub>mg</sub>';
                                    $is_calories_value_existing = true;
                                }

                            ?>

                            <div class="flex-column">
                                <?php 
                                    if($is_calories_value_existing == true){
                                        echo "<div class=\"tracker_status\">Normal</div>";
                                    }
                                ?>
                                <div class="tracker_value"> <?php echo $calories_value; ?></div>
                            </div>
                        
                        </div>
                    </a>

                    <a href= <?php echo "progress_tracker.php?u=".$_SESSION['username']."&p=waters"; ?> class = "home_tracker_snippet_link">
                        <div class="home_tracker_snippet placcard">
                            <div class="flex-row">
                                <i class="fa fa-heartbeat"></i>
                                Waters
                            </div>

                            <?php 
                                $user_id = $_SESSION['id'];
                                $waters_query = mysqli_query($db, "SELECT * FROM progress WHERE progress = 'waters' AND user_id = '$user_id' ORDER BY timestamp DESC LIMIT 1");
                                $waters_value = "";
                                $is_waters_value_existing = false;
                                
                                if(mysqli_num_rows($waters_query) < 1){
                                    $waters_value = "click here to start tracking !";
                                }
                                else{
                                    $waters_value = mysqli_fetch_assoc($waters_query)["value"].'<sub>litres</sub>';
                                    $is_waters_value_existing = true;
                                }

                            ?>


                            <div class="flex-column">
                                <?php 
                                    if($is_waters_value_existing == true){
                                        echo "<div class=\"tracker_status\">Normal</div>";
                                    }
                                ?>
                                <div class="tracker_value"><?php echo $waters_value; ?></div>
                            </div>
                        
                        </div>
                    </a>
                </div>
                <div class="rhs_bottom_deck flex-column flex-end m-10">
                    <div class="home_tracker_snippet_link flex-column flex-end">
                        <div class="health_tip_card home_tracker_snippet ml-10 placcard">
                            <div class="average-text white-text ml-10">Health tips: </div>
                            <div id="health_tips_text" class = "margin-10">
                                <!-- health tips generated by ai-->
                                <script type = "module">
                                    import {generateResponse} from './ai_requests.js';
                                    generateResponse("Pick a random topic or two of the following and give me health tips on it: exercise, mental health, stress, psychology, hygiene, general healthcare and nutrition, not more than 70 words.",document.getElementById("health_tips_text"));
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>