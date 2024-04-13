<?php
session_start();
$db = new SQLITE3('C:\xampp\data\stage_3.db');

$totalFields = 27;
$percentageCompleted = 0;

if (isset($_POST['submit'])) {

    $patientId = $_SESSION['patient_id'];

    $filledFields = count(array_filter($_POST));
    $percentageCompleted = ($filledFields / $totalFields) * 100;

    $_SESSION['form_values'] = $_POST;

    $stmtCheck = $db->prepare('SELECT COUNT(*) FROM POA_questionnaire WHERE surgery_id = :surgery_id');
    $stmtCheck->bindValue(':surgery_id', $patientId, SQLITE3_INTEGER);
    $resultCheck = $stmtCheck->execute()->fetchArray();

    if ($resultCheck[0] > 0) {
        $stmt = $db->prepare('UPDATE POA_questionnaire SET date_of_poa = :poadate, percentage_completed = :percentage, surname = :surname, first_name = :fname, address = :address, date_of_birth = :dob, sex = :sex, age = :age, telephone_number = :phone, occupation = :occupation, religion = :religion, emergency_contact_number = :emergency WHERE surgery_id = :surgery_id');
    } else {
        $stmt = $db->prepare('INSERT INTO POA_questionnaire (surgery_id, date_of_poa, percentage_completed, surname, first_name, address, date_of_birth, sex, age, telephone_number, occupation, religion, emergency_contact_number) VALUES (:surgery_id, :poadate, :percentage, :surname, :fname, :address, :dob, :sex, :age, :phone, :occupation, :religion, :emergency)');
    }

    $stmt->bindValue(':surgery_id', $patientId, SQLITE3_INTEGER);
    $stmt->bindValue(':poadate', $_POST['poadate'], SQLITE3_TEXT);
    $stmt->bindValue(':percentage', $percentageCompleted, SQLITE3_FLOAT);
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

    if ($result) {
        header("Location: ../questionnaire/medicalHistory.php");
        exit();
    } else {
        echo "Error occurred while processing data.";
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
    <title>Basic Details</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <h1>Basic Details</h1>

            <div>
            <?php
            if (isset($percentageCompleted)) {
                echo "Total Percentage Completed: " . round($percentageCompleted, 2) . "%";
            } else {
                echo "Total Percentage Completed: 0%";
            }
            ?>
            </div>
            <form class="questionnaire-form" method="post">
                <label>Questionnaire Completion Date</label>
                <input type="date" name="poadate" value="<?php echo isset($_POST['poadate']) ? $_POST['poadate'] : (isset($_SESSION['form_values']['poadate']) ? $_SESSION['form_values']['poadate'] : ''); ?>">

                <label>Surname</label>
                <input type="text" name="surname" value="<?php echo isset($_POST['surname']) ? $_POST['surname'] : (isset($_SESSION['form_values']['surname']) ? $_SESSION['form_values']['surname'] : ''); ?>">

                <label>First Name</label>
                <input type="text" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : (isset($_SESSION['form_values']['fname']) ? $_SESSION['form_values']['fname'] : ''); ?>">

                <label>Address</label>
                <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : (isset($_SESSION['form_values']['address']) ? $_SESSION['form_values']['address'] : ''); ?>">

                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : (isset($_SESSION['form_values']['dob']) ? $_SESSION['form_values']['dob'] : ''); ?>">

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
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
