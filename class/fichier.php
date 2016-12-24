<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of file
 *
 * @author Jesus t'aime
 */
class fichier {

    //put your code here
    var $id;
    var $nomfile;
    var $idcreateur;
    var $created;

    public function __construct($nomfile) {

        $rekete = "SELECT * FROM file WHERE nomfile = '" . $nomfile . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->nomfile = $list["nomfile"];
            $this->idcreateur = $list["idcreateur"];
            $this->created = $list["created"];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNomfile() {
        return $this->nomfile;
    }

    public function setNomfile($nomfile) {
        $this->nomfile = $nomfile;
    }
    
     public function getIdcreateur() {
        return $this->idcreateur;
    }

    public function setCreated($created) {
        $this->created = $created;
    }
    
     public function getCreated() {
        return $this->created;
    }

    public function setIdcreateur($idcreateur) {
        $this->idcreateur = $idcreateur;
    }
    
    
    public function verifdoublon() {
        $rekete = "SELECT * FROM file WHERE nomfile='" . $this->nomfile . "'";
        $result = Functions::commit_sql($rekete, "");
        if (Functions::is_void($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function ajoutFile() {
        if (!$this->verifdoublon()) {
             $rekete = "INSERT INTO file(nomfile,idcreateur) ";
            $rekete .= "VALUES('" . $this->nomfile . "','" . $_SESSION['user']['id']. "')";
            $result = Functions::commit_sql($rekete, "");
            if ($result) {
                //header('Location:  www.nouveau_site.com');
                //header('Refresh: 10; url=www.nouveau_site.com');
                return '0';
                echo 0;
            }
        } else {
            return '1';
            echo 1;
        }
    }
    public static function verifyFile($nomfile) {
        $rekete = " file WHERE nomfile = '".$nomfile."' ";
        $rslt = Functions::get_Count($rekete);
        return $rslt;
    }

}

?>
