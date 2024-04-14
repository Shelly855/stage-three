<?php

function getPOAanswers()
{
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        POA_questionnaire.poa_form_id,
        surgery.surgery_id AS surgery_id,
        POA_questionnaire.assigned,
        POA_questionnaire.percentage_completed,
        POA_questionnaire.completed,
        POA_questionnaire.date_of_poa,
        POA_questionnaire.surname,
        POA_questionnaire.first_name,
        POA_questionnaire.address,
        POA_questionnaire.date_of_birth,
        POA_questionnaire.sex,
        POA_questionnaire.age,
        POA_questionnaire.telephone_number,
        POA_questionnaire.occupation,
        POA_questionnaire.religion,
        POA_questionnaire.emergency_contact_number,
        POA_questionnaire.heart_disease,
        POA_questionnaire.MI,
        POA_questionnaire.hypertension,
        POA_questionnaire.angina,
        POA_questionnaire.'DVT/PE',
        POA_questionnaire.stroke,
        POA_questionnaire.diabetes,
        POA_questionnaire.epilepsy,
        POA_questionnaire.jaundice,
        POA_questionnaire.sickle_cell_status,
        POA_questionnaire.kidney_disease,
        POA_questionnaire.arthritis,
        POA_questionnaire.asthma,
        POA_questionnaire.pregnant,
        POA_questionnaire.other_health_conditions,
        POA_questionnaire.previous_medication

    FROM 
        POA_questionnaire
    JOIN 
        surgery ON POA_questionnaire.surgery_id = surgery.surgery_id
    WHERE
        POA_questionnaire.completed = 1";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $arrayResult = [];
    while ($row = $result->fetchArray()) {
        $arrayResult[] = $row;
    }
    return $arrayResult;

}
$POAanswers = getPOAanswers();

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>View Preoperative Assessment Answers</title>
</head>

<html>

<body>
    <div class="container">
        <?php
        include ("../includes/doctorHeader.php");
        ?>
        <main>
            <h1>Preoperative Assessment Answers:</h1>
            <div class="table-container">
                <table>
                    <thead>
                        <th>poa_form_id</th>
                        <th>surgery_id</th>
                        <th>assigned</th>
                        <th>percentage_completed</th>
                        <th>completed</th>
                        <th>date_of_poa</th>
                        <th>surname</th>
                        <th>first_name</th>
                        <th>address</th>
                        <th>date_of_birth</th>
                        <th>sex</th>
                        <th>age</th>
                        <th>telephone_number</th>
                        <th>occupation</th>
                        <th>religion</th>
                        <th>emergency_contact_number</th>
                        <th>heart_disease</th>
                        <th>MI</th>
                        <th>hypertension</th>
                        <th>angina</th>
                        <th>DVT/PE</th>
                        <th>stroke</th>
                        <th>diabetes</th>
                        <th>epilepsy</th>
                        <th>jaundice</th>
                        <th>sickle_cell_status</th>
                        <th>kidney_disease</th>
                        <th>arthritis</th>
                        <th>asthma</th>
                        <th>pregnant</th>
                        <th>other_health_conditions</th>
                        <th>previous_medication</th>
                        <th>Eligible for Surgery?</th>
                    </thead>
                    <tbody>
                        <?php foreach ($POAanswers as $POAanswer): ?>
                            <tr>
                                <td><?php echo $POAanswer['poa_form_id']; ?></td>
                                <td><?php echo $POAanswer['surgery_id']; ?></td>
                                <td><?php echo $POAanswer['assigned']; ?></td>
                                <td><?php echo $POAanswer['percentage_completed']; ?></td>
                                <td><?php echo $POAanswer['completed']; ?></td>
                                <td><?php echo $POAanswer['date_of_poa']; ?></td>
                                <td><?php echo $POAanswer['surname']; ?></td>
                                <td><?php echo $POAanswer['first_name']; ?></td>
                                <td><?php echo $POAanswer['address']; ?></td>
                                <td><?php echo $POAanswer['date_of_birth']; ?></td>
                                <td><?php echo $POAanswer['sex']; ?></td>
                                <td><?php echo $POAanswer['age']; ?></td>
                                <td><?php echo $POAanswer['telephone_number']; ?></td>
                                <td><?php echo $POAanswer['occupation']; ?></td>
                                <td><?php echo $POAanswer['religion']; ?></td>
                                <td><?php echo $POAanswer['emergency_contact_number']; ?></td>
                                <td><?php echo $POAanswer['heart_disease']; ?></td>
                                <td><?php echo $POAanswer['MI']; ?></td>
                                <td><?php echo $POAanswer['hypertension']; ?></td>
                                <td><?php echo $POAanswer['angina']; ?></td>
                                <td><?php echo $POAanswer['DVT/PE']; ?></td>
                                <td><?php echo $POAanswer['stroke']; ?></td>
                                <td><?php echo $POAanswer['diabetes']; ?></td>
                                <td><?php echo $POAanswer['epilepsy']; ?></td>
                                <td><?php echo $POAanswer['jaundice']; ?></td>
                                <td><?php echo $POAanswer['sickle_cell_status']; ?></td>
                                <td><?php echo $POAanswer['kidney_disease']; ?></td>
                                <td><?php echo $POAanswer['arthritis']; ?></td>
                                <td><?php echo $POAanswer['asthma']; ?></td>
                                <td><?php echo $POAanswer['pregnant']; ?> </td>
                                <td><?php echo $POAanswer['other_health_conditions']; ?></td>
                                <td><?php echo $POAanswer['previous_medication']; ?></td>
                                <td>
                                    <form action="insertEligibleSurgery.php" method="POST">
                                        <input type="hidden" name="surgery_id" value="<?php echo $POAanswer['surgery_id']; ?>">
                                        <input type="checkbox" id="eligible" name="eligible" value="1">
                                        <input type="submit" value="Submit">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>



        <?php include ("../includes/footer.php"); ?>

    </div>

</body>

</html>
