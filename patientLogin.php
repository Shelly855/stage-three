<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Login</title>
</head>

<body>
    <div class="container">
        <?php
        include ("includes/header.php");
        require_once ("checkPatientLogin.php");
        ?>
        <main role="main" class="pb-3">
            <h2>Patient Login</h2><br>
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="checkPatientLogin.php">

                        <div class="form-group">
                            <label class="control-label">Username</label>
                            <input class="form-control" name="username" placeholder="Enter Username" type="text" />
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" name="password" placeholder="Enter Password" class="form-control" />
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <?php
        include ("includes/footer.php");
        ?>
    </div>

</body>

</html>


<?php
    session_start();

    require_once('includes/header.php');

    if (isset($_SESSION['role']) && isset($navigationLinks[$_SESSION['role']])) {
        $role = $_SESSION['role'];

        echo '<ul class="nav-menu">';
        foreach ($navigationLinks[$role] as $title => $link) {
            echo '<li><a href="' . $link . '">' . $title . '</a></li>';
        }
        echo '</ul>';
    } else {
        header("Location: patientLogin.php");
        exit();                                                                               //u should prob take away the header-config line and the
    }                                                                                            //navigation links thing
?> 



