<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * author: chris H.
 */
//error_reporting(E_ALL ^ E_NOTICE);
include_once("../config/connect.php"); // Fichier de connexion
include_once("./includeclass.php");  // Fichier de classes
//$import = new importer("");
/* debut controle commun */

$savefile = 0;
$output_dir = "../upload/";
$fichier = $_FILES['relfile']['name'];
$fname = $output_dir . $fichier;

//$i = 0;
//$j = 0;

if ($fichier == "") {
    Functions::afficheBoiteMsg("Veuillez sélectionner le fichier !");
    ?>
    <script>
        document.location.href = "  ../index.php";//?config=cadreLogiqueimport
    </script>
    <?php

} else {
    if (isset($_FILES['relfile']) && $_FILES['relfile']['error'] == 0) {
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['relfile']['size'] <= 2048000) {
            //             Testons si l'extension est autorisÃ©e
            $infosfichier = pathinfo($_FILES['relfile']['name']);
            $extension = $infosfichier['extension']; // on recupère l'extension du fichier 
            $a = explode(".", $fichier);

            if ($extension != 'csv') {
                Functions::afficheBoiteMsg("Veuillez télécharger un fichier excel au format csv !");
                ?> 
                <script>
                //                    document.location.href = "../index.php"//?config=cadreLogiqueimport;
                </script>
                <?php

                $fichier = "";
            } else
            if (move_uploaded_file($_FILES['relfile']['tmp_name'], $fname)) {
                
            } else {
                $savefile = 1;
            }
        } else {
            $savefile = 3;
        }
    } else {
        $savefile = 4;
    }
}

