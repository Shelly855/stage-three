<?php
function verifyUser() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_POST['username']) || !isset($_POST['password'])) {
        return array();
    }

    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
        return array();
    }

    $stmt = $db->prepare('
        SELECT u.user_id, u.username, u.password, u.role, p.patient_id 
        FROM users u
        JOIN patients p ON u.user_id = p.user_id 
        WHERE u.username=:username AND u.password=:password
    ');

    $stmt->bindParam(':username', $_POST['username'], SQLITE3_TEXT);
    $stmt->bindParam(':password', $_POST['password'], SQLITE3_TEXT);

    $result = $stmt->execute();

    $rows_array = array();
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rows_array[] = $row;
    }

    $stmt->close();
    $db->close();

    return $rows_array;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verifiedUser = verifyUser();

    if (!empty($verifiedUser)) {
        $_SESSION['user_id'] = $verifiedUser[0]['user_id'];
        $_SESSION['username'] = $verifiedUser[0]['username'];
        $_SESSION['role'] = $verifiedUser[0]['role'];

        if ($_SESSION['role'] == 'patient') {
            $_SESSION['patient_id'] = $verifiedUser[0]['patient_id'];
        }
        
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../adminProfile/dashboardAdmin.php");
            exit;
        } elseif ($_SESSION['role'] == 'doctor') {
            header("Location: ../doctorProfile/dashboardDoctor.php");
            exit;
        } elseif ($_SESSION['role'] == 'patient') {
            header("Location: ../patientProfile/dashboardPatient.php");
            exit;
        }
    } else {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {                 
        var errorMessageElement = document.getElementById('error-message');                    
        if (errorMessageElement) {
            errorMessageElement.innerHTML = 'Invalid username or password. Please try again.';
        }
        });</script>";
    }
}
?>
