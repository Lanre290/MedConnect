<?php
require('script.php');
    

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty($_POST)){
        echo "unexpected response";
        exit();
    }
    else{

        if(isset($_POST['type']) && $_POST['type'] == "register_user" && isset($_POST['data'])){
            $data = json_decode($_POST['data']);
        
    
            $name = $data->name;
            $uname = $data->uname;
            $email = $data->email;
            $gender = $data->gender;
            $pwd = $data->pwd;
            $dob = $data->dob;
    
    
            $user = new signUp($name, $uname, $email, $gender, $pwd, $dob);
            $response = $user->register();
            echo $response;
        }
    
        if(isset($_POST['type']) && $_POST['type'] == "login" && isset($_POST['data'])){
            $data = json_decode($_POST['data']);
    
            $username = $data->username;
            $pwd = $data->pwd;
    
    
            $user = new User($user_id = 0,$uname = $username, $pwd = $pwd);
            $response = $user->signIn();
    
            echo $response;
        }
    
        if(isset($_POST['type']) && $_POST['type'] == "updateProgress" && isset($_POST['data'])){
            $data = json_decode($_POST['data']);
    
            $value = $data->value;
            $description = $data->description;
            $date = $data->date;
            $current_progress = $data->current_progress;
            $timestamp = $data->timestamp;
    
    
            $user = new userAction();
            $response = $user->updateNewProgress($current_progress, $value, $date, $description, $timestamp);
    
            echo $response;
        }

        if(isset($_POST['type']) && $_POST['type'] == "getProgress" && isset($_POST['data'])){

            $value = $_POST['data'];

            $user = new userAction();
            $response = $user->getProgress($value);

            echo json_encode($response);

        }
    }
}