<?php
/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:27
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/Database.php';
include_once '../objects/ListTodo.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare todoList object
$todoList = new ListTodo($db);

// set ID property of todoList to be edited
$todoList->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of todoList to be edited
$todoList->readOne();

// create array
$todoList_arr = array(
  "id" => $todoList->id,
  "content" => $todoList->content,
  "checkDone" => $todoList->checkDone);

// make it json format
print_r(json_encode($todoList_arr));
