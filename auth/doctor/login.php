<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Headers: X-Requested-With');
// header('Access-Control-Allow-Credentials: true');
require_once "../../vendor/autoload.php";

use App\Auth;
use App\ReadOneRecord;
$read_one = new ReadOneRecord;



if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$data = json_decode(file_get_contents("php://input"), true);
	if (!empty($data) && is_array($data)) {
		extract($data);

		if (!empty(isset($email))) {
			$response = $read_one->read("id, password, email", "doctors", "email=:email", ['email' => $email]);

			if ($response) {
				if (password_verify($password, $response['password'])) {
					http_response_code(202);
					echo json_encode(["success" => true, "message" => "Successfully logged in", "jwt" => Auth::authenticate($response['id'], $response['email']), 
					// "data" => $read_one->read("id, first_name, last_name, username, email, phone, specialization, current_clinic, image", "doctors", "email=:email", ['email' => $email])
				]);					
				} else {					
					http_response_code(401);
					echo json_encode(["success" => false, "message" => "Invalid credentials", "data" => null]);
				}
			} else {
				http_response_code(404);
				echo json_encode(["success" => false, "message" => "No such redord", "data" => null]);
			}
		} else if (!empty(isset($username))) {
			$response = $read_one->read("id, password, username", "doctors", "username=:username", ['username' => $username]);

			if ($response) {
				if (password_verify($password, $response['password'])) {
					http_response_code(202);
					echo json_encode(["success" => true, "message" => "Successfully logged in", "jwt" => Auth::authenticate($response['id'], $response['username']),
					//  "data" => $read_one->read("id, first_name, last_name, username, email, phone, specialization, current_clinic, image", "doctors", "username=:username", ['username' => $username])
					]);					
				} else {
					http_response_code(401);
					echo json_encode(["success" => false, "message" => "Invalid credentials", "data" => null]);
				}
			} else {
				http_response_code(404);
				echo json_encode(["success" => false, "message" => "No such redord", "data" => null]);
			}
		} else {
			http_response_code(400);
			echo json_encode(["success" => false, "message" => "Username or Email must be set", "data" => null]);
		}
	} else {
		return http_response_code(400);
	}
}
