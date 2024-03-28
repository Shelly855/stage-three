<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');
$errorsfname = $errorssurname = $errorrole = $errorsuname = $errorspwd = "";
$allFields = true;

if (isset($_POST['submit'])) {

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

        $stmt = $db->prepare("UPDATE staff SET first_name = :sfname, surname = :ssurname, role = :role, username = :suname, password = :spwd WHERE staff_id = :sid");
        $stmt->bindValue(':sid', $_POST['staff_id'], SQLITE3_INTEGER);
        $stmt->bindValue(':sfname', $_POST['sfname'], SQLITE3_TEXT);
        $stmt->bindValue(':ssurname', $_POST['ssurname'], SQLITE3_TEXT);
        $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
        $stmt->bindValue(':suname', $_POST['suname'], SQLITE3_TEXT);
        $stmt->bindValue(':spwd', $_POST['spwd'], SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            header('Location: updateStaffSuccess.php?updated=true');
            exit;
        } else {
            echo "Error updating staff.";
        }
    }
}

if (isset($_GET['sid'])) {
    $stmt = $db->prepare('SELECT * FROM staff WHERE staff_id = :sid');
    $stmt->bindParam(':sid', $_GET['sid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $staff = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update Staff</title>
</head>
<body>
<div class="container">
    <?php
        include("../includes/adminHeader.php");
    ?>  
    <main>
        <h1>Update Staff</h1>
        <form method="post">
            <?php if (isset($staff)): ?>
                <input type="hidden" name="staff_id" value="<?php echo $staff['staff_id']; ?>">
            <?php endif; ?>
            <label>First Name</label>
            <input type="text" name="sfname" value="<?php echo isset($staff['first_name']) ? $staff['first_name'] : ''; ?>">
            <span class="blank-error"><?php echo $errorsfname; ?></span>

            <label>Surname</label>
            <input type="text" name="ssurname" value="<?php echo isset($staff['surname']) ? $staff['surname'] : ''; ?>">
            <span class="blank-error"><?php echo $errorssurname; ?></span>

            <label>Role</label>
            <select name="role">
                <option value="">Select Role</option>
                <option value="admin" <?php echo (isset($staff['role']) && $staff['role'] == "admin") ? "selected" : ""; ?>>Admin</option>
                <option value="doctor" <?php echo (isset($staff['role']) && $staff['role'] == "doctor") ? "selected" : ""; ?>>Doctor</option>
            </select>
            <span class="blank-error"><?php echo $errorrole; ?></span>

            <label>Username</label>
            <input type="text" name="suname" value="<?php echo isset($staff['username']) ? $staff['username'] : ''; ?>">
            <span class="blank-error"><?php echo $errorsuname; ?></span>

            <label>Password</label>
            <input type="text" name="spwd" value="<?php echo isset($staff['password']) ? $staff['password'] : ''; ?>">
            <span class="blank-error"><?php echo $errorspwd; ?></span>

            <input type="submit" value="Update Staff" name="submit">
            <a href="../adminStaffProfiles/adminStaffProfiles.php" class="back-button">Back</a>
        </form>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
    </div>
</body>
</html>