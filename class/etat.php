<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of etat
 *
 * @author Manda
 */
class etat {
    //put your type here
    var $id;
    var $type;
    var $libelle;
//    var $libtype;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM etat WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->type = $list["type"];
            $this->libelle = $list["libelle"];
           // $this->libtype = $list["libtype"];
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

        public function getLibelle() {
        return $this->libelle;
    }

    public function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
//    public function getLibtype() {
//        return $this->libtype;
//    }
//
//    public function setLibtype($libtype) {
//        $this->libtype = $libtype;
//    }
    public static function libEtat($idetat){
        $e = new etat($idetat);
        return $e->getLibelle();
    }

}

?>
