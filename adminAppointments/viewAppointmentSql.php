<?php

function getAppointments() {
     include '../includes/dbConnection.php';

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        appointments.appointment_id,
        appointments.date,
        appointments.time,
        users.first_name AS patient_first_name,
        users.surname AS patient_surname
       
    FROM 
        appointments
    JOIN 
        patients ON appointments.patient_id = patients.patient_id
    JOIN 
        users ON users.user_id = patients.user_id";
    

    $stmt = $db->prepare($sql);
    
    $result = $stmt->execute();

    if (!$result) {
        die("Error executing query: " . $db->lastErrorMsg());
    }

    $arrayResult = [];
    while ($row = $result->fetchArray()){
        $arrayResult [] = $row;
    }
    return $arrayResult;
}

