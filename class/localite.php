<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of localite
 *
 * @author Manda
 */
class Localite {

    var $id;
    var $codeunique;
    var $libelle;
    var $idtypelocalite;
    var $idlocalitemere;
    var $codelocalite;
    var $libunique;
    var $idzonesanitaire;

    public function __construct($codeunique) {

//        $table = Localite::getTableName();

        $rekete = "SELECT * FROM localite WHERE codeunique ='" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];

            $this->codeunique = $list["codeunique"];
            $this->libelle = $list["libelle"];
            $this->idtypelocalite = $list["idtypelocalite"];
            $this->idzonesanitaire = $list["idzonesanitaire"];
            $this->idlocalitemere = $list["idlocalitemere"];
            $this->codelocalite = $list["codelocalite"];
            $this->libunique = $list["libunique"];
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

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    public function getIdtypelocalite() {
        return $this->idtypelocalite;
    }

    public function setIdtypelocalite($idtypelocalite) {
        $this->idtypelocalite = $idtypelocalite;
    }

    public function getIdlocalitemere() {
        return $this->idlocalitemere;
    }

    public function setIdlocalitemere($idlocalitemere) {
        $this->idlocalitemere = $idlocalitemere;
    }

    public function getCodelocalite() {
        return $this->codelocalite;
    }

    public function setCodelocalite($codelocalite) {
        $this->codelocalite = $codelocalite;
    }

    public function getLibunique() {
        return $this->libunique;
    }

    public function setLibunique($libunique) {
        $this->libunique = $libunique;
    }

    public function getIdzonesanitaire() {
        return $this->idzonesanitaire;
    }

    public function setIdzonesanitaire($idzonesanitaire) {
        $this->idzonesanitaire = $idzonesanitaire;
    }

    public static function zonesanitaire($idlocalite) {
        $loc = new Localite($idlocalite);
        return Zonesanitaire::libzonesanitaire($loc->getIdzonesanitaire());
    }

    public static function liblocalite($idlocalite) {
        $loc = new Localite($idlocalite);
        return $loc->getLibelle();
    }

    public static function libuniquelocalite($idlocalite) {
        $loc = new Localite($idlocalite);
        return $loc->getLibunique();
    }

    public static function commune($idlocalite) {
        $loc = new Localite($idlocalite);
        $typ = $loc->getIdtypelocalite();
        $idl = "";
        switch ($typ) {
            case 2:
                $idl = $idlocalite;
                break;

            case 3:
                $idl = $loc->getIdlocalitemere();
                break;

            case 4:
                $idm = $loc->getIdlocalitemere();
                $lm = new Localite($idm);
                $idl = $lm->getIdlocalitemere();
                break;
        }
        return $idl;
    }

    public static function localiteparcritere($critere) {
        $rekete = "SELECT * FROM licalite " . $critere;
        $result = Functions::commit_sql($rekete, "");
        return Localite::donnee($result);
    }

    public static function getTableName() {
        return "localite";
    }

    public static function getPrefix() {
        return "lloc";
    }

