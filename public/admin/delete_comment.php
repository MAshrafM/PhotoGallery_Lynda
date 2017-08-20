<?php 
require_once("../../includes/initialize.php");

if(!$session->is_logged_in()){
  redirect_to("login.php");
}

if(empty($_GET["id"])){
  $session->message("No comment id was provided");
  redirect_to("index.php");
}

$comment = Comment::find_by_id($_GET["id"]);
if($comment && $comment->delete()){
  $session->message("the comment {$comment->filename} was deleted");
  redirect_to("comments.php?id={$comment->photograph_id}");
}
else{
  $session-message("the comment could not be deleted");
  redirect_to("list_photos.php");
}

if(isset($database)){
  $database->close_connection();
}

?>