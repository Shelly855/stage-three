<?php
session_start();
include '../includes/dbConnection.php';

function getPOAData($poaId) {
    include '../includes/dbConnection.php';

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

function checkRecordExists($db, $surgeryId) {
    $stmtCheck = $db->prepare('SELECT COUNT(*) FROM POA_questionnaire WHERE surgery_id = :surgery_id');
    $stmtCheck->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
    $resultCheck = $stmtCheck->execute()->fetchArray();

    return ($resultCheck[0] > 0);
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

                $patientId = $_POST['patient_id'];
                $surgeryId = $_POST['surgery_id'];
            
                if (checkRecordExists($db, $surgeryId)) {
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

                if (checkRecordExists($db, $surgeryId)) {
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
            
                if (checkRecordExists($db, $surgeryId)) {
                $pregnant_value = ($_POST['pregnant'] == 'yes') ? 1 : 0;
            
                $stmt = $db->prepare('UPDATE POA_questionnaire SET pregnant = :pregnant, other_health_conditions = :other, previous_medication = :medication, percentage_completed = :percentage_completed WHERE surgery_id = :surgery_id');
                $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
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

                <label>Questionnaire Completion Date (dd/mm/yy)</label>
                <input type="text" name="poadate" value="<?php echo $poaData['date_of_poa'] ?? ''; ?>">

                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo $poaData['surname'] ?? ''; ?>">

                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo $poaData['first_name'] ?? ''; ?>">

                <label>Address</label>
                <input type="text" name="address" value="<?php echo $poaData['address'] ?? ''; ?>">

                <label>Date of Birth (dd/mm/yy)</label>
                <input type="text" name="dob" value="<?php echo $poaData['date_of_birth'] ?? ''; ?>">

                <label>Sex</label>
                <select name="sex">
                    <option value="">Select Sex</option>
                    <option value="female" <?php if(isset($poaData['sex']) && $poaData['sex'] == 'female') echo 'selected'; ?>>Female</option>
                    <option value="male" <?php if(isset($poaData['sex']) && $poaData['sex'] == 'male') echo 'selected'; ?>>Male</option>
                </select>

                <label>Age</label>
                <input type="number" name="age" value="<?php echo $poaData['age'] ?? ''; ?>">

                <label>Telephone Number</label>
                <input type="number" name="phone" value="<?php echo $poaData['telephone_number'] ?? ''; ?>">

                <label>Occupation</label>
                <input type="text" name="occupation" value="<?php echo $poaData['occupation'] ?? ''; ?>">

                <label>Religion</label>
                <input type="text" name="religion" value="<?php echo $poaData['religion'] ?? ''; ?>">

                <label>Emergency Contact Number</label>
                <input type="number" name="emergency" value="<?php echo $poaData['emergency_contact_number'] ?? ''; ?>">

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
                    <option value="yes" <?php if(isset($poaData['heart_disease']) && $poaData['heart_disease'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['heart_disease']) && $poaData['heart_disease'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>MI(heart attack)</label>
                <select name="MI">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['MI']) && $poaData['MI'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['MI']) && $poaData['MI'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Hypertension(high blood pressure)</label>
                <select name="hypertension">
                    <option value="">Select Option</option>
                    <option value="1" <?php if(isset($poaData['hypertension']) && $poaData['hypertension'] == '1') echo 'selected'; ?>>Yes</option>
                    <option value="0" <?php if(isset($poaData['hypertension']) && $poaData['hypertension'] == '0') echo 'selected'; ?>>No</option>
                </select>

                <label>Angina(chest pain)</label>
                <select name="angina">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['angina']) && $poaData['angina'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['angina']) && $poaData['angina'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>DVT/PE(blood clots)</label>
                <select name="dvt">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['DVT/PE']) && $poaData['DVT/PE'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['DVT/PE']) && $poaData['DVT/PE'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Stroke(CVA/TIA)</label>
                <select name="stroke">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['stroke']) && $poaData['stroke'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['stroke']) && $poaData['stroke'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Diabetes Type 1 / 2</label>
                <select name="diabetes">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['diabetes']) && $poaData['diabetes'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['diabetes']) && $poaData['diabetes'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Epilepsy</label>
                <select name="epilepsy">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['epilepsy']) && $poaData['epilepsy'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['epilepsy']) && $poaData['epilepsy'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Jaundice</label>
                <select name="jaundice">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['jaundice']) && $poaData['jaundice'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['jaundice']) && $poaData['jaundice'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Sickle Cell Disease</label>
                <select name="sickle">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['sickle_cell_status']) && $poaData['sickle_cell_status'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['sickle_cell_status']) && $poaData['sickle_cell_status'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Kidney Disease</label>
                <select name="kidney">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['kidney_disease']) && $poaData['kidney_disease'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['kidney_disease']) && $poaData['kidney_disease'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Arthritis</label>
                <select name="arthritis">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['arthritis']) && $poaData['arthritis'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['arthritis']) && $poaData['arthritis'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>Asthma</label>
                <select name="asthma">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['asthma']) && $poaData['asthma'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['asthma']) && $poaData['asthma'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/questionnaireInput.php?section=basic" class="back-button">Back to Basic Details</a> 
                </form>

            <?php elseif ($section === 'additional') : ?>
                <h1>Additional Details</h1>
                <form class="questionnaire-form" method="post">
                <input type="hidden" name="patient_id" value="<?php echo $_SESSION['patient_id']; ?>">
                <input type="hidden" name="surgery_id" value="<?php echo isset($_SESSION['surgery_id']) ? $_SESSION['surgery_id'] : ''; ?>">
                    
                <label>Are you currently or is there a possibility you are pregnant?</label>
                <select name="pregnant">
                    <option value="">Select Option</option>
                    <option value="yes" <?php if(isset($poaData['pregnant']) && $poaData['pregnant'] == 1) echo 'selected'; ?>>Yes</option>
                    <option value="no" <?php if(isset($poaData['pregnant']) && $poaData['pregnant'] == 0) echo 'selected'; ?>>No</option>
                </select>

                <label>If you have any other health conditions, please mention them below.</label>
                <input type="text" name="other" value="<?php echo $poaData['other_health_conditions'] ?? ''; ?>">

                <label>If you have took any previous medications, please mention them below.</label>
                <input type="text" name="medication" value="<?php echo $poaData['previous_medication'] ?? ''; ?>">

                <input type="submit" value="Save and Check Answers" name="submit">
                <a href="../questionnaire/questionnaireInput.php?section=medical" class="back-button">Back to Medical History</a> 
                </form>
            <?php endif; ?>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
