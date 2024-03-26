

<?php include ("header.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Doctor Login</title>
</head>

<body>

    <div class="container bgColor">
        <main role="main" class="pb-3">
            <h2>Doctor Login</h2><br>


            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="SelectPatient.php">

                        <div class="form-group">
                            <label class="control-label">Username</label>

                            <input class="form-control" placeholder="Enter Username" type="text" value="<?= $username; ?>" />
                            <span class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Password</label>
                            <input type="password" placeholder="Enter Password" class="form-control" value="<?php echo $password; ?>" />
                            <span class="text-danger"></span>
                        </div>

                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary" />
                           

                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>

</body>

</html>

<?php include ("footer.php"); ?>
