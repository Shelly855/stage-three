<?php
function getPatients() {
    include '../includes/dbConnection.php';

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "SELECT patients.*, users.first_name, users.surname 
    FROM patients 
    INNER JOIN users ON patients.user_id = users.user_id";

    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $arrayResult = [];
    while ($row = $result->fetchArray()) {
        $arrayResult[] = $row;
    }

    $db->close();

    return $arrayResult;
}

?>


