<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container"> 
        <?php
            session_start();
            include("../includes/adminHeader.php");

            $username = $_SESSION['username'];
            $role = $_SESSION['role'];
            $role = ucfirst($role);
        ?>  
        <main> 
            <h1>Welcome, <?php echo $role; ?> <?php echo $username; ?></h1>

            <div class="dashboardBoxes">
                <div class="pageLinks">
                    <p class="headings">Manage Profiles</p>
                    <a href="../adminUsers/adminUsers.php">Users</a></br>
                    <a href="../adminPatientProfiles/adminPatientProfiles.php">Patients</a> 
                </div>
                <div class="pageLinks">
                    <p class="headings">Surgery & Appointments</p>
                    <a href="../adminProfile/adminProposedSurgery.php">Surgery</a>
                    <a href="../adminAppointments/adminAppointments.php">Patient Appointments</a>
                </div> 
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
