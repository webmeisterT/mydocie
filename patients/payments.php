<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');

require_once "../vendor/autoload.php";

use App\CreateRecord;

$create_record = new CreateRecord;
// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);
extract($data);
    
      $request = [
        'tx_ref' => uniqid().uniqid(),
        'amount' => $amount,
        'currency' => 'NGN',
        'payment_options' => 'card',
        'redirect_url' => 'index.php', //replace with yours
        'customer' => [
            'email' => $email,
            'name' => $first_name. ' '.$last_name
        ],
        'meta' => [
            'price' => $amount
        ],
        'customizations' => [
            'title' => 'Paying for health service', //Set your title
            'description' => 'MyDocie'
        ]
    ];
    
    //* Call fluterwave endpoint
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.flutterwave.com/v3/payments', //don't change this
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($request),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer FLWSECK_TEST-0777869f6df0389d7d7ca79b21b49f4b-X',
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    
    $res = json_decode($response);
    // var_dump($res);
    if($res->status == 'success')
    {
        // Initialize create parameters
        $column = "tx_ref, first_name, last_name, email, amount";
        $value = ":tx_ref, :first_name, :last_name, :email, :amount";
        $data = [
            "tx_ref" => $request['tx_ref'],
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email" => $email,
            "amount" => $amount,
        ];
        // Create client
        $res2 = $create_record->create("payments",$column,$value,$data);

        if ($res2) {
            http_response_code(201);
            echo json_encode(["success" => true, "message" => "Payment successful"]);
        } else {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Record cannot be created"]);
        }
        // $link = $res->data->link;
        // print_r((array)$res);
        // header('Location: '.$link);
    }
    else
    {
        http_response_code(422);
        echo json_encode(["success" => false, "message" => $res->message]);
    }
    // Ifedavid001@080



