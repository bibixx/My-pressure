<?php
include 'passwords.php';
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);

session_start();
$auth = false;
if( array_key_exists("auth", $_SESSION) ){
  $auth = $_SESSION['auth'];
}

if( ($auth == true) ){
  if( isset($_POST["date"]) && isset($_POST["sys"]) && isset($_POST["dia"]) ){
    if( !empty($_POST["date"]) && !empty($_POST["sys"]) && !empty($_POST["dia"]) ){
      $dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
      $dcs = mysql_select_db(DATABASE);

      $d = $_POST["date"];
      $dateInfo = date_parse_from_format('Y-m-d\TH:i', $d);
      $ut = mktime( $dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'], $dateInfo['month'], $dateInfo['day'], $dateInfo['year'] );

      $query = "INSERT INTO `pressures`(`date`, `sys`, `dia`) VALUES (\"".date("Y-m-d H:i:00", $ut)."\", \"".$_POST["sys"]."\", \"".$_POST["dia"]."\")";
      $data = mysql_query($query);
      mysql_close($dbc);
      header("Location: show.php");
    } else {
      header("Location: insert.php");
    }
  } else {
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
        <form name="login-form" action="insert.php" method="post" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="form-group">
            <label for="sys">Ciśnienie skurczowe (SYS)</label>
            <div class="input-group">
              <span class="input-group-addon" id="sys-addon">
                <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
              </span>
              <input type="number" class="form-control" id="sys" name="sys" placeholder="Ciśnienie skurczowe" aria-describedby="sys-addon" required>
            </div>
          </div>
          <div class="form-group">
            <label for="dia">Ciśnienie rozkurczowe (DIA)</label>
            <div class="input-group">
              <span class="input-group-addon" id="dia-addon">
                <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
              </span>
              <input type="number" class="form-control" id="dia" name="dia" placeholder="Ciśnienie rozkurczowe" aria-describedby="dia-addon" required>
            </div>
          </div>
          <div class="form-group">
            <label for="date">Data</label>
            <div class="input-group">
              <span class="input-group-addon" id="date-addon">
                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
              </span>
              <input type="datetime-local" class="form-control" placeholder="" value="<?=date("Y-m-d\TH:i") ?>" id="date" name="date" aria-describedby="date-addon" required>
            </div>
          </div>
          <button type="submit" class="btn btn-default col-xs-12">Dodaj</button>
        </form>
      </div>
    </div>


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  }
} else {
  $_SESSION["last-page"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  header("Location: .");
  die();
}
?>
