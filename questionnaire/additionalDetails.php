<?php
$db = new SQLITE3('C:\xampp\data\stage_3.db');

$query = 'SELECT percentage_completed FROM POA_questionnaire WHERE poa_form_id = :questionnaire_id';
$stmt = $db->prepare($query);
$stmt->bindValue(':questionnaire_id', $questionnaire_id, SQLITE3_INTEGER);
$result = $stmt->execute();

if ($result !== false) {
    $percentageCompleted = $result;
} else {
    $percentageCompleted = 0;
}

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    $questionnaire_id = $_POST['questionnaire_id'];

    $totalFields = 27;
    $filledFields = count(array_filter($_POST));
    $percentageCompleted = ((23 + $filledFields) / $totalFields) * 100;

    $pregnant_value = ($_POST['pregnant'] == 'yes') ? 1 : 0;

    $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET pregnant = :pregnant, other_health_conditions = :other, previous_medication = :medication, percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
    $stmtUpdate->bindValue(':pregnant', $pregnant_value, SQLITE3_INTEGER);
    $stmtUpdate->bindValue(':other', $_POST['other'], SQLITE3_TEXT);
    $stmtUpdate->bindValue(':medication', $_POST['medication'], SQLITE3_TEXT);
            
    $resultUpdate = $stmtUpdate->execute();
    
    if ($resultUpdate) {
        $stmtUpdatePercentage = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
        $stmtUpdatePercentage->bindValue(':percentage_completed', $percentageCompleted, SQLITE3_FLOAT);
        $stmtUpdatePercentage->bindValue(':poa_form_id', $questionnaire_id, SQLITE3_INTEGER);

        $resultPercentage = $stmtUpdatePercentage->execute();
            
        if ($resultPercentage) {
            header("Location: ../questionnaire/testQuestionnaire.php");
            // change in future
            exit();
        } else {
            echo "Error occurred while updating the percentage completed.";
        }
    } else {
        echo "Error occurred while updating other fields.";
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

            <div>
            Total Percentage Completed: <?php echo round($percentageCompleted, 2); ?>%
            </div>

            <form method="post">

                <label>Are you currently or is there a possibility you are pregnant?</label>
                <select name="pregnant">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['pregnant']) && $_POST['pregnant'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['pregnant']) && $_SESSION['form_values']['pregnant'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['pregnant']) && $_POST['pregnant'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['pregnant']) && $_SESSION['form_values']['pregnant'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>If you have any other health conditions, please mention them below.</label>
                <input type="text" name="other" value="<?php echo isset($_POST['other']) ? $_POST['other'] : (isset($_SESSION['form_values']['other']) ? $_SESSION['form_values']['other'] : ''); ?>">

                <label>If you have took any previous medications, please mention them below.</label>
                <input type="text" name="medication" value="<?php echo isset($_POST['medication']) ? $_POST['medication'] : (isset($_SESSION['form_values']['medicatioj']) ? $_SESSION['form_values']['medication'] : ''); ?>">

                <input type="submit" value="Save and Check Answers" name="submit">
                <a href="../questionnaire/medicalHistory.php" class="back-button">Back</a> 
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
