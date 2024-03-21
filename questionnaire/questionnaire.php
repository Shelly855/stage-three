<!-- maybe need to separate into more than one page -->
<?php
$errorpoadate = $errorsurname = $errorfname = $erroraddress = $errordob = $errorage = $errorphone = $erroroccupation = $errorreligion = $erroremergency = $erroroption = $errorother = $errormedication = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (empty($_POST['poadate'])) {
        $errorpoadate = "Date of Questionnaire Completion is mandatory";
        $allFields = false;
    }
    if (empty($_POST['surname'])) {
        $errorsurname = "Surname is mandatory";
        $allFields = false;
    }
    if (empty($_POST['fname'])) {
        $errorfname = "First Name is mandatory";
        $allFields = false;
    }
    if (empty($_POST['address'])) {
        $erroraddress = "Address is mandatory";
        $allFields = false;
    }
    if (empty($_POST['dob'])) {
        $errordob = "Date of Birth is mandatory";
        $allFields = false;
    }
    if (empty($_POST['sex'])) {
        $erroroption = "Please pick an option";
        $allFields = false;
    }
    if (empty($_POST['age'])) {
        $errorage = "Age is mandatory";
        $allFields = false;
    }
    if (empty($_POST['phone'])) {
        $errorphone = "Telephone Number is mandatory";
        $allFields = false;
    }
    if (empty($_POST['occupation'])) {
        $erroroccupation = "Occupation is mandatory";
        $allFields = false;
    }
    if (empty($_POST['religion'])) {
        $errorreligion = "Religion is mandatory";
        $allFields = false;
    }
    if (empty($_POST['emergency'])) {
        $erroremergency = "Emergency Contact Number is mandatory";
        $allFields = false;
    }
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
    if (empty($_POST['pregnant'])) {
        $erroroption;
        $allFields = false;
    }
    if (empty($_POST['other'])) {
        $errorother = "Please pick an option";
        $allFields = false;
    }
    if (empty($_POST['medication'])) {
        $errormedication = "Please pick an option";
        $allFields = false;
    }

    if ($allFields) {
        $heart_value = ($_POST['heart'] == 'yes') ? 1 : 0;

        $stmt = $db->prepare('INSERT INTO POA_questionnaire (date_of_poa, surname, first_name, address, date_of_birth, sex, age, telephone_number, occupation, religion, emergency_contact_number, heart_disease, MI, hypertension, angina, DVT/PE, stroke, diabetes, epilepsy, jaundice, sickle_cell_status, kidney_disease, arthritis, asthma, pregnant, other_health_conditions, previous_medication) VALUES (:poadate, :sdate, :surname, :fname, :address, :dob, :sex, :age, :phone, :occupation, :religion, :emergency, :heart, :MI, :hypertension, :angina, :dvt, :stroke, :diabetes, :epilepsy, :jaundice, :sickle, :kidney, :arthritis, :pregnant, :other, :medication)');
        $stmt->bindValue(':poadate', $_POST['poadate'], SQLITE3_TEXT);
        $stmt->bindValue(':surname', $_POST['surname'], SQLITE3_TEXT);
        $stmt->bindValue(':fname', $_POST['fname'], SQLITE3_TEXT);
        $stmt->bindValue(':address', $_POST['address'], SQLITE3_TEXT);
        $stmt->bindValue(':dob', $_POST['dob'], SQLITE3_TEXT);
        $stmt->bindValue(':sex', $_POST['sex'], SQLITE3_TEXT);
        $stmt->bindValue(':age', $_POST['age'], SQLITE3_INTEGER);
        $stmt->bindValue(':phone', $_POST['phone'], SQLITE3_INTEGER);
        $stmt->bindValue(':occupation', $_POST['occupation'], SQLITE3_TEXT);
        $stmt->bindValue(':religion', $_POST['religion'], SQLITE3_TEXT);
        $stmt->bindValue(':emergency', $_POST['emergency'], SQLITE3_INTEGER);
        $stmt->bindValue(':heart', $heart_value, SQLITE3_INTEGER);
        $stmt->bindValue(':MI', $_POST['MI'], SQLITE3_INTEGER);
        $stmt->bindValue(':hypertension', $_POST['hypertension'], SQLITE3_INTEGER);
        $stmt->bindValue(':angina', $_POST['angina'], SQLITE3_INTEGER);
        $stmt->bindValue(':dvt', $_POST['dvt'], SQLITE3_INTEGER);
        $stmt->bindValue(':stroke', $_POST['stroke'], SQLITE3_INTEGER);
        $stmt->bindValue(':diabetes', $_POST['diabetes'], SQLITE3_INTEGER);
        $stmt->bindValue(':epilepsy', $_POST['epilepsy'], SQLITE3_INTEGER);
        $stmt->bindValue(':jaundice', $_POST['jaundice'], SQLITE3_INTEGER);
        $stmt->bindValue(':sickle', $_POST['sickle'], SQLITE3_INTEGER);
        $stmt->bindValue(':kidney', $_POST['kidney'], SQLITE3_INTEGER);
        $stmt->bindValue(':arthritis', $_POST['arthritis'], SQLITE3_INTEGER);
        $stmt->bindValue(':asthma', $_POST['asthma'], SQLITE3_INTEGER);
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
    <title>Questionnaire</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/header.php");
        ?>  
        <main>
            <h1>Questionnaire</h1>
            <form method="post">
                <label>Questionnaire Completion Date</label>
                <input type="date" name="date" value="<?php echo isset($_POST['poadate']) ? $_POST['poadate'] : ''; ?>">
                <span class="blank-error"><?php echo $errorpoadate; ?></span>

                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorsurname; ?></span>

                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                <span class="blank-error"><?php echo $errorfname; ?></span>

                <label>Address</label>
                <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>">
                <span class="blank-error"><?php echo $erroraddress; ?></span>

                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
                <span class="blank-error"><?php echo $errordob; ?></span>

                <label>Sex</label>
                <select name="sex">
                    <option value="">Select Sex</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                </select>
                <span class="blank-error"><?php echo $erroroption; ?></span>

                <label>Age</label>
                <input type="number" name="age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : ''; ?>">
                <span class="blank-error"><?php echo $errorage; ?></span>

                <label>Telephone Number</label>
                <input type="number" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                <span class="blank-error"><?php echo $errorphone; ?></span>

                <label>Occupation</label>
                <input type="text" name="occupation" value="<?php echo isset($_POST['occupation']) ? $_POST['occupation'] : ''; ?>">
                <span class="blank-error"><?php echo $erroroccupation; ?></span>

                <label>Religion</label>
                <input type="text" name="religion" value="<?php echo isset($_POST['religion']) ? $_POST['religion'] : ''; ?>">
                <span class="blank-error"><?php echo $errorreligion; ?></span>

                <label>Emergency Contact Number</label>
                <input type="number" name="emergency" value="<?php echo isset($_POST['emergency']) ? $_POST['emergency'] : ''; ?>">
                <span class="blank-error"><?php echo $erroremergency; ?></span>

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
                <select name="hypertension">
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

                <!-- unfinished -->

                <input type="submit" value="Complete Questionnaire" name="submit">
                <a href="../index.php" class="back-button">Back</a> 
                <!-- link will probably need to be changed -->
                <!-- save answers button -->
                <!-- percentage completed -->
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
