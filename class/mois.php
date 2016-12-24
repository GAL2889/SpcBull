<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mois
 *
 * @author Manda
 */
class mois {

    //put your code here
    var $id;
    var $libelle;
    var $numero;

    public function __construct($id) {
        $id = (int) $id;
        $rekete = "SELECT * FROM mois WHERE id = '" . $id . "'";
        $result = Functions::commit_sql($rekete, "");

        if ($result) {
            $list = $result->fetch();
            $this->id = $list["id"];
            $this->numero = $list["numero"];
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

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    public static function libMoisParId($id){
        $mois = new mois($id);
        return $mois->getLibelle();
    }

    public function getDatedebut($annee="") {
        if ($annee==""){
            $annee=date("Y");
        }
        $lemois = new mois($this->id);
        $mois = $lemois->getNumero();
        $datedebut =  $annee. "-" . $mois . "-01";
        return $datedebut;
    }

    public function getDatefin($annee="") {
         if ($annee==""){
            $annee=date("Y");
        }
        $lemois = new mois($this->id);
        $mois = $lemois->getNumero();
        $datefin="";
        switch ($mois) {
            case "01":
            case "03":
            case "05":
            case "07":
            case "08":
            case "10":
            case "12":
                $datefin = $annee . "-" . $mois . "-31";
                break;
            case "02":
                $annee=date("Y");
                $reste=($annee%4);
                if ($reste==0){
                       $datefin = $annee . "-" . $mois . "-29";
                }else{
                       $datefin = $annee . "-" . $mois . "-28";
                }
                break;
            case "04":
            case "06":
            case "09":
            case "11":
                $datefin = date("Y") . "-" . $mois . "-30";
                break;
        }
        return $datefin;
    }
    
    public static function idMoisEncours(){
        $num = date('m');
        //$rekete = "SELECT * FROM mois WHERE numero='".$num."'";
        //$result = 
        return intval($num);
    }
    
     public static function getIdMoisbyNum($numMois) {
       $id=0;
       $rekete="select id from mois where numero='".$numMois."'";
       $result = Functions::commit_sql($rekete, "");
        if ($result) {
            $list = $result->fetch();
            $id=$list["id"];
        }
        return $id;    
    }

}

?>
