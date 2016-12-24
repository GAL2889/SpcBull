<?php

class parametre {

    var $id;
    var $matriculeencours;
    var $prefixmatricule;
    var $prefixdevis;
    var $numdevisencour;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM parametre WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->matriculeencours = $list["matriculeencours"];
            $this->prefixmatricule = $list["prefixmatricule"];
            $this->prefixdevis = $list["prefixdevis"];
            $this->numdevisencour = $list["numdevisencour"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMatriculeencours() {
        return $this->matriculeencours;
    }

    public function setMatriculeencours($matriculeencours) {
        $this->matriculeencours = $matriculeencours;
    }

    public function getPrefixmatricule() {
        return $this->prefixmatricule;
    }

    public function setPrefixmatricule($prefixmatricule) {
        $this->prefixmatricule = $prefixmatricule;
    }

    public function getPrefixdevis() {
        return $this->prefixdevis;
    }

    public function setPrefixdevis($prefixdevis) {
        $this->prefixdevis = $prefixdevis;
    }

    public function getNumdevisencour() {
        return $this->numdevisencour;
    }

    public function setNumdevisencour($numdevisencour) {
        $this->numdevisencour = $numdevisencour;
    }

    public function verifdoublon() {
        $condition = "(matriculeencours = ? AND prefixmatricule = ? ) OR (numdevisencour = ? AND prefixdevis = ? )";
        $param = array($this->matriculeencours, $this->prefixmatricule, $this->numdevisencour, $this->prefixdevis);
        $result = Functions::get_record_byCondition("parametre", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function verifdoublonmod() {
        $condition = "((matriculeencours = ? AND prefixmatricule = ? ) OR (numdevisencour = ? AND prefixdevis = ? )) AND id <> ? ";
        $param = array($this->matriculeencours, $this->prefixmatricule, $this->numdevisencour, $this->prefixdevis, $this->id);
        $result = Functions::get_record_byCondition("parametre", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifparametre() {
        if (!$this->verifdoublonmod()) {
            $rekete = "UPDATE parametre SET matriculeencours = '" . $this->matriculeencours . "',";
            $rekete .= " prefixmatricule = '" . $this->prefixmatricule . "',";
            $rekete .= " numdevisencour = '" . $this->numdevisencour . "',";
            $rekete .= " prefixdevis = '" . $this->prefixdevis . "'";
            " WHERE id = '" . $this->id . "'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                return personne::ajoutReketeSynchro($rekete);
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function getAllparametreInfos() {
        global $dbh;
        $stmt = $dbh->prepare("SELECT * FROM parametre");
        $affich = array();
        if ($stmt->execute()) {
            $i = 0;
            while ($list = $stmt->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["matriculeencours"] = $list['matriculeencours'];
                $affich[$i]["prefixmatricule"] = $list['prefixmatricule'];
                $affich[$i]["numdevisencour"] = $list['numdevisencour'];
                $affich[$i]["prefixdevis"] = $list['prefixdevis'];

                $i++;
            }
        }
        return $affich;
    }

    public static function formMajMatricule($retour) {
        $p = new parametre(1);
        $lnum = "";
        $lpref = "";
        $num = "";
        $pref = "";
        switch ($retour) {
            case 'majmatricule':
                $lnum = "N° matricule encours";
                $lpref = "Préfix matricule ";
                $num = $p->getMatriculeencours();
                $pref = $p->getPrefixmatricule();
                break;
            case 'majnumdevis':
                $lnum = "N° devis encours";
                $lpref = "Préfix N° devis ";
                $num = $p->getNumdevisencour();
                $pref = $p->getPrefixdevis();
                break;
        }
//        Functions::afficheBoiteMsg('M' . $retour . 'N');
//        $retour = 'Accueil';
        ?>

        <div id="infoparam"></div>

        <div id="zoneadd">

        </div>
        <div class="validateTips"><p class="alert alert-info"><b>Tous les champs (*) sont obligatoires</b></p></div>
        <form class="form-horizontal" method="post" name="formaddDroitProfil" id="formaddDroitProfil" action="" >
            <div class="control-group" >
                <div class="well well-large"> 
                    <div class="control-group">
                        <label class="control-label" for="prefix"><strong><?php echo $lpref; ?> </strong></label>
                        <div class="controls">
                            <input type="text" style="height:30px; width:210px;" onkeyup="JPrincipal.enMajuscule('prefixmatricule', 0);" name="prefixmatricule" id="prefixmatricule" class="text ui-widget-content ui-corner-all" value="<?php echo $pref; ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="nom"><strong><?php echo $lnum; ?>(*)</strong></label>
                        <div class="controls">
                            <input type="text" style="height:30px; width:210px;" name="matriculeencours" id="matriculeencours" class="text ui-widget-content ui-corner-all" value="<?php echo $num; ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">                        
                            <input type="button" onclick="JRubriques.valider('1', 'validerparametre', '<?php echo $retour; ?>');" class="btn btn-small btn-success" value="Enregistrer"/>
                        </div>
                    </div> 
                </div>
            </div>
        </form>
        <?php
    }

    public static function numeroMatriculeencoursParId($id) {
        $param = new parametre($id);
        $n = $param->getMatriculeencours();
//        $n++;
        $ch = $param->getPrefixmatricule();
        if ($n < 10) {
            $ch .= "00";
        } else {
            if ($n < 100)
                $ch .= "0";
        }

        return $ch . $n;
    }

    public static function numeroDeviseencoursParId($id) {
        $param = new parametre($id);
        $n = $param->getNumdevisencour();
//        $n++;
        $ch = $param->getPrefixdevis();       
         if ($n < 10) {
                    $ch .= '000';
                } else  if ($n < 100){
                        $ch .= '00';
                } else {
                    if ($n < 1000)
                        $ch .= '0';
                }


        return $ch . $n;
    }

    public static function initNumeroDeviseencoursParId($id) {
        $param = new parametre($id);
        $n = $param->getNumdevisencour();
        $n++;
        $ch = $param->getPrefixdevis();
         if ($n < 10) {
                    $ch .= '000';
                } else  if ($n < 100){
                        $ch .= '00';
                } else {
                    if ($n < 1000)
                        $ch .= '0';
                }

        return $ch . $n;
    }

    public static function initNumeroMatriculeencoursParId($id) {
        $param = new parametre($id);
        $n = $param->getMatriculeencours();
        $n++;
        $ch = $param->getPrefixmatricule();
        if ($n < 10) {
            $ch .= "00";
        } else {
            if ($n < 100)
                $ch .= "0";
        }

        return $ch . $n;
    }

    public static function actualiseMatriculeencours($id) {
        $parm = new parametre($id);
        $n = $parm->getMatriculeencours();
        $n++;
        $parm->setMatriculeencours($n);
        $parm->modifparametre();
    }

    public static function initImpression($titre, $listtitre, $listcolonneBD, $listlargeurtitre, $nomfichier, $tabrekete, $orientation, $borduretableau, $hautdoc, $basdoc, $tabAlign, $corpsDoc = "") {
        // Pour l'impression
        $_SESSION["titre"] = $titre; //"Liste des matériels";
        $_SESSION["header"] = $listtitre; //array("Catégorie","Désignation","Espèce unité","Quantité stock");
        $_SESSION["headerBD"] = $listcolonneBD; //array("nomcategorie","designation","especeunite","qtestock");
        $_SESSION["width"] = $listlargeurtitre; //array(50,60,40,40);
        $_SESSION["requete"] = $tabrekete; //$affich;
        $_SESSION["nomfichier"] = $nomfichier; //$affich;
        $_SESSION["orientationpage"] = $orientation; //$affich;
        $_SESSION["borduretableau"] = $borduretableau; //$affich;
        $_SESSION["hautdoc"] = $hautdoc; //$Bas du document
        $_SESSION["basdoc"] = $basdoc; //$Bas du document
        $_SESSION["tabAlign"] = $tabAlign; //$Bas du document
        $_SESSION["corps"] = $corpsDoc; //corps du document
    }

    public static function idChefParProfil($idprofil) {
        $rekete = "SELECT idUtilisateur FROM utilisateurprofil WHERE idProfil ='" . $idprofil . "'";
        $result = Functions::commit_sql($rekete, "");
        $idretour = 0;
        if ($result) {
            while ($list = $result->fetch()) {
                $utilisateur = new utilisateur($list['idUtilisateur']); //Functions::afficheBoiteMsg($utilisateur->getIdchef());
                if ($utilisateur->getIdchef() == $list['idUtilisateur'])
                    $idretour = $list['idUtilisateur'];
            }
        }
        return $idretour;
    }

    public static function valider($id, $retour) {
        $p = new parametre($id);
        switch ($retour) {
            case 'majmatricule':
                $p->setPrefixmatricule(addslashes($_GET['prefixmatricule']));
                $p->setMatriculeencours($_GET['matriculeencours']);
                $ch = $_GET['prefixmatricule'];
                $n = intval($_GET['matriculeencours']);
                if ($n < 10) {
                    $ch .= '00';
                } else {
                    if ($n < 100)
                        $ch .= '0';
                }

                $rekete = "SELECT id FROM personne WHERE matricule = '" . $ch . $_GET['matriculeencours'] . "'";
                $rs = Functions::commit_sql($rekete, "");       // echo '  '.$rekete;
                $t = 0;
                if ($rs) {
                    $ls = $rs->fetch();
                    if ($ls['id'] != "")
                        $t = 1;
                }

                break;
            case 'majnumdevis':
                $p->setPrefixdevis(addslashes($_GET['prefixmatricule']));
                $p->setNumdevisencour($_GET['matriculeencours']);
                $ch = $_GET['prefixmatricule'];
                $n = intval($_GET['matriculeencours']);
                if ($n < 10) {
                    $ch .= '000';
                } else  if ($n < 100){
                        $ch .= '00';
                } else {
                    if ($n < 1000)
                        $ch .= '0';
                }

                $rekete = "SELECT id FROM devis WHERE numdevis = '" . $ch . $_GET['matriculeencours'] . "'";
                $rs = Functions::commit_sql($rekete, "");       // echo '  '.$rekete;
                $t = 0;
                if ($rs) {
                    $ls = $rs->fetch();
                    if ($ls['id'] != "")
                        $t = 1;
                }

                break;

        }

        $msg = "";

        if ($t == 0) {
            $result = $p->modifparametre();
        } else {
            $msg = "Le N° matricule que vous tentez d'enregistrer existe déjà";
            $result = '2';
        }

        switch ($result) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le n\'a pas été enregistré : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                $_SESSION['config']='Accueil';
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Le paramètre a été enregistré avec succès. </div>').fadeIn(1000);
                       document.location.href = "index.php";
//                    JPrincipal.afficheContenu(0, 'Accueil', '', ' ');
                </script>
                <?php
                break;

            case '2':
                Functions::afficheBoiteMsg($msg);
                ?>
                <!--                <script>
                    alert('<?php echo $msg; ?>');
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> '+ '<?php echo $msg; ?>'+' </div>').fadeIn(500);
                </script>-->
                <?php
                break;
        }
    }

    public static function menuParamCommercial() {

        $listeParam = "";
//Functions::afficheBoiteMsg($_SESSION['config']);
        ?>
        <div class="accordion-group">
            <div class="accordion-heading ponto">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#commrecial" href="#" onclick="JPrincipal.afficheMenu('<?php echo "#commrecial" ?>');"  >
                    Commercial</a>
            </div>
            <div id="commrecial" class="accordion-body collapse <?php if (isset($_SESSION['ancre']) && $_SESSION['ancre'] == "#commrecial") echo 'in'; ?>">
                <div class="accordion-inner">
                    <ul class = "nav nav-list bs-docs-sidenav" id = "bs-docs">
                        <?php
                        if (Functions::valInArray("10", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'famille') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');
                                    JPrincipal.afficheContenu(0, 'famille', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Familles</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'modereglement') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'modereglement', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Mode de règlement</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'banque') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'banque', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Banques</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'prospect') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'prospect', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Prospects</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'client') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'client', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Clients</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'fournisseur') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'fournisseur', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Fournisseur</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'unite') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'unite', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Unité de mesure</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'promotion') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'promotion', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Promotions</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'chantier') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'chantier', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Chantiers</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'conditionreglement') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'conditionreglement', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Condition de règlement</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'depot') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'depot', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Dépôts</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'taxe') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'taxe', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Taxes</a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("9", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_GET['config']) && $_GET['config'] == 'representant') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#commrecial');JPrincipal.afficheContenu(0, 'representant', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i>Représentants</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

    public static function menuParamGeneral() {

        $listeParam = "";
//Functions::afficheBoiteMsg($_SESSION['config']);
        ?>
        <div class="accordion-group">
            <div class="accordion-heading ponto">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#" onclick="JPrincipal.afficheMenu('<?php echo "#general" ?>');"  >
                    Général</a>
            </div>
            <div id="general" class="accordion-body collapse <?php if (isset($_SESSION['ancre']) && $_SESSION['ancre'] == "#general") echo 'in'; ?>">
                <div class="accordion-inner">
                    <ul class = "nav nav-list bs-docs-sidenav" id = "bs-docs">
                        <?php
                        if (Functions::valInArray("14", $_SESSION['userMenu'])) {
                            ?>
<!--                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'rubriques') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'rubriques', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Rubriques </a>
                            </li>-->
                            <?php
                        }
                        if (Functions::valInArray("28", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'sourceoperation') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'sourceoperation', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Gestion des Caisses et banques </a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("28", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'majmatricule') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'majmatricule', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Mise à jour N° matricule </a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("28", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'majnumdevis') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'majnumdevis', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Mise à jour N° devis </a>
                            </li>
                            <?php
                        }
