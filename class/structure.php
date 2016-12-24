<?php

class structure {

    var $id;
    var $codeunique;
    var $denomination;
    var $idtypestructure;
    var $sigle;
    var $idlocalite;
    var $idstructuremere;
    var $idchefstructure;

    public function __construct($id) {
        $id = (int) $id;
        $result = Functions::get_record_byfield("structure", "id", $id);
        if ($result != false) {
            $list = $result->fetch();
            $this->id = $list["id"];
             $this->codeunique = $list["codeunique"];
            $this->denomination = $list["denomination"];
            $this->sigle = $list["sigle"];
            $this->idtypestructure = $list["idtypestructure"];
            $this->idlocalite = $list["idlocalite"];
            $this->idstructuremere = $list["idstructuremere"];
            $this->idchefstructure = $list["idchefstructure"];
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

        public function getDenomination() {
        return $this->denomination;
    }

    public function setDenomination($denomination) {
        $this->denomination = $denomination;
    }

    public function getIdtypestructure() {
        return $this->idtypestructure;
    }

    public function setIdtypestructure($idtypestructure) {
        $this->idtypestructure = $idtypestructure;
    }

    public function getSigle() {
        return $this->sigle;
    }

    public function setSigle($sigle) {
        $this->sigle = $sigle;
    }

    public function getIdlocalite() {
        return $this->idlocalite;
    }

    public function setIdlocalite($idlocalite) {
        $this->idlocalite = $idlocalite;
    }

    public function getIdstructuremere() {
        return $this->idstructuremere;
    }

    public function setIdstructuremere($idstructuremere) {
        $this->idstructuremere = $idstructuremere;
    }

    public function getIdchefstructure() {
        return $this->idchefstructure;
    }

    public function setIdchefstructure($idchefstructure) {
        $this->idchefstructure = $idchefstructure;
    }
    public static function sigleTypeStructure($idstruc){
        $sigle = "";
        $rekete = "SELECT typestructure.* FROM typestructure, structure ";
        $rekete .= " WHERE typestructure.id = structure.idtypestructure ";
        $rekete .= "AND structure.id ='".$idstruc."'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            if($list = $result->fetch())
                    $sigle = $list['sigle'];
       }
       return $sigle;
    }

    public function verifDoublon() {
        $result = Functions::get_record_byfield("structure", "denomination", $this->denomination);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutStructure() {
        if (!$this->verifDoublon()) {
             if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'structure');
            $rekete = "INSERT INTO structure(codeunique,denomination,idtypestructure,sigle,idlocalite,idstructuremere,idchefstructure,idcreateur) ";
            $rekete . "VALUES('".$this->codeunique."','".$this->denomination."', ".$this->idtypestructure.", '".$this->sigle."', '".$this->idlocalite."', '".$this->idstructuremere."', '".$this->idchefstructure."', ".$_SESSION['user']['id'].")";
//            $param = array($this->denomination, $this->idtypestructure, $this->sigle, $this->idlocalite, $this->idstructuremere, $this->idchefstructure, $_SESSION['user']['id']);
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

    public function verifDoublonMod() {
        $condition = "denomination = ? AND codeunique <> ? ";
        $param = array($this->denomination, $this->codeunique);
        $result = Functions::get_record_byCondition("structure", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifStructure() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE structure SET denomination =".$this->denomination.", idtypestructure=".$this->idtypestructure.", sigle=".$this->sigle.", idlocalite=".$this->idlocalite.", idstructuremere=".$this->idstructuremere.", idchefstructure=".$this->idchefstructure."  WHERE codeunique =".$this->codeunique." ";
//            $param = array($this->denomination, $this->idtypestructure, $this->sigle, $this->idlocalite, $this->idstructuremere, $this->idchefstructure, $this->id);
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

    public function suppStructure() {
        $rekete = "DELETE FROM structure WHERE codeunique = '" . $this->codeunique . "'";
//        $param = array($this->id);
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
           echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }
    
    public static function libStructureParId($id){
        $struct = new structure($id);
        return $struct->getDenomination();
    }

    public static function donnee($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["denomination"] = $list["denomination"];
                $affich[$i]["sigle"] = $list["sigle"];

                $affich[$i]["idtypestructure"] = $list["idtypestructure"];
                $typestructure = new typestructure($list["idtypestructure"]);
                $affich[$i]["typestructure"] = $typestructure->getLibelle();

                $affich[$i]["idlocalite"] = $list["idlocalite"];
                $localite = new localite($list["idlocalite"]);
                $affich[$i]["localite"] = $localite->getLibelle();

                $affich[$i]["idstructuremere"] = $list["idstructuremere"];
                $structure = new structure($list["idstructuremere"]);
                $affich[$i]["structuremere"] = $structure->getDenomination();

                $affich[$i]["idchefstructure"] = $list["idchefstructure"];
                $personne = new personne($list["idchefstructure"]);
                $affich[$i]["chefstructure"] = $personne->getNomPrenom();
                $i++;
            }
        }
        return $affich;
    }

    public static function getAllStructureInfos() {
        $rekete = "SELECT * FROM structure";
        $result = Functions::commit_sql($rekete, "");
        $affich = structure::donnee($result);
        return $affich;
    }

    public static function listStructPourCombo() {         //Functions::afficheBoiteMsg('Merci');
        $donnee = structure:: getAllStructureInfos();
        $list = '';
        $i = 0;
        foreach ($donnee as $v) {
            if ($i > 0) {
                $list .= '-->';
            }
            $list .= $v['id'] . '|' . $v['denomination'];
            $i++;

            //Functions::afficheBoiteMsg($v['id'].'|'.$v['denomination']);            
        }

        return $list;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'structure':
                $titre = "Liste des structures";
                break;

            case 'addstructure':
                $titre = "Ajout de structure ";
                break;

            case 'editstructure':
                $titre = "Modification de structure";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = structure::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'structure':
                $donnee = structure::getAllStructureInfos();
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addstructure', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    structure::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addstructure':
                $retour = 'structure';
                structure::formAddEdit($retour, 0);
                break;
            case 'editstructure':
                $retour = 'structure';
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                structure::formAddEdit($retour, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune structure n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>Sigle</strong></th>
                        <th><strong>Dénomination</strong></th>
                        <th><strong>Type de structure</strong></th>
                        <th><strong>Localite</strong></th>
                        <th><strong>Structure mère</strong></th>
                        <th><strong>Chef structure</strong></th>
                        <th style="width: 110px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                            
                            <td><?php echo $v['sigle'] ?></td>
                            <td><?php echo $v['denomination'] ?></td>
                            <td><?php echo $v['typestructure'] ?></td>
                            <td><?php echo $v['localite'] ?></td>
                            <td><?php echo $v['structuremere'] ?></td>
                            <td><?php echo $v['chefstructure'] ?></td>
                            <td>
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editstructure', '', '');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>
                                <a href="#" class="btn btn-small btn-danger" onclick="JStructure.suppStructure('<?php echo $v['codeunique'] ?>');" style="margin-right: 10px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
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

    static function formAddEdit($retour, $id = 0) {
        $sigle = "";
        $denomination = "";
        $idtypestructure = 0;
        $idstructuremere = 0;
        $idlocalite = 0;
        $idchefstructure = 0;
        if ($id != 0) {
            $S = new structure($id);
            $denomination = $S->getDenomination();
            $sigle = $S->getSigle();
            $idtypestructure = $S->getIdtypestructure();
            $idstructuremere = $S->getIdstructuremere();
            $idlocalite = $S->getIdlocalite();
            $idchefstructure = $S->getIdchefstructure();
        }
        ?> 
        <div id="info"></div>
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allsecteur" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddedit" id="formaddedit" action="" >                    
            <div class="well well-large">               

                <div class="control-group">
                    <label class="control-label" for="sigle"><strong>Sigle</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:100px;" name="sigle" id="sigle" class="text ui-widget-content ui-corner-all" value="<?php echo $sigle; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="denomination"><strong>Dénomination (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:290px;" name="denomination" id="denomination" class="text ui-widget-content ui-corner-all" value="<?php echo $denomination; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idtypestructure"><strong>Type de structure (*)</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo("SELECT * FROM typestructure", "id", "libelle", "idtypestructure", "Sélectionnez le type de la structure", "210", "", $idtypestructure);
                        ?>  
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idlocalite"><strong>Localité (*)</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo("SELECT * FROM localite where idtypelocalite=2", "id", "libelle", "idlocalite", "Sélectionnez la localité", "210", "", $idlocalite);
                        ?>  
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idstructuremere"><strong>Structure mère (*)</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo("SELECT * FROM structure", "id", "denomination", "idstructuremere", "Sélectionnez la structure mère", "210", "", $idstructuremere);
                        ?>  
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="idchefstructure"><strong>Chef structure (*)</strong></label>
                    <div class="controls">
                        <?php
                        echo Functions::LoadCombo("SELECT *, CONCAT(nom,' ',prenom) as nomprenom FROM personne", "id", "nomprenom", "idchefstructure", "Sélectionnez le chef structure", "210", "", $idchefstructure);
                        ?>  
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JStructure.validerStructure('<?php echo $id; ?>');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    public static function valider($id, $retour) {
        $structure = new structure($id);
        $structure->setDenomination($_GET['denomination']);
        $structure->setSigle($_GET['sigle']);
        $structure->setIdtypestructure($_GET['idtypestructure']);
        $structure->setIdlocalite($_GET['idlocalite']);
        $structure->setIdstructuremere($_GET['idstructuremere']);
        $structure->setIdchefstructure($_GET['idchefstructure']);

        $result = 0;
        if ($id == 0) {
            $result = $structure->ajoutStructure();
        } else {
            $result = $structure->modifStructure();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                     $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La structure n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La structure a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La structure que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>

