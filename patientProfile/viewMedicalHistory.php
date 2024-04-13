<?php
 session_start();
$db = new SQLite3('C:\xampp\data\stage_3.db');

if (!$db) {
    die("Failed to connect to the database.");
}
$patientId = $_SESSION['patient_id'];
$query = "SELECT * FROM patient WHERE user_id='$patient'";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>My Details</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main> 
         <h1>Medical History</h1>
         <table class="detailsTable">
            <tr> 
                <td>User ID</td>
                <td><?php echo $row['user_id']; ?></td>
            </tr>            
            <tr> 
                <td>Medical Conditions</td>
                <td><?php echo $row['medical_conditions']; ?></td>
            </tr>
            <tr> 
                <td>Previous Medical Conditions</td>
                <td><?php echo $row['previous_medical_conditions']; ?></td>
            </tr>
</table>  
 </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
