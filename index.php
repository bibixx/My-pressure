<?php
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);

session_start();
$login = "admin";
$pass  = "admin1";

$auth = false;
if( array_key_exists("auth", $_SESSION) ){
  $auth = $_SESSION['auth'];
}

if (!isset($_POST['login']) && !isset($_POST['password']) && $auth == FALSE) {
?>
<!DOCTYPE html>
<html>
  <head>
    <?= file_get_contents("head.html"); ?>
  </head>
  <body>
    <?php include 'nav.php'; ?>

    <div class="containter">
      <div class="body-main row">
        <form name="login-form" action="." method="post" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Login">
          </div>
          <div class="form-group">
            <label for="password">Hasło</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Hasło">
          </div>
          <button type="submit" class="btn btn-default">Zaloguj</button>
        </form>
      </div>
    </div>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>

<?php
} elseif (isset($_POST['login']) && isset($_POST['password']) && $auth == false) {
  if( !empty($_POST['login']) && !empty($_POST['password']) ){
    if( $_POST['login'] == $login && $_POST['password'] == $pass ){
      $_SESSION['auth'] = true;
      if( isset($_SESSION['last-page']) ){
        header("Location: ".$_SESSION['last-page']);
      } else {
        header("Location: show.php");
        die();
      }
    } else {
      header("Location: .");
      die();
    }
  }
} else {
  header("Location: show.php");
  die();
}
?>
