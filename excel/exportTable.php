<?php

/** Error reporting */
//error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start();
}

/** PHPExcel */
include_once("../config/connect.php");
include_once("./ExcelTab.php");
//Functions::afficheBoiteMsg($namefile);
$tabtitre = $_SESSION["header"]; // entete du tableau
$tabcle = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$data = $_SESSION["requete"]; // Contenu du tableau
$titre = $_SESSION["titre"]; // Titre du fichier
$namefile=$_SESSION["nomfichier"]; // nom du fichier excel 
$dat = new DateTime();
$nomfichier = str_replace(" ", "_", $namefile). "_"  .$dat->format("d-m-Y-H-i-s");
//$nomfichier = $titre . "_" . $dat->format("d-m-Y-H-i-s");

ExcelTab ::tabexcel($data, $titre, $tabtitre, $tabcle, $nomfichier);



