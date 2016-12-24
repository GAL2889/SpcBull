<div id="header-left">
    <img class="logo-left" src="images/logo3.png" alt="Direct Stock" title="GE-SCP" style="width: 50px;">
</div>

<div id="header-left-left">
    <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        GESTION DES EXPEDITIONS - SCP</h4>
</div>
<!--<table>
    <tr>       
        </td>-->
        <?php
        if (isset($_SESSION["user"]["codeunique"])) {
            $utilisateur = new utilisateur($_SESSION["user"]["codeunique"]);
            $pers = new personne($utilisateur->getIdpersonne());
            $sexe = $pers->getIdsexe();
            $image = "";
            switch ($sexe) {
                case '2':
                    $image = "user.jpg";
                    break;
                case '1':
                    $image = "femme.jpg";
                    break;
            }
            if (($pers->getPhoto() != '') && ($pers->getPhoto() != NULL))
                $image = $pers->getPhoto();
            ?>
        <div id="header-right">
            <div id="timer"></div>
            <a href="#" onclick="JPrincipal.afficheContenu(0,'moncompte','','')">
                <img class="logo-right img-circle" src="<?php echo'images/photo/' . $image; ?>" alt="<?php echo personne::nomPrenom($utilisateur->getIdpersonne()); ?>" title="<?php echo personne::nomPrenom($utilisateur->getIdpersonne()); ?>">
            </a>

        </div>
<!--    </td>
    </tr>
    </table>-->
    <?php
} else {
    ?>
    <div id="header-right">
        <img class="logo-right img-rounded" src="images/user1.jpg" alt="Utilisateur" title="Utilisateur">
    </div>
    <?php
}
?>



