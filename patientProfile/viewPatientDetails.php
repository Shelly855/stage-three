<?php
session_start();
include '../includes/dbConnection.php';

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT p.patient_id, u.username, u.first_name, u.surname, p.date_of_birth, p.email, p.mobile_number
          FROM patients p
          JOIN users u ON p.user_id = u.user_id
          WHERE p.patient_id='$patient'";
$res = $db->query($query);


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
            <?php
            if ($res) {
                $row = $res->fetchArray(SQLITE3_ASSOC);
                if ($row !== false) {
            ?>
            <h1>Personal Details</h1>
            <table class="details-table">
                <tr> 
                    <td>Patient ID</td>
                    <td><?php echo $row['patient_id']; ?></td>
                </tr>
                <tr> 
                    <td>Username</td>
                    <td><?php echo $row['username']; ?></td>
                </tr>            
                <tr> 
                    <td>First Name</td>
                    <td><?php echo $row['first_name']; ?></td>
                </tr>
                <tr> 
                    <td>Surname</td>
                    <td><?php echo $row['surname']; ?></td>
                </tr>            
                <tr> 
                    <td>Date of Birth</td>
                    <td><?php echo $row['date_of_birth']; ?></td>
                </tr>
                <tr> 
                    <td>Email</td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <tr> 
                    <td>Mobile Number</td>
                    <td><?php echo $row['mobile_number']; ?></td>
                </tr>
            </table>  
            <?php
            } 
            else {
                  echo '<h1>No results found. </h1>';
                  echo '<p class="backPatient"><a href="../patientProfile/patientProfile.php">Back</a></p>';
           }
           } 
           else {
                 echo "Error executing query.";
           }
           ?>
        </main>
        <?php 
            include("../includes/footer.php"); 
        ?>
    </div>
</body>
</html>
