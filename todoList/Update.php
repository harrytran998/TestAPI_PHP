<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/Database.php';
include_once '../objects/ListTodo.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$listTd = new ListTodo($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

$listTd->id = $data->id;
$listTd->content = $data->content;
$listTd->checkDone = $data->checkDone;

// update the product
if ($listTd->update()) {
  echo '{';
  echo '"message": "ListTodo was updated."';
  echo '}';
} // if unable to update the product, tell the user
else {
  echo '{';
  echo '"message": "Unable to update ListTodo."';
  echo '}';
}
?>
