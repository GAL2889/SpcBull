<?php
/*
 * Description de la classe privilège privilege
 * Auteurs HE Systems & Elpis Technologies
 */

//error_reporting(0);

class Functions {
    /*
     * fonction qui permet d'enregister
     * les erreurs dans le fichier error.txt
     */
    /*
     * pour executer une requete sql
     */

    static function RegisterError($libError, $detail) {
        $date = date('y-m-d');
        $time = date('y-m-d-H-i-s');
        $message = "\n" . $libError . ";" . $detail . ";" . $time;
        $errorFile = './' . ERRORLOGFILE_FOLDER . "/" . $date . ".cvs";
        if (file_exists(ERRORLOGFILE_FOLDER)) {
            $file = fopen($errorFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        } else {
            $errorFile = '../' . ERRORLOGFILE_FOLDER . "/" . $date . ".cvs";
            $file = fopen($errorFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        }
    }

    /*
     * fonction qui permet d'enregister
     * les actions d'un utilisateur dans la fichier log.txt
     */

    static function RegisterAction($msg, $detail) {
        $date = date('y-m-d');
        $time = date('y-m-d-H-i-s');
        $user = '[' . $msg . '] : ';
        $message = "\n" . $user . "" . $detail . " : " . $time;
        $errorFile = './' . ACTIONLOGFILE_FOLDER . "/" . $date . ".cvs";
        if (file_exists(ACTIONLOGFILE_FOLDER)) {
            $file = fopen($errorFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        } else {
            $errorFile = '../' . ACTIONLOGFILE_FOLDER . "/" . $date . ".cvs";
            $file = fopen($errorFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        }
    }
    
    /*
     * fonction qui permet d'enregister
     * les requêtes pour la synchronisation dans le fichier synchro.txt
     */
    static function commit_sql($rekete, $param) {
        global $dbh;

        try {
            if (($param == "")) {
                $result = $dbh->prepare($rekete);
                //echo $result;
                $result->execute();
            } else {
                $result = $dbh->prepare($rekete);
                $result->execute($param);
            }

            return $result;
        } catch (PDOException $e) {
            $libError = "Sql_Error";
            $detail = "(" . $rekete . ")" . $e->getMessage();
            Functions::RegisterError($libError, $detail);
            return false;
        }
    }

    /*
     * pour voir si le resultat d'une requete sql est vide
     */

    static function is_void($result) {
        if ($result != false) {
            if ($result->rowCount() > 0)
                return false;
            else
                return true;
        }
        else
            return true;
        //Functions::RegisterError($libError, $detail);
    }

    /*
     * fonction qui retourne le nom du mois suivant le numero de mois---------
     */

    static function get_mois($num) {
        if ($num < 1 || $num > 12)
            return false;
        $langserver = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        switch ($num) {
            case 1: {
                    switch (strtolower(substr($langserver, 0, 2))) {
                        case "fr": {// cas de navigateur français
                                $mois = "Janvier";
                                break;
                            }
                        case "en": {// cas de navigateur anglais
                                $mois = "January";
                                break;
                            }
                        default: {
                                $mois = "Janvier";
                                break;
                            }
                    }
                    break;
                }
            case 2: {
                    switch (strtolower(substr($langserver, 0, 2))) {
                        case "fr": {// cas de navigateur français
                                $mois = "Février";
                                break;
                            }
                        case "en": {// cas de navigateur anglais
                                $mois = "February";
                                break;
                            }
                        default: {
                                $mois = "Février";
                                break;
                            }
                    }
                    break;
                }
            case 3: {
                    switch (strtolower(substr($langserver, 0, 2))) {
                        case "fr": {// cas de navigateur français
                                $mois = "Mars";
                                break;
                            }
                        case "en": {// cas de navigateur anglais
                                $mois = "March";
                                break;
                            }
                        default: {
                                $mois = "Mars";
                                break;
                            }
                    }
                    break;
                }
            case 4:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Avril";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "April";
                            break;
                        }
                    default: {
                            $mois = "Avril";
                            break;
                        }
                }
                break;
            case 5:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Mai";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "May";
                            break;
                        }
                    default: {
                            $mois = "Mai";
                            break;
                        }
                }
                break;
            case 6:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Juin";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "June";
                            break;
                        }
                    default: {
                            $mois = "Juin";
                            break;
                        }
                }
                break;
            case 7:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Juillet";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "July";
                            break;
                        }
                    default: {
                            $mois = "Juillet";
                            break;
                        }
                }
                break;
            case 8:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Août";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "August";
                            break;
                        }
                    default: {
                            $mois = "Août";
                            break;
                        }
                }
                break;
            case 9:
                $mois = "Septembre";
                break;
            case 10:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Octobre";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "October";
                            break;
                        }
                    default: {
                            $mois = "Octobre";
                            break;
                        }
                }
                break;
            case 11:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Novembre";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "November";
                            break;
                        }
                    default: {
                            $mois = "Novembre";
                            break;
                        }
                }
                break;
            case 12:
                switch (strtolower(substr($langserver, 0, 2))) {
                    case "fr": {// cas de navigateur français
                            $mois = "Décembre";
                            break;
                        }
                    case "en": {// cas de navigateur anglais
                            $mois = "December";
                            break;
                        }
                    default: {
                            $mois = "Décembre";
                            break;
                        }
                }
                break;
            default : {
                    return "Mois";
                }
        }
        return $mois;
    }

    /*
     * convertit la date format anglais  en francais
     */

    static function convert_dateFr($date) {
        $tab = explode('-', $date);
        $result = $tab['0'] . " " . Functions::get_mois($tab['1']) . " " . $tab['2'];
        return $result;
    }

    /*
     * convertit la date format anglais  en francais
     */

    static function convert_dateEnFr($date) {
        $tab = explode('-', $date);
        $result = $tab['2'] . "-" . $tab['1'] . "-" . $tab['0'];
        return $result;
    }

    /*
     * convertit la date format francais en anglais   
     */

    static function convert_dateFrEn($date) {
        $tab = explode('-', $date);
        $result = $tab['0'] . "-" . $tab['1'] . "-" . $tab['2'];
        return $result;
    }

    /*
     * retourne la date format Anglais(AAAA-MM-JJ);
     */

    static function makeDate($jour, $mois, $annee) {
        return $annee . "-" . $mois . "-" . $jour;
    }

    /*
     * affiche la date format anglais  en francais
     */

    static function show_dateFr($date) {
        echo Functions::convert_dateFr($date);
    }

    /*
     * convertit l'heure format anglais en farnçais
     */

    static function convert_timeFr($time) {
        $tab = explode(':', $time);
        //$result=$tab['2']."h".$tab['1']."mn".$tab['0']."s";
        //$result=$tab['2']."h-".$tab['2']."Mn".$tab['0']."s";
        $result = $tab['0'] . ":" . $tab['1'];
        return $result;
    }

    /*
     * afficher l'heure format anglais en français
     */

    static function show_timeFr($time) {
        echo convert_timeFr($time);
    }

    /*
     * 
     */

    static function convertTimestampfr($TimeStamp) {
        $tab = explode(" ", $TimeStamp);
        $result = Functions::convert_dateFr($tab["0"]) . " " . Functions::convert_timeFr($tab["1"]);
        return $result;
    }

    /*
     * crypter
     * un mot de passe
     */

    static function crypter($word) {
        $return = md5($word);
        $return1 = md5($return);
        $result = md5($return1);
        return $result;
    }

    /*
     * Retourne La date d'une
     * chaine format Time Stamp
     */

    static function getDateFromTimeStamp($timestamp) {
        $tab = explode(" ", $timestamp);
        return $tab["0"];
    }

    /*
     * Meme Chose que get_record_byfield
     * Mais donne la possiblité d'ajouter une condition sql
     * $condition est la condition sql à rajouter. 
     */

    static function get_record_byfieldverif($table, $field, $value) {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $field . " = ? ";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * Pour compter le nombre total d'une table à partir d'une condition
     */

    static function get_field_byField($table, $field, $value, $field1) {
        $rekete = "SELECT " . $field1 . " AS NOMBRE  FROM " . $table . " WHERE " . $field . " <> ? ";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        $list = $result->fetch();
        if ($list["NOMBRE"] != NULL)
            return $list["NOMBRE"];
        else
            return 0;
    }

    /*
     * Pour compter le nombre total d'une table à partir d'une condition
     */

    static function get_field_byFieldd($table, $field, $value, $field1) {
        $rekete = "SELECT " . $field1 . " AS NOMBRE  FROM " . $table . " WHERE " . $field . " = ? ";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        $list = $result->fetch();
        if ($list["NOMBRE"] != NULL)
            return $list["NOMBRE"];
        else
            return 0;
    }

    /*
     * pour executer une requete sql et renvoyer
     * le jeu d'enregistrement de du resultat de
     *   l'execution de la requete
     */

    static function commit_record($rekete, $param = "") {
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result->fetch();
    }

    /*
     * pour selectionner tous les
     * enregistrements d'une table
     */

    static function get_data($table) {
        $rekete = "SELECT * FROM " . $table . " ORDER BY created DESC";
        $result = Functions::commit_sql($rekete, "");
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * 
     * Retoune un enregistrement d'une table
     * suivant la valeur d'un champ donné
     * $table : le libellé de la table
     * $field est le libellé de la conne à tester
     * $value est la valeur recherchée
     * 
     */

    static function get_record_byfield($table, $field, $value) {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $field . " = ? ORDER BY created DESC ";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * Meme Chose que get_record_byfield
     * Mais donne la possiblité d'ajouter une condition sql
     * $condition est la condition sql à rajouter. 
     */

    static function get_record_byCondition($table, $condition, $param = "") {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $condition;
        //Functions::afficheBoiteMsg($rekete);
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * Meme Chose que get_record_byfield
     * Mais donne la possiblité d'ajouter une condition sql
     * $condition est la condition sql à rajouter.
     */

    static function get_record_byfieldOrder($table, $field, $value, $condition) {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $field . " = ? ORDER BY " . $condition;
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * Recupere Distinctement les valeurs de
     * Column suivant la valeur d'un champ donné
     */

    static function get_record_byfieldColumn($table, $field, $value, $column) {
        $rekete = "SELECT DISTINCT " . $column . " FROM " . $table . " WHERE " . $field . " = ?";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     * fonction pour retourner un enregistrement approximatif
     */

    static function get_record_byapproximateField($table, $field, $value) {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $field . " LIKE ? ORDER BY created DESC";
        $param = array("%$value%");
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*  Cedric Amonle */

    static function get_record_byapproximateFields($table, $field1, $field2, $value) {
        $rekete = "SELECT * FROM " . $table . " WHERE " . $field1 . " LIKE ? OR " . $field2 . " LIKE ? ORDER BY created DESC";
        $param = array("%$value%", "%$value%");
        $result = Functions::commit_sql($rekete, $param);
        if (Functions::is_void($result))
            return false;
        else
            return $result;
    }

    /*
     *  pour compter le nombre d'enregistrement selon un idienfiant de la table
     */

    static function get_number($table, $ID) {
        $rekete = "SELECT MAX(" . $ID . ") as NOMBRE FROM " . $table;
        $result = Functions::commit_sql($rekete, "");
        $list = $result->fetch();
        if ($list["NOMBRE"] != NULL)
            return $list["NOMBRE"];
        else
            return 0;
    }

    /*
     * Pour compter le nombre total d'une table
     */

    static function get_Count($table) {
        $rekete = "SELECT COUNT(*) as NOMBRE FROM  " . $table;
        $result = Functions::commit_sql($rekete, "");
        $list = $result->fetch();
        if ($list["NOMBRE"] != NULL)
            return $list["NOMBRE"];
        else
            return 0;
    }

    /*
     * Pour compter le nombre total d'une table à partir d'une condition
     */

    static function get_Count_byField($table, $field, $value) {
        $rekete = "SELECT COUNT(*) as NOMBRE FROM " . $table . " WHERE " . $field . " <> ? ";
        $param = array($value);
        $result = Functions::commit_sql($rekete, $param);
        $list = $result->fetch();
        if ($list["NOMBRE"] != NULL)
            return $list["NOMBRE"];
        else
            return 0;
    }

    /*
     * GBETIE Gamaliel
     * Créé le 04/01/2013 à 13h20
     * Dernière modification : 20/01/2013 à 01h30
     * Retourne une combo contenant les éléments d'une table
     * $table : nom de table à afficher dans la combo
     * $idtable : nom de la colonne de la table qui fera office de l'option value
     * $colonne : nom de la colonne de la table à afficher dans la combo
     * $choixdefaut : Texte à afficher pour l'option par défaut
     * $onchange : Fonction javascript à exécuter après sélection d'une option de la combo
     * $idcombo : id de la combo
     * $largeur : Largeur de la colonne
     */

    static function convertDate($da) {
        $v = explode("-", $da);
//        $m = ($v[1]>10)?$v[1]:('0'.$v[1])
        $d = $v[2] . "-" . $v[1] . "-" . $v[0];
        return $d;
    }
    

    static function LoadCombo_Annee($an, $onchange = "") {

        $anencours = date("Y");

        $affich = "<select name='annee' style='float:left;margin-right:10px;height:30px;width:80px;' id='annee' onchange='" . $onchange . "'>";
//        $affich.="<option value='0'>--Choix année--</option>";
        for ($i = $anencours - 10; $i <= $anencours; $i++) {
            if ($i == $an) {
                $sel = "selected=selected";
            }
            else
                $sel = "";
            $affich.="<option " . $sel . " value=" . $i . ">";
            $affich.=$i . "</option>";
        }
        $affich.="</select>";
        return $affich;
    }

    static function LoadCombo_Sexe() {
        $affich = "<select name='sexe' style='height:30px;width:170px;' type='text' id='sexe'>";
        $affich.="<option value='Masculin'>Masculin</option>";
        $affich.="<option value='Féminin'>Féminin</option>";
        $affich.="</select>";
        return $affich;
    }

    static function LoadCombo_SexeParam($sexe) {
        $affich = "<select name='sexe' style='height:30px;width:170px;' type='text' id='sexe'>";
        $choice1 = "";
        if ($sexe == 'Masculin') {
            $choice1 = 'selected=selected';
        }
        $choice2 = "";
        if ($sexe == 'Féminin') {
            $choice2 = 'selected=selected';
        }

        $affich.="<option value='Masculin' $choice1>Masculin</option>";
        $affich.="<option value='Féminin' $choice2>Féminin</option>";
        $affich.="</select>";
        return $affich;
    }

    static function afficheBoiteMsg($msg) {
        echo '<SCRIPT type="text/javascript">alert("' . $msg . ' ")</SCRIPT>     ';
    }

    static function renvoiDate($date, $format) {
        $debut = new DateTime($date);
        return $debut->format($format);
    }

    static function lancerPageSuivantIDenreg($refpage, $id = "") {
        $_SESSION['idenreg'] = $id;
        if (isset($_GET['id']) && ($id == ""))
            $_SESSION['idenreg'] = $_GET['id']; //echo 'Salut Marie '.$_GET['id'];
        ?>
        <SCRIPT language="javascript">
            document.location.href = "<?php echo $refpage; ?>";

        </SCRIPT> 

        <?php
    }

    //cette fonction parcour un array et verifie si une valeur est dans le tableau
    static function valInArray($valeur, $array, $colname = "") {
        $sortie = false;
        $nbre = count($array);
        //for
        for ($i = 0; $i < $nbre; $i++) {
            if ($colname == "") {
                if ($valeur == $array[$i]['id']) {
                    $sortie = true;
                    return $sortie;
                }
            } else {
                if ($valeur == $array[$i][$colname]) {
                    $sortie = true;
                    return $sortie;
                }
            }
        }
        return $sortie;
    }

    
    public static function formatnombre($nombre, $separateur = " ") {
        
        $nb = explode('.', $nombre);
        $t = sizeof($nb, 1);
        
        $n1 = Functions::formatnombresimple($nb[0], $separateur);
        $n2 = ($t>1)?'.'.Functions::formatnombresimple($nb[1], $separateur):'';
        
        return $n1.$n2;
    }
    
    public static function formatnombresimple($nombre, $separateur = " ") {
        $retour = "";
                            
        $taille = strlen($nombre);
        $niveau = $taille;
        
        $m = $taille % 3; //taille Modulo 3
//        $n = (int) ($taille / 3); //division entière de taille par 3
        if ($taille > $m) {
            while ($niveau > $m) {
                $niveau -=3;
                $ch = substr($nombre, $niveau, 3);
                if ($retour == '')
                    $retour = $ch . $retour;
                else {
                    $retour = $ch . $separateur . $retour;
                }
            }
        }
       
        $ch = substr($nombre, 0, $m);
        if ($m > 0) {
            if ($retour == '')
                $retour = $ch . $retour;
            else {
                $retour = $ch . $separateur . $retour;
            }
        } //Functions::afficheBoiteMsg($retour1);
        return $retour;
    }

    public static function getidMax($table) {
        $rekete = "SELECT max(id) AS id FROM  " . $table;
        $result = Functions::commit_sql($rekete, "");
        $id = 0;
        if ($result) {
            $list = $result->fetch();
            if ($list['id'] != NULL)
                $id = $list['id'];
        }
        return $id;
    }

    static function LoadCombo($rekete, $idtable, $colonne, $idcombo, $choixdefaut, $largeur = "210", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "") {
     $affich = "";     //Functions::afficheBoiteMsg($largeur);
        $onch = "";
     if($onchange!='') $onch = "onchange =".$onchange; //."'";
     if ($multiple == "") {
            $affich = "<select class='m-chosen  span4' id='" . $idcombo . "' name='".$idcombo."' " . $onch . " style='height: 30px; width:" . $largeur . "px;' >";
        } else {
            $affich = "<select class='m-chosen  span4' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' " . $onch . " style='height: 30px; width: " . $largeur . "px;' >";
        }
        $affich.="<option value='0'>--" . $choixdefaut . "--</option>";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            while ($list = $result->fetch()) {
                $depinit = "";
                if ($list[$idtable] == $idencours) {
                    $depinit = 'selected=selected';
                }
                $affich.="<option " . $depinit . " value=" . $list[$idtable] . ">";
                $affich.=$list[$colonne] . "</option>";
            }
            $affich.="</select>";
        }

        return $affich;
    }

    static function comboMultiSimple($rekete, $idtable, $colonne, $idcombo, $choixdefaut, $largeur = "210", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "") {
     $affich = "";     //Functions::afficheBoiteMsg($largeur);
        $onch = "";
     if($onchange!='') $onch = "onchange =".$onchange; //."'";
//     if ($multiple == "") {
//            $affich = "<select class='m-chosen  span4' id='" . $idcombo . "' name='".$idcombo."' " . $onch . " style='height: 30px; width:" . $largeur . "px;' >";
//        } else {
//            $affich = "<select class='m-chosen  span4' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' " . $onch . " style='height: 30px; width: " . $largeur . "px;' >";
//        }
        
        $affich = "<select class='multiselect span4' multiple='multiple' style='height: 30px; width: " . $largeur . "px;' " . $onch . " >";
        
//        $affich.="<option value='0'>--" . $choixdefaut . "--</option>";
        $result = Functions::commit_sql($rekete, "");
        if ($result) {
            while ($list = $result->fetch()) {
                $depinit = "";
                if ($list[$idtable] == $idencours) {
                    $depinit = 'selected=selected';
                }
                $affich.="<option " . $depinit . " value=" . $list[$idtable] . ">";
                $affich.=$list[$colonne] . "</option>";
            }
            $affich.="</select>";
        }

        return $affich;
    }
    
    static function LoadCombo2($rekete, $idtable, $colonne, $idcombo, $choixdefaut, $largeur = "214", $onchange = "",$idencours) {
//        global $dbh;
        $result = Functions::commit_sql($rekete, "");
        $affich = "<select name='" . $idcombo . "' style='height: 30px; width: " . $largeur . "px;' onchange='" . $onchange . "'  type='text'  id='" . $idcombo . "' >";
        $affich.="<option value='0'>--" . $choixdefaut . "--</option>";
         if ($result) {
            while ($list = $result->fetch()) {
                $depinit = "";
                if ($list[$idtable] == $idencours) {
                    $depinit = 'selected=selected';
                }
                $affich.="<option " . $depinit . " value=" . $list[$idtable] . ">";
                $affich.=$list[$colonne] . "</option>";
            }
            $affich.="</select>";
        }
        return $affich;
    }

    
    static function finDuMois($mois, $an) {
//        echo $mois;
        switch ($mois) {

            case '1':return 31;
            case '2':
                if (Functions::anneeBissextile($an) > 0) {
                    return 29;
                } else {

                    return 28;
                }
            case '3':return 31;
            case '4':return 30;
            case '5':return 31;
            case '6':return 30;
            case '7':return 31;
            case '8':return 31;
            case '9':return 30;
            case '10':return 31;
            case '11':return 30;
            case '12':return 31;

            default:
                break;
        }
    }

    static function nomduMois($mois) {
        switch ($mois) {
            case"1": return "Janvier";
            case"2": return "Février";
            case"3": return "Mars";
            case"4": return "Avril";
            case"5": return "Mai";
            case"6": return "Juin";
            case"7": return "Juillet";
            case"8": return "Août";
            case"9": return "Septembre";
            case"10": return "Octobre";
            case"11": return "Novembre";
            case"12": return "Décembre";
        }
    }

    static function anneeBissextile($an) {
        $q = 0;

        if (($an % 4) == 0) {
            if (($an % 100) == 0) {
                if (($an % 400) == 0) {
//                            echo "C'est une année bissextile";
                    $q = 1;
                } else {
//                            echo "Ce n'est pas une année bissextile";                        
                }
            } else {//                        echo "C'est une année bissextile";
                $q = 1;
            }
        } else {
//                    echo "Ce n'est pas une année bissextile";
        }

        return $q;
    }

      static function LoadComboListe($donnees, $idtable, $colonne, $idcombo, $choixdefaut, $largeur = "214", $onchange = "", $idencours = "", $multiple = "", $idtabloRet = "") {
     $affich = "";     //Functions::afficheBoiteMsg($largeur);
        if ($multiple == "") {
            $affich = "<select class='m-chosen  span4' id='" . $idcombo . "' onchange='" . $onchange . "' style='height: 30px; width: " . $largeur . "px;' >";
        } else {
            $affich = "<select class='m-chosen  span4' multiple='" . $multiple . "' id='" . $idcombo . "'  name='" . $idtabloRet . "' onchange=" . $onchange . " style='height: 30px; width: " . $largeur . "px;' >";
        }
        $affich.="<option value='0'>--" . $choixdefaut . "--</option>";
        foreach ($donnees as $v) :
           $depinit = "";           //Functions::afficheBoiteMsg($colonne);
            if ($v[$idtable] == $idencours) {
                    $depinit = 'selected=selected';
                }
                $affich.="<option " . $depinit . " value=" . $v[$idtable] . ">";
                $affich.= $v[$colonne] . "</option>";
       
                endforeach;
                 $affich.="</select>";
                 
        return $affich;
    }
    
//    Ajout date
    
    public static function datePlus($d,$nbJ=0,$nbM=0,$nbA=0,$nbH=0,$nbMn=0,$nbS =0){
         $dj = Functions::renvoiDate($d,"Y-m-d");
        list($annee,$mois,$jour,$h,$m,$s)=sscanf($dj,"%d-%d-%d %d:%d:%d");
        $annee += $nbA;
        $mois += $nbM;
        $jour += $nbJ;
        $h += $nbH;
        $m += $nbMn;
        $s += $nbS;
        $timestamp=mktime($h,$m,$s,$mois,$jour,$annee); 
        return date('d-m-Y',$timestamp);
    }
    
      static function RegisterReketePourSynchro($rekete) {
        //$dateHeure DateHeure de la dernière synchronisation 
        $date = date('d-m-y');
        $time = date('d-m-y-H-i-s');
        $message = "\n" . $rekete . " ;" . $time;
        $synchroFile = './' . SYNCHRONISATION_FOLDER . "/Synchro_".  gethostname() . $date . ".cvs";
        if (file_exists(SYNCHRONISATION_FOLDER)) {
            $file = fopen($synchroFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        } else {
            $synchroFile = '../' . SYNCHRONISATION_FOLDER . "/Synchro_".  gethostname() . $date . ".cvs";
            $file = fopen($synchroFile, "a+");
            while (feof($file)) {
                fgets($file);
            }
            fwrite($file, $message);
        }
         //enregistrer le fichier dans la bd
        $nommFichier = "Synchro_".  gethostname() . $date . ".cvs";
        $S = new fichier('');
        $S->setNomfile($nommFichier);
        $S->ajoutFile();
        //Functions::afficheBoiteMsg($result);
    }
}
?>