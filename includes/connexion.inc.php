<?php
//$utilisateur = new utilisateur($_SESSION["user"]["codeunique"]);


$idprofilUser = 0;
$libProfil = "";
if (isset($_SESSION['user']['idprofil'])) {
    $idprofilUser = $_SESSION['user']['idprofil'];
    $libProfil = $_SESSION['user']['libprofil'];
}
$requete = "SELECT menu.* FROM  menu,menuprofil WHERE menu.codeunique=menuprofil.idmenu AND idprofil='" . $idprofilUser . "' ORDER  BY  niveau, menu.id";
$result = Functions::commit_sql($requete, "");
$affich = array();
if ($result) {
    $i = 0;
    while ($list = $result->fetch()) {
        $affich[$i]["id"] = $list['id'];
        $affich[$i]["libellemenu"] = $list['libellemenu'];
        $affich[$i]["niveau"] = $list['niveau'];
        $affich[$i]["idMenuSuperieur"] = $list['idMenuSuperieur'];
        $i++;
    }
}
//Functions::afficheBoiteMsg('Merci');
//$_SESSION['userMenu'] = $affich;
$_SESSION['userMenu'] = menuprofil::listeMenuParProfil($idprofilUser);

include_once 'nav/navAccueil.php';
//include_once 'nav/navDT.php';
//include_once 'nav/navElement.php';
//include_once 'nav/navClient.php';
//include_once 'nav/navFournisseur.php';
//include_once 'nav/navDocuments.php';
//include_once 'nav/navCollaboration.php';
include_once 'nav/navSuperAdmin.php';
?>









