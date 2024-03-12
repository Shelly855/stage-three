<?php
require_once('includes/userConfig.php');

function createUser(){
    $created = false;

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = 'INSERT INTO users(user_id, first_name, surname, role, email, mobile_number, date_of_birth, username, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in prepare statement: " . $conn->error);
    }

    $stmt->bind_param('issssssss', $uid, $fname, $surname, $role, $email, $mobile, $dob, $uname, $pwd);

    $uid = (int)$_POST['uid'];
    $fname = $_POST['fname'];
    $surname = $_POST['surname'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $uname = $_POST['uname'];
    $pwd = $_POST['pwd'];

    $result = $stmt->execute();

    if($result){
        $created = true;
        header("Location: createUserSuccess.php?createUser=success");
        exit();
    } else {
        error_log("Error in executing statement: " . $stmt->error);
        die("Error in creating user - please try again later.");
    }
}