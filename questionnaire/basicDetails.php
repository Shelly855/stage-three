<?php
session_start();
$db = new SQLITE3('C:\xampp\data\stage_3.db');

if (isset($_POST['submit'])) {

    $patientId = $_SESSION['patient_id'];

    $totalFields = 27;
    $filledFields = count(array_filter($_POST));
    $percentageCompleted = ($filledFields / $totalFields) * 100;

    $_SESSION['form_values'] = $_POST;

    $stmt = $db->prepare('INSERT INTO POA_questionnaire (surgery_id, date_of_poa, percentage_completed, surname, first_name, address, date_of_birth, sex, age, telephone_number, occupation, religion, emergency_contact_number) VALUES (:surgery_id, :poadate, :percentage, :surname, :fname, :address, :dob, :sex, :age, :phone, :occupation, :religion, :emergency)');
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
        $newEntryId = $db->lastInsertRowID();
        $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
        $stmtUpdate->bindValue(':percentage_completed', $percentageCompleted, SQLITE3_FLOAT);
        $stmtUpdate->bindValue(':poa_form_id', $newEntryId, SQLITE3_INTEGER);
        $stmtUpdate->execute();

        header("Location: ../questionnaire/medicalHistory.php");
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
    <title>Basic Details</title>
</head>
<body>
    <div class="container"> 
        <?php
            include("../includes/header.php");
        ?>  
        <main>
            <h1>Basic Details</h1>

            <div>
            Total Percentage Completed: <?php echo round($percentageCompleted, 2); ?>%
            </div>
            <form method="post">
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
                <a href="../questionnaire/testQuestionnaire.php" class="back-button">Back</a> 
                <!-- link will probably need to be changed -->
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
