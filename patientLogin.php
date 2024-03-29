<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Login</title>
</head>

<body>
    <div class="container">
        <?php
        include ("includes/header.php");
        require_once ("checkPatientLogin.php");
        ?>
        <main role="main" class="pb-3">
            <h2>Patient Login</h2><br>
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="patientLogin.php">

                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input class="form-control" name="username" id="usrname" placeholder="Enter Username" type="text" required />
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" id ="password"  placeholder="Enter Password" class="form-control" required />
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php
        include ("includes/footer.php");
        ?>
    </div>

</body>

</html>



<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $db = new SQLite3("stage_3.db");

    $stmt = $db->prepare('SELECT username, password FROM patients WHERE username=:username AND password=:password');
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);

    $result = $stmt->execute();

    if ($row = $result->fetchArray()) {

        $_SESSION['username'] = $username;
        header("Location: dashboardPatient.php"); 
        exit;
    } else {
        echo "Invalid username or password. Please try again.";
    }

    $db->close();
}
?>


