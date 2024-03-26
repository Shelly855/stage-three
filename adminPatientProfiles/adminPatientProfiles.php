<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Profiles</title>
</head>
<body>
    <div class="container">
        <?php
            include("../adminPatientProfiles/viewPatientSql.php");

            $patients = getPatients();
            include("../includes/header.php");
        ?>
        <main>
            <h1>Patient Profiles</h1>

            <form action="../adminPatientProfiles/createPatient.php">
                <input type="submit" value="Create New Patient" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Date of Birth</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $patient): ?>
                            <tr>
                                <td><?php echo $patient['first_name']; ?></td>
                                <td><?php echo $patient['surname']; ?></td>
                                <td><?php echo $patient['email']; ?></td>
                                <td><?php echo $patient['mobile_number']; ?></td>
                                <td><?php echo $patient['date_of_birth']; ?></td>
                                <td><?php echo $patient['username']; ?></td>
                                <td>
                                    <a href="../adminPatientProfiles/updatePatient.php?pid=<?php echo $patient['patient_id']; ?>">Update</a>
                                    <a href="../adminPatientProfiles/deletePatient.php?pid=<?php echo $patient['patient_id']; ?>">Delete</a>
                                </td>
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