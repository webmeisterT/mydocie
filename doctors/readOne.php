<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";


use App\ReadOneRecord;
use App\Auth;

$read_one = new ReadOneRecord;
//Get all heders
$allheaders = getallheaders();
//Check if user has access and then decode the jwt token
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($allheaders['Authorization'])) {

    $id = Auth::decodeAuth($allheaders);

    // Get user 
    if (!empty(isset($id))) {
        $response = $read_one->read("id, first_name, last_name, username, email, phone, specialization, current_clinic, image", "doctors", "id=:id ORDER BY createdAt ASC", ["id"=>$id]);
        
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
} else {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Sorry, you don't have access to this page"]);

}
