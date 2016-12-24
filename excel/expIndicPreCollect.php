<?php

/** Error reporting */
error_reporting(E_ALL);



/** PHPExcel */
include_once("../config/connect.php");
include_once("./includeclass.php");





$affich = Functions::affichePrecollecteParOng($_GET['annee'], $_GET['mois'], $_GET['ong'], $_GET['departement'], $_GET['commune'], $_GET['arrondissement'], $_GET['quartier'], $_GET['mode']);

$zone = "ONG";
$titre = "INDICATEUR SUR LES QUANTITES DE DSM PRE-COLLECTEES PAR ONG ";
if ($_GET['mois'] != 0) {
    $titre.=" EN " . strtoupper(Functions::moisEncours($_GET['mois'])) . " " . $_GET['annee'];
}

// Create new PHPExcel object

$i = 0;
$totattendu = 0;
$totprecollecte = 0;
$totbasfond = 0;

foreach ($affich as $v){


    $totattendu += $v["quantiteattendue"];
    $totprecollecte += $v["quantiteprecollecte"];
    $totbasfond+=$v["quantitebasfond"];


    $i++;

}


if ($totattendu <> 0) {
    $tottaux = $totprecollecte * 100 / $totattendu;
    $tottaux = number_format($tottaux, 2, ',', ' ') . " %";
} else {
    $tottaux = " - ";
}

$affich[i]["nomparam"] = 'TOTAL';
$affich[i]["quantiteattendue"] = number_format($totattendu, 2, ',', ' ');
$affich[i]["quantiteprecollecte"] = number_format($totprecollecte, 2, ',', ' ');
$affich[i]["quantitebasfond"] = number_format($totbasfond, 2, ',', ' ');
$affich[i]["taux"] = $tottaux;

$nomfichier = 'Indicateur_PreCollecte';
$listecle = 'nomparam;quantiteattendue;quantiteprecollecte;quantitebasfond;taux';
$listTitre = $zone.';Quantité attendue (m3);Quantité Pré - collectée (m3);Quantité vers bas-fonds (m3);Taux de collecte';

ExcelTab ::tabexcel($affich, $titre, $listTitre, $listecle,$nomfichier);



