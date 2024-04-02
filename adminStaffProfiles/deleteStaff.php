<?php
session_start();

$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['delete'])) {
    if (isset($_POST['sid'])) {
        $staffId = $_POST['sid'];

        $stmt = $db->prepare("DELETE FROM staff WHERE staff_id = :sid");
        $stmt->bindValue(':sid', $staffId);
        $result = $stmt->execute();

        if ($result) {
            header("Location: ../adminStaffProfiles/deleteStaffSuccess.php?deleted=true");
            exit();
        } else {
            echo "Error deleting staff.";
        }
    }
}

if (isset($_GET['sid'])) {
    $stmt = $db->prepare('SELECT * FROM staff WHERE staff_id = :sid');
    $stmt->bindParam(':sid', $_GET['sid'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $staff = $result->fetchArray(SQLITE3_ASSOC);
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
    <title>Delete Staff</title>
</head>
<body>
    <div class="container">
        <?php include("../includes/adminHeader.php"); ?>
        <main>
            <h2>Delete Staff</h2>
            <div class="confirm">Are you sure you want to delete this staff?</div>
            <?php if(isset($staff)): ?>
            <div class="delete-data">
                <label class="delete-label">First Name:</label>
                <label><?php echo $staff['first_name']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Surname:</label>
                <label><?php echo $staff['surname']; ?></label>
            </div>
            <div class="delete-data">
                <label class="delete-label">Role:</label>
                <label><?php echo $staff['role']; ?></label>
            </div>
            <?php endif; ?>
            <form method="post">
                <input type="hidden" name="sid" value="<?php echo $_GET['sid']; ?>">
                <input type="submit" value="Delete" name="delete">
                <a href="../adminStaffProfiles/adminStaffProfiles.php" class="back-button">Back</a>
            </form>
        </main>
        <?php include("../includes/footer.php"); ?>
    </div>
</body>
</html>
