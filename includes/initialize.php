<?php 
  // Define core paths
  defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR); // define seperator
  defined('SITE_ROOT') ? null : define('SITE_ROOT', 'D:'.DS.'Xamp'.DS.'htdocs'.DS.'Lynda'.DS.'photo_gallery'); // site core
  defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes'); // libaray path
  // load config
  require_once(LIB_PATH.DS."config.php");
  // load basic functions
  require_once(LIB_PATH.DS."functions.php");
  //load core objects
  require_once(LIB_PATH.DS."session.php");
  require_once(LIB_PATH.DS."database.php");
  require_once(LIB_PATH.DS."database_object.php");
  // load db related classes
  require_once(LIB_PATH.DS."user.php");
  
?>