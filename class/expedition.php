<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * LDeclarationdouane of expedition
 *
 * @author Jésus t'aime
 * 
 *  

 */
class expedition {

    //put your code here
    var $id;
    var $codeunique;
    var $valeurdeclaree;
    var $declarationdouane;
    var $certificat;
    var $montantremboursement;
    var $taxepercue;
    var $numelement;
    var $idelement;
    var $idpaysorigine;
    var $iddestinataire;
    var $idexpediteur;
    var $idbureauechange;
    var $idactionlivraison;
    var $nbelement;
    var $dateexpedition;
    var $idpaysdestion;
    var $idbureaudepot;
    var $poids;
    var $compltactionnonlivraison;
    var $voieactionnonlivraison;
    var $voieacheminement;
    var $numccp;
    var $titulaireccp;
    var $idbureauccp;
    var $idlieuccp;
    var $idcreateur;

    function __construct($codeunique) {

        $rekete = "SELECT * FROM expedition WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->valeurdeclaree = $list["valeurdeclaree"];
            $this->declarationdouane = $list["declarationdouane"];
            $this->certificat = $list["certificat"];
            $this->montantremboursement = $list["montantremboursement"];
            $this->taxepercue = $list["taxepercue"];
            $this->numelement = $list["numelement"];
            $this->idelement = $list["idelement"];
            $this->idpaysorigine = $list["idpaysorigine"];
            $this->iddestinataire = $list["iddestinataire"];
            $this->idexpediteur = $list["idexpediteur"];
            $this->idbureauechange = $list["idbureauechange"];
            $this->idactionlivraison = $list["idactionlivraison"];
            $this->nbelement = $list["nbelement"];
            $this->dateexpedition = $list["dateexpedition"];
            $this->idpaysdestion = $list["idpaysdestion"];
            $this->idbureaudepot = $list["idbureaudepot"];
            $this->poids = $list["poids"];
            $this->compltactionnonlivraison = $list["compltactionnonlivraison"];
            $this->voieactionnonlivraison = $list["voieactionnonlivraison"];
            $this->voieacheminement = $list["voieacheminement"];
            $this->numccp = $list["numccp"];
            $this->titulaireccp = $list["titulaireccp"];
            $this->idbureauccp = $list["idbureauccp"];
            $this->idlieuccp = $list["idlieuccp"];
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

    public function getValeurdeclaree() {
        return $this->valeurdeclaree;
    }

    public function setValeurdeclaree($valeurdeclaree) {
        $this->valeurdeclaree = $valeurdeclaree;
    }

    public function getDeclarationdouane() {
        return $this->declarationdouane;
    }

    public function setDeclarationdouane($declarationdouane) {
        $this->declarationdouane = $declarationdouane;
    }

    public function getCertificat() {
        return $this->certificat;
    }

    public function setCertificat($certificat) {
        $this->certificat = $certificat;
    }

    public function getMontantremboursement() {
        return $this->montantremboursement;
    }

    public function setMontantremboursement($montantremboursement) {
        $this->montantremboursement = $montantremboursement;
    }

    public function getTaxepercue() {
        return $this->taxepercue;
    }

    public function setTaxepercue($taxepercue) {
        $this->taxepercue = $taxepercue;
    }

    public function getNumelement() {
        return $this->numelement;
    }

    public function setNumelement($numelement) {
        $this->numelement = $numelement;
    }

    public function getIdelement() {
        return $this->idelement;
    }

    public function setIdelement($idelement) {
        $this->idelement = $idelement;
    }

    public function getIdpaysorigine() {
        return $this->idpaysorigine;
    }

    public function setIdpaysorigine($idpaysorigine) {
        $this->idpaysorigine = $idpaysorigine;
    }

    public function iddestinataire() {
        return $this->iddestinataire;
    }

    public function setIddestinataire($iddestinataire) {
        $this->iddestinataire = $iddestinataire;
    }

    public function getIdexpediteur() {
        return $this->idexpediteur;
    }

    public function setIdexpediteur($idexpediteur) {
        $this->idexpediteur = $idexpediteur;
    }

    public function getIdbureauechange() {
        return $this->idbureauechange;
    }

    public function setIdbureauechange($idbureauechange) {
        $this->idbureauechange = $idbureauechange;
    }

    public function getIdactionlivraison() {
        return $this->idactionlivraison;
    }

    public function setIdactionlivraison($idactionlivraison) {
        $this->idactionlivraison = $idactionlivraison;
    }

    public function getNbelement() {
        return $this->nbelement;
    }

    public function setNbelement($nbelement) {
        $this->nbelement = $nbelement;
    }

    public function getModuleform2() {
        return $this->dateexpedition;
    }

    public function setModuleform2($dateexpedition) {
        $this->dateexpedition = $dateexpedition;
    }

    public function getIdpaysdestion() {
        return $this->idpaysdestion;
    }

    public function setIdpaysdestion($idpaysdestion) {
        $this->idpaysdestion = $idpaysdestion;
    }

    public function getIdbureaudepot() {
        return $this->idbureaudepot;
    }

    public function setIdbureaudepot($idbureaudepot) {
        $this->idbureaudepot = $idbureaudepot;
    }

    public function getPoids() {
        return $this->poids;
    }

    public function setPoids($poids) {
        $this->poids = $poids;
    }

    public function getCompltactionnonlivraison() {
        return $this->compltactionnonlivraison;
    }

    public function setCompltactionnonlivraison($compltactionnonlivraison) {
        $this->compltactionnonlivraison = $compltactionnonlivraison;
    }

    public function getVoieactionnonlivraison() {
        return $this->voieactionnonlivraison;
    }

    public function setVoieactionnonlivraison($voieactionnonlivraison) {
        $this->voieactionnonlivraison = $voieactionnonlivraison;
    }

    public function getNumccp() {
        return $this->numccp;
    }

    public function setNumccp($numccp) {
        $this->numccp = $numccp;
    }

    public function getTitulaireccp() {
        return $this->titulaireccp;
    }

    public function setTitulaireccp($titulaireccp) {
        $this->titulaireccp = $titulaireccp;
    }

    public function getIdbureauccp() {
        return $this->idbureauccp;
    }

    public function setIdbureauccp($idbureauccp) {
        $this->idbureauccp = $idbureauccp;
    }

    public function getIdlieuccp() {
        return $this->idlieuccp;
    }

    public function setIdlieuccp($idlieuccp) {
        $this->idlieuccp = $idlieuccp;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }

    public function getDateexpedition() {
        return $this->dateexpedition;
    }

    public function setDateexpedition($dateexpedition) {
        $this->dateexpedition = $dateexpedition;
    }

    public function getVoieacheminement() {
        return $this->voieacheminement;
    }

    public function setVoieacheminement($voieacheminement) {
        $this->voieacheminement = $voieacheminement;
    }

    public function verifDoublon() {
        $condition = "idelement =? AND n =?  AND numelement=? AND idexpediteur =? AND iddestinataire=? AND idbureauechange=? AND dateexpedition=?  ";
        $param = array($this->idelement, $this->numelement, $this->idexpediteur, $this->iddestinataire, $this->idbureauechange, $this->dateexpedition);
        $result = Functions::get_record_byCondition("expedition", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifDoublonMod() {
        $condition = "idelement =? AND n =?  AND numelement=? AND idexpediteur =? AND iddestinataire=? AND idbureauechange=? AND dateexpedition=? AND codeunique <> ?";
        $param = array($this->idelement, $this->numelement, $this->idexpediteur, $this->iddestinataire, $this->idbureauechange, $this->dateexpedition, $this->codeunique);
        $result = Functions::get_record_byCondition("expedition", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutExpedition() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'expedition');
            $rekete = "INSERT INTO expedition( `codeunique`, `valeurdeclaree`, `declarationdouane`, `certificat`, `montantremboursement`, ";
            $rekete .= "`taxepercue`, `numelement`, `idelement`, `idpaysorigine`, `iddestinataire`, `idexpediteur`, ";
            $rekete .= "`idbureauechange`, `idactionlivraison`, `nbelement`, `dateexpedition`, `idpaysdestion`, `idbureaudepot`, ";
            $rekete .= "`poids`, `compltactionnonlivraison`, `voieactionnonlivraison`, `numccp`, `titulaireccp`, `idbureauccp`, ";
            $rekete .= "`idlieuccp`,`idcreateur` )VALUES ";
            $rekete .= "('" . $this->codeunique . "','" . $this->valeurdeclaree . "','" . $this->declarationdouane . "','" . $this->certificat . "' ";
            $rekete .= ",'" . $this->montantremboursement . "','" . $this->taxepercue . "','" . $this->numelement . "','" . $this->idelement . "'";
            $rekete .= ",'" . $this->idpaysorigine . "','" . $this->iddestinataire . "','" . $this->idexpediteur . "','" . $this->idbureauechange . "'";
            $rekete .= ",'" . $this->idactionlivraison . "','" . $this->nbelement . "','" . $this->dateexpedition . "'";
            $rekete .= ",'" . $this->idpaysdestion . "','" . $this->idbureaudepot . "','" . $this->poids . "'";
            $rekete .= ",'" . $this->compltactionnonlivraison . "','" . $this->voieactionnonlivraison . "','" . $this->numccp . "'";
            $rekete .= ",'" . $this->titulaireccp . "','" . $this->idbureauccp . "','" . $this->idlieuccp . "','" . $_SESSION["user"]["codeunique"] . "')";
            $result = Functions::commit_sql($rekete, "");
            //echo 'Merci   ' . $rekete;
            if ($result) {
                return principale::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function modifExpedition() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE expedition SET declarationdouane = '" . $this->declarationdouane . "',valeurdeclaree = '" . $this->valeurdeclaree . "' ";
            $rekete .= ",iddestinataire = '" . $this->iddestinataire . "' ,idexpediteur = '" . $this->idexpediteur . "',certificat = '" . $this->certificat . "' ";
            $rekete .= ",idbureauechange = '" . $this->idbureauechange . "' ,idactionlivraison = '" . $this->idactionlivraison . "' ";
            $rekete .= " ,montantremboursement = '" . $this->montantremboursement . "', idelement = '" . $this->idelement . "' ";
            $rekete .= ",nbelement = '" . $this->nbelement . "' ,dateexpedition = '" . $this->dateexpedition . "',voieacheminement = '" . $this->voieacheminement . "' ";
            $rekete .= ",idpaysdestion = '" . $this->idpaysdestion . "' ,idbureaudepot = '" . $this->idbureaudepot . "' ";
            $rekete .= ",poids = '" . $this->poids . "' ,compltactionnonlivraison = '" . $this->compltactionnonlivraison . "' ";
            $rekete .= ",voieactionnonlivraison = '" . $this->voieactionnonlivraison . "' ,numccp = '" . $this->numccp . "' ";
            $rekete .= ",titulaireccp = '" . $this->titulaireccp . "' ,idbureauccp = '" . $this->idbureauccp . "' ";
            $rekete .= ",taxepercue = '" . $this->taxepercue . "' ,numelement = '" . $this->numelement . "' ";
            $rekete .= ",idpaysorigine = '" . $this->idpaysorigine . "' ,idlieuccp = '" . $this->idlieuccp . "'WHERE codeunique = '" . $this->codeunique . "'";
            //Functions::afficheBoiteMsg($rekete);
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

    public function suppExpedition() {
        if (principale::suppressionPossible('expedition', $this->codeunique) == 1) {
            $rekete = "DELETE FROM expedition WHERE codeunique = '" . $this->codeunique . "'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                echo principale::ajoutReketeSynchro($rekete);
            } else {
                echo '0';
            }
        } else {
            echo '3';
        }
    }

    public static function donnee($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["num"] = $i + 1;
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["valeurdeclaree"] = $list["valeurdeclaree"];
//                $affich[$i]["centre"] = centre::libCentre($list["valeurdeclaree"]);
                $affich[$i]["declarationdouane"] = $list["declarationdouane"];
                $affich[$i]["certificat"] = $list["certificat"];
                $affich[$i]["declarationdouanecertificat"] = $list["declarationdouane"] . ' ' . $list["certificat"];
                $affich[$i]["montantremboursement"] = $list["montantremboursement"];
//                $affich[$i]["corps"] = corps::libCorpsParCodeunique($list["montantremboursement"]);
                $affich[$i]["taxepercue"] = $list["taxepercue"];
                $affich[$i]["numelement"] = $list["numelement"];
                $affich[$i]["idelement"] = $list["idelement"];
                $affich[$i]["idpaysorigine"] = $list["idpaysorigine"];
                $affich[$i]["paysorigine"] = pays::nomfrancaisPays($list["idpaysorigine"]);
                $affich[$i]["iddestinataire"] = $list["iddestinataire"];
                $affich[$i]["destinataireAddres"] = acteurs::designationActeurAdresse($list["iddestinataire"]);
                $affich[$i]["idexpediteur"] = $list["idexpediteur"];
                $affich[$i]["expediteurAdres"] = acteurs::designationActeurAdresse($list["idexpediteur"]);
                $affich[$i]["idbureauechange"] = $list["idbureauechange"];
                $affich[$i]["idactionlivraison"] = $list["idactionlivraison"];
                $affich[$i]["nbelement"] = $list["nbelement"];
                $affich[$i]["dateexpedition"] = Functions::convertDate($list["dateexpedition"]);
                $affich[$i]["idpaysdestion"] = $list["idpaysdestion"];
                $affich[$i]["paysdestion"] = pays::nomfrancaisPays($list["idpaysdestion"]);
                $affich[$i]["idbureaudepot"] = $list["idbureaudepot"];
                $affich[$i]["poids"] = $list["poids"];
                $affich[$i]["compltactionnonlivraison"] = $list["compltactionnonlivraison"];
                $affich[$i]["voieactionnonlivraison"] = $list["voieactionnonlivraison"];
                $affich[$i]["voieacheminement"] = $list["voieacheminement"];
                $affich[$i]["libvoieacheminement"] = voieacheminement::libelleVoieacheminement($list["voieacheminement"]);
                $affich[$i]["numccp"] = $list["numccp"];
                $affich[$i]["titulaireccp"] = $list["titulaireccp"];
                $affich[$i]["idbureauccp"] = $list["idbureauccp"];
                $affich[$i]["idlieuccp"] = $list["idlieuccp"];
                $affich[$i]["idcreateur"] = $list["idcreateur"];
                $i++;
            }
        }
        return $affich;
    }

    public static function expeditionParCritere($critere = "") {

        $rekete = "SELECT DISTINCT * FROM expedition " . $critere;
        $result = Functions::commit_sql($rekete, "");      //  echo ' Merci  '.$rekete;
        $affich = expedition::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'expedition':
                $titre = "Liste des expéditions";
                break;

            case 'addexpedition':
                $titre = "Ajout d'expédition";
                break;

            case 'editexpedition':
                $titre = "Modification d'expédition";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = expedition::afficheTitre($conf);
        $critere = "";
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo strtoupper($titre); ?> </h4>
        </div> 

        <?php
        switch ($conf) {
            case 'expedition':

                $_SESSION['ongactiv'] = 2;
                $donnee = expedition::expeditionParCritere($critere);
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">

                    <div class="btn-group">
                        <?php if ($conf == 'expedition') { ?>  <a href="#" onclick="JPrincipal.afficheContenu(0, 'addexpedition', '', '<?php echo $retour; ?>');" id="addexpedition" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>   <?php } ?>             

                    </div>

                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    expedition::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addexpedition':
                $retour = 'expedition';
                expedition::formMaj($retour, $conf, "");
                break;
            case 'editexpedition':
                $retour = 'expedition';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                expedition::formMaj($retour, $conf, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
        $confsup = "suppexpedition";
        $_SESSION['ongactiv'] = 1;
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune information n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" data-spy="scroll" width="100%" >
                <thead>
                    <tr class="menu_gauche">                                                                                                          <!--                        <th><strong>Projet/Programme</strong></th>-->
                        <th><strong>N°</strong></th>
                        <th><strong>Date</strong></th>                                                
                        <th><strong>Expéditeur</strong></th>                                                
                        <th><strong>Destinataire</strong></th>                                                
                        <th><strong>Pays destination</strong></th>                                                
                        <th><strong>Acheminement</strong></th>                                                
                        <th><strong>Remboursement</strong></th>                                                
                        <th><strong>Valeur déclarée</strong></th>                                                
                        <th><strong>Poids</strong></th>                                                
                        <th><strong>Valeur affranchie</strong></th>                                                
                        <th ><strong>Boutons</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                            
                            <td><?php echo $v['numelement'] ?></td>
                            <td><?php echo $v['dateexpedition'] ?></td>
                            <td><?php echo $v['expediteurAdres'] ?></td>
                            <td><?php echo $v['destinataireAddres'] ?></td>
                            <td><?php echo $v['paysdestion'] ?></td>
                            <td><?php echo $v['libvoieacheminement'] ?></td>
                            <td><?php echo $v['montantremboursement']; ?></td>                           
                            <td><?php echo $v['valeurdeclaree']; ?></td>                           
                            <td><?php echo $v['poids']; ?></td>                           
                            <td><?php echo $v['taxepercue']; ?></td>                           
                            <td>
                                <div class="btn-group" >
                                    <a href="#"class="btn dropdown-toggle" data-toggle="dropdown" >
                                        Boutons
                                        <span class="caret">

                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!--                                        <li>
                                                                                    <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'formationQuestionnaire', '', 'expedition');" style="margin-right: 5px;" title="Voir actions"><i class="icon-eye-open"></i>Voir les formations</a>
                                                                                </li>-->
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editexpedition', '', '');" style="margin-right: 5px;" title="Modifier"><i class="icon-edit"></i>Modifier</a>
                                        </li>

                                        <li>
                                            <a href="#" class="btn btn-small btn-danger" onclick="JTraitement1.supprimer('<?php echo $v['codeunique']; ?>', '<?php echo $confsup; ?>');" style="margin-right: 5px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i>Supprimer</a>
                                        </li>
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

    static function formMaj($retour, $conf, $id = "") {
        $act = (isset($_SESSION['ongactiv'])) ? $_SESSION['ongactiv'] : 1;
        $active1 = ($act == 1) ? "active" : "";
        $active2 = ($act == 2) ? "active" : "";
        $active3 = ($act == 3) ? "active" : "";
        $active4 = ($act == 4) ? "active" : "";

        $clasactive1 = ($act == 1) ? 'class="active"' : '';
        $clasactive2 = ($act == 2) ? 'class="active"' : '';
        $clasactive3 = ($act == 3) ? 'class="active"' : '';
        $clasactive4 = ($act == 4) ? 'class="active"' : '';
        ?> 
        <div id="zoneonglet"></div>
        <!--<div id="info"></div>-->
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allcotation" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
                <li <?php echo $clasactive1 ?> ><a href="#tab1" data-toggle="tab">Généralités</a></li>
                <li <?php echo $clasactive2 ?> ><a href="#tab2" data-toggle="tab">Montant</a></li>
                <li <?php echo $clasactive3 ?> ><a href="#tab3" data-toggle="tab">CCP</a></li>
                <li <?php echo $clasactive4 ?> ><a href="#tab4" data-toggle="tab">Action non livraison</a></li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane <?php echo $active1 ?>" id="tab1">
                    <?php expedition::section1($retour, $id); ?>
                </div>
                <div class="tab-pane <?php echo $active2 ?>" id="tab2">
                    <?php expedition::section2($retour, $id); ?>                                                          
                </div>
                <div class="tab-pane <?php echo $active3 ?>" id="tab3">
                    <?php expedition::section3($retour, $id); ?>                        
                </div>
                <div class="tab-pane <?php echo $active4 ?>" id="tab4">
                    <?php expedition::section4($retour, $conf, $id); ?>                        
                </div>

            </div>
        </div>
        <?php
    }

    static function section1($retour, $id = "") {
        $critere = "WHERE codeunique = '" . $id . "'";
        $d = expedition::expeditionParCritere($critere);
        $b = (sizeof($d, 1) == 0) ? 0 : 1;

        $ret = $retour . '|2';
        ?>   
        <!-- Formulaire d'ajout de cotation -->
        <div class="validateTips"><p class="alert alert-warning"><b>A-	INFORMATIONS GENERALES</b></p></div>
        <form class="form-horizontal" method="post" name="formaddexpedition" id="formaddexpedition" action="" >                    
            <div class="well well-large">               
                <div class="control-group pull-right">
                    <label class="control-label" for="dateexpedition"><strong>Date expédition </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:100px;" name="dateexpedition" id="dateexpedition" class="text ui-widget-content ui-corner-all date" value="<?php echo ($b == 1) ? $d[0]['dateexpedition'] : date('d-m-Y'); ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="numelement"><strong>N° Colis(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('numelement', 0);" name="numelement" id="numelement" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['numelement'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idpaysorigine"><strong>Pays d'origine(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeP = "SELECT * FROM pays";
                        echo Functions::LoadCombo2($reketeP, 'id', "nomfrancais", 'idpaysorigine', "Sélectionner le pays d'origine", '400', '', ($b == 1) ? $d[0]['idpaysorigine'] : "");
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idpaysdestion"><strong>Pays de destination(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketePD = "SELECT * FROM pays";
                        echo Functions::LoadCombo2($reketePD, 'id', "nomfrancais", 'idpaysdestion', "Sélectionner le pays d'origine", '400', '', ($b == 1) ? $d[0]['idpaysdestion'] : "");
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="numelement"><strong>Bureau d'échange(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $rekete = "SELECT * FROM bureauechange";
                        echo Functions::LoadCombo2($rekete, 'codeunique', "designation", 'idbureauechange', "Sélectionner le bureau d'échange", '400', '', ($b == 1) ? $d[0]['idbureauechange'] : "");
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idexpediteur"><strong>Expéditeur(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeE = "SELECT * FROM acteurs";
                        echo Functions::LoadCombo2($reketeE, 'codeunique', "designation", 'idexpediteur', "Sélectionner l'expéditeur ", '400', '', ($b == 1) ? $d[0]['idexpediteur'] : "");
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="iddestinataire"><strong>Destinataire(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeD = "SELECT * FROM acteurs";
                        echo Functions::LoadCombo2($reketeD, 'codeunique', "designation", 'iddestinataire', "Sélectionner le destinataire", '400', '', ($b == 1) ? $d[0]['iddestinataire'] : "");
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="voieacheminement"><strong>Voie acheminement(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeVA = "SELECT * FROM voieacheminement";
                        echo Functions::LoadCombo2($reketeVA, 'id', "libelle", 'voieacheminement', "Sélectionner la voie d'acheminement", '400', '', ($b == 1) ? $d[0]['voieacheminement'] : "");
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="poids"><strong>Poids(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:100px;" name="poids" id="poids" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['poids'] : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <!--<a href="#" onclick="JTraitement1.activeonglet('2', '<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>-->
                        <a href="#" onclick="JTraitement.valider('<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    static function section2($retour, $id = "") {
        $critere = "WHERE codeunique = '" . $id . "'";
        $d = expedition::expeditionParCritere($critere);
        $b = (sizeof($d, 1) == 0) ? 0 : 1;

        $ret = $retour . '|3';
        ?>   
        <!-- Formulaire d'ajout de cotation -->
        <div class="validateTips"><p class="alert alert-warning"><b>B-	MONTANT</b></p></div>
        <form class="form-horizontal" method="post" name="formaddexpedition" id="formaddexpedition" action="" >                    
            <div class="well well-large">               

                <div class="control-group">
                    <label class="control-label" for="valeurdeclaree"><strong>Valeur déclarée </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.estNumerique('valeurdeclaree');" name="valeurdeclaree" id="valeurdeclaree" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['valeurdeclaree'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="declarationdouaniere"><strong>Déclaration douanière </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.estNumerique('declarationdouaniere');" name="declarationdouaniere" id="declarationdouaniere" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['declarationdouane'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="certificatoufacture"><strong>Certificat ou Facture </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.estNumerique('certificatoufacture');" name="certificatoufacture" id="certificatoufacture" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['certificat'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="montantremboursement"><strong>Montant du remboursement </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.estNumerique('montantremboursement');" name="montantremboursement" id="montantremboursement" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['montantremboursement'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="taxepercue"><strong>Taxe perçue </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.estNumerique('taxepercue');" name="taxepercue" id="taxepercue" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['taxepercue'] : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <!--<a href="#" onclick="JTraitement1.activeonglet('2', '<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>-->
                        <a href="#" onclick="JTraitement.valider('<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    static function section3($retour, $id = "") {
        $critere = "WHERE codeunique = '" . $id . "'";
        $d = expedition::expeditionParCritere($critere);
        $b = (sizeof($d, 1) == 0) ? 0 : 1;

        $ret = $retour . '|4';
        ?>   
        <!-- Formulaire d'ajout de cotation -->
        <div class="validateTips"><p class="alert alert-warning"><b>C-	CCP</b></p></div>
        <form class="form-horizontal" method="post" name="formaddexpedition" id="formaddexpedition" action="" >                    
            <div class="well well-large">               
                <div class="control-group">
                    <label class="control-label" for="numccp"><strong>N° Compte courant(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('numccp', 0);" name="numccp" id="numccp" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['numccp'] : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="titulaireccp"><strong>Titulaire </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('titulaireccp', 0);" name="titulaireccp" id="titulaireccp" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['titulaireccp'] : ''; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="idbureauccp"><strong>Bureaux de chèque(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketePD = "SELECT * FROM bureauechange";
                        echo Functions::LoadCombo2($reketePD, 'codeunique', "designation", 'idbureauccp', "Sélectionner le bureau de chèque", '400', '', ($b == 1) ? $d[0]['idbureauechange'] : "");
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="idlieuccp"><strong>Lieu(*) </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeL = "SELECT * FROM bureauechange";
                        echo Functions::LoadCombo2($reketeL, 'codeunique', "designation", 'idlieuccp', "Sélectionner le bureau de chèque", '400', '', ($b == 1) ? $d[0]['idbureauechange'] : "");
                        ?>
                    </div>
                </div> 

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <!--<a href="#" onclick="JTraitement1.activeonglet('2', '<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>-->
                        <a href="#" onclick="JTraitement.valider('<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>
                    </div>
                </div>
            </div>                         
        </form>
        <?php
    }

    static function section4($retour, $conf, $id = "") {
        $critere = "WHERE codeunique = '" . $id . "'";
        $d = expedition::expeditionParCritere($critere);
        $b = (sizeof($d, 1) == 0) ? 0 : 1;

        $ret = $retour . '|1';
        $ret4 = $conf . '|4|' . $id;
        $idact = isset($_SESSION["idactionlivraison"]) ? $_SESSION["idactionlivraison"] : (($b == 1) ? $d[0]['idactionlivraison'] : "");
        ?>   
        <!-- Formulaire d'ajout de cotation -->
        <div class="validateTips"><p class="alert alert-warning"><b>D-	ACTIONS NON - LIVRAISON</b></p></div>
        <form class="form-horizontal" method="post" name="formaddexpedition" id="formaddexpedition" action="" >                    
            <div class="well well-large">               


                <div class="control-group">
                    <label class="control-label" for="idactionlivraison"><strong>Action non livraison </strong></label>
                    <div class="controls">                        
                        <input type="hidden"  name="ret4" id="ret4" class="text ui-widget-content ui-corner-all" value="<?php echo $ret4; ?>" />
                        <?php
                        $onchange = "JTraitement.onChangeComboActionnonlivraison()";
                        $reketePD = "SELECT * FROM actionnonlivraison";
                        echo Functions::LoadCombo2($reketePD, 'id', "libelle", 'idactionlivraison', "Sélectionner l'action", '400', $onchange, $idact);
                        ?>
                    </div>
                </div>
                <?php if ($idact < 7) { ?>
                    <div class="control-group">
                    <label class="control-label" for="voieactionnonlivraison"><strong> Voie Action non livraison </strong></label>
                    <div class="controls">                        
                        <?php
                        $reketeVA = "SELECT * FROM voieacheminement";
                        echo Functions::LoadCombo2($reketeVA, 'id', "libelle", 'voieactionnonlivraison', "Sélectionner la voie d'acheminement", '400', '', ($b == 1) ? $d[0]['voieactionnonlivraison'] : "");
                        ?>
                    </div>
                </div>
                <?php } ?>
                <?php
                $lib = '';
                switch ($idact) {
                    case 2:
                        $lib = " Nom et l'adresse d'une tierce personne dans le pays de destination";
                        break;
                    
                    case 4:
                        $lib = "Délais d'expiration";
                        break;
                    
                    case 5:
                        $lib = "Nom et l'adresse du nouveau destinataire ";
                        break;

                }
                if ($idact ==2||$idact ==4||$idact ==5) {
                    ?>
                <div class="control-group">
                        <label class="control-label" for="compltactionnonlivraison"><strong><?php echo $lib; ?> </strong></label>
                        <div class="controls">
                            <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('compltactionnonlivraison', 0);" name="compltactionnonlivraison" id="compltactionnonlivraison" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['compltactionnonlivraison'] : ''; ?>" />
                        </div>
                    </div>
        <?php } ?>
                
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <!--<a href="#" onclick="JTraitement1.activeonglet('2', '<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Suivant <i class="icon-arrow-right"></i></a>-->
                        <a href="#" onclick="JTraitement.valider('<?php echo $id; ?>', '<?php echo $ret; ?>');" id="allcotation" class="btn btn-small btn-info"> Valider <i class="icon-ok"></i></a>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    public static function valider($id, $retour, $champ) {       //Functions::afficheBoiteMsg($retour);
        $expedition = new expedition($id);
        $t = count($champ);
        //$("#idactionlivraison").val() + "|"+ $("#compltactionnonlivraison").val() +"|"+ $("#voieactionnonlivraison").val()
        $expedition->setdateexpedition(Functions::convertDate($champ[0]));
        $expedition->setnumelement($champ[1]);
        $expedition->setidpaysorigine(addslashes($champ[2]));
        $expedition->setidpaysdestion(addslashes($champ[3]));
        $expedition->setidbureauechange(addslashes($champ[4]));
        $expedition->setidexpediteur(addslashes($champ[5]));
        $expedition->setIddestinataire($champ[6]);
        $expedition->setvoieacheminement(addslashes($champ[7]));
        $expedition->setpoids($champ[8]);
        $expedition->setvaleurdeclaree($champ[9]);
        $expedition->setDeclarationdouane($champ[10]);
        $expedition->setCertificat($champ[11]);
        $expedition->setMontantremboursement($champ[12]);
        $expedition->setTaxepercue($champ[13]);
        $expedition->setNumccp($champ[14]);
        $expedition->setTitulaireccp($champ[15]);
        $expedition->setIdbureauccp($champ[16]);
        $expedition->setIdlieuccp($champ[17]);
        $expedition->setIdactionlivraison($champ[18]);
       if($t > 20 ) $expedition->setVoieactionnonlivraison($champ[20]);
       if($t > 21 ) $expedition->setCompltactionnonlivraison($champ[21]);
        $_SESSION["ongactiv"] = $champ[19];
        if ($champ[19] > 1)
            $retour = 'editexpedition';
        $result = 0;
        if ($id == "") {
            $result = $expedition->ajoutExpedition();
            if ($result == '1')
                $id = principale::dernierCodeunique(gethostname(), 'codeunique', 'expedition');
        } else {
            $result = $expedition->modifExpedition();
        }
        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le expedition n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);
                                    
                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le expedition a été enregistré avec succès. </div>').fadeIn(300).fadeOut(2000);
                    JPrincipal.afficheContenu('<?php echo $id; ?>', '<?php echo $retour; ?>', '', '');
                </script>                    
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le expedition que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    public static function donneeImprimer($conf) {
        $orientation = 'p'; //Portrait
        $borduretableau = 1; //Portrait par défaut        
        $hautdoc = array();
        $basdoc = array();
        $corps = "";
        $critere = "";
        $montantremboursement = "";
        $valeurdeclaree = "";
        if (isset($_SESSION['montantremboursement'])) {
            $montantremboursement = $_SESSION['montantremboursement'];
        }
        if (isset($_SESSION['valeurdeclaree'])) {
            $valeurdeclaree = $_SESSION['valeurdeclaree'];
        }
        if ($montantremboursement != "" && $montantremboursement != '0')
            $critere .= "WHERE montantremboursement = '" . $montantremboursement . "' ";
        if ($valeurdeclaree != "" && $valeurdeclaree != '0') {
            $critere .= ($critere == "") ? " WHERE valeurdeclaree = '" . $valeurdeclaree . "' " : " AND valeurdeclaree = '" . $valeurdeclaree . "' ";
        }
        $titre = expedition::afficheTitre($conf);

        switch ($conf) {
            case 'expedition':
                $declarationdouanefichier = "quesionnair"; // Ne pas dépasser 11 caractères au total sinon erreur                
                $donnee = expedition::expeditionParCritere($critere);

                $tabAlign = array("L", "L", "L");
                $listlargeurtitre = array(80, 55, 55); //total 190
                $listtitre = array("Centre", "Corps", "Declarationdouane", "Prédeclarationdouanes", "Ancienneté corps", "Ancienneté poste", "Date remplissage",
                    "Q1", "Q2année1", "Q2année2", "Q2année3", "Q2année4", "Q3mod1", "Q3mod2", "Q3mod3",
                    "Q3mod4", "Q3mod5", "Q3mod6", "Q3mod7", "Q3mod8", "Q3mod9", "Q3mod10",
                    "Q4", "Q5", "Q6con1", "Q6con2", "Q6con3", "Q6con4", "Q6con5",
                    "Q6con6", "Q6con7", "Q6con8", "Q6con9", "Q6con10", "Q7", "Q8",
                    "Q8a1", "Q8a2", "Q8a3", "Q8a4", "Q8a5", "Q8a6", "Q8a7", "Q8aAutrechangement",
                    "Q8b", "Q9", "Q9a1", "Q9a2", "Q9a3", "Q9b1", "Q9b2",
                    "Q10", "Q11COGES/COGECS", "Q11Comité départemental/national", "Q11a Nbre de fois", "Q11a Occasion",
                    "Q11b Nbre de fois", "Q11b Occasion", "Q11c Conclusion COGES/COGECS", "Q11c Conclusion Comité départemental/national",
                    "Q11d", "Q12");

                $listcolonneBD = array("centre", "corps", "declarationdouane", "certificat", "taxepercue", "numelement", " idelement",
                    "idpaysorigine", "iddestinataire", "idexpediteur", "idbureauechange", "idactionlivraison", "nbelement", "dateexpedition", "idpaysdestion",
                    "idbureaudepot", "poids", "compltactionnonlivraison", "voieactionnonlivraison", "numccp", "titulaireccp", "idbureauccp",
                    "idlieuccp", "conameliore", "conacquis1", "conacquis2", "conacquis3", "conacquis4", "conacquis5",
                    "conacquis6", "conacquis7", "conacquis8", "conacquis9", "conacquis10", "applicationcon", "changmtconstat",
                    "changmt1", "changmt2", "changmt3", "changmt4", "changmt5", "changmt6", "changmt7", "autrechangmt",
                    "changmtattribuable", "rencontdifficulte", "difficulte1", "difficulte2", "difficulte3", "suggestion1", "suggestion2",
                    "besoinactuel", "cogescvisite", "comitedepnationalvisite", "nbvisitecogesc", "occasionvisitcogesc",
                    "nbvisitecomitedep", "occasionvisitcomitedep", "conclusvisitecoges", "conclusvisitecomitedep",
                    "existcahier", "souhait");
                break;
        }

        return array($titre, $listtitre, $listcolonneBD, $listlargeurtitre, $declarationdouanefichier, $donnee, $orientation, $borduretableau, $hautdoc, $basdoc, $tabAlign, $corps);
    }

}
?>
 