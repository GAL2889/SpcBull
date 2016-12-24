
<?php
switch ($_GET['action']) {
    case 'getImpressionPDF':
    case 'getExportExcel':
        $orientation = 'p'; //Portrait par défaut
        $borduretableau = 1; //Portrait par défaut
        $fichier = 'print/impression.php';
        $hautdoc = array();
        $basdoc = array();
        $corps = "";

        $conf = $_GET['conf'];
//        Functions::afficheBoiteMsg($conf);
        switch ($conf) {

            case "utilisateur":
                $titre = "Liste des utilisateurs";
                $nomfichier = "Utilisateur"; // Ne pas dépasser 11 caractères au total sinon erreur
                $listtitre = array("Nom Prénom", "Login", "Profil");
                $tabAlign = array("L", "L", "L");
                $listcolonneBD = array("nomprenom", "login", "fonction");
                $listlargeurtitre = array(50, 30, 60); //total 190
                $utilisateur = new utilisateur("");
                $donnee = $utilisateur->getAllutilisateurInfos();
                break;

            case'profil':
                $titre = "Liste des profils";
                $nomfichier = "Profil"; // Ne pas dépasser 11 caractères au total sinon erreur
                $listtitre = array("Libellé");
                $tabAlign = array("l");
                $listcolonneBD = array("libelleprofil");
                $listlargeurtitre = array(60); //total 190
                $profil = new profil("");
                $donnee = $profil->getAllProfilInfos();
                break;

            case "structure":
                $titre = "Liste des structures ";
                $nomfichier = "structures"; // Ne pas dépasser 11 caractères au total sinon erreur
                $listtitre = array("Sigle", "Dénomination", "Type de structure", "Localité", "Chef structure");
                $tabAlign = array("L", "L", "L", "L", "L");
                $listcolonneBD = array("sigle", "denomination", "typestructure", "localite", "chefstructure");
                $listlargeurtitre = array(20, 40, 30, 40, 30); //total 190
                $donnee = structure::getAllStructureInfos();
                break;

            case'rapportfinancier':
                $tab = operationfinanciere::donneeImprimer($conf);
//                $tab = operationfinanciere::donneRapportImprim();
                break;
            case'anneeacademik':
                $tab = anneeacademique::donneeImprimer();
                break;
            case'sourceoperation':
            case'tresorerie':
                $tab = sourceoperation::donneeImprimer($conf);
                break;
            case'presence':
            case'detailsPresence':
            case'synthesepresence':
                $tab = presence::donneeImprimer($conf);
                break;
            case'punition':
                $tab = punition::donneeImprimer($conf);
                break;
            case'rubriques':
                $tab = rubriques::donneeImprimer($conf);
                break;
            case 'opentreeB':
            case 'opentreeC':
            case 'validePF':
            case 'opsortieB':
            case 'opsortieC':
                $tab = operationfinanciere::donneeImprimer($conf);
                break;
            case'personne':
                $tab = personne::donneeImprimer($conf);
                break;
            case 'prevision':
                $tab = previsiontache::donneeImprimer($conf);
                break;
            case 'objectif':
            case 'objectifDetailPrint':
            case 'detailsObjectif':
                $tab = objectifsjr::donneeImprimer($conf);
                break;
            case 'programPrint':
            case 'detailsProgram':
                $tab = programme::donneeImprimer($conf);
                break;
            case 'planning':
            case 'suiviTech':
                $tab = planning::donneeImprimer($conf);
                break;
            case 'notes':
                $tab = notes::donneeImprimer($conf);
                break;
            
            case 'syntheseTech':
                $tab = programme::donneeImprimerSynthTechs($conf);
                break;
            case 'syntheseIndiv':
                $tab = programme::donneeImprimerSynthIndiv($conf);
                break;
            case 'suivitache':
                $tab = suivitache::donneeImprimer($conf);
                break;
            case 'rapports':
                $tab = rapports::donneeImprimer($conf);
                break;
            case 'LeRapport':
                $tab = rapports::ImprimerRapport($conf);
                break;
            case 'contrat':
                $tab = contrat::donneeImprimer($conf);
                break;
            case 'detailscontrat':
                $tab = echeancier::donneeImprimer($conf);
                break;
        }

        parametre::initImpression($tab[0], $tab[1], $tab[2], $tab[3], $tab[4], $tab[5], $tab[6], $tab[7], $tab[8], $tab[9], $tab[10], $tab[11]);
        if ($_GET['action'] == 'getImpressionPDF') {            //echo 'Merci Seigneur';
            ?>
            <SCRIPT language="javascript">
                window.open('<?php echo $fichier; ?>');
            </script> 
            <?php
        }
        if ($_GET['action'] == 'getExportExcel') {
            ?>
            <SCRIPT language="javascript">
                window.open('excel/exportTable.php');
            </script> 
            <?php
        }
        break;

//================================================================================================

    case 'formVoirDetailsNotif':
        $idnotification = $_GET['id'];
        $notification = new notification($idnotification);
        if (isset($_GET['conf']))
            $_SESSION['confRetour'] = $_GET['conf'];
        if (isset($_GET['idexpediteur']))
            $_SESSION['idexpediteur'] = $_GET['idexpediteur'];
//        $idnotification = $_SESSION['idenreg'];
        $element = $notification->getElement();
        $idelement = $notification->getIdelement();
        $iddemandeur = $notification->getExpediteur();
        $infos = "VALIDATION DE : " . $element;
        $_SESSION['infoValidation'] = $element . '|' . $idelement . '|' . $iddemandeur . '|' . $idnotification . '|' . $infos;
        $ref = "index.php?config=detailsNotif";
        Functions::lancerPageSuivantIDenreg($ref, "");
        break;

    case 'actualiseNotification':
        notification::afficheNotification();
        break;

    case 'getFormresetPwd':
        ?>

        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formresetPwd" id="formresetPwd">
            <div class="control-group">
                <label class="control-label" for="motdepasse"><strong>Mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:25px; width:170px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value=""/>
                    <input type="hidden" name="action"  id="action" value="resetPwdUtilisateurs" size="32" />
                    <input type="hidden" name="id"  id="id" value="<?php echo $_GET['id']; ?>" size="32" />
                </div>
            </div>           
        </form>
        <?php
        break;

    case 'afficheMenu':
        $ancre = "";
        $rang = 0;
        $_SESSION["idsource"] = "";
        if (isset($_GET['ancre']))
            $ancre = $_GET['ancre'];
        if (isset($_SESSION['menuouvert'])) {

            if (($_SESSION['menuouvert'] == 1) && ($_SESSION['ancre'] == $_GET['ancre'])) {

                switch ($_GET['ancre']) {

                    case '#general':
                    case '#Epidemio':
                    case '#SNIGS':

                        $_SESSION['menuouvert'] = 1;
                        if (isset($_GET['rang']) && $_GET['rang'] != 0) {
                            
                        } else {
                            if (($_SESSION['ancre'] == $_GET['ancre']))
                                $ancre = "#general";
                        }
                        break;

                    default:

                        if (isset($_GET['rang']) && $_GET['rang'] == 0)
                            $_SESSION['menuouvert'] = 0;
                        break;
                }
            }else {
                $_SESSION['menuouvert'] = 1;
            }
        } else {
            $_SESSION['menuouvert'] = 1;
        }
//        Functions::afficheBoiteMsg($_SESSION['ancre']);
        if (isset($_GET['rang']))
            $rang = $_GET['rang'];
        if ($ancre == "Accueil") {
            $_SESSION['ancre'] = "";
            principale::afficheMenu();
            $ref = "index.php";
            Functions::lancerPageSuivantIDenreg($ref, "");
        } else {
            if (($ancre == $_SESSION['ancre']) && ($rang == 0)) {
                
            } else {
                $_SESSION['ancre'] = $ancre;
            }
            // Functions::afficheBoiteMsg('Merci Seigneur');
            principale::afficheMenu();
        }
        break;

    case 'getformaddatreleve':
        $conf = $_GET['conf'];
        $_SESSION['idenregcas'] = $_GET['idcas'];
        $_SESSION['retour'] = $_GET['retour'];
        $retour = $_GET['retour'];
        principale::afficheContenu($conf, $retour);
        break;

    case 'afficheContenu':
        $conf = $_GET['conf'];
        $retour = $_GET['retour'];

        $_SESSION['idenreg'] = $_GET['id'];
        $_SESSION['config'] = $_GET['conf'];
        $_SESSION['retour'] = $_GET['retour'];
        $_SESSION['listparam'] = $_GET['listparam'];
        ?>
        <script>
//            document.location.href = "index.php";
        </script>
        <?php
        principale::afficheContenu($conf, $retour);
        break;

    case 'suppression':
        $conf = $_GET['conf'];      //  Functions::afficheBoiteMsg($conf);
        // $retour = $_GET['retour'];
        principale::suppression($conf);
        break;

    case 'cloturerPresence':
        presence::cloturerPresence($_GET['datejour']);
        break;



    case 'addRubMulti':
        $retour = "addrubriqueassocie";
        rubriqueassocie::addRubriqueAssocieMulti($_GET['tab'], $retour);
        break;

    case 'actualiseNumPiece':

//        $comb = banque::listeBanquePourCombo();
//        $typepiece = new typepiece($_GET['idtypepiece']);
        $_SESSION['infosoperation']['codeunique']= $_GET['codeunique'];
        $_SESSION['infosoperation']['idtypepiece']= $_GET['idtypepiece'];
        ?>
        <SCRIPT language="javascript"> 
            JPrincipal.afficheContenu('<?php echo $_GET['codeunique']; ?>', '<?php echo $_GET['conf']; ?>', '', '');

        </SCRIPT> 

        <?php
        break;


    // Ajout d'utilisateurs
    case 'getFormAddUtilisateurs' :
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formaddUti" id="formaddUti"> 
            <fieldset class="pull-left">
                <div class="control-group">
                    <label class="control-label" for="nom"><strong>Nom</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value=""/>
                    </div>
                </div>            

                <div class="control-group">
                    <label class="control-label" for="prenom"><strong>Prénoms</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="telephone"><strong>Télephone</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email"><strong>Email</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="sexe"><strong>Sexe</strong></label>
                    <div class="controls">
                        <?php echo Functions::LoadCombo_Sexe() ?>
                    </div>
                </div>
            </fieldset>

            <fieldset class="pull-right">
                <div class="control-group">
                    <label class="control-label" for="idprofil"><strong>Profil</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo_Table("profil", "idprofil", "nomprofil", "idprofil", "Choix Profil", "180");
                        ?>
                    </div>
                </div>            

                <div class="control-group">
                    <label class="control-label" for="login"><strong>Login</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="motdepasse"><strong>Mot de passe</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value=""/>
                        <input type="hidden" name="action"  id="action" value="addUtilisateurs" size="32" />
                    </div>
                </div>
            </fieldset>
        </form>      
        <?php
        break;

    case 'addUtilisateurs':
        $S = new utilisateur("");
        $S->setNom($_GET['nom']);
        $S->setPrenom($_GET['prenom']);
        $S->setTelephone($_GET['telephone']);
        $S->setEmail($_GET['email']);
        $S->setSexe($_GET['sexe']);
        $S->setidprofil($_GET['idprofil']);
        $S->setLogin(strtolower($_GET['login']));
        $S->setMotdepasse($_GET['motdepasse']);
        $S->ajoututilisateur();
        break;

    // Modification d'utilisateurs
    case 'getFormEditUtilisateurs' :

        $user = new utilisateur($_GET['idutilisateur']);
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formeditUti" id="formeditUti"> 
            <fieldset class="pull-left">
                <div class="control-group">
                    <label class="control-label" for="nom"><strong>Nom</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getNom() ?>"/>
                    </div>
                </div>            

                <div class="control-group">
                    <label class="control-label" for="prenom"><strong>Prénoms</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getPrenom() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="telephone"><strong>Télephone</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getTelephone() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email"><strong>Email</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getEmail() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="sexe"><strong>Sexe</strong></label>
                    <div class="controls">                        
                        <?php echo Functions::LoadCombo_SexeParam($user->getSexe()) ?>                        
                    </div>
                </div>
            </fieldset>

            <fieldset class="pull-right">
                <div class="control-group">
                    <label class="control-label" for="idprofil"><strong>Profil</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo_TableParam("profil", "idprofil", "nomprofil", "idprofil", "Choix Profil", $user->getIdprofil(), "180");
                        ?>
                    </div>
                </div>            

                <div class="control-group">
                    <label class="control-label" for="login"><strong>Login</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:170px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getLogin() ?>"/>
                        <input type="hidden" name="idutilisateur"  id="idutilisateur" value="<?php echo $user->getIdutilisateur(); ?>" size="32" />
                        <input type="hidden" name="action"  id="action" value="editUtilisateurs" size="32" />
                    </div>
                </div>
            </fieldset>
        </form>      
        <?php
        break;

    case 'editUtilisateurs':
        $S = new utilisateur($_GET['idutilisateur']);
        $S->setIdprofil($_GET['idprofil']);
        $S->setLogin(strtolower($_GET['login']));
        $S->setNom($_GET['nom']);
        $S->setPrenom($_GET['prenom']);
        $S->setTelephone($_GET['telephone']);
        $S->setEmail($_GET['email']);
        $S->setSexe($_GET['sexe']);
        $S->modifutilisateur();
        break;


    // Suppression de l'utilisateur
    case 'suppUtilisateur':
        $S = new utilisateur($_GET['id']);
        $S->supputilisateur();
        break;

    /* Mes informations personnelles */
    case 'getFormEditPersonneUser':
        $user = new utilisateur($_GET['iduser']);
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formeditPersonneUser" id="formeditPersonneUser">
            <fieldset class="pull-left">
                <div class="control-group">
                    <label class="control-label" for="nom"><strong>Nom</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:220px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getNom() ?>"/>
                    </div>
                </div>            

                <div class="control-group">
                    <label class="control-label" for="prenom"><strong>Prénoms</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:220px;" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getPrenom() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="telephone"><strong>Télephone</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:220px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getTelephone() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email"><strong>Email</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:220px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getEmail() ?>"/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="sexe"><strong>Sexe</strong></label>
                    <div class="controls">
                        <?php echo Functions::LoadCombo_SexeParam($user->getSexe()) ?>                         
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="login"><strong>Identifiant</strong></label>
                    <div class="controls">
                        <input type="text" style="height:20px; width:220px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getLogin() ?>"/>
                        <input type="hidden" name="action"  id="action" value="editPersonneUser" size="32" />
                        <input type="hidden" name="iduser"  id="iduser" value="<?php echo $user->getIdutilisateur(); ?>" size="32" />
                    </div>
                </div>
            </fieldset>
        </form>
        <?php
        break;

    case 'editPersonneUser':
        $S = new utilisateur($_GET['iduser']);
        $S->setNom($_GET['nom']);
        $S->setPrenom($_GET['prenom']);
        $S->setTelephone($_GET['telephone']);
        $S->setEmail($_GET['email']);
        $S->setSexe($_GET['sexe']);
        $S->setLogin($_GET['login']);
        $S->modifutilisateur1();
        break;

    /* Changer votre mot de passe */
    case 'getFormEditPasswordUser':
        $user = new utilisateur($_GET['iduser']);
        ?>
        <p class="validateTips"></p>     
        <form class="form-horizontal" action="" method="post" name="formeditPasswordUser" id="formeditPasswordUser">
            <div class="control-group">
                <label class="control-label" for="nom"><strong>Nom et prénoms</strong></label>
                <div class="controls">
                    <input type="text" style="height:20px; width:220px;" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getNom() . ' ' . $user->getPrenom(); ?>" readonly/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="login"><strong>Login</strong></label>
                <div class="controls">
                    <input type="text" style="height:20px; width:220px;" name="login" id="login" class="text ui-widget-content ui-corner-all" value="<?php echo $user->getLogin(); ?>" readonly/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="motdepasse"><strong>Mot de passe actuel</strong></label>
                <div class="controls">
                    <input type="password" style="height:20px; width:220px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value="" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="motdepasse1"><strong>Nouveau mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:20px; width:220px;" name="motdepasse1" id="motdepasse1" class="text ui-widget-content ui-corner-all" value="" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="motdepasse2"><strong>Confirmer votre mot de passe</strong></label>
                <div class="controls">
                    <input type="password" style="height:20px; width:220px;" name="motdepasse2" id="motdepasse2" class="text ui-widget-content ui-corner-all" value="" />
                    <input type="hidden" name="action"  id="action" value="editPasswordUser" size="32" />
                    <input type="hidden" name="iduser"  id="iduser" value="<?php echo $user->getIdutilisateur(); ?>" size="32" />
                </div>
            </div>
        </form>

        <?php
        break;

    case 'editPasswordUser':
        $S = new utilisateur($_GET['iduser']);
        $S->changepassword($_GET['motdepasse'], $_GET['motdepasse1'], $_GET['motdepasse2']);
        break;

    /* Reinitialisation de mot de passe */
    case 'getFormEditUti':
        //echo 'Merci';
        ?>
        <p class="validateTips"></p>
        <form class="form-horizontal" action="" method="post" name="formresetPwd" id="formresetPwd">
            <div class="control-group">
                <label class="control-label" for="motdepasse"><strong>Mot de passe</strong></label>
                <div class="controls">
                    <input type="text" style="height:20px; width:170px;" name="motdepasse" id="motdepasse" class="text ui-widget-content ui-corner-all" value=""/>
                    <input type="hidden" name="action"  id="action" value="resetPwdUtilisateurs" size="32" />
                    <input type="hidden" name="idutilisateur"  id="idutilisateur" value="<?php echo $_GET['idutilisateur']; ?>" size="32" />
                </div>
            </div>           
        </form>
        <?php
        break;

    case 'resetPwdUtilisateurs':
        $S = new utilisateur($_GET['idutilisateur']);
        $S->resetpassword($_GET['motdepasse']);
        break;

    case 'ajoutFormModal':
        switch ($_GET['conf']) {
            case 'addpiece':
                typepiece::formAddEdit($_GET['retour'], "");
                break;
            case 'addpresence':
                presence::formAddEdit($_GET['retour'], $_GET['conf'], "");
                break;

            case 'addchantier':
                chantier::formAddEdit($_GET['retour'], "");
                break;

            case 'majdetailsModereglement':
            case 'editDetailseditmodereglement':
                list($retour, $idmodereglement, $iddetail ) = explode('|', $_GET['retour']);
                detailsmodereglement::formMaj($retour, $idmodereglement, $iddetail);
                break;

            case 'majbanqueacteur':
            case 'editbanqueateur':
                list($retour, $idacteur, $iddetail ) = explode('|', $_GET['retour']);
                banqueacteur::formMaj($retour, $idacteur, $iddetail);
                break;

            case 'majdetailsdevis':
            case 'editdetailsdevis': //echo 'Merci '.$_GET['retour'];
                list($retour, $idacteur, $iddetail ) = explode('|', $_GET['retour']);
                detailsdevis::formMaj($retour, $idacteur, $iddetail);
                break;

            case 'majfournisseurelement':
            case 'editfournisseurelement':
                list($retour, $idelement, $iddetail ) = explode('|', $_GET['retour']);
                fournisseurelement::formMaj($retour, $idelement, $iddetail);
                break;

            case 'majdetailsouvrage':
            case 'editdetailsouvrage':
                list($retour, $idelement, $iddetail ) = explode('|', $_GET['retour']);
                detailsouvrage::formMaj($retour, $idelement, $iddetail);
                break;

            case 'addprov':
                provenance::formAddEdit($_GET['retour'], "");
                break;

            case 'addrub':
                rubriques::formAddEdit($_GET['retour'], "");
                break;

            case 'addclient': 
                $_SESSION['idDT']=$_GET['id'];
                acteurcommercial::formAddEdit($_GET['retour'],"addclient", 1);
                break;
            case 'addpersExterne':            
                personne::formPersExterne($_GET['retour'],4, '');
                break;
            case 'addpersTemp':            
                personne::formPersExterne($_GET['retour'],3, '');
                break;
            case 'reinitpw':
                utilisateur::formReinitPw($_GET['retour'], '');
                break;
            case 'majProfil':
                utilisateur::formMajProfil($_GET['retour']);
                break;

            case 'critereselection':
//                $_SESSION['idtypeperiode'] = $_GET['idtypeperiode'];
//               $_SESSION['idmois'] = $_GET['idmois'];
//               $_SESSION['idannee'] = $_GET['idannee'];
                principale::formCritere($_GET['retour']);
                break;
            case 'addnotes':
                list($retour, $idnote, $idpersonne, $dateEval, $idanne, $idtypenote) = explode("|", $_GET['retour']);
                notes::formAddEdit($retour, $idnote, $idpersonne, $dateEval, $idanne, $idtypenote);
                break;
        }
        ?>
        <script>
            JPrincipal.appliqueChosen();
        </script>
        <?php
        break;

    case 'actUtilisateur':
        $id = $_GET['id'];
        $uti = new utilisateur($id);
        $uti->actuti();
        break;

    case 'desactUtilisateur':
        $id = $_GET['id'];
        $uti = new utilisateur($id);
        $uti->desactuti();
        break;
    //================================================================================================
    case 'addprofil':
        $retour = "profil";
        profil::addProfil($retour);
        break;

    case 'editprofil':
        $retour = "profil";
        profil::editProfil($_GET['id'], $retour);
        break;

    case 'addUserProfil':
        $retour = "adduserprofil";
        userprofil::addUserProfil($_GET['id'], $retour);
        break;

    case 'addMenu':
        $retour = "addmenuprofil";
        menuprofil::addMenuProfil($_GET['id'], $retour);
        break;
    //================================================================================================

    case 'validerFonction':
        $retour = "fonction";
        fonction::validerFonction($_GET['id'], $retour);
        break;

    case 'validerPersonne':
        $retour = "personne";
        personne::validerPersonne($_GET['id'], $retour);
        break;

    case 'validerReinitPW':
        $retour = "utilisateur";
        utilisateur::validerPW($_GET['idutilisateur'], $retour);
        break;

    case 'validerProfilUser':
        $retour = "utilisateur";
        utilisateur::validerProfiluser($_GET['idutilisateur'], $retour);
        break;

    case 'validerUtilisateur':
        $retour = "utilisateur";
        utilisateur::valider($_GET['codeunique'], $retour);
        break;
    case 'validerNotification':
        notification::valider($_GET['champ']);
        break;

    case 'validerPersExterne':
        personne::validerPersExterne($_GET['champ']);
        break;

    case 'onchangeCmbTypePersone':
        //$idtypepersonne = $_GET['idtypepersonne'];
        $_SESSION['idtypepersonne'] = $_GET['idtypepersonne'];
        principale::afficheContenu('personne');
        ?>
<!--        <script>
            JPrincipal.afficheContenu('<?php // echo $idtypepersonne; ?>', 'personne', '', '');
        </script>-->
        <?php
        break;

    case 'actualisezoneLieuMvt':
        $_SESSION['infomvt'] = explode('|', $_GET['val']);
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $_GET['id']; ?>', '<?php echo $_GET['conf']; ?>', '', '');
        </script>
        <?php
        break;

    case 'actualiseDemandeur':
        $_SESSION['infodevis'] = explode('|', $_GET['infodevis']);
        //Functions::afficheBoiteMsg($_GET['conf']);
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $_GET['id']; ?>', '<?php echo $_GET['conf']; ?>', '', '');
            //            document.getElementById('zonedemandeur').innerHTML = '<strong>' + '<?php // echo $dmdeur;  ?>' + '</strong>';
            //            document.getElementById('zonedetaildemandeur').innerHTML = '<strong>' + '<?php // echo $dmdeur;  ?>' + '</strong>';
        </script>
        <?php
        break;

    case 'actualiseEltccial':
        $idelementccial = $_GET['idelementccial'];
        $elt = elementcommercial::elementcommercialParCritere("WHERE codeunique = '".$_GET['idelementccial']."'");
       $b = (sizeof($elt, 1) > 0) ? 1 : 0;
       $pvht = ($b == 1) ? $elt[0]['prixventeHT'] : 0;
        //Functions::afficheBoiteMsg($_GET['conf']);
        
        ?>
        <script>
                     document.getElementById('pvht').value = '<?php  echo $pvht;  ?>';
            //            document.getElementById('zonedetaildemandeur').innerHTML = '<strong>' + '<?php // echo $dmdeur;  ?>' + '</strong>';
        </script>
        <?php
        break;

    case 'actualiseCompte':
        $c = paramcomptelt::paramcompteltParCritere("WHERE idtypeelt = '".$_GET['idtypeeltccial']."' AND idfamille = '".$_GET['idfamille']."'");
       $b = (sizeof($c, 1) > 0) ? 1 : 0;
       $numcompte = ($b == 1) ? $c[0]['numcompte'] : 0;
        //Functions::afficheBoiteMsg($_GET['conf']);
        
        ?>
        <script>
                     document.getElementById('numcompte').value = '<?php  echo $numcompte;  ?>';
            
        </script>
        <?php
        break;

    case 'actualiseParamFamille':
       $c = paramcomptelt::paramcompteltParCritere("WHERE idtypeelt = '".$_GET['idtypeeltccial']."' AND idfamille = '".$_GET['idfamille']."'");
       $b = (sizeof($c, 1) > 0) ? 1 : 0;
       $f = famille::familleParCritere("WHERE  codeunique = '".$_GET['idfamille']."'");
       $bf = (sizeof($f, 1) > 0) ? 1 : 0;
       $numcompte = ($b == 1) ? $c[0]['numcompte'] : 0;
//        Functions::afficheBoiteMsg($f[0]['benemat']);
        
        ?>
        <script>
                 document.getElementById('fraismat').value = '<?php  echo ($bf == 1) ? $f[0]['fraismat'] : 0;  ?>';
                 document.getElementById('fraismod').value = '<?php  echo ($bf == 1) ? $f[0]['fraismod'] : 0;  ?>';
                 document.getElementById('beneficemat').value = '<?php  echo ($bf == 1) ? $f[0]['benemat'] : 0;  ?>';
                 document.getElementById('beneficemod').value = '<?php  echo ($bf == 1) ? $f[0]['benemod'] : 0;  ?>';
//            JCommrecial.actualisetarif();
            JCommrecial.actualisetarif('H')
        </script>
        <?php
        break;

    case 'actualiseDescription':
        $resume = $_GET['resume'];        
        ?>
        <script>
                     if(document.getElementById('descripcommercial').value==='')document.getElementById('descripcommercial').value = '<?php  echo $resume;  ?>';
                     if(document.getElementById('descriptechnique').value==='')document.getElementById('descriptechnique').value = '<?php  echo $resume;  ?>';
            
        </script>
        <?php
        break;

    case 'actualiseTotal':
        $idelementccial = $_GET['idelementccial'];
        $quantite = $_GET['quantite'];
        $remise = $_GET['remise'];
        $tva = taxe::tauxTaxe($_GET['idtva']);
        $elt = elementcommercial::elementcommercialParCritere("WHERE codeunique = '".$_GET['idelementccial']."'");
       $b = (sizeof($elt, 1) > 0) ? 1 : 0;
       $pvht = ($b == 1) ? $elt[0]['prixventeHT'] : 0;
       $ht = $quantite *$pvht;
       $totht = Functions::formatnombre($ht);
       $net = $ht -$remise;
       $netht = Functions::formatnombre($net);
       $ttc = $net *(1+$tva/100);
       $totttc = Functions::formatnombre($ttc);
        //Functions::afficheBoiteMsg($_GET['conf']);
        
        ?>
        <script>
                     document.getElementById('totht').value = '<?php  echo $totht;  ?>';
                     document.getElementById('netht').value = '<?php  echo $netht;  ?>';
                     document.getElementById('ttc').value = '<?php  echo $totttc;  ?>';
            //            document.getElementById('zonedetaildemandeur').innerHTML = '<strong>' + '<?php // echo $dmdeur;  ?>' + '</strong>';
        </script>
        <?php
        break;

    case 'formatNombre':
        $idchamp = $_GET['idchamp'];      //  Functions::afficheBoiteMsg($idchamp);   
        $valchamp = Functions::formatnombre($_GET['valchamp']);
        ?>
        <script>
            var val = '<?php echo $valchamp; ?>';
            document.getElementById('<?php echo $idchamp; ?>').value = val;
        </script>
        <?php
        break;

    case 'onChangecmbTypePeriode':
        $_SESSION['idtypeperiode'] = $_GET['idtypeperiode'];
        ?>
        <script>
            JPrincipal.ajoutFormModal('critereselection', '<?php echo $_GET['idtypeperiode']; ?>');
        </script>
        <?php
        break;

    case 'validerPresence':
        if ($_GET['conf'] == "addpresence") {
            $retour = $_GET['retour'];
        }
        if ($_GET['conf'] == "editpresence") {
            $retour = "presence";
        }
        if ($_GET['conf'] == "editpresenceDetail") {
            $retour = "detailsPresence";
        }
        presence::validerPresence($_GET['id'], $retour);
        break;

    case 'validerAbsence':
        $retour = "absence";
        absence::validerAbsence($_GET['id'], $retour);
        break;

    case 'validerPrevision':
        $retour = "prevision";
        previsiontache::validerPrevision($_GET['id'], $retour);
        break;

    case 'executerTache':
        previsiontache::executerTache($_GET['id']);
        break;

    case 'validerObjectif':
        $retour = "objectif";
        objectifsjr::validerObjectif($_GET['id'], $retour);
        break;

    case 'atteindreObjectif':
        objectifsjr::atteindreObjectif($_GET['id']);
        break;

    case 'validationObjectif':
        objectifsjr::validationObjectif($_GET['id']);
        break;

    case 'validerSource':
        $retour = $_GET['retour'];
        sourceoperation::valider($_GET['codeunique'], $retour);
        break;

    case 'validerparametre':
        $retour = $_GET['retour'];
        parametre::valider($_GET['codeunique'], $retour);
        break;

    case 'validerPF':
        operationfinanciere::validerPF($_GET['conf']);
        break;

    case 'validerSuiviTache':
        $retour = "suivitache";
        suivitache::validerSuiviTache($_GET['id'], $retour);
        break;

    case 'onChangeCmbPersonne':
        $idpersonne = $_GET['idpersonne'];
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $idpersonne; ?>', '<?php echo $_GET['conf']; ?>', '', '');
        </script>
        <?php
        break;

    case 'onChangeComboActionnonlivraison':
        $_SESSION['idenreg'] = $_GET['id'];
        $_SESSION["idactionlivraison"] = $_GET["idactionlivraison"]; 
        $_SESSION['ongactiv'] = $_GET["ong"]; 
         principale::afficheContenu($_GET["conf"], '');        
        break;

    case 'onChangeCmbMois':
        $idmois = $_GET['idmois'];
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $idmois; ?>', '<?php echo $_GET['conf']; ?>', '', '');
        </script>
        <?php
        break;

    case 'onchangeCmbTypeFamille':
        $_SESSION["idtypefamille"] = $_GET["idtypefamille"];
        principale::afficheContenu($_GET["conf"], '');
       
        break;

    case 'onchangeCmbTypeUnite':
        $_SESSION["idtypeunite"] = $_GET["idtypeunite"];
        principale::afficheContenu($_GET["conf"], '');
        break;

    case 'onChangeTypeelementccial':
        $_SESSION["idtypeeltccial"] = $_GET["idtypeeltccial"];
        principale::afficheContenu($_GET["conf"], '');
        break;

    case 'onChangeDateFiltre':
        $datefiltre = $_GET['datefiltre'];
        if ($_GET['conf'] == "objectif") { //si ce sont les objectifs
            $datefiltre = $_GET['datefiltre'] . "|" . $_SESSION["user"]["codeunique"];
        }
        ?>
        <script>
            JPrincipal.afficheContenu(0, '<?php echo $_GET['conf']; ?>', '<?php echo $datefiltre; ?>', '');
        </script>
        <?php
        break;

    case 'onChangePeriode':
        $_SESSION["debutperiode"] = $_GET['debutperiode'];
        $_SESSION["finperiode"] = $_GET['finperiode'];
        ?>
        <script>
            JPrincipal.afficheContenu(0, '<?php echo $_GET['conf']; ?>', '', '');
        </script>
        <?php
        break;

    case'updateHeureDep':
        presence::validerHeureDepart();
        break;

    case'validerFiche':
        presence::validerFichePresence($_GET["datejour"]);
        break;

    case'validerFicheAbs':
        absence::validerFicheAbsence($_GET["datejour"]);
        break;

    case'validerRapports':
        $retour = "rapports";
        rapports::validerRapports($_GET['id'], $retour);
        break;

    case'validationRapport':
        rapports::validationRapport($_GET['id']);
        break;

    case'validerProgramme':
        $retour = "program";
        programme::validerProgramme($_GET['id'], $retour);
        break;

    case'validerDetailsProgramme':
        $retour = "adddetailsProgram";
        detailsprogram::validerDetailsProgramme($_GET['id'], $retour);
        break;

    case'validerPlanning':
        $retour = "planning";
        planning::validerPlanning($_GET['id'], $retour);
        break;

    case'suiviTechnicien':
        planning::validerActiviterJour();
        break;

    case'validerSuiviPrime':
        $retour = "prime";
        suiviprime::validerSuiviPrime($_GET['id'], $retour);
        break;

    case'validerContrat':
        $retour = "contrat";
        contrat::validerContrat($_GET['id'], $retour);
        break;

    case'validerEcheancier':
        $retour = "addecheancier";
        echeancier::validerEcheancier($_GET['id'], $retour);
        break;

    case'validerAnneeAcademique':
        $retour = "anneeacademik";
        anneeacademique::validerAnneeAcademik($_GET['id'], $retour);
        break;

    case'validerTitre':
        $retour = "titre";
        titre::validerTitre($_GET['id'], $retour);
        break;

    case'validerTraitement':
        $codeunique = $_GET['codeunique'];
        $retour = $_GET['retour'];
        $champ = explode("|", $_GET["champ"]);
        switch ($retour) {
            case 'acteurs':
                acteurs::valider($codeunique, $retour, $champ);
                break;
            case 'bureauechange':
                bureauechange::valider($codeunique, $retour, $champ);
                break;
            case 'elementscp':
                elementscp::valider($codeunique, $retour, $champ);
                break;
            case 'actionnonlivraison':
               actionnonlivraison::valider($codeunique, $retour, $champ);
                break;
            case 'expedition':
               expedition::valider($codeunique, $retour, $champ);
                break;

            case 'scp':
                scp::valider($codeunique, $retour, $champ);
                break;

        }
        break;

    case 'OnchangeDateJrPrev':
        $datejour = $_GET['datejour'];
        ?>
        <script>
            JPrincipal.afficheContenu(0, 'addobjectif', '<?php echo $datejour; ?>', '');
        </script>
        <?php
        break;
    case 'desactiverPers':
        $retour = "personne";
        personne::desactPersonne($_GET["id"]);
        break;

    case 'activerPers':
        $retour = "personne";
        personne::actiPersonne($_GET["id"]);
        break;

    case'validerTypePunition':
        $retour = "typepunition";
        typepunition::validerTypePunition($_GET['id'], $retour);
        break;

    case'validerTypeNote':
        $retour = "typenote";
        typenote::validerTypeNote($_GET['id'], $retour);
        break;

    case'validerPunition':
        $retour = "punition";
        punition::validerPunition($_GET['id'], $retour);
        break;

    case'validerNotes':
        $retour = "notes";
        notes::validerNotes($_GET['id'], $retour);
        break;
    case'validerFrais':
        $retour = "personne";
        personne::fraisPersonne($_GET["id"], $_GET["fraisformation"]);
        break;
    case'onchangeCmbProgramme':
        $conf = $_GET['conf'];
        $idprogramme = $_GET['idprogramme'];
        switch ($conf) {
            case'syntheseTech':
            case'syntheseTech':
                ?>
                <script>
                    JPrincipal.afficheContenu('<?php echo $idprogramme; ?>', '<?php echo $conf; ?>', '', '');
                </script>
                <?php
                break;
        }

        break;
    case'onChangeContact':
        $cont1 = "";
        $cont2 = "";
        $idtypeacteur = $_GET['idtypeacteur'];
        switch ($idtypeacteur) {
            case 1:
            case 3:
                $cont1 = 'Facturation';
                $cont2 = 'Livraison';
                break;
            case 2:
                $cont1 = 'Commande';
                $cont2 = 'Enlèvement';
                break;
        }
        $idcontact1 = $_GET['idcontact1'];
        $idcontact2 = $_GET['idcontact2'];
        $_SESSION['idcontact1'] = $_GET['idcontact1'];
        $_SESSION['idcontact2'] = $_GET['idcontact2'];
        $p1 = new personne($idcontact1);
        $p2 = new personne($idcontact2);

//        $onchange1 = "";
//        $rekete = "SELECT *,CONCAT(nom,' ',prenom) AS nomprenom FROM personne WHERE idtypepersonne =4 AND desactiver = 0";
        $critere = 'WHERE idtypepersonne =4 AND desactiver = 0';
        $comb = personne::listPersonnePourCombo($critere);
        ?>
        <script>
            listCombo = '<?php echo $comb; ?>';
            var idencour1 = '<?php echo $idcontact1; ?>';
            var idencour2 = '<?php echo $idcontact2; ?>';
            var donneeCombo = listCombo.split('-->');
            combo1 = JPrincipal.chargeCombo("idcontact1", "JCommrecial.onChangeContact()", "Contact", "300", donneeCombo, idencour1);
            combo2 = JPrincipal.chargeCombo("idcontact2", "JCommrecial.onChangeContact()", "Contact", "300", donneeCombo, idencour2);
            document.getElementById("zoneinfocontact").innerHTML = ' \n\
        <table>\n\
        <tr><td colspan="3"> <strong><?php echo $cont1; ?> </strong></td>\n\
        <td colspan="2"> <strong><?php echo $cont2; ?> </strong></td></tr>\n\
        <tr><td colspan="2">' + combo1 + '</td >\n\
        <td style=" width:40px;"></td>\n\
        <td colspan="2">' + combo2 + '</td></tr>\n\
        <tr><td style=" width:100px;" >Adresse</td> <td ><?php echo $p1->getAdresse(); ?></td> <td style=" width:130px;">\n\
        </td><td >Adresse</td> <td style=" width:100px;" ><?php echo $p2->getAdresse(); ?></td> \n\
        </tr> <tr><td >Téléphone</td><td ><?php echo $p1->getTelephone(); ?></td>\n\
        <td style=" width:40px;"></td> \n\
        <td >Téléphone</td> \n\
        <td ><?php echo $p2->getTelephone(); ?></td>\n\
        </tr><tr>\n\
        <td >Email</td>\n\
        <td ><?php echo $p1->getEmail(); ?></td>\n\
        <td style=" width:40px;"></td>\n\
        <td >Email</td>\n\
        <td ><?php echo $p2->getAdresse(); ?></td>\n\
        </tr>\n\
        </table>';


        </script>
        <?php
//                break;
//        }

        break;

    case'onchangeCmbTechnicien':
        $conf = $_GET['conf'];
        $idprogramme = $_GET['idprogramme'];
        $idpersonne = $_GET['idpersonne'];
        switch ($conf) {
            case'syntheseIndiv':
                ?>
                <script>
                    JPrincipal.afficheContenu('<?php echo $idprogramme; ?>', '<?php echo $conf; ?>', '<?php echo $idpersonne; ?>', '');
                </script>
                <?php
                break;
        }

        break;

    case'onChangeComboTva':
        $conf = $_GET['conf'];
        $idtva= $_GET['idtva'];    
        $tva = taxe::tauxTaxe($idtva);
        switch ($conf) {
            case'majelementccial': 
                ?>
                <script>
                    document.getElementById("tva").value = '<?php echo $tva; ?>';
                    JCommrecial.actualisetarif('H');
                </script>
                <?php
                break;
        }

        break;

    case 'onChangeDateEvaluation':
        $dateeval = $_GET['dateEval'];
        $anneeAca = $_GET['idanneeacademik'];
        $typenote = $_GET['idtypenote'];
//        if ($dateeval != "" and $anneeAca != 0 and $typenote != 0) {
        ?>
        <script>
            JPrincipal.afficheContenu(0, '<?php echo $_GET['conf']; ?>', '<?php echo $dateeval . "|" . $anneeAca . "|" . $typenote; ?>', '');
        </script>
        <?php
//        }
        break;

    case 'onChangeAnneeAcademik':
        $anneeAca = $_GET['idanneeacademik'];
        $dateeval = $_GET['dateEval'];
        $typenote = $_GET['idtypenote'];
//        if ($dateeval != "" and $anneeAca != 0 and $typenote != 0) {
        ?>
        <script>
            JPrincipal.afficheContenu(0, '<?php echo $_GET['conf']; ?>', '<?php echo $dateeval . "|" . $anneeAca . "|" . $typenote; ?>', '');
        </script>
        <?php
//        }
        break;

    case 'onChangeTypeNote':
        $typenote = $_GET['idtypenote'];
        $dateeval = $_GET['dateEval'];
        $anneeAca = $_GET['idanneeacademik'];
//        if ($dateeval != "" and $anneeAca != 0 and $typenote != 0) {
        ?>
        <script>
            JPrincipal.afficheContenu(0, '<?php echo $_GET['conf']; ?>', '<?php echo $dateeval . "|" . $anneeAca . "|" . $typenote; ?>', '');
        </script>
        <?php
//        }
        break;

    case 'onChangeCmbPersPrevision':
        $idmois = $_GET['idmois'];
        $idpersonne = $_GET['idpersonne'];
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $idmois; ?>', '<?php echo $_GET['conf']; ?>', '<?php echo $idpersonne; ?>', '');
        </script>
        <?php
        break;

    case 'onChangeCmbUserObjectif':
        $datefiltre = $_GET['datefiltre'];
        $idpersonne = $_GET['idpersonne'];
        ?>
        <script>
            JPrincipal.afficheContenu('', '<?php echo $_GET['conf']; ?>', '<?php echo $datefiltre . "|" . $idpersonne; ?>', '');
        </script>
        <?php
        break;

    //======================================================================================================
    //======================================================================================================
    case'validercritereselection':
        $_SESSION['idtypeperiode'] = $_GET['idtypeperiode'];
        $_SESSION['idmois'] = $_GET['idmois'];
        $_SESSION['idannee'] = $_GET['idannee'];
        $_SESSION['debut'] = $_GET['debut'];
        $_SESSION['fin'] = $_GET['fin'];


//        switch ($_GET['conf']) {
//            case 'rapportfinancier':
//                operationfinanciere::afficheContenu($_GET['conf'], '');
//                break;
//        }
        ?>
        <SCRIPT language="javascript">
            JPrincipal.afficheContenu(0, 'rapportfinancier', '', '');
            //               $("#zonemodal").dialog("close");
        </script> 
        <?php
        break;

    case 'addMenuMulti':
        $retour = "addmenuprofil";
        menuprofil::addMenuProfilMulti($_GET['tab'], $retour);
        break;

    case 'addDroit':
        $retour = "adddroitacces";
        droitacces::addDroitAcces($_GET['id'], $retour);
        break;

    case 'addDroitMulti':
        $retour = "adddroitacces";
        droitacces::addDroitAccesMulti($_GET['tab'], $_GET['retour']);
        break;

    //================================================================================================
    //================================================================================================
    case 'validerRubriques':
        $retour = $_GET['retour'];
        rubriques::valider($_GET['codeunique'], $retour);
        break;

    case 'validerCompte':
        compte::valider($_GET['codeunique'], $_GET['retour'], $_GET['champ']);
        break;

    case 'validerDomaineActivite':
        $retour = $_GET['retour'];
        domaineactivite::valider($_GET['codeunique'], $retour);
        break;

    case 'validerProvenance':
        $retour = $_GET['retour'];
        provenance::valider($_GET['codeunique'], $retour);
        break;

    case 'validerTypepiece':
        $retour = $_GET['retour'];
        typepiece::valider($_GET['codeunique'], $retour);
        break;


    case 'validerOperationfinanciere':
        operationfinanciere::valider($_GET['codeunique'], $_GET['retour']);
        break;

    case 'validerDemandetravaux':
        demandetravaux::valider($_GET['codeunique'], $_GET['retour']);
        break;

    case 'onChangeTxtDatePeriode':
        $_SESSION["debut"] = Functions::convertDate($_GET["debut"]);
        $_SESSION["fin"] = Functions::convertDate($_GET["fin"]);
        switch ($_GET["conf"]) {
            case "pointcaisse":
                ?>
                <SCRIPT language="javascript">
                    JPrincipal.afficheContenu(0, 'pointcaisse', '', '');
                </script> 
                <?php
                //operationfinanciere::afficheContenu($_GET["conf"], "", 1);
                break;
            case "pointbanque":
                ?>
                <SCRIPT language="javascript">
                    JPrincipal.afficheContenu(0, 'pointbanque', '', '');
                </script> 
                <?php
                // operationfinanciere::afficheContenu($_GET["conf"], "", 2);
                break;

            case "rapportfinancier":
                operationfinanciere::afficheContenu($_GET["conf"], "");
                break;
        }
        break;

    case "afficheRapport":
        $_SESSION["idmois"] = $_GET["idmois"];
        $_SESSION["idannee"] = $_GET["idannee"];
        operationfinanciere::afficheContenu($_GET["conf"], "");
        break;

    case 'onChangeCmbSource':
        $_SESSION["idsource"] = $_GET["idsource"];
        principale::afficheContenu($_GET["conf"], '');

        break;

    case 'onChangeCmbElement':
        $_SESSION["element"] = $_GET["element"];       // Functions::afficheBoiteMsg('Merci '.$_GET["conf"]);
        principale::afficheContenu($_GET["conf"], '');

        break;
    
    //a partir dici  Amanda
    case 'validerJournal':
        $retour = "jrnal";
        journal::valider($_GET['id'], $retour);
        break;

    case 'onChangeCmbJournal':
        $idjournal = $_GET['idjournal'];
        ?>
        <script>
            JPrincipal.afficheContenu('<?php echo $idjournal; ?>', '<?php echo $_GET['conf']; ?>', '', '');
        </script>
        <?php
        break;
    
    case'genererEcriture':
        ecriture::genererEcriture();
        break;
    
    case'validerBrouillard':
        ecriture::valEcriture();
        break;
}
?>