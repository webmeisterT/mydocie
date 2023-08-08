<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');

require_once "../vendor/autoload.php";


// Get raw posted data as associative array
$data = json_decode(file_get_contents("php://input"), true);
extract($data);
    
      $request = [
        
        'tx_ref' => bin2hex(random_bytes(8)),
        'amount' => $amount,
        'currency' => 'NGN',
        'payment_options' => 'card',
        'redirect_url' => 'http://127.0.0.1/mydocie/api/v1/patients/process_payment.php', //replace with yours
        'customer' => [
            'email' => $email,
            'name' => $first_name. ' '.$last_name
        ],
        'meta' => [
            'price' => $amount
        ],
        'customizations' => [
            'title' => 'MyDocie Health Services', //Set your title
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

    if($res->status == 'success')
    {
        $link = $res->data->link;        
        // header('Location: '.$link);
        http_response_code(201);
        echo json_encode(["success" => true, "message" => $link]);
    // } else {
        
    // }
    } else {
        http_response_code(422);
        echo json_encode(["success" => false, "message" => $res->message]);
    }

    // Ifedavid001@080
