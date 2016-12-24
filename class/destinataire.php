<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of destinataire
 *
 * @author xavier_gedo
 */
class destinataire {

    //put your code here
    var $id;
    var $codeunique;
    var $type;
    var $idnotification;
    var $iddestinataire;
    var $lu;

    public function __construct($codeunique) {
        $rekete = "SELECT * FROM destinataire WHERE codeunique ='".$codeunique."'";
        $result = Functions::commit_sql($rekete, "");
        if ($result != false) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->type = $list["type"];
            $this->idnotification = $list["idnotification"];
            $this->iddestinataire = $list["iddestinataire"];
            $this->lu = $list["lu"];
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

    public function getidnotification() {
        return $this->idnotification;
    }

    public function setidnotification($idnotification) {
        $this->idnotification = $idnotification;
    }

    public function getiddestinataire() {
        return $this->iddestinataire;
    }

    public function setiddestinataire($iddestinataire) {
        $this->iddestinataire = $iddestinataire;
    }

    public function gettype() {
        return $this->type;
    }

    public function settype($type) {
        $this->type = $type;
    }

    public function getLu() {
        return $this->lu;
    }

    public function setLu($lu) {
        $this->lu = $lu;
    }

    public function verifdoublon() {
        $condition = "idnotification = ? AND iddestinataire = ? ";
        $param = array($this->idnotification, $this->iddestinataire);
        $result = Functions::get_record_byCondition("destinataire", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutdestinataire() {       
          if ($this->codeunique == '')
                $this->codeunique = principale::initCodeunique(gethostname(), 'codeunique', 'destinataire');
        $rekete = "INSERT INTO destinataire(codeunique,idnotification, iddestinataire,type,lu) ";
        $rekete .= "VALUES('".$this->codeunique."','".$this->idnotification."','".$this->iddestinataire."','".$this->type."',0)";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            return principale::ajoutReketeSynchro($rekete);
        } else {
            return '0';
        }
    }

    public function verifdoublonmod() {
        $condition = "idnotification = ? AND iddestinataire = ? AND codeunique <> ?";
        $param = array($this->idnotification, $this->iddestinataire, $this->codeunique);
        $result = Functions::get_record_byCondition("destinataire", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifdestinataire() {
        $rekete = "UPDATE destinataire SET idnotification = '".$this->idnotification."' , iddestinataire = '".$this->iddestinataire."' , type = '".$this->type."' , lu = '".$this->lu."' WHERE codeunique = '".$this->codeunique."'";
       
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public function suppdestinataire() {
        $rekete = "DELETE FROM destinataire WHERE codeunique = '".$this->codeunique."'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            echo principale::ajoutReketeSynchro($rekete);
        } else {
            echo '0';
        }
    }

    public static function destinatairesParNotification($idnotification) {
        $rekete = "SELECT personne.*,destinataire.type FROM personne,destinataire ";
        $rekete .= "WHERE personne.codeunique = destinataire.iddestinataire ";
        $rekete .= "AND idnotification ='" . $idnotification . "'";
//echo $rekete;        
        $result = Functions::commit_sql($rekete, "");
        $affich = array();
        if ($result != false) {
            $i = 0;
            while ($list = $result->fetch()) {
                $affich[$i]["id"] = $list['id'];
                $affich[$i]["codeunique"] = $list['codeunique'];
                $affich[$i]["matricule"] = $list["matricule"];               
                $affich[$i]["nom"] = $list["nom"];
                $affich[$i]["prenom"] = $list["prenom"];
                $affich[$i]["nomprenom"] = $list["nom"] . ' ' . $list["prenom"];
                $affich[$i]["telephone"] = $list["telephone"];
                $affich[$i]["email"] = $list["email"];
                $affich[$i]["sexe"] = $list["idsexe"];
                $fonction = "";
              $affich[$i]["fonction"] = $fonction;
                $affich[$i]["activate"] = !$list["desactiver"];
                $affich[$i]["photo"] = $list["photo"];
                $affich[$i]["typenotification"] = $list["type"];
                $i++;
            }
        }
        return $affich;
    }
    public static function listIdDestinatairesParNotification($idnotification) {
        $rekete = "SELECT personne.*,destinataire.type FROM personne,destinataire ";
        $rekete .= "WHERE personne.codeunique = destinataire.iddestinataire ";
        $rekete .= "AND idnotification ='" . $idnotification . "'";
//echo $rekete;        
        $result = Functions::commit_sql($rekete, "");
        $affich = array();
        if ($result != false) {
            $i = 0;
            while ($list = $result->fetch()) {               
                $affich[$i] = $list['codeunique'];
               
                $i++;
            }
        }
        return $affich;
    }

}
?>


