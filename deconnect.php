<?php
if (!isset($_SESSION)) {
  session_start();
}
session_destroy();
//session_unregister("connectUser");
header("Location:index.php");
?>