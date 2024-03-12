<?php
require_once('includes/userConfig.php');

function getUsers(){

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $user = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $staff[] = $row;
        }
    }

    $conn->close();

    return $user;
}