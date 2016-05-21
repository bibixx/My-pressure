<?php
$filename = pathinfo(__FILE__, PATHINFO_FILENAME);

function a($attr){
  $classUp = "glyphicon glyphicon-triangle-top";
  $classDown = "glyphicon glyphicon-triangle-bottom";
  if( array_key_exists("by", $_GET) && array_key_exists("dir", $_GET) ){
    if( $_GET["by"] == $attr ){
      if( $_GET["dir"] == "a" ){
        $classUp .= " text-primary";
      } elseif( $_GET["dir"] == "d" ){
        $classDown .= " text-primary";
      }
    }
  } else {
    if( $attr == "date" ){
      $classDown .= " text-primary";
    }
  }

  echo "<span class=\"pull-right\">";
  echo "<a href=\"?by=$attr&dir=a\"><span class=\"$classUp\" aria-hidden=\"true\"></span></a>";
  echo "<a href=\"?by=$attr&dir=d\"><span class=\"$classDown\" aria-hidden=\"true\"></span></a>";
  echo "</span>";
}

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

        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                  <th>Data <?=a("date")?></th>
                  <th>Skurczowe [mmHg]<?=a("sys")?></th>
                  <th>Rozkurczowe [mmHg]<?=a("dia")?></th>
                </tr>
            </thead>
            <tbody>
              <?php
                $sort =  "`date` DESC";
                if( array_key_exists("by", $_GET) && array_key_exists("dir", $_GET) ){
                  $dirG = $_GET["dir"];
                  $dir = "DESC";
                  if( strtoupper($dirG) == "D" ){
                    $dir = "DESC";
                  } elseif ( strtoupper($dirG) == "A" ) {
                    $dir = "ASC";
                  }
                  $sort = "`".$_GET["by"]."` ".$dir;
                }

                $arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
                setlocale( LC_ALL, $arrLocales );
                $dbc = mysql_connect('localhost', 'root', 'admin') or die( 'błąd' );
                $dcs = mysql_select_db('pressure');

                $query = "SELECT * FROM `pressures` ORDER BY".$sort;
                $data = mysql_query($query);

                while ($row = mysql_fetch_array($data)) {
                  $date = strtotime($row["date"]);
                  echo "<tr><td>".strftime ("%d.%m.%Y %R (%A)", $date)."</td><td>".$row["sys"]."</td><td>".$row["dia"]."</td></tr>";
                }
              ?>
            </tbody>
        </table>

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
