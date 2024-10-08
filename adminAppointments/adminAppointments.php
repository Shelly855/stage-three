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
            include("../adminAppointments/viewAppointmentSql.php");

            $appointments = getAppointments();
            include("../includes/adminHeader.php");
        ?>
        <main>
            <h1>Appointments</h1>

            <form action="../adminAppointments/createAppointment.php">
                <input type="submit" value="Create New Appointment" />
            </form>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Patient Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?php echo $appointment['date']; ?></td>
                                <td><?php echo $appointment['time']; ?></td>
                                <td><?php echo $appointment['patient_first_name'] . ' ' . $appointment['patient_surname']; ?></td>
                                <td>
                                    <a href="../adminAppointments/updateAppointment.php?aid=<?php echo $appointment['appointment_id']; ?>">Update</a> 
                                    <a href="../adminAppointments/deleteAppointment.php?aid=<?php echo $appointment['appointment_id']; ?>">Delete</a>
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
