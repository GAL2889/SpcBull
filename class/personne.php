<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class personne {

    var $id;
    var $codeunique;
    var $matricule;
    var $nom;
    var $prenom;
    var $nomjeunefille;
    var $idtypepersonne;
    var $telephone;
    var $email;
    var $idsexe;
    var $idsituationmatri;
    var $datenaissance;
    var $lieunaissance;
    var $adresse;
    var $idfonction;
    var $dateembauche;
    var $photo;
    var $numcnss;
    var $idtitreperscontact;
    var $nomperscontact;
    var $prenomperscontact;
    var $telperscontact;
    var $dateprobdepart;
    var $desactiver;
    var $fraisformation;
    var $societe;
    var $role;
    var $observations;

    public static function getTableName() {
        return "personne";
    }

    function __construct($codeunique) {
        $rekete = "SELECT * FROM " . static::getTableName() . " WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->matricule = $list["matricule"];
            $this->nom = $list["nom"];
            $this->prenom = $list["prenom"];
            $this->nomjeunefille = $list["nomjeunefille"];
            $this->idtypepersonne = $list["idtypepersonne"];
            $this->telephone = $list["telephone"];
            $this->email = $list["email"];
            $this->idsexe = $list["idsexe"];
            $this->idsituationmatri = $list["idsituationmatri"];
            $this->datenaissance = $list["datenaissance"];
            $this->lieunaissance = $list["lieunaissance"];
            $this->adresse = $list["adresse"];
            $this->idfonction = $list["idfonction"];
            $this->dateembauche = $list["dateembauche"];
            $this->photo = $list["photo"];
            $this->numcnss = $list["numcnss"];
            $this->idtitreperscontact = $list["idtitreperscontact"];
            $this->nomperscontact = $list["nomperscontact"];
            $this->prenomperscontact = $list["prenomperscontact"];
            $this->telperscontact = $list["telperscontact"];
            $this->dateprobdepart = $list["dateprobdepart"];
            $this->desactiver = $list["desactiver"];
            $this->fraisformation = $list["fraisformation"];
            $this->societe = $list["societe"];
            $this->role = $list["role"];
            $this->observations = $list["observations"];
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

    public function getMatricule() {
        return $this->matricule;
    }

    public function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getNomjeunefille() {
        return $this->nomjeunefille;
    }

    public function setNomjeunefille($nomjeunefille) {
        $this->nomjeunefille = $nomjeunefille;
    }

    public function getIdtypepersonne() {
        return $this->idtypepersonne;
    }

    public function setIdtypepersonne($idtypepersonne) {
        $this->idtypepersonne = $idtypepersonne;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIdsexe() {
        return $this->idsexe;
    }

    public function setIdsexe($idsexe) {
        $this->idsexe = $idsexe;
    }

    public function getIdsituationmatri() {
        return $this->idsituationmatri;
    }

    public function setIdsituationmatri($idsituationmatri) {
        $this->idsituationmatri = $idsituationmatri;
    }

    public function getDatenaissance() {
        return $this->datenaissance;
    }

    public function setDatenaissance($datenaissance) {
        $this->datenaissance = $datenaissance;
    }

    public function getLieunaissance() {
        return $this->lieunaissance;
    }

    public function setLieunaissance($lieunaissance) {
        $this->lieunaissance = $lieunaissance;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getIdfonction() {
        return $this->idfonction;
    }

    public function setIdfonction($idfonction) {
        $this->idfonction = $idfonction;
    }

    public function getDateembauche() {
        return $this->dateembauche;
    }

    public function setDateembauche($dateembauche) {
        $this->dateembauche = $dateembauche;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function getNumcnss() {
        return $this->numcnss;
    }

    public function setNumcnss($numcnss) {
        $this->numcnss = $numcnss;
    }

    public function getIdtitreperscontact() {
        return $this->idtitreperscontact;
    }

    public function setIdtitreperscontact($idtitreperscontact) {
        $this->idtitreperscontact = $idtitreperscontact;
    }

    public function getNomperscontact() {
        return $this->nomperscontact;
    }

    public function setNomperscontact($nomperscontact) {
        $this->nomperscontact = $nomperscontact;
    }

    public function getPrenomperscontact() {
        return $this->prenomperscontact;
    }

    public function setPrenomperscontact($prenomperscontact) {
        $this->prenomperscontact = $prenomperscontact;
    }

    public function getTelperscontact() {
        return $this->telperscontact;
    }

    public function setTelperscontact($telperscontact) {
        $this->telperscontact = $telperscontact;
    }

    public function getNomPrenom() {
        return $this->nom . " " . $this->prenom;
    }

    public function getDateprobdepart() {
        return $this->dateprobdepart;
    }

    public function setDateprobdepart($dateprobdepart) {
        $this->dateprobdepart = $dateprobdepart;
    }

    public function getDesactiver() {
        return $this->desactiver;
    }

    public function setDesactiver($desactiver) {
        $this->desactiver = $desactiver;
    }

    public function getFonction() {
        $lafonction = new fonction($this->idfonction);
        return $lafonction->getLibelle();
    }

    public function getFraisformation() {
        return $this->fraisformation;
    }

    public function setFraisformation($fraisformation) {
        $this->fraisformation = $fraisformation;
    }

    public function getSociete() {
        return $this->societe;
    }

    public function setSociete($societe) {
        $this->societe = $societe;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getObservations() {
        return $this->observations;
    }

    public function setObservations($observations) {
        $this->observations = $observations;
    }

    public static function nomPrenom($codeunique) {
        $p = new personne($codeunique);
        return $p->getNom() . ' ' . $p->getPrenom();
    }

    public function verifdoublon() {
        $condition = "matricule=? AND nom=? AND prenom=? AND idtypepersonne=? AND idsexe=?";
        $param = array($this->matricule, $this->nom, $this->prenom, $this->idtypepersonne, $this->idsexe);
        $result = Functions::get_record_byCondition("personne", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifdoublonmod() {
        $condition = "matricule=? AND nom=? AND prenom=? AND idtypepersonne=? AND idsexe=? AND codeunique <> ?";
        $param = array($this->matricule, $this->nom, $this->prenom, $this->idtypepersonne, $this->idsexe, $this->codeunique);
        $result = Functions::get_record_byCondition("personne", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
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

    public static function ajoutReketeSynchro($librekete) {
        $rekete = "INSERT INTO reketesynchro (rekete) VALUES('" . addslashes($librekete) . "');";        //echo $rekete;
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            return '1';
        } else {
            return '0';
        }
    }

    public function ajoutPersonne() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = personne::initCodeunique(gethostname(), 'codeunique', 'personne');
            $rekete = "INSERT INTO personne (codeunique,matricule,nom,prenom,nomjeunefille,";
            $rekete .= "idtypepersonne,telephone,email,idsexe,idsituationmatri,datenaissance,";
            $rekete .= "lieunaissance,adresse,idfonction,dateembauche,photo,numcnss,idtitreperscontact,";
            $rekete .= "nomperscontact,prenomperscontact,telperscontact,idcreateur,dateprobdepart,";
            $rekete .= "societe,role,observations) ";
            $rekete .= "VALUES('" . $this->codeunique . "','" . $this->matricule . "','" . $this->nom . "','";
            $rekete .= $this->prenom . "','" . $this->nomjeunefille . "','" . $this->idtypepersonne . "','";
            $rekete .= $this->telephone . "','" . $this->email . "','" . $this->idsexe . "','";
            $rekete .= $this->idsituationmatri . "','" . $this->datenaissance . "','";
            $rekete .= $this->lieunaissance . "','" . $this->adresse . "','" . $this->idfonction . "','";
            $rekete .= $this->dateembauche . "','" . $this->photo . "','" . $this->numcnss . "','";
            $rekete .= $this->idtitreperscontact . "','" . $this->nomperscontact . "','";
            $rekete .= $this->prenomperscontact . "','" . $this->telperscontact . "','";
            $rekete .= $_SESSION["user"]["codeunique"] . "', '" . $this->dateprobdepart . "', '";
            $rekete .= $this->societe . "', '" . $this->role . "', '" . $this->observations . "')";
            $result = Functions::commit_sql($rekete, "");           // Functions::afficheBoiteMsg($rekete);
            if ($result) {
                return personne::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function modifPersonne() {
        if (!$this->verifdoublonmod()) {
            $rekete = "UPDATE personne SET matricule='" . $this->matricule . "', nom='" . $this->nom;
            $rekete .= "', prenom='" . $this->prenom . "', nomjeunefille='" . $this->nomjeunefille;
            $rekete .= "', idtypepersonne='" . $this->idtypepersonne . "', ";
            $rekete .= "telephone='" . $this->telephone . "', email='" . $this->email . "', idsexe='";
            $rekete .= $this->idsexe . "', idsituationmatri='" . $this->idsituationmatri . "', datenaissance='";
            $rekete .= $this->datenaissance . "', lieunaissance='" . $this->lieunaissance . "', ";
            $rekete .= "adresse='" . $this->adresse . "', idfonction='" . $this->idfonction . "', dateembauche='";
            $rekete .= $this->dateembauche . "', photo='" . $this->photo . "', numcnss='" . $this->numcnss;
            $rekete .= "',idtitreperscontact='" . $this->idtitreperscontact . "',observations='" . $this->observations . "', ";
            $rekete .= " societe='" . $this->societe . "',role='" . $this->role . "',nomperscontact='";
            $rekete .= $this->nomperscontact . "',prenomperscontact='" . $this->prenomperscontact;
            $rekete .= "',telperscontact='" . $this->telperscontact . "', dateprobdepart= '" . $this->dateprobdepart . "' , fraisformation= '" . $this->fraisformation . "'  WHERE codeunique = '" . $this->codeunique . "'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                return personne::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function suppPersonne() {
        $rekete = "DELETE FROM personne WHERE codeunique = '" . $this->codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo personne::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function donnee($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["matricule"] = $list["matricule"];
                $affich[$i]["fraisformation"] = $list["fraisformation"];
                $affich[$i]["idtypepersonne"] = $list["idtypepersonne"];
                $affich[$i]["nom"] = $list["nom"];
                $affich[$i]["prenom"] = $list["prenom"];
                $affich[$i]["nomjeunefille"] = $list["nomjeunefille"];
                $affich[$i]["nomprenom"] = $list["nom"] . " " . $list["prenom"];
                $affich[$i]["telephone"] = $list["telephone"];
                $affich[$i]["email"] = $list["email"];
                $affich[$i]["idsexe"] = $list["idsexe"];
                $lesexe = new sexe($list["idsexe"]);
                $affich[$i]["sexe"] = $lesexe->getLibelle();
                $affich[$i]["idsituationmatri"] = $list["idsituationmatri"];
                $situationmatri = new situationmatri($list["idsituationmatri"]);
                $affich[$i]["situationmatri"] = $situationmatri->getLibelle();
                $affich[$i]["datenaissance"] = Functions::renvoiDate($list["datenaissance"], "d-m-Y");
                $affich[$i]["lieunaissance"] = $list["lieunaissance"];
                $affich[$i]["adresse"] = $list["adresse"];
                $affich[$i]["idfonction"] = $list["idfonction"];
                $lafonction = new fonction($list["idfonction"]);
                $affich[$i]["fonction"] = $lafonction->getLibelle();
                $affich[$i]["dateembauche"] = Functions::renvoiDate($list["dateembauche"], "d-m-Y");
                $affich[$i]["photo"] = $list["photo"];
                $affich[$i]["numcnss"] = $list["numcnss"];
                $affich[$i]["idtitreperscontact"] = $list["idtitreperscontact"];
                $affich[$i]["nomperscontact"] = $list["nomperscontact"];
                $affich[$i]["prenomperscontact"] = $list["prenomperscontact"];
                $affich[$i]["telperscontact"] = $list["telperscontact"];
                $affich[$i]["dateprobdepart"] = $list["dateprobdepart"];
                $affich[$i]["observations"] = $list["observations"];
                $affich[$i]["desactiver"] = $list["desactiver"];
                $affich[$i]["etat"] = $list['desactiver'] == 0 ? "Désactivé" : "Activé";
                if ($list["idtypepersonne"] == 2) {
                    $paye = personne::fraisRembourse($list['codeunique']);
                    $rest = $list["fraisformation"] - $paye;
                    $affich[$i]["fraisformationRest"] = $rest;
                }

                $i++;
            }
        }
        return $affich;
    }

    public static function personneParCritere($critere) {
        $rekete = "SELECT * FROM personne " . $critere;
        $result = Functions::commit_sql($rekete, "");
        echo 'Merci ' . $rekete;
        $affich = personne::donnee($result);
        return $affich;
    }

    public static function listPersonnePourCombo($critere) {
        $donnee = personne::personneParCritere($critere);
        $list = '';
        $i = 0;
        foreach ($donnee as $v) {
            if ($i > 0) {
                $list .= '-->';
            }
            $list .= $v['codeunique'] . '|' . $v['nomprenom'];
            $i++;
        }

        return $list;
    }

    public static function donneeImprimer($conf) {
        $orientation = 'L'; //paysage
        $borduretableau = 1; //Portrait par défaut        
        $hautdoc = array();
        $basdoc = array();
        $corps = "";
        $titre = personne::afficheTitre($conf);
        switch ($conf) {
            case 'personne':
                $nomfichier = "personnel"; // Ne pas dépasser 11 caractères au total sinon erreur
                $idtypersonne = 0;
                if (isset($_SESSION['idenreg']))
                    $idtypersonne = $_SESSION['idenreg'];
                $donnee = personne::getAllPersonneInfos($idtypersonne);
                break;
        }
        $listtitre = array("Matricule", "Nom Prénom", "Téléphone", "Adresse", "Fonction", "Date d'embauche", "Etat");
        $tabAlign = array("L", "L", "L", "L", "L", "L");
        $listcolonneBD = array("matricule", "nomprenom", "telephone", "adresse", "fonction", "dateembauche", "etat");
        $listlargeurtitre = array(20, 70, 30, 30, 40, 30, 30); //total 240

        return array($titre, $listtitre, $listcolonneBD, $listlargeurtitre, $nomfichier, $donnee, $orientation, $borduretableau, $hautdoc, $basdoc, $tabAlign, $corps);
    }

    public static function getAllPersonneInfos($idtypersonne = 0) {
        $rekete = "SELECT * FROM personne";
        if ($idtypersonne != 0) {
            $rekete.= " where idtypepersonne=" . $idtypersonne . "";
        }
        $rekete.=" order by nom";
        $result = Functions::commit_sql($rekete, "");
        $affich = personne::donnee($result);
        return $affich;
    }

    public static function getAllTechnicienActif() {
        $rekete = "SELECT * FROM personne where idtypepersonne=2 and desactiver=0";
        $rekete.=" order by nom";
        $result = Functions::commit_sql($rekete, "");
        $affich = personne::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'personne':
                $idtypersonne = 0;
                if (isset($_SESSION['idenreg']))
                    $idtypersonne = $_SESSION['idenreg'];
                $typersonne = new typepersonne($idtypersonne);
                if ($idtypersonne == 0) {
                    $titre = "Liste du personnel";
                } else {
                    $titre = "Liste du personnel (" . $typersonne->getLibelle() . ")";
                }
                break;

            case 'addpersonne':
                $titre = "Ajout de personne";
                break;

            case 'editpersonne':
                $titre = "Modification d'une personne";
                break;

            case 'fichPersonne':
                $titre = "Fiche individuelle";
                break;
            case 'fichecomplete':
                $titre = "Fiche individuelle complète";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = personne::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'personne':
                $idtypersonne = 0;
                if (isset($_SESSION['idtypepersonne']))
                    $idtypersonne = $_SESSION['idtypepersonne'];
                $donnee = personne::getAllPersonneInfos($idtypersonne);
                ?>      
                <div class="control-group">
                    <div class="controls">
                        <?php
                        $onchange = "JPersonne.onchangeCmbTypePersone();";
                        echo Functions::LoadCombo("SELECT * FROM typepersonne", "id", "libelle", "idtypepersonne", "Sélectionnez le type de personne", "210", $onchange, $idtypersonne);
                        ?>  
                    </div>
                </div>
                <div class="btn-toolbar">
                    <div class="btn-group pull-left">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addpersonne', '', '<?php echo $retour; ?>');" id="addprofil" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="print" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="export" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="info"></div>           

                <div id="zoneListeSite" data-spy="scroll" style="overflow-x: scroll">
                    <?php
                    personne::afficheListe($donnee, $idtypersonne);
                    ?>
                </div>
                <?php
                break;

            case 'addpersonne':
                $retour = 'personne';
                personne::formAddEdit($retour);
                break;

            case 'editpersonne':
                $retour = 'personne';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                personne::formAddEdit($retour, $id);
                break;

            case 'fichPersonne':
            case 'fichecomplete':
                $idpersonne = "";
                if (isset($_SESSION['idenreg']))
                    $idpersonne = $_SESSION['idenreg'];
                ?>      
                <div class="control-group">
                    <div class="controls">
                        <?php
                        $onchange = "JSuiviTache.onChangeCmbPersonne('" . $conf . "');";
                        echo Functions::LoadCombo("SELECT *, CONCAT(nom,' ',prenom)as nomprenom FROM personne where desactiver=0 order by nom", "codeunique", "nomprenom", "idpersonne", "Sélectionnez la personne", "210", $onchange, $idpersonne);
                        ?>  
                    </div>
                </div>
                <?php
                if ($conf == "fichPersonne") {
                    personne::formFicheIndividuelle($idpersonne);
                }
                if ($conf == "fichecomplete") {                   // Functions::afficheBoiteMsg($idpersonne);
                    personne::formFicheIndComplete($idpersonne);
                }

                break;
        }
    }

    public static function afficheListe($donnee, $idtypersonne = 0) {      //  Functions::afficheBoiteMsg($idtypersonne);
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune personne n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead><?php ?> 
                    <tr class="menu_gauche">
                        <?php if ($idtypersonne == 2) { ?> <th style="width:50px"><strong>Matricule</strong></th><?php } ?>
                        <th><strong>Nom Prénom</strong></th>
                        <th><strong>Téléphone</strong></th>
                        <!--<th><strong>Email</strong></th>-->
                        <!--<th><strong>Sexe</strong></th>-->
                        <!--<th><strong>Situation matrimoniale</strong></th>-->
                        <!--<th><strong>Date de naissance</strong></th>-->
                        <!--<th><strong>Lieu de naissance</strong></th>-->
                        <th><strong>Adresse</strong></th>
                        <th><strong>Fonction</strong></th>
                        <th style="width:80px"><strong>Date d'embauche</strong></th>
                        <?php if ($idtypersonne == 2) { ?>  <th><strong>Frais de formation<br>(Reste à payer)</strong></th><?php } ?>
                        <th style="width:120px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>              
                            <?php if ($idtypersonne == 2) { ?> <td><?php echo $v['matricule'] ?></td><?php } ?>
                            <td><?php echo $v['nomprenom'] ?></td>
                            <td><?php echo $v['telephone'] ?></td>
                            <!--<td><?php echo $v['email'] ?></td>-->
                            <!--<td><?php echo $v['sexe'] ?></td>-->
                            <!--<td><?php echo $v['situationmatri'] ?></td>-->
                            <!--<td><?php echo $v['datenaissance'] ?></td>-->
                            <!--<td><?php echo $v['lieunaissance'] ?></td>-->
                            <td><?php echo $v['adresse'] ?></td>
                            <td><?php echo $v['fonction'] ?></td>
                            <td><?php echo $v['dateembauche'] ?></td>
                            <?php if ($idtypersonne == 2) { ?> <td>
                                    <?php
                                    if ($v['fraisformationRest'] == 0) {
                                        echo "";
                                    } else {
                                        echo functions::formatnombre($v['fraisformationRest']);
                                    }
                                    ?>
                                </td><?php } ?>

                            <td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">

                                        <li>                                            
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editpersonne', '', '');" style="margin-right: 5px;" title="Modifier"><i class="icon-edit"></i> Modifier</a>
                                        </li>
                                        <li>                                            
                                            <a href="#" class="btn btn-small btn-danger" onclick="JPersonne.suppPersonne('<?php echo $v['codeunique']; ?>');" style="margin-right: 5px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i>Supprimer</a>
                                        </li>
                                        <?php
                                        if ($v['desactiver'] == 0) {
                                            ?>
                                            <li> 
                                                <a href="#" onclick="JPersonne.desactiver('<?php echo $v['codeunique'] ?>');" style="margin-right: 5px;">
                                                    <img src="images/Activate.jpg" style="width: 16px; height: 16px" alt="Mettre en veille" title="Mettre en veille"/>Mettre en veille
                                                </a>
                                            </li>
                                            <?php
                                        } else {
                                            ?>
                                            <li> 
                                                <a href="#" onclick="JPersonne.activer('<?php echo $v['codeunique'] ?>');" style="margin-right: 5px;">
                                                    <img src="images/Desactivate.jpg" alt="Activer" title="Activer" style="width: 16px; height: 16px"/>Activer
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        if ($v['idtypepersonne'] == 2) {
                                            ?>
                                            <li> 
                                                <a href="#" class="btn btn-small btn-info" onclick="JPersonne.fraisFormation('<?php echo $v['codeunique'] ?>');" style="margin-right: 5px;" title="Frais de formation"><i class="icon-book"></i>Frais de formation</a>
                                            </li>
                                            <?php
                                        }
                                        ?> 

                                    </ul>
                                </div>
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

    public static function formAddEdit($retour, $id = "") {
        $matricule = parametre::numeroMatriculeencoursParId(1);
        $idtypepersonne = 0;
        $nom = "";
        $prenom = "";
        $nomjeunefille = "";
        $telephone = "229";
        $email = "";
        $idsexe = 0;
        $idsituationmatri = 0;
        $datenaissance = "";
        $lieunaissance = "";
        $adresse = "";
        $idfonction = 0;
        $dateembauche = "";
        $datedepart = "";
        $photo = "images/photo/";
        $numcnss = "";
        $idtitre = 0;
        $nomPC = "";
        $fraisForm = 0;
        $prenomPC = "";
        $telPC = "229";
        $observations = "";
        $action = "addPersonne";
        if ($id != "") {
            $S = new personne($id);
            $matricule = $S->getMatricule();
            $idtypepersonne = $S->getIdtypepersonne();
            $nom = $S->getNom();
            $prenom = $S->getPrenom();
            $nomjeunefille = $S->getNomjeunefille();
            $telephone = $S->getTelephone();
            $email = $S->getEmail();
            $idsexe = $S->getIdsexe();
            $idsituationmatri = $S->getIdsituationmatri();
            $datenaissance = Functions::renvoiDate($S->getDatenaissance(), "d-m-Y");
            $lieunaissance = $S->getLieunaissance();
            $adresse = $S->getAdresse();
            $idfonction = $S->getIdfonction();
            $dateembauche = Functions::renvoiDate($S->getDateembauche(), "d-m-Y");
            $datedepart = Functions::renvoiDate($S->getDateprobdepart(), "d-m-Y");
            $photo = "images/photo/" . $S->getPhoto();
            $numcnss = $S->getNumcnss();
            $idtitre = $S->getIdtitreperscontact();
            $nomPC = $S->getNomperscontact();
            $prenomPC = $S->getPrenomperscontact();
            $telPC = $S->getTelperscontact();
            $action = "editPersonne";
            $fraisForm = $S->getFraisformation();
            $observations = $S->getObservations();
        }

        if ($retour == 'personne') {
            ?> 
            <p>
                <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allsecteur" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
            </p> 
        <?php }
        ?>

        <div id="info"></div>

        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form  method="post" name="formaddeditPersonne" id="formaddeditPersonne" action="traitement/personne.php" enctype="multipart/form-data">                    
            <div class="well well-large"> 
                <div class="control-group pull-right">
                    <!--<div class="controls">-->                        
                    <input type="button" onclick="JPersonne.validerPersonne('<?php echo $id; ?>');" class="btn btn-small btn-info" value="Enregistrer"/>
                    <!--</div>-->
                </div>   
                <fieldset style="width: 650px;" class="form-inline">
                    <legend>  <font color="#8dd8ff"> Etat Civil </font> </legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="nom"><strong>Nom (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('nom', 0);" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $nom; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="prenom"><strong>Prénom (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('prenom', 1);" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $prenom; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fileupload fileupload-new pull-right" data-provides="fileupload">
                                    <div class="fileupload-preview thumbnail" style="width:120px; height:120px;">
                                        <img src="<?php echo $photo ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fileupload fileupload-new pull-right" data-provides="fileupload">
                                    <div>
                                        <span class="btn btn-file btn-info"><span class="fileupload-new">Choisir photo</span>
                                            <span class="fileupload-exists">Changer</span><input type="file" name="photo" id="photo" /></span>
                                        <a href="<?php echo $photo ?>" class="btn fileupload-exists btn-info" data-dismiss="fileupload">Supprimer</a>
                                    </div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="nomjeunefille"><strong>Nom de jeune fille</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('nomjeunefille', 0);" name="nomjeunefille" id="nomjeunefille" class="text ui-widget-content ui-corner-all" value="<?php echo $nomjeunefille; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idsexe"><strong>Sexe (*)</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM sexe", "id", "libelle", "idsexe", "Sélectionnez le sexe", "210", "", $idsexe);
                                        ?>  
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idsituationmatri"><strong>Situation matrimoniale (*)</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM situationmatri", "id", "libelle", "idsituationmatri", "Sélectionnez la situation matrimoniale", "200", "", $idsituationmatri);
                                        ?>  
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="datenaissance"><strong>Date de naissance (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="datenaissance" id="datenaissance" class="text ui-widget-content ui-corner-all date" onchange="Verif_Date('datenaissance');" value="<?php echo $datenaissance; ?>" />
                                    </div>
                                </div> 
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="lieunaissance"><strong>Lieu de naissance (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('lieunaissance', 1);" name="lieunaissance" id="lieunaissance" class="text ui-widget-content ui-corner-all" value="<?php echo $lieunaissance; ?>" />
                                    </div>
                                </div>   
                            </td>
                        </tr>
                    </table>


                </fieldset>

                <fieldset style="width: 650px;">
                    <legend><font color="#8dd8ff">Professionel</font></legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="matricule"><strong>Matricule (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" readonly name="matricule" id="matricule" class="text ui-widget-content ui-corner-all" value="<?php echo $matricule; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="numcnss"><strong>Numéro CNSS </strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="numcnss" id="numcnss" class="text ui-widget-content ui-corner-all" value="<?php echo $numcnss; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="dateembauche"><strong>Date d'embauche (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="dateembauche" id="dateembauche" class="text ui-widget-content ui-corner-all date" onchange="Verif_Date('dateembauche');
                                            JPersonne.onChangeDateEmbauche();" value="<?php echo $dateembauche; ?>" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="dateprobdepart"><strong>Date probable de départ </strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="dateprobdepart" id="dateprobdepart" class="text ui-widget-content ui-corner-all date" value="<?php echo $datedepart; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idtypepersonne"><strong>Categorie (*)</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM typepersonne", "id", "libelle", "idtypepersonne", "Sélectionnez la catégorie", "210", "", $idtypepersonne);
                                        ?>  
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idfonction"><strong>Fonction (*)</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM fonction order by libelle", "codeunique", "libelle", "idfonction", "Sélectionnez la fonction", "210", "", $idfonction);
                                        ?>  
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        //Functions::afficheBoiteMsg($id.' '.$idtypepersonne);
                        if (($id != '') && ($idtypepersonne == 2)) {
                            ?>
                            <tr>
                                <td>
                                    <div class="control-group">
                                        <label class="control-label" for="fraisformation"><strong>Frais de formation </strong></label>
                                        <div class="controls">
                                            <input type="text" style="height:30px; width:210px;" name="fraisformation" id="fraisformation" class="text ui-widget-content ui-corner-all" value="<?php echo Functions::formatnombre($fraisForm); ?>" />
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="control-group">
                                        <label class="control-label" for="notes"><strong>Notes </strong></label>
                                        <div class="controls">
                                            <textarea rows="2" style="width:420px;" onkeyup="JPrincipal.enMajuscule('observations', 1);"  name="observations" id="observations" class="text ui-widget-content ui-corner-all" placeholder="Saisir de notes"><?php echo $observations; ?></textarea>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </fieldset>

                <fieldset style="width: 650px;">
                    <legend><font color="#8dd8ff">Contact agent</font></legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="telephone"><strong>Téléphone (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value="<?php echo $telephone; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="email"><strong>Email</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value="<?php echo $email; ?>" />
                                    </div>
                                </div> 
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="adresse"><strong>Adresse (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('adresse', 1);" name="adresse" id="adresse" class="text ui-widget-content ui-corner-all" value="<?php echo $adresse; ?>" />
                                    </div>
                                </div>   
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <fieldset style="width: 650px;">
                    <legend><font color="#8dd8ff">Personne à contacter</font></legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idtitreperscontact"><strong>Titre</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM titre", "id", "libelle", "idtitreperscontact", "Sélectionnez le titre", "110", "", $idtitre);
                                        ?>  
                                    </div>
                                </div>  
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="nomperscontact"><strong>Nom</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('nomperscontact', 0);" name="nomperscontact" id="nomperscontact" class="text ui-widget-content ui-corner-all" value="<?php echo $nomPC; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="prenomperscontact"><strong>Prénom</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('prenomperscontact', 1);" name="prenomperscontact" id="prenomperscontact" class="text ui-widget-content ui-corner-all" value="<?php echo $prenomPC; ?>" />
                                    </div>
                                </div> 
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="telperscontact"><strong>Téléphone</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="telperscontact" id="telperscontact" class="text ui-widget-content ui-corner-all" value="<?php echo $telPC; ?>" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </fieldset>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" size="32" /> 
                        <input type="hidden" name="action" id="action" value="<?php echo $action; ?>" size="32" /> 
                        <input type="hidden" name="retour" id="retour" value="<?php echo $retour; ?>" size="32" /> 
                        <input type="button" onclick="JPersonne.validerPersonne('<?php echo $id; ?>');" class="btn btn-small btn-info" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    static function formPersExterne($retour,$idtype, $codeunique = '') {
//        $idtype = 4;
        switch ($retour) {
            case 'adddemandetravaux':
                $idtype = 2;
                break;

        }
        $idsexe = "";
        $nom = "";
        $prenom = "";
        $telephone = "";
        $mail = "";
        $adresse = "";
        $societe = "";
        $role = "";
        if ($codeunique != '') {
            $S = new personne($codeunique);
            $idtype = $S->getIdtypepersonne();
            $idsexe = $S->getIdsexe();
            $nom = $S->getNom();
            $prenom = $S->getPrenom();
            $telephone = $S->getTelephone();
            $adresse = $S->getAdresse();
            $societe = $S->getSociete();
            $role = $S->getRole();
            $mail = $S->getEmail();
        }

        if ($retour == 'personne') {
            ?> 
            <p>
                <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allsecteur" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
            </p> 
            <?php
        }
        ?>
        <div id="info"></div>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddedit" id="formaddedit" action="" >                    
            <div class="well well-large">               
                <input type="hidden" name="idtypepersonne" id="idtypepersonne" value="<?php echo $idtype; ?>" size="32" />
                <fieldset style="width: 650px;" class="form-inline">
                    <legend>  <font color="#8dd8ff"> Etat Civil </font> </legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="nom"><strong>Nom (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('nom', 0);" name="nom" id="nom" class="text ui-widget-content ui-corner-all" value="<?php echo $nom; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="prenom"><strong>Prénom </strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('prenom', 1);" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all" value="<?php echo $prenom; ?>" />
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="idsexe"><strong>Sexe (*)</strong></label>
                                    <div class="controls">
                                        <?php
                                        echo Functions::LoadCombo("SELECT * FROM sexe", "id", "libelle", "idsexe", "Sélectionnez le sexe", "210", "", $idsexe);
                                        ?>  
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="societe"><strong>Nom de sa société</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('societe', 0);" name="societe" id="societe" class="text ui-widget-content ui-corner-all" value="<?php echo $societe; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="role"><strong>Fonction</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('role', 0);" name="role" id="role" class="text ui-widget-content ui-corner-all" value="<?php echo $role; ?>" />
                                    </div>
                                </div>
                            </td>


                        </tr>

                    </table>


                </fieldset>

                <fieldset style="width: 650px;">
                    <legend><font color="#8dd8ff">Contact agent</font></legend>
                    <table>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="telephone"><strong>Téléphone (*)</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value="<?php echo $telephone; ?>" />
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="email"><strong>Email</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" name="email" id="email" class="text ui-widget-content ui-corner-all" value="<?php echo $mail; ?>" />
                                    </div>
                                </div> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-group">
                                    <label class="control-label" for="adresse"><strong>Adresse</strong></label>
                                    <div class="controls">
                                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('adresse', 1);" name="adresse" id="adresse" class="text ui-widget-content ui-corner-all" value="<?php echo $adresse; ?>" />
                                    </div>
                                </div>   
                            </td>

                        </tr>
                    </table>
                </fieldset>


                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JRubriques.valider('<?php echo $codeunique; ?>', 'validerPersExterne', '<?php echo $retour; ?>');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>                        
        <?php
    }

    public static function validerPersExterne($champ) {
        list($codeunique, $idtypepersonne, $nom, $prenom, $idsexe, $societe, $role, $telephone, $email, $adresse, $retour) = explode('|', $champ);
//        Functions::afficheBoiteMsg($retour);
//Enregistregment de la notification
        $S = new personne($codeunique);
        $S->setIdtypepersonne($idtypepersonne);
        $S->setNom(addslashes($nom));
        $S->setPrenom(addslashes($prenom));
        $S->setIdsexe($idsexe);
        $S->setSociete($societe);
        $S->setRole($role);
        $S->setTelephone($telephone);
        $S->setEmail($email);
        $S->setAdresse($adresse);
        if ($codeunique == '') {
            $result = $S->ajoutPersonne();
        } else {
            $result = $S->modifPersonne();
        }

        switch ($result) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
//                if($retour=='')
                ?>
                <script>
                    $("#zonemodal").dialog("close");
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne a été enregistrée avec succès. </div>').fadeIn(1000).fadeOut(300);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    public static function validerPersonne($id, $retour) {
        $personne = new personne($id);
        $personne->setMatricule($_GET['matricule']);
        $personne->setNom($_GET['nom']);
        $personne->setPrenom($_GET['prenom']);
        if (isset($_GET['nomjeunefille'])) {
            $personne->setNomjeunefille($_GET['nomjeunefille']);
        }
        $personne->setIdtypepersonne($_GET['idtypepersonne']);
        $personne->setTelephone($_GET['telephone']);
        $personne->setEmail($_GET['email']);
        $personne->setIdsexe($_GET['idsexe']);
        $personne->setIdsituationmatri($_GET['idsituationmatri']);
        $personne->setDatenaissance(Functions::renvoiDate($_GET['datenaissance'], "Y-m-d"));
        $personne->setLieunaissance($_GET['lieunaissance']);
        $personne->setAdresse($_GET['adresse']);
        $personne->setIdfonction($_GET['idfonction']);
        $personne->setDateembauche(Functions::renvoiDate($_GET['dateembauche'], "Y-m-d"));
        $personne->setNumcnss($_GET['numcnss']);
        $personne->setIdtitreperscontact($_GET['idtitreperscontact']);
        $personne->setNomperscontact($_GET['nomperscontact']);
        $personne->setPrenomperscontact($_GET['prenomperscontact']);
        $personne->setTelperscontact($_GET['telperscontact']);
        $imag = "";
        switch ($_GET['idsexe']) {
            case '2':
                $imag = "user.jpg";
                break;
            case '1':
                $imag = "femme.jpg";
                break;
        }

// functions::afficheBoiteMsg($_FILES['photo']);
//traitement de la photo
        $msg = "";
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

            if ($_FILES['photo']['size'] <= 8000000) {
                $infosfichier = pathinfo($_FILES['photo']['photo']);
                $extension = $infosfichier['extension'];
                $basename = $infosfichier['basename'];
//                functions::afficheBoiteMsg($basename);
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension, $extensions_autorisees)) {

                    $nomphoto = str_replace(" ", "_", $_GET['nom'] . "_" . $_GET['prenom']);

                    if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $basename)) {
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
            $savefile = 4;
            $msg = "";
            $personne->setPhoto($imag);
        }

        if ($msg == "") {

            $result = 0;
            if ($id == "") {
                $result = $personne->ajoutPersonne();
                if ($result == '1')
                    parametre::actualiseMatriculeencours(1);
            } else {
                $result = $personne->modifPersonne();
            }
            switch ($result) {
                case '0':
                    ?>
                    <script>
                        $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                    </script>
                    <?php
                    break;

                case '1':
                    ?>
                    <script>
                        $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne a été enregistrée avec succès. </div>').fadeIn(1000);
                        JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                    </script>
                    <?php
                    break;

                case '2':
                    ?>
                    <script>
                        $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La personne que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                    </script>
                    <?php
                    break;
            }
        } else {
            ?>
            <script>
                alert("<?php echo $msg; ?>");
            </script>
            <?php
        }
    }

    public static function formFicheIndividuelle($idpersonne) {
        $lapersonne = new personne($idpersonne);
        ?>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Etat Civil </font> </legend>
            <div class="fileupload fileupload-new pull-right" data-provides="fileupload">
                <div class="fileupload-preview thumbnail" style="width:120px; height:120px;">
                    <img src="<?php echo "images/photo/" . $lapersonne->getPhoto(); ?>"/>
                </div>
            </div>
            <label class="control-label">Nom prénom: <strong><?php echo $lapersonne->getNomPrenom() ?></strong></label>
            <label class="control-label">Nom jeune fille:<strong> <?php echo $lapersonne->getNomjeunefille() ?></strong></label>
            <label class="control-label">
                Sexe: 
                <strong>
                    <?php
                    $sexe = new sexe($lapersonne->getIdsexe());
                    echo $sexe->getLibelle();
                    ?>
                </strong>
            </label>
            <label class="control-label">
                Situation Matrimoniale:
                <strong>
                    <?php
                    $sitmatri = new situationmatri($lapersonne->getIdsituationmatri());
                    echo $sitmatri->getLibelle();
                    ?>
                </strong>
            </label>
            <label class="control-label">Date de naissance:<strong> <?php echo functions::renvoiDate($lapersonne->getDatenaissance(), "d-m-Y") ?></strong></label>
            <label class="control-label">Lieu de naissance:<strong> <?php echo $lapersonne->getLieunaissance() ?></strong></label>
        </fieldset>


        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Contact  de l'agent</font> </legend>
            <label class="control-label">Téléphone:<strong> <?php echo $lapersonne->getTelephone() ?></strong></label>
            <label class="control-label">Email:<strong> <?php echo $lapersonne->getEmail() ?></strong></label>
            <label class="control-label">Adresse:<strong> <?php echo $lapersonne->getAdresse() ?></strong></label>
        </fieldset>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Personne à contacter </font> </legend>
            <label class="control-label">
                Titre: 
                <strong>
                    <?php
                    $titre = new titre($lapersonne->getIdtitreperscontact());
                    echo $titre->getLibelle()
                    ?>
                </strong>
            </label>
            <label class="control-label">Nom prénom<strong>: <?php echo $lapersonne->getNomperscontact() . " " . $lapersonne->getPrenomperscontact() ?></strong></label>
            <label class="control-label">Téléphone:<strong> <?php echo $lapersonne->getTelperscontact() ?></strong></label>
        </fieldset>

        <?php
    }

    public static function formFicheIndComplete($idpersonne) {
        $lapersonne = new personne($idpersonne);
        ?>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Etat Civil </font> </legend>
            <div class="fileupload fileupload-new pull-right" data-provides="fileupload">
                <div class="fileupload-preview thumbnail" style="width:120px; height:120px;">
                    <img src="<?php echo "images/photo/" . $lapersonne->getPhoto(); ?>"/>
                </div>
            </div>
            <label class="control-label">Nom prénom:<strong> <?php echo $lapersonne->getNomPrenom() ?></strong></label>
            <label class="control-label">Nom jeune fille:<strong> <?php echo $lapersonne->getNomjeunefille() ?></strong></label>
            <label class="control-label">
                Sexe:<strong>
                    <?php
                    $sexe = new sexe($lapersonne->getIdsexe());
                    echo $sexe->getLibelle();
                    ?>
                </strong>
            </label>
            <label class="control-label">
                Situation Matrimoniale:  <strong>
                    <?php
                    $sitmatri = new situationmatri($lapersonne->getIdsituationmatri());
                    echo $sitmatri->getLibelle();
                    ?>
                </strong>
            </label>
            <label class="control-label">Date de naissance: <strong><?php echo functions::renvoiDate($lapersonne->getDatenaissance(), "d-m-Y") ?></strong></label>
            <label class="control-label">Lieu de naissance:<strong> <?php echo $lapersonne->getLieunaissance() ?></strong></label>
        </fieldset>

        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Professionnel </font> </legend>
            <label class="control-label">Matricule:<strong> <?php echo $lapersonne->getMatricule() ?></strong></label>
            <label class="control-label">Numéro CNSS:<strong> <?php echo $lapersonne->getNumcnss() ?></strong></label>
            <label class="control-label">
                Catégorie: <strong>
                    <?php
                    $typepers = new typepersonne($lapersonne->getIdtypepersonne());
                    echo $typepers->getLibelle()
                    ?>
                </strong>
            </label>
            <label class="control-label">
                Fonction:<strong> 
                    <?php
                    $fonct = new fonction($lapersonne->getIdfonction());
                    echo $fonct->getLibelle();
                    ?>
                </strong>
            </label>
            <label class="control-label">Date d'embauche:<strong> <?php echo functions::renvoiDate($lapersonne->getDateembauche(), "d-m-Y") ?></strong></label>
            <label class="control-label">Date de départ:<strong> <?php echo functions::renvoiDate($lapersonne->getDateprobdepart(), "d-m-Y") ?></strong></label>
            <?php
            if ($lapersonne->getIdtypepersonne() == 2) {
                $frs = Functions::formatnombre($lapersonne->getFraisformation());
                $paye = Functions::formatnombre(personne::fraisRembourse($idpersonne));
                $rest = str_replace(' ', '', $frs) - str_replace(' ', '', $paye);
                $rest = Functions::formatnombre($rest);
                ?>
                <label class="control-label">Frais de formation :<strong> <?php echo $frs; ?></strong> &nbsp; &nbsp;&nbsp;&nbsp;Total Remboursé : 
                    <strong> <?php echo $paye; ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;
                    Reste : <strong> <?php echo $rest; ?></strong>
                </label>
            <?php } ?>
        </fieldset>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Contact  de l'agent</font> </legend>
            <label class="control-label">Téléphone: <strong><?php echo $lapersonne->getTelephone() ?></strong></label>
            <label class="control-label">Email:<strong> <?php echo $lapersonne->getEmail() ?></strong></label>
            <label class="control-label">Adresse:<strong> <?php echo $lapersonne->getAdresse() ?></strong></label>
        </fieldset>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Personne à contacter </font> </legend>
            <label class="control-label">
                Titre:  <strong>
                    <?php
                    $titre = new titre($lapersonne->getIdtitreperscontact());
                    echo $titre->getLibelle()
                    ?>
                </strong>
            </label>
            <label class="control-label">Nom prénom:<strong> <?php echo $lapersonne->getNomperscontact() . " " . $lapersonne->getPrenomperscontact() ?></strong></label>
            <label class="control-label">Téléphone:<strong> <?php echo $lapersonne->getTelperscontact() ?></strong></label>
        </fieldset>
        <fieldset style="width: 650px;">
            <legend>  <font color="#8dd8ff"> Autres informations </font> </legend>
            <label class="control-label">Nombre de présence:<strong> <?php echo presence::getNbrePresence($idpersonne); ?></strong></label>
            <label class="control-label">Nombre d 'absence:<strong> <?php echo presence::getNbreAbsence($idpersonne); ?></strong></label>
            <label class="control-label">Nombre de retard:<strong> <?php echo presence::getNbreRetard($idpersonne); ?></strong></label>
            <label class="control-label">Prime: <strong><?php echo suiviprime::getPrimeDu($idpersonne) . " FCFA"; ?></strong></label>
        </fieldset>
        <?php
    }

    public static function desactPersonne($codeunique) {
        $rekete = "UPDATE personne SET desactiver=1 WHERE codeunique ='" . $codeunique . "' ";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function actiPersonne($codeunique) {
        $rekete = "UPDATE personne SET desactiver=0 WHERE codeunique ='" . $codeunique . "' ";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function fraisPersonne($codeunique, $frais) {
        $rekete = "UPDATE personne SET fraisformation='" . $frais . "' WHERE codeunique ='" . $codeunique . "' ";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function fraisRembourse($idpersonne) {
        $remb = 0;
        $rekete = "SELECT SUM(montant) AS total FROM operationfinanciere,rubriques ";
        $rekete .= "WHERE operationfinanciere.idrubrique = rubriques.codeunique AND idprovenance = '" . $idpersonne . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $ls = $result->fetch();
            if ($ls['total'] != '')
                $remb = $ls['total'];
        }
        return $remb;
    }

    public static function Birthday() {
        $affich = array();
        $rekete = "select * from  personne where idtypepersonne in (1,2) order by datenaissance";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $year = date("Y");
            $mois = date("m");
            $i = 0;
            while ($list = $result->fetch()) {
                $ladate = Functions::renvoiDate($list['datenaissance'], "d-m-Y");
//                $ConvertLadate = new DateTime($ladate);
//                $ConvertLadate = $ladate;                Functions::afficheBoiteMsg(Functions::renvoiDate($list['datenaissance'], "m"));
//                $lemois = $ConvertLadate->format("m");
                $lemois = Functions::renvoiDate($list['datenaissance'], "m");
                if ($mois == $lemois) {
                    $affich[$i]["nomprenom"] = $list['nom'] . " " . $list['prenom'];
                    $affich[$i]["datenaissance"] = Functions::renvoiDate($list['datenaissance'], "d-m-Y");
                    $affich[$i]["datejour"] = Functions::renvoiDate($list['datenaissance'], "d") . "-" . $mois . "-" . $year;
                }
            }
        }
        return $affich;
    }

    static function afficheBirthday($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Il n'y a aucun anniversaire pour le mois en cours; ?>
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>Date du jour</strong></th>
                        <th><strong>Nom Prénom</strong></th>
                        <th><strong>Date de naissance</strong></th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                  
                            <td><?php echo $v['datejour'] ?></td>
                            <td><?php echo $v['nomprenom'] ?></td>
                            <td><?php echo $v['datenaissance'] ?></td>
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

}
?>
