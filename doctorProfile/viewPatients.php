<?php

function getPatients()
{
    $db = new SQLite3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        users.first_name,
        users.surname,
        patients.email,
        patients.mobile_number,
        patients.date_of_birth,
        patients.medical_conditions,
        patients.previous_medical_conditions
    FROM 
        patients
    JOIN 
        users ON patients.user_id = users.user_id";

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
$patients = getPatients();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Records</title>
</head>
<body>
    <div class="container">
        <?php
        
            include("../includes/doctorHeader.php");
        ?>
        <main>
            <h1>Patient Records</h1>

            <div class="table-container">
                <table>
                    <thead>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Date of Birth</th>
                            <th>Medical Conditions</th>
                            <th>Previous Medical Conditions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo $patient['first_name']; ?></td>
                                <td><?php echo $patient['surname']; ?></td>
                                <td><?php echo $patient['email']; ?></td>
                                <td><?php echo $patient['mobile_number']; ?></td>
                                <td><?php echo $patient['date_of_birth']; ?></td>
                                <td><?php echo $patient['medical_conditions']; ?></td>
                                <td><?php echo $patient['previous_medical_conditions']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>   
            </div> 
        </main>
        <?php
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
