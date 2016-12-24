<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of civilite
 *
 * @author Amanda
 */
class civilite {
    //put your code here
      var $id;
    var $codeunique;
    var $code;
    var $libelle;
   
     public function __construct($codeunique) {
        
        $rekete = "SELECT * FROM civilite WHERE codeunique = '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->code = $list["code"];
            $this->libelle = $list["libelle"];
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
    
    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

        public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public static function libCivilite($idcivilite){
        $c = new civilite($idcivilite);
        return $c->getLibelle();
    }

    public static function codeCivilite($idcivilite){
        $c = new civilite($idcivilite);
        return $c->getCode();
    }

    public function verifdoublon() {
        $condition = "libelle=?";
        $param = array($this->libelle);
        $result = Functions::get_record_byCondition("civilite", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifdoublonmod() {
        $condition = "libelle=? AND codeunique <> ?";
        $param = array($this->libelle, $this->codeunique);
        $result = Functions::get_record_byCondition("civilite", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }
    
      public function ajoutCivilite() { 
        if (!$this->verifdoublon()) { 
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'civilite');
            $rekete = "INSERT INTO civilite(codeunique,libelle,code,idcreateur) ";
            $rekete .= "VALUES('".$this->codeunique."','".$this->libelle."','".$this->code."','". $_SESSION["user"]["codeunique"]."')";
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

    public function modifCivilite() {
        if (!$this->verifdoublonmod()) {
            $rekete = "UPDATE civilite SET libelle= '".$this->libelle."',code= '".$this->code."' WHERE codeunique = '".$this->codeunique."'";
           
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

    public function suppCivilite() {
         if (principale::suppressionPossible('civilite', $this->codeunique) == 1) {
            $rekete = "DELETE FROM civilite WHERE codeunique = '" . $this->codeunique . "'";
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
                $affich[$i]["code"] = $list['code'];
                $affich[$i]["libelle"] = $list["libelle"];
                $i++;
            }
        }
        return $affich;
    }

    public static function getAllCiviliteInfos() {
        $rekete = "SELECT * FROM civilite";
        $result = Functions::commit_sql($rekete, "");
        $affich = civilite::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'civilite':
                $titre = "Liste des civilités";
                break;

            case 'addcivilite':
                $titre = "Ajouter un civilité ";
                break;

            case 'editcivilite':
                $titre = "Modifier un civilité";
                break;
        }
        return $titre;
    }

       static function afficheContenu($conf, $retour) {
        $titre = civilite::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'civilite':
                $donnee = civilite::getAllCiviliteInfos();
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addcivilite', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="print" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="export" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    civilite::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addcivilite':
                $retour = 'civilite';
                civilite::formAddEdit($retour, "");
                break;
            case 'editcivilite':
                $retour = 'civilite';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                civilite::formAddEdit($retour, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun civilité  n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">
                        <th style="width: 10px"><strong>N°</strong></th>
                        <th><strong>Code</strong></th>
                        <th><strong>Libellé</strong></th>
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
                            <td><?php echo $v['num'] ?></td>
                            <td><?php echo $v['code'] ?></td>
                            <td><?php echo $v['libelle'] ?></td>
                            <td>
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editcivilite', '', '');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>
                                <a href="#" class="btn btn-small btn-danger" onclick="JCommrecial.supprimer('<?php echo $v['codeunique'] ?>','supprcivilite');" style="margin-right: 10px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
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

    static function formAddEdit($retour, $id = "") {
        $libelle = "";
        $code = "";
        if ($id != "") {
            $S = new civilite($id);
            $libelle = $S->getLibelle();
            $code = $S->getCode();
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
                    <label class="control-label" for="code"><strong>Code (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('code', 1);" name="code" id="code" class="text ui-widget-content ui-corner-all" value="<?php echo $code; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="libelle"><strong>Libellé (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('libelle', 1);" name="libelle" id="libelle" class="text ui-widget-content ui-corner-all" value="<?php echo $libelle; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JCommrecial.valider('<?php echo $id; ?>','<?php echo $retour; ?>');" class="btn btn-small btn-info" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }
    
     public static function  valider($codeunique, $retour, $champ) {      
        $c= new civilite($codeunique);       
        $c->setCode(addslashes($champ[0]));
        $c->setLibelle(addslashes($champ[1]));
       $result = 0;
        if ($codeunique == "") {
            $result = $c->ajoutCivilite();
        } else {
            $result = $c->modifCivilite();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La civilité n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La civilité a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La civilité que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }
}

?>
