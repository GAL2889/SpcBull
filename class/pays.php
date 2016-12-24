<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pays
 *
 * @author Manda
 */
class pays {

    //put your code here
    var $id;
    var $nomfrancais;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM pays WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->nomfrancais = $list["nomfrancais"];
        }
    }
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNomfrancais() {
        return $this->nomfrancais;
    }

    public function setNomfrancais($nomfrancais) {
        $this->nomfrancais = $nomfrancais;
    }

    public static function nomfrancaisPays($id) {
        $p = new pays($id);
        return $p->getNomfrancais();
    }



}

?>
