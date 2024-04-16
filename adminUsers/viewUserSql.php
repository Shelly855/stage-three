<?php
function getUsers() {
    include '../includes/dbConnection.php';

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "SELECT * FROM users";

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

