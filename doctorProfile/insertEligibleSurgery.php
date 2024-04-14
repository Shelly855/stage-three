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
        <a href="viewPOAanswers.php" class="back-button">Back</a>

<?php
$db_file = 'C:\xampp\data\stage_3.db';

$conn = new SQLite3($db_file);

if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}

$surgery_id = $_POST['surgery_id'];
$eligible = isset($_POST['eligible']) ? 1 : 0; 

$sql = "UPDATE surgery SET eligible = :eligible WHERE surgery_id = :surgery_id";
$stmt = $conn->prepare($sql);

$stmt->bindParam(':surgery_id', $surgery_id, SQLITE3_INTEGER);
$stmt->bindParam(':eligible', $eligible, SQLITE3_INTEGER);

if ($stmt->execute()) {
    echo "Eligibility successfully added";
} else {
    echo "Error updating eligibility: " . $conn->lastErrorMsg();
}

$conn->close();

include ("../includes/footer.php"); 

?>
