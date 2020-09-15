<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../database.php';

// get database connection
$db = new Database();

// get id of visitor to be edited
$data = json_decode(file_get_contents("php://input"));
$qrid = $data->qrid;

// set visitor property values
$result = $db->update(array(
    "section_name" => $data->section_name,
    "form_name" => $data->form_name,
    "user_data" => $data->user_data
), 'qrid=' . $qrid);

// update the visitor
if($result) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Visitor was updated."));
}

// if unable to update the visitor, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to update visitor."));
}
?>