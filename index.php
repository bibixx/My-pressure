<?php
include 'passwords.php';
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);

session_start();
$login = "admin";
$pass  = "$2y$10$9ywy5dz93B0HtkBiuHHqqODjPqD6RS2j6z6pn.CQ0JLfuuD5Jer36";

$dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
$dcs = mysql_select_db(DATABASE);

$query = "SELECT `rememberMe` FROM `users` WHERE `login` = 'admin'";
$data = mysql_query($query);
$rememberMe = json_decode(mysql_fetch_array($data)['rememberMe']);
mysql_close($dbc);


if( isset($_COOKIE["token"]) && isset($rememberMe[0]) ){
  if( !empty($_COOKIE["token"]) && !empty($rememberMe[0]) ){
    if( in_array($_COOKIE["token"], $rememberMe) ){
      $_SESSION['auth'] = true;
    }
  }
}

$auth = false;
if( array_key_exists("auth", $_SESSION) ){
  $auth = $_SESSION['auth'];
}

if ( !isset($_POST['login']) && !isset($_POST['password']) && $auth == FALSE ) {
?>
<!DOCTYPE html>
<html>
  <head>
    <?= file_get_contents("includes/head.html"); ?>
  </head>
  <body>
    <?php include 'includes/nav.php'; ?>

    <div class="containter">
      <div class="body-main row">
        <form name="login-form" action="." method="post" class="col-xs-12 col-sm-4 col-md-4 col-lg-4 signin">
          <h2>Zaloguj się!</h2>
          <div class="form-group">
            <label for="login" class="sr-only">Login</label>
            <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
            <label for="password" class="sr-only">Hasło</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Hasło" required>
          </div>
          <div class="rememberMe checkbox">
            <label>
              <input type="checkbox" id="rememberMe" name="rememberMe">
              Zapamiętaj mnie
            </label>
          </div>

          <?php if( isset($_SESSION["login-error"]) && $_SESSION["login-error"] == true ){ ?>
            <div class="alert alert-danger">Błędny login lub hasło!</div>
          <?php } ?>

          <button type="submit" class="btn btn-primary">Zaloguj</button>
        </form>
      </div>
    </div>

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>

<?php
} elseif (isset($_POST['login']) && isset($_POST['password']) && $auth == false) {
  $_SESSION["login-error"] = false;
  if( !empty($_POST['login']) && !empty($_POST['password']) ){
    if( $_POST['login'] == $login && password_verify($_POST['password'], $pass) ){
      $_SESSION['auth'] = true;
      $_SESSION["login-error"] = false;
      if( isset($_POST['rememberMe']) ){
        if( !isset($_COOKIE["token"]) ){
          $hash = password_hash($_POST['login'].$_SERVER['REMOTE_ADDR'], PASSWORD_DEFAULT);

          array_push($rememberMe, $hash);
          $dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
          $dcs = mysql_select_db(DATABASE);

          $query = "UPDATE `users` SET `rememberMe` = '".json_encode($rememberMe)."' WHERE `users`.`id` = 1;";
          $data = mysql_query($query);
          mysql_close($dbc);

          setcookie("token", $hash, time() + (86400 * 365 * 20), "/");
        }
      }
      if( isset($_SESSION['last-page']) ){
        header("Location: ".$_SESSION['last-page']);
      } else {
        header("Location: show.php");
        die();
      }
    } else {
      $_SESSION["login-error"] = true;
      header("Location: .");
      die();
    }
  }
} else {
  header("Location: show.php");
  die();
}
?>
