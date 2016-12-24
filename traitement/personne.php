<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($_SESSION)) {
    session_start();
}
include_once("../config/connect.php"); // Fichier de connexion
include_once("./includeclass.php");  // Fichier de classes
$id = "";



if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$personne = new personne($id);
$personne->setMatricule($_POST['matricule']);
$personne->setNom($_POST['nom']);
$personne->setPrenom($_POST['prenom']);

if (isset($_POST['nomjeunefille'])) {
    $personne->setNomjeunefille($_POST['nomjeunefille']);
}


$personne->setIdtypepersonne($_POST['idtypepersonne']);
$personne->setTelephone($_POST['telephone']);
$personne->setEmail($_POST['email']);
$personne->setIdsexe($_POST['idsexe']);
$personne->setIdsituationmatri($_POST['idsituationmatri']);
$personne->setDatenaissance(Functions::renvoiDate($_POST['datenaissance'], "Y-m-d"));
$personne->setLieunaissance($_POST['lieunaissance']);
$personne->setAdresse($_POST['adresse']);
$personne->setIdfonction($_POST['idfonction']);
$personne->setDateembauche(Functions::renvoiDate($_POST['dateembauche'], "Y-m-d"));
$personne->setDateprobdepart(Functions::renvoiDate($_POST['dateprobdepart'], "Y-m-d"));
$personne->setNumcnss($_POST['numcnss']);
$personne->setIdtitreperscontact($_POST['idtitreperscontact']);
$personne->setNomperscontact($_POST['nomperscontact']);
$personne->setPrenomperscontact($_POST['prenomperscontact']);
$personne->setTelperscontact($_POST['telperscontact']); //fraisformation
$personne->setObservations($_POST['observations']); 
if(isset($_POST['fraisformation'])) $personne->setFraisformation(str_replace (' ', '', $_POST['fraisformation'])); 
$imag = "";
//$fr = $_POST['fraisformation'];
//Functions::afficheBoiteMsg($_POST['fraisformation']);
switch ($_POST['idsexe']) {
    case '2':
        $imag = "user.jpg";
        break;
    case '1':
        $imag = "femme.jpg";
        break;
}

if (($personne->getPhoto()!="user.jpg" && $personne->getPhoto()!="femme.jpg") && $personne->getPhoto()!="" && $personne->getPhoto()!=NULL ){
    $imag = $personne->getPhoto();
}
//traitement de la photo
$msg = "";
if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

    if ($_FILES['photo']['size'] <= 8000000) {

        $infosfichier = pathinfo($_FILES['photo']['name']);
        $extension = $infosfichier['extension'];
        $basename = $infosfichier['basename'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG');
        if (in_array($extension, $extensions_autorisees)) {

            if (move_uploaded_file($_FILES['photo']['tmp_name'], '../images/photo/' . $basename)) {
                $personne->setPhoto($basename);
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
//    functions::afficheBoiteMsg("la dedans40");
    $savefile = 4;
//    $msg = "Une erreur est survenue !!!";
    $personne->setPhoto($imag);
}

if ($id == "") {
    $idenreg = 0;
    $redirect = "addpersonne";
} else {
    $redirect = "editpersonne";
    $idenreg = $id;
}


if ($msg == "") {
    $result = 0;
    if ($id == "") {
        $result = $personne->ajoutPersonne(); 
        if($result=='1') parametre::actualiseMatriculeencours (1);
    } else {
        $result = $personne->modifPersonne();
    }

    
    switch ($result) {
        case '0':
            $_SESSION['idenreg'] = 0;
            $_SESSION["config"] = $redirect;
            ?>
            <script>
                //$("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                // JPrincipal.afficheContenu('<?php echo $id; ?>', '<?php echo $redirect; ?>', '', '');
                document.location.href = "../index.php";
            </script>
            <?php
            break;

        case '1':
            $_SESSION['idenreg'] = 0;
            $_SESSION["config"] = $_POST['retour']; //"personne";
            ?>
            <script>
               
                // $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne a été enregistrée avec succès. </div>').fadeIn(1000);
                //JPrincipal.afficheContenu(0, '<?php echo $_POST['retour']; ?>', '', '');
                document.location.href = "../index.php";
            </script>
            <?php
            break;

        case '2':
            $_SESSION['idenreg'] = $idenreg;
            $_SESSION["config"] = $redirect;
            ?>
            <script>
                //                $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                document.location.href = "../index.php";
            </script>
            <?php
            break;
    }
} else {
    $_SESSION["config"] = $redirect;
    ?>
    <script>
        alert("<?php echo $msg; ?>");
        document.location.href = "../index.php";
    </script>
    <?php
}
?>
