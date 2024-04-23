<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Help & Support</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <div class="helpGuide">
                <h1>Help Guide<h1> 
                    <h2>How do I register?</h2>
                    <p>Patients do not need to register, our systems administrator will register each patient.</p>
                    <h2>How do I access the system?</h2>
                    <p>Patients will receive their login credentials from us. Patients must log in with their personal username and password and this will allow them to use the system. </p>
                    <h2>Request a paper assessment if you are unable to access the digital system.</h2>
                    <button class="requestBtn"><a href="../patientProfile/requestSubmitted.php">Request paper assessment</a></button>                
                    <h2>Contact Us if you have any more questions.</h2>
                    <p>0300 311 22 33</p>
            </div>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
