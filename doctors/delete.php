<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: DELETE');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\DeleteRecord;
$delete = new DeleteRecord;

$id = $_GET['id'];

$response = $delete->delete("doctors", "id=:id", ['id' => $id]);

if ($response) {
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Record deleted successfully", "data" => null]);
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Record cannot be found", "data" => null]);
}
        
