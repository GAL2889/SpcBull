<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * LTaxetransportinterieur of scp
 *
 * @author Jésus t'aime
 * 
 *  

 */
class scp{

    //put your code here
    var $id;
    Var $numordre;
    Var $numcolis ;       
    var $codeunique;
    var $droitfixe;
    var $taxetransportinterieur;
    var $droitdouane;
    var $montantavis;
    var $fraismagcoilisjour;
    var $lieuxscp;
    var $echeance;
    var $datelivraison;
    var $montantremboursement;
    var $iddestinataire;
    var $idexpediteur;
    var $idpaysorigine;
    var $datescp;
    var $idcreateur;

    function __construct($codeunique) {

        $rekete = "SELECT * FROM scp WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->numcolis = $list["numcolis"];
            $this->numordre = $list["numordre"];
            $this->codeunique = $list["codeunique"];
            $this->droitfixe = $list["droitfixe"];
            $this->taxetransportinterieur = $list["taxetransportinterieur"];
            $this->droitdouane = $list["droitdouane"];
            $this->montantavis = $list["montantavis"];
            $this->fraismagcoilisjour = $list["fraismagcoilisjour"];
            $this->lieuxscp = $list["lieuxscp"];
            $this->echeance = $list["echeance"];
            $this->datelivraison = $list["datelivraison"];
            $this->montantremboursement = $list["montantremboursement"];
            $this->iddestinataire = $list["iddestinataire"];
            $this->idexpediteur = $list["idexpediteur"];
            $this->idpaysorigine = $list["idpaysorigine"];
            $this->datescp = $list["datescp"];
            $this->idcreateur = $list["idcreateur"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumordre() {
        return $this->numordre;
    }

    public function setNumordre($numordre) {
        $this->numordre = $numordre;
    }

    public function getNumcolis() {
        return $this->numcolis;
    }

    public function setNumcolis($numcolis) {
        $this->numcolis = $numcolis;
    }

    public function getCodeunique() {
        return $this->codeunique;
    }

    public function setCodeunique($codeunique) {
        $this->codeunique = $codeunique;
    }

    public function getDroitfixe() {
        return $this->droitfixe;
    }

    public function setDroitfixe($droitfixe) {
        $this->droitfixe = $droitfixe;
    }

    public function getTaxetransportinterieur() {
        return $this->taxetransportinterieur;
    }

    public function setTaxetransportinterieur($taxetransportinterieur) {
        $this->taxetransportinterieur = $taxetransportinterieur;
    }

    public function getDroitdouane() {
        return $this->droitdouane;
    }

    public function setDroitdouane($droitdouane) {
        $this->droitdouane = $droitdouane;
    }

    public function getMontantavis() {
        return $this->montantavis;
    }

    public function setMontantavis($montantavis) {
        $this->montantavis = $montantavis;
    }
 
    public function getFraismagcoilisjour() {
        return $this->fraismagcoilisjour;
    }

    public function setFraismagcoilisjour($fraismagcoilisjour) {
        $this->fraismagcoilisjour = $fraismagcoilisjour;
    }

    public function getLieuxscp() {
        return $this->lieuxscp;
    }

    public function setLieuxscp($lieuxscp) {
        $this->lieuxscp = $lieuxscp;
    }

    public function getEcheance() {
        return $this->echeance;
    }

    public function setEcheance($echeance) {
        $this->echeance = $echeance;
    }

    public function getDatelivraison() {
        return $this->datelivraison;
    }

    public function setDatelivraison($datelivraison) {
        $this->datelivraison = $datelivraison;
    }
    
    public function getMontantremboursement() {
        return $this->montantremboursement;
    }

    public function setMontantremboursement($montantremboursement) {
        $this->montantremboursement = $montantremboursement;
    }

    public function getIddestinataire() {
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
    public function getIdpaysorigine() {
        return $this->idpaysorigine;
    }

    public function setIdpaysorigine($idpaysorigine) {
        $this->idpaysorigine = $idpaysorigine;
    }

            public function getDatescp() {
        return $this->datescp;
    }

    public function setDatescp($datescp) {
        $this->datescp = $datescp;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }
    
    public static function montantTotal($idscp){
        $d = scp::scpParCritere("WHERE codeunique = '".$idscp."'");
        $b = sizeof($d, 1);
        $tot = ($b>0)?($d[0]['droitfixe'] + $d[0]['taxetransportinterieur']+ $d[0]['droitdouane']+ $d[0]['montantavis']+ $d[0]['montantremboursement']):0;
         return $tot;
    }

        public function verifDoublon() {
        $condition = "numordre =? OR ( iddestinataire =? AND idexpediteur =? AND idpaysorigine=?  AND numcolis=? AND datescp =? ) ";
        $param = array($this->numordre, $this->iddestinataire, $this->idexpediteur,  $this->idpaysorigine, $this->numcolis, $this->datescp);
        $result = Functions::get_record_byCondition("scp", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifDoublonMod() {
        $condition = "(numordre =? OR ( iddestinataire =? AND idexpediteur =? AND idpaysorigine =? AND numcolis=? AND datescp =? ))  AND codeunique <> ?";
        $param = array($this->numordre, $this->iddestinataire, $this->idexpediteur,  $this->idpaysorigine, $this->numcolis, $this->datescp, $this->codeunique);
        $result = Functions::get_record_byCondition("scp", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutScp() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'scp');
            $rekete = "INSERT INTO scp(`numordre`,`numcolis`,`codeunique`, `droitfixe`, `taxetransportinterieur`, `droitdouane`, `montantavis`, ";
            $rekete .= "`fraismagcoilisjour`, `lieuxscp`, `echeance`, `datelivraison`,`montantremboursement`,`iddestinataire`,idexpediteur,idpaysorigine, `datescp`, ";
            $rekete .= "`idcreateur` )VALUES ";
            $rekete .= "('" . $this->numordre . "','" . $this->numcolis . "','" . $this->codeunique . "' ";
            $rekete .= ",'" . $this->droitfixe . "','" . $this->taxetransportinterieur . "','" . $this->droitdouane . "','" . $this->montantavis . "'";
            $rekete .= ",'" . $this->fraismagcoilisjour . "','" . $this->lieuxscp . "','" . $this->echeance . "','" . $this->datelivraison . "','" . $this->montantremboursement . "','" . $this->iddestinataire . "','" . $this->idexpediteur . "','" . $this->idpaysorigine . "'";
            $rekete .= ",'" . $this->datescp . "','" . $_SESSION["user"]["codeunique"] . "')";
            $result = Functions::commit_sql($rekete, "");           //echo 'Merci   '.$rekete;
            if ($result) {
                return principale::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function modifScp() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE scp SET numordre = '" . $this->numordre . "',numcolis = '" . $this->numcolis . "' ";
            $rekete .= ",droitfixe = '" . $this->droitfixe . "' ,taxetransportinterieur = '" . $this->taxetransportinterieur . "' ";
            $rekete .= ",droitdouane = '" . $this->droitdouane . "' ,montantavis = '" . $this->montantavis . "' ";
            $rekete .= " ,fraismagcoilisjour = '" . $this->fraismagcoilisjour . "', lieuxscp = '" . $this->lieuxscp . "' ";
            $rekete .= ",echeance = '" . $this->echeance . "' ,datelivraison = '" . $this->datelivraison . "' ";
            $rekete .= ",datescp = '" . $this->datescp ."',montantremboursement = '" . $this->montantremboursement ."',iddestinataire = '" . $this->iddestinataire ."'";
            $rekete .= ",idexpediteur = '" . $this->idexpediteur ."',idpaysorigine = '" . $this->idpaysorigine ."' WHERE codeunique= '" . $this->codeunique . "'";

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

    public function suppScp() {
        if (principale::suppressionPossible('scp', $this->codeunique) == 1) {
            $rekete = "DELETE FROM scp WHERE codeunique = '" . $this->codeunique . "'";
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
                $affich[$i]["numordre"] = $list['numordre'];
                $affich[$i]["numcolis"] = $list['numcolis'];
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["droitfixe"] = $list["droitfixe"];
                $affich[$i]["taxetransportinterieur"] = $list["taxetransportinterieur"];
                $affich[$i]["droitdouane"] = $list["droitdouane"];
                $affich[$i]["montantavis"] = $list["montantavis"];
                $affich[$i]["montanttotal"] =$list["montantremboursement"] + $list["droitfixe"] + $list["taxetransportinterieur"] + $list["droitdouane"]+ $list["montantavis"];
                $affich[$i]["fraismagcoilisjour"] = $list["fraismagcoilisjour"];
                $affich[$i]["datescp"] = $list["datescp"];
                $affich[$i]["lieuxscp"] = bureauechange::designationBureau( $list["lieuxscp"]);
                $affich[$i]["echeance"] = Functions::convertDate($list["echeance"]);
                $affich[$i]["datelivraison"] = Functions::convertDate($list["datelivraison"]);
                $affich[$i]["montantremboursement"] = $list["montantremboursement"];
                $affich[$i]["iddestinataire"] = $list["iddestinataire"];
                $affich[$i]["destinataireAdress"] = acteurs::designationActeurAdresse( $list["iddestinataire"]);
                $affich[$i]["idexpediteur"] = $list["idexpediteur"];
                $affich[$i]["idpaysorigine"] = $list["idpaysorigine"];
                $affich[$i]["paysorigine"] = pays::nomfrancaisPays( $list["idpaysorigine"]);
                $affich[$i]["idcreateur"] = $list["idcreateur"];
                $i++;
            }
        }
        return $affich;
    }

    public static function scpParCritere($critere = "") {

        $rekete = "SELECT DISTINCT * FROM scp " . $critere;
        $result = Functions::commit_sql($rekete, "");      //  echo ' Merci  '.$rekete;
        $affich = scp::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'scp':
                $titre = "Liste des scp";
                break;

            case 'addscp':
                $titre = "Ajout de scp";
                break;

            case 'editscp':
                $titre = "Modification de scp";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = scp::afficheTitre($conf);
        $critere = "";
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo strtoupper($titre); ?> </h4>
        </div> 

        <?php
        switch ($conf) {
            case 'scp':

//                $_SESSION['ongactiv'] = 2;
                $donnee = scp::scpParCritere($critere);
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">

                    <div class="btn-group">
                        <?php if ($conf == 'scp') { ?>  <a href="#" onclick="JPrincipal.afficheContenu(0, 'addscp', '', '<?php echo $retour; ?>');" id="addscp" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>   <?php } ?>             

                    </div>

                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    scp::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addscp':
                $retour = 'scp';
                scp::formMaj($retour, "");
                break;
            case 'editscp':
                $retour = 'scp';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                scp::formMaj($retour, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
        $confsup = "suppscp";

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
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">                                                                                                          <!--                        <th><strong>Projet/Programme</strong></th>-->
                        <th><strong>N° Ordre</strong></th>
                        <th><strong>N° Colis</strong></th>                                                
                        <th><strong>Pays d'origine</strong></th>                                                
                        <th><strong>Destinataire</strong></th>                                                
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
                <!--                            <td><?php // echo $v['centre']                  ?></td>-->
                            <td><?php echo $v['numordre'] ?></td>
                            <td><?php echo $v['numcolis'] ?></td>
                            <td><?php echo $v['paysorigine']; ?></td>                           
                            <td><?php echo $v['destinataireAdress']; ?></td>                           
                                                     
                            <td>
                                <div class="btn-group" >
                                    <a href="#"class="btn dropdown-toggle" data-toggle="dropdown" >
                                        Boutons
                                        <span class="caret">

                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <!--                                        <li>
                                                                                    <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'formationQuestionnaire', '', 'scp');" style="margin-right: 5px;" title="Voir actions"><i class="icon-eye-open"></i>Voir les formations</a>
                                                                                </li>-->
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editscp|0', '', '');" style="margin-right: 5px;" title="Modifier"><i class="icon-edit"></i>Modifier</a>
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

    static function formMaj($retour, $id = "") {
        $critere = "WHERE codeunique = '" . $id . "'";
        $d = scp::scpParCritere($critere);
        $b = (sizeof($d, 1) == 0) ? 0 : 1;
        $deb = date('Y').'_';
        $col = 'numordre';
        $table = 'scp';
        $numordre = ($b == 1) ? $d[0]['numordre'] : principale::initNumero($deb, $col, $table);
        ?> 
        <div id="zoneonglet"></div>
        <div id="info"></div>
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allcotation" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddscp" id="formaddscp" action="" >                    
            <div class="well well-large">               
                <div class="control-group pull-right">
                    <label class="control-label" for="datescp"><strong>Date expédition </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:100px;" name="datescp" id="datescp" class="text ui-widget-content ui-corner-all date" value="<?php echo ($b == 1) ? $d[0]['datescp'] : date('d-m-Y'); ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="numordre"><strong>N° Ordre(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" readonly name="numordre" id="numordre" class="text ui-widget-content ui-corner-all" value="<?php echo $numordre; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="numcolis"><strong>N° Colis(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('numcolis', 0);" name="numcolis" id="numcolis" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['numcolis'] : ''; ?>" />
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
                    <label class="control-label" for="montantremboursement"><strong>Montant remboursement(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.totalscp();" name="montantremboursement" id="montantremboursement" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['montantremboursement'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="droitfixe"><strong>Droit fixe(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.totalscp();" name="droitfixe" id="droitfixe" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['droitfixe'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="taxetransportinterieur"><strong>Taxe de transport a l'intérieur(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.totalscp();"  name="taxetransportinterieur" id="taxetransportinterieur" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['taxetransportinterieur'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="droitdouane"><strong>Droit de douane(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.totalscp();" name="droitdouane" id="droitdouane" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['droitdouane'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="montantavis"><strong> Montant d'avis(*) </strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onchange="JPrincipal.totalscp();" name="montantavis" id="montantavis" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['montantavis'] : ''; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="montanttotal"><strong> Total(*) </strong></label>
                    <div class="controls">
                        <input type="text" readonly style="height:30px; width:210px;"  name="montanttotal" id="montanttotal" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['montanttotal'] : ''; ?>" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">   
                        <a href="#" onclick="JTraitement.valider('<?php echo $id; ?>', '<?php echo $retour; ?>');" id="allcotation" class="btn btn-small btn-info"> valider </a>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    public static function valider($id, $retour, $champ) {       //Functions::afficheBoiteMsg($retour);
        $scp = new scp($id);
//        Functions::afficheBoiteMsg('Dieu est grand');
        $scp->setdatescp(Functions::convertDate($champ[0]));
        $scp->setNumordre(addslashes($champ[1]));
        $scp->setNumcolis($champ[2]);
        $scp->setIdpaysorigine(addslashes($champ[3]));
        $scp->setIdexpediteur($champ[4]);
        $scp->setIddestinataire($champ[5]);
        $scp->setMontantremboursement($champ[6]);
        $scp->setDroitfixe($champ[7]);
        $scp->setTaxetransportinterieur($champ[8]);
        $scp->setDroitdouane($champ[9]);
        $scp->setMontantavis($champ[10]);
//        $scp->setMontanttotal($champ[11]);
      
        
        $result = 0;
        if ($id == "") {
            $result = $scp->ajoutScp();
            
        } else {
            $result = $scp->modifScp();
        }
        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le scp n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);

                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le scp a été enregistré avec succès. </div>').fadeIn(300).fadeOut(2000);
                    JPrincipal.afficheContenu('<?php echo $id; ?>', '<?php echo $retour; ?>', '', '');
                </script>                    
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le scp que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
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
        $montantavis = "";
        $droitfixe = "";
        if (isset($_SESSION['montantavis'])) {
            $montantavis = $_SESSION['montantavis'];
        }
        if (isset($_SESSION['droitfixe'])) {
            $droitfixe = $_SESSION['droitfixe'];
        }
        if ($montantavis != "" && $montantavis != '0')
            $critere .= "WHERE montantavis = '" . $montantavis . "' ";
        if ($droitfixe != "" && $droitfixe != '0') {
            $critere .= ($critere == "") ? " WHERE droitfixe = '" . $droitfixe . "' " : " AND droitfixe = '" . $droitfixe . "' ";
        }
        $titre = scp::afficheTitre($conf);

        switch ($conf) {
            case 'scp':
                $taxetransportinterieurfichier = "quesionnair"; // Ne pas dépasser 11 caractères au total sinon erreur                
                $donnee = scp::scpParCritere($critere);

                $tabAlign = array("L", "L", "L");
                $listlargeurtitre = array(80, 55, 55); //total 190
                $listtitre = array("Centre", "Corps", "Taxetransportinterieur", "Prétaxetransportinterieurs", "Ancienneté corps", "Ancienneté poste", "Date remplissage",
                    "Q1", "Q2année1", "Q2année2", "Q2année3", "Q2année4", "Q3mod1", "Q3mod2", "Q3mod3",
                    "Q3mod4", "Q3mod5", "Q3mod6", "Q3mod7", "Q3mod8", "Q3mod9", "Q3mod10",
                    "Q4", "Q5", "Q6con1", "Q6con2", "Q6con3", "Q6con4", "Q6con5",
                    "Q6con6", "Q6con7", "Q6con8", "Q6con9", "Q6con10", "Q7", "Q8",
                    "Q8a1", "Q8a2", "Q8a3", "Q8a4", "Q8a5", "Q8a6", "Q8a7", "Q8aAutrechangement",
                    "Q8b", "Q9", "Q9a1", "Q9a2", "Q9a3", "Q9b1", "Q9b2",
                    "Q10", "Q11COGES/COGECS", "Q11Comité départemental/national", "Q11a Nbre de fois", "Q11a Occasion",
                    "Q11b Nbre de fois", "Q11b Occasion", "Q11c Conclusion COGES/COGECS", "Q11c Conclusion Comité départemental/national",
                    "Q11d", "Q12");

                $listcolonneBD = array("centre", "corps", "taxetransportinterieur", "droitdouane", "fraismagcoilisjour", "lieuxscp", " echeance",
                    "datelivraison", "iddestinataire", "idexpediteur", "idbureauechange", "idactionlivraison", "nbelement", "datescp", "idpaysdestion",
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

        return array($titre, $listtitre, $listcolonneBD, $listlargeurtitre, $taxetransportinterieurfichier, $donnee, $orientation, $borduretableau, $hautdoc, $basdoc, $tabAlign, $corps);
    }

}
?>
 