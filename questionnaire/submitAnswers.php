<?php
session_start();
$db = new SQLite3('C:\xampp\data\stage_3.db');

$patientId = $_SESSION['patient_id'];
$surgeryId = $_SESSION['surgery_id'];

if (isset($_POST['submit']) &&
    isset($_POST['date_of_poa']) && $_POST['date_of_poa'] !== '' &&
    isset($_POST['surname']) && $_POST['surname'] !== '' &&
    isset($_POST['first_name']) && $_POST['first_name'] !== '' &&
    isset($_POST['address']) && $_POST['address'] !== '' &&
    isset($_POST['date_of_birth']) && $_POST['date_of_birth'] !== '' &&
    isset($_POST['sex']) && $_POST['sex'] !== '' &&
    isset($_POST['age']) && $_POST['age'] !== '' &&
    isset($_POST['telephone_number']) && $_POST['telephone_number'] !== '' &&
    isset($_POST['occupation']) && $_POST['occupation'] !== '' &&
    isset($_POST['religion']) && $_POST['religion'] !== '' &&
    isset($_POST['emergency_contact_number']) && $_POST['emergency_contact_number'] !== '' &&
    isset($_POST['heart_disease']) && $_POST['heart_disease'] !== '' &&
    isset($_POST['MI']) && $_POST['MI'] !== '' &&
    isset($_POST['hypertension']) && $_POST['hypertension'] !== '' &&
    isset($_POST['angina']) && $_POST['angina'] !== '' &&
    isset($_POST['DVT/PE']) && $_POST['DVT/PE'] !== '' &&
    isset($_POST['stroke']) && $_POST['stroke'] !== '' &&
    isset($_POST['diabetes']) && $_POST['diabetes'] !== '' &&
    isset($_POST['epilepsy']) && $_POST['epilepsy'] !== '' &&
    isset($_POST['jaundice']) && $_POST['jaundice'] !== '' &&
    isset($_POST['sickle_cell_status']) && $_POST['sickle_cell_status'] !== '' &&
    isset($_POST['kidney_disease']) && $_POST['kidney_disease'] !== '' &&
    isset($_POST['arthritis']) && $_POST['arthritis'] !== '' &&
    isset($_POST['asthma']) && $_POST['asthma'] !== '' &&
    isset($_POST['pregnant']) && $_POST['pregnant'] !== '' &&
    isset($_POST['other_health_conditions']) && $_POST['other_health_conditions'] !== '' &&
    isset($_POST['previous_medication']) && $_POST['previous_medication'] !== '') {

    $query = "UPDATE POA_questionnaire SET completed = 1, percentage_completed = 100 WHERE surgery_id = :surgery_id";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':surgery_id', $surgeryId, SQLITE3_INTEGER);
    $stmt->execute();

    header("Location: ../questionnaire/submitQuestionnaireSuccess.php");
    exit();
} else {
    header("Location: ../questionnaire/reviewAnswers.php?error=1");
    exit();
}

?>
