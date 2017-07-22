<?php
  require_once(LIB_PATH.DS.'database.php');
  
  class DatabaseObject{
    // Common DB Methods
  // Find All
  public static function find_all(){
    return static::find_by_sql("SELECT * FROM ".static::$table_name);
  }
  // Find One by ID
  public static function find_by_id($id = 0){
    global $database;
    $result_arr = self::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = {$id} LIMIT 1");
    return !empty($result_arr) ? array_shift($result_arr) : false;
  }
  // Find by special sql
  public static function find_by_sql($sql=""){
    global $database;
    $result_set = $database->query($sql);
    $obj_arr = array();
    while($row = $database->fetch_array($result_set)){
      $obj_arr[] = static::instantiate($row);
    }
    return $obj_arr;
  }
  // init object
  private static function instantiate($record){
    $class_name = get_called_class()
    $obj = new $class_name;    
    foreach($record as $attr=>$value){
      if($obj->has_attribute($attr)){
        $obj->$attr = $value;
      }
    }
    return $obj;
  }
  // check if it has attr
  private function has_attribute($attr){
    $obj_vars = get_object_vars($this);
    return array_key_exists($attr, $obj_vars);
  }

  }
?>