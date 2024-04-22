<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>My Profile</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <h1>My Profile<h1> <br>
        <div class="patientMenu">
            <div class="col-3">
                <a href="viewPatientDetails.php">My Details</a> 
            </div>
            <div class="col-3">
                <a href="viewMedicalHistory.php">My Medical History</a>
            </div> 
            <div class="col-3">
                <a href="helpGuide.php">Help & Support</a>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
