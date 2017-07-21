<?php
require_once("database.php");

class User{
  
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;
  
  public static function find_all(){
    return self::find_by_sql("SELECT * FROM users");
  }
  
  public static function find_by_id($id = 0){
    global $database;
    $result_arr = self::find_by_sql("SELECT * FROM users WHERE id = {$id} LIMIT 1");
    return !empty($result_arr) ? array_shift($result_arr) : false;
  }
  
  public static function find_by_sql($sql=""){
    global $database;
    $result_set = $database->query($sql);
    $obj_arr = array();
    while($row = $database->fetch_array($result_set)){
      $obj_arr[] = self::instantiate($row);
    }
    return $obj_arr;
  }

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
  public function full_name(){
    if(isset($this->first_name) && isset($this->last_name)){
      return $this->first_name . " " . $this->last_name;
    }
    else{
      return "";
    }
  }
  
  private static function instantiate($record){
    $obj = new self;    
    foreach($record as $attr=>$value){
      if($obj->has_attribute($attr)){
        $obj->$attr = $value;
      }
    }
    return $obj;
  }
  
  private function has_attribute($attr){
    $obj_vars = get_object_vars($this);
    return array_key_exists($attr, $obj_vars);
  }
}
?>