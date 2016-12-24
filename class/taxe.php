<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of taxe
 *
 * @author Manda
 */
class taxe {

    //put your code here
    var $id;
    var $codeunique;
    var $libelle;
    var $taux;

    public function __construct($codeunique) {      
        $rekete = "SELECT * FROM taxe WHERE codeunique = '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->libelle = $list["libelle"];
            $this->taux = $list["taux"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
    
    
    public function getTaux() {
        return $this->taux;
    }

    public function setTaux($taux) {
        $this->taux = $taux;
    }

    public function getCodeunique() {
        return $this->codeunique;
    }

    public function setCodeunique($codeunique) {
        $this->codeunique = $codeunique;
    }
    
    public static function libTaxe($codeunique){
        $rub = new taxe($codeunique);
        return $rub->getLibelle();
    }
    
    public static function tauxTaxe($codeunique){
        $rub = new taxe($codeunique);        
        return ($codeunique==''||$codeunique=='0')?0:$rub->getTaux();
    }

    public function verifDoublon() {
            $rekete = "SELECT * FROM taxe WHERE libelle = '".$this->libelle."' ";
        $result = Functions::commit_sql($rekete, ""); 
        $retour = false;
        if($result){
            $ls = $result->fetch();
            if($ls['id']!='') $retour = true;
        }

        return $retour; 
    }

    public function ajoutTaxe() {
        if (!$this->verifDoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'taxe');
            $rekete = "INSERT INTO taxe(libelle,codeunique,taux) VALUES('".$this->libelle."','".$this->codeunique."','".$this->taux."')";
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
        $condition = "libelle = ?  AND codeunique <> ? ";
        $param = array($this->libelle, $this->codeunique);
        $result = Functions::get_record_byCondition("taxe", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifTaxe() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE taxe SET libelle ='" . $this->libelle . "',taux ='" . $this->taux . "' ";
            $rekete .= "WHERE codeunique = '" . $this->codeunique . "'";
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

    public function suppTaxe() {
        $rekete = "DELETE FROM taxe WHERE codeunique= '".$this->codeunique."'";
     
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo  principale::ajoutReketeSynchro($rekete);
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
                $affich[$i]["libelle"] = $list["libelle"];
                $affich[$i]["taux"] = $list["taux"];
                $affich[$i]["codeunique"] = $list["codeunique"];
                $i++;
            }
        }
        return $affich;
    }

    public static function taxeParCritere($critere = "") {
        $rekete = "SELECT * FROM taxe ".$critere;        
        $result = Functions::commit_sql($rekete, "");
        $affich = taxe::donnee($result);
        return $affich;
    }

    public static function listTaxePourCombo() {
        $donnee = taxe:: getAllTaxeInfos();
        $list = '';
        $i = 0;
        foreach ($donnee as $v) {
            if ($i > 0) {
                $list .= '-->';
            }
            $list .= $v['id'] . '|' . $v['libelle'];
            $i++;
         
        }

        return $list;
    }

    public static function afficheTitre($conf) {
        ?>

        <?php
        $titre = '';
        switch ($conf) {
            case 'taxe':
                $titre = "Liste des taxes";
                break;

            case 'addtaxe':
                $titre = "Ajout de taxe ";
                break;

            case 'edittaxe':
                $titre = "Modification de taxe";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = taxe::afficheTitre($conf);
     $critere = "";
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'taxe':
                $donnee = taxe::taxeParCritere($critere);
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addtaxe', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    taxe::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addtaxe':
                $retour = 'taxe';
                taxe::formAddEdit($retour, '');
                break;
            case 'edittaxe':
                $retour = 'taxe';
                $codeunique = '';
                if (isset($_SESSION['idenreg']))
                    $codeunique = $_SESSION['idenreg'];
                taxe::formAddEdit($retour, $codeunique);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun domaine d'activité n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">
                        <th><strong>Libellé</strong></th>
                        <th><strong>Taux (%)</strong></th>
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
                            <td><?php echo $v['libelle'] ?></td>
                            <td><?php echo $v['taux'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">                                            
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'edittaxe', '', '');"  title="Modifier"><i class="icon-edit"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn btn-small btn-danger" onclick="JCommrecial.supprimer('<?php echo $v['codeunique'] ?>','suppTaxe');"  title="Supprimer"><i class="icon-remove-sign icon-white"></i>Supprimer</a>
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

    static function formAddEdit($retour, $codeunique = '') {
         $critere = "WHERE codeunique = '" . $codeunique . "'";
        $d = taxe::taxeParCritere($critere); //
        $b = (sizeof($d, 1) > 0) ? 1 : 0;
        
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
                                <label class="control-label" for="libelle"><strong>Libellé (*)</strong></label>
                                <div class="controls">
                                    <input type="text" style="height:30px; width:400px;" onkeyup="JPrincipal.enMajuscule('libelle', 1);" name="libelle" id="libelle" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['libelle'] : ""; ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="taux"><strong>Taux (*)</strong></label>
                                <div class="controls">
                                    <input type="text" style="height:30px; width:80px;" name="taux" id="taux" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['taux'] : ""; ?>" />&nbsp;%
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label"></label>
                                <div class="controls">                        
                                    <input type="button" onclick="JCommrecial.valider('<?php echo $codeunique; ?>','taxe');" class="btn btn-small btn-success" value="Enregistrer"/>
                                </div>
                            </div>   
                        </div>                         
                    </form>                        
        <?php
    }

    public static function valider($codeunique, $retour, $champ) {
        $e = new taxe($codeunique);
        $e->setLibelle(addslashes($champ[0]));
        $e->setTaux($champ[1]);

        $result = 0;
        if ($codeunique == "") {
            $result = $e->ajoutTaxe();
        } else {
            $result = $e->modifTaxe();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La taxe n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La taxe a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La taxe que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>

