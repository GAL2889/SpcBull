<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menuprofil
 *
 * @author Manda
 */
class menuprofil {

    //put your code here
    var $id;
    var $idmenu;
    var $idprofil;
    var $ordre;
    var $idcreateur;

    public function __construct($id) {

        $id = (int) $id;
        $rekete = "SELECT * FROM menuprofil WHERE id ='" . $id . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->idprofil = $list["idprofil"];
            $this->idmenu = $list["idmenu"];
            $this->idcreateur = $list["idcreateur"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdmenu() {
        return $this->idmenu;
    }

    public function setIdmenu($idmenu) {
        $this->idmenu = $idmenu;
    }

    public function getIdprofil() {
        return $this->idprofil;
    }

    public function setIdprofil($idprofil) {
        $this->idprofil = $idprofil;
    }

    public function getOrdre() {
        return $this->ordre;
    }

    public function setOrdre($ordre) {
        $this->ordre = $ordre;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }

    public function verifdoublon() {
        $condition = "idmenu = ?  AND idprofil=?";
        $param = array($this->idmenu, $this->idprofil);
        $result = Functions::get_record_byCondition("menuprofil", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutMenuProfil() {
        if (!$this->verifdoublon()) {
            $rekete = "INSERT INTO menuprofil(idmenu,idprofil,ordre,idcreateur) VALUES(?,?,?,?)";
            $param = array($this->idmenu, $this->idprofil, $this->ordre, $_SESSION["user"]["id"]);
            $result = Functions::commit_sql($rekete, $param);
            if ($result) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function suppMenuProfil($id) {
        //supprimer ce menu pour ce profil
        list($idmenu, $idprofil) = explode(",", $id);

        $rekete = "DELETE FROM menuprofil WHERE idprofil = ?  AND idmenu=?";
        $param = array($idprofil, $idmenu);
        $result = Functions::commit_sql($rekete, $param);
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    //menu par profil    
    public static function getAllMenuProfilInfos($idprofil) {
        global $dbh;
        $stmt = $dbh->prepare("SELECT menu.* FROM menu, menuprofil WHERE menu.id=menuprofil.idmenu AND idprofil='" . $idprofil . "' order by niveau,menu.id asc");
        $affich = array();
        if ($stmt->execute()) {
            $i = 0;
            while ($list = $stmt->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["libellemenu"] = $list["libellemenu"];
                $affich[$i]["niveau"] = $list["niveau"];
                $affich[$i]["idMenuSuperieur"] = $list["idMenuSuperieur"];
                $i++;
            }
        }
        return $affich;
    }

    //menu par profil   
    public static function listeMenuParProfil($idprofil) {
       $rekete = "SELECT * FROM menu WHERE id IN ";
       $rekete .= " (SELECT idelement FROM droitacces WHERE element = 1 AND idprofil = '".$idprofil."'  AND (lecture = '1' OR ecriture ='1') )";
       $result = Functions::commit_sql($rekete, "");      // echo $rekete;
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["libellemenu"] = $list["libellemenu"];
                $affich[$i]["niveau"] = $list["niveau"];
                $affich[$i]["idMenuSuperieur"] = $list["idMenuSuperieur"];
                $i++;
            }
        }
        return $affich;
    }

    public static function getAllMenuInfos($idprofil) {
        global $dbh;
        $rekete = "SELECT * FROM  menu  where id not in ( select idmenu from menuprofil where idProfil='" . $idprofil . "') order by niveau,id asc";
        $stmt = $dbh->prepare($rekete);        //echo 'Merci '.$rekete;
        $affich = array();
        if ($stmt->execute()) {
            $i = 0;
            while ($list = $stmt->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["libellemenu"] = $list["libellemenu"];
                $affich[$i]["niveau"] = $list["niveau"];
                $affich[$i]["idMenuSuperieur"] = $list["idMenuSuperieur"];
                $i++;
            }
        }
        return $affich;
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'menuprofil':
                $titre = "Gestion des menus par profil";
                break;

            case 'addmenuprofil':
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];

                $leprofil = new profil($id);
                $titre = "Attribution des menus du profil: " . $leprofil->getLibelleprofil();
                break;

            case 'listemenuP':
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $leprofil = new profil($id);
                $titre = "Liste des menus du profil: " . $leprofil->getLibelleprofil();
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = menuprofil::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4> <?php echo $titre; ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'menuprofil':
                $profil = new profil("");
                $donnee = $profil->getAllProfilInfos();
                ?>
                <div id="info"></div>           

                <div id="zoneListeSite">
                    <?php
                    menuprofil::afficheListe($donnee, "listPro");
                    ?>
                </div>
                <?php
                break;

            case 'addmenuprofil':
                $retour = 'menuprofil';
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $donnee = menuprofil::getAllMenuInfos($id);
                ?>
                <div id="info"></div>           
                <p>
                    <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allmenu" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                    <a href="#" onclick="JMenuProfil.ajoutDesMenuProfil('<?php echo $id; ?>');" class="btn btn-small btn-success"><i class="icon-plus-sign"></i> Valider les cochés</a>
                </p>  
                <div id="zoneadd">

                </div>
                <div id="zoneListeSite">
                    <?php
                    menuprofil::afficheListe($donnee, "addM", $id);
                    ?>
                </div>
                <?php
                break;

            case'listemenuP':
                $retour = 'menuprofil';
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $donnee = menuprofil::getAllMenuProfilInfos($id);
                ?>
                <div id="info"></div>           
                <p>
                    <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allmenu" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                    <a href="#" onclick="JMenuProfil.supprimerDesMenuProfil('<?php echo $id; ?>');" class="btn btn-small btn-danger"><i class="icon-minus-sign"></i> Supprimer les cochés</a>
                </p>
                <div id="zoneListeSite">
                    <?php
                    menuprofil::afficheListe($donnee, "listM", $id);
                    ?>
                </div>
                <?php
                break;
        }
    }

    static function afficheListe($donnee, $cas, $idprofilSelect = 0) {

        if ($cas == "listPro") {
            
        }
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
                        } else {
                            ?>
                            <?php if ($cas != "listPro") { ?>
                                <th style="width: 40px">
                                    <label  for="coch" class="checkbox inline" title="Tout cocher" style="cursor:pointer;" >
                                        <input name="coch" id="coch" style=""  type="checkbox" onclick="if (this.checked)
                                                    JMenuProfil.cocherTout();
                                                else
                                                    JMenuProfil.decocherTout();"  title="Tout cochez pour la suppression" />
                                    </label>
                                </th>
                            <?php } ?>
                            <th style="width: 50px"><strong>N°</strong></th> 
                            <th><strong>Menu</strong></th> 
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
                                    <!--<a href="#" class="btn btn-small btn-success" onclick="JMenuProfil.formAddMenuProfil('<?php echo $v['id']; ?>');" style="margin-right: 10px;" title="Attribuer"><i class="icon-plus-sign" ></i></a>-->
                                    <a href="#" class="btn btn-small btn-success" onclick="JPrincipal.afficheContenu('<?php echo $v['id']; ?>', 'addmenuprofil', '', '');" style="margin-right: 5px;" title="Attribuer"><i class="icon-plus-sign"></i></a>
                                 <!--<a href="#" class="btn btn-small" onclick="JMenuProfil.formDetailsMenu('<?php echo $v['id']; ?>');" style="margin-right: 0px;" title="Voir Détails"><i class="icon-eye-open"></i></a>-->
                                    <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['id']; ?>', 'listemenuP', '', '');" style="margin-right: 5px;" title="Voir détails"><i class="icon-eye-open"></i></a>  
                                </td>
                                <?php
                            } elseif ($cas == "addM") {
                                ?>   
                                <td>
                                    <label class="checkbox" title="Sélectionner">
                                        <input type="checkbox" value="<?php echo $v['id'] ?>" name="chk<?php echo $i ?>" id="chk<?php echo $i ?>" />
                                        <input type="hidden" id="param<?php echo $i; ?>" value="<?php echo $v['libellemenu']; ?>"/>
                                    </label>
                                </td> 
                                <td><?php echo $i ?></td>
                                <td><?php echo $v['libellemenu'] ?></td>     
                                <td> 
                                    <a href="#" class="btn btn-small btn-success" onclick="JMenuProfil.ajoutMenuProfil('<?php echo $v['id'] . "," . $idprofilSelect; ?>');" style="margin-right: 10px;" title="Attribuer"><i class="icon-plus-sign" ></i></a>
                                </td>
                                <?php
                            } else {
                                ?>  
                                <td>
                                    <label class="checkbox" title="Sélectionner">
                                        <input type="checkbox" value="<?php echo $v['id'] ?>" name="chk<?php echo $i ?>" id="chk<?php echo $i ?>" />
                                        <input type="hidden" id="param<?php echo $i; ?>" value="<?php echo $v['libellemenu']; ?>"/>
                                    </label>
                                </td> 
                                <td><?php echo $i ?></td>
                                <td><?php echo $v['libellemenu'] ?></td>
                                <td> 
                                    <a href="#" class="btn btn-small btn-danger" onclick="JMenuProfil.suppMenuProfil('<?php echo $v['id'] . "," . $idprofilSelect; ?>', '<?php echo $idprofilSelect; ?>');" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
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

    static function addMenuProfil($id, $retour) {
        list($idmenu, $idprofil) = explode(",", $id);
        $S = new menuprofil("");
        $S->setIdmenu($idmenu);
        $S->setIdprofil($idprofil);
        $S->setOrdre(1);
        $result = $S->ajoutMenuProfil();

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

    static function addMenuProfilMulti($tablo, $retour) {
        $n = count($tablo);
        $rs = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($tablo[$i] != 0) {

                list($idprofil, $idmenu) = explode("|", $tablo[$i]);
                $S = new menuprofil("");
                $S->setIdmenu($idmenu);
                $S->setIdprofil($idprofil);
                $S->setOrdre(1);
                $rs += $S->ajoutMenuProfil();
            }
        }
        if ($rs == $n)
            $result = 1; else {            
            if ($tablo[0] == 0){ 
            $result = 3; }else {
                $result = 0;
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
    
    static function supprMenuProfilMulti($tablo, $retour) {
        $n = count($tablo);
        $rs = 0;
        for ($i = 0; $i < $n; $i++) {
            if ($tablo[$i] != 0) {
                list($idprofil, $idmenu) = explode("|", $tablo[$i]);
                $rekete = "DELETE FROM menuprofil WHERE idprofil ='".$idprofil."'  AND idmenu='".$idmenu."'";
       
        $resultat = Functions::commit_sql($rekete, "");
        if ($resultat) {
           $rs++;
        }                 
            }
        }
        if ($rs == $n)
            $result = 1; else {            
            if ($tablo[0] == 0){ 
            $result = 3; }else {
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

}
?>
