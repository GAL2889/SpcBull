<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConnectClass
 *
 * @author k@kou
 */
class ConnectAdmin {

    
    //put your code here
    //Déclaration des variables de la classe
    var $login;
    var $pass;
//    var $idprofile;

//   constructeur----------------------
//    function __construct($login, $pass,$profil) {
    function __construct($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;
//        $this->idprofile = $profil;
    }

// 	récupération des valeurs des parametres
    function set_param($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;
//        $this->idprofile = $profil;
    }

// 	Controle d'authentifiacation
    function control_access() {        //principale::actualiseCodeuniqueLiaison("utilisateurprofil");;
        global $dbh;
// 	    récupération des variables entrées au clavier
        $send_login = $this->login;
        $send_pass = Functions::crypter($this->pass);
//        $send_profil=$this->idprofile;
        $login_retourne = "";
        $pass_retourne = "";
//        $profil_retourne="";
        
        // $send_pass = $this->pass;
// 	    mise à vide du tableau de retour
        $return = array();

// 	    Si le login n'est pas vide
        if (!empty($send_login)) {
// 	    	Si le mot de passe n'est pas vide
            if (!empty($send_pass)) {
                
//                if (!empty($send_profil)) {
                
                $search_login_sql = 'SELECT login FROM utilisateur WHERE motdepasse = ?';
                $search_login = $dbh->prepare($search_login_sql);
                $search_login->bindParam(1, $send_pass);
                $search_login->Execute();
                while ($data_login = $search_login->fetch()) {
                    if ($data_login['login'] == $send_login) //by k@kou
                        $login_retourne = $data_login['login'];
                }

                $search_pass_sql = 'SELECT  motdepasse FROM utilisateur WHERE  login = ?';
                $search_pass = $dbh->prepare($search_pass_sql);
                $search_pass->bindParam(1, $send_login);
                $search_pass->Execute();
                while ($data_pass = $search_pass->fetch()) {
                    if ($data_pass['motdepasse'] == $send_pass) //by k@kou
                        $pass_retourne = $data_pass['motdepasse'];
                }

                // 	    	      Si les entrées concordent aux données dans la base de données
                if (($login_retourne == $send_login) AND ($pass_retourne == $send_pass)) {

                    //Récupération des informations du connecté
 
                    
                    $search_infos_sql = "SELECT utilisateur.*, idProfil,profil.libelle AS libelleprofil FROM profil, utilisateurprofil,utilisateur
                                    WHERE utilisateurprofil.idProfil=profil.codeunique AND
                                    utilisateurprofil.idUtilisateur=utilisateur.codeunique AND
                                    login=? AND motdepasse = ?";
                    $search_infos = $dbh->prepare($search_infos_sql);
                    $search_infos->bindParam(1, $send_login);
                    $search_infos->bindParam(2, $send_pass);
//                    $search_infos->bindParam(3, $send_profil);
                    $search_infos->Execute();
                    $data_infos = $search_infos->fetch();
//                    echo 'Merci '.$data_infos["activate"];
                    if ($data_infos["activate"]) {
                        
                        $return["user"]["id"] = $data_infos['id'];
                        $return["user"]["codeunique"] = $data_infos['codeunique'];
                        $return["user"]["login"] = $data_infos['login'];
                        $return["user"]["nom"] = $data_infos['nom'];
                        $return["user"]["idprofil"] = $data_infos['idProfil'];                       
                        $return["user"]["libprofil"] = $data_infos['libelleprofil'];
                        $return["user"]["prenom"] = $data_infos['prenom'];
                        $return["user"]["nomprenom"] = $data_infos['nom'].' '.$data_infos['prenom'];
                       
                        //Si les informations du connecté existent
                        if (
                                (!empty($return["user"]['nomprenom'])) &&
                                (!empty($return["user"]['login']))
                        ) {
                            $return['rep'] = true;
                            echo '1'; //Si les informations du connecté existent
                        }
                        else { //Si les informations du connecté n'existent pas
                            $return['msg'] = "<div class=\"alert alert-error\">Erreur de connection Code #4411 (Contactez &agrave; l'administrateur du site)</div>";
                            echo '0';
                            $return['rep'] = false;
                        }
                    } else {
                        $return['msg'] = '<div class="alert alert-error">Compte Non Activé. Attribuez lui un profil!</div>';
                        echo '2';
                        $return['rep'] = false;
                    }
                    // 	    	      	
                }
                //Si les entrées ne concordent pas aux données dans la base de données
                else {
                    $return['msg'] = '<div class="alert alert-error">Le login et le mot de passe ne concordent pas.</div>';
                    echo '3';
                    $return['rep'] = false;
                }
                
//            }//si le profil n'est pas sélectionné
//            else{
//                $return['msg'] = '<div class="alert">Le profil n\'a pas été sélectionné.</div>';
//                $return['rep'] = false;
//            }
                
            }
            // 	    Si le mot de passe est vide
            else {
                $return['msg'] = '<div class="alert">Le champ du mot de passe est vide.</div>';
                $return['rep'] = false;
            }
        }
// 	    Si le login est vide
        else {
            $return['msg'] = '<div class="alert">Le champ du login est vide.</div>';
            $return['rep'] = false;
        }
        return $return;
    }

    function connection() {
        if ((!empty($this->login)) && (!empty($this->pass)))
            return $this->control_access();
    }

}

?>