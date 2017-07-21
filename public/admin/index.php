<?php 
  require_once("../../includes/initialize.php");
  
  if(!$session->is_logged_in()){ redirect_to("login.php"); }
?>
<html>
  <head>
    <title>Photo Gallery</title>
    <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <header>
      <h1>Photo Gallery</h1>
    </header>
    <main>
      <h2>Menu</h2>
    </main>
    <footer>
      Copyright &copy; <?php echo data("Y", time()); ?>, MAshraf.
    </footer>
  </body>
</html>