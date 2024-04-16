<?php

function getAppointments() {
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        appointments.appointment_id,
        appointments.date,
        appointments.time,
        users.first_name AS patient_first_name,
        users.surname AS patient_surname,
        users.first_name AS staff_first_name,
        users.surname AS staff_surname
    FROM 
        appointments

    JOIN 
        patients ON appointments.patient_id = patients.patient_id
    JOIN 
        users ON appointments.user_id = users.user_id;
        
    WHERE 
        appointments.users_id = :doctor_id";

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
