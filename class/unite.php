<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of unite
 *
 * @author Manda
 */
class unite {

    //put your code here
    var $id;
    var $codeunique;
    var $idtypeunite;
    var $libelle;
    var $idcreateur;

    function __construct($codeunique) {
        $rekete = "SELECT * FROM unite WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->idtypeunite = $list["idtypeunite"];
            $this->libelle = $list["libelle"];
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

    public function getIdtypeunite() {
        return $this->idtypeunite;
    }

    public function setIdtypeunite($idtypeunite) {
        $this->idtypeunite = $idtypeunite;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }
    
    public static function libunite($idunite){
        $f = new unite($idunite);
        return $f->getLibelle();
    }

    public function verifDoublon() {
        $condition = "libelle = ? AND idtypeunite = ? ";
        $param = array($this->libelle, $this->idtypeunite);
        $result = Functions::get_record_byCondition("unite", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifDoublonMod() {
        $condition = "libelle = ? AND idtypeunite = ? AND codeunique <> ?";
        $param = array($this->libelle, $this->codeunique);
        $result = Functions::get_record_byCondition("unite", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutUnite() {
        if (!$this->verifDoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'unite');
            $rekete = "INSERT INTO unite (codeunique,idtypeunite,libelle,idcreateur) ";
            $rekete .= "VALUES('" . $this->codeunique . "','" . $this->idtypeunite . "','" . $this->libelle . "','" . $_SESSION["user"]["codeunique"] . "')";
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

    public function modifUnite() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE unite SET idtypeunite = '" . $this->idtypeunite . "',libelle='" . $this->libelle . "' WHERE codeunique = '" . $this->codeunique . "'";
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

    public function suppUnite() {
        if (principale::suppressionPossible('unite', $this->codeunique) == 1) {
            $rekete = "DELETE FROM unite WHERE codeunique = '" . $this->codeunique . "'";
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
                $affich[$i]["libelle"] = $list["libelle"];
                $affich[$i]["idtypeunite"] = $list["idtypeunite"];               
                $affich[$i]["typeunite"] = typeunite::libType($list["idtypeunite"]);
                $affich[$i]["idcreateur"] = $list["idcreateur"];

                $i++;
            }
        }
        return $affich;
    }

    public static function uniteParCritere($critere) {
        $rekete = "SELECT * FROM unite " . $critere;
        $result = Functions::commit_sql($rekete, "");
        $affich = unite::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'unite':
                $titre = "Liste des unités";
                break;

            case 'addunite':
                $titre = "Ajout d'unité ";
                break;

            case 'editunite':
                $titre = "Modification d'unité";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $idtype = "";
        $critere = "";
        if (isset($_SESSION['idtypeunite'])){
        $idtype = $_SESSION['idtypeunite'];
        $critere = "WHERE idtypeunite = '".$idtype."'";
        }
        $titre = unite::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
<form class="form-horizontal" method="post" name="formadd" id="formadd" action="" >
        <div class="control-group">
            <label class="control-label" for="idtypeunite"><strong>Type d'unité (*)</strong></label>
            <div class="controls">
                <?php
                $onchangeCmbTypeUnite = "JPrincipal.onchangeCmbTypeUnite('$conf');";
                echo Functions::LoadCombo("SELECT * FROM typeunite", "id", "libelle", "idtypeunite", "Sélectionnez le type d'unité", "300", $onchangeCmbTypeUnite, $idtype);
                ?>       
            </div>
        </div>
    </form>
        <?php
        switch ($conf) {
            case 'unite':
                $donnee = unite::uniteParCritere($critere);
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addunite', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    unite::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;
            case 'addunite':
                $retour = 'unite';
                unite::formAddEdit($retour, "");
                break;
            case 'editunite':
                $retour = 'unite';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                unite::formAddEdit($retour, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
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
                    <tr class="menu_gauche">                        
                        <th style='width: 20px;'><strong>N°</strong></th>
                        <th><strong>Type d'unité</strong></th>
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
                            <td><?php echo $v['typeunite'] ?></td>
                            <td><?php echo $v['libelle'] ?></td>                           
                            <td>
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editunite', '', '');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>
                                <a href="#" class="btn btn-small btn-danger" onclick="JCommrecial.supprimer('<?php echo $v['codeunique'] ?>','supprunite');" style="margin-right: 10px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
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
        $idtypeunite = '';        
        if (isset($_SESSION['idtypeunite']))
        $idtypeunite = $_SESSION['idtypeunite'];
        $libelle = "";
        if ($id != 0) {
            $S = new unite($id);
            $idtypeunite = $S->getIdtypeunite();            
            $libelle = $S->getLibelle();
        }
        ?> 
        <div id="info"></div>
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allsecteur" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formadd" id="formadd" action="" >                    
            <div class="well well-large">       
               
                <div class="control-group">
                    <label class="control-label" for="libelle"><strong>Libellé (*)</strong></label>
                    <div class="controls">
                        <input type="hidden" style="height:30px; width:40px;"  name="idtypeunite" id="idtypeunite" class="text ui-widget-content ui-corner-all" value="<?php echo $libelle; ?>" />
                        <input type="text" style="height:30px; width:400px;" onkeyup="JPrincipal.enMajuscule('libelle', 1);" name="libelle" id="libelle" class="text ui-widget-content ui-corner-all" value="<?php echo $libelle; ?>" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JCommrecial.valider('<?php echo $id; ?>','<?php echo $retour; ?>');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>
        <?php
    }

    public static function valider($codeunique, $retour, $champ) {
        $f= new unite($codeunique);
        $f->setIdtypeunite($champ[0]);
        $f->setLibelle(addslashes($champ[1]));
       
        $result = 0;
        if ($codeunique == "") {
            $result = $f->ajoutUnite();
        } else {
            $result = $f->modifUnite();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La unite n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La unite a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La  unite que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>
