<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of validation
 *
 * @author DIEUAMOUR
 */
class principale {

    static function superieursHierarchiqueParActeur($idacteur) {
        $acteur = new utilisateur($idacteur);
        $idStructAteur = $acteur->getIdstructure();
        $idstructure = $idStructAteur;

        $idchef = 0;
        $structure = new structure($idstructure);
        //si l'acteur est chef alors on cherche sa structure mère
        if ($acteur->getIdchef() == $idacteur) {
            $structureMere = new structure($structure->getIdstructuremere());
            $idchef = $structureMere->getIdchef();
        } else {
            $idchef = $acteur->getIdchef();
        }
        return $idchef;
    }

    public static function afficheMenu() {     //   Functions::afficheBoiteMsg('Merci');
        ?>
        <!--<div class="menu">-->
        <div class="accordion" id="accordion2">
            <?php
            if (isset($_SESSION['userMenu'])) {
                include_once '../includes/nav/menuCollaboration.inc.php';
        include_once '../includes/nav/menuTraitements.inc.php';
        include_once '../includes/nav/menuParametre.inc.php';
        include_once '../includes/nav/menuRapport.inc.php';
              
            }
            ?>

        </div> 
        <?php
    }

    public static function afficheContenu($conf = "", $retour = "") {
        ?>
        <div id="zoneadd">

        </div>

        <div id="info"></div>
        <div id="zoneListeSite" >
            <div id="zoneannuler" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment annuler cette pièce?
                </p>
            </div>
            <div id="zonesuppr" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment supprimer cet enregistrement?
                </p>
            </div>
            <div id="zonecloturepresence" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment clôturer la présence pour cette date?
                </p>
            </div>
            <div id="zoneExec" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment marquer cette tâche comme exécutée?
                </p>
            </div>
            <div id="zoneValide" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment valider?
                </p>
            </div>
            <div id="zoneObj" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment marquer cet objectif comme atteint?
                </p>
            </div>
            <div id="zoneHeureDep" style="display: none">
                <div class="form-horizontal">
                    <label class="control-label" for="heuredepart"><strong>Heure de départ</strong></label>
                    <div class="controls">
                        <input type="time" style="height:30px; width:200px;" name="heuredepart" id="heuredepart" placeholder="00:00:00" class="text ui-widget-content ui-corner-all" value="" />
                    </div>
                </div>
            </div>
            <div id="zoneSuiviTech" style="display: none">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="activitejour"><strong>Activité du jour (*)</strong></label>
                        <div class="controls">
                            <textarea rows="2" style="width:300px;" name="activitejour" id="activitejour" placeholder="L'activité du jour" ></textarea>  
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="observation"><strong>Observation</strong></label>
                        <div class="controls">
                            <textarea rows="2" style="width:300px;" name="observation" id="observation" placeholder="mes observations" ></textarea>  
                        </div>
                    </div>
                </div>
            </div>
            <div id="zonedesactUser" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment mettre en veille cette personne?
                </p>
            </div>
            <div id="zoneactiUser" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment activer cette personne?
                </p>
            </div>

            <div id="zoneFrais" style="display: none">
                <div class="form-horizontal">
                    <label class="control-label" for="fraisformation"><strong>Frais de formation</strong></label>
                    <div class="controls">
                        <input type="number" style="height:30px; width:200px;" name="fraisformation" id="fraisformation" class="text ui-widget-content ui-corner-all" value="" />
                    </div>
                </div>
            </div>
            <div id="zoneGenEcr" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment générer ces écritures?
                </p>
            </div>
            <div id="zonevalEcr" style="display: none">
                <p>
                    <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment valider les écritures du brouillard?
                </p>
            </div>
            <div id="info"></div>
            <div id="zonemodal"></div>

            <?php
            switch ($conf) {
                case 'majmatricule':
                case 'majnumdevis':
                    parametre::formMajMatricule($conf, '');
                    break;
                case 'moncompte':
                case 'password':
                case 'utilisateur':
                case 'addutilisateur':
                case 'editutilisateur':
                case 'supputilisateur':
                    utilisateur::afficheContenu($conf, $retour);
                    break;

                case 'profil':
                case 'addprofil':
                case 'editprofil':
                case 'suppprofil':
                    profil::afficheContenu($conf, $retour);
                    break;

                case 'acteurs':
                case 'addacteurs':
                case 'editacteurs':
                    acteurs::afficheContenu($conf, $retour);
                    break;

                case 'bureauechange':
                case 'addbureauechange':
                case 'editbureauechange':
                    bureauechange::afficheContenu($conf, $retour);
                    break;
                
                case 'elementscp':
                case 'addelementscp':
                case 'editelementscp':
                    elementscp::afficheContenu($conf, $retour);
                    break;
                
                case 'expedition':
                case 'addexpedition':
                case 'editexpedition':
                    expedition::afficheContenu($conf, $retour);
                    break;
                case 'scp':
                case 'addscp':
                case 'editscp':
                    scp::afficheContenu($conf, $retour);
                    break;
                
               //
                case 'civilite':
                case 'addcivilite':
                case 'editcivilite':
                    civilite::afficheContenu($conf, $retour);
                    break;
                case 'famille':
                case 'addfamille':
                case 'editfamille':
                    famille::afficheContenu($conf, $retour);
                    break;

                case 'unite':
                case 'addunite':
                case 'editunite':
                    unite::afficheContenu($conf, $retour);
                    break;

                               case 'adduserprofil':
                case 'listeuserProfil':
                case 'suppUserProfil':
                    userprofil::afficheContenu($conf, $retour);
                    break;

                case 'menuprofil':
                case 'addmenuprofil':
                case 'listemenuP':
                case 'suppMenuProfil':
                    menuprofil::afficheContenu($conf, $retour);
                    break;


                case 'droitacces':
                case 'adddroitacces':
                case 'listemenuP':
                case 'detailsDroitProfil':
                    droitacces::afficheContenu($conf, $retour);
                    break;

                case 'taxe':
                case 'addtaxe':
                case 'edittaxe':
                    taxe::afficheContenu($conf, $retour);
                    break;

                case 'titre':
                case 'addtitre':
                case 'edittitre':
                case 'supptitre':
                    titre::afficheContenu($conf, $retour);
                    break;

                case 'addnotification':
                case 'collaboration':
                case 'nonlus':
                case 'envoye':
                case 'recues':
                case 'observNotification':
                case 'relanceNotification':
                case 'fluxNotification':
                case 'voirNotification':
                    notification::afficheContenu($conf, $retour);
                    break;
   
            }
            ?>
        </div>     

        <?php
    }

