<?php 
  require_once("../../includes/functions.php");
  require_once("../../includes/session.php");
  require_once("../../includes/database.php");
  require_once("../../includes/user.php");
  
  if($session->is_logged_in()){
    redirect_to("index.php");
  }
  //Form with name submit
  if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POSTp['password']);
  }
  // check db if user exists
  $found_user = User::authenticate($username, $password);
    if($found_user){
      $session->login($found_user);
      redirect_to("index.php");
    }
    else{
      $message = "Username/Password combination not correct";
    }
  else{
    $username = "";
    $password = "";
  }
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
      <h2>Staff Login</h2>
      <?php echo output_message($message); ?>
      <form action="login.php" method="post">
        <table>
          <tr><td>Username: </td><td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" /></td></tr>
          <tr><td>Password: </td><td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" /><td></tr>
          <tr><td colspan="2"><input type="submit" name="submit" value="Login" /></td></tr>
        </table>
      </form>
    </main>
    <footer>
      Copyright &copy; <?php echo data("Y", time()); ?>, MAshraf.
    </footer>
  </body>
</html>
<?php 
if(isset($database)){
  $database->close_connection();
}
?>