<?php
/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:27
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/Database.php';
include_once '../objects/ListTodo.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$listTd = new ListTodo($db);

// get keywords
$property = isset($_GET["pro"]) ? $_GET["pro"] : "";
$keyword = isset($_GET["key"]) ? $_GET["key"] : "";
// query products
$stmt = $listTd->search($property, $keyword);
//$stmt = $listTd->search2($keyword);
$num = $stmt->rowCount();

if ($num > 0) {

  // products array
  $listTd_arr = array();
  $listTd_arr["records"] = array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $listTd__item = array(
      "id" => $id,
      "content" => $content,
      "checkDone" => $checkDone
    );
    array_push($listTd_arr["records"], $listTd__item);
  }
  echo json_encode($listTd_arr);
} else {
  echo json_encode(
    array("message" => "No Todo found.")
  );
}
