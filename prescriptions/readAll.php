<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\ReadRecords;
$read_all = new ReadRecords;

// Get info from URL
$patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';

// Get patient value
if (!empty($patient_id)) {
    $response = $read_all->read("id, patient_id, doctor_id, drug_name, dosage, duration, repeat_drug, day_time, diet_type, diagnosis, doctor_note", "prescriptions", "patient_id=:patient_id", ["patient_id"=>$patient_id]);

    if ($response) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Successful", "data" => $response]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "No such record", "data" => null]);
    }

} else if (!empty($doctor_id)) {
    $response = $read_all->read("id, patient_id, doctor_id, drug_name, dosage, duration, repeat_drug, day_time, diet_type, diagnosis, doctor_note", "prescriptions", "doctor_id=:doctor_id", ["doctor_id"=>$doctor_id]);

    if ($response) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Successful", "data" => $response]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "No such record", "data" => null]);
    }
} else {
    return http_response_code(401); 
}
