<?php

extract($_POST);
//$instanceconnect = new ConnectAdmin($login, $pass,$cmbprofil);
$instanceconnect = new ConnectAdmin($login, $pass);
$connect = $instanceconnect->connection();
if ($connect["rep"]) {
    $_SESSION["connectAdmin"] = $connect["rep"];
    $_SESSION["user"] = $connect["user"]; // Recupere les infos sur l'utilisateur
    // On stocke l'heure de dernière connexion
    // time s'exprime en secondes à partir du 01/01/70 à 00:00:00
    $_SESSION['last_access'] = time();
    echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
}
?>