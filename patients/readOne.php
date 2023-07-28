<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\ReadOneRecord;
$read_one = new ReadOneRecord;
// Get info from URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Get user 
if (!empty($id)) {
    $response = $read_one->read("id, first_name, last_name,username, email, phone, language, weight, height, gender, age, street, city, state, country, image", "patients", "id=:id ORDER BY createdAt ASC", ["id"=>$id]);
    
    if ($response) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Successful", "data" => $response]);
    } else {
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "No such record", "data" => null]);
    }
    
} else {
    return http_response_code(400);    
}
