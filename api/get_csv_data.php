<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$row = 1;
$filename = isset($_GET['f']) ? $_GET['f'] : '';
$arr = array();
if (($handle = fopen("csv/" . $filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c = 0; $c < $num; $c++) {
            array_push($arr, trim($data[$c]));
        }
    }
    fclose($handle);
}
// http_response_code(200);
echo json_encode($arr, JSON_PRETTY_PRINT);