//                        if (Functions::valInArray("51", $_SESSION['userMenu'])) {
//                            ?>
<!--                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'compte') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'compte', '//<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Plan comptable</a>
                            </li>-->
                            <?php
//                        }
                        if (Functions::valInArray("15", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'domaineactivite') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'domaineactivite', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Domaine d'activité</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("16", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'provenance') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'provenance', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Provenance </a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("17", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'typepiece') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'typepiece', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Type pièce justificative </a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("100", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'personne') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'personne', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Personnes </a>
                            </li>
                            <?php
                        }

                        if (Functions::valInArray("48", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'fonction') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'fonction', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Fonction</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'anneeacademik') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'anneeacademik', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Année académique</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'titre') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'titre', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Titre</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'typepunition') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'typepunition', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Type punition</a>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'typenote') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'typenote', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Type note</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'civilite') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'civilite', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> Civilité</a>
                            </li>
                            <?php
                        }
                        if (Functions::valInArray("49", $_SESSION['userMenu'])) {
                            ?>
                            <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'paramcomptelt') echo 'class="active"' ?> >
                                <a href="#" onclick="JPrincipal.selectionSousMenu('#general');
                                    JPrincipal.afficheContenu(0, 'paramcomptelt', '<?php echo $listeParam; ?>', 'Accueil');"><i class="icon-chevron-right"></i> N° Compte élément</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
    }

}
?>