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
                <td>User ID</td>
                <td><?php echo $row['user_id']; ?></td>
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
                <td>Email</td>
                <td><?php echo $row['email']; ?></td>
            </tr>
            <tr> 
                <td>Mobile Number</td>
                <td><?php echo $row['mobile_number']; ?></td>
            </tr>
            <tr> 
                <td>Date of Birth</td>
                <td><?php echo $row['date_of_birth']; ?></td>
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
