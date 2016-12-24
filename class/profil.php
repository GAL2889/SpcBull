<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profil
 *
 * @author Manda
 */
class profil {

    //put your code here
    var $id;
    var $codeunique;
    var $libelleprofil;
    var $idcreateur;

    public function __construct($codeunique) {
        $rekete = "SELECT * FROM profil WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->libelleprofil = $list["libelleprofil"];
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
    
    public function getLibelleprofil() {
        return $this->libelleprofil;
    }

    public function setLibelleprofil($libelleprofil) {
        $this->libelleprofil = $libelleprofil;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }
    
    public static function idParcodeunique($codunique){
        $id = 0;
        $rekete = "SELECT * FROM profil WHERE codeunique ='".$codunique."'";
         $result = Functions::commit_sql($rekete, "");
            if ($result) {
                $ls = $result->fetch();
                if($ls['id']!='') $id = $ls['id'];
            }
        return $id;
    }

    public function verifdoublon() {
        $condition = "libelleprofil = ? ";
        $param = array($this->libelleprofil);
        $result = Functions::get_record_byCondition("profil", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifdoublonmod() {
        $condition = "libelleprofil = ? AND codeunique <> ?";
        $param = array($this->libelleprofil, $this->codeunique);
        $result = Functions::get_record_byCondition("profil", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutprofil() {
        if (!$this->verifdoublon()) {
            
            $rekete = "INSERT INTO profil(codeunique,libelleprofil,idcreateur) ";
            $rekete .= "VALUES('".$this->codeunique."','".$this->libelleprofil."','".$_SESSION["user"]["codeunique"]."')";
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

    public function modifprofil() {
        if (!$this->verifdoublonmod()) {
            $rekete = "UPDATE profil SET libelleprofil = '".$this->libelleprofil."' WHERE codeunique = '".$this->codeunique."'";
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

    public function suppProfil() {
        //On vérifie s'il existe au moins un utilisateur avec ce profil
        $condition = "idProfil = ? ";
        $param = array($this->id);
        $resultPossible = Functions::get_record_byCondition("utilisateurprofil", $condition, $param);
        $msg = "";
        if ($resultPossible == false) {
            //suppression possible
            $rekete = "DELETE FROM profil WHERE codeunique = '".$this->codeunique."'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                echo principale::ajoutReketeSynchro($rekete);
            } else {
                echo '0';
            }
        } else {
            $msg = "Il existe au moins un utilisateur qui ce profil \n Vous ne pouvez donc pas le supprimer ";
            echo '5';
        }
    }

    public static function donnee($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["libelleprofil"] = $list["libelleprofil"];
                $i++;
            }
        }
        return $affich;
    }

    public static function getAllProfilInfos() {
        $rekete = "SELECT * FROM profil";
        $result = Functions::commit_sql($rekete, "");
        $affich = profil::donnee($result);
        return $affich;
    }

    public static function afficheTitre($conf) {
         ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'profil':
                $titre = "Liste des profils";
                break;

            case 'addprofil':
                $titre = "Ajout de profil";
                break;

            case 'editprofil':
                $titre = "Modification de profil";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = profil::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'profil':
                $donnee = profil::getAllProfilInfos();
                ?>      
                <div class="btn-toolbar">
                    <div class="btn-group pull-left">
                        <!--<a href="index.php?config=addprofil" onclick="" id="addprofil" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau profil</a>-->                
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addprofil', '', '<?php echo $retour; ?>');" id="addprofil" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printprofil" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportprofil" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="info"></div>           

                <div id="zoneListeSite">
                    <?php
                    profil::afficheListe($donnee);
                    ?>
                </div>
                <?php
                break;

            case 'addprofil':
                $retour = 'profil';
                profil::formAdd($retour);
                break;

            case 'editprofil':
                $retour = 'profil';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                profil::formEdit($retour, $id);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun profil n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">                        
                        <th><strong>Libellé</strong></th>                         
                        <th style="width: 203px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                      
                            <td><?php echo $v['libelleprofil'] ?></td>    
                            <td>
                                <!--<a href="#" class="btn btn-small" onclick=" JProfil.formEditProfil('<?php echo $v['codeunique'] ?>');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>-->
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editprofil', '', '');" style="margin-right: 10px;" title="Modifier"><i class="icon-edit"></i></a>
                                <?php
                                switch ($v['id']) {
                                    case 1:
                                    case 2:
                                    case 3:
                                    case 4:
                                    case 5:
                                    case 6:
                                        //pas d suppression
                                        break;
                                    default:
                                ?>
                                <a href="#" class="btn btn-small btn-danger" onclick="JProfil.suppProfil('<?php echo $v['codeunique'] ?>');" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
                                <?php
                                        break;
                                }
                                ?>
                                <!--<a href="#" class="btn btn-small btn-success" onclick="JProfil.formAddUserProfil('<?php echo $v['codeunique']; ?>');" style="margin-right: 10px;" title="Attribuer ce profil"><i class="icon-plus-sign icon-white"></i></a>-->
                                <a href="#" class="btn btn-small btn-success" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'adduserprofil', '', '');" style="margin-right: 10px;" title="Attribuer ce profil"><i class="icon-plus-sign icon-white"></i></a>
                                <!--<a href="#" class="btn btn-small" onclick="JProfil.formDetailsUser('<?php echo $v['codeunique']; ?>');" style="margin-right: 10px;" title="Voir Détails"><i class="icon-eye-open"></i></a>-->
                                <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'listeuserProfil', '', '');" style="margin-right: 10px;" title="Voir Détails"><i class="icon-eye-open"></i></a>
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

    static function formAdd($retour) {
        ?>      
        <div id="info"></div>
        <p>
            <!--<a href="index.php?config=profil" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>-->
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddProfil" id="formaddBudget" action="" enctype="multipart/form-data">  
            <div class="well well-large">
                <div class="control-group">
                    <label class="control-label" for="libprofil"><strong>Libellé profil(*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:210px;" name="libprofil" id="libprofil" class="text ui-widget-content ui-corner-all" value="" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JProfil.ajoutProfil();" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>

            </div>            
        </form>
        <?php
    }

    static function addProfil($retour) {
        $S = new profil("");
        $S->setLibelleprofil(strtoupper($_GET['libprofil']));
        $result = $S->ajoutprofil();

        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil a été enregistré avec succès. </div>').fadeIn(1000);
                //                    document.location.href = "index.php?config=profil";
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    static function formEdit($retour, $id) {
        $profil = new profil($id);
        $libprofil = $profil->getLibelleprofil();
        ?>      
        <div id="info"></div>
        <p>
            <!--<a href="index.php?config=profil" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>-->
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
        </p>
        <div id="zoneadd">

        </div>
        <p class="validateTips"><b>Tous les champs (*) sont obligatoires</b></p>
        <form class="form-horizontal" method="post" name="formeditprofil" id="formeditprofile" action="" enctype="multipart/form-data">                                    
            <div class="control-group">
                <label class="control-label" for="libprofil"><strong>Libellé profil (*)</strong></label>
                <div class="controls">
                    <input type="text" style="height:30px; width:210px;" name="libprofil" id="libprofil" class="text ui-widget-content ui-corner-all" value="<?php echo $libprofil; ?>" />
                </div>
            </div>       

            <div class="control-group">
                <div class="controls">
                    <input type="button" onclick="JProfil.editProfil(<?php echo $id; ?>);" class="btn btn-success" value="Modifier"/>
                </div>
            </div>
        </form>
        <?php
    }

    static function editProfil($id, $retour) {
        $S = new profil($id);
        $S->setLibelleprofil(strtoupper($_GET['libprofil']));
        $result = $S->modifprofil();

        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil a été modifié avec succès. </div>').fadeIn(1000);
                //                    document.location.href = "index.php?config=profil";
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>
