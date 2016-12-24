<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of droitacces
 *
 * @author Manda
 */
class droitacces {

    //put your code here
    var $id;
    var $codeunique;
    var $idprofil;
    var $idelement;
    var $element;
    var $lecture;
    var $ecriture;
    var $suppression;

    public function __construct($codeunique) {
        $rekete = "SELECT * FROM droitacces WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->idprofil = $list["idprofil"];
            $this->idelement = $list["idelement"];
            $this->lecture = $list["lecture"];
            $this->ecriture = $list["ecriture"];
            $this->suppression = $list["suppression"];
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

    public function getIdelement() {
        return $this->idelement;
    }

    public function setIdelement($idelement) {
        $this->idelement = $idelement;
    }

    public function getIdprofil() {
        return $this->idprofil;
    }

    public function setIdprofil($idprofil) {
        $this->idprofil = $idprofil;
    }

    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    public function getLecture() {
        return $this->lecture;
    }

    public function setLecture($lecture) {
        $this->lecture = $lecture;
    }

    public static function lecturePar($id) {
        $droit = new droitacces($id);
        return $droit->lecture;
    }

    public static function ecriturePar($id) {
        $droit = new droitacces($id);
        return $droit->ecriture;
    }

    public function getEcriture() {
        return $this->ecriture;
    }

    public function setEcriture($ecriture) {
        $this->ecriture = $ecriture;
    }

    public function getSuppression() {
        return $this->suppression;
    }

    public function setSuppression($suppression) {
        $this->suppression = $suppression;
    }

    public function verifdoublon() {
        $condition = "element = ? AND idelement = ?  AND idprofil=?";
        $param = array($this->element, $this->idelement, $this->idprofil);
        $result = Functions::get_record_byCondition("droitacces", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public static function idDroitParCritere($idprofil, $element, $idelement) {
        $rekete = "SELECT * FROM droitacces WHERE idprofil= '" . $idprofil . "' AND element = '" . $element . "' AND idelement='" . $idelement . "' ";
        $result = Functions::commit_sql($rekete, "");        //echo $rekete;
        $id = "";
        if ($result) {
            $list = $result->fetch();
            if ($list['codeunique'] != NULL)
                $id = $list['codeunique'];
        }
        return $id;
    }

    public function ajoutDroitAcces() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'droitacces');
            $rekete = "INSERT INTO droitacces(codeunique,idelement,idprofil,element,lecture,ecriture,suppression) ";
            $rekete .= "VALUES('".$this->codeunique."','".$this->idelement."','".$this->idprofil."','".$this->element."','".$this->lecture."','".$this->ecriture."','".$this->suppression."')";
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

    public function verifdoublonMod() {
        $condition = "element = ? AND idelement = ?  AND idprofil=? AND codeunique <> ? ";
        $param = array($this->element, $this->idelement, $this->idprofil, $this->codeunique);
        $result = Functions::get_record_byCondition("droitacces", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifDroitAcces() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE droitacces SET lecture ='" . $this->lecture . "',ecriture ='" . $this->ecriture . "' ,suppression ='" . $this->suppression . "'  WHERE codeunique = '" . $this->codeunique . "'";
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

    public function suppDroitAcces($id) {      
        list($element, $idelement, $idprofil) = explode(",", $id);
        $rekete = "DELETE FROM droitacces WHERE idprofil = '".$idprofil."' AND idelement='".$idelement."' AND element='".$element."'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function donnees($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["idprofil"] = $list["idprofil"];
                $affich[$i]["element"] = $list["element"];
                $affich[$i]["idelement"] = $list["idelement"];
                $affich[$i]["lecture"] = $list["lecture"];
                $affich[$i]["lecture"] = $list["lecture"];
                $affich[$i]["ecriture"] = $list["ecriture"];
                $affich[$i]["suppression"] = $list["suppression"];
                $i++;
            }
        }
        return $affich;
    }

    //droits par profil    
    public static function droitAccesParProfil($idprofil) {
        $rekete = "SELECT * FROM droitacces WHERE  idprofil='" . $idprofil . "' ORDER BY element,idelement ASC";
        $result = Functions::commit_sql($rekete, "");
        return droitacces::donnees($result);
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'droitacces':
                $titre = "Gestion des droits d'accès par profil";
                break;

            case 'adddroitacces':
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];

                $leprofil = new profil($id);
                $titre = "Attribution des droits d'accès au profil: " . $leprofil->getLibelleprofil();
                break;

            case 'listedroitP':
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $leprofil = new profil($id);
                $titre = "Liste des menus du profil: " . $leprofil->getLibelleprofil();
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = droitacces::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4> <?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'droitacces':
                $profil = new profil("");
                $donnee = $profil->getAllProfilInfos();
                ?>
                <div id="info"></div>           

                <div id="zoneListeSite">
                    <?php
                    droitacces::afficheListe($donnee, "listPro");
                    ?>
                </div>
                <?php
                break;

            case 'adddroitacces':
            case 'detailsDroitProfil':
                $retour = 'droitacces';
                $idprofil = "";
                $element = "";
                if (isset($_SESSION['idenreg']))
                    $idprofil = $_SESSION['idenreg'];
                if (isset($_SESSION['element']))
                    $element = $_SESSION['element'];
                ?>
                <div id="info"></div>           

                <div id="zoneadd">

                </div>
                <div id="zoneListeSite">
                    <?php
                    droitacces::formadd($idprofil, $retour, $element, $conf);
                    ?>
                </div>
                <?php
                break;

            case'listeDroitP':
                $retour = 'droitacces';
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $donnee = droitacces::droitAccesParProfil($id);
                ?>
                <div id="info"></div>           
                <p>
                    <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allmenu" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                    <a href="#" onclick="JDroitAcces.supprimerDesDroitAcces('<?php echo $id; ?>');" class="btn btn-small btn-danger"><i class="icon-minus-sign"></i> Supprimer les cochés</a>
                </p>
                <div id="zoneListeSite">
                    <?php
                    droitacces::afficheListe($donnee, "listD", $id);
                    ?>
                </div>
                <?php
                break;
        }
    }

