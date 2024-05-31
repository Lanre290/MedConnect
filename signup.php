<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width",initial-scale="1.0">
        <link rel="stylesheet" type="text/css" href="login.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="fontawesome-free-6.4.2-web\css\all.min.css">
        <!--
        <link rel="preconnect" href="https://fonts.gstatics.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">-->
        <title>Sign up</title>
    </head>
    <body>
        <div id="body">
            <div class="main" id="preamble">
                <button id="prev"><i class="fa fa-chevron-left"></i></button>
                <div class="display_text"><h3 align="center" id="display_text">Welcome to  story hub.<br>Story hub brings to you all of your favourite novels right to you</h3></div>
                <div class="pos_cont" id="pos_cont">
                    <div class="position current"></div>
                </div>
                <button class="next" id="proceed_btn">Next</button>
                <button id="next"><i class="fa fa-chevron-right"></i></button>
            </div>
        </div>
        <div class="main" id="main" style="display :none;">
            <div class="main_inner">
                <div class="title"><h3 align="center">Create your account</h3></div>
                <div class="main_inners_cont">
                    <div class="main_inner_left">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="main_inner_center">
                        <div class="input_cont">
                            <font class="input_labels">Full name&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="text"class="input_fields" id="name" placeholder="e.g: John Doe" />
                            <br><font class="small_errs" id="name_err"></font>
                        </div>
                        <div class="input_cont">
                            <font class="input_labels">Username&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="text"class="input_fields" id="uname">
                            <br><font class="small_errs" id="uname_err"></font>
                        </div>
                        <div class="input_cont">
                            <font class="input_labels">Email&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="text"class="input_fields" id="email" />
                            <br><font class="small_errs" id="email_err"></font>
                        </div>
                        <div class="input_cont">
                            <font class="input_labels">Gender&nbsp;<i class="fa fa-question-circle"></i> </font><br>
                            <select class="opt_menu" id="gender" selected=" ">
                                <option value="male">Male</option>
                                <option value="male">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="main_inner_right">
                        <div class="input_cont">
                            <font class="input_labels">Password&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="password"class="input_fields" id="pwd"/>
                            <br><font class="small_errs" id="pwd_err"></font>
                        </div>
                        <div class="input_cont">
                            <font class="input_labels">Password repeat&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="password"class="input_fields" id="pwd_repeat" />
                        </div>
                        <div class="input_cont">
                            <font class="input_labels">Date of Birth&nbsp;<i class="fa fa-question-circle"></i> </font><br>
                                <input type="date"class="input_fields" id="dob"/>
                        </div>
                    </div>
                </div>
                    <h3 align="center" class="already_have_account">Already have an acccount?&nbsp;<span id="login_link">Sign in</span></h3>
                <div class="accept_terms_cont">
                    <div class="check_cont">
                        <input type="checkbox" id="accept_terms">
                        <div class="accept_terms" id="accept_terms_text">I agree that i have read and accept the <font class="links">Terms of Use and Agreement</font> and consent to the <font class="links">Privacy policies</font> </div>
                    </div>
                    <button class="submit" id="submit_btn">Proceed&nbsp;<i class="fa fa-arrow-circle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="main" id="main_login" style="display: none;">
            <div class="main_inner">
                <font class="title"><h3 align="center">Login</h3></font><br>
                    <div class="main_inners_cont">
                    <div class="main_inner_left">
                        <i class="fa fa-envelope"></i>
                    </div>
                        <div class="main_inner_center">
                            <div class="input_cont">
                                <font class="input_labels">Username&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="text"class="input_fields" id="uname_login">
                                <br><font class="small_errs" id="uname_login_err"></font>
                            </div>
                            <div class="input_cont">
                                <font class="input_labels">Password&nbsp;<i class="fa fa-question-circle"></i> </font><br><input type="password"class="input_fields" id="pwd_login"/>
                                <br><font class="small_errs" id="pwd_login_err"></font>
                            </div>
                            <button class="submit_login" id="login_btn">Proceed&nbsp;<i class="fa fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                    <h3 align="center" class="already_have_account">Don't have an acccount?&nbsp;<span id="signup_link">Sign up</span></h3><br>
            </div>
        </div>
        <div class="black_cont" id="bc_loading">
            <div class="loading_bar" id="loading_bar"></div>
        </div>
        <div class="black_cont" id="error_bc">
            <div class="error_div_cont">
                <div class="error_text" id = "error_text"><!--error text--></div>
                <button class="error_btn" id = "error_btn">Ok</button>
            </div>
        </div>
        <script src="login.js"></script>
    </body>
</html>