<?php

function getAppointments (){
    $db = new SQLITE3('C:\xampp\data\stage_3.db');
    $sql = "SELECT * FROM appointments";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute();

    $arrayResult = [];
    while ($row = $result->fetchArray()){
        $arrayResult [] = $row;
    }
    return $arrayResult;
}
