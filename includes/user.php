<?php
require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject{
  
  protected static $table_name = "users";
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  // get full name
  public function full_name(){
    if(isset($this->first_name) && isset($this->last_name)){
      return $this->first_name . " " . $this->last_name;
    }
    else{
      return "";
    }
  }
  // authenticate user
  public static function authenticate($username="", $password=""){
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);
    
    $sql  = "SELECT * FROM users";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND password = '{$password}' ";
    $sql .= "LIMIT 1";
    
    $result_arr = self::find_by_sql($sql);
    return !empty($result_arr) ? array_shift($result_arr) : false;
  }
  
  public function create(){
    global $database;
    $sql = "INSERT INTO users (";
    $sql .= "username, password, first_name, last_name";
    $sql .= ") VALUES ('";
    $sql .= $database->escape_value($this->username) ."', '";
    $sql .= $database->escape_value($this->password) ."', '";
    $sql .= $database->escape_value($this->first_name) ."', '";
    $sql .= $database->escape_value($this->last_name) ."')";
    if($database->query($sql)){
      $this->id = $database->insert_id();
      return true;
    }
    else{
      return false;
    }
  }
  
  public function update(){
    
  }
  
  public function delete(){
    
  }
}
?>