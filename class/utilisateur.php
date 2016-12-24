<?php

class utilisateur {

    var $id;
    var $codeunique;
    var $idpersonne;
    var $login;
    var $motdepasse;
    var $idcreateur;

    public function __construct($codeunique) {

        $rekete = "SELECT * FROM utilisateur WHERE  codeunique= '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result != false) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->idpersonne = $list["idpersonne"];
            $this->login = $list["login"];
            $this->motdepasse = $list["motdepasse"];
            $this->idcreateur = $list["idcreateur"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getCodeunique() {
        return $this->codeunique;
    }

    public function setCodeunique($codeunique) {
        $this->codeunique = $codeunique;
    }

    public function getIdpersonne() {
        return $this->idpersonne;
    }

    public function setIdpersonne($idpersonne) {
        $this->idpersonne = $idpersonne;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getMotdepasse() {
        return $this->motdepasse;
    }

    public function setMotdepasse($motdepasse) {
        $this->motdepasse = $motdepasse;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }
    public static function idpersParUti($codeunique){
        $u = new utilisateur($codeunique);
        return $u->getIdpersonne();
    }

    public function verifdoublon() {
        $rekete = "SELECT * FROM utilisateur WHERE login='" . $this->login . "' OR idpersonne ='" . $this->idpersonne . "'";
        $result = Functions::commit_sql($rekete, "");
        if (Functions::is_void($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoututilisateur() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'utilisateur');
            $rekete = "INSERT INTO utilisateur(codeunique, login, motdepasse, idpersonne,idcreateur) ";
            $rekete .= "VALUES('" . $this->codeunique . "','" . $this->login . "','" . Functions::crypter($this->motdepasse) . "' ";
            $rekete .= ",'" . $this->idpersonne . "','" . $this->idcreateur . "')";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                return principale::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function verifdoublonmod() {
        $rekete = "SELECT * FROM utilisateur WHERE (login='" . $this->login . "' OR idpersonne ='" . $this->idpersonne . "') AND codeunique <> '" . $this->codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if (Functions::is_void($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function modifutilisateur() { 
        if (!$this->verifdoublonmod()) {
            $rekete = "UPDATE utilisateur SET login = '" . $this->login . "', idpersonne = '" . $this->idpersonne . "', idcreateur = '" . $_SESSION['user']['codeunique'] . "' WHERE codeunique = '" . $this->codeunique . "'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                return principale::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function supputilisateur() {
        $rekete = "DELETE FROM utilisateur WHERE codeunique = '" . $this->codeunique . "'";
        //echo $rekete;
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public function verifpass($pass) {
        $ancpass = $this->motdepasse; // Mot de passe crypté de l'utilisateur se trouvant dans la base        
        $oldpass = Functions::crypter($pass); // mot de passe tapé par l'utilisateur (que nous cryptons)        
        if ($ancpass == $oldpass) { // on vérifie si les deux concordent
            return true;
        } else {
            return false;
        }
    }

    public function confirmpass($pass1, $pass2) {
        if ($pass1 == $pass2)
            return true;
        else
            return false;
    }

    public function resetpassword($pass) {       // Functions::afficheBoiteMsg($pass);
        $rekete = "UPDATE utilisateur set motdepasse = ? where codeunique= ? ";
        $param = array(Functions::crypter($pass), $this->codeunique);
        $result = Functions::commit_sql($rekete, $param);
        if ($result) {
            return '1';
        } else {
            return '0';
        }
    }

    public function changepassword($pass, $pass1, $pass2) {
        if ($this->verifpass($pass)) {
            if ($this->confirmpass($pass1, $pass2)) {
                $rekete = "UPDATE utilisateur set motdepasse= ? where codeunique= ? ";
                $param = array(Functions::crypter($pass1), $this->codeunique);
                $result = Functions::commit_sql($rekete, $param);
                if ($result) {
                    return '1'; // Mot de passe changé avec succès
                } else {
                    return '0'; // erreur de connexion
                }
            } else {
                return '2'; // les nouveaux mot de passe ne concordent pas
            }
        } else {
            return '3'; // Mot de passe actuel incorrecte
        }
    }

    public static function idProfilParUtilisateur($idutilisateur) {
        $rekete = "SELECT idProfil FROM utilisateurprofil WHERE idUtilisateur ='" . $idutilisateur . "'";
        $result = Functions::commit_sql($rekete, "");
        $idretour = 0;
        if ($result) {
            $list = $result->fetch();
            if ($list != '')
                $idretour = $list['idProfil'];
        }
        return $idretour;
    }

    public static function donneeUtilisateur($result) {
        $affich = array();

        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list["codeunique"];
                $affich[$i]["login"] = $list["login"];
                $affich[$i]["idcreateur"] = $list["idcreateur"];
                $affich[$i]["idpersonne"] = $list["idpersonne"];
                $p = new personne($list["idpersonne"]);
                $affich[$i]["nom"] = $p->getNom();
                $affich[$i]["prenom"] = $p->getPrenom();
                $affich[$i]["personne"] = $p->getNomPrenom();
                $affich[$i]["activate"] = !$p->getDesactiver();
                $affich[$i]["photo"] = $p->getPhoto();
                $i++;
            }
        }
        return $affich;
    }

    public function getAllutilisateurInfos() {
        $rekete = "SELECT * FROM utilisateur ";
        $result = Functions::commit_sql($rekete, "");
        $affich = utilisateur::donneeUtilisateur($result);
        return $affich;
    }

    public function getAllutilisateurDjaProfilInfos() {
        $rekete = "SELECT * FROM utilisateur where utilisateur.id not in (SELECT idutilisateur from utilisateurprofil)";
        $result = Functions::commit_sql($rekete, "");
        $affich = utilisateur::donneeUtilisateur($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <div id="zoneresetPwd">

        </div>
        <div id="zonedesact" style="display: none">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment désactiver cet utilisateur?
            </p>
        </div>
        <div id="zoneact" style="display: none">
            <p>
                <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment activer cet utilisateur?
            </p>

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'moncompte':
                $titre = "Mon compte";
                break;

            case 'password':
                $titre = "Changer mon mot de passe";
                break;

            case 'utilisateur':
                $titre = "Liste des utilisateurs";
                break;

            case 'addutilisateur':
                $titre = "Ajouter un utilisateur";
                break;

            case 'editutilisateur':
                $titre = "Modifier un utilisateur";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = utilisateur::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'moncompte'://compte utilisateur
                utilisateur::formCompte($retour);
                break;

            case 'password'://changer mon password
                utilisateur::formPassWord($retour);
                break;

            case 'utilisateur':
                $utilisateur = new utilisateur("");
                $donnee = $utilisateur->getAllutilisateurInfos();
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addutilisateur', '', '<?php echo $retour; ?>');" id="addutilisateur" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                  <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printutilisateur" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportutilisateur" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    utilisateur::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;

            case 'addutilisateur':
                $retour = "utilisateur";
                utilisateur::formMaj($retour,"");
                break;

            case 'editutilisateur':
                $retour = "utilisateur";
                $id = "";
                if (isset($_SESSION["idenreg"]))
                    $id = $_SESSION["idenreg"];
                utilisateur::formMaj($retour,$id);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun utilisateur n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered " data-spy="scroll" width="100%">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>Noms & Prénoms</strong></th>                                         
                        <th><strong>Login</strong></th>                                                                               
                        <th style="width: 180px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                        

                            <td><?php echo $v['personne'] ?></td>                                                                                                  
                            <td><?php echo $v['login'] ?></td>                                                                                                                                                
                            <td>
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editutilisateur', '', '');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>
                                <a href="#" class="btn btn-small btn-danger" onclick="JUtilisateurs.suppUtilisateur('<?php echo $v['codeunique'] ?>');" style="margin-right: 10px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
                                <a href="#" class="btn btn-small " onclick="JPrincipal.ajoutFormModal('reinitpw', '<?php echo $v['codeunique'] ?>', 400, 'Réinitialiser le mot de passe');"  style="margin-right: 10px;" title="Réinitialiser le mot de passe"><img src="images/reinitpwd.png" style="width: 20px; height:17px" /></a>
                                <a href="#" class="btn btn-small " onclick="JPrincipal.ajoutFormModal('majProfil', '<?php echo $v['codeunique'] ?>', 500, 'Attribuer un profil');"  style="margin-right: 10px;" title="Attribuer un profil"><i class=" icon-user"></i></a>
                                <?php
                                if ($v['activate'] == 0) {
                                    ?>
<!--                                    <a href="#" onclick="JUtilisateurs.act('<?php echo $v['codeunique'] ?>');" style="margin-right: 10px;">
                                        <img src="images/Desactivate.jpg" alt="Activer l'utilisateur" title="Activer l'utilisateur" style="width: 16px; height: 16px"/>
                                    </a>-->
                                    <?php
                                } else {
                                    ?>
<!--                                    <a href="#" onclick="JUtilisateurs.desact('<?php echo $v['codeunique'] ?>');" style="margin-right: 10px;">
                                        <img src="images/Activate.jpg" style="width: 16px; height: 16px" alt="Désactiver l'utilisateur" title="Désactiver l'utilisateur"/>
                                    </a>-->
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    endforeach;
                    unset($donnee);
                    ?>
                </tbody>
            </table>
            <input type="hidden" id="nbreparam" value="<?php echo $i; ?>" />

            <?php
        }
    }

    static function formMaj($retour, $codeunique = '') {
        $idpers = "";
        $login = "";
        $motdepasse = "";
        if ($codeunique != '') {
            $S = new utilisateur($codeunique);
            $idpers = $S->getIdpersonne();
            $login = $S->getLogin();
            $motdepasse = $S->getMotdepasse();
        }
        ?> 
        <div id="info"></div>
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="alltypeoperationfinanciere" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddedit" id="formaddedit" action="" >                    
            <div class="well well-large">               
                <div class="control-group">
                    <label class="control-label" for="login"><strong>Infos personnelles (*)</strong></label>
                    <div class="controls">                       
                <?php
                $onchange= "";
                $rek = "SELECT codeunique, CONCAT(nom,' ',prenom)AS nomprenom FROM personne WHERE desactiver = 0";
                echo Functions::LoadCombo($rek, "codeunique", "nomprenom", 'idpersonne', "Personne", "500", $onchange, $idpers); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for="login"><strong>Login (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:220px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $login; ?>" />                                                        
                    </div>
                </div>
                <?php if ($codeunique == '') { ?>

                <div class="control-group ">
                    <label class="control-label" for="motdepasse"><strong>Mot de passe</strong></label>
                    <div class="controls">
                        <input type="password" style="height:30px; width:220px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value="<?php echo $motdepasse; ?>" />                                                        
                    </div>
                </div>
                    <div class="control-group ">
                        <label class="control-label" for="motdepasse1"><strong>Confirmer le mot de passe</strong></label>
                        <div class="controls">
                            <input type="password" style="height:30px; width:220px;" name="motdepasse1" id="motdepasse1" class="text ui-widget-content ui-corner-all" value="" />                                                        
                        </div>
                    </div>
                <?php } ?>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JRubriques.valider('<?php echo $codeunique; ?>', 'validerUtilisateur', '<?php echo $retour; ?>');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>                        
        <?php
    }

    static function addutilisateur() {

// Verification des mots de passes
        if (utilisateur::confirmpass1($_GET['motdepasse'], $_GET['motdepasse1']) == true) {// Si cest bon
            $S = new utilisateur("");
            $S->setSexe($_GET['sexe']);
            $S->setNom($_GET['nom']);
            $S->setPrenom($_GET['prenom']);
            $S->setCodeunique($_GET['codeunique']);
            $format = "Y-m-d";
            $S->setDatedenaissance(Functions::renvoiDate($_GET['datedenaissance'], $format));
            $S->setEmail($_GET['email']);
            $S->setTelephone($_GET['idcreateur']);
            $S->setLogin($_GET['login']);
            $S->setMotdepasse($_GET['motdepasse']);
            $S->setIdpersonne($_GET['idpersonne']);
            $fonction = $_GET['fonction'];

            if (empty($fonction)) {
                $S->setAdminpersonne(0);
                $S->setChefapprovisionnement(0);
                $S->setChefmateriel(0);
                $S->setChefmagasin(0);
                $S->setChefauto(0);
            } else {
                foreach ($fonction as $Selectedfonction) {
                    if ($Selectedfonction == 'Administrateur de Structure')
                        $S->setAdminpersonne(1);
                    if ($Selectedfonction == 'Chef Approvisionnement')
                        $S->setChefapprovisionnement(1);
                    if ($Selectedfonction == 'Chef Matériels')
                        $S->setChefmateriel(1);
                    if ($Selectedfonction == 'Chef Magasin')
                        $S->setChefmagasin(1);
                    if ($Selectedfonction == 'Chef Auto')
                        $S->setChefauto(1);
                }
            }

            $result = $S->ajoututilisateur();
            switch ($result) {
                case '0': // Erreur d'enregistrement dans la base
                    ?>
                    <script>
                                $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                    </script>
                    <?php
                    break;

                case '1': // Enregistrement dans la base effectué
                    ?>
                    <script>
                        JUtilisateurs.effacer();
                        $("#info", window.parent.document).html('<div class="alert alert-succes"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent a été enregistrée avec succès. </div>').fadeIn(1000);
                        document.location.href = "index.php?config=utilisateur";
                    </script>
                    <?php
                    break;

                case '2':
                    ?>
                    <script>
                        $("#info", window.parent.document).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent que vous tentez d\'enregistrer existe déjà. </div>').fadeIn(1000);
                    </script>
                    <?php
                    break;
            }
        } else { // Si ce nest pas bon
            ?>
            <script>
                $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Mot de passes incorrectes </div>').fadeIn(1000);
            </script>
            <?php
        }
    }

    static function editutilisateur() {

        $S = new utilisateur($_GET['id']);
        $S->setSexe($_GET['sexe']);
        $S->setNom($_GET['nom']);
        $S->setPrenom($_GET['prenom']);
        $S->setCodeunique($_GET['codeunique']);
        $format = "Y-m-d";
        $S->setDatedenaissance(Functions::renvoiDate($_GET['datedenaissance'], $format));
        $S->setEmail($_GET['email']);
        $S->setTelephone($_GET['idcreateur']);
        $S->setLogin($_GET['login']);
//            $S->setMotdepasse($_GET['motdepasse']);
        $S->setIdpersonne($_GET['idpersonne']);
        $fonction = $_GET['fonction'];

        if (empty($fonction)) {
            $S->setAdminpersonne(0);
            $S->setChefapprovisionnement(0);
            $S->setChefmateriel(0);
            $S->setChefmagasin(0);
            $S->setChefauto(0);
        } else {
            foreach ($fonction as $Selectedfonction) {
                if ($Selectedfonction == 'Administrateur de Structure')
                    $S->setAdminpersonne(1);
                if ($Selectedfonction == 'Chef Approvisionnement')
                    $S->setChefapprovisionnement(1);
                if ($Selectedfonction == 'Chef Matériels')
                    $S->setChefmateriel(1);
                if ($Selectedfonction == 'Chef Magasin')
                    $S->setChefmagasin(1);
                if ($Selectedfonction == 'Chef Auto')
                    $S->setChefauto(1);
            }
        }

        $result = $S->modifutilisateur();
        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent n\'a pas été modifié : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    JUtilisateurs.effacer();
                    $("#info", window.parent.document).html('<div class="alert alert-succes"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent a été modifié avec succès. </div>').fadeIn(1000);
                    document.location.href = "index.php?config=utilisateur";
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'agent que vous tentez de modifié existe déjà. </div>').fadeIn(1000);
                </script>
                <?php
                break;
        }
    }

    static function formCompte($retour) {
        $id = $_SESSION['user']['codeunique'];
        $utilisateur = new utilisateur($id);
        ?>      
        <div id="info"></div>

        <form class="form-horizontal" method="post" name="formeditUtilisateur" id="formeditUtilisateur" action="traitement/utilisateur.php" enctype="multipart/form-data" >
            <!--<div class="well well-large">-->

            <div class="control-group pull-left">
                <label class="control-label" for="sexe"><strong>Civilité (*)</strong></label>


                <div class="controls" >
                    <select name='sexe' style='height:30px;width:100px;' type='text' id='sexe' class="selectpicker text ui-corner-all" >
                        <?php
                        $choice1 = "";
                        if ($utilisateur->getSexe() == 'Homme') {
                            $choice1 = 'selected=selected';
                        }
                        $choice2 = "";
                        if ($utilisateur->getSexe() == 'Femme') {
                            $choice2 = 'selected=selected';
                        }
                        ?>
                        <option value="Homme" <?php echo $choice1 ?> >Homme</option>
                        <option value="Femme" <?php echo $choice2 ?> >Femme</option>
                    </select>                       
                </div>
            </div>

            <div class="fileupload fileupload-new pull-right" data-provides="fileupload">
                <div class="fileupload-preview thumbnail" style="width:200px; height:200px;">
                    <img src="images/<?php echo $utilisateur->getPhoto() ?>" />
                </div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Choisir photo</span>
                        <span class="fileupload-exists">Changer</span><input type="file" name="image" id="image" /></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                </div>
            </div>                          
            <div class="control-group pull-left">
                <label class="control-label" for="nom"><strong>Nom (*)</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getNom(); ?>" />                   
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="prenom"><strong>Prénoms (*)</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getPrenom(); ?>" />                                      
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="codeunique"><strong>Codeunique</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="codeunique" id="codeunique" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getCodeunique(); ?>" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="datedenaissance"><strong>Date de naissance</strong></label>
                <div class="controls">
                    <input type="text" data-date-format="dd-mm-yyyy" style="height:30px; width:220px;" name="datedenaissance" id="datedenaissance" class="text ui-widget-content ui-corner-all" value="<?php echo Functions::renvoiDate($utilisateur->getDatedenaissance(), "d-m-Y"); ?>" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="email"><strong>Email</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getEmail(); ?>" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="idcreateur"><strong>Téléphone</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="idcreateur" id="idcreateur" class="text ui-widget-content ui-corner-all"  value="<?php echo $utilisateur->getTelephone(); ?>" />                                                        
        <!--                        <input type="text" data-format="229dddddddd" style="height:30px; width:220px;" name="idcreateur" id="idcreateur" class="text ui-widget-content ui-corner-all input-medium bfh-phone"  value="" />                                                        -->
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="login"><strong>Login</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:220px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getLogin(); ?>" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">                
                <div class="controls">                  
                    <div class="control-group pull-left">
                        <label class="control-label"></label>
                        <div class="controls">   
        <!--                            <input type="reset" class="btn btn-small btn-success" value="Annuler"/>-->
                            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', 'moncompte')" id="Annuler" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                            <input type="hidden" name="action" id="action" value="editUtilisateur" size="32" /> 
                            <input type="hidden" name="config" id="config" value="moncompte" size="32" /> 
                            <a href="#" id="Enregistrer" onclick="JUtilisateurs.editUtilisateur();" class="btn btn-small btn-info pull-left"><i class="icon-ok"></i> Enregistrer</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--</div>-->            
        </form>
        <?php
    }

    static function formPassWord() {
        $id = $_SESSION['user']['codeunique'];
        $utilisateur = new utilisateur($id);
        ?>      
        <div id="info">
            <?php
            if (isset($_SESSION['msgPassword'])) {
                if ($_SESSION['resultPassword'] == 1) {
                    ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Info !</strong> <?php echo $_SESSION['msgPassword']; ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>Info !</strong> <?php echo $_SESSION['msgPassword']; ?>
                    </div>
                    <?php
                }
                unset($_SESSION['msgPassword']);
                unset($_SESSION['resultPassword']);
            }
            ?>
        </div>

        <form class="form-horizontal" method="post" name="formPassword" id="formPassword" action="traitement/utilisateur.php" enctype="multipart/form-data" >

            <div class="control-group pull-left">
                <label class="control-label" for="sexe"><strong>Civilité</strong></label>

                <div class="controls" >
                        <?php
                        $p = new personne($utilisateur->getIdpersonne());       
                          echo Functions::LoadCombo("SELECT * FROM sexe", "id", "libelle", "idsexe", "Choisir le sexe", "245","",$p->getIdsexe());

                        ?>
                                       
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="nom"><strong>Nom</strong></label>
                <div class="controls">
                    <input type="text" readonly="true" style="height:30px; width:220px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $p->getNom(); ?>" />                   
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="prenom"><strong>Prénoms</strong></label>
                <div class="controls">
                    <input type="text" readonly="true" style="height:30px; width:220px;" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $p->getPrenom(); ?>" />                                      
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="codeunique"><strong>Codeunique</strong></label>
                <div class="controls">
                    <input type="text" readonly="true" style="height:30px; width:220px;" name="codeunique" id="codeunique" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getCodeunique(); ?>" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">
                <label class="control-label" for="login"><strong>Login</strong></label>
                <div class="controls">
                    <input type="text" readonly="true" style="height:30px; width:220px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $utilisateur->getLogin(); ?>" />                                                        
                </div>
            </div>
            <div class="control-group pull-left">
                <label class="control-label" for="oldPassword"><strong>Mot de passe actuel</strong></label>
                <div class="controls">
                    <input type="password" style="height:30px; width:220px;" name="oldPassword" id="oldPassword" class="text ui-widget-content ui-corner-all" value="" />                                                        
                </div>
            </div>
            <div class="control-group pull-left">
                <label class="control-label" for="newPassword"><strong>Nouveau mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:30px; width:220px;" name="newPassword" id="newPassword" class="text ui-widget-content ui-corner-all" value="" />                                                        
                </div>
            </div>
            <div class="control-group pull-left">
                <label class="control-label" for="confirmPass"><strong>Confirmer mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:30px; width:220px;" name="confirmPass" id="confirmPass" class="text ui-widget-content ui-corner-all" value="" />                                                        
                </div>
            </div>

            <div class="control-group pull-left">                
                <div class="controls">                  
                    <div class="control-group pull-left">
                        <label class="control-label"></label>
                        <div class="controls pull-left">             
                            <input type="hidden" name="action" id="action" value="editPassword" size="32" /> 
                            <input type="hidden" name="config" id="config" value="password" size="32" /> 
                            <input type="button" onclick="JUtilisateurs.checkPassword();" class="btn btn-small btn-info pull-left" value="Changer"/>
                            <a href="index.php" id="Annuler" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--</div>-->            
        </form>
        <?php
    }

    function chargerComboProfil($login) {
        $sql = "SELECT profil.* FROM profil, utilisateurprofil,utilisateur
                                 WHERE utilisateurprofil.idProfil=profil.id AND
                                 utilisateurprofil.idUtilisateur=utilisateur.id AND
                                  login=" . $login . "";


        $connect["rep"] = false;
        $connect["msg"] = "";
        if (isset($_POST["submitConnect"]))
            include_once("commitConnect.php"); //TO treat a submit Action
        ?>
        <div id="log-cont">
            <h4 style="color: white; margin-top: 0px;" >Espace de connexion<br><small style="color: white;"><b>Gestion des Matériels</b></small></h4>
            <form action="" method="post" class="formConnectAdmin form-horizontal" style="margin: 20px">
                <?php
                if ($connect["rep"] == true) {
                    header("Location:index.php");
                } else {
                    echo $connect["msg"];
                }
                ?>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" id="login" name="login" class="span2" id="prependedInput" placeholder="Identifiant" style="width: 230px;" onchange="JProfil.onchangeTxtLogin();" value =" <?php echo $login; ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" id="pass" name="pass" class="span2" id="prependedInput" placeholder="Mot de passe" style="width: 230px;"/>
                    </div>
                </div>

                <div class="control-group" id="divCmb">
                    <div class="input-prepend" >
                        <span class="add-on"><i class="icon-user"></i></span>

                        <?php
                        echo Functions::LoadCombo("SELECT * FROM profil", "id", "libelleprofil", "cmbprofil", "Choisir un profil", "245");
                        ?>        
                    </div>
                </div>

                <div class="control-group pull-right">
                    <input type="reset" value="Annuler" class="btn btn-small"/>
                    <input  type="submit" value="Connecter" name="submitConnect" class="btn btn-small btn-primary" />                        
                </div>   

            </form>
        </div>
        <?php
    }

    public static function idsuperieurHierarchique($idutilisateur) {
        $util = new utilisateur($idutilisateur);
        $struct = new personne($util->getIdStructureUser());
        $idchef = $struct->getIdchefpersonne();
        $idsup = 0;
        if ($idchef != $idutilisateur)
            $idsup = $idchef; else {
            $structMere = new personne($struct->getIdpersonnemere());
            $idsup = $structMere->getIdchefpersonne();
        }
        return $idsup;
    }

    public static function formReinitPw($idutilisateur) {
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formresetPwd" id="formresetPwd">
            <div class="control-group">
                <label class="control-label" for="motdepasse"><strong>Mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:30px; width:170px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value=""/>

                    <input type="hidden" name="idutilisateur"  id="idutilisateur" value="<?php echo $idutilisateur; ?>" size="32" />
                </div>
            </div> 
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">                        
                    <input type="button" onclick="JRubriques.valider('<?php echo $idutilisateur; ?>', 'validerReinitPW', 'utilisateur');" class="btn btn-small btn-success" value="Valider"/>
                </div>
            </div>   
        </form>
        <?php
    }

    public static function formMajProfil($idutilisateur) {        //Functions::afficheBoiteMsg($idutilisateur);
        $uti = new utilisateur($idutilisateur);
        $nomp = personne::nomPrenom($uti->getIdpersonne());
        $idprofil = "";
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formMajProfil" id="formMajProfil">
            <div class="control-group">                
                    <label class="control-label" for="utilisateur"><strong>Utilisateur</strong></label>
                <div class="controls">
                    <label class="control-label"><strong> <?php echo $nomp ?></strong></label>
                    <input type="hidden" name="idutilisateur"  id="idutilisateur" value="<?php echo $idutilisateur; ?>" size="32" />
                </div>
            </div>
            
            <div class="control-group">
                    <label class="control-label" for="profil"><strong>Profil(*)</strong></label>
                    <div class="controls">
                        <?php
                        //$onchange = "";                       
                        echo Functions::LoadCombo("SELECT * FROM profil", "codeunique", "libelleprofil", 'idprofil', "Sélectionnez le profil", "260", "", $idprofil);
                        ?>  
                    </div>
                </div>
            
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">                        
                    <input type="button" onclick="JRubriques.valider('<?php echo $idutilisateur; ?>', 'validerProfilUser', 'utilisateur');" class="btn btn-small btn-success" value="Valider"/>
                </div>
            </div>   
        </form>
        <?php
    }

    public static function validerPW($id, $retour) {
        $uti = new utilisateur($id);
        $pass = $_GET['motdepasse'];
        $rs = $uti->resetpassword($pass);

        switch ($rs) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le mot de passe n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1': //Functions::afficheBoiteMsg($retour);
                ?>
                <script>
                    $("#zonemodal").dialog("close");
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le mot de passe a été enregistré avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;
        }
    }
    
    public static function validerProfiluser($id, $retour) {
        $profil = new userprofil("");
        $profil->setIdProfil($_GET['idprofil']);
        $profil->setIdUtilisateur($id);
        $rs = $profil->ajoutUserProfil();       
        switch ($rs) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le mot de passe n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le mot de passe a été enregistré avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;
        }
    }
    
     public static function valider($id, $retour) {
        $u = new utilisateur($id);
        $u->setIdpersonne($_GET['idpersonne']);
        $u->setLogin($_GET['login']);
        $u->setMotdepasse($_GET['login']);

        $result = 0;       
        if ($id == '') {
            $result = $u->ajoututilisateur();
        } else {
            $result = $u->modifutilisateur();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'utilisateur n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'utilisateur a été enregistré avec succès. </div>').fadeIn(1000).fadeOut(2000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> L\'utilisateur que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>