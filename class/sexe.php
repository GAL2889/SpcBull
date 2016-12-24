<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sexe
 *
 * @author Manda
 */
class sexe {
    //put your code here
    var $id;
    var $code;
    var $libelle;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM sexe WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->code = $list["code"];
            $this->libelle = $list["libelle"];
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getCode() {
        return $this->code;
    }

    public function setCode($code) {
        $this->code = $code;
    }

        public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

}

?>
