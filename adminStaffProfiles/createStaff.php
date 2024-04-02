<?php

$errorsfname = $errorssurname = $errorrole = $errorsuname = $errorspwd = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (empty($_POST['sfname'])) {
        $errorsfname = "First Name is mandatory";
        $allFields = false;
    }
    if (empty($_POST['ssurname'])) {
        $errorssurname = "Surname is mandatory";
        $allFields = false;
    }
    if (empty($_POST['role'])) {
        $errorrole = "Role is mandatory";
        $allFields = false;
    }
    if (empty($_POST['suname'])) {
        $errorsusername = "Username is mandatory";
        $allFields = false;
    }
    if (empty($_POST['spwd'])) {
        $errorspwd = "Password is mandatory";
        $allFields = false;
    }

    if ($allFields) {
        $stmt = $db->prepare('INSERT INTO staff (first_name, surname, role, username, password) VALUES (:sfname, :ssurname, :role, :suname, :spwd)');
        $stmt->bindValue(':sfname', $_POST['sfname'], SQLITE3_TEXT);
        $stmt->bindValue(':ssurname', $_POST['ssurname'], SQLITE3_TEXT);
        $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
        $stmt->bindValue(':suname', $_POST['suname'], SQLITE3_TEXT);
        $stmt->bindValue(':spwd', $_POST['spwd'], SQLITE3_TEXT);
            
        $result = $stmt->execute();
    
        if ($result) {
            header("Location: ../adminStaffProfiles/createStaffSuccess.php?createStaff=success");
            exit();
        } else {
            echo "Error creating appointment";
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
    <title>Create Staff</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/adminHeader.php");
        ?>  
        <main>
            <h1>Create Staff</h1>
            <form method="post">
                <label>First Name</label>
                <input type="text" name="sfname" value="<?php echo isset($_POST['sfname']) ? $_POST['sfname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsfname; ?></span>

                <label>Surname</label>
                <input type="text" name="ssurname" value="<?php echo isset($_POST['ssurname']) ? $_POST['ssurname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorssurname; ?></span>

                <label>Role</label>
                <select name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                </select>
                <span class="blank-error"><?php echo $errorrole; ?></span>

                <label>Username</label>
                <input type="text" name="suname" value="<?php echo isset($_POST['suname']) ? $_POST['suname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsuname; ?></span>

                <label>Password</label>
                <input type="text" name="spwd" value="<?php echo isset($_POST['spwd']) ? $_POST['spwd'] : ''; ?>">
                <span class="blank-error"><?php echo $errorspwd; ?></span>

                <input type="submit" value="Create Staff" name="submit">
                <a href="../adminStaffProfiles/adminStaffProfiles.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
