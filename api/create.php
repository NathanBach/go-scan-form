<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once './database.php';

$db = new Database();

// get posted data
$data = json_decode(file_get_contents("php://input"));
$action = $data->action; // value will be: edit | add
$result = false;
// var_dump($action);die;

if (!empty($data->user_data) && $action === 'edit') {
    // set visitor property values

    $where = "JSON_EXTRACT(`user_data` , '$.demander_name.firstname') = \"{$data->user_data->demander_name->firstname}\" AND JSON_EXTRACT(`user_data` , '$.demander_name.lastname') = \"{$data->user_data->demander_name->lastname}\" AND JSON_EXTRACT(`user_data` , '$.demander_name_kata.firstname') = \"{$data->user_data->demander_name->firstname}\" AND JSON_EXTRACT(`user_data` , '$.demander_name_kata.lastname') = \"{$data->user_data->demander_name->lastname}\"";
    $arr = array(
        "user_data" => json_encode((array)$data->user_data)
    );
    $result = $db->update($arr, $where);

    if ($result) {
        http_response_code(201);
        echo json_encode(array("response" => "Visitor was updated."));
    } else {
        http_response_code(503); // set response code - 503 service unavailable
        echo json_encode(array("response" => "Visitor could not updated."));
    }

}

else if ( !empty($data->section_name) && !empty($data->form_name) && !empty($data->user_data) && $action === 'add' ) {

    $arr = array(
        "section_name" => $data->section_name,
        "form_name" => $data->form_name,
        "user_data" => json_encode((array)$data->user_data),
        "insert_date" => date("Y-m-d H:i:s")
    );
    $result = $db->insert($arr);

    if ($result) {
        http_response_code(201);
        echo json_encode(array("response" => "Visitor was created."));
    } else {
        http_response_code(503);// set response code - 503 service unavailable
        echo json_encode(array("response" => "Unable to create visitor."));
    }
}

else {
    // http_response_code(406); // Bad request
    echo json_encode(array("response" => "Unable to create visitor."));
}
?>