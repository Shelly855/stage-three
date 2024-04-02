<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errorpfname = $errorpsurname = $errorpemail = $errorpmobile = $errorpdob = $errorpuname = $errorppwd = "";
$allFields = true;

if (isset($_POST['submit'])) {

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
        $errorpuname = "Username is mandatory";
        $allFields = false;
    }
    if (empty($_POST['ppwd'])) {
        $errorppwd = "Password is mandatory";
        $allFields = false;
    }

    if ($allFields) {

        $stmt = $db->prepare("UPDATE patients SET first_name = :pfname, surname = :psurname, email = :pemail, mobile_number = :pmobile, date_of_birth = :pdob, username = :puname, password = :ppwd WHERE patient_id = :pid");
        $stmt->bindValue(':pid', $_POST['patient_id'], SQLITE3_INTEGER);
        $stmt->bindValue(':pfname', $_POST['pfname'], SQLITE3_TEXT);
        $stmt->bindValue(':psurname', $_POST['psurname'], SQLITE3_TEXT);
        $stmt->bindValue(':pemail', $_POST['pemail'], SQLITE3_TEXT);
        $stmt->bindValue(':pmobile', $_POST['pmobile'], SQLITE3_TEXT);
        $stmt->bindValue(':pdob', $_POST['pdob'], SQLITE3_TEXT);
        $stmt->bindValue(':puname', $_POST['puname'], SQLITE3_TEXT);
        $stmt->bindValue(':ppwd', $_POST['ppwd'], SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            header('Location: updatePatientSuccess.php?updated=true');
            exit;
        } else {
            echo "Error updating patient.";
        }
    }
}

if (isset($_GET['pid'])) {
    $stmt = $db->prepare('SELECT * FROM patients WHERE patient_id = :pid');
    $stmt->bindParam(':pid', $_GET['pid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $patient = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update Patient</title>
</head>
<body>
<div class="container">
    <?php
        include("../includes/adminHeader.php");
    ?>  
    <main>
        <h1>Update Patient</h1>
        <form method="post">
            <?php if (isset($patient)): ?>
                <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">
            <?php endif; ?>
            <label>First Name</label>
            <input type="text" name="pfname" value="<?php echo isset($patient['first_name']) ? $patient['first_name'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpfname; ?></span>

            <label>Surname</label>
            <input type="text" name="psurname" value="<?php echo isset($patient['surname']) ? $patient['surname'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpsurname; ?></span>

            <label>Email</label>
            <input type="text" name="pemail" value="<?php echo isset($patient['email']) ? $patient['email'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpemail; ?></span>

            <label>Mobile Number</label>
            <input type="number" name="pmobile" value="<?php echo isset($patient['mobile_number']) ? $patient['mobile_number'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpmobile; ?></span>

            <label>Date of Birth</label>
            <input type="date" name="pdob" value="<?php echo isset($patient['date_of_birth']) ? $patient['date_of_birth'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpdob; ?></span>

            <label>Username</label>
            <input type="text" name="puname" value="<?php echo isset($patient['username']) ? $patient['username'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpuname; ?></span>

            <label>Password</label>
            <input type="text" name="ppwd" value="<?php echo isset($patient['password']) ? $patient['password'] : ''; ?>">
            <span class="blank-error"><?php echo $errorppwd; ?></span>

            <input type="submit" value="Update Patient" name="submit">
            <a href="../adminPatientProfiles/adminPatientProfiles.php" class="back-button">Back</a>
        </form>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
    </div>
</body>
</html>