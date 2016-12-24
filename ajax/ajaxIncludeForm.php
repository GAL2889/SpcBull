<?php // 
if (!isset($_SESSION)) {
    session_start();
}
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
include('includeclass.php');
include_once("../inc/form/formPrincipal.php"); 
//include_once("../inc/form/formUtilisateur.php"); 


?>