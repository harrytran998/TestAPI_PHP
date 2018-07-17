<?php

/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:26
 */
class Database
{

  // specify your own database credentials
  private $host = "localhost";
  private $db_name = "TodoList";
  private $username = "root";
  private $password = "jetaime123";
  public $conn;

  // get the database connection
  public function getConnection()
  {

    $this->conn = NULL;
    try {
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
    } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
    }
    return $this->conn;
  }
}
