<?php 
require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject{
  protected static $table_name = "comments";
  protected static $db_fields = array("id", "photograph_id", "created", "author", "body");
  
  public $id;
  public $photograph_id;
  public $created;
  public $author;
  public $body;
  
  public static function make($photo_id, $author="Anon", $body=""){
    if(!empty($photo_id) && !empty($author) && !empty($body)){
      $comment = new Comment();
      $comment->photograph_id = (int)$photo_id;
      $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
      $comment->author = $author;
      $comment-body = $body;
      return $comment;
    }
    else{
      return false;
    }
  }
  
  public static function find_comments_on($photo_id = 0){
    global $database;
    $sql = "SELECT * FROM ". self::$table_name;
    $sql .= " WHERE photograph_id = " .$database=>escape_value($photo_id);
    $sql .= " ORDER BY created ASC";
    return self::find_by_sql($sql);
  }

  public static send_notification(){
    $mail = new PHPMailer();
    
    $mail->IsSMTP();
    $mail->Host = "your.host.com";
    $mail->Port = 25;
    $mail->SMTPAuth = false;
    $mail->Username = "MAshraf";
    $mail->Password = "password";
    
    $mail->FromName = "Photo Gallery";
    $mail->From = "noreply@pg.com";
    $mail->AddAddress("MA", "PG Admin");
    $mail->Subject = "New Comment";
    $mail->Body =<<<EMAILBODY
    A new comment has been recieved in the PG.
    
    At {$this->created}, {$this->author} wrote:
    
    {$this->body}
    
    EMAILBODY;
    
    $result = $mail->Send();
    return $result;
  }
}
?>