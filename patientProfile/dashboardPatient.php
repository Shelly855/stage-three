<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Dashboard</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main> 
            <h1>Welcome <?php echo $username; ?></h1>

        <h1>Welcome Sabiha</h1>

        <div class="dashboardBoxes">
            <div class="pageLinks">
                <p class="headings">Your Appointments</p>
                <a href="">Past and Upcoming Appointments</a> 
            </div>
            <div class="pageLinks">
                <p class="headings"> Need To Complete </p>
                <a href="">Pre-operative assessment</a>
            </div> 
            <div class="viewProfileButton">
                <br>
                <a href="patientProfile.php" class="viewProfile">View Your Profile</a>
            </div>


            

        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
