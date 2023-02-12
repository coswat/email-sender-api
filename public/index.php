<?php

error_reporting(0);
require '../vendor/autoload.php';
header('Content-Type:application/json');
use Api\Controllers\ApiController;

$api = $_POST['apikey'];
$email = $_POST['email'];
//subject is optional param
$subject = $_POST['subject'];
if (!$api || !$email) {
  http_response_code(400);
    $response = [
    'status' => false,
    'message' => 'Params Missing, Required Params email and apikey',
    'data' => []
    ];
    echo json_encode($response);
    exit();
} elseif ($subject) {
    $sendEmail = new ApiController($email, $api, $subject);
    echo $sendEmail->proccess();
} else {
    $sendEmail = new ApiController($email, $api);
    echo $sendEmail->proccess();
}
