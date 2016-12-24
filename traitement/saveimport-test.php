<?php

//Declaration des classes à inclure

require './excel_reader2.php';
include_once("../config/connect.php");
include_once("../class/Functions.php");
include_once("../class/releve.php");
include_once("../class/relevemensuel.php");
include_once("../class/patient.php");
include_once("../class/cas.php");
include_once("../class/utilisateur.php");
include_once("../class/personne.php");
include_once("../class/structure.php");
include_once("../class/epidemiologie.php");

if (!isset($_SESSION)) {
    session_start();
}

function GetDATA($v) {
    return isset($v) ? stripcslashes(trim($v)) : "";
}

$output_dir = "../upload/";

if (isset($_FILES["relfile"])) {
    //Filter the file types , if you want.
    if ($_FILES["relfile"]["error"] > 0) {
        echo "err";
    } else {

        $fdir = $output_dir . $_FILES["relfile"]["name"];

        //move the uploaded file to uploads folder;
        move_uploaded_file($_FILES["relfile"]["tmp_name"], $fdir);

        $data = new Spreadsheet_Excel_Reader($fdir);

        $send = "";
        $pass = "47555";
        $mistake = array();

        $code = GetDATA($data->sheets[0]['cells'][1][1]);

        //$kk = $_POST['idr'];

        $rm = new epidemiologie($_POST['idr']);
        $idstrr = $rm->getId();

        if ($code == $pass) {

            $i = 3;
            $mem = -10;

            while ($i <= $data->sheets[0]['numRows'] &&
            strlen(GetDATA($data->sheets[0]['cells'][$i][2])) > 0) {

                $idtypp = GetDATA($data->sheets[0]['cells'][$i][14]);

                $idcatt = GetDATA($data->sheets[0]['cells'][$i][5]) <= 5 ? 1 : 2;

                $nomm = GetDATA($data->sheets[0]['cells'][$i][3]);
                $prenomm = GetDATA($data->sheets[0]['cells'][$i][4]);
                $idpatt = patient::verifPatient($nomm . " " . $prenomm);

                if ($idpatt == 0) {

                    $rekete = "INSERT INTO patient (nom,prenom,datenaissance,age,indicatifmaison,telephone,idsexe,idlocalite,idcreateur) VALUES(?,?,?,?,?,?,?,?,?)";
                    $param = array($nomm, $prenomm, "", GetDATA($data->sheets[0]['cells'][$i][5]),
                        "", "", "", GetDATA($data->sheets[0]['cells'][$i][8]), $_SESSION["user"]["id"]);

                    //$result = Functions::commit_sql($rekete, $param);                 
                    //$idpatt = Functions::getidMax("patient");  
                }

                $dateCas = DateTime::createFromFormat("d/m/Y", GetDATA($data->sheets[0]['cells'][$i][2]))->format("Y-m-d");

                $idtraitant = GetDATA($data->sheets[0]['cells'][$i][11]);


                //$send.="<p> CAS :  (structure : $idstrr) (type palu : $idtypp) (categorie: $idcatt)  (patient : $nomm $prenomm) ( date : $dateCas)  </p>";


                $ans = Functions::get_record_byCondition("cas", " idstructure = ?  and idtypepalu = ? and idcategorie = ? and idpatient = ? and datejour = ? ", array($idstrr, $idtypp, $idcatt, $idpatt, $dateCas));

                if ($ans) {
                    $curid = $ans->fetch();
                    $curid = $curid['id'];
                } else {

                    $rekete = "INSERT INTO cas(idstructure,idtypepalu,idcategorie,idpatient,idreleve, datejour,idpersonne,idcreateur,numfacture) VALUES(?,?,?,?,?,?,?,?,?)";
                    $param = array($idstrr, $idtypp, $idcatt, $idpatt, $_POST['idr'], $dateCas, $idtraitant, $_SESSION["user"]["id"], cas::getNumFactureCas());
                    //$result = Functions::commit_sql($rekete, $param);
                    //$curid = Functions::getidMax("cas");                    
                }
                //*/


                $curlgn = GetDATA($data->sheets[0]['cells'][$i][1]);

                while ($i <= $data->sheets[0]['numRows'] &&
                strlen(GetDATA($data->sheets[0]['cells'][$i][2])) > 0 &&
                GetDATA($data->sheets[0]['cells'][$i][1]) == $curlgn) {


                    $qtt = GetDATA($data->sheets[0]['cells'][$i][20]);
                    $prixuu = GetDATA($data->sheets[0]['cells'][$i][21]);

                    $iddintrant = $iddacte = 0;
                    $idDesign = explode("-", GetDATA($data->sheets[0]['cells'][$i][18]));

                    if ($idDesign[0] == "i") {
                        $iddintrant = $idDesign[1];
                    } else {
                        $iddacte = $idDesign[1];
                    }

                    $rekete = "insert into detailscas (idcas,idacte,idintrant,quantite,montant,idcreateur) values(?,?,?,?,?,?)";
                    $param = array($curid, $iddacte, $iddintrant, $qtt, $prixuu, $_SESSION["user"]["id"]);
                    //$resultat = Functions::commit_sql($rekete, $param);
                    //*/
                    //$send.="<p> DETAIL  CAS :   ( ligne : $curlgn ) (acte id : $iddacte) (intrant id : $iddintrant) ( quantite : $qtt) (prix : $prixuu)  </p>";

                    $i++;
                }
            }
        } else {
            $mistake[] = "Votre fichier n'est pas le bon !!";
        }
        //echo $send;
        echo count($mistake) == 0 ? "done" : $mistake[0];
    }
}

?>