if ($savefile == 0) {
    // correctement
    if (file_exists($fname)) {
        $fp = fopen($fname, "r");
        //Functions::afficheBoiteMsg($msg)
    } else { /* le fichier n'existe pas */
        echo "Fichier introuvable !<br>Importation stoppée.";
        exit();
        ?> 
        <script>
            document.location.href = "../index.php"//?config=cadreLogiqueimport;
        </script>
        <?php

    }

    if ($fp) {
        $affich = array();
        $i = 0;

        while (!feof($fp)) /* Et Hop on importe */ {
            /* Tant qu'on n'atteint pas la fin du fichier */
            $i++;
//    Functions::afficheBoiteMsg("merci Seigneur Jésus ".$i);

            $liste = fgetcsv($fp, 10000000, ';'); /* On lit une ligne */

//        /* On assigne les variables */

            $n = count($liste);
            if ($n > 0)
                $affich[$i]['departement'] = $liste[0];
            else
                $affich[$i]['departement'] = '';
            //  $departement = $liste[0];
            //  Functions::afficheBoiteMsg($departement);
            if ($n > 1)
                $affich[$i]['zonesanitaire'] = $liste[1];
            else
                $affich[$i]['zonesanitaire'] = '';
            // $zonesanitaire = $liste[1];
            if ($n > 2)
                $affich[$i]['commune'] = $liste[2];
            else
                $affich[$i]['commune'] = '';
            //$commune = $liste[2];
            if ($n > 3)
                $affich[$i]['arrondissement'] = $liste[3];
            else
                $affich[$i]['arrondissement'] = '';
            //$arrondissement = $liste[3];
            if ($n > 4)
                $affich[$i]['formationsanitaire'] = $liste[4];
            else
                $affich[$i]['formationsanitaire'] = '';
            // $formationsanitaire = $liste[4];
            if ($n > 5)
                $affich[$i]['annee'] = $liste[5];
            else
                $affich[$i]['annee'] = '';
            //$annee = $liste[5];
            if ($n > 6)
                $affich[$i]['mois'] = $liste[6];
            else
                $affich[$i]['mois'] = '';
            // $mois = $liste[6];
            if ($n > 7)
                $affich[$i]['CCM1'] = $liste[7];
            else
                $affich[$i]['CCM1'] = '';
            //  $CCM1 = $liste[7];
            if ($n > 8)
                $affich[$i]['CCF1'] = $liste[8];
            else
                $affich[$i]['CCF1'] = '';
            //    $CCF1 = $liste[8];
            if ($n > 9)
                $affich[$i]['CCM2'] = $liste[9];
            else
                $affich[$i]['CCM2'] = '';
            //    $CCM2 = $liste[9];
            if ($n > 10)
                $affich[$i]['CCF2'] = $liste[10];
            else
                $affich[$i]['CCF2'] = '';
            //    $CCF2 = $liste[10];
            if ($n > 11)
                $affich[$i]['CCM3'] = $liste[11];
            else
                $affich[$i]['CCM3'] = '';
            //   $CCM3 = $liste[11];
            if ($n > 12)
                $affich[$i]['CCF3'] = $liste[12];
            else
                $affich[$i]['CCF3'] = '';
            //    $CCF3 = $liste[12];
            if ($n > 13)
                $affich[$i]['CCM4'] = $liste[13];
            else
                $affich[$i]['CCM4'] = '';
            //    $CCM4 = $liste[13];
            if ($n > 14)
                $affich[$i]['CCF4'] = $liste[14];
            else
                $affich[$i]['CCF4'] = '';
            //    $CCF4 = $liste[14];
            if ($n > 15)
                $affich[$i]['CHM1'] = $liste[15];
            else
                $affich[$i]['CHM1'] = '';
            //    $CHM1 = $liste[15];
            if ($n > 16)
                $affich[$i]['CHF1'] = $liste[16];
            else
                $affich[$i]['CHF1'] = '';
            //    $CHF1 = $liste[16];
            if ($n > 17)
                $affich[$i]['CHM2'] = $liste[17];
            else
                $affich[$i]['CHM2'] = '';
            //   $CHM2 = $liste[17];
            if ($n > 18)
                $affich[$i]['CHF2'] = $liste[18];
            else
                $affich[$i]['CHF2'] = '';
            //   $CHF2 = $liste[18];
            if ($n > 19)
                $affich[$i]['CHM3'] = $liste[19];
            else
                $affich[$i]['CHM3'] = '';
            //    $CHM3 = $liste[19];
            if ($n > 20)
                $affich[$i]['CHF3'] = $liste[20];
            else
                $affich[$i]['CHF3'] = '';
            //    $CHF3 = $liste[20];
            if ($n > 21)
                $affich[$i]['CHM4'] = $liste[21];
            else
                $affich[$i]['CHM4'] = '';
            //  $CHM4 = $liste[21];
            if ($n > 22)
                $affich[$i]['CHF4'] = $liste[22];
            else
                $affich[$i]['CHF4'] = '';
            if (($liste[0] == "") && ($liste[1] == "") && ($liste[2] == "") && ($liste[3] == "") && ($liste[4] == "") && ($liste[5] == "") && ($liste[6] == "")) {

                //echo 'Merci'.$liste[5].'Marie';
            } else {
                $redoublon = "SELECT * FROM epidemtampon WHERE departement= '" . utf8_encode($liste[0]) . "' AND zonesanitaire='" . $liste[1] . "' AND commune='" . $liste[2] . "' AND arrondissement='" . $liste[3] . "' AND formationsanitaire='" . $liste[4] . "' AND annee='" . $liste[5] . "' AND mois= '" . $liste[6] . "' ";
                $redoublonresult = Functions::commit_sql($redoublon, '');

                if ($redoublonresult) {
                    $ls = $redoublonresult->fetch();
                    if ($ls['id'] != "") {

                        //Functions::afficheBoiteMsg("l\'enregistrerment existe");
                    } else {
                        $rekete = "INSERT INTO epidemtampon(departement,zonesanitaire,commune,arrondissement,formationsanitaire,annee,mois,CCM0_11,CCF0_11,CCM1_4,CCF1_4,CCM5_14,CCF5_14,CCM15,CCF15,CHM0_11,CHF0_11,CHM1_4,CHF1_4,CHM5_14,CHF5_14,CHM15,CHF15) 
             VALUES ('" . utf8_encode($liste[0]) . "','" . $liste[1] . "', '" . $liste[2] . "' ,'" . $liste[3] . "','" . $liste[4] . "','" . $liste[5] . "','" . $liste[6] . "','" . $liste[7] . "','" . $liste[8] . "','" . $liste[9] . "','" . $liste[10] . "','" . $liste[11] . "','" . $liste[12] . "','" . $liste[13] . "','" . $liste[14] . "','" . $liste[15] . "','" . $liste[16] . "','" . $liste[17] . "','" . $liste[18] . "','" . $liste[19] . "','" . $liste[20] . "','" . $liste[21] . "','" . $liste[22] . "')";
                        $result = Functions::commit_sql($rekete, '');
                    }
                }
            }
        }//fin WHILE                
        echo "<br>Importation terminée, avec succès.";
        validerEpidemiologie();
        /* Fermeture */
        fclose($fp);
    } else {
        echo 'je marche pas';
    }
}

