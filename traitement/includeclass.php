<?php
if (!isset($_SESSION)) {
    session_start();
}
//Declaration des classes à inclure
include_once("../class/ConnectAdmin.php");
include_once("../class/Functions.php");
include_once("../class/utilisateur.php");
include_once("../class/structure.php");
include_once("../class/profil.php");
include_once("../class/userprofil.php");
include_once("../class/annee.php");
include_once("../class/mois.php");
include_once("../class/structure.php");
include_once("../class/personne.php");
include_once("../class/parametre.php");
//include_once("../class/principarle.php.php");

?>