<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Deletion</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/adminHeader.php");

            $deleted = isset($_GET['deleted']) && $_GET['deleted'] === 'true';

            $message = ($deleted) ? "Patient Profile Deleted Successfully!" : "Patient Profile Deletion Failed!";
        ?>  
        <main>
            <h1><?php echo $message; ?></h1>
            <form action="../adminPatientProfiles/adminPatientProfiles.php">
                <input type="submit" value="Back" />
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>

