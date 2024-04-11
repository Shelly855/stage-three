<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['delete'])) {
    if (isset($_POST['uid'])) {
        $userId = $_POST['uid'];

        $stmt = $db->prepare("DELETE FROM users WHERE user_id = :uid");
        $stmt->bindValue(':uid', $userId);
        $result = $stmt->execute();

        if ($result) {
            header("Location: ../adminUsers/deleteUserSuccess.php?deleted=true");
            exit();
        } else {
            echo "Error deleting user.";
        }
    }
}

if (isset($_GET['uid'])) {
    $stmt = $db->prepare('SELECT * FROM users WHERE user_id = :uid');
    $stmt->bindParam(':uid', $_GET['uid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Delete User</title>
</head>
<body>
    <div class="container">
        <?php include("../includes/adminHeader.php"); ?>
        <main>
            <h2>Delete User</h2>
            <div class="confirm">Are you sure you want to delete this user?</div>
            <?php if(isset($user)): ?>
            <div class="delete-data">
                <label class="delete-label">First Name:</label>
                <label><?php echo $user['first_name']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Surname:</label>
                <label><?php echo $user['surname']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Role:</label>
                <label><?php echo $user['role']; ?></label>
            </div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>">
                <input type="submit" value="Delete" name="delete">
                <a href="../adminUsers/adminUsers.php" class="back-button">Back</a>
            </form>
        </main>
        <?php include("../includes/footer.php"); ?>
    </div>
</body>
</html>
