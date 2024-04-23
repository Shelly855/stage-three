<?php
$patientId = $_SESSION['patient_id'];
$query = "SELECT COUNT(*) AS count FROM surgery WHERE patient_id = $patientId";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);

if ($row['count'] > 0) {
    $surgeryNotification = '<section class="outcomeNotifications">
                            <h2>Surgery Decision</h2>
                            <p class="assigned">Surgery Proposed: Yes </p>
                            <p> The doctor has proposed a surgery for you. Click <a href="../patientProfile/surgeryDetails.php">here</a> to view your surgery details. </p>
                        </section>';
} 
else {
    $surgeryNotification = '<section class="outcomeNotifications">
                            <h2>Surgery Decision</h2>
                            <p class="assigned">Surgery Proposed: No</p>
                            <p>The doctor has not proposed a surgery for you. </p>
                        </section>';
}
?>
