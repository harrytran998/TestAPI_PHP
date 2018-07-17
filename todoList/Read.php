<?php
/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:27
 */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/ListTodo.php';

$database = new Database();
$db = $database->getConnection();

$todos = new ListTodo($db);

$stmt = $todos->read();
$num = $stmt->rowCount();

if ($num > 0) {
  $todos_arr = array();
  $todos_arr["records"] = array();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $todo_item = array(
      "id" => $id,
      "content" => $content,
      "checkDone" => $checkDone
    );
    array_push($todos_arr["records"], $todo_item);
  }
  echo json_encode($todos_arr);
} else {
  echo json_encode(
    array("message" => "No products found.")
  );
}


