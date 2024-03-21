<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Appointments</title>
</head>
<body>
    <div class="container">
        <?php
            include("../appointments/viewAppointmentSql.php");

            $appointments = getAppointments();
            include("../includes/header.php");
        ?>
        <main>
            <h1>Appointments</h1>

            <form action="../appointments/createAppointment.php">
                <input type="submit" value="Create New Appointment" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Appointment ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient Name</th>
                            <th>Staff Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo $appointment['appointment_id']; ?></td>
                                <td><?php echo $appointment['date']; ?></td>
                                <td><?php echo $appointment['time']; ?></td>
                                <td><?php echo $appointment['patient_first_name'] . ' ' . $appointment['patient_surname']; ?></td>
                                <td><?php echo $appointment['staff_first_name'] . ' ' . $appointment['staff_surname']; ?></td>
                                <td>
                                    <a href="../appointments/updateAppointment.php?aid=<?php echo $appointment['appointment_id']; ?>">Update</a> 
                                    <a href="../appointments/deleteAppointment.php?aid=<?php echo $appointment['appointment_id']; ?>">Delete</a>
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