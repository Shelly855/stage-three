<<<<<<< HEAD
<?php
=======
 <?php
>>>>>>> 794063e069479575af8b5edf464cc8bf7ecaf445
function verifyPatients () {
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

    $stmt = $db->prepare('SELECT username, password FROM patients WHERE username=? AND password=?');

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
    $verifiedPatients = verifyPatients();

    if (!empty($verifiedPatients)) {
        $_SESSION['username'] = $verifiedUsers[0]['usernmae'];
        $_SESSION['password'] = $verifiedUsers[0]['password'];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>document.addEventListener('DOMContentLoaded', function() {                //this error message 
        var errorMessageElement = document.getElementById('error-message');                    //prob be changed
        if (errorMessageElement) {
            errorMessageElement.innerHTML = 'Invalid username or password. Please try again.';
        }
        });</script>";
    }
}