<?
$a1 = "";
$a2 = "";
$a3 = "";
$logout = '<ul class="nav navbar-nav navbar-right"><li><a href="logout.php">Wyloguj</a></li></ul>';

switch ($filename) {
  case 'show':
    $a1 = "class=\"active\"";
    break;

  case 'insert':
    $a2 = "class=\"active\"";
    break;

  case 'graph':
    $a3 = "class=\"active\"";
    break;

  case 'index':
    $logout = "";
    break;
}

echo <<< END
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href=".">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
      </a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
END;

echo "<li $a1><a href=\"show.php\">Pokaż dane</a></li>";
echo "<li $a2><a href=\"insert.php\">Wprowadź dane</a></li>";
echo "<li $a3><a href=\"graph.php\">Pokaż wykres</a></li>";

echo <<< END
      </ul>
      $logout
    </div>
  </div>
</nav>
END;
?>
