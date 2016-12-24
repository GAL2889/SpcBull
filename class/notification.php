<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification
 *
 * @author chercheur
 */
class notification {

    private $id;
    private $codeunique;
    private $objet;
    private $expediteur;
    private $contenu;
    private $element;
    private $idelement;
    private $date;
    private $etat;
    private $typenotification;

    /*
     * constructeur
     */

    public function __construct($codeunique) {

        $rekete = "SELECT * FROM notification WHERE  codeunique= '" . $codeunique . "'";

        $result = Functions::commit_sql($rekete, "");
        if ($result != false) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->objet = $list["objet"];
            $this->expediteur = $list["expediteur"];
            $this->contenu = $list["contenu"];
            $this->element = $list["element"];
            $this->idelement = $list["idelement"];
            $this->date = $list["date"];
            $this->etat = $list["etat"];
            $this->typenotification = $list["typenotification"];
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

    public function getObjet() {
        return $this->objet;
    }

    public function setObjet($objet) {
        $this->objet = $objet;
    }

    public function getExpediteur() {
        return $this->expediteur;
    }

    public function setExpediteur($expediteur) {
        $this->expediteur = $expediteur;
    }

    public function getContenu() {
        return $this->contenu;
    }

    public function setContenu($contenu) {
        $this->contenu = $contenu;
    }

    public function getIdelement() {
        return $this->idelement;
    }

    public function setIdelement($idelement) {
        $this->idelement = $idelement;
    }

    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
    }

    public function getElement() {
        return $this->element;
    }

    public function setElement($element) {
        $this->element = $element;
    }

    public function getTypenotification() {
        return $this->typenotification;
    }

    public function setTypenotification($typenotification) {
        $this->typenotification = $typenotification;
    }

