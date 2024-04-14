<?php
function getPatients()
{
    $db = new SQLite3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        users.user_id,
        users.username,
        users.first_name,
        users.surname,        
        patients.date_of_birth,
        patients.email,
        patients.mobile_number,
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
    <title>My Details</title>
</head>
<body>
<div class="container"> 
        <?php
            include("../includes/patientHeader.php");
        ?>  
        <main>
            <h1>Personal Details</h1>

            <div class="detailsTable">
                <table>
                    <thead>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Date of Birth</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo $patient['user_id']; ?></td>
                                <td><?php echo $patient['username']; ?></td>
                                <td><?php echo $patient['first_name']; ?></td>
                                <td><?php echo $patient['surname']; ?></td>                                
                                <td><?php echo $patient['date_of_birth']; ?></td>
                                <td><?php echo $patient['email']; ?></td>
                                <td><?php echo $patient['mobile_number']; ?></td>
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

