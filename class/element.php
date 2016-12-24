<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of element
 *
 * @author DIEUAMOUR
 */
class element {

    //put your code here
    var $id;
    var $libelle;
    var $nomtable;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM element WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->libelle = $list["libelle"];
            $this->nomtable = $list["nomtable"];
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

    public function getNomtable() {
        return $this->nomtable;
    }

    public function setNomtable($nomtable) {
        $this->nomtable = $nomtable;
    }

    public function verifDoublon() {
        $result = Functions::get_record_byfield("element", "nomtable", $this->nomtable);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutElement() {
        if (!$this->verifDoublon()) {
            $rekete = "INSERT INTO element(libelle,nomtable) VALUES(?,?)";
            $param = array($this->libelle, $this->nomtable);
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

    public function verifDoublonMod() {
        $condition = "nomtable = ? AND id <> ? ";
        $param = array($this->libelle, $this->id);
        $result = Functions::get_record_byCondition("element", $condition, $param);
        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function modifElement() {
        if (!$this->verifDoublonMod()) {
            $rekete = "UPDATE element SET libelle ='" . $this->libelle . "'  WHERE id = '" . $this->id . "'";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                return '1';
            } else {
                return '0';
            }
        } else {
            return '2';
        }
    }

    public function suppElement() {
        $rekete = "DELETE FROM element WHERE id = ?";
        $param = array($this->id);
        $result = Functions::commit_sql($rekete, $param);
        if ($result) {
            echo '1';
        } else {
            echo '0';
        }
    }

    public static function nomtable($idelement) {
        $element = new element($idelement);
        return $element->getNomtable();
    }

    public static function donnee($result, $element, $conf, $idprofil) {       
        $nomtable = element::nomtable($element);
        $lib = 'libelle';

        switch ($nomtable) {
            case 'sourceoperationfinanciere':
                $lib = "libsource";
                break;
            case 'menu':
                $lib = "libellemenu";
                break;
        }
   
        $affich = array();
        if ($result) {          //  print_r($result);
            $i = 0;
            while ($list = $result->fetch()) {                
                    $iddroit = droitacces::idDroitParCritere($idprofil, $element, $list['codeunique']);
                    $l = droitacces::lecturePar($iddroit);
                    $e = droitacces::ecriturePar($iddroit);

                if ($conf == 'detailsDroitProfil') {
                    if (($l != 0) || ($e != 0)) {
                        $affich[$i]["lecture"] = droitacces::lecturePar($iddroit); 
                        $affich[$i]["ecriture"] = droitacces::ecriturePar($iddroit);
                        $affich[$i]["suppression"] = 0;
                        $affich[$i]["element"] = $element;
                        $affich[$i]["id"] = $list['id'];
                        $affich[$i]["codeunique"] = $list['codeunique'];
                        $affich[$i]["libelle"] = $list[$lib];

                        $i++;
                    }
                                   
                } else {
                    if (($l == 0) && ($e == 0)) {
                    $affich[$i]["element"] = $element;
                    $affich[$i]["id"] = $list['id'];
                    $affich[$i]["codeunique"] = $list['codeunique'];
                    $affich[$i]["libelle"] = $list[$lib];
                    $affich[$i]["lecture"] = 0;
                    $affich[$i]["ecriture"] = 0;
                    $affich[$i]["suppression"] = 0;
                    $i++;
                }
                }
            }
        }
        return $affich;
    }

    public static function contenuElement($idelement, $idprofil, $conf) {       // Functions::afficheBoiteMsg($conf);
        $nomtable = element::nomtable($idelement);
        $rekete = "";
        switch ($conf) {
            case 'adddroitacces':
                $rekete .= "SELECT * FROM " . $nomtable."" ;//. " WHERE codeunique NOT IN ";
                break;
            case 'detailsDroitProfil':
                $rekete .= "SELECT * FROM " . $nomtable ;//. " WHERE codeunique  IN ";

//                $rekete .= "SELECT DISTINCT ".$nomtable.".*,lecture,ecriture,suppression FROM " . $nomtable.",droitacces  ";
//                $rekete .= "WHERE ".$nomtable.".id = droitacces.idelement AND ".$nomtable.".id IN ";
                break;
        }
        //$rekete .= " (SELECT idelement FROM droitacces WHERE element='" . $idelement . "' AND idprofil='" . $idprofil . "') "; //echo $rekete;
        $result = Functions::commit_sql($rekete, "");        //echo $rekete;
        return element::donnee($result, $idelement, $conf, $idprofil);
    }

}
?>

