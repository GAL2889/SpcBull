<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($_SESSION)) {
    session_start();
}
//$_SESSION['photoelt']= "";
include_once("../config/connect.php"); // Fichier de connexion
include_once("./includeclass.php");  // Fichier de classes
$codeunique = ""; 
//traitement de la photo
$msg = ""; //Functions::afficheBoiteMsg('Merci Seigneur');
 if (isset($_POST['codeunique'])) {
    $codeunique = $_POST['codeunique'];
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

    if ($_FILES['photo']['size'] <= 8000000) {

        $infosfichier = pathinfo($_FILES['photo']['name']);
        $extension = $infosfichier['extension'];
        $basename = $infosfichier['basename'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG');
        if (in_array($extension, $extensions_autorisees)) {

            if (move_uploaded_file($_FILES['photo']['tmp_name'], '../images/photo/' . $basename)) {
    
               
    $rf = '0';
}
//                $_SESSION['photoelt']= $basename;
                
                $rekete = "UPDATE elementcommercial SET photo ='" . $basename . "' WHERE codeunique = '" . $codeunique . "'";
                $result = Functions::commit_sql($rekete, "");           // echo 'Merci '.$rekete; 
            if ($result) {
                $rf = personne::ajoutReketeSynchro($rekete);
            } else {
                $rf = '0';
            }
            
            } else {
                $savefile = 1;
                $msg = "L'image n'a pas pu être uploadé";
            }
        } else {
            $savefile = 2;
            $msg = "L'extension du fichier n'est pa pris en charge";
        }
    } else {
        $savefile = 3;
        $msg = "La taille de l'image est trop élevée (> 8Mo)";
    }
} else {
//    functions::afficheBoiteMsg("la dedans40 ".$_POST['photobd']);
    $savefile = 4;
if(isset($_POST['photobd'])){
////    functions::afficheBoiteMsg("la dedans40 ".$_POST['photobd']);
//    $_SESSION['photoelt'] = $_POST['photobd'];
//  $rekete = "UPDATE elementcommercial SET photo ='" . $_POST['photobd'] . "' WHERE codeunique = '" . $codeunique . "'";
//                $result = Functions::commit_sql($rekete, "");                Functions::afficheBoiteMsg($rekete);        // echo 'Merci '.$rekete; 
//            if ($result) {
//                $rf = personne::ajoutReketeSynchro($rekete);
//            } else {
//                $rf = '0';
//            }
}

}


           $_SESSION['idenreg'] = $codeunique;
             $_SESSION["config"] = (isset($_SESSION["ret"]))?$_SESSION["ret"]:'';
            ?>
            <script>
                document.location.href = "../index.php";
            </script>
            <?php

?>