    public static function donnee($result) {
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["num"] = $i + 1;
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["idtypelocalite"] = $list["idtypelocalite"];
                switch ($list["idtypelocalite"]) {
                    case '1':
                        $affich[$i]["typelocalite"] = "DEPARTEMENT";
                        break;
                    case '2':
                        $affich[$i]["typelocalite"] = "COMMUNE";
                        break;
                    case '3':
                        $affich[$i]["typelocalite"] = "ARRONDISSEMENT";
                        break;
                    case '4':
                        $affich[$i]["typelocalite"] = "QUARTIER";
                        break;
                }
                $affich[$i]["idlocalitemere"] = $list["idlocalitemere"];
                $affich[$i]["localitemere"] = Localite::libuniquelocalite($list["idlocalitemere"]);
                $affich[$i]["libelle"] = $list["libelle"];
                $affich[$i]["libunique"] = $list["libunique"];
                $affich[$i]["codelocalite"] = $list["codelocalite"];
                $affich[$i]["idzonesanitaire"] = $list["idzonesanitaire"];
                $affich[$i]["zonesanitaire"] = Zonesanitaire::libzonesanitaire($list["idzonesanitaire"]);

                $i++;
            }
        }
        return $affich;
    }

    public static function donneeImprimer($conf) {
        $orientation = 'p'; //Portrait
        $borduretableau = 1; //Portrait par défaut        
        $hautdoc = array();
        $basdoc = array();
        $corps = "";
        $titre = Localite::afficheTitre($conf);

        /*

         */
        switch ($conf) {
            case 'localite':
            case 'localiteParZone':
                $critere = "";
                $donnee = Localite::localiteparcritere($critere);
                $nomfichier = "localite"; // Ne pas dépasser 11 caractères au total sinon erreur                
                if ($conf == 'localiteParZone') {
                    if (isset($_SESSION['idenreg']))
                        $id = $_SESSION['idenreg'];
                    $donnee = Zonesanitaire::localiteParZoneSanitaire($id);
                }
                $listtitre = array("N°", "Zone sanitaire", "Type de localité", "Localité mère", "Libellé");
                $tabAlign = array("L", "L", "L", "L");
                $listcolonneBD = array("num", "zonesanitaire", "typelocalite", "localitemere", "libunique");
                $listlargeurtitre = array(10, 45, 45, 45, 45); //total 190
                break;
        }

        return array($titre, $listtitre, $listcolonneBD, $listlargeurtitre, $nomfichier, $donnee, $orientation, $borduretableau, $hautdoc, $basdoc, $tabAlign, $corps);
    }

    public static function afficheTitre($conf) {
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        $id = '';
        if (isset($_SESSION['idenreg']))
            $id = $_SESSION['idenreg'];
        //$l = new Localite($id);
        switch ($conf) {
            case 'localite':
                $titre = "Liste des localités";
                break;

            case 'localiteParZone':
                $titre = "Liste des localités de " . Zonesanitaire::libzonesanitaire($id);
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        $titre = Localite::afficheTitre($conf);
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo strtoupper($titre); ?> </h4>
        </div> 
        <?php
        switch ($conf) {
            case 'localite':
            case'localiteParZone':
                switch ($conf) {
                    case 'localite':
                        $critere = "";
                        $donnee = Localite::localiteparcritere($critere);
                        break;
                    case 'localiteParZone':
                        $retour = Zonesanitaire::getPrefix();
                        if (isset($_SESSION['idenreg']))
                            $id = $_SESSION['idenreg'];
                        $donnee = Zonesanitaire::localiteParZoneSanitaire($id);
                        break;
                }
                ?> 
                <div id="info"></div>

                <div class="btn-toolbar">

                    <div class="btn-group">
                        <?php if ($conf == 'localite') { ?>  <a href="#" onclick="JPrincipal.afficheContenu(0, 'addlocalite', '', '<?php echo $retour; ?>');" id="addeffet" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Nouveau</a>   <?php } ?>             
                        <?php if ($conf == 'localiteParZone') { ?>  <a href="#" onclick="JPrincipal.afficheContenu(0, '<?php echo $retour; ?>', '', '<?php echo $retour; ?>');" id="allcotation" class="btn btn-small"><i class="icon-arrow-left"></i> Retour</a>   <?php } ?>             
                    </div>

                    <div class="btn-group pull-right">
                        <a href="#" onclick="JVisualisation.imprimer('<?php echo $conf; ?>');" id="printsigleabreviation" class="btn btn-small"><i class="icon-print"></i> Imprimer</a>
                        <a href="#" onclick="JVisualisation.exportexcel('<?php echo $conf; ?>');" id="exportsigleabreviation" class="btn btn-small"><i class="icon-download"></i> Exporter</a>
                    </div>
                    <img id="loading" style="margin-left: 10px; visibility: hidden; width: 30px; height: 30px" alt="Loading" title="Loading..." src="./images/loader.gif" />
                </div>

                <div id="zoneListeSite" data-spy="scroll">
                    <?php
                    Localite::afficheListe($donnee, $conf);
                    ?>
                </div>
                <?php
                break;
        }
    }

    static function afficheListe($donnee, $conf) {
        $confsup = "supplocalite";

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
                        <th><strong>N°</strong></th>
                        <?php if ($conf == 'localite') { ?>
                            <th><strong>Zone sanitaire</strong></th>
                        <?php } ?>
                        <th><strong>Type de localité</strong></th>
                        <th><strong>Localité mère</strong></th>
                        <th><strong>Libellé</strong></th>                                               
                        <!--<th ><strong>Action</strong></th>-->                        
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                            
                <!--                            <td><?php // echo $v['activite']                     ?></td>-->
                            <td><?php echo $v['num'] ?></td>
                            <?php if ($conf == 'localite') { ?>
                                <td><?php echo $v['zonesanitaire']; ?></td> 
                            <?php } ?>
                            <td><?php echo$v['typelocalite']; ?></td>                           
                            <td><?php echo $v['localitemere']; ?></td>                           
                            <td><?php echo $v['libunique']; ?></td>                          
                <!--                            <td>
                                <div class="btn-group" >
                                    <a href="#"class="btn dropdown-toggle" data-toggle="dropdown" >
                                        Action
                                        <span class="caret">

                                        </span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'detailstache', '', 'tache');" style="margin-right: 5px;" title="Voir actions"><i class="icon-eye-open"></i>Voir résultats</a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn btn-small" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'edittache', '', '');" style="margin-right: 5px;" title="Modifier"><i class="icon-edit"></i>Modifier</a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn btn-small btn-danger" onclick="JTraitement1.supprimer('<?php echo $v['codeunique']; ?>', '<?php echo $confsup; ?>');" style="margin-right: 5px;" title="Supprimer"><i class="icon-remove-sign icon-white"></i>Supprimer</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>-->
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
