<?php

function renomFichier($name_file) {
    $date = date('d-m-Y');
    $heure = date('H-i');
    $name_file1 = $date . " " . $heure . ".xls";
    //vérifier si le fichier existe
    $content_dir = "tmp/"; // dossier ou se trouve le fichier
    if (file_exists($content_dir . $name_file)) {
        rename($content_dir . $name_file, $content_dir . $name_file1);
        $mes = "Le fichier a ete bien renomme.";
    } else {
        $mes = "Le fichier n'existe pas.\n.Veuillez charger ce fichier ";
    }
    return $content_dir . $name_file1;
}

//appel de la fonction
//renomFichier("nouveaua.xlsx");
//convertir le fichier .xlsx en .cvs
function convert($name_file) {
    $content_dir = "tmp/"; // dossier ou se trouve le fichier
    if (file_exists($content_dir . $name_file)) {
        //fgetcsv($content_dir.$name_file,,";");
    }
}

//recuperer lentete d'un fichier excel
function entete($name_file) {
    $del = ";";
    //vérifier si le fichier existe
    $content_dir = "tmp/"; // dossier ou se trouve le fichier
    if (file_exists($content_dir . $name_file)) {
        $content = file($content_dir . $name_file);
        //compter le nombre de ligne
        $l = count($content);
        //echo $l;
        //on lis la 1ere ligne pour g?n?rer lles listes
        $fp = fopen("$content_dir" . "$name_file", 'r');
        $str = "";
        $cpt = 0;

        $str .= fgets($fp, 99000);
        //echo $str;
        $str = trim($str);
        if (substr($str, -1, 1) != $del) {
            $str .= $del;
        }

        $tabcsv = explode($del, $str);
        //echo $str;
        //echo $tabcsv[2];
        //dans le tab se trouve les champs
        fclose($fp);
        //print_r($tabcsv);
    } else {
        echo "Le fichier n'existe pas.\n Veuillez charger ce fichier ";
    }
}

//appel de la fonction
//entete("ouveaua.csv");
//lit tout le fichier excel
function toutfichier($name_file) {
    $content_dir = "tmp/"; // dossier ou se trouve le fichier
    $ligne = 1; // compteur de ligne
    if (file_exists($content_dir . $name_file)) {
        $fic = fopen("$content_dir" . "$name_file", "r");
        $content = file($content_dir . $name_file);
        //compter le nombre de ligne
        $l = count($content);
        while ($ligne <= $l) {
            $tab = fgetcsv($fic, 99000, ';');
            $champs = count($tab); //nombre de champ dans la ligne en question
            echo "<b> Les " . $champs . " champs de la ligne " . $ligne . " sont :</b><br />";
            if ($ligne > 1) {
                //affichage de chaque champ de la ligne en question
                for ($i = 0; $i < $champs; $i++) {
                    echo $tab[$i] . "<br />";
                }
            }
            $ligne++;
        }
    }
}

//appel de la fonction
//toutfichier("ouveaua.csv");
//recuperer les champs de l'entete
function entetefichier($name_file) {
    $content_dir = "tmp/"; // dossier ou se trouve le fichier
    $ligne = 1; // compteur de ligne
    if (file_exists($content_dir . $name_file)) {
        $fic = fopen("$content_dir" . "$name_file", "r");
        $content = file($content_dir . $name_file);
        //compter le nombre de ligne
        $l = count($content);
        while ($ligne <= $l) {
            $tab = fgetcsv($fic, 99000, ';');
            $champs = count($tab); //nombre de champ dans la ligne en question
            //echo "<b> Les " . $champs . " champs de la ligne " . $ligne . " sont :</b><br />";
            if ($ligne == 1) {
                //affichage de chaque champ de la ligne en question
                for ($i = 0; $i < $champs; $i++) {
                    #echo $tab[$i] . "<br />";
                }
            }
            $ligne++;
        }
    }
    return $tab;
}

//appel de la fonction
//entetefichier("test.csv");
//
function cellule($nligne, $nchamp, $name_file) {



    $data = new Spreadsheet_Excel_Reader();

// Définition du type d’encodage de caractère à utiliser pour la sortie (ce qui va être affiché à l’écran)
// ici on utilise l’encodage de Windows voir http://en.wikipedia.org/wiki/CP1251
    $data->setOutputEncoding('CP1251');

// Chargement du fichier excel à lire
    $data->read($name_file);



    /* for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) { */
    $pos = "";
    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        $entete = $data->sheets[0]['cells'][1][$j];
        if ($nchamp == $entete)
            $pos = $j;
        /* echo $data->sheets[0]['cells'][$i][$j].","; */
    }
    echo "
";
/////////
//echo $pos;
    if ($pos != "") {

        $maxc = $data->sheets[0]['cells'][$nligne][$pos];
    }


    return $maxc;
}

//appel de la fonction
//cellule(3,"DATE NAISSANCE","dodo.csv");
//donner la valeur la plus longue de la colonne
function maximum($nchamp, $name_file) {

    $data = new Spreadsheet_Excel_Reader();

// Définition du type d’encodage de caractère à utiliser pour la sortie (ce qui va être affiché à l’écran)
// ici on utilise l’encodage de Windows voir http://en.wikipedia.org/wiki/CP1251
    $data->setOutputEncoding('CP1251');

// Chargement du fichier excel à lire
    $data->read($name_file);



    /* for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) { */
    $pos = "";
    for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
        $entete = $data->sheets[0]['cells'][1][$j];
        if ($nchamp == $entete)
            $pos = $j;
        /* echo $data->sheets[0]['cells'][$i][$j].","; */
    }

/////////
//echo $pos;
    if ($pos != "") {
        $max = 0;
        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {



            if ((strlen($data->sheets[0]['cells'][$i][$pos])) > $max) {

                $max = strlen($data->sheets[0]['cells'][$i][$pos]);
                $maxc = $data->sheets[0]['cells'][$i][$pos];
            }
        }
    }

    return $maxc;




    //}
}

//appel de la fonction
//maximum("BOITE POSTALE","Test_Excel.csv");
//cellule(2,"TEL","test.csv");
?>