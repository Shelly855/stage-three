<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/desktop.css" media="only screen and (min-width:720px)" rel="stylesheet" type="text/css">
    <link href="../css/mobile.css" media="only screen and (max-width:720px)" rel="stylesheet" type="text/css">
    <title>Patient Dashboard</title>
</head>
<body>
    <div class="container"> 
        <?php
            session_start();
            include("../includes/patientHeader.php");

            $db = new SQLite3('C:\xampp\data\stage_3.db');

            $patientId = $_SESSION['patient_id'];

            $questionnaireQuery = "SELECT pq.poa_form_id, s.surgery_id
                                    FROM POA_questionnaire pq
                                    JOIN surgery s ON pq.surgery_id = s.surgery_id
                                    WHERE s.patient_id = $patientId AND pq.completed = 0";

            $result = $db->query($questionnaireQuery);

            if ($result === false) {
                echo "Error executing query";
            } else {
                echo '<main>
                        <h1>Welcome To Your Dashboard</h1>
                        <div class="dashboardBoxes">
                            <div class="pageLinks">
                                <p class="headings">Your Appointments</p>
                                <a href="upcomingAppointments.php">Upcoming Appointments</a> 
                            </div>';

                $preOpAssessmentLinks = '';

                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $_SESSION['surgery_id'] = $row['surgery_id'];
                    $preOpAssessmentLinks .= '<li><a href="../questionnaire/questionnaire.php?id=' . $row['poa_form_id'] . '&surgery_id=' . $row['surgery_id'] . '">Pre-operative assessment</a></li>';
                }

                if (!empty($preOpAssessmentLinks)) {
                    echo '<div class="pageLinks">
                            <p class="headings"> Need To Complete </p>
                            <ul>';
                    echo $preOpAssessmentLinks;
                    echo '</ul></div>';
                }

                echo '<div class="viewProfileButton">
                        <br>
                        <a href="patientProfile.php" class="viewProfile">View Your Profile</a>
                    </div>
                    </div>
                    </main>';
            }

            $db->close();
            include("../includes/footer.php");
        ?>
    </div>
</body>
</html>
