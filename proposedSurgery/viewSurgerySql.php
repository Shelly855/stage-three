<?php
function getSurgeries() {
    include '../includes/dbConnection.php';

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "SELECT s.surgery_id, s.surgery_name, u.first_name, u.surname, s.eligible, poa.completed 
    FROM surgery s
    JOIN patients p ON s.patient_id = p.patient_id
    JOIN users u ON p.user_id = u.user_id
    LEFT JOIN POA_questionnaire poa ON s.surgery_id = poa.surgery_id";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $arrayResult = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $arrayResult[] = $row;
    }

    $db->close();

    return $arrayResult;
}
?>
