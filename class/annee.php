<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of annee
 *
 * @author Manda
 */
class annee {

    //put your code here
    var $id;
    var $codeunique;
    var $annee;
    var $encours;

    public function __construct($codeunique) {
        //$id = (int) $id;
        $rekete = "SELECT * FROM annee WHERE codeunique = '" . $codeunique . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->codeunique = $list["codeunique"];
            $this->annee = $list["annee"];
            $this->encours = $list["encours"];
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

    public function getAnnee() {
        return $this->annee;
    }

    public function setAnnee($annee) {
        $this->annee = $annee;
    }

    public function getEncours() {
        return $this->encours;
    }

    public function setEncours($encours) {
        $this->encours = $encours;
    }

    public static function getIdAnneeEncours() {
        $id = "";
        $rekete = "select * from annee where encours=1";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $id = $list["codeunique"];
        }
        return $id;
    }

    public static function getIdAnneebylibelle($annee) {
        $id = 0;
        $rekete = "select codeunique from annee where annee='" . $annee . "'";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $id = $list["codeunique"];
        }
        return $id;
    }

    public function getAnneeEncours() {
        $annee = date("Y");
        $rekete = "select * from annee where encours=1";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $annee = $list["annee"];
        }
        return $annee;
    }

    public static function libAnneeParId($id) {
        $an = new annee($id);
        return $an->getAnnee();
    }

}

?>
