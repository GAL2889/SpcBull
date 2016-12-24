<ul class="nav nav-pills pull-right ">

    <li class="dropdown active ">
        <a href="#" class="dropdown-toggle btn-small accordion-heading " data-toggle="dropdown"><i class="icon-user"></i> Bienvenue <?php // echo substr($utilisateur->getNom(),4) ; ?> <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <?php
                $listeParam = '';
            if (Functions::valInArray("19", $_SESSION['userMenu'])) {
//                $conf = 'moncompte';
                ?>
                <!--<li><a href="index.php?config=moncompte">Mon compte</a></li>-->    
                <!--<li><a href="#" onclick="JPrincipal.afficheContenu(0, 'moncompte', '<?php echo $listeParam; ?>', ' ');">Mon compte</a></li>-->    
                <?php
            }
            ?>
            <?php
            if (Functions::valInArray("20", $_SESSION['userMenu'])) {
                ?>
                <li><a href="#" onclick="JPrincipal.afficheContenu(0, 'password', '<?php echo $listeParam; ?>', 'Accueil');">Changer mon mot de passe</a></li>  

                <?php
            }
            ?>
            <?php
            if (Functions::valInArray("21", $_SESSION['userMenu'])) {
                ?>
                <!--<li><a href="#" onclick="JPrincipal.afficheContenu(0, 'structure', '<?php echo $listeParam; ?>', 'Accueil');">Gestion des structures</a></li>--> 
                <?php
            }
            ?>


            <?php
            if (Functions::valInArray("22", $_SESSION['userMenu'])) {
                ?>
                <li><a href="#" onclick="JPrincipal.afficheContenu(0, 'utilisateur', '<?php echo $listeParam; ?>', 'Accueil');">Utilisateurs</a></li>
                <?php
            }
            ?>

            <?php
            if (Functions::valInArray("23", $_SESSION['userMenu'])) {
               ?>
                <!--<li><a href="#" onclick="JPrincipal.afficheContenu(0, 'profil', '//<?php echo $listeParam; ?>', 'Accueil');">Gestion des profils</a></li>-->
               <?php
            }
            ?>

            <?php
            if (Functions::valInArray("24", $_SESSION['userMenu'])) {
                ?>
                <!--<li><a href="#" onclick="JPrincipal.afficheContenu(0, 'menuprofil', '<?php echo $listeParam; ?>', 'Accueil');">Gestion des menus</a></li>-->  
                <?php
            }
            if (Functions::valInArray("24", $_SESSION['userMenu'])) {
                ?>
                <li><a href="#" onclick="JPrincipal.afficheContenu(0, 'droitacces', '<?php echo $listeParam; ?>', 'Accueil');">Gestion des droits d'accès</a></li>  
                <?php
            }
            ?>


        </ul>
    </li>
    <li class="active "><a class="accordion-heading" href="deconnect.php" ><i class="icon-off icon-white "></i> Déconnexion</a></li>
</ul>