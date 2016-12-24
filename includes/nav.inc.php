<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="index.php">Accueil</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opérations <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li class="nav-header">CLIENTS</li>
                            <li><a href="#">Enregistrement des clients</a></li>
                            <li><a href="#r">Enregistrement du dossier d'un client</a></li>                          
                            
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consultation <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?config=listeclientconteneursnonretournes">Liste des clients avec conteneurs non retournés</a></li>
                            <li><a href="index.php?config=listeclientconteneursretournes">Liste des clients avec conteneurs retournés</a></li>
                           <?php
                            if (isset($_SESSION["user"]['idprofil']) && $_SESSION["user"]['idprofil'] == 1) {
                                ?>
                                <li class="divider"></li>
                                <li class="nav-header">BILAN DES COMISSIONS</li>
                                <li><a href="index.php?config=bilanperiodique">Bilan périodique</a></li>
                                <li><a href="index.php?config=bilanannuel">Bilan annuel</a></li>
                                <?php
                            }
                            ?>                            
                        </ul>
                    </li>

                    <li class="conteneur active">
                        <a href="#" rel="tooltip" data-placement="top" title="<?php echo 'Il y a ' . Functions::countRetour() . ' client(s) n\'ayant pas retourné(s) les conteneurs'; ?>"><i class="icon-bell"></i>
                            <sup>
                                <span class="label label-important"><?php echo Functions::countRetour(); ?></span>                              
                            </sup>
                        </a>
                    </li>
                </ul>

                <ul class="nav pull-right">

                    <li><a href="deconnect.php">Déconnexion</a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" rel="tooltip" data-placement="top" title="<?php echo $_SESSION["user"]["nomprenom"]; ?>">                                    
                            <i class="icon-user"></i> Bienvenue <strong><?php echo substr($_SESSION["user"]["nomprenom"], 0, 8) . '...'; ?></strong>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="nav-header">Utilisateur : <?php echo $_SESSION["user"]["nomprenom"]; ?></li>
                            <li class="divider"></li>
                            <li><a href="#" onclick="JUtilisateurs.editPersonneUser('<?php echo $_SESSION["user"]["idutilisateur"] ?>');">Mes informations personnelles</a></li>
                            <li><a href="#" onclick="JUtilisateurs.editPasswordUser('<?php echo $_SESSION["user"]['idutilisateur'] ?>');">Changer votre mot de passe</a></li>

                            <?php
                            if (isset($_SESSION["user"]['idprofil']) && $_SESSION["user"]['idprofil'] == 1) {
                                ?>
                                <li class="divider"></li>
                                <li><a href="index.php?config=utilisateur">Gestion des utilisateurs</a></li>
                                <?php
                            }
                            ?>
                            <li><a href="aide/MANUEL_GIRC.pdf" target="_blank">Aide</a></li>
                        </ul>
                    </li>                            

                </ul>
            </div><!-- /.nav-collapse -->
        </div>
    </div><!-- /navbar-inner -->
</div><!-- /navbar -->