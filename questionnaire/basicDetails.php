<!-- unfinished -->
<?php
$errorpoadate = $errorsurname = $errorfname = $erroraddress = $errordob = $errorage = $errorphone = $erroroccupation = $errorreligion = $erroremergency = $erroroption = "";
$allFields = true;

if (isset($_POST['submit'])) {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    $totalFields = 11;
    $filledFields = count(array_filter($_POST));
    $percentageCompleted = ($filledFields / $totalFields) * 100;

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
    if ($allFields) {

        $outcome_id = -1;

        $stmt = $db->prepare('INSERT INTO POA_questionnaire (date_of_poa, assigned, percentage_completed, completed, outcome_id, surname, first_name, address, date_of_birth, sex, age, telephone_number, occupation, religion, emergency_contact_number) VALUES (:poadate, :assigned, :percentage, :completed, :oid, :surname, :fname, :address, :dob, :sex, :age, :phone, :occupation, :religion, :emergency)');
        $stmt->bindValue(':poadate', $_POST['poadate'], SQLITE3_TEXT);
        $stmt->bindValue(':assigned', 1, SQLITE3_INTEGER);
        $stmt->bindValue(':percentage', $percentageCompleted, SQLITE3_FLOAT);
        $stmt->bindValue(':completed', 0, SQLITE3_INTEGER);
        $stmt->bindValue(':oid', $outcome_id, SQLITE3_INTEGER);
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

        $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
        $stmtUpdate->bindValue(':percentage_completed', $percentageCompleted, SQLITE3_FLOAT);

        if ($result) {
            $newEntryId = $db->lastInsertRowID();
            $stmtUpdate = $db->prepare('UPDATE POA_questionnaire SET percentage_completed = :percentage_completed WHERE poa_form_id = :poa_form_id');
            $stmtUpdate->bindValue(':percentage_completed', $percentage_completed, SQLITE3_FLOAT);
            $stmtUpdate->bindValue(':poa_form_id', $newEntryId, SQLITE3_INTEGER);
            $stmtUpdate->execute();

            header("Location: ../questionnaire/medicalHistory.php");
            exit();
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
            Percentage Completed: <?php echo round($percentageCompleted, 2); ?>%
            </div>

            <form method="post">
                <label>Questionnaire Completion Date</label>
                <input type="date" name="poadate" value="<?php echo isset($_POST['poadate']) ? $_POST['poadate'] : ''; ?>">
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

                <input type="submit" value="Save and Next" name="submit">
                <a href="../questionnaire/testQuestionnaire.php" class="back-button">Back</a> 
                <!-- link will probably need to be changed -->
                <!-- percentage completed -->
            </form>
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>