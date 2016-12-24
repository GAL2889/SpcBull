<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of situationmatri
 *
 * @author Manda
 */
class situationmatri {

    //put your code here
    var $id;
    var $libelle;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM situationmatri WHERE id = '" . $id . "'";
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



}

?>
