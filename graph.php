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

    <div class="container-fluid">

      <div class="body-main">

        <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div class="row-fluid">
          <div class="col-xs-12 col-md-6">
            <div id="container2" style="margin: 0 auto"></div>
          </div>
          <div class="col-xs-12 col-md-6">
            <div id="container3" style="margin: 0 auto"></div>
          </div>
        </div>

      </div>

    </div>


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">
<?php
  $sysLimit = array(122, 147);
  $diaLimit = array(70, 97);
  $sysStats = array(0,0,0);
  $diaStats = array(0,0,0);
  $sys = "";
  $dia = "";

  $sort =  "`date` ASC";
  $arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
  setlocale( LC_ALL, $arrLocales );
  $dbc = mysql_connect('localhost', 'root', 'admin') or die( 'błąd' );
  $dcs = mysql_select_db('pressure');

  $query = "SELECT * FROM `pressures` ORDER BY".$sort;
  $data = mysql_query($query);

  while ($row = mysql_fetch_array($data)) {
    $dtime = DateTime::createFromFormat("Y-m-d H:i:s", $row["date"]);
    $t = $dtime->getTimestamp();

    $sysVal = $row["sys"];
    $diaVal = $row["dia"];

    $sys .= "  [Date.UTC(".date("Y, ", $t).(date("n", $t)-1).date(", j, G, i", $t)."), $sysVal],\n";
    if( $sysVal>$sysLimit[1] ){
      $sysStats[2] += 1;
    } else if( $sysVal<$sysLimit[0] ){
      $sysStats[0] += 1;
    } else {
      $sysStats[1] += 1;
    }

    $dia .= "  [Date.UTC(".date("Y, ", $t).(date("n", $t)-1).date(", j, G, i", $t)."), $diaVal],\n";
    if( $diaVal>$diaLimit[1] ){
      $diaStats[2] += 1;
    } else if( $diaVal<$diaLimit[0] ){
      $diaStats[0] += 1;
    } else {
      $diaStats[1] += 1;
    }

  }

  $sys = rtrim($sys, "\n");
  $sys = rtrim($sys, ",");
  $sys .= "\n";

  $dia = rtrim($dia, "\n");
  $dia = rtrim($dia, ",");
  $dia .= "\n";

  echo "var sysData = [\n".$sys;
  echo "];\n\n";

  echo "var diaData = [\n".$dia;
  echo "];\n\n";

  echo "var sysLimit = ".json_encode($sysLimit).";\n";
  echo "var diaLimit = ".json_encode($diaLimit).";\n\n";
  echo "var sysStats = ".json_encode($sysStats).";\n";
  echo "var diaStats = ".json_encode($diaStats).";\n";

  mysql_close($dbc);
?>
    </script>
    <script src="chart.js"></script>
  </body>
</html>

<?php
} else {
  $_SESSION["last-page"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  header("Location: .");
  die();
}
?>
