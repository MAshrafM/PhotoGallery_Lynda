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
    $result_arr = self::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = " . $database->escape_value($id). " LIMIT 1");
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
    $class_name = get_called_class();
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
  // get all class attributes
  protected function attributes(){
    $attributes = array();
    foreach(static::$db_fields as $field){
      if(property_exists($this, $field)){
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }
  // sanitize values
  protected function sanitized_attributes(){
    global $database;
    $clean_attributes = array();
    foreach($this->attributes() as $key => $value){
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }
  // Create Object
  public function create(){
    global $database;
    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO ". static::$table_name ." (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";
    if($database->query($sql)){
      $this->id = $database->insert_id();
      return true;
    }
    else{
      return false;
    }
  }
  // Update Object
  public function update(){
    global $database;
    $attributes = $this->sanitized_attributes();
    $attributes_pairs = array();
    foreach($attributes as $key => $value){
      $attributes_pairs[] = "{$key}= '{$value}'";
    }
    $sql = "UPDATE ". static::$table_name ." SET ";
    $sql .= join(", ", $attributes_pairs);
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
    $sql = "DELETE from ". static::$table_name;
    $sql .= " WHERE id = ". $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return($database->affected_rows() == 1) ? true : false;
  }
}
?>