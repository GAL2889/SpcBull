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
class actionnonlivraison {//`id`, `codeunique`, `libelle`, `complement`, `typeactionnonlivraison`, `telephone`, `idcreateur`
    //put your code here

    var $id;
    var $libelle;
    

    public function __construct($id) {
        $rekete = "SELECT * FROM acteurs WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"]; 
            $this->libelle = $list["libelle"];
        }


    }

    public static function libelleActionnonlivraison($id) {
        $rub = new actionnonlivraison($id);//construteur
        return $rub->getLibelle();
    }

    public function verifDoublon() {
        $rekete = "SELECT * FROM actionnonlivraison WHERE libelle = '" . $this->libelle . "' ";
        $result = Functions::commit_sql($rekete, "");       // Functions::afficheBoiteMsg($rekete);
        $retour = false;
        if ($result) {
            $ls = $result->fetch();
            if ($ls['id'] != '')
                $retour = true;
        }

        return $retour;
    }

    public function ajoutactionnonlivraison() {
        if (!$this->verifDoublon()) {           
            $rekete = "INSERT INTO actionnonlivraison(libelle) VALUES('" . $this->libelle . "')";
           
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
        $result = Functions::get_record_byCondition("actionnonlivraison", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifactionnonlivraison() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE actionnonlivraison SET libelle ='" . $this->libelle . "' ";
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

    public function suppactionnonlivraison() {
        if (principale::suppressionPossible("actionnonlivraison", $this->id)) {
            $rekete = "DELETE FROM actionnonlivraison WHERE id= '" . $this->id . "'";

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

    public static function actionnonlivraisonParCritere($critere = "") {
        $rekete = "SELECT * FROM actionnonlivraison " . $critere;
        $result = Functions::commit_sql($rekete, "");
        $affich = actionnonlivraison::donnee($result);
        return $affich;
    }

    public static function listactionnonlivraisonPourCombo() {
        $donnee = actionnonlivraison:: getAllactionnonlivraisonInfos();
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

