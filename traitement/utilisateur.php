<?php
//Declaration des fichiers à inclure
if (!isset($_SESSION)) {
    session_start();
}
include_once("../config/connect.php"); // Fichier de connexion
include_once("./includeclass.php");  // Fichier de classes
// Cas de l'ajout d'un utilisateur
if (isset($_POST['action']) && $_POST['action'] == 'addUtilisateur') {

    // Verification des mots de passes
    if (utilisateur::confirmpass1($_POST['motdepasse'], $_POST['motdepasse1']) == true) {// Si cest bon
        $S = new utilisateur("");
        $S->setSexe($_POST['sexe']);
        $S->setNom($_POST['nom']);
        $S->setPrenom($_POST['prenom']);
        $S->setMatricule($_POST['matricule']);
        $format = "Y-m-d";
        $S->setDatedenaissance(Functions::renvoiDate($_POST['datedenaissance'], $format));
        $S->setEmail($_POST['email']);
        $S->setTelephone($_POST['telephone']);
        $S->setLogin($_POST['login']);
        $S->setMotdepasse($_POST['motdepasse']);
        $S->setIdstructure($_POST['idstructure']);


        $imag = "";
        switch ($_POST['sexe']) {
            case 'Homme':
                $imag = "user1.jpg";
                break;
            case 'Femme':
                $imag = "femme.jpg";
                break;
        }

        //Traitement de la photo
        // Testons si le fichier n'est pas trop gros

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            // Testons si le fichier n'est pas trop gros
            if ($_FILES['image']['size'] <= 8000000) {
//             Testons si l'extension est autorisée
                $infosfichier = pathinfo($_FILES['image']['name']);
                $extension = $infosfichier['extension']; // on recupère l'extension du fichier
                $basename = $infosfichier['basename']; // on recupère le nom du fichier avec l'extension
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png'); //Functions::afficheBoiteMsg("Merci ".$basename);
                if (in_array($extension, $extensions_autorisees)) {
                    // On peut valider le fichier et le stocker définitivement
//                    $nomphoto = str_replace(" ", "_", $_POST['nom'] . "_" . $_POST['prenom']);
                    $msg = "";
                    if (!$S->verifdoublon()) {
                        if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $basename)) {
//                    if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . utf8_decode($nomphoto) . '.' . $extension)) {
                            $S->setPhoto($basename);
                        } else {
                            $savefile = 1;
                            $msg = "L'image n'a pas pu être uploadé";
//                        echo '3'; // la photo n'a pas pu etre uploadé
                        }
                    } else {
                        $msg = "Le login existe déjà";
//                    echo '2'; // le nom du produit existe déja
                    }
                } else {
                    $savefile = 2;
                    $msg = "L'extension du fichier n'est pa pris en charge";
                    //    echo '4'; // l'extension du fichier n'est pa pris en charge
                }
            } else {
                $savefile = 3;
                $msg = "La taille de l'image est trop élevée (> 8Mo)";
//            echo '5'; // La taille de la photo est trop élevée (> 8Mo)
            }
        } else {
            $savefile = 4;
//        $msg = "Erreur lors du chargement de la photo"; Champ image facultatif
            $msg = "";
            $S->setPhoto($imag);
//        echo '6'; // Erreur lors du chargement de la photo
        }

        if ($msg == "") {
            $result = $S->ajoututilisateur();        //Functions::afficheBoiteMsg($result);
            ?>
            <script>
            //            alert('salut');
                document.location.href = "../index.php?config=utilisateur";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("<?php echo $msg; ?>");
                document.location.href = "../index.php?config=addutilisateur";
            </script>
            <?php
        }
    } else {
        
    }
}


// Cas de la modification d'un agent

