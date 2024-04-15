<?php
function getAppointments($doctor_id) {
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
        patients.medical_conditions,
        patients.previous_medical_conditions,
        patient.first_name AS patient_first_name,
        patient.surname AS patient_surname,
        staff.first_name AS staff_first_name,
        staff.surname AS staff_surname
    FROM 
        appointments
    JOIN 
        patients ON appointments.patient_id = patients.patient_id
    JOIN 
        users AS patient ON appointments.patient_id = patient.user_id
    JOIN 
        users AS staff ON appointments.user_id = staff.user_id
    WHERE 
        appointments.user_id = :doctor_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':doctor_id', $doctor_id, SQLITE3_INTEGER);

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
