<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\UpdateRecord;
use App\ReadOneRecord;
use App\Sanitize;

$update_record = new UpdateRecord;
$read_one = new ReadOneRecord;

// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize the data
$new_data = [];
foreach ($data as $key => $value) {
    $new_data[$key] = Sanitize::sanitizeData($value);
}

extract($new_data);

// Initialize parameters
$column = "details=:details, type_of_insurance=:type_of_insurance";

$update_data = [
    'id' => $id,
    'details' => $details,
    'type_of_insurance' => $type_of_insurance
];

    // Update user
$response = $update_record->update("insurance_records", $column, "id=:id", $update_data);

if ($response) {
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Record updated successfully", "data" => null]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Record cannot be found", "data" => null]);
}
