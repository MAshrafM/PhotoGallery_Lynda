<?php 
require_once("../../includes/initialize.php");

if(!$session->is_logged_in()){
  redirect_to("login.php");
}

if(empty($_GET["id"])){
  $session->message("No photograph id was provided");
  redirect_to("index.php");
}

$photo = Photograph::find_by_id($_GET["id"]);
if($photo && photo->destroy()){
  $session->message("the photo {$photo->filename} was deleted");
  redirect_to("list_photos.php");
}
else{
  $session-message("the phot could not be deleted");
  redirect_to("index.php");
}

if(isset($database)){
  $database->close_connection();
}

?>