    static function afficheListe($donnee, $cas) {

        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune ligne n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">  

                        <?php
                        if ($cas == "listPro") {
                            ?>
                            <th><strong>Profils</strong></th>                           
                            <?php
                        }
                        ?>

                        <th style="width: 95px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :

                        $i++;
                        ?>
                        <tr> 

                            <?php
                            if ($cas == "listPro") {
                                ?>
                                <td><?php echo $v['libelleprofil'] ?></td>     
                                <td> 
                                    <a href="#" class="btn btn-small btn-success" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'adddroitacces', '', '');" style="margin-right: 5px;" title="Attribuer"><i class="icon-plus-sign"></i></a>
                                    <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'detailsDroitProfil', '', '');" style="margin-right: 5px;" title="Voir détails"><i class="icon-eye-open"></i></a>  
                                </td>

                                <?php
                            }
                            ?>

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

    static function addDroitAcces($id, $retour) {
        list($element, $idelement, $idprofil) = explode(",", $id);
        $S = new droitacces("");
        $S->setIdelement($idelement);
        $S->setIdprofil($idprofil);
        $S->setElement($element);
        $S->setLecture($_GET['lect']);
        $S->setEcriture($_GET['ecri']);
        $S->setSuppression(0);
        $result = $S->ajoutDroitAcces();

        switch ($result) {
            case '0':
                ?>
                <script>
                        $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil n\'a pas été ajouté pour l\'utilisateur : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le menu a été ajouté avec succès pour ce profil. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu('<?php echo $idprofil; ?>', '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le menu que vous tentez d\'ajouté à ce profil existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    static function addDroitAccesMulti($tablo, $retour) {
        $n = count($tablo);      //  echo 'Merci '.$n;
        $rs = 0;
        for ($i = 0; $i < $n; $i++) {            
            if ($tablo[$i] != "") {

                list($idprofil, $element, $idelement, $lect, $ecri) = explode("|", $tablo[$i]);
                $id = droitacces::idDroitParCritere($idprofil, $element, $idelement);               //Functions::afficheBoiteMsg($idprofil.' element '.$element.' idelement '.$idelement);
                $S = new droitacces($id);
                $S->setIdelement($idelement);
                $S->setIdprofil($idprofil);
                $S->setElement($element);
                $S->setLecture($lect);               // Functions::afficheBoiteMsg($id);
                $S->setEcriture($ecri);                
                $S->setSuppression(0);
                if ($id == "") {
                    if(($lect!=0)||($ecri!=0)){
                    $rs += $S->ajoutDroitAcces();
                    }
                } else {
                    $rs += $S->modifDroitAcces();
                }
            }
        }
        if ($rs == $n)
            $result = 1; else {
            if ($rs == 0) {
                $result = 3;
            } else {
                if ($rs == 0)$result = 0; else $result = 1;
            }
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil n\'a pas été ajouté pour l\'utilisateur : erreur de connexion. </div>').fadeIn(1000).fadeOut(5000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le menu a été ajouté avec succès pour ce profil. </div>').fadeIn(1000).fadeOut(5000);
                    JPrincipal.afficheContenu('<?php echo $idprofil; ?>', '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;
            case '3':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Aucun menu n\'a été séléctionné. </div>').fadeIn(500).fadeOut(5000);
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le menu que vous tentez d\'ajouté à ce profil existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    static function supprDroitAccesMulti($tablo, $retour) {
        $n = count($tablo);
        $rs = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($tablo[$i] != "") {
                list($idprofil, $idelement) = explode("|", $tablo[$i]);
                $rekete = "DELETE FROM droitacces WHERE idprofil ='" . $idprofil . "'  AND idelement='" . $idelement . "'";

                $resultat = Functions::commit_sql($rekete, "");
                if ($resultat) {
                    principale::ajoutReketeSynchro($rekete);
                    $rs++;
                }
            }
        }
        if ($rs == $n)
            $result = 1; else {
            if ($tablo[0] == 0) {
                $result = 3;
            } else {
                $result = 0;
            }
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Au menu n\'a  été supprimé à ce profil pour l\'utilisateur : erreur de connexion. </div>').fadeIn(1000).fadeOut(5000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Les menus ont été supprimés avec succès pour ce profil. </div>').fadeIn(1000).fadeOut(5000);
                    JPrincipal.afficheContenu('<?php echo $idprofil; ?>', '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;
            case '3':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Aucun menu n\'a été séléctionné. </div>').fadeIn(500).fadeOut(5000);
                </script>
                <?php
                break;
        }
    }

    public static function formadd($idprofil, $retour, $element, $conf) {       // Functions::afficheBoiteMsg($conf);
        $donnee = array();
        $valconf = 0;
        switch ($conf) {
            case 'adddroitacces':
                $donnee = element::contenuElement($element, $idprofil, $conf);
                $valconf = 1;
                break;
            case 'detailsDroitProfil':
                $donnee = element::contenuElement($element, $idprofil, $conf);
                $valconf = 15; 
                break;
        }
        ?>
        <!--<div class="well well-large">-->
        <p>
            <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allmenu" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
            <a href="#" onclick="JDroitAcces.ajoutDesDroitAcces('<?php echo $idprofil; ?>', '<?php echo $element; ?>', '<?php echo $conf; ?>');" class="btn btn-small btn-success"><i class="icon-plus-sign"></i> Valider les cochés</a>
        </p>  
        <form class="form-horizontal" method="post" name="formaddDroitProfil" id="formaddDroitProfil" action="" >
            <div class="control-group" >
                <label class="control-label" for="elt"><strong>Eléments (*)</strong></label>
                <div class="controls">
                    <?php
                    $onchange = "JDroitAcces.onChangeCmbElement($valconf)";
                    $idcombos = "element";
                    $rek = "SELECT * FROM element WHERE id < 3 ";
                    echo Functions::LoadCombo($rek, "id", "libelle", $idcombos, "Sélectionnez l'élément", "260", $onchange, $element);
                    ?>   
                </div>
            </div> 
        </form>       

        <?php
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune ligne n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">  
                        <th style="width: 50px"><strong>N°</strong></th> 
                        <th><strong>Libellé</strong></th> 
                        <th style="width: 40px">
                            Lecture<label  for="coch" class="checkbox inline" title="Tout cocher" style="cursor:pointer;" >
                                <input name="coch" id="coch" style=""  type="checkbox" onclick="if (this.checked)
                        JDroitAcces.cocherTout('chkL');
                    else
                        JDroitAcces.decocherTout('chkL');"  title="Tout cochez pour la suppression" />
                            </label>               
                        </th>
                        <th style="width: 40px;"> 
                            Ecriture<label  for="coch" class="checkbox inline" title="Tout cocher" style="cursor:pointer;" >
                                <input name="coch" id="coch" style=""  type="checkbox" onclick="if (this.checked)
                        JDroitAcces.cocherTout('chkE');
                    else
                        JDroitAcces.decocherTout('chkE');"  title="Tout cochez pour la suppression" />
                            </label>            
                        </th>

                                                            <!--<th style="width: 95px"><strong>Action</strong></th>-->                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :

                        $i++;
                        ?>
                        <tr> 

                            <td><?php echo $i ?></td>
                            <td><?php echo $v['libelle'] ?></td>
                            <td>
                                <?php
                                $checkL = "";
                                if ($v['lecture'] == 1)
                                    $checkL = "checked = true"; //echo $v['lecture'];68519709 96321419
                                ?>
                                <label class="checkbox" title="Sélectionner">
                                    <input type="checkbox" value="<?php echo $v['codeunique'] ?>" <?php echo $checkL ?> name="chkL<?php echo $i ?>" id="chkL<?php echo $i ?>" />                                        
                                </label>

                            </td> 
                            <td>
                                <?php
                                $checkE = "";
                                if ($v['ecriture'] == 1)
                                    $checkE = "checked = true";
                                ?>
                                <label class="checkbox" title="Sélectionner" style=''>
                                    <input  type="checkbox" value="<?php echo $v['codeunique'] ?>" <?php echo $checkE ?> name="chkE<?php echo $i ?>" id="chkE<?php echo $i ?>" />                                        

                                </label>
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

}
?>
