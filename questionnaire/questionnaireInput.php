<?php
session_start();
$db = new SQLITE3('C:\xampp\data\stage_3.db');

function getPOAData($poaId) {
    $db = new SQLite3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "SELECT * FROM POA_questionnaire WHERE surgery_id = :surgery_id";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':surgery_id', $poaId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $poaData = $result->fetchArray(SQLITE3_ASSOC);
    $db->close();

    return $poaData;
}

$section = isset($_GET['section']) ? $_GET['section'] : 'basic';
$surgeryId = isset($_SESSION['surgery_id']) ? $_SESSION['surgery_id'] : null;

$poa_form_id = isset($_POST['poa_form_id']) ? $_POST['poa_form_id'] : (isset($_SESSION['poa_form_id']) ? $_SESSION['poa_form_id'] : null);
$section = isset($_GET['section']) ? $_GET['section'] : 'basic';

$poaData = getPOAData($surgeryId);

$query = "SELECT * FROM POA_questionnaire WHERE surgery_id = :surgery_id";
$stmt = $db->prepare($query);
$stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
$result = $stmt->execute();

$row = $result->fetchArray();

if (isset($_POST['submit'])) {
    switch ($section) {
        case 'basic':
            if (isset($_POST['submit'])) {

                $_SESSION['form_values'] = $_POST;
            
                $stmtCheck = $db->prepare('SELECT COUNT(*) FROM POA_questionnaire WHERE surgery_id = :surgery_id');
                $stmtCheck->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
                $resultCheck = $stmtCheck->execute()->fetchArray();
            
                if ($resultCheck[0] > 0) {
                    $stmt = $db->prepare('UPDATE POA_questionnaire SET date_of_poa = :poadate, surname = :surname, first_name = :fname, address = :address, date_of_birth = :dob, sex = :sex, age = :age, telephone_number = :phone, occupation = :occupation, religion = :religion, emergency_contact_number = :emergency WHERE surgery_id = :surgery_id');
                    $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
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

                    $result = $stmt->execute();

                    if ($result === false) {
                        echo "Error executing update statement: " . $db->lastErrorMsg();
                        exit();
                    }
                } else {
                    echo "Error: Record with the given surgery ID does not exist.";
                    exit();
                }
            
                if ($result) {
                    header("Location: ../questionnaire/questionnaireInput.php?section=medical");
                    exit();
                } else {
                    echo "Error occurred while processing data.";
                }
            } else {
                echo "Error: Unable to prepare SQL statement.";
            }
            break;
        case 'medical':
            if (isset($_POST['submit'])) {

                $patientId = $_POST['patient_id'];
                $surgeryId = $_POST['surgery_id'];

                $_SESSION['form_values'] = $_POST;
                
                $stmtCheck = $db->prepare('SELECT COUNT(*) FROM POA_questionnaire WHERE surgery_id = :surgery_id');
                $stmtCheck->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
                $resultCheck = $stmtCheck->execute()->fetchArray();

            if ($resultCheck[0] > 0) {
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
            
                $stmt = $db->prepare('UPDATE POA_questionnaire SET heart_disease = :heart, MI = :MI, hypertension = :hypertension, angina = :angina, "DVT/PE" = :dvt, stroke = :stroke, diabetes = :diabetes, epilepsy = :epilepsy, jaundice = :jaundice, sickle_cell_status = :sickle, kidney_disease = :kidney, arthritis = :arthritis, asthma = :asthma WHERE surgery_id = :surgery_id');
                $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
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

            } else {
                echo "Error: Record with the given surgery ID does not exist.";
            }
            
            if ($result) {
                header("Location: ../questionnaire/questionnaireInput.php?section=additional");
                exit();
            } else {
                echo "Error occurred while processing data.";
            }
        } else {
            echo "Error: Unable to prepare SQL statement.";
        }
            break;
        case 'additional':
            if (isset($_POST['submit'])) {

                $patientId = $_POST['patient_id'];
                $surgeryId = $_POST['surgery_id'];

                $_SESSION['form_values'] = $_POST;
                
                $stmtCheck = $db->prepare('SELECT COUNT(*) FROM POA_questionnaire WHERE surgery_id = :surgery_id');
                $stmtCheck->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
                $resultCheck = $stmtCheck->execute()->fetchArray();
            
                if ($resultCheck[0] > 0) {
                $pregnant_value = ($_POST['pregnant'] == 'yes') ? 1 : 0;
            
                $stmt = $db->prepare('UPDATE POA_questionnaire SET pregnant = :pregnant, other_health_conditions = :other, previous_medication = :medication, percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
                $stmt->bindValue(':pregnant', $pregnant_value, SQLITE3_INTEGER);
                $stmt->bindValue(':other', $_POST['other'], SQLITE3_TEXT);
                $stmt->bindValue(':medication', $_POST['medication'], SQLITE3_TEXT);
                        
                $result = $stmt->execute();

            } else {
                echo "Error: Record with the given surgery ID does not exist.";
            }
                
                if ($result) {
                    header("Location: ../questionnaire/reviewAnswers.php");
                    exit();
                } else {
                    echo "Error occurred while updating the database.";
                }
            }
            break;
        default:
            echo "Invalid section parameter. Please check the URL.";
            break;
    }
}

$query = "SELECT * FROM POA_questionnaire WHERE poa_form_id = :poa_form_id";
$stmt = $db->prepare($query);
$stmt->bindValue(':poa_form_id', $poa_form_id, SQLITE3_INTEGER);
$result = $stmt->execute();

$row = $result->fetchArray();
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
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <?php if ($section === 'basic') : ?>
                <h1>Basic Details</h1>
                <form class="questionnaire-form" method="post">
    
                <input type="hidden" name="patient_id" value="<?php echo $_SESSION['patient_id']; ?>">
                <input type="hidden" name="surgery_id" value="<?php echo isset($_SESSION['surgery_id']) ? $_SESSION['surgery_id'] : ''; ?>">

                <label>Questionnaire Completion Date</label>
                <input type="date" name="surname" value="<?php echo $poaData['date_of_poa'] ?? ''; ?>">

                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo $poaData['surname'] ?? ''; ?>">

                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo $poaData['first_name'] ?? ''; ?>">

                <label>Address</label>
                <input type="text" name="address" value="<?php echo $poaData['address'] ?? ''; ?>">

                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $poaData['dob'] ?? ''; ?>">

                <label>Sex</label>
                <select name="sex">
                    <option value="">Select Sex</option>
                    <option value="female"<?php echo (isset($_POST['sex']) && $_POST['sex'] == 'female') ? ' selected' : (isset($_SESSION['form_values']['sex']) && $_SESSION['form_values']['sex'] == 'female' ? ' selected' : ''); ?>>Female</option>
                    <option value="male"<?php echo (isset($_POST['sex']) && $_POST['sex'] == 'male') ? ' selected' : (isset($_SESSION['form_values']['sex']) && $_SESSION['form_values']['sex'] == 'male' ? ' selected' : ''); ?>>Male</option>
                </select>

                <label>Age</label>
                <input type="number" name="age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : (isset($_SESSION['form_values']['age']) ? $_SESSION['form_values']['age'] : ''); ?>">

                <label>Telephone Number</label>
                <input type="number" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : (isset($_SESSION['form_values']['phone']) ? $_SESSION['form_values']['phone'] : ''); ?>">

                <label>Occupation</label>
                <input type="text" name="occupation" value="<?php echo isset($_POST['occupation']) ? $_POST['occupation'] : (isset($_SESSION['form_values']['occupation']) ? $_SESSION['form_values']['occupation'] : ''); ?>">

                <label>Religion</label>
                <input type="text" name="religion" value="<?php echo isset($_POST['religion']) ? $_POST['religion'] : (isset($_SESSION['form_values']['religion']) ? $_SESSION['form_values']['religion'] : ''); ?>">

                <label>Emergency Contact Number</label>
                <input type="number" name="emergency" value="<?php echo isset($_POST['emergency']) ? $_POST['emergency'] : (isset($_SESSION['form_values']['emergency']) ? $_SESSION['form_values']['emergency'] : ''); ?>">

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/questionnaire.php" class="back-button">Back</a> 
                </form>

            <?php elseif ($section === 'medical') : ?>
                <h1>Medical History</h1>
                <form class="questionnaire-form" method="post">
                <input type="hidden" name="patient_id" value="<?php echo $_SESSION['patient_id']; ?>">
                <input type="hidden" name="surgery_id" value="<?php echo isset($_SESSION['surgery_id']) ? $_SESSION['surgery_id'] : ''; ?>">

                <h3>Do you currently have or have you ever been diagnosed with:</h3>

                <label>Heart Disease incl pacemaker</label>
                <select name="heart">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['heart']) && $_POST['heart'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['heart']) && $_SESSION['form_values']['heart'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['heart']) && $_POST['heart'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['heart']) && $_SESSION['form_values']['heart'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>MI(heart attack)</label>
                <select name="MI">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['MI']) && $_POST['MI'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['MI']) && $_SESSION['form_values']['heart'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['MI']) && $_POST['MI'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['MI']) && $_SESSION['form_values']['MI'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Hypertension(high blood pressure)</label>
                <select name="hypertension">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['hypertension']) && $_POST['hypertension'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['hypertension']) && $_SESSION['form_values']['hypertension'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['hypertension']) && $_POST['hypertension'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['hypertension']) && $_SESSION['form_values']['hypertension'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Angina(chest pain)</label>
                <select name="angina">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['angina']) && $_POST['angina'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['angina']) && $_SESSION['form_values']['angina'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['angina']) && $_POST['angina'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['angina']) && $_SESSION['form_values']['angina'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>DVT/PE(blood clots)</label>
                <select name="dvt">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['dvt']) && $_POST['dvt'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['dvt']) && $_SESSION['form_values']['dvt'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['dvt']) && $_POST['dvt'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['dvt']) && $_SESSION['form_values']['dvt'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Stroke(CVA/TIA)</label>
                <select name="stroke">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['stroke']) && $_POST['stroke'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['stroke']) && $_SESSION['form_values']['stroke'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['stroke']) && $_POST['stroke'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['stroke']) && $_SESSION['form_values']['stroke'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Diabetes Type 1 / 2</label>
                <select name="diabetes">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['diabetes']) && $_POST['diabetes'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['diabetes']) && $_SESSION['form_values']['diabetes'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['diabetes']) && $_POST['diabetes'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['diabetes']) && $_SESSION['form_values']['diabetes'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Epilepsy</label>
                <select name="epilepsy">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['epilepsy']) && $_POST['epilepsy'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['epilepsy']) && $_SESSION['form_values']['epilepsy'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['epilepsy']) && $_POST['epilepsy'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['epilepsy']) && $_SESSION['form_values']['epilepsy'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Jaundice</label>
                <select name="jaundice">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['jaundice']) && $_POST['jaundice'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['jaundice']) && $_SESSION['form_values']['jaundice'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['jaundice']) && $_POST['jaundice'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['jaundice']) && $_SESSION['form_values']['jaundice'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Sickle Cell Disease</label>
                <select name="sickle">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['sickle']) && $_POST['sickle'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['sickle']) && $_SESSION['form_values']['sickle'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['sickle']) && $_POST['sickle'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['sickle']) && $_SESSION['form_values']['sickle'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Kidney Disease</label>
                <select name="kidney">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['kidney']) && $_POST['kidney'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['kidney']) && $_SESSION['form_values']['kidney'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['kidney']) && $_POST['kidney'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['kidney']) && $_SESSION['form_values']['kidney'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Arthritis</label>
                <select name="arthritis">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['arthritis']) && $_POST['arthritis'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['arthritis']) && $_SESSION['form_values']['arthritis'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['arthritis']) && $_POST['arthritis'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['arthritis']) && $_SESSION['form_values']['arthritis'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>Asthma</label>
                <select name="asthma">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['asthma']) && $_POST['asthma'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['asthma']) && $_SESSION['form_values']['asthma'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['asthma']) && $_POST['asthma'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['asthma']) && $_SESSION['form_values']['asthma'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/questionnaireInput.php?section=basic" class="back-button">Back</a> 
                </form>

            <?php elseif ($section === 'additional') : ?>
                <h1>Additional Details</h1>
                <form class="questionnaire-form" method="post">
                <input type="hidden" name="patient_id" value="<?php echo $_SESSION['patient_id']; ?>">
                <input type="hidden" name="surgery_id" value="<?php echo isset($_SESSION['surgery_id']) ? $_SESSION['surgery_id'] : ''; ?>">
                    
                <label>Are you currently or is there a possibility you are pregnant?</label>
                <select name="pregnant">
                    <option value="">Select Option</option>
                    <option value="yes"<?php echo (isset($_POST['pregnant']) && $_POST['pregnant'] == 'yes') ? ' selected' : (isset($_SESSION['form_values']['pregnant']) && $_SESSION['form_values']['pregnant'] == 'yes' ? ' selected' : ''); ?>>Yes</option>
                    <option value="no"<?php echo (isset($_POST['pregnant']) && $_POST['pregnant'] == 'no') ? ' selected' : (isset($_SESSION['form_values']['pregnant']) && $_SESSION['form_values']['pregnant'] == 'no' ? ' selected' : ''); ?>>No</option>
                </select>

                <label>If you have any other health conditions, please mention them below.</label>
                <input type="text" name="other" value="<?php echo isset($_POST['other']) ? $_POST['other'] : (isset($_SESSION['form_values']['other']) ? $_SESSION['form_values']['other'] : ''); ?>">

                <label>If you have took any previous medications, please mention them below.</label>
                <input type="text" name="medication" value="<?php echo isset($_POST['medication']) ? $_POST['medication'] : (isset($_SESSION['form_values']['medication']) ? $_SESSION['form_values']['medication'] : ''); ?>">

                <input type="submit" value="Save and Check Answers" name="submit">
                <a href="../questionnaire/questionnaireInput.php?section=medical" class="back-button">Back</a> 
                </form>
            <?php endif; ?>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
