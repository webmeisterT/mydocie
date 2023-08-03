<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');

use App\UpdateRecord;
$update_record = new UpdateRecord;


$data = json_decode($_POST['data']);
$prev_name = $data->filename;
$id = $data->id;
$upload_path = "uploads/";

if ($prev_name) {
    @unlink($upload_path . $prev_name);
}

$extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
$filename = uniqid() . uniqid() . "." . $extension;
$filepath = $upload_path . $filename;
if ($res = move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) {

    if ($update_record->update("doctors", "image=:image", "id=:id", ['id' => $id, 'image' => $filename])) {
        echo json_encode(["success" => true, "message" => "Successful", "data" => null]);
    } else {
        echo json_encode(["success" => false, "message" => "Unable To Upload File", "data" => null]);
    }
} else {
    echo json_encode(["success" => false, "message" => "'Unable To Upload File'", "data" => null]);
}
