<?php
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);

session_start();
$auth = false;
if( array_key_exists("auth", $_SESSION) ){
  $auth = $_SESSION['auth'];
}

if( ($auth == true) ){
?>

<!DOCTYPE html>
<html>
  <head>
    <?= file_get_contents("head.html"); ?>
  </head>
  <body>
    <?php include 'nav.php'; ?>

    <div class="container">

      <div class="body-main">

        insert

      </div>

    </div>


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>

<?php
} else {
  $_SESSION["last-page"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  header("Location: .");
  die();
}
?>
