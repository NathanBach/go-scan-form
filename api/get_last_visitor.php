<?php

// include database and object files
include_once './database.php';

// prepare visitor object
$db = new Database();

$data = json_decode('{"user_data":{"people":{"people1":{"lastname":"Bach","firstname":"Nhan"},"people2":{"lastname":"Bach","firstname":"Nathan"},"people3":{"lastname":"B","firstname":"Nate"},"people4":{"lastname":"Bieber","firstname":"Justin"},"people5":{"lastname":"","firstname":""},"people6":{"lastname":"","firstname":""}},"version":"1","language":"0","device_id":"0000","move_date":"20200910","company_name":"Long Island Record","demander_name":{"lastname":"Bach","firstname":"Nhan"},"temp_re_entry":"1","create_deman_date":"20200726114134","create_re_counter":"都民の声窓口","demander_name_kata":{"lastname":"Bach","firstname":"Nhan"},"create_phone_number":"1787987986"},"section_name":"生活文化局","form_name":"FORM","action":"edit"}');
print_r($data);