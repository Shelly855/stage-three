<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Doctor Dashboard</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/doctorHeader.php");
        ?>  
        <main> 
        <h1>Welcome To Your Dashboard</h1>
            <div class="dashboardBoxes">
                <div class="pageLinks">
                    <p class="headings">Profiles</p>
                    <a href="../doctorProfile/viewPatients.php">Patients</a></br> 
                </div>
                <div class="pageLinks">
                    <p class="headings">Surgery & Pre-Operative Assessment</p>
                    <a href="../proposedSurgery/proposedSurgery.php">Surgery</a>
                    <a href="../doctorProfile/viewPOAanswers.php">Pre-Operative Assessment Answers</a>
                </div> 
                <div class="pageLinks">
                    <p class="headings">Appointments</p>
                    <a href="../doctorAppointments/doctorAppointments.php">Patient Appointments</a>
                </div>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