    public static function suppression($conf) {
        switch ($conf) {
            case 'suppSourceoperation':
                $codeunique = '';
                if (isset($_GET['id']))
                    $codeunique = $_GET['id'];
                $S = new sourceoperation($codeunique);
                $S->suppSourceoperation();
                break;
            case 'suppstructure':
                $id = 0;
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new structure($id);
                $S->suppStructure();
                break;

            case 'suppprofil':
                $id = 0;
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new profil($id);
                $S->suppProfil();
                break;

            case 'suppUserProfil':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new userprofil("");
                $S->suppUserProfil($id); //id=idutilisateur+idprofil
                break;

            case 'suppMenuProfil':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new menuprofil("");
                $S->suppMenuProfil($id); //idmenu+idprofil
                break;

            case 'suppOperationfinanciere':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new operationfinanciere($id);               // Functions::afficheBoiteMsg($id);
                $S->suppOperationfinanciere(); //idmenu+idprofil
                break;
            case 'suppRubriqueAssocie':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new rubriqueassocie($id);
                $S->suppRubriqueAssocie($id); //idmenu+idprofil
                break;

            case 'suppRubriques':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new rubriques($id);
                $S->suppRubriques(); //idmenu+idprofil
                break;

            case 'supprelementccial':
                $id = ""; 
                if (isset($_GET['id']))
                    $id = $_GET['id']; //Functions::afficheBoiteMsg($id);
                $S = new elementcommercial($id);
                $S->suppElementcommercial(); 
                break;

            case 'suppTypepiece':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new typepiece($id);
                $S->suppTypepiece(); //idmenu+idprofil
                break;

            case 'suppCompte':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new compte($id);
                $S->suppCompte();
                break;

            case 'suppDomaineActivite':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new domaineactivite($id);
                $S->suppDomaineActivite();
                break;

            case 'suppConditionReglement':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new conditionreglement($id);
                $S->suppConditionReglement();
                break;

            case 'suppDepot':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new depot($id);
                $S->suppDepot();
                break;

            case 'suppRepresentant':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new representant($id);
                $S->suppRepresentant();
                break;

            case 'suppTaxe':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new taxe($id);
                $S->suppTaxe();
                break;

            case 'suppProvenance':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new provenance($id);
                $S->suppProvenance();
                break;

            case 'suppfonction':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new fonction($id);
                $S->suppFonction();
                break;
            case 'supppersonne':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new personne($id);
                $S->suppPersonne();
                break;
            case 'supppresence':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new presence($id);
                $S->suppPresence();
                break;
            case 'suppabsence':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new absence($id);
                $S->suppAbsence();
                break;
            case 'suppprevision':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new previsiontache($id);
                $S->suppPrevision();
                break;
            case 'suppobjectif':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new objectifsjr($id);
                $S->suppObjectif();
                $dobj = new detailsobjectif("");
                $dobj->suppDetailsObjectif($id);
                break;
            case 'suppsuivitache':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new suivitache($id);
                $S->suppSuiviTache();
                break;
            case 'supprapports':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new rapports($id);
                $S->suppRapports();
                break;
            case 'suppprogram':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new programme($id);
                $S->suppProgramme();
                break;
            case 'suppdetailsprogram':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new detailsprogram($id);
                $S->suppDetailsProgramme();
                break;
            case 'suppplanning':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new planning($id);
                $S->suppPlanning();
                break;
            case 'suppprime':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new suiviprime($id);
                $S->suppSuiviPrime();
                break;
            case 'suppcontrat':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new contrat($id);
                $S->suppContrat();
                break;
            case 'suppanneeacademik':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new anneeacademique($id);
                $S->suppAnneeAcademik();
                break;
            case 'supptitre':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new titre($id);
                $S->suppTitre();
                break;
            case 'supptypenote':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new typenote($id);
                $S->suppTypeNote();
                break;
            case 'supptypepunition':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new typepunition($id);
                $S->suppTypePunition();
                break;
            case 'supppunition':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new punition($id);
                $S->suppPunition();
                break;
            case 'suppnotes':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new notes($id);
                $S->suppNotes();
                break;

            case 'supprbanque':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new banque($id);
                $S->suppBanque();
                break;

            case 'supprparamcomptelt':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new paramcomptelt($id);
                $S->suppParamcomptelt();
                break;

            case 'supprcivilite':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new civilite($id);
                $S->suppCivilite();
                break;

            case 'supprunite':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new unite($id);
                $S->suppUnite();
                break;

            case 'supprpromotion':
                $id = "";
                if (isset($_GET['id']))
                    $id = $_GET['id'];
                $S = new promotion($id);
                $S->suppPromotion();
                break;
        }
    }

