<?php
$patientId = $_SESSION['patient_id'];
$query = "SELECT COUNT(*) AS count FROM surgery WHERE patient_id = $patientId";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    $surgeryNotification = '<section class="outcomeNotifications">
                            <h2>Your Questionnaire Outcome</h2>
                            <p class="assigned">Surgery Assigned: Yes </p>
                            <p> The doctor has assigned a surgery for you. Click <a href="surgeryDetails.php">here</a> to view your surgery details. </p>
                        </section>';
} 
else {
    $surgeryNotification = '<section class="outcomeNotifications">
                            <h2>Your Questionnaire Outcome</h2>
                            <p class="assigned">Surgery Assigned: No</p>
                            <p>The doctor has not assigned a surgery for you. </p>
                        </section>';
}
?>
