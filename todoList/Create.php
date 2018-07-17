<?php
/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:27
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");
// include
include_once '../objects/ListTodo.php';
include_once '../config/Database.php';
// get connect
$database = new Database();
$db = $database->getConnection();
// load and get all blog from database
$listTd = new ListTodo($db);
// get raw posted data
$data = json_decode(file_get_contents("php://input"));
$listTd->content = $data->content;
$listTd->checkDone = $data->checkDone;

if ($listTd->create()) {
  echo json_encode(
    array("Message" => "Blog created")
  );
} else {
  echo json_encode(
    array("Message" => "Blog not created")
  );
}
