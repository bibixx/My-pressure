<!DOCTYPE html>
<html>
  <head>
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" media="screen" charset="utf-8">
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">

      <div class="body-main">

        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Skurczowe</th>
                    <th>Rozkurczowe</th>
                </tr>
            </thead>
            <tbody>
              <?php
                $dbc = mysql_connect('localhost', 'root', 'admin') or die( 'błąd' );
                $dcs = mysql_select_db('pressure');

                $query = "SELECT * FROM `pressures` ORDER BY `date` DESC";
                $data = mysql_query($query);

                while ($row = mysql_fetch_array($data)) {
                  echo "<tr><td>".$row["date"]."</td><td>".$row["systolic"]."</td><td>".$row["diastolic"]."</td></tr>";
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
