<?php

/**
 * Created by PhpStorm.
 * User: jetaimefrc
 * Date: 13/07/2018
 * Time: 20:28
 */
class ListTodo
{
  private $conn;
  public $id;
  public $content;
  public $checkDone;

  public function __construct($db)
  {
    $this->conn = $db;
  }

//  public function bindParam($parameter, $value, $var_type = NULL)
//  {
//    if (is_null($var_type)) {
//      switch (TRUE) {
//        case is_bool($value):
//          $var_type = PDO::PARAM_BOOL;
//          break;
//        case is_int($value):
//          $var_type = PDO::PARAM_INT;
//          break;
//        case is_null($value):
//          $var_type = PDO::PARAM_NULL;
//          break;
//        default:
//          $var_type = PDO::PARAM_STR;
//      }
//    }
//    $this->stmt->bindValue($parameter, $value, $var_type);
//  }

  function read()
  {
    $stmt = $this->conn->prepare("SELECT * FROM Todo;");
    $stmt->execute();
    return $stmt;
  }

  public function readOne()
  {
    $stmt = $this->conn->prepare("SELECT * FROM Todo where  id = ?");

    //bind id of TodoList to be updated
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->id = $row["id"];
    $this->content = $row["content"];
    $this->checkDone = $row["checkDone"];
  }

  function create()
  {
//    $query = "insert into Todo set
//                        content =:content,
//                        checkDone =:checkDone";
    $query = "Insert into Todo(content, checkDone) values (?, ?)";
    $stmt = $this->conn->prepare($query);
    //clean data
    $this->content = htmlspecialchars(strip_tags($this->content));
    $this->checkDone = htmlspecialchars(strip_tags($this->checkDone));
    // bind data
    $stmt->bindValue(1, $this->content);
    $stmt->bindValue(2, $this->checkDone ? 1 : 0, PDO::PARAM_BOOL);

    // execute
    if ($stmt->execute()) {
      return TRUE;
    }
    // print out error
    echo $stmt->error;
    return FALSE;
  }

  public function update()
  {
    $query = "UPDATE Todo SET
                content = ?,
                checkDone = ?
            WHERE
                id = ?";
    // prepare query statement
    $stmt = $this->conn->prepare($query);
    // sanitize
//    $this->content = htmlspecialchars(strip_tags($this->content));
//    $this->checkDone = htmlspecialchars(strip_tags($this->checkDone));
//    $this->id = htmlspecialchars(strip_tags($this->id));
    // bind new values
//    $stmt->bindParam(1, $this->content, PDO::PARAM_STR);
//    $stmt->bindParam(2, $this->checkDone, PDO::PARAM_BOOL);
//    $stmt->bindParam(3, $this->id, PDO::PARAM_INT);
    $stmt->bindValue(1, $this->content);
    $stmt->bindValue(2, $this->checkDone ? 1 : 0, PDO::PARAM_BOOL);
    $stmt->bindValue(3, $this->id);
    // execute the query
    if ($stmt->execute()) {
      return TRUE;
    }
    return FALSE;
  }

  public function delete()
  {
    $stmt = $this->conn->prepare("Delete from Todo where id = ?");
    $stmt->bindValue(1, $this->id);
    if ($stmt->execute()) {
      return TRUE;
    }
    return FALSE;
  }

  public function search($properties, $keywords)
  {
    $sql = NULL;
    if (strcmp($properties, "id") == 0) {
      $sql = "Select * from Todo where id = ? ";
    } else {
      if (strcmp($properties, "content") == 0) {
        $keywords = "%{$keywords}%";
        $sql = "Select * from Todo where content like ? ";
      } else {
        $sql = "Select * from Todo where checkDone = ? ";
      }
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(1, $keywords);
    $stmt->execute();
    return $stmt;
  }

  public function search2($keywords)
  {
    $keywords = "%{$keywords}%";
    $sql = "Select * from Todo where content like ? order by id ";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(1, $keywords);
    $stmt->execute();
    return $stmt;
  }

  public function readPaging($from_record_num, $records_per_page)
  {

  }
}