    public function verifdoublon() {//Est ce possible de controler un doublon ici? expediteur, element, idelement     
        $condition = "id = ? ";
        $param = array($this->id);
        $result = Functions::get_record_byCondition("notification", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutnotification() {
        if (!$this->verifdoublon()) {
            if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'notification');
            $rekete = "INSERT INTO notification (codeunique,objet,expediteur,contenu,element,idelement,etat,typenotification) ";
            $rekete .= "VALUES('" . $this->codeunique . "','" . $this->objet . "', '" . $this->expediteur . "','" . $this->contenu . "','" . $this->element . "','" . $this->idelement . "','" . $this->etat . "','" . $this->typenotification . "')";
//           echo ' Merci '.$rekete; 
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

    public static function valider($champ) {
        list($codeunique, $tabledestinataires, $objet, $contenu, $expediteur, $typenotification, $element, $idelement, $retour) = explode('|', $champ);
        $tabdest = explode(',', $tabledestinataires);

//Enregistregment de la notification
        $S = new notification($codeunique);
        $S->setContenu(addslashes($contenu));
        $S->setEtat(0);
        $S->setDate(date("Y-m-d"));
        $S->setExpediteur($expediteur);
        $S->setIdelement($idelement);
        $S->setObjet(addslashes($objet));
        $S->setElement($element);
        $S->setTypenotification($typenotification);
        $result = $S->ajoutnotification();
        $resultat = 0; //$result = 0;
        if ($result == 1) {
            if ($element == 3) {
                //
                //Mise à jour On renseigne à 1 l'état de la notification depuis laquelle on a lancer le traitement
                $rek = "UPDATE notification SET etat = '1' WHERE codeunique = '" . $idelement . "'";
                Functions::commit_sql($rek, "");
                //Mise à jour de l'état lu à 1 : on renseigne que le destinataire a déjà lu
                
                $reketedes = "UPDATE destinataire SET lu = '1' WHERE destinataire.iddestinataire='" . utilisateur::idpersParUti($expediteur). "' AND idnotification ='" . $idelement . "'";               // Functions::afficheBoiteMsg($reketedes);
                $resultdes = Functions::commit_sql($reketedes, "");
            }
            //echo 'Merci ';
            //On prend la dernière notifiction celle qu'on vient d'enregistrer
            $idnotification = principale::dernierCodeunique(gethostname(), 'codeunique', 'notification');
            //Enregistrement des destinataires
            if ($tabledestinataires != '') {
                foreach ($tabdest as $v) {
                    $dest = new destinataire("");
                    $dest->setidnotification($idnotification);
                    $dest->settype(2);
                    $dest->setiddestinataire($v);
                    $resultdes = $dest->ajoutdestinataire();
                }
            }
//                //Mise à jour de l'état de l'élément traité (etat = 2)
//                $rekete = "UPDATE " . $element . " SET etat = '" . $etatvalid . "' WHERE id = '" . $idelement . "'";            //echo $rekete;
//                $rs = Functions::commit_sql($rekete, "");
//                if ($rs) {
//                    if ($resultdes == '1')
//                        $resultat = 1;
//                }
            $resultat = $resultdes;
        }
       // echo ' Seigneur '.$resultat;
//        return $resultat;
        switch ($resultat) {
            case '0':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La notification n\'a pas été envoyée : erreur de connexion. </div>').fadeIn(1000);
                </script>
                <?php
                break;

            case '1':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La notification a été envoyée avec succès. </div>').fadeIn(1000).fadeOut(2000);
                    JPrincipal.afficheContenu('', '<?php echo $retour; ?>', '', '');
                </script>
                <?php
                break;

            case '2':
                ?>
                <script>
                    $("#info", window.parent.document).html('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> La notification que vous tentez d\'enregistrer existe déja. </div>').fadeIn(500);
                </script>
                <?php
                break;
        }
    }

    public static function notificationParActeur($idacteur, $type = "", $idelement = 0, $element = "") {
        switch ($type) {
            case '':
                $rekete = "SELECT DISTINCT notification.* FROM notification ";
                $rekete .= "WHERE expediteur = '" . $idacteur . "' ";
                $rekete .= "UNION (";
                $rekete .= "SELECT DISTINCT notification.* FROM notification,destinataire  ";
                $rekete .= "WHERE destinataire.idnotification = notification.id ";
                $rekete .="AND destinataire.lu = '0' ";
                $rekete .="AND iddestinataire = '" . $idacteur . "' ) ";
                $rekete .=" ORDER BY date DESC ";               
                break;

            case 'E':
                $rekete = "SELECT * FROM notification WHERE expediteur = '" . $idacteur . "' ORDER BY date DESC ";
// echo ' Merci '.$rekete;
                break;

            case 'L':
                $rekete = "SELECT DISTINCT notification.*,lu FROM notification,destinataire  ";
                $rekete .= "WHERE destinataire.idnotification = notification.codeunique ";
                $rekete .="AND destinataire.lu = '0' ";
                $rekete .="AND iddestinataire = '" . $idacteur . "' ";
                $rekete .=" ORDER BY date DESC ";               // echo 'Merci   '.$rekete;
                break;

            case 'R':
                $rekete = "SELECT DISTINCT notification.*,lu FROM notification,destinataire  ";
                $rekete .= "WHERE destinataire.idnotification = notification.codeunique ";
//                $rekete .="AND destinataire.lu = '0' ";
                $rekete .="AND iddestinataire = '" . $idacteur . "' ";
                $rekete .=" ORDER BY date DESC ";
                break;
            case 'N'://non traitée
                $rekete = "SELECT DISTINCT notification.*,lu FROM notification,destinataire  ";
                $rekete .= "WHERE destinataire.idnotification = notification.codeunique ";
                $rekete .="AND notification.etat = '0' ";
                $rekete .="AND iddestinataire = '" . $idacteur . "' ";
                $rekete .=" ORDER BY date DESC ";
                break;

            case 'M':
                $rekete = "SELECT DISTINCT notification.*,lu FROM notification,destinataire  WHERE destinataire.idnotification = notification.codeunique AND idelement='" . $idelement . "' AND element='" . $element . "' ORDER BY date DESC  ";
                break;
        }
//        echo '  '.$rekete;
//        Functions::afficheBoiteMsg($rekete);

        $mincard = Functions::commit_sql($rekete, "");

        return notification::donnee($mincard);
    }

    public static function donnee($result) {
        $affich = array();
        if ($result != false) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["objet"] = $list["objet"];
                $affich[$i]["idexpediteur"] = $list["expediteur"];
                $utilisateur = new utilisateur($list["expediteur"]);
                $affich[$i]["expediteur"] = personne::nomPrenom($utilisateur->getIdpersonne());
                $affich[$i]["contenu"] = $list["contenu"];
                $affich[$i]["element"] = $list["element"];
                $affich[$i]["idelement"] = $list["idelement"];
                $format = 'd-m-Y à H:i:s';
                $affich[$i]["date"] = Functions::renvoiDate($list["date"], $format);
                $affich[$i]["etat"] = $list["etat"];
                $affich[$i]["typenotification"] = $list["typenotification"];
//                if (($type != "E") && ($type != "")) {
//                    $affich[$i]["lu"] = $list["lu"];
//                }
//                $tabdestinataire = destinataire::destinatairesParNotification($list['codeunique']);
//                $destinataire = "";
//
//                foreach ($tabdestinataire as $vd) {
//                    if ($destinataire != "")
//                        $destinataire .= ", ";
//                    $destinataire .= $vd['nomprenom'];
//                    switch ($vd['typenotification']) {
//                        case 'direct':
//                            $destinataire .= "(D)";
//
//                            break;
//                        case 'indirect':
//                            $destinataire .= "(A)";
//                            break;
//                    }
//                }
                $affich[$i]["destinataire"] = notification::destinataires($list['codeunique']);

                $i++;
            }
        }
        return $affich;
    }

