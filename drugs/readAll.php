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
$user = isset($_GET['user']) ? $_GET['user'] : '';

// Get user value
if (!empty($user) && $user == 2) {
    $response = $read_all->read("id, name, mg, quantity", "drugs", "1 ORDER BY createdAt ASC", []);

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
