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

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


$mail = new PHPMailer();
$update_record = new UpdateRecord;
$read_one = new ReadOneRecord;

$read_one->read("email", "doctors", "email=:email", ['email'=>$email]);
// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);

$mailing = MailUser::mail_user($mail, $data['email']);
if($mailing['mailsent']){
    echo  json_encode(["success" => true, "message" => "Email sent Successful", "data" => null]) ;
}else{
    echo json_encode(["success" => false, "message" => "Email sending Not Successful", "data" => null]);
}		