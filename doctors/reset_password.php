<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\UpdateRecord;
use App\ReadOneRecord;


$update_record = new UpdateRecord;
$read_one = new ReadOneRecord;

// Get raw posted data as associative array
$email = $_GET['email'] ? $_GET['email'] : '';
$code = $_GET['code'] ? $_GET['code'] : '';

if (!empty($email) && !empty($code)) {

    // Initialize parameters
    $column = "password=:password";

    $update_data = [
        "email" => $email,
        "password" => $password
    ];

    // Update user
    $response = $update_record->update("doctors", $column, "email=:email", $update_data);

    if ($response) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Record updated successfully", "data" => null]);
    } else {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Record cannot be found", "data" => null]);
    }
} else {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "You are not an authorized user", "data" => null]);
}