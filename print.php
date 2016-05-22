<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <style>
      tr > th:nth-child(2),  tr > td:nth-child(2), tr > th:nth-child(3),  tr > td:nth-child(3) {
        width: 100px;
      }

      .table {
        width: auto;
        min-width:
      }

      .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        font-size: 12px;
      }

      .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border-color: #000;
      }
    </style>
  </head>
  <body>
  <table class="table table-bordered table-responsive">
      <thead>
          <tr>
            <th>Data</th>
            <th>Skurczowe</th>
            <th>Rozkurczowe</th>
          </tr>
      </thead>
      <tbody>
        <?php
          include 'passwords.php';
          $sort =  "`date` ASC";
          $arrLocales = array('pl_PL', 'pl','Polish_Poland.28592');
          setlocale( LC_ALL, $arrLocales );
          $dbc = mysql_connect(HOST, LOGIN, PASSWORD) or die( 'błąd' );
          $dcs = mysql_select_db('pressure');

          $query = "SELECT * FROM `pressures` ORDER BY".$sort;
          $data = mysql_query($query);

          while ($row = mysql_fetch_array($data)) {
            $date = strtotime($row["date"]);
            echo "<tr><td>".strftime ("%d.%m.%Y %R (%A)", $date)."</td><td>".$row["sys"]."</td><td>".$row["dia"]."</td></tr>";
          }

          $query2 = "SELECT COUNT(*) FROM `pressures`";
          $data2 = mysql_query($query2);
          $count = mysql_fetch_array($data2)[0];
          mysql_close($dbc);
        ?>
      </tbody>
  </table>
</body>
</html>