    public static function initNumero($deb, $col, $table) {
        $num = $deb;
        $n = 0;
        $rekete = "SELECT " . $col . " FROM " . $table . "  WHERE " . $col . " LIKE '" . $deb . "%' ORDER BY id DESC ";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $n = (int) substr($list[$col], -4);
        }
        $n++;
        if ($n < 10) {
            $num .= "000";
        } else if ($n < 100) {
            $num .= "00";
        } else if ($n < 1000) {
            $num .= "0";
        }
        $num .= $n;
        return $num;
    }

    public static function initCodeunique($deb, $col, $table) {
        $num = $deb;
        $n = 0;
        $rekete = "SELECT  " . $col . ",id  FROM " . $table . "  WHERE " . $col . " LIKE '" . $deb . "%' ORDER BY id DESC ";        //echo $rekete;
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            if ($list[$col] != '')
                list($m, $n) = explode($deb, $list[$col]);
            //$n =  (int) $n;            
        }
        $n++;
        $num .= $n;
        return $num;
    }

    public static function actualiseCodeunique($table) {
        $netbios = gethostname();
        $rekete = "UPDATE " . $table . " SET codeunique =  CONCAT('" . $netbios . "', id )";
        $result = Functions::commit_sql($rekete, "");       // echo $rekete;
        if ($result) {
            return '1';
        } else {
            return '0';
        }
    }

    public static function changeCleEtrangere($table, $colonne) {
        return "ALTER TABLE  " . $table . " CHANGE  " . $colonne . "   " . $colonne . " TEXT NOT NULL ;";
    }

    public static function actualiseCodeuniqueLiaison($table) {
        $netbios = gethostname();
        $rekete = "";
        $col = array();

        switch ($table) {

            case 'compte':
                $col = array("idmere");
                break;
            case 'fonction':
            case 'objectifsjr':
            case 'rapports':
                $col = array("idcreateur");
                break;
            case 'absence':
            case 'contrat':
            case 'presence':
            case 'suiviprime':
            case 'suivitache':
                $col = array("idpersonne", "idcreateur");
                break;
            case 'destinataire':
                $col = array("idnotification", "iddestinataire");
                break;
            case 'echeancier':
                $col = array("idcontrat", "idcreateur");
                break;
            case 'notification':
                $col = array("expediteur", "idelement");
                break;
            case 'anneeacademique':
                $col = array("idanneedebut", "idanneefin", "idcreateur");
                break;
            case 'demandetravaux':
                $col = array("iddemandeur", "idlocalite", "idcreateur");
                break;
            case 'detailsobjectif':
                $col = array("idobjectif", "idprevisiontache", "idcreateur");
                break;
            case 'detailsprogram':
                $col = array("idprogramme", "idniveausuperieur", "idcreateur");
                break;
            case 'droitacces':
                $col = array("idprofil", "idelement");
                break;
            case 'localite':
                $col = array("idlocalitemere", "idcreateur");
                break;

            case 'operationfinanciere':
                $col = array("idrubrique", "idtypeoperation", "idtypepiece", "idsource", "idbeneficiaire", "idcompte", "iddomaine", "idprovenance", "idemetteur", "idcreateur");
                break;
            case 'personne':
                $col = array("idfonction", "idcreateur");
                break;
            case 'planning':
                $col = array("idpersonne", "iddetailsprogram", "idcreateur");
                break;

            case 'previsiontache':
                $col = array("idannee", "idpersonnehelp", "idcreateur");
                break;
            case 'programme':
                $col = array("idanneeacademique", "idcreateur");
                break;
            case 'rubriqueassocie':
                $col = array("idrubrique", "idtypeoperationfinanciere");
                break;
            case 'rubriques':
                $col = array("idtypeoperation");
                break;
            case 'structure':
                $col = array("idlocalite", "idstructuremere", "idchefstructure", "idcreateur");
                break;
            case 'utilisateurprofil':
                $col = array("idUtilisateur", "idProfil", "idcreateur");
                break;
            case 'utilisateur':
                $col = array("idstructure", "idcreateur");
                break;
        }
        //Exécution 
        foreach ($col as $v) {
            $colonne = $v;
            $rekete .= principale::changeCleEtrangere($table, $colonne);
            $rekete .= "UPDATE " . $table . " SET " . $colonne . " =  CONCAT('" . $netbios . "', " . $colonne . " ) ;"; // echo $rekete;
        }


        $result = Functions::commit_sql($rekete, "");       // echo $rekete;
        if ($result) {
            return '1';
        } else {
            return '0';
        }
    }

   public static function ajoutReketeSynchro($librekete) {

        Functions::RegisterReketePourSynchro($librekete);
        return '1';
    }


    public static function soldeParsource($idsource) {
        $solde = 0;
        $rekete = "SELECT ((SELECT SUM(montant) FROM operationfinanciere WHERE nature = 1 AND idsource ='" . $idsource . "')- ";
        $rekete .= "(SELECT SUM(montant) FROM operationfinanciere WHERE nature = 2 AND idsource ='" . $idsource . "')) AS solde";
        $result = Functions::commit_sql($rekete, "");       // Functions::afficheBoiteMsg($rekete);
        if (($result != '')) {
            $ls = $result->fetch();
            $solde = $ls['solde'];
        }
        return$solde;
    }

    public static function ajoutcolonneCodeunique($table) {
        $rekete = "ALTER TABLE  " . $table . " ADD  `codeunique` TEXT NOT NULL AFTER  `id`";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            return '1';
        } else {
            return '0';
        }
    }

    public static function majBD() {
        $rekete = "SHOW TABLES FROM tecmavs";
        $result = Functions::commit_sql($rekete, "");
        $tab = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $tab[$i] = $list['Tables_in_tecmavs'];
                $i++;
            }
        }

        foreach ($tab as $v) {
            $table = $v;
            if (($v != 'niveauprogram') && ($v != 'sexe') && ($v != 'situationmatri') && ($v != 'element') && ($v != 'typelocalite') && ($v != 'mois') && ($v != 'titre') && ($v != 'menu') && ($v != 'priorite') && ($v != 'reketesynchro') && ($v != 'typeelementbat') && ($v != 'typemouvement') && ($v != 'typeperiode') && ($v != 'typepersonne') && ($v != 'typestructure') && ($v != 'unite')) {
                //Ajout de colonne codeunique
                $addcol = principale::ajoutcolonneCodeunique($table);

                if ($addcol == '1') {
                    //Actualise codeunique
                    $actucode = principale::actualiseCodeunique($table);
                }
                $actuliaison = principale::actualiseCodeuniqueLiaison($table);
            }
        }
    }

    public static function formCritere($conf) {        //Functions::afficheBoiteMsg($conf);
        $idtypeperiode = 1;
        if (isset($_SESSION['idtypeperiode']))
            $idtypeperiode = $_SESSION['idtypeperiode'];
        $idmois = mois::idMoisEncours();
        $idannee = annee::getIdAnneeEncours();
        if (isset($_SESSION["idmois"])) {
            $idmois = $_SESSION["idmois"];
        }
        if (isset($_SESSION["idannee"])) {
            $idannee = $_SESSION["idannee"];
        }
        $deb = date('d-m-Y');
        $fin = date('d-m-Y');
        if (isset($_SESSION["debut"])) {
            $deb = $_SESSION["debut"];
        }
        if (isset($_SESSION["fin"])) {
            $fin = $_SESSION["fin"];
        }
        $idconf = 0;
        switch ($conf) {
            case 'rapportfinancier':
                $idconf = 1;
                break;
        }
       
        ?> 
        <div id="info"></div>

        <div id="zoneadd">

        </div>

        <!-- Formulaire d'ajout de cotation -->
        <div class="validateTips"><p class="alert alert-info" style="width: 500px; " ><b>CRITERES DE SELECTION</b></p></div>
        <form class="form-horizontal" method="post" name="critere" id="formcritere" action="" >                    

            <div class="well well-large">  

                <div class="control-group">
                    <label class="control-label" for="debut"><strong>TYPE DE PERIODE (*)</strong></label>
                    <div class="controls">
                        <?php
                        $onchangetypeperiode = "JPrincipal.onChangecmbTypePeriode($idconf)";
                        echo Functions::LoadCombo("SELECT * FROM typeperiode ", "id", "libelle", "idtypeperiodecritere", "Sélectionnez l'élément", "250", $onchangetypeperiode, $idtypeperiode);
                        ?> 
                    </div>
                </div>
                <div class="control-group">
                    <table>
                        <tr>
                            <?php
                            switch ($idtypeperiode) {
                                case 1:
                                    ?> 
                                    <td style=" width:150px;">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM mois ", "id", "libelle", "idmoiscritere", "mois", "140", "", $idmois);
                                        ?>                                                                  
                                    </td>
                                    <td style=" width:150px;">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM annee ", "codeunique", "annee", "idanneecritere", "année", "100", "", $idannee);
                                        ?>                                                                  
                                    </td>
                                    <?php
                                    break;
                                case 2:
                                    ?> 
                                    <td style=" width:150px;">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM annee ", "codeunique", "annee", "idanneecritere", "année", "100", "", $idannee);
                                        ?>                                                                  
                                    </td>
                                    <?php
                                    break;
                                case 3:
                                    ?> 
                                    <td style=" width:150px;">
                                        <strong>PERIODE DU </strong>
                                    </td>
                                    <td style=" width:200px;">                                      
                                        <input type="text" style="height:30px; width:150px;" name="debutcritere" id="debutcritere" class="text ui-widget-content ui-corner-all date" value="<?php echo $deb; ?>" />

                                    </td>
                                    <td style=" width:60px;"> <strong> AU </strong> </td>
                                    <td style=" width:200px;">                                        
                                        <input type="text" style="height:30px; width:150px;" name="fincritere" id="fincritere" class="text ui-widget-content ui-corner-all date" value="<?php echo $fin; ?>" />
                                    </td>
                                    <?php
                                    break;
                            }
                            ?> 

                        </tr>
                    </table>                
                </div> 



                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JPrincipal.validerCritere('<?php echo $conf; ?>');" class="btn btn-small btn-success" value="Valider"/>
                    </div>
                </div>       

            </div>                         
        </form>

        <?php
    }

    public static function dernierCodeunique($deb, $col, $table) {
        $code = "";
        $rekete = "SELECT  " . $col . ",id  FROM " . $table . "  WHERE " . $col . " LIKE '" . $deb . "%' ORDER BY id DESC ";        //echo $rekete;
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $code = $list[$col];
        }

        return $code;
    }

    public static function suppressionPossible($table, $codeunique) {
        $r = 1;
        $rekete = "";
        switch ($table) {
            case 'rubriques':
                $rekete = "SELECT * FROM operationfinanciere WHERE idrubrique='" . $codeunique . "' ";
                break;
            case 'compte':
                $rekete = "SELECT * FROM operationfinanciere WHERE idrubrique='" . $codeunique . "' ";
                break;
            case 'elementcommercial':
                $rekete = "SELECT id FROM detailsdevis WHERE idelementccial='" . $codeunique . "' ";
                $rekete .= "UNION ( SELECT id FROM detailsouvrage WHERE idelementccial='" . $codeunique . "' )";
//                $rekete .= "UNION ( SELECT id FROM fournisseurelement WHERE idelement='" . $codeunique . "' )";
                $rekete .= "UNION ( SELECT id FROM mouvement WHERE idelementccial='" . $codeunique . "' )";
                break;
            case 'operationfinanciere':
//                $rekete = "SELECT id FROM detailsdevis WHERE idelementccial='" . $codeunique . "' ";
//                $rekete .= "UNION ( SELECT id FROM detailsouvrage WHERE idelementccial='" . $codeunique . "' )";
//                $rekete .= "UNION ( SELECT id FROM fournisseurelement WHERE idelement='" . $codeunique . "' )";
//                $rekete .= "UNION ( SELECT id FROM mouvement WHERE idelementccial='" . $codeunique . "' )";
                break;
        } //Functions::afficheBoiteMsg($rekete);
//        echo 'Merci  '.$rekete;
        if ($rekete != "") {
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                $ls = $result->fetch();
                if ($ls['id'] != '')
                    $r = 0;
            }
        }
        return $r;
    }

}
?>
 