<?php

function getAppointments (){
    $db = new SQLITE3('C:\xampp\data\stage_3.db');
    $sql = "
    SELECT 
        appointments.appointment_id,
        appointments.date,
        appointments.time,
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

    $arrayResult = [];
    while ($row = $result->fetchArray()){
        $arrayResult [] = $row;
    }
    return $arrayResult;
}