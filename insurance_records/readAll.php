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

// Get patient_id value
if (!empty($patient_id)) {
    $response = $read_all->read("id, patient_id, details, type_of_insurance", "insurance_records", "patient_id=:patient_id", ["patient_id"=>$patient_id]);

    if (is_array($response)) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Successful", "data" => $response]);
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Not successful", "data" => null]);
    }
    
} else {
    return http_response_code(401); 
}
