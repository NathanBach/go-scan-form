<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once './database.php';

// prepare visitor object
$db = new Database();

// set ID property of record to read
$firstname = isset($_GET["firstname"]) ? $_GET["firstname"] : '';
$lastname = isset($_GET["lastname"]) ? $_GET["lastname"] : '';
$firstname_kata = isset($_GET["firstname_kata"]) ? $_GET["firstname_kata"] : '';
$lastname_kata = isset($_GET["lastname_kata"]) ? $_GET["lastname_kata"] : '';

// read the details of visitor to be edited
if ($firstname !== '') {
$sql = "SELECT *  FROM visitors  WHERE JSON_EXTRACT(`user_data` , '$.demander_name.firstname') = '$firstname' AND JSON_EXTRACT(`user_data` , '$.demander_name.lastname') = '$lastname' AND JSON_EXTRACT(`user_data` , '$.demander_name_kata.firstname') = '$firstname_kata' AND JSON_EXTRACT(`user_data` , '$.demander_name_kata.lastname') = '$lastname_kata'";

    $data = $db->get_list($sql);

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

    $db->dis_connect();

} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user visitor does not exist
    echo json_encode(array("message" => "Visitor does not exist."));
}
?>