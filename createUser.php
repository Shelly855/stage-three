<?php
include_once("createUserSql.php");
$conn = mysqli_connect("localhost", "root", "", "users");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$erroruid = $errorfname = $errorsurname = $errorrole = $erroremail = $errormobile = $errordob = $erroruname = $errorpwd = "";
$allFields = true;

if (isset($_POST['submit'])){

    if ($_POST['uid']==""){
        $erroruid = "User ID is mandatory";
        $allFields = false;
    }
    if ($_POST['fname']==""){
        $errorfname = "First name is mandatory";
        $allFields = false;
    }
    if ($_POST['surname']==""){
        $errorsurname = "Surname is mandatory";
        $allFields = false;
    }
    if ($_POST['role']==""){
        $errorrole = "Role is mandatory";
        $allFields = false;
    }
    if ($_POST['email']==""){
        $erroremail = "Email Address is mandatory";
        $allFields = false;
    }
    if ($_POST['mobile']==""){
        $errormobile = "Mobile Number is mandatory";
        $allFields = false;
    }
    if ($_POST['dob']==""){
        $errordob = "Date of Birth is mandatory";
        $allFields = false;
    }
    if ($_POST['uname']==""){
        $erroruname = "Username is mandatory";
        $allFields = false;
    }
    if ($_POST['pwd']==""){
        $errorpwd = "Password is mandatory";
        $allFields = false;
    }

    if($allFields == true)
    {
        $userID = $_POST['uid'];
        if (checkUserIdExists($userID, $conn)) {
            $erroruid = "User ID already exists";
        } else {
            $createUser = createUser();
        }
    }
}

function checkUserIdExists($uid, $conn) {
    $result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$uid'");
    return mysqli_num_rows($result) > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Create User</title>
</head>
<body>
    <div class="container">
        <?php
            include("includes/header.php");
        ?>  
        <main>
            <h1>Create User</h1>
            <form method="post">
                <label>User ID</label>
                <input type="number" name = "uid">
                <span class="blank-notify"><?php echo $erroruid; ?></span>

                <label>First Name</label>
                <input type="text" name = "fname">
                <span class="blank-notify"><?php echo $errorfname; ?></span>

                <label>Surname</label>
                <input type="text" name = "surname">
                <span class="blank-notify"><?php echo $errorsurname; ?></span>

                <label>Date of Birth</label>
                <input type="date" name = "dob">
                <span class="blank-notify"><?php echo $errordob; ?></span>

                <label>Email Address</label>
                <input type="text" name = "email">
                <span class="blank-notify"><?php echo $erroremail; ?></span>

                <label>Mobile Number</label>
                <input type="text" name = "mobile">
                <span class="blank-notify"><?php echo $errormobile; ?></span>

                <label>Username</label>
                <input type="text" name = "uname">
                <span class="blank-notify"><?php echo $erroruname; ?></span>

                <label>Password</label>
                <input type="password" name = "pwd">
                <span class="blank-notify"><?php echo $errorpwd; ?></span>

                <label>Job Role</label>
                <select name="job">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                </select>
                <span class="blank-notify"><?php echo $errorrole; ?></span>

                <input type="submit" value="Create User" name ="submit"><a href="userProfiles.php">Back</a>
            </form>
        </main>
        <?php
            include("includes/footer.php");
        ?>
    </div>
</body>
</html>