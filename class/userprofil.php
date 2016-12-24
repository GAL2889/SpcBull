<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userprofil
 *
 * @author Manda
 */
class userprofil {

    //put your code here
    var $id;
    var $codeunique;
    var $idUtilisateur;
    var $idProfil;
    var $idcreateur;

    public function __construct($id) {

        $id = (int) $id;
        $rekete = "SELECT * FROM utilisateurprofil WHERE codeunique ='" . $id . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->idUtilisateur = $list["idUtilisateur"];
            $this->idProfil = $list["idProfil"];
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

    public function getIdUtilisateur() {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur($idUtilisateur) {
        $this->idUtilisateur = $idUtilisateur;
    }

    public function getIdProfil() {
        return $this->idProfil;
    }

    public function setIdProfil($idProfil) {
        $this->idProfil = $idProfil;
    }

    public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }

    public function verifdoublon() {
        $condition = "idUtilisateur = ?  AND idProfil=?";
        $param = array($this->idUtilisateur, $this->idProfil);
        $result = Functions::get_record_byCondition("utilisateurprofil", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutUserProfil() {
         if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'utilisateurprofil');
            $rekete = "INSERT INTO utilisateurprofil(codeunique, idUtilisateur,idProfil,idcreateur) ";
            $rekete .= "VALUES('" . $this->codeunique . "','" . $this->idUtilisateur . "','" . $this->idProfil . "','". $_SESSION["user"]["codeunique"]. "')";
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

    public function suppUserProfil($id) {
        //supprimer ce profil pour cet utilisateur
        list($iduser, $idprofil) = explode(",", $id);
        $rekete = "DELETE FROM utilisateurprofil WHERE idProfil = ?  AND idUtilisateur=?";
        $param = array($idprofil, $iduser);
        $result = Functions::commit_sql($rekete, $param);
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    //Utilisateurs par profil    

    public static function getAllUserProfilInfos($idprofil) {
        $rekete = "SELECT utilisateur.* FROM utilisateur, utilisateurprofil WHERE utilisateur.id=utilisateurprofil.idUtilisateur AND idProfil=" . $idprofil . "";
        $result = Functions::commit_sql($rekete, "");
        $affich = utilisateur::donneeUtilisateur($result);
        return $affich;
    }

    //Les profils d'un utilisateur    

    public static function profilsParUtilisateur($idutilisateur) {
        global $dbh;
        $stmt = $dbh->prepare("SELECT profil.* FROM profil, utilisateurprofil WHERE profil.id = utilisateurprofil.idProfil AND  utilisateurprofil.idUtilisateur = '" . $idutilisateur . "'");
        $affich = array();
        if ($stmt->execute()) {
            $i = 0;
            while ($list = $stmt->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["libelleprofil"] = $list['libelleprofil'];
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
            case 'adduserprofil':
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];

                $leprofil = new profil($id);
                $titre = "Attribution du profil: " . $leprofil->getLibelleprofil();
                break;

            case 'listeuserProfil':
                $id = "";
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $leprofil = new profil($id);
                $titre = "Liste des utilisateurs ayant le profil: " . $leprofil->getLibelleprofil();
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = userprofil::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo $titre; ?> </h4>
        </div> 
        <?php
        $retour = "profil";
        switch ($conf) {
            case 'adduserprofil':
                $user = new utilisateur("");
                $donnee = $user->getAllutilisateurDjaProfilInfos();
                ?>
                <div id="info"></div>           
                <p>
                    <!--<a href="index.php?config=profil" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>-->
                    <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                </p>
                <div id="zoneadd">

                </div>
                <div id="zoneListeSite">
                    <?php
                    userprofil::afficheListe($donnee, "add");
                    ?>
                </div>
                <?php
                break;
            case 'listeuserProfil':
                $id = 0;
                if (isset($_SESSION['idenreg']))
                    $id = $_SESSION['idenreg'];
                $donnee = userprofil::getAllUserProfilInfos($id);
                ?>
                <div id="info"></div>           
                <p>
                    <!--<a href="index.php?config=profil" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>-->
                    <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '<?php echo ''; ?>', '<?php echo $retour; ?>');" id="allprofil" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>
                </p>
                <div id="zoneListeSite">
                    <?php
                    userprofil::afficheListe($donnee, "list");
                    ?>
                </div>
                <?php
                break;
        }
    }

    static function afficheListe($donnee, $cas) {
        $id = 0;
        if (isset($_SESSION['idenreg']))
            $id = $_SESSION['idenreg'];

        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun utilisateur n'est disponible pour le moment
            </div>
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">                        
                        <th><strong>Nom  & Prénom</strong></th>                         
                        <th><strong>Login</strong></th>                         
                        <!--<th><strong>Structure</strong></th>-->                         
                        <!--<th><strong>Fonction</strong></th>-->                         
                        <th style="width: 20px"><strong>Action</strong></th>                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                      
                            <td><?php echo $v['nomprenom'] ?></td>    
                            <td><?php echo $v['login'] ?></td>    
                            <!--<td><?php echo $v['denomination'] ?></td>-->    
                            <!--<td><?php echo $v['fonction'] ?></td>-->    
                            <td>
                                <?php
                                if ($cas == "add") {
                                    ?>
                                    <a href="#" class="btn btn-small btn-success" onclick="JUserProfil.ajoutUserProfil('<?php echo $v['id'] . "," . $id; ?>');" style="margin-right: 10px;" title="Attribuer"><i class="icon-plus-sign" ></i></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="btn btn-small btn-danger" onclick="JUserProfil.suppUserProfil('<?php echo $v['id'] . "," . $id; ?>', '<?php echo $id; ?>');" title="Supprimer"><i class="icon-remove-sign icon-white"></i></a>
                                    <?php
                                }
                                ?>

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

    static function addUserProfil($id, $retour) {
        list($iduser, $idprofil) = explode(",", $id);
        $S = new userprofil("");
        $S->setIdUtilisateur($iduser);
        $S->setIdProfil($idprofil);
        $result = $S->ajoutUserProfil();

        switch ($result) {
            case '0': // Erreur d'enregistrement dans la base
                ?>
                <script>
                        $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil n\'a pas été ajouté pour l\'utilisateur : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1': // Enregistrement dans la base effectué
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil a été ajouté avec succès pour l\'utilisateur. </div>').fadeIn(1000);
                    //                    document.location.href = "index.php?config=adduserprofil";
                    JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le profil que vous tentez d\'ajouté a cet utilisateur existe déja. </div>').fadeIn(500);
                    //document.location.href = "index.php?config=adduserprofil";
                </script>
                <?php
                break;
        }
    }

}
?>
