<?php

error_reporting(0);
require "../vendor/autoload.php";
header("Content-Type:application/json");

use Api\Controllers\ApiController;
use Dotenv\Dotenv;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
$api = $_POST["apikey"];
$email = $_POST["email"];
 $dotenv = Dotenv::createImmutable('../');
 $dotenv->load();
 
$subject = $_POST["subject"];//subject is optional param
if (!$api || !$email) {
    http_response_code(400);
    $response = [
        "status" => false,
        "message" => "Params Missing, Required Params email and apikey",
        "data" => [],
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
}else {
  http_response_code(405);
    $response = [
        "status" => false,
        "message" => 'Api Method Is Post, Sended Method Is '.$_SERVER['REQUEST_METHOD'],
    ];
    echo json_encode($response);
    exit();
}