<?php 
require_once(LIB_PATH.DS."config.php");

class MySQLDatabase{
  // attributes
  private $connection;
  private $magic_quotes_active;
  private $real_escape_string_exists;
  public $last_query;
  // class construct
  function __construct(){
    $this->open_connection();
    $this->magic_quotes_active = get_magic_quotes_gpc();
    $this->real_escape_string_exists = function_exists("mysql_real_escape_string");
  }
  // open db connection and select db
  public function open_connection(){
    $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
    if(!$this->connection){
      die("Database connection failed: " . mysql_error());
    }
    else{
      $db_select = mysqli_select_db($this->connection, DB_NAME);
      if(!$db_select){
        die("Database connection failed: " . mysql_error());
      }
    }
  }
  // close connction
  public function close_connection(){
    if(isset($this->connection)){
      mysql_close($this->connection);
      unset($this->connection);
    }
  }
  //query
  public function query($sql){
    $this->last_query = $sql;
    $result = mysqli_query($this->connection, $sql);
    $this->confirm_query($result);
    return $result;
  }
  // prep
  public function escape_value($value){
    if($this->real_escape_string_exists){
      if($this->magic_quotes_active){
        $value = stripslashes($value);
      }
    }
    else{
      if(!$magic_quotes_active){
        $value = addslashes($value);
      }
    }
    return $value;
  }
  // db agnostic
  public function fetch_array($result){
    return mysqli_fetch_array($result);
  }
  public function num_rows($result){
    return mysqli_num_rows($result);
  }
  public function insert_id(){
    return mysqli_insert_id($this->connection);
  }
  public function affected_rows(){
    return mysqli_affected_rows($this->connection);
  }
  //confirm query
  private function confirm_query($result){
    if(!$result){
      $output = "Database query failed: " . mysql_error() . "<br /><br />";
      $output .= "Last SQL query: " . $this->last_query;
      die($output);
    }
  }
}

// Database object
$database = new MySQLDatabase();
$db =& $database;
?>