/*
 * enregistement dans epidemiologie
 */

function validerEpidemiologie() {
    $reketeepidem = "select * from epidemtampon";
    $resultepidem = Functions::commit_sql($reketeepidem, '');
    if ($resultepidem) {
        while ($liste = $resultepidem->fetch()) {
            $idannee = annee::getIdAnneebylibelle($liste['annee']);
            $idmois = mois::getIdMoisbylibelle($liste['mois']);
            $idstructure = structure::getIdStructbylibelle($liste['formationsanitaire']);
            $iddeclaration = declarationintrant::idDeclarationintrantParCritere($idannee, $idmois, $idstructure, 3);
           if ($iddeclaration != 0) {
             $reketeepidemio = "INSERT INTO epidemiologie(iddeclaration,idcible,valeur)";
             $reketeepidemio .= "VALUES ('".$iddeclaration."','CCM0_11','".$liste['CCM0_11']."'),('".$iddeclaration."','CCF0_11','".$liste['CCF0_11']."'), ";
             $reketeepidemio .= "('".$iddeclaration."' ,'CCM1_4','".$liste['CCM1_4']."'),('".$iddeclaration."','CCF1_4','".$liste['CCF1_4']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CCM5_14','".$liste['CCM5_14']."'),('".$iddeclaration."','CCF5_14','".$liste['CCF5_14']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CCM15','".$liste['CCM15']."'),('".$iddeclaration."','CCF15','".$liste['CCF15']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CHM0_11','".$liste['CHM0_11']."'),('".$iddeclaration."','CHF0_11','".$liste['CHF0_11']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CHM1_4','".$liste['CHM1_4']."'),('".$iddeclaration."','CHF1_4','".$liste['CHF1_4']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CHM5_14','".$liste['CHM5_14']."'),('".$iddeclaration."','CHF5_14','".$liste['CHF5_14']."'),";
             $reketeepidemio .= "('".$iddeclaration."','CHM15','".$liste['CHM15']."'),('".$iddeclaration."','CHF15','".$liste['CHF15']."')";
             //echo $reketeepidemio;
             $result = Functions::commit_sql($reketeepidemio, '');  
            }
        }//fin while
    }
}

//    function doublon($index, $tablo = array()) {
//        for ($i = 1; $i < count($tablo); $i++) {
//            if ($i <> $index) {
//                if (($tablo[$index]['departement'] == $tablo[$i]['departement']) && ($tablo[$index]['zonesanitaire'] == $tablo[$i]['zonesanitaire']) && ($tablo[$index]['commune'] == $tablo[$i]['commune']) && ($tablo[$index]['arrondissement'] == $tablo[$i]['arrondissement']) && ($tablo[$index]['formationsanitaire'] == $tablo[$i]['formationsanitaire']) && ($tablo[$index]['annee'] == $tablo[$i]['annee']) && ($tablo[$index]['mois'] == $tablo[$i]['mois']))
//                    return 0;
//            }
//            else {
//                return 1;
//            }
//        }
//    }
//
//    function verifDoublon($tablo = array()) {
//        for ($i = 1; $i < count($tablo); $i++) {
//            $b = doublon($i, $tablo);
//            if ($b == 0) {
//                echo 'Merci ' . $i;
//                print_r($tablo[$i]);
//            }
//        }
//    }
?>