    public static function getdonneeimprime() {
        $recup = $_SESSION['user']['id'];
        $rekete = "SELECT DISTINCT * FROM notification WHERE expediteur='$recup'";
        $result = Functions::commit_sql($rekete, "");        //Functions::afficheBoiteMsg($rekete);
        $affich = array();
        if ($result) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["objet"] = $list["objet"];
                $affich[$i]["date"] = $list["date"];
                $affich[$i]["contenu"] = $list["contenu"];
                $affich[$i]["element"] = $list["element"];
                $i++;
            }
        }
        return $affich;
    }

    public static function afficheTitre($conf) {
        $codeunique = "";
            if (isset($_SESSION['idenreg']))
                    $codeunique = $_SESSION['idenreg'];
            $not = new notification($codeunique);
            $dest = notification::destinataires($codeunique);
        ?>
        <div id="zoneadd">

        </div>
        <?php
        $titre = '';
        switch ($conf) {
            case 'nonlus':
                $titre = "Notifications non lues";
                break;
            case 'collaboration':
                $titre = "Flux des notifications";
                break;

            case 'recues':
                $titre = "Notifications reçues";
                break;
            case 'voirNotification':
                $titre = "Voir le message";
                break;

            case 'envoye':
                $titre = "Notifications envoyées";
                break;
            case 'addnotification':
                $titre = "Nouvelle notification";
                break;
            case 'observNotification':
                $titre = "Faire une observation sur cette notification <br> Contenu: ".$not->getContenu()."<br> Destinataires : ".$dest;
                break;
                case 'relanceNotification':
                $titre = "Relancer cette notification<br> Contenu: ".$not->getContenu()."<br> Destinataires : ".$dest;
                break;
                case 'fluxNotification':
                $titre = "Voir l'ensemble des flux relatifs à cette notification<br> Contenu: ".$not->getContenu()."<br> Destinataires : ".$dest;
                break;
        }
        return $titre;
    }

    static function afficheContenu($conf, $retour) {
        ?> 
        <div class="page-header" id="entetePage">
            <h4><?php echo notification::afficheTitre($conf); ?> </h4>
        </div>
       
        <div id="zoneListeSite">
            <?php
            $u = new utilisateur($_SESSION['user']['codeunique']);
//            $expediteur = $u->getIdpersonne();
//            $expediteur = $_SESSION['user']['codeunique'];
            $codeunique = "";
            if (isset($_SESSION['idenreg']))
                    $codeunique = $_SESSION['idenreg'];
            $not = new notification($codeunique);
            switch ($conf) {

                case 'collaboration':
//                    $expediteur = $_SESSION['user']['codeunique'];
                    $type = "L";
                    $donnee = notification::notificationParActeur($u->getIdpersonne(), $type);
                    notification::afficheListeNotificationParActeur($donnee, $conf);
                    break;
                case 'nonlus':
//                    $expediteur = $_SESSION['user']['codeunique'];
                    $type = "L";
                    $donnee = notification::notificationParActeur($u->getIdpersonne(), $type);
                    notification::afficheListeNotificationParActeur($donnee, $conf);
                    break;
                case 'envoye':
//                    $expediteur = $_SESSION['user']['codeunique'];
                    $type = "E";
                    $donnee = notification::notificationParActeur($_SESSION['user']['codeunique'], $type);
                    notification::afficheListeNotificationParActeur($donnee, $conf);
                    break;
                case 'recues':
//                    $expediteur = $_SESSION['user']['codeunique'];
                    $type = "R";
                    $donnee = notification::notificationParActeur($u->getIdpersonne(), $type);
                    notification::afficheListeNotificationParActeur($donnee, $conf);
                    break;

                case 'detailsNotif':
//                    $idacteur = $_SESSION['user']['id'];
                    notification::formDetailsNotification($u->getIdpersonne());
                    break;

                case 'mmelement':
//                    $idacteur = $_SESSION['user']['id'];
                    notification::formMmElement($u->getIdpersonne());
                    break;
                case 'voirNotification':

                    notification::formVoirNotif($codeunique,'recues');
                    break;
                case 'addnotification':
//                    $param = $codeunique.'|'.$tabledestinataires.'|'.$objet.'|'.$contenu.'|'.$expediteur.'|'.$typenotification.'|'.$element.'|'.$idelement.'|'.$retour;
                    $param = '' . '|' . '' . '|' . '' . '|' . '' . '|' . $_SESSION['user']['codeunique'] . '|' . '0' . '|' . '3' . '|' . '' . '|' . $retour;
                    notification::formAddNotification($param);
                    break;
                case 'observNotification':
                    
//                    $param = $codeunique.'|'.$tabledestinataires.'|'.$objet.'|'.$contenu.'|'.$expediteur.'|'.$typenotification.'|'.$element.'|'.$idelement.'|'.$retour;
                    $param = '' . '|' . utilisateur::idpersParUti($not->getExpediteur()) . '|' . $not->getObjet() . ' (Observation)|' . '' . '|' . $_SESSION['user']['codeunique'] . '|' . '1' . '|' . '3' . '|' . $codeunique . '|' . $retour;
                    notification::formAddNotification($param);
                    break;
                case 'relanceNotification':
                    $des = destinataire::listIdDestinatairesParNotification($codeunique); 
                    $d = $des[0];
                    
//                    $param = $codeunique.'|'.$tabledestinataires.'|'.$objet.'|'.$contenu.'|'.$expediteur.'|'.$typenotification.'|'.$element.'|'.$idelement.'|'.$retour;
                    $param = ''. '|' .  $d  . '|' . $not->getObjet() . ' (Relance)|' . '' . '|' . $_SESSION['user']['codeunique'] . '|' . '2' . '|' . '3' . '|' . $codeunique . '|' . $retour;
                    notification::formAddNotification($param);
                    break;
                case 'fluxNotification':
                    
$donnee = notification::notificationParActeur("", "M", $codeunique, $not->getElement());                    
                    notification::afficheListeNotificationParActeur($donnee, $conf);
                    break;
            }
            ?>
        </div>
        <?php
    }

    static function afficheListe($donnee) {
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucun message n'est disponible pour le moment
            </div>  
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">      
                        <th><strong>Date</strong></th>                         
                        <th><strong>Objet</strong></th>                         
                        <th><strong>Expéditeur</strong></th>                         
                        <th><strong>Destinataire</strong></th>                         
                        <?php if ($_GET['config'] == 'recues' || $_GET['config'] == 'nonlus') { ?>
                                                                                               <!--<th><strong>Type</strong></th>-->                         
                        <?php } ?>
                        <th><strong>Contenu</strong></th>                         
                        <?php
                        if ($_GET['config'] != 'mmelement') {
                            ?>
                            <th style="width: 203px"><strong>Action</strong></th> 
                            <?php
                        }
                        ?>                   
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 0;
                    foreach ($donnee as $v) :
                        $i++;
                        ?>
                        <tr>                      

                            <td><?php echo $v['date'] ?></td>     
                            <td><?php echo $v['objet'] ?></td>
                            <td><?php echo $v['expediteur'] ?></td>
                            <td><?php echo $v['destinataire'] ?></td>
                            <?php if ($_GET['config'] == 'recues' || $_GET['config'] == 'nonlus') { ?>
                                                                                                                                                                                                <!--<td><?php echo $v['typenotification'] ?></td>-->     
                            <?php } ?>
                            <td><?php echo $v['contenu'] ?></td>   
                            <?php
                            if ($_GET['config'] != 'mmelement') {
                                ?>
                                <td>
                                    <a href="#" class="btn btn-small " onclick="JNotification.formVoirDetailsNotif('<?php echo $v['id']; ?>', '<?php echo $_GET['config']; ?>');" style="margin-right: 10px;" title="Voir détails "><i class="icon-eye-open "></i></a>
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

    static function afficheListeNotificationParActeur($donnee, $confRetour) {
        $utilisateur = new utilisateur($_SESSION['user']['id']);
//        $idchef = $utilisateur->getIdStructureUser();
        $idchef = 0;
        $bchef = 0; //Functions::afficheBoiteMsg($confRetour);
        if ($idchef == $_SESSION['user']['id'])
            $bchef = 1;
        if (sizeof($donnee, 1) == 0) {
            ?>
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Infos!</strong> 
                Aucune notification n'est disponible actuellement pour <?php
                echo personne::nomPrenom($utilisateur->getIdpersonne());
                ?>
            </div>  
            <?php
        } else {
            ?>
            <table border="0" class="display table table-bordered" width="100%">
                <thead>
                    <tr class="menu_gauche">      
                        <th><strong>N°</strong></th>                         
                        <?php if (isset($donnee[0]['lu'])) { ?><th><strong>Etat</strong></th>   <?php } ?>                       
                        <th><strong>Date</strong></th>                         
                        <th><strong>Objet</strong></th>                
                        <th><strong>Contenu</strong></th>                       
                        <th><strong>Expéditeur</strong></th>                       
                        <th><strong>Destinataires</strong></th>                       
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
                            <td><?php echo $i ?></td>                           
                            <?php if (isset($v['lu'])) { ?>
                                <td>
                                    <?php
                                    if ($v['lu'] == 0) {
                                        ?>
                                        <a href="#" onclick="" style="margin-right: 10px;">
                                            <img src="images/Desactivate.jpg" alt="Non lus" title="Non lus" style="width: 16px; height: 16px"/>
                                        </a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="#" onclick="" style="margin-right: 10px;">
                                            <img src="images/Activate.jpg" style="width: 16px; height: 16px" alt="lus" title="Lus"/>
                                        </a>
                                        <?php
                                    }
                                    ?></td>   <?php } ?>                        
                            <td><?php echo $v['date'] ?></td>                           
                            <td><?php echo $v['objet'] ?></td>     
                            <td><?php echo $v['contenu'] ?></td>     
                            <td><?php echo $v['expediteur'] ?></td>     
                            <td><?php echo $v['destinataire'] ?></td>     
                            <td>
                                <!--<a href="#" class="btn btn-small " onclick="JNotification.formVoirDetailsNotif('<?php echo $v['id']; ?>', '<?php echo $confRetour; ?>', '<?php echo $idexpediteur; ?>');" style="margin-right: 5px;" title="Voir détails "><i class="icon-eye-open "></i></a>-->

                                <?php
                                if (($v['typenotification'] != 3) && ($confRetour != 'envoye')) {
                                    ?>
                                <a href="#" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'observNotification', '', '<?php echo $confRetour; ?>');" id="allnotif" class="btn btn-small btn-warning" title="Faire observation "><i class="icon-info-sign "></i></a>
                                <a href="#" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'voirNotification', '', '<?php echo $confRetour; ?>');" id="allnotif" class="btn btn-small btn-info" title="Voir le message "><i class="icon-eye-open "></i></a>
                                     <?php
                                } else {
                                    ?>
                                <a href="#" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'relanceNotification', '', '<?php echo $confRetour; ?>');" id="allnotif" class="btn btn-small btn-warning" title="Relancer "><i class="icon-share"></i></a>
                                    <?php
                                }

//                                $expediteur = new utilisateur($idexpediteur); //echo $etatelement;
                                //$idstructexpediteur = $utilisateur
                                if (($bchef == 1) && ($v['typenotification'] == 2) && ($confRetour != 'envoye') && ($v['etat'] != '1') && ($etatelement != '1')) {
                                    ?>
                                    <!--<a href="#" class="btn btn-small btn-success " onclick="JNotification.formNotifier('<?php echo $idelement; ?>', '<?php echo $element; ?>', '<?php echo $idacteur; ?>', '<?php echo $iddestinataire; ?>', '<?php echo $retour; ?>', '<?php echo $conf; ?>', '<?php echo $titreValider; ?>', '<?php echo 1; ?>', '<?php echo $v['id']; ?>');" style="margin-right: 5px;" title="Valider "><i class="icon-ok "></i></a>-->
                                    <?php
                                }
                                ?>
                                <a href="#" onclick="JPrincipal.afficheContenu('<?php echo $v['codeunique']; ?>', 'fluxNotification', '', '<?php echo $confRetour; ?>');" id="allnotif" title="Flux d'un même élement" class="btn btn-small btn-success"><i class="icon-filter "></i></a>
                                <!--<a href="#" class="btn btn-small btn-success " onclick="JNotification.formVoirMmElement('<?php echo $idelement; ?>', '<?php echo $element; ?>', '<?php echo $confRetour; ?>');" style="" title="Flux d'un même élement"><i class="icon-filter"></i></a>-->
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

    static function afficheNotification() {
        $idacteur = "";
        if (isset($_SESSION['user']['codeunique'])) {
            $idacteur = $_SESSION['user']['codeunique'];
        }
        $u = new utilisateur($idacteur);
        $n = 0;

        $rekete = "SELECT DISTINCT notification.* FROM notification,destinataire  ";
        $rekete .= "WHERE destinataire.idnotification = notification.codeunique ";
        $rekete .="AND destinataire.lu = '0' ";
        $rekete .="AND notification.etat = '0' ";
        $rekete .="AND iddestinataire = '" . $u->getIdpersonne() . "' ";
        $result = Functions::commit_sql($rekete, "");        //Functions::afficheBoiteMsg($rekete);
        if ($result) {
            while ($list = $result->fetch()) {
                $n++;
            }
        }

        if ($n > 0) {
            ?>  
            <span id ='notification' name ="notification" class="label label-important"><?php echo $n; ?> </span>                           

            <?php
        } else {
            ?>  
            <span id ='notification' name ="notification" class="label label-success"><?php echo $n; ?> </span>                           

            <?php
        }
    }

    public static function formVoirNotif($idnotification,$retour){
        //Mise à jour On renseigne à 1 l'état de la notification depuis laquelle on a lancer le traitement
//                $rek = "UPDATE notification SET etat = '1' WHERE codeunique = '" . $idnotification . "'";
//                Functions::commit_sql($rek, "");
        
         $reketedes = "UPDATE destinataire SET lu = '1' WHERE destinataire.iddestinataire='" . utilisateur::idpersParUti($_SESSION['user']['codeunique']). "' AND idnotification ='" . $idnotification . "'";        // echo ' Merci '.$reketedes;
         Functions::commit_sql($reketedes, "");
        
        $not = new notification($idnotification);
        
        ?>
        <form class="form-horizontal" method="post" name="formAddNotification" id="formAddNotification" action="" enctype="multipart/form-data">  
            <div class="well well-large">                
                
                <div class="control-group">
                    <label class="control-label" for="expediteur"><strong>Expéditeur </strong></label>
                    <div class="controls">
                        <?php echo personne::nomPrenom(utilisateur::idpersParUti($not->getExpediteur()) ); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="objet"><strong>Objet </strong></label>
                    <div class="controls">
                        <?php echo $not->getObjet(); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="Contenu"><strong>Contenu :  </strong></label>
                    <div class="controls">
                        <?php echo $not->getContenu(); ?>
                    </div>
                </div>

                

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">  
                        <input type="button" onclick=" JPrincipal.afficheContenu('<?php echo $idnotification; ?>', 'observNotification', '', '<?php echo $retour; ?>');" class="btn btn-small btn-warning" value="Faire d'observation"/>
                        <!--<a href="<?php echo $retour; ?>" onclick="" id="retour" class="btn btn-small"> Annuler</a>-->
                    </div>
                </div> 

            </div>

        </form>
         <?php
         
    }

    static function formMmElement() {
        if (isset($_SESSION['confRetour'])) {
            $confRetour = $_SESSION['confRetour'];
        } else {
            $confRetour = "";
        }
        if (isset($_SESSION['infoMmFlux'])) {
            list($idelement, $element, $demandeur, $infos) = explode("|", $_SESSION['infoMmFlux']);
        }
//        Functions::afficheBoiteMsg('Merci Seigneur  ' . $element . '  ' . $idelement . ' ');
        $donnee = notification::notificationParActeur($demandeur, "M", $idelement, $element);
        ?>      
        <div id="info"></div>

        <div id="zoneListeSite">
            <?php
            notification::afficheListe($donnee);
            ?>
        </div>
        <?php
    }

    static function formAddNotification($param = "") {
        list($codeunique, $tabledestinataires, $objet, $contenu, $expediteur, $typenotification, $element, $idelement, $retour) = explode('|', $param);
//        Functions::afficheBoiteMsg($retour);
        ?>      
        <input type="hidden" id="idexpediteur" name="idexpediteur" value="<?php echo $expediteur; ?>" />
        <input type="hidden" id="typenotification" name="typenotification" value="<?php echo $typenotification; ?>" />
        <input type="hidden" id="element" name="element" value="<?php echo $element; ?>" />
        <input type="hidden" id="idelement" name="idelement" value="<?php echo $idelement; ?>" />

        <form class="form-horizontal" method="post" name="formAddNotification" id="formAddNotification" action="" enctype="multipart/form-data">  
            <div class="well well-large">                
                <div class="control-group">
                    <label class="control-label" for="destinataire"><strong>Destinataires (*)</strong></label>
                    <div class="controls">
                        <?php
                        $uti = new utilisateur($_SESSION['user']['codeunique']);
                        $rekete = "SELECT codeunique , CONCAT(nom,' ',prenom) AS nomprenom FROM personne WHERE desactiver = '0' AND codeunique <>'" . $uti->getIdpersonne() . "'  ";       // echo 'Merci '.$rekete;
                        $rekete .= " AND codeunique IN ( SELECT idpersonne FROM utilisateur )";
                        echo Functions::LoadCombo($rekete, "codeunique", "nomprenom", "iddestinataire", 'Destinataires', "300", "", $tabledestinataires, "multiple", "iddestinataire[]");
                        ?>                     
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="objet"><strong>Objet (*)</strong></label>
                    <div class="controls">
                        <textarea id="objet" rows="1" name="objet" style="width: 300px;" onkeyup="JPrincipal.enMajuscule('objet', 1);" class="text ui-widget-content ui-corner-all"><?php echo $objet; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="memo"><strong>Contenu (*)</strong></label>
                    <div class="controls">
                        <textarea id="memo" rows="5" name="memo" style="width: 300px;" onkeyup="JPrincipal.enMajuscule('memo', 1);" class="text ui-widget-content ui-corner-all"><?php echo $contenu; ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">  
                        <input type="button" onclick="JRubriques.valider('<?php echo $codeunique; ?>', 'validerNotification', '<?php echo $retour; ?>');" class="btn btn-small btn-success" value="Envoyer"/>
                        <a href="" onclick="JPrincipal.afficheContenu('', '<?php echo $retour; ?>', '', '');" id="retour" class="btn btn-small"> Annuler</a>
                    </div>
                </div> 

            </div>

        </form>
        <?php
    }
    
    public static function destinataires($idnotification){
        $tabdestinataire = destinataire::destinatairesParNotification($idnotification);
        $destinataire = "";
         foreach ($tabdestinataire as $vd) {
                    if ($destinataire != "")
                        $destinataire .= ", ";
                    $destinataire .= $vd['nomprenom'];
                    switch ($vd['typenotification']) {
                        case 'direct':
                            $destinataire .= "(D)";

                            break;
                        case 'indirect':
                            $destinataire .= "(A)";
                            break;
                    }
                }
                return $destinataire;
    }

}
?>
