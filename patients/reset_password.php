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
$email = isset($_GET['email']) ? $_GET['email'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if (!empty($email) && !empty($token)) {
    $resp = $read_one->read('email, token', 'patients', 'email=:email AND token=:token', ['email'=>$email, 'token'=>$token]);
    if ($resp) {        
        // Get raw posted data as associative array
        $data = json_decode(file_get_contents("php://input"), true);
        // extract($data);
        
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        // Initialize parameters
        $column = "password=:password";

        $update_data = [
            "email" => $email,
            "password" => $data['password']
        ];

        // Update user
        $response = $update_record->update("patients", $column, "email=:email", $update_data);

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
    
} else {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "You are not an authorized user", "data" => null]);
}