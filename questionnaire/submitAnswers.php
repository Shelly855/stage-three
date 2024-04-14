<?php
session_start();
$db = new SQLite3('C:\xampp\data\stage_3.db');

$patientId = $_SESSION['patient_id'];
$surgeryId = $_SESSION['surgery_id'];

$query = "UPDATE POA_questionnaire SET completed = 1, percentage_completed = 100 WHERE surgery_id = :surgery_id";
$stmt = $db->prepare($query);
$stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
$stmt->execute();

header("Location: ../questionnaire/submitQuestionnaireSuccess.php");
exit();
?>
