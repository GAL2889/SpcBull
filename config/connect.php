<?php
include_once("config.php");
try {
    $dbh = new PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    echo "<p>Erreur :" . $e->getMessage() . ": veuillez re&eacutessayez plus tard</p>";
    exit();
}
?>