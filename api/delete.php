<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once './database.php';

// get database connection
$db = new Database();

// get visitor id
$qrid = isset($_GET["qrid"]) ? $_GET["qrid"] : die();

// delete the visitor
$result = $db->remove('qrid=' . $qrid);

if($result) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Visitor was deleted."));
}

// if unable to delete the visitor
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete visitor."));
}
?>