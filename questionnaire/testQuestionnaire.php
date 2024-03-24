<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Questionnaire</title>
</head>
<body>
    <div class="container">
        <?php
            include("../includes/header.php");
        ?>
        <main>
            <h1>Questionnaire</h1>

            <form action="../questionnaire/questionnaire.php">
                <input type="submit" value="Complete Questionnaire" />
            </form>

        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>