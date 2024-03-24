<?php
$erroroption = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (empty($_POST['pregnant'])) {
        $erroroption = "Please pick an option.";
        $allFields = false;
    }

    if ($allFields == true && isset($_POST['other']) && isset($_POST['medication'])) {
        $pregnant_value = ($_POST['pregnant'] == 'yes') ? 1 : 0;

        $stmt = $db->prepare('INSERT INTO POA_questionnaire (pregnant, other_health_conditions, previous_medication) VALUES (:pregnant, :other, :medication)');
        $stmt->bindValue(':pregnant', $_POST['pregnant'], SQLITE3_INTEGER);
        $stmt->bindValue(':other', $_POST['other'], SQLITE3_TEXT);
        $stmt->bindValue(':medication', $_POST['medication'], SQLITE3_TEXT);
            
        $result = $stmt->execute();
    
        if ($result) {
            header("Location: ../questionnaire/completeQuestionnaireSuccess.php?completeQuestionnaire=success");
            // might need to be changed
            exit();
        } else {
            echo "Error completing questionnaire";
        }
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Additional Details</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/header.php");
        ?>  
        <main>
            <h1>Additional Details</h1>
            <form method="post">

                <label>Are you currently or is there a possibility you are pregnant?</label>
                <select name="pregnant">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>If you have any other health conditions, please mention them below.</label>
                <input type="text" name="other" value="<?php echo isset($_POST['other']) ? $_POST['other'] : ''; ?>">

                <label>If you have took any previous medications, please mention them below.</label>
                <input type="text" name="medication" value="<?php echo isset($_POST['medication']) ? $_POST['medication'] : ''; ?>">

                <input type="submit" value="Save and Check Answers" name="submit">
                <a href="../questionnaire/medicalHistory.php" class="back-button">Back</a> 
                <!-- percentage completed -->
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
