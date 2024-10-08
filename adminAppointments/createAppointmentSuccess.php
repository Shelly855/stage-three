<?php
    $result = isset($_GET['createAppointment']) ? $_GET['createAppointment'] : '';

    $message = ($result) ? "Appointment Created Successfully!" : "Appointment Creation Failed!";

    $title = $message;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/adminHeader.php");

            $db = new SQLITE3('C:\xampp\data\stage_3.db');
        ?>  
        <main>
            <h1><?php echo $message; ?></h1>
            <form action="../adminAppointments/adminAppointments.php">
                <input type="submit" value="Back" />
            </form>
        </main>
        <?php
            include("../includes/footer.php");

            $db->close();
        ?>
    </div>
</body>
</html>
