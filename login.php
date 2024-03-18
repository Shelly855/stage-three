<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login</title>
</head>
   
<body>
    <div class="container">
        <main>
        <h1>Login</h1>
        <form method="post">
            <div class="imgcontainer">
                <img src="Hospital logo.png" alt="logo" class="logo">
            </div>
            <div class="container">
                <div class="label">
                    <label for="uname"><b>Username</b></label><br>
                    <input type="text" id="uname" placeholder="Enter Username" name="uname" required><br>
                </div>
                <div class="label">
                    <label for="pword"><b>Password</b></label><br>
                    <input type="password" placeholder="Enter Password" name="pword" required><br>
                    <span class="pword"><a href="#">Forgot password?</a></span><br>
                </div>

                <input class="button" type="submit" value="Login" name="submit">
                <button class="btn btn-warning" type="button"><a href="index.php">Back</a></button>
            </div>

        </form>
        <?php
            include("includes/footer.php");
        ?>
        </main>
    </div>
</body>

</html>

<?php

$db = new SQLITE3("stage_3.db");
$sql = "select first_name, last_name, password FROM staff";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $pword = $_POST["password"];
}

$sql = "SELECT first_name, last_name, password FROM staff WHERE first_name=:fname AND last_name=:lname AND password=:pword";
$stmt = $db->prepare($sql);
$stmt->bindValue(':fname', $fname, SQLITE3_TEXT);
$stmt->bindValue(':lname', $lname, SQLITE3_TEXT);
$stmt->bindValue(':pword', $pword, SQLITE3_TEXT);
$result = $stmt->execute();

?>