<?php
function verifyDoctors () {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return array();
    }

    $db = new SQLite3("stage_3.db");

    if (!$db) {
        echo "Failed to connect to database: ";
        return array();
    }

    $stmt = $db->prepare('SELECT username, password FROM staff WHERE username=:username AND password=:password');

    $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
    $stmt->bindParam(':password', $_POST['password'], SQLITE3_TEXT);

    $result = $stmt->execute();


    $rows_array = array();
    while ($row = $result ->fetchArray(SQLITE3_ASSOC)) {
        $rows_array[] = $row;
    }

    $stmt->close();
    $db->close();

    return $rows_array;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verifiedDoctors = verifyDoctors();

    if (!empty($verifiedDoctors)) {
        $_SESSION['username'] = $verifiedDoctors[0]['usernmae'];
        $_SESSION['password'] = $verifiedDoctors[0]['password'];
        header("Location: ../dashboardDoctor.php");
        exit;
    } else {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {                
        var errorMessageElement = document.getElementById('error-message');                    
        if (errorMessageElement) {
            errorMessageElement.innerHTML = 'Invalid username or password. Please try again.';
        }
        });</script>";
    }
}
