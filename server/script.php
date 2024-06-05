<?php
    session_start();
    include_once "db.php";

    class User{
        public function __construct($user_id = "",$uname = "",$pwd = "") {
            $this->id = $user_id;
            $this->username = $uname;
            $this->pwd = $pwd;
            if(isset($_SESSION['id'])){
                $this->id = $_SESSION['id'];
            }
            if(isset($_SESSION['username'])){
                $this->username = $_SESSION['username'];
            }
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
                    return json_Encode(array("success" => true,"uname" => $assoc['username']));
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
            $conn = mysqli_connect("localhost", "root", "", "datican");
            $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';          //initialise email pattern woth regex.
            $stringPattern = '/^[a-zA-Z\s]+$/';                              //initialize string with regex.
            
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
            $this->conn = mysqli_connect("localhost", "root", "", "datican");
            if(!(isset($_SESSION['id']))){
                exit();
            }
            if($id == ""){
                $this->id = $_SESSION['id'];
            }
        }

        public function updateNewProgress($progress, $value, $date, $description, $timestamp){

            $query = mysqli_query($this->conn, "INSERT INTO progress(user_id, progress, value, date, description, timestamp) VALUES('$this->id','$progress','$value','$date','$description','$timestamp')");

            if(!($query)){
                return "Error connecting to database.";
            }
            else{
                return true;
            }
        }

        public function getProgress($value){

            
            $query = mysqli_query($this->conn, "SELECT * FROM progress WHERE progress = '$value' AND user_id = '$this->id' ORDER BY timestamp DESC LIMIT 10");

            $out_arr = array();
            $arr = [];
            $max_value = 0;
            $unit = "";
            if($value == "blood_pressure"){
                $unit = "mmHg";
            }
            if($value == "waters"){
                $unit = "litres";
            }
            if($value == "calorires"){
                $unit = "kcal";
            }
            if($value == "glucose"){
                $unit = "grams";
            }
            while($assoc = mysqli_fetch_assoc($query)){
                $inner_arr = array("id" => $assoc['id'],"value" => $assoc['value'],"unit of measure"=> $unit,"description" => $assoc['description'],"date" => $assoc['date'],"timestamp"=> $assoc['timestamp']);
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

        public function addNewProgressTracker($progress){
            if(empty($progress)){
                return "Unexpected response.";
            }
            else{
                $progress_value = str_replace(" ", "_", strtolower($progress));

                $query = mysqli_query($this->conn, "INSERT INTO user_progress(user_id, progress, progress_value) VALUES('$this->id','$progress','$progress_value')");

                if(!($query)){
                    return "Error connecting to database.";
                }
                else{
                    return true;
                }
            }
        }

        public function getAdditionalProgress(){
            $out_string = "";

            $query = mysqli_query($this->conn, "SELECT * FROM user_progress WHERE user_id = '$this->id'");
            while($assoc = mysqli_fetch_assoc($query)){
                $out_string = $out_string.'<option value="'.$assoc['progress_value'].'">'.$assoc['progress'].'</option>';
            }

            if(!($query)){
                return "err";
            }
            else{
                return $out_string;
            }
        }

        public function deleteProgress($id){

            if(empty($id)){
                return "Unexpected response.";
            }
            else{
                $query = mysqli_query($this->conn, "DELETE FROM progress WHERE id = '$id'");
                if(!($query)){
                    return "Error connecting to database.";
                }
                else{
                    return true;
                }
            }
        }

        public function sendMessage($sender,$message,$timestamp){
            if(empty($sender) || empty($message)){
                return "Error processing data.";
            }
            else{
                $id = $_SESSION['id'];
                $message = str_replace('\n','<br>',$message);
                $message = str_replace('"','&quot;',$message);

                $query = mysqli_query($this->conn, "INSERT INTO chat(user_id, sender, message, timestamp) VALUES(\"$id\",\"$sender\",\"$message\",\"$timestamp\")");

                if(!$query){
                    return "Error connecting to database.";
                }
                else{
                    return true;
                }
            }
        }

        public function getMessages($timestamp){
            $id = $_SESSION['id'];
            $query = "";
            if($timestamp != null){
                $query = mysqli_query($this->conn, "SELECT * FROM chat WHERE user_id = '$id' AND timestamp < '$timestamp' ORDER BY timestamp DESC LIMIT 10");
            }
            else{
                $query = mysqli_query($this->conn, "SELECT * FROM chat WHERE user_id = '$id' ORDER BY timestamp DESC LIMIT 10");
            }

            if(!$query){
                return "Error Connecting to database.";
            }
            else{
                $out_arr = array();
                while ($assoc = mysqli_fetch_assoc($query)) {
                    $array = array();
                    $array['id'] = $assoc['id'];
                    $array['sender'] = $assoc['sender'];
                    $array['message'] = $assoc['message'];
                    $array['timestamp'] = $assoc['timestamp'];
                    array_push($out_arr, $array);
                }
            }

            return json_encode($out_arr);
        }

    }

    class aiServices{
        public function __construct() {
            $this->api_key = 'AIzaSyDMvlaaspQy2tonz31IZ4prt7Sd_AeE84A';
        }
        public function chatAi($text){

            // Data to be sent in the request body
            $data = array(
                'contents' => array(
                    array(
                        'parts' => array(
                            array(
                                'text' => $text
                            )
                        )
                    )
                )
            );

            $data_json = json_encode($data);

            $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=' . $this->api_key;

            // Set up cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));

            // Execute curl request
            $response = curl_exec($ch);

            if ($response === false) {
                echo 'Error: ' . curl_error($ch);
            } else {
                $response_data = json_decode($response, true);

                if (isset($response_data['candidates'][0]['content']['parts'][0]['text'])) {
                    $pre_response =  json_encode($response_data['candidates'][0]['content']['parts'][0]['text'], JSON_UNESCAPED_UNICODE);
                    $out_string = str_replace(array( '* **','**','*','##'), '',substr($pre_response, 1, -1));
                    $out_string = str_replace('\n','<br>',$out_string);
                    $out_string = str_replace('\"','&quot;',$out_string);
                    $out_string = str_replace('\/','/',$out_string);
                    return $out_string;
                } else {
                    return 'AI is unavailable for now, try again.';
                }
            }

            curl_close($ch);

        }

        public function analyseImage($image){

            $image_base64 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));

            $data = array(
                'requests' => array(
                    array(
                        'image' => array(
                            'content' => $image_base64
                        ),
                        'features' => array(
                            array('type' => 'LABEL_DETECTION'),     // General labels
                            array('type' => 'TEXT_DETECTION'),      // Text in images (e.g., drug labels)
                            array('type' => 'OBJECT_LOCALIZATION'), // Object detection (e.g., food items)
                            array('type' => 'DOCUMENT_TEXT_DETECTION'), // Detailed text detection
                        )
                        ,
                        'prompt' => 'Describe this image in a sentence.',
                    )
                )
            );

            $data_json = json_encode($data);

            $endpoint = 'https://vision.googleapis.com/v1/images:annotate?key=' . $this->api_key;

            // Set up cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));

            // Execute curl request
            $response = curl_exec($ch);

            if ($response === false) {
                echo 'Error: ' . curl_error($ch);
            } else {
                $response_data = json_decode($response, true);

                if (isset($response_data['responses'][0])) {
                    $response_parts = $response_data['responses'][0];

                    $results = array();

                    if (isset($response_parts['labelAnnotations'])) {
                        $labels = array_map(function($label) {
                            return $label['description'];
                        }, $response_parts['labelAnnotations']);
                        $results['labels'] = $labels;
                    }

                    if (isset($response_parts['textAnnotations'])) {
                        $text = array_map(function($text) {
                            return $text['description'];
                        }, $response_parts['textAnnotations']);
                        $results['text'] = $text;
                    }

                    if (isset($response_parts['localizedObjectAnnotations'])) {
                        $objects = array_map(function($object) {
                            return $object['name'];
                        }, $response_parts['localizedObjectAnnotations']);
                        $results['objects'] = $objects;
                    }

                    // Additional feature handling for more healthcare-related detections can be added here

                    $out_string = json_encode($results, JSON_UNESCAPED_UNICODE);
                    $out_string = str_replace(array( '* **','**','*','##'), '',substr($pre_response, 1, -1));
                    $out_string = str_replace('\n','<br>',$out_string);
                    $out_string = str_replace(array('"','\"'),'&quot;',$out_string);
                    $out_string = str_replace('\/','/',$out_string);
                    return $out_string;
                } else {
                    return serialize($response_data);//'AI is unavailable for now, try again.';
                }
            }

            curl_close($ch);

        }
    }