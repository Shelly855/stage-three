<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Questionnaire Submitted</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <h1>Questionnaire Successfully Submitted!</h1>
            <form action="../patientProfile/dashboardPatient.php">
                <input type="submit" value="Back" />
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
