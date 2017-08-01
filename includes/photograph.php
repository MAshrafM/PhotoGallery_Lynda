<?php

require_once(LIB_PATH.DS.'database.php');

class Photograph extends DatabaseObject{
  protected static $table_name = "photographs";
  protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption');
  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;
  private $temp_path;
  protected $upload_dir = "images";
  public $error = array();
  protected $upload_errors = array(
    UPLOAD_ERR_OK => "No Errors",
    UPLOAD_ERR_INI_SIZE => "Larger than max uploadfile size",
    UPLOAD_ERR_FROM-SIZE => "Larger than max file size",
    UPLOAD_ERR_PARTIAL => "Partial upload",
    UPLOAD_ERR_NO_FILE => "No file",
    UPLOAD_ERR_NO_TMP_DIR => "No temp dir",
    UPLOAD_ERR_CANT_WRITE => "Cant write to disk",
    UPLOAD_ERR_EXTENSION => "unsupported extension"
  );
  
  public function attach_file($file){
    if(!$file || empty($file) || !is_array($file)){
      $this->errors[] = "No file uploaded";
      return false;
    }
    elseif($file['error'] != 0){
      $this->errors[] = $this->upload_errors[$file['error']];
      return false;
    }
    else{
      $this=>temp_path = $file['tmp_name'];
      $this->filename = basename($file['name']);
      $this->type = $file['type'];
      $this->size = $file['size'];
      return true;
    }
  }
}