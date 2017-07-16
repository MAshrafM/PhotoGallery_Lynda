<?php 
require_once("config.php");

class MySQLDatabase{
  
  private $connection;
  // class construct
  function __construct(){
    $this->open_connection();
  }
  // open db connection and select db
  public function open_connection(){
    $this->connection - mysql_connect(DB_SERVER, DB_USER, DB_PASS);
    if(!$this->connection){
      die("Database connection failed: " . mysql_error());
    }
    else{
      $db_select = mysql_select_db(DB_NAME, $this->connection);
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
    $result = mysql_query($sql, $this->connection);
    confirm_query($result)
    return $result;
  }
  // prep
  public function mysql_prep($value){
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string");
    if($new_enough_php){
      if($magic_quotes_active){
        $value = stripslashes($valye);
      }
    }
    else{
      if(!$magic_quotes_active){
        $value = addslashes($value);
      }
    }
    return $value;
  }
  //confirm query
  private function confirm_query($result){
    if(!$result){
      die("Database connection failed: " . mysql_error());
    }
  }
}

// Database object
$database = new MySQLDatabase();
$db =& $database;
?>