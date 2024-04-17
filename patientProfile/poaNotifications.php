<?php
$patientId = $_SESSION['patient_id'];
$query = $query = "SELECT COUNT(*) AS count FROM POA_questionnaire pq
JOIN surgery s ON pq.surgery_id = s.surgery_id
WHERE s.patient_id = $patientId";
$res = $db->query($query);
$row = $res->fetchArray(SQLITE3_ASSOC);

if ($row['count'] >= 1) {
    $poaNotification = '<section class="poaDecision">
                        <h2>Pre Operative Assessment Decision</h2>
                        <p class="assigned">POA Assigned: Yes</p>  
                        <p>The doctor has assigned a Pre-Operative Assessment for you. You can access the Questionnaire from your dashboard.</p>
                    </section>';
} 
else {
    $poaNotification = '<section class="poaDecision">
                        <h2>Pre Operative Assessment Decision</h2>
                        <p class="assigned">POA Assigned: No</p>
                        <p>The doctor has not assigned a Pre-Operative Assessment for you. </p>
                    </section>';
}
?>
