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
    if ($key == 'password' && strlen($value) < 8) {
        http_response_code(406);
        echo json_encode(["success" => false, "message" => "Password length must be greater than 8"]);
        return;
    }
    
    if ($key == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        http_response_code(406);
        echo json_encode(["success" => false, "message" => "Invalid email format"]);
        return;
    }
    
    $new_data[$key] = Sanitize::sanitizeData($value);
}

extract($new_data);

// Initialize parameters
$column = "first_name=:first_name, last_name=:last_name, username=:username, email=:email, phone=:phone, specialization=:specialization, current_clinic=:current_clinic";

$update_data = [
    "id" => $id,
    "first_name" => $first_name,
    "last_name" => $last_name,
    "username" => $username,
    "email" => $email,
    "phone" => $phone,
    "specialization" => $specialization,
    "current_clinic" => $current_clinic,
];


// Update user
$response = $update_record->update("doctors", $column, "id=:id", $update_data);

if ($response) {
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Record updated successfully", "data" => $read_one->read("id, first_name, last_name, username, email, phone, specialization, current_clinic, image", "doctors", "id=:id", ['id'=>$id])]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Record cannot be found", "data" => null]);
}
