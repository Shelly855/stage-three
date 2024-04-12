<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Doctorlogin.html"); 
    exit;
}
$username = $_SESSION['username'];
?>

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
        <h1>Welcome</h1><br>


            
       
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
