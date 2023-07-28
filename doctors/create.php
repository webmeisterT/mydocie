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


$response = $read_one->read("*", "doctors", "username=:username OR email=:email OR phone=:phone", ['username' => $new_data['username'], 'email' => $new_data['email'], 'phone' => $new_data['phone']]);

if ($response && count($response) > 0) {
    if ($response['username'] == $new_data['username']) {  
        http_response_code(409);              
        echo json_encode(["success" => false, "message" => "A user with this username already exists!", "data" => null]);
        return;
    }
    
    if ($response['email'] == $new_data['email']) {  
        http_response_code(409);              
        echo json_encode(["success" => false, "message" => "A user with this email already exists!", "data" => null]);
        return;
    }
    
    if ($response['phone'] == $new_data['phone']) {                
        http_response_code(409);              
        echo json_encode(["success" => false, "message" => "A user with this phone number already exists!", "data" => null]);
        return;
    }
    return;
}

$new_data['password'] = password_hash($new_data['password'], PASSWORD_BCRYPT, ['cost' => 12]);


// Initialize create parameters

$column = "first_name, last_name, username, email, phone, password";
$value = ":first_name, :last_name, :username, :email, :phone, :password";
    
    // Create client
$response = $create_record->create("doctors",$column,$value,$new_data);

if ($response) {
    http_response_code(201);
    echo json_encode(["success" => true, "message" => "Record created successfully", "data" => null]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Record cannot be created", "data" => null]);
}
