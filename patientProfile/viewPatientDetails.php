<?php
 session_start();
$db = new SQLite3('C:\xampp\data\stage_3.db');

if (!$db) {
    die("Failed to connect to the database.");
}

$patient = $_SESSION['patient_id'];
$query = "SELECT * FROM patients WHERE patient_id='$patient'";
$res= new SQLite3_query($query);
$row = new SQLite3_fetch_array($res);
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
         <h1>Personal Details</h1>
         <table class="detailsTable">
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
 </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>

