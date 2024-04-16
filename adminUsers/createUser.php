<?php
$errorfname = $errorsurname = $errorrole = $erroruname = $errorpwd = "";
$allFields = true;

if (isset($_POST['submit'])) {
    include '../includes/dbConnection.php';

    if (empty($_POST['fname'])) {
        $errorfname = "First Name is mandatory";
        $allFields = false;
    }
    if (empty($_POST['surname'])) {
        $errorsurname = "Surname is mandatory";
        $allFields = false;
    }
    if (empty($_POST['role'])) {
        $errorrole = "Role is mandatory";
        $allFields = false;
    }
    if (empty($_POST['uname'])) {
        $erroruname = "Username is mandatory";
        $allFields = false;
    }
    if (empty($_POST['pwd'])) {
        $errorpwd = "Password is mandatory";
        $allFields = false;
    }

    if ($allFields) {
        $stmt = $db->prepare('INSERT INTO users (first_name, surname, role, username, password) VALUES (:fname, :surname, :role, :uname, :pwd)');
        $stmt->bindValue(':fname', $_POST['fname'], SQLITE3_TEXT);
        $stmt->bindValue(':surname', $_POST['surname'], SQLITE3_TEXT);
        $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
        $stmt->bindValue(':uname', $_POST['uname'], SQLITE3_TEXT);
        $stmt->bindValue(':pwd', $_POST['pwd'], SQLITE3_TEXT);
            
        $result_user = $stmt->execute();

        $user_id = $db->lastInsertRowID();
    
        if ($result_user) {
            if ($_POST['role'] === 'patient') {
                $stmt_patient = $db->prepare('INSERT INTO patients (user_id) VALUES (:user_id)');
                $stmt_patient->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
                $result_patient = $stmt_patient->execute();
                if ($result_patient) {
                    header("Location: ../adminUsers/createUserSuccess.php?createUser=success");
                    exit();
                } else {
                    echo "Error creating patient record: " . $db->lastErrorMsg();
                }
            } else {
                header("Location: ../adminUsers/createUserSuccess.php?createUser=success");
                exit();
            }
        } else {
            echo "Error creating user: " . $db->lastErrorMsg();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Create User</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/adminHeader.php");
        ?>  
        <main>
            <h1>Create User</h1>
            <form method="post">
                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorfname; ?></span>

                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsurname; ?></span>

                <label>Role</label>
                <select name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                </select>
                <span class="blank-error"><?php echo $errorrole; ?></span>

                <label>Username</label>
                <input type="text" name="uname" value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : ''; ?>">
                <span class="blank-error"><?php echo $erroruname; ?></span>

                <label>Password</label>
                <input type="text" name="pwd" value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpwd; ?></span>

                <input type="submit" value="Create User" name="submit">
                <a href="../adminUsers/adminUsers.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
