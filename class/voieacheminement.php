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
class voieacheminement {//`id`, `codeunique`, `libelle`, `complement`, `typevoieacheminement`, `telephone`, `idcreateur`
    //put your code here

    var $id;
    var $libelle;
    

    public function __construct($id) {
        $rekete = "SELECT * FROM voieacheminement WHERE id = '" . $id . "'";       // echo 'Merci '.$rekete;
        $result = Functions::commit_sql($rekete, ""); 

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"]; 
            $this->libelle = $list["libelle"];
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    
    public static function libelleVoieacheminement($id) {
        $rub = new voieacheminement($id);//construteur
        return $rub->getLibelle();
    }

    public function verifDoublon() {
        $rekete = "SELECT * FROM voieacheminement WHERE libelle = '" . $this->libelle . "' ";
        $result = Functions::commit_sql($rekete, "");       // Functions::afficheBoiteMsg($rekete);
        $retour = false;
        if ($result) {
            $ls = $result->fetch();
            if ($ls['id'] != '')
                $retour = true;
        }

        return $retour;
    }

    public function ajoutvoieacheminement() {
        if (!$this->verifDoublon()) {           
            $rekete = "INSERT INTO voieacheminement(libelle) VALUES('" . $this->libelle . "')";
           
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
        $condition = "libelle = ?  AND i <> ? d";
        $param = array($this->libelle, $this->id);
        $result = Functions::get_record_byCondition("voieacheminement", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifvoieacheminement() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE voieacheminement SET libelle ='" . $this->libelle . "' ";
            $rekete .= "WHERE id = '" . $this->id."'";
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

    public function suppvoieacheminement() {
        if (principale::suppressionPossible("voieacheminement", $this->id)) {
            $rekete = "DELETE FROM voieacheminement WHERE id= '" . $this->id . "'";

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
                $affich[$i]["libelle"] = $list["libelle"];
                
                $i++;
            }
        }
        return $affich;
    }

    public static function voieacheminementParCritere($critere = "") {
        $rekete = "SELECT * FROM voieacheminement " . $critere;
        $result = Functions::commit_sql($rekete, "");
        $affich = voieacheminement::donnee($result);
        return $affich;
    }

    public static function listvoieacheminementPourCombo() {
        $donnee = voieacheminement:: getAllvoieacheminementInfos();
        $list = '';
        $i = 0;
        foreach ($donnee as $v) {
            if ($i > 0) {
                $list .= '-->';
            }
            $list .= $v['codeunique'] . '|' . $v['libelle'];
            $i++;
        }

        return $list;
    }


}
?>

