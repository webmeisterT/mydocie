<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');

require_once "../vendor/autoload.php";

use App\ReadOneRecord;
use App\CreateRecord;

$read_one = new ReadOneRecord;
$create = new CreateRecord;

$txid = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';
$tx_ref = isset($_GET['tx_ref']) ? $_GET['tx_ref'] : '';
$get_status = isset($_GET['status']) ? $_GET['status'] : '';

// $readone = $read_one->read('transaction_id, amount, status', 'payments', 'tx_ref=:tx_ref', ['tx_ref' => $tx_ref]);

if($get_status) {
    // check payment status
    if($get_status == 'cancelled') {
        // header('Location: index.php');
        http_response_code(499);
        echo json_encode(["success" => false, "message" => 'User cancelled the payment']);
    }
    else if($get_status == 'successful') {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/{$txid}/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer FLWSECK_TEST-0777869f6df0389d7d7ca79b21b49f4b-X"
            ],
        ]);
            
        $response = curl_exec($curl);
        
        curl_close($curl);
        
        $res = json_decode($response);

        if($res->status) {
        $amountPaid = $res->data->charged_amount;
        // $amountToPay = $res->data->meta->price;
        // Initialize create parameters
        $column = "tx_ref, transaction_id, name, email, amount, status";
        $value = ":tx_ref, :transaction_id, :name, :email, :amount, :status";
        $data = [
            "tx_ref" => $tx_ref,
            "transaction_id" => $txid,
            "name" => $res->data->customer->name,
            "email" => $res->data->customer->email,
            "amount" => $amountPaid,
            "status" => 'successful',
        ];
        // Create payment table
        $create->create('payments', $column, $value, $data);
        http_response_code(201);
        echo json_encode(["success" => true, "message" => "Payment successful"]);
        } else {
            http_response_code(422);
            echo json_encode(["success" => false, "message" => "Can not process payment"]);
        }
    } else {
        // Initialize create parameters
        $column = "tx_ref, transaction_id, name, email, amount, status";
        $value = ":tx_ref, :transaction_id, :name, :email, :amount, :status";
        $data = [
            "tx_ref" => $tx_ref,
            "transaction_id" => $txid,
            "name" => $res->data->customer->name,
            "email" => $res->data->customer->email,
            "amount" => $amountPaid,
            "status" => 'failed',
        ];
        // Create payment table
        $create->create('payments', $column, $value, $data);
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Payment failed! please retry paying"]);
    }
}
