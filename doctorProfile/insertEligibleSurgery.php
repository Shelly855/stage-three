<?php
 include '../includes/dbConnection.php';

 if (!$db) {
    die("Failed to connect to the database.");
}

$surgery_id = $_POST['surgery_id'];
$eligible = isset($_POST['eligible']) ? 1 : 0; 

$sql = "UPDATE surgery SET eligible = :eligible WHERE surgery_id = :surgery_id";
$stmt = $db->prepare($sql);

$stmt->bindParam(':surgery_id', $surgery_id, SQLITE3_INTEGER);
$stmt->bindParam(':eligible', $eligible, SQLITE3_INTEGER);

$message = "";

if ($stmt->execute()) {
    $message = "Eligibility successfully added";
} else {
    $message = "Error updating eligibility: " . $conn->lastErrorMsg();
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
    <title>Insert Eligibility</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/doctorHeader.php");
        ?>
        <main>
            <div id="eligibility-message"><?php echo $message; ?></div>
            <a href="viewPOAanswers.php" class="back-button">Back</a><br>
        </main>
        <?php
        include ("../includes/footer.php"); 
        ?>
    </div>
</body>
</html>
