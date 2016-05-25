<?php
include 'passwords.php';
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
    <?= file_get_contents("includes/head.html"); ?>
  </head>
  <body>

    <?php include 'includes/nav.php'; ?>

    <div class="container">

      <div class="body-main">
        <h2>
          Twoje wyniki
          <button class="btn btn-default pull-right" style="margin-bottom: 20px" id="btnPrint" type="button" title="Wydrukuj">
            Wydrukuj&nbsp;&nbsp;<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
          </button>
        </h2>

        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                  <th>Data <?=a("date")?></th>
                  <th>Skurczowe <span class="hidden-xs">[mmHg]</span><?=a("sys")?></th>
                  <th>Rozkurczowe <span class="hidden-xs">[mmHg]</span><?=a("dia")?></th>
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

                setlocale(LC_ALL, 'pl_PL.UTF-8');
                $dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
                $dcs = mysql_select_db(DATABASE);
                mysql_query('SET NAMES utf8');

                $offset = isset($_GET["page"]) ? ($_GET["page"]-1 >= 0 ? $_GET["page"]-1 : 0) : 0;
                $query = "SELECT * FROM `pressures` ORDER BY".$sort." LIMIT 15 OFFSET ".$offset*15;
                $data = mysql_query($query);

                if ( empty($data[0]) ){
                  $empty = true;
                } else {
                  $empty = false;
                }

                while ($row = mysql_fetch_array($data)) {
                  $date = strtotime($row["date"]);
                  echo "<tr><td>".strftime ("%d.%m.%Y %R (%A)", $date)."</td><td>".$row["sys"]."</td><td>".$row["dia"].'<div id="'.$row["id"].'" class="controls"><span class="pull-right glyphicon glyphicon-remove-circle" aria-hidden="true"></span>'."</td></tr>";
                }
                $query2 = "SELECT COUNT(*) FROM `pressures`";
                $data2 = mysql_query($query2);
                $count = mysql_fetch_array($data2)[0];
                mysql_close($dbc);
              ?>
            </tbody>
        </table>

        <ul class="pagination">
          <?php

            $url = "?";
            foreach ($_GET as $key => $value) {
              if( $key != 'page' ){
                $url .= $key."=".$value."&";
              }
            }

            $url1 = $url.'page='.$offset;
            $url2 = $url.'page='.($offset+2);

            if( ceil($count/15)-1 > 0 ){

              if( $offset > 0 ){
                echo '<li><a href="'.$url1.'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
              }

              for($x=1; $x<=ceil($count/15); $x++){
                $urlX = $url."page=".$x;
                if( $x == ($offset+1) ){
                  echo "<li class=\"active\"><a href=\"$urlX\">$x</a></li>";
                } else {
                  echo "<li><a href=\"$urlX\">$x</a></li>";
                }
              }

              if( $offset < ceil($count/15)-1 ){
                echo '<li><a href="'.$url2.'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
              }

            }
          ?>
        </ul>

      </div>

    </div>


    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="js/jquery.printPage.js" type="text/javascript"></script>
    <script src="js/show.js" type="text/javascript"></script>
  </body>
</html>

<?php
} else {
  $_SESSION["last-page"] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  header("Location: .");
  die();
}
?>
