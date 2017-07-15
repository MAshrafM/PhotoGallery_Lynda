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
}

// Database object
$database = new MySQLDatabase();
$db =& $database;
?>