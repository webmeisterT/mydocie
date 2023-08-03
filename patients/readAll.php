<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\ReadRecords;
use App\Auth;

$read_all = new ReadRecords;

//Get all headers
$allheaders = getallheaders();
//Check if user has access and then decode the jwt token
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($allheaders['Authorization'])) {
    $id = Auth::decodeAuth($allheaders);

    // Get all patient
    if (!empty($id)) {
        $response = $read_all->read("id, first_name, last_name,username, email, phone, language, weight, height, gender, age, street, city, state, country, image", "patients", "1 ORDER BY createdAt ASC", []);

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
} else {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Sorry, you don't have access to this page"]);

}