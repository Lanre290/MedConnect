<?php
session_start();

    class User{
        public function __construct($user_id = "",$uname = "",$pwd = "") {
            $this->id = $user_id;
            $this->username = $uname;
            $this->pwd = $pwd;
        }

        public function getDetails(){
            $conn = mysqli_connect("localhost", "root", "", "datican");

            if(!$conn){
                echo "error connecting to database";
            }
            else{
                $fetchall = [];
                $query = mysqli_query($conn,"SELECT * FROM users WHERE id = '$this->id'");
                if(mysqli_num_rows($query) > 0){
                    $assoc = mysqli_fetch_assoc($query);
                    array_push($fetchall,$assoc);
                    
                    echo json_encode($fetchall);
                }
                else{
                    return "null";
                }
            }

        }

        public function signIn(){
            $conn = mysqli_connect("localhost", "root", "", "datican");


            $check_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$this->username'");      //check if username exists in database and raise an error if it does
            if(mysqli_num_rows($check_username) == 0){
                return "Username does not exists";
            }
            else{
                $assoc = mysqli_fetch_assoc($check_username);

                if (password_verify($this->pwd, $assoc['password'])) {
                    return true;
                } else {
                    return "Incorrect Password";
                }
            }

        }


    }


    class signUp{
        public function __construct($name, $uname, $email, $gender, $pwd, $dob) {
            $this->name = $name;
            $this->uname = $uname;
            $this->email = $email;
            $this->gender = $gender;
            $this->pwd = password_hash($pwd,PASSWORD_DEFAULT);
            $this->dob = $dob;
        }

        public function register(){
            $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';          //initialise email pattern woth regex.
            $stringPattern = '/^[a-zA-Z\s]+$/';                              //initialize string with regex.
            $conn = mysqli_connect("localhost", "root", "", "datican");
            $error = 0;

            if(empty($this->name) || empty($this->uname) || empty($this->email) || empty($this->gender) || empty($this->pwd) || empty($this->dob)){
                return "Invalid Details";
                $error++;
                die();
            }

            if(!preg_match($stringPattern,$this->name)  || !preg_match($stringPattern,$this->gender)){
                return("#002");
                $error++;
                die();
            }
            if(!preg_match($emailPattern,$this->email)){
                return "Invalid input";
                $error++;
                die();
            }


            $check_username = mysqli_query($conn, "SELECT * FROM users WHERE username='$this->uname'");      //check if username exists in database and raise an error if it does
            if(mysqli_num_rows($check_username) > 0){
                return "User with this username already exists";
                $error++;
                die();
            }

            $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$this->email'");     //check if email exists in database and raise an error if it does
            if(mysqli_num_rows($check_email) > 0){
                return "User with this email already exists";
                $error++;
                die();
            }

            $insert_query = mysqli_query($conn,"INSERT INTO users(full_name, username, email, gender, password, dob) VALUES('$this->name','$this->uname','$this->email','$this->gender','$this->pwd','$this->dob')");     //insert into the database if there is no error

            if(!($insert_query)){
                return "Error connecting to database.";
                $error++;
                die();
            }

            if($error == 0){
                $arr = array("success" => true,"email" => $this->email);
                
                return json_encode($arr);        //return token if all exceptions are passed
            }
            

        }
    }

    class userAction{
        public function __construct($id = "") {
            $this->id = $id;
        }

        public function updateNewProgress($progress, $value, $date, $description, $timestamp){
            $conn = mysqli_connect("localhost", "root", "", "datican");
            $id = $_SESSION["id"];


            $query = mysqli_query($conn, "INSERT INTO progress(user_id, progress, value, date, description, timestamp) VALUES('$id','$progress','$value','$date','$description','$timestamp')");

            if(!($query)){
                return "Error connecting to database.";
            }
            else{
                return true;
            }
        }

        public function getProgress($value){
            $conn = mysqli_connect("localhost", "root", "", "datican");

            $user_id = $_SESSION['id'];
            
            $query = mysqli_query($conn, "SELECT * FROM progress WHERE progress = '$value' AND user_id = '$user_id' ORDER BY timestamp DESC LIMIT 10");

            $out_arr = array();
            $arr = [];
            $max_value = 0;
            
            while($assoc = mysqli_fetch_assoc($query)){
                $inner_arr = array("value" => $assoc['value'],"description" => $assoc['description'],"date" => $assoc['date'],"timestamp"=> $assoc['timestamp']);
                array_unshift($arr, $inner_arr);

                if($assoc['value'] > $max_value){
                    $max_value = $assoc['value'];       //assign value to max_value each time it loops through;
                }
            }

            $out_arr["max_value"] = $max_value;

            $out_arr["data"] = $arr;

            if(!($query)){
                return "Error connecting to database.";
            }
            else{
                return $out_arr;
            }
        }
    }