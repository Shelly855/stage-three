<?php

$errorpfname = $errorpsurname = $errorpemail = $errorpmobile = $errorpdob = $errorpuname = $errorppwd = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (empty($_POST['pfname'])) {
        $errorpfname = "First Name is mandatory";
        $allFields = false;
    }
    if (empty($_POST['psurname'])) {
        $errorpsurname = "Surname is mandatory";
        $allFields = false;
    }
    if (empty($_POST['pemail'])) {
        $errorpemail = "Email Address is mandatory";
        $allFields = false;
    }
    if (empty($_POST['pmobile'])) {
        $errorpmobile = "Mobile Number is mandatory";
        $allFields = false;
    }
    if (empty($_POST['pdob'])) {
        $errorpdob = "Date of Birth is mandatory";
        $allFields = false;
    }
    if (empty($_POST['puname'])) {
        $errorpusername = "Username is mandatory";
        $allFields = false;
    }
    if (empty($_POST['ppwd'])) {
        $errorppwd = "Password is mandatory";
        $allFields = false;
    }

    if ($allFields) {
        $stmt = $db->prepare('INSERT INTO patients (first_name, surname, email, mobile_number, date_of_birth, username, password) VALUES (:pfname, :psurname, :pemail, :pmobile, :pdob, :puname, :ppwd)');
        $stmt->bindValue(':pfname', $_POST['pfname'], SQLITE3_TEXT);
        $stmt->bindValue(':psurname', $_POST['psurname'], SQLITE3_TEXT);
        $stmt->bindValue(':pemail', $_POST['pemail'], SQLITE3_TEXT);
        $stmt->bindValue(':pmobile', $_POST['pmobile'], SQLITE3_TEXT);
        $stmt->bindValue(':pdob', $_POST['pdob'], SQLITE3_TEXT);
        $stmt->bindValue(':puname', $_POST['puname'], SQLITE3_TEXT);
        $stmt->bindValue(':ppwd', $_POST['ppwd'], SQLITE3_TEXT);
            
        $result = $stmt->execute();
    
        if ($result) {
            header("Location: ../adminPatientProfiles/createPatientSuccess.php?createPatient=success");
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
    <title>Create Patient</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/header.php");
        ?>  
        <main>
            <h1>Create Patient</h1>
            <form method="post">
                <label>First Name</label>
                <input type="text" name="pfname" value="<?php echo isset($_POST['pfname']) ? $_POST['pfname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpfname; ?></span>

                <label>Surname</label>
                <input type="text" name="psurname" value="<?php echo isset($_POST['psurname']) ? $_POST['psurname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpsurname; ?></span>

                <label>Email</label>
                <input type="text" name="pemail" value="<?php echo isset($_POST['pemail']) ? $_POST['pemail'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpemail; ?></span>

                <label>Mobile Number</label>
                <input type="number" name="pmobile" value="<?php echo isset($_POST['pmobile']) ? $_POST['pmobile'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpmobile; ?></span>

                <label>Date of Birth</label>
                <input type="date" name="pdob" value="<?php echo isset($_POST['pdob']) ? $_POST['pdob'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpdob; ?></span>

                <label>Username</label>
                <input type="text" name="puname" value="<?php echo isset($_POST['puname']) ? $_POST['puname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpuname; ?></span>

                <label>Password</label>
                <input type="text" name="ppwd" value="<?php echo isset($_POST['ppwd']) ? $_POST['ppwd'] : ''; ?>">
                <span class="blank-error"><?php echo $errorppwd; ?></span>

                <input type="submit" value="Create Patient" name="submit">
                <a href="../adminPatientProfiles/adminPatientProfiles.php" class="back-button">Back</a>
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
