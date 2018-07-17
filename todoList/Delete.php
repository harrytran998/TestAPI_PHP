<?php
/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:27
 */
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/Database.php';
include_once '../objects/ListTodo.php';

// prepare product object
$database = new Database();
$db = $database->getConnection();

// prepare product object
$listTd = new ListTodo($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

$listTd->id = $data->id;

// delete the product
if($listTd->delete()){
  echo '{';
  echo '"message": "Product was deleted."';
  echo '}';
}

else{
  echo '{';
  echo '"message": "Unable to delete object."';
  echo '}';
}