if (isset($_POST['action']) && $_POST['action'] == 'editUtilisateur') {
//    Functions::afficheBoiteMsg("Merci ".$_POST['matricule']);
    if ($_POST['config'] == 'moncompte') {
        $id = $_SESSION['user']['codeunique'];
    } else {
        $id = $_SESSION['idenreg'];
    }
    $S = new utilisateur($id);
    $S->setSexe($_POST['sexe']);
    $S->setNom($_POST['nom']);
    $S->setPrenom($_POST['prenom']);
    $S->setMatricule($_POST['matricule']);
    $format = "Y-m-d";
    $S->setDatedenaissance(Functions::renvoiDate($_POST['datedenaissance'], $format));
    $S->setEmail($_POST['email']);
    $S->setTelephone($_POST['telephone']);
    $S->setLogin($_POST['login']);
    if ($_POST['config'] != 'moncompte') {
        $S->setIdstructure($_POST['idstructure']);
    } else {
        $id = $_SESSION["user"]['id'];
        $user = new utilisateur($id);
        $idStr = $user->getIdstructure();
        $S->setIdstructure($idStr);
    }
    $imag = "";
    switch ($_POST['sexe']) {
        case 'Homme':
            $imag = "user1.jpg";
            break;
        case 'Femme':
            $imag = "femme.jpg";
            break;
    }
    if (($S->getPhoto() != "user1.jpg") && ($S->getPhoto() != "femme.jpg") && ($S->getPhoto() != "") && ($S->getPhoto() != NULL))
        $imag = $S->getPhoto();

    //Traitement de la photo         


    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Testons si le fichier n'est pas trop gros
        if ($_FILES['image']['size'] <= 8000000) {
//             Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['image']['name']);
            $extension = $infosfichier['extension']; // on recupère l'extension du fichier
            $basename = $infosfichier['basename']; // on recupère le nom du fichier avec l'extension
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');   //Functions::afficheBoiteMsg($basename);
            if (in_array($extension, $extensions_autorisees)) {
                // On peut valider le fichier et le stocker définitivement
                $nomphoto = str_replace(" ", "_", $_POST['nom'] . "_" . $_POST['prenom']);
                $msg = "";
                if (!$S->verifdoublonmod()) {
                    if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $basename)) {
//                    if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . utf8_decode($nomphoto) . '.' . $extension)) {
                        $S->setPhoto($basename);
                    } else {
                        $savefile = 1;
                        $msg = "L'image n'a pas pu être uploadé";
//                        echo '3'; // la photo n'a pas pu etre uploadé
                    }
                } else {
                    $msg = "Le login existe déjà";
//                    echo '2'; // le nom du produit existe déja
                }
            } else {
                $savefile = 2;
                $msg = "L'extension du fichier n'est pa pris en charge";
                //    echo '4'; // l'extension du fichier n'est pa pris en charge
            }
        } else {
            $savefile = 3;
            $msg = "La taille de l'image est trop élevée (> 8Mo)";
//            echo '5'; // La taille de la photo est trop élevée (> 8Mo)
        }
    } else {
        $savefile = 4;
//        $msg = "Erreur lors du chargement de la photo"; Champ image facultatif
        $msg = "";
        $S->setPhoto($imag);
//        echo '6'; // Erreur lors du chargement de la photo
    }

    if ($msg == "") {
        $result = $S->modifutilisateur();
        $config = $_POST['config'];
        //Functions::afficheBoiteMsg($result);
        ?>
        <script>
            //alert(conf);
            var conf = "<?php echo $config; ?>";

            if (conf == "editUtilisateur") {
                document.location.href = "../index.php?config=utilisateur";
            }
            if (conf == "moncompte") {
                document.location.href = "../index.php?config=moncompte";
            }
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("<?php echo $msg; ?>");
            document.location.href = "../index.php?config=editutilisateur";
        </script>
        <?php
    }
}


if (isset($_POST['action']) && $_POST['action'] == 'editPassword') {
    $id = $_SESSION['user']['codeunique'];
    $S = new utilisateur($id);
    $result = $S->changepassword($_POST['oldPassword'], $_POST['newPassword'], $_POST['confirmPass']);
    $msgPassword = "";


    switch ($result) {
        case'0':
            $msgPassword = 'Erreur de connexion!';
            ?>
            <script>
                document.location.href = "../index.php?config=password";
                //$("#info", window.parent.document).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Erreur de connexion. </div>').fadeIn(1000);
            </script>
            <?php
            break;

        case'1':
            $msgPassword = 'Mot de passe changé avec succès!';
           $_SESSION['idenreg'] = 0;
            $_SESSION["config"] = "Accueil";
            ?>
            <script>
               document.location.href = "../index.php";
            </script>
            <?php
            break;

        case'2':
            $msgPassword = 'les nouveaux mot de passe ne concordent pas!';
            ?>
            <script>
                document.location.href = "../index.php?config=password";
                //$("#info", window.parent.document).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Les nouveaux mot de passe ne concordent pas. </div>').fadeIn(1000);
            </script>
            <?php
            break;

        case'3':
            $msgPassword = 'Le mot de passe actuel est incorrecte!';
            ?>
            <script>
                document.location.href = "../index.php?config=password";
                //$("#info", window.parent.document).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le mot de passe actuel est incorrecte. </div>').fadeIn(1000);
            </script>
            <?php
            break;
    }
    $_SESSION['msgPassword'] = $msgPassword;
    $_SESSION['resultPassword'] = $result;
}
?>
