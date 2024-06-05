<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

?>



<div class="topnav mobile-flex-column-reverse">
    <div class="lhs_topnav mobile-flex-column">
        <div class="logo_div"><i class="fa fa-heartbeat"></i> MedConnect</div>
        <div class="navbar" id="navbar">
            <a href="index.php?u=<?php echo $_SESSION['username']?>" class = "current">Overwiew</a>
            <a href="ai.php">MedConnect AI</a>
            <a href="progress_tracker.php?u=<?php echo $_SESSION['username']?>">Progress Tracker</a>
        </div>
    </div>
    <div class="rhs_topnav mobile-flex-end">
        <div class="notif_div navbtn" title = "Notifications">
            <div class="notif_beep"></div>
            <i class="fa fa-bell"></i>
        </div>
        <button class="navbtn" id = "settings_btn" title = "settings"><i class="fa fa-cog"></i></button>
        <div class="name_div">
            <div class="user_navbar_dp"></div>
            <div class= "name_div_name"> <?php echo $_SESSION['name']; ?> </div>
        </div>
    </div>
</div>