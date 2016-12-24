<?php 
//Declaration des fichiers à inclure
if (!isset($_SESSION)) {
  session_start();
}
include_once("./config/connect.php"); // Fichier de connexion
include_once("./includeclass.php");  // Fichier de classes
?>