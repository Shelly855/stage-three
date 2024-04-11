<?php

function getAppointments (){
    $db = new SQLITE3('C:\xampp\data\stage_3.db');

    if (!$db) {
        die("Failed to connect to the database.");
    }

    $sql = "
    SELECT 
        appointments.appointment_id,
        appointments.date,
        appointments.time,
        appointments.clinical_notes,
        appointments.medical_history,
        patients.first_name AS patient_first_name,
        patients.surname AS patient_surname,
        staff.first_name AS staff_first_name,
        staff.surname AS staff_surname
    FROM 
        appointments
    JOIN 
        patients ON appointments.patient_id = patients.patient_id
    JOIN 
        staff ON appointments.staff_id = staff.staff_id";
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
