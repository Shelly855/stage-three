<!-- error messages, save answers -->

<?php
session_start();
$erroroption = "Please pick an option";
$allFields = true;

$db = new SQLITE3('C:\xampp\data\stage_3.db');

$query = 'SELECT percentage_completed FROM POA_questionnaire';

$result = $db->querySingle($query);

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
    $percentageCompleted = ((10 + $filledFields) / $totalFields) * 100;

    $_SESSION['form_values'] = $_POST;

    if (empty($_POST['heart'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['MI'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['hypertension'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['angina'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['dvt'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['stroke'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['diabetes'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['epilepsy'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['jaundice'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['sickle'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['kidney'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['arthritis'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['asthma'])) {
        $erroroption;
        $allFields = false;
    }

    if ($allFields) {
        $heart_value = ($_POST['heart'] == 'yes') ? 1 : 0;
        $MI_value = ($_POST['MI'] == 'yes') ? 1 : 0;
        $hypertension_value = ($_POST['hypertension'] == 'yes') ? 1 : 0;
        $angina_value = ($_POST['angina'] == 'yes') ? 1 : 0;
        $dvt_value = ($_POST['dvt'] == 'yes') ? 1 : 0;
        $stroke_value = ($_POST['stroke'] == 'yes') ? 1 : 0;
        $diabetes_value = ($_POST['diabetes'] == 'yes') ? 1 : 0;
        $epilepsy_value = ($_POST['epilepsy'] == 'yes') ? 1 : 0;
        $jaundice_value = ($_POST['jaundice'] == 'yes') ? 1 : 0;
        $sickle_value = ($_POST['sickle'] == 'yes') ? 1 : 0;
        $kidney_value = ($_POST['kidney'] == 'yes') ? 1 : 0;
        $arthritis_value = ($_POST['arthritis'] == 'yes') ? 1 : 0;
        $asthma_value = ($_POST['asthma'] == 'yes') ? 1 : 0;

        $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET heart_disease = :heart, MI = :MI, hypertension = :hypertension, angina = :angina, "DVT/PE" = :dvt, stroke = :stroke, diabetes = :diabetes, epilepsy = :epilepsy, jaundice = :jaundice, sickle_cell_status = :sickle, kidney_disease = :kidney, arthritis = :arthritis, asthma = :asthma, percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
        $stmtUpdate->bindValue(':heart', $heart_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':MI', $MI_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':hypertension', $hypertension_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':angina', $angina_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':dvt', $dvt_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':stroke', $stroke_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':diabetes', $diabetes_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':epilepsy', $epilepsy_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':jaundice', $jaundice_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':sickle', $sickle_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':kidney', $kidney_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':arthritis', $arthritis_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':asthma', $asthma_value, SQLITE3_INTEGER);
        $stmtUpdate->bindValue(':percentage_completed', $percentageCompleted, SQLITE3_FLOAT);
        $stmtUpdate->bindValue(':poa_form_id', $questionnaire_id, SQLITE3_INTEGER);

        $result = $stmtUpdate->execute();
        }
    
        if ($result) {
            $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
            $stmtUpdate->bindValue(':percentage_completed', $percentageCompleted, SQLITE3_FLOAT);
            header("Location: ../questionnaire/additionalDetails.php");
            exit();
        } else {
            echo "Error occurred while inserting data.";
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
    <title>Medical History</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/header.php");
        ?>  
        <main>
            <h1>Medical History</h1>

            <div>
            Total Percentage Completed: <?php echo round($percentageCompleted, 2); ?>%
            </div>
        
            <form method="post">
            <input type="hidden" name="questionnaire_id" value="<?php echo $questionnaire_id; ?>">

                <h3>Do you currently have or have you ever been diagnosed with:</h3>

                <label>Heart Disease incl pacemaker</label>
                <select name="heart">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['heart']) && $_POST['heart'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['heart']) && $_SESSION['form_values']['heart'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['heart']) && $_POST['heart'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['heart']) && $_SESSION['form_values']['heart'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>MI(heart attack)</label>
                <select name="MI">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['MI']) && $_POST['MI'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['heart']) && $_SESSION['form_values']['heart'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['MI']) && $_POST['MI'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['MI']) && $_SESSION['form_values']['MI'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Hypertension(high blood pressure)</label>
                <select name="hypertension">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['hypertension']) && $_POST['hypertension'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['hypertension']) && $_SESSION['form_values']['hypertension'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['hypertension']) && $_POST['hypertension'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['hypertension']) && $_SESSION['form_values']['hypertension'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Angina(chest pain)</label>
                <select name="angina">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['angina']) && $_POST['angina'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['angina']) && $_SESSION['form_values']['angina'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['angina']) && $_POST['angina'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['angina']) && $_SESSION['form_values']['angina'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>DVT/PE(blood clots)</label>
                <select name="dvt">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['dvt']) && $_POST['dvt'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['dvt']) && $_SESSION['form_values']['dvt'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['dvt']) && $_POST['dvt'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['dvt']) && $_SESSION['form_values']['dvt'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Stroke(CVA/TIA)</label>
                <select name="stroke">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['stroke']) && $_POST['stroke'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['stroke']) && $_SESSION['form_values']['stroke'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['stroke']) && $_POST['stroke'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['stroke']) && $_SESSION['form_values']['stroke'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Diabetes Type 1 / 2</label>
                <select name="diabetes">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['diabetes']) && $_POST['diabetes'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['diabetes']) && $_SESSION['form_values']['diabetes'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['diabetes']) && $_POST['diabetes'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['diabetes']) && $_SESSION['form_values']['diabetes'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Epilepsy</label>
                <select name="epilepsy">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['epilepsy']) && $_POST['epilepsy'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['epilepsy']) && $_SESSION['form_values']['epilepsy'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['epilepsy']) && $_POST['epilepsy'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['epilepsy']) && $_SESSION['form_values']['epilepsy'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Jaundice</label>
                <select name="jaundice">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['jaundice']) && $_POST['jaundice'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['jaundice']) && $_SESSION['form_values']['jaundice'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['jaundice']) && $_POST['jaundice'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['jaundice']) && $_SESSION['form_values']['jaundice'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Sickle Cell Disease</label>
                <select name="sickle">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['sickle']) && $_POST['sickle'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['sickle']) && $_SESSION['form_values']['sickle'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['sickle']) && $_POST['sickle'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['sickle']) && $_SESSION['form_values']['sickle'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Kidney Disease</label>
                <select name="kidney">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['kidney']) && $_POST['kidney'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['kidney']) && $_SESSION['form_values']['kidney'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['kidney']) && $_POST['kidney'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['kidney']) && $_SESSION['form_values']['kidney'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Arthritis</label>
                <select name="arthritis">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['arthritis']) && $_POST['arthritis'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['arthritis']) && $_SESSION['form_values']['arthritis'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['arthritis']) && $_POST['arthritis'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['arthritis']) && $_SESSION['form_values']['arthritis'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Asthma</label>
                <select name="asthma">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['asthma']) && $_POST['asthma'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['asthma']) && $_SESSION['form_values']['asthma'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['asthma']) && $_POST['asthma'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['asthma']) && $_SESSION['form_values']['asthma'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/basicDetails.php" class="back-button">Back</a> 
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
