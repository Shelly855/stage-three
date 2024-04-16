<?php
session_start();

include '../includes/dbConnection.php';
$errorfname = $errorsurname = $errorrole = $erroruname = $errorpwd = "";
$allFields = true;

if (isset($_POST['submit'])) {

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

        $stmt = $db->prepare("UPDATE users SET first_name = :fname, surname = :surname, role = :role, username = :uname, password = :pwd WHERE user_id = :uid");
        $stmt->bindValue(':uid', $_POST['user_id'], SQLITE3_INTEGER);
        $stmt->bindValue(':fname', $_POST['fname'], SQLITE3_TEXT);
        $stmt->bindValue(':surname', $_POST['surname'], SQLITE3_TEXT);
        $stmt->bindValue(':role', $_POST['role'], SQLITE3_TEXT);
        $stmt->bindValue(':uname', $_POST['uname'], SQLITE3_TEXT);
        $stmt->bindValue(':pwd', $_POST['pwd'], SQLITE3_TEXT);

        $result = $stmt->execute();

        if ($result) {
            header('Location: updateUserSuccess.php?updated=true');
            exit;
        } else {
            echo "Error updating user.";
        }
    }
}

if (isset($_GET['uid'])) {
    $stmt = $db->prepare('SELECT * FROM users WHERE user_id = :uid');
    $stmt->bindParam(':uid', $_GET['uid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Update User</title>
</head>
<body>
<div class="container">
    <?php
        include("../includes/adminHeader.php");
    ?>  
    <main>
        <h1>Update User</h1>
        <form method="post">
            <?php if (isset($user)): ?>
                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <?php endif; ?>
            <label>First Name</label>
            <input type="text" name="fname" value="<?php echo isset($user['first_name']) ? $user['first_name'] : ''; ?>">
            <span class="blank-error"><?php echo $errorfname; ?></span>

            <label>Surname</label>
            <input type="text" name="surname" value="<?php echo isset($user['surname']) ? $user['surname'] : ''; ?>">
            <span class="blank-error"><?php echo $errorsurname; ?></span>

            <label>Role</label>
            <select name="role">
                <option value="">Select Role</option>
                <option value="admin" <?php echo (isset($user['role']) && $user['role'] == "admin") ? "selected" : ""; ?>>Admin</option>
                <option value="doctor" <?php echo (isset($user['role']) && $user['role'] == "doctor") ? "selected" : ""; ?>>Doctor</option>
                <option value="patient" <?php echo (isset($user['role']) && $user['role'] == "patient") ? "selected" : ""; ?>>Patient</option>
            </select>
            <span class="blank-error"><?php echo $errorrole; ?></span>

            <label>Username</label>
            <input type="text" name="uname" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>">
            <span class="blank-error"><?php echo $erroruname; ?></span>

            <label>Password</label>
            <input type="text" name="pwd" value="<?php echo isset($user['password']) ? $user['password'] : ''; ?>">
            <span class="blank-error"><?php echo $errorpwd; ?></span>

            <input type="submit" value="Update User" name="submit">
            <a href="../adminUsers/adminUsers.php" class="back-button">Back</a>
        </form>
    </main>
    <?php
        include("../includes/footer.php");
    ?>
    </div>
</body>
</html>
