<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../vendor/autoload.php";

use App\UpdateRecord;
use App\ReadOneRecord;
use App\MailUser;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';


$mail = new PHPMailer();
$update_record = new UpdateRecord;
$read_one = new ReadOneRecord;

// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);
extract($data);
$token = uniqid();
$res = $read_one->read("id, email", "doctors", "email=:email", ['email'=>$email]);
if ($res) {
    if ($update_record->update('doctors', 'token=:token', 'id=:id', ["id"=>$res['id'], "token"=>$token])) {
        $mailing = MailUser::mail_user($mail, ['email'=>$email, 'token'=>$token, 'user'=>'doctors']);
        if($mailing['mailsent']){
            echo  json_encode(["success" => true, "message" => "Email sent Successful"]) ;
        }else{
            echo json_encode(["success" => false, "message" => $mailing['message']]);
        }	
    }	
}
