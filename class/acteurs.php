<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of acteurs
 *
 * @author Manda
 */
class acteurs {//`id`, `codeunique`, `designation`, `perscontact`, `adresse`, `telephone`, `idcreateur`
    //put your code here

    var $id;
    var $codeunique;
    var $designation;
    var $perscontact;       
    var $adresse;
    var $telephone;
    var $idcreateur;

    public function __construct($codeunique) {
        $rekete = "SELECT * FROM acteurs WHERE codeunique = '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->designation = $list["designation"];
            $this->perscontact = $list["perscontact"];
            $this->adresse = $list["adresse"];
            $this->telephone = $list["telephone"];
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

    public function getDesignation() {
        return $this->designation;
    }

    public function setDesignation($designation) {
        $this->designation = $designation;
    }

    public function getPerscontact() {
        return $this->perscontact;
    }

    public function setPerscontact($perscontact) {
        $this->perscontact = $perscontact;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }

    public static function designationActeur($codeunique) {
        $rub = new acteurs($codeunique);//construteur
        return $rub->getDesignation();
    }

    public static function designationActeurAdresse($codeunique) {
        $act = new acteurs($codeunique);//construteur
        return $act->getDesignation().'  ('.$act->getAdresse().' )';
    }

    public function verifDoublon() {
        $rekete = "SELECT * FROM acteurs WHERE designation = '" . $this->designation . "' AND perscontact = '" . $this->perscontact . "' ";
        $result = Functions::commit_sql($rekete, "");       // Functions::afficheBoiteMsg($rekete);
        $retour = false;
        if ($result) {
            $ls = $result->fetch();
            if ($ls['id'] != '')
                $retour = true;
        }

        return $retour;
    }

    public function ajoutActeurs() {
        if (!$this->verifDoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'acteurs');
            $rekete = "INSERT INTO acteurs(designation,codeunique,perscontact,adresse,telephone,idcreateur) VALUES('" . $this->designation . "','" . $this->codeunique . "','" . $this->perscontact . "'";
            $rekete .= ",'" . $this->adresse . "','" . $this->telephone . "','" . $_SESSION['user']['codeunique'] . "' )";

            $result = Functions::commit_sql($rekete, "");          //  echo 'Merci '.$rekete;

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
        $condition = "designation = ?  AND perscontact = ? AND codeunique <> ? ";
        $param = array($this->designation, $this->perscontact, $this->codeunique);
        $result = Functions::get_record_byCondition("acteurs", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifActeurs() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE acteurs SET designation ='" . $this->designation . "',perscontact ='" . $this->perscontact . "' ";
            $rekete .= ",adresse ='" . $this->adresse . "' ,telephone ='" . $this->telephone . "'";
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

    public function suppActeurs() {
        if (principale::suppressionPossible("acteurs", $this->codeunique)) {
            $rekete = "DELETE FROM acteurs WHERE codeunique= '" . $this->codeunique . "'";

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
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["num"] = $i+1;
                $affich[$i]["designation"] = $list["designation"];
                $affich[$i]["perscontact"] = $list["perscontact"];
                $affich[$i]["codeunique"] = $list["codeunique"];
                $affich[$i]["adresse"] = $list["adresse"];
                $affich[$i]["telephone"] = $list["telephone"];
                                
                $i++;
            }
        }
        return $affich;
    }

    public static function acteursParCritere($critere = "") {
        $rekete = "SELECT * FROM acteurs " . $critere;
        $result = Functions::commit_sql($rekete, "");
        $affich = acteurs::donnee($result);
        return $affich;
    }

    public static function listActeursPourCombo() {
        $donnee = acteurs:: getAllActeursInfos();
        $list = '';
        $i = 0;
        foreach ($donnee as $v) {
            if ($i > 0) {
                $list .= '-->';
            }
            $list .= $v['codeunique'] . '|' . $v['designation'];
            $i++;
        }

        return $list;
    }

    public static function afficheTitre($conf) {
        ?>

        <?php
        $titre = '';
        switch ($conf) {
            case 'acteurs':
                $titre = "Liste des acteurs";
                break;

            case 'addacteurs':
                $titre = "Ajout d'acteurs ";
                break;

            case 'editacteurs':
                $titre = "Modification d'acteurs";
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = acteurs::afficheTitre($conf);
        $critere = "";
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'acteurs':
                $donnee = acteurs::acteursParCritere($critere);
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="#" onclick="JPrincipal.afficheContenu(0, 'addacteurs', '', '<?php echo $retour; ?>');" id="addsecteur" class="btn btn-small btn-success"><i class="icon-plus-sign icon-white"></i> Nouveau</a>                
                    </div>
                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printliste" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportliste" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                <?php
                acteurs::afficheListe($donnee);
                ?>
                </div>
                <?php
                break;
            case 'addacteurs':
                $retour = 'acteurs';
                acteurs::formAddEdit($retour, '');
                break;
            case 'editacteurs':
                $retour = 'acteurs';
                $codeunique = '';
                if (isset($_SESSION['idenreg']))
                    $codeunique = $_SESSION['idenreg'];
                acteurs::formAddEdit($retour, $codeunique);
                break;
        }
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun information n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <!--les differentes noms pour les entetes-->
                    <tr class="menu_gauche">
                        <th><strong>N°</strong></th>
                        <th><strong>Désignation</strong></th>
                        <th><strong>Personne contact</strong></th>
                        <th><strong>Adresse</strong></th>
                        <th><strong>Téléphone</strong></th>
                        <th style="width: 110px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
            <?php
            $i = 0;
            foreach ($donnee as $v) :
                $i++;
                ?>
                    <!--les données a l'interieur de ces entetes-->
                        <tr>                            
                            <td><?php echo $v['num'] ?></td>
                            <td><?php echo $v['designation'] ?></td>
                            <td><?php echo $v['perscontact'] ?></td>
                            <td><?php echo $v['adresse'] ?></td>
                            <td><?php echo $v['telephone'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                        Action
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">                                            
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'editacteurs', '', '');"  title="Modifier"><i class="icon-edit"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn btn-small btn-danger" onclick="JCommrecial.supprimer('<?php echo $v['codeunique'] ?>', 'suppActeurs');"  title="Supprimer"><i class="icon-remove-sign icon-white"></i>Supprimer</a>
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
          //formulaire d ajout ou modification des données
                $critere = "WHERE codeunique = '" . $codeunique . "'";
                $d = acteurs::acteursParCritere($critere); //
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
                    <label class="control-label" for="designation"><strong>Designation (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:400px;" onkeyup="JPrincipal.enMajuscule('designation', 1);" name="designation" id="designation" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['designation'] : ""; ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="perscontact"><strong>Perscontact (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:400px;" onkeyup="JPrincipal.enMajuscule('perscontact', 1);" name="perscontact" id="perscontact" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['perscontact'] : ""; ?>" />&nbsp;
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="adresse"><strong>Adresse (*)</strong></label>
                    <div class="controls">
                        <textarea type="text" row='3' style=" width:400px;" onkeyup="JPrincipal.enMajuscule('adresse', 1);" name="adresse" id="adresse" class="text ui-widget-content ui-corner-all" ><?php echo ($b == 1) ? $d[0]['adresse'] : ""; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="telephone"><strong>Telephone (*)</strong></label>
                    <div class="controls">
                        <input type="text" style="height:30px; width:120px;" name="telephone" id="telephone" class="text ui-widget-content ui-corner-all" value="<?php echo ($b == 1) ? $d[0]['telephone'] : ""; ?>" />&nbsp;
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">                        
                        <input type="button" onclick="JTraitement.valider('<?php echo $codeunique; ?>', 'acteurs');" class="btn btn-small btn-success" value="Enregistrer"/>
                    </div>
                </div>   
            </div>                         
        </form>                        
        <?php
    }

    public static function valider($codeunique, $retour, $champ) {
        $e = new acteurs($codeunique);
        $e->setDesignation(addslashes($champ[0]));
        $e->setPerscontact(addslashes($champ[1]));
        $e->setAdresse(addslashes($champ[2]));
        $e->setTelephone($champ[3]);

        $result = 0;
        if ($codeunique == "") {
            $result = $e->ajoutActeurs();
        } else {
            $result = $e->modifActeurs();
        }
        switch ($result) {
            case '0':
                ?>
                <script>
                            $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La acteurs n\'a pas été enregistrée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La acteurs a été enregistrée avec succès. </div>').fadeIn(1000);
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La acteurs que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

}
?>

