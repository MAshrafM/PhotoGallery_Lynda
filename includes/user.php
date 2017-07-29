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
  // Create User
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
  // Update User
  public function update(){
    global $database;
    $sql = "UPDATE users SET ";
    $sql .= "username = '". $database->escape_value($this->username) ."', ";
    $sql .= "username = '". $database->escape_value($this->password) ."', ";
    $sql .= "username = '". $database->escape_value($this->first_name) ."', ";
    $sql .= "username = '". $database->escape_value($this->last_name) ."'";
    $sql .= " WHERE id = ". $database->escape_value($this->id);
    $database->query($sql);
    return($database->affected_rows() == 1) ? true : false;
  }
    // save Create || Update
  public function save(){
    return isset($this->id) ? $this->update() : $this->create();
  }
  // Delete User
  public function delete(){
    global $database;
    $sql = "DELETE from users ";
    $sql .= "WHERE id = ". $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return($database->affected_rows() == 1) ? true : false;
  }
}
?>