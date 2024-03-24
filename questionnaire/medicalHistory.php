<?php
$erroroption = "Please pick an option";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    $totalFields = 13;
    $filledFields = count(array_filter($_POST));
    $percentageCompleted = ($filledFields / $totalFields) * 100;

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

        function updateRecordWithSection2Data($db, $entryId, $section2Data){
        $stmt = $db->prepare('INSERT INTO POA_questionnaire (heart_disease, MI, hypertension, angina, DVT/PE, stroke, diabetes, epilepsy, jaundice, sickle_cell_status, kidney_disease, arthritis, asthma) VALUES (:heart, :MI, :hypertension, :angina, :dvt, :stroke, :diabetes, :epilepsy, :jaundice, :sickle, :kidney, :arthritis, :asthsma)');
        $stmt->bindValue(':heart', $heart_value, SQLITE3_INTEGER);
        $stmt->bindValue(':MI', $MI_value, SQLITE3_INTEGER);
        $stmt->bindValue(':hypertension', $hypertension_value, SQLITE3_INTEGER);
        $stmt->bindValue(':angina', $angina_value, SQLITE3_INTEGER);
        $stmt->bindValue(':dvt', $dvt_value, SQLITE3_INTEGER);
        $stmt->bindValue(':stroke', $stroke_value, SQLITE3_INTEGER);
        $stmt->bindValue(':diabetes', $diabetes_value, SQLITE3_INTEGER);
        $stmt->bindValue(':epilepsy', $epilepsy_value, SQLITE3_INTEGER);
        $stmt->bindValue(':jaundice', $jaundice_value, SQLITE3_INTEGER);
        $stmt->bindValue(':sickle', $sickle_value, SQLITE3_INTEGER);
        $stmt->bindValue(':kidney', $kidney_value, SQLITE3_INTEGER);
        $stmt->bindValue(':arthritis', $arthritis_value, SQLITE3_INTEGER);
        $stmt->bindValue(':asthma', $asthma_value, SQLITE3_INTEGER);

        $result = $stmt->execute();
        }
    
        if ($result) {
            $newEntryId = $db->lastInsertRowID();
            $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
            $stmtUpdate->bindValue(':percentage_completed', $percentage_completed, SQLITE3_FLOAT);
            $stmtUpdate->bindValue(':poa_form_id', $newEntryId, SQLITE3_INTEGER);
            $stmtUpdate->execute();
        
            header("Location: ../questionnaire/additionalDetails.php");
            exit();
        } else {
            echo "Error occurred while inserting data.";
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
            Percentage Completed: <?php echo round($percentageCompleted, 2); ?>%
            </div>
        
            <form method="post">
                <h3>Do you currently have or have you ever been diagnosed with:</h3>

                <label>Heart Disease incl pacemaker</label>
                <select name="heart">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>MI(heart attack)</label>
                <select name="MI">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Hypertension(high blood pressure)</label>
                <select name="hypertension">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Angina(chest pain)</label>
                <select name="angina">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>DVT/PE(blood clots)</label>
                <select name="dvt">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Stroke(CVA/TIA)</label>
                <select name="stroke">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Diabetes Type 1 / 2</label>
                <select name="diabetes">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Epilepsy</label>
                <select name="epilepsy">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Jaundice</label>
                <select name="jaundice">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Sickle Cell Disease</label>
                <select name="sickle">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Kidney Disease</label>
                <select name="kidney">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Arthritis</label>
                <select name="arthritis">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Asthma</label>
                <select name="asthma">
                    <option value="">Select Option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/basicDetails.php" class="back-button">Back</a> 
                <!-- percentage completed -->
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>