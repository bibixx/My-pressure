<?php
  session_start();
  $_SESSION["auth"] = false;
  $_SESSION["last-page"] = null;
  header("Location: .");
  die();
?>
