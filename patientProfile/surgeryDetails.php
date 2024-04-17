<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT * FROM surgery WHERE patient_id='$patient'";
$res = $db->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Surgery Details</title>
</head>
<body>
    <div class="container"> 
            <?php 
                 include("../includes/patientHeader.php"); 
            ?>  
            <main> 
                <?php
                if ($res) {
                    $row = $res->fetchArray(SQLITE3_ASSOC);
    
                    if ($row !== false) {
                ?>
                <h1>Information about your surgery</h1>
                <table class="detailsTable">                    
                    <tr> 
                        <td>Patient ID</td>
                        <td><?php echo $row['patient_id']; ?></td>
                    </tr> 
                    <tr> 
                        <td>Surgery ID</td>
                        <td><?php echo $row['surgery_id']; ?></td>
                    </tr>
                    <tr> 
                        <td>Surgery Name</td>
                        <td><?php echo $row['surgery_name']; ?></td>
                    </tr>
                </table>  
                <?php
                } 
                else {
                    echo "<h1>You have no surgery booked</h1>";
                }
                } 
                else {
                    echo "<h1>Error</h1>";
                }
                ?>
            </main>
        <?php 
            include("../includes/footer.php"); 
        ?>    
    </div>
</body>
</html>
