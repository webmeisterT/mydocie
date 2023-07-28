<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');

require_once "../vendor/autoload.php";

use App\CreateRecord;
use App\ReadOneRecord;
use App\Sanitize;

$create_record = new CreateRecord;
$read_one = new ReadOneRecord;
// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize the data
$new_data = [];
foreach ($data as $key => $value) {
    $new_data[$key] = Sanitize::sanitizeData($value);
}

// Initialize create parameters

$column = "name, mg, quantity, createdBy";
$value = ":name, :mg, :quantity, :createdBy";
    
    // Create client
$response = $create_record->create("drugs",$column,$value,$new_data);

if ($response) {
    http_response_code(201);
    echo json_encode(["success" => true, "message" => "Record created successfully", "data" => null]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Record cannot be created", "data" => null]);
}
