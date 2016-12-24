 

<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once("./includefiles.php");
if (!isset($_SESSION["connectAdmin"]))
    header("Location:connexion.php");
//TIME_OUT
//if (isset($_SESSION['user'])) {
//    // On vérifie si le temps d'inactivité n'a pas été dépassé
//    if ((time() - $_SESSION['last_access']) > SESSION_TIMEOUT) {
//        header("Location:deconnect.php");
//    }
//}
?>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>PROJET SCP</title>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->

        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--[if lt IE 9]><script src="js/html5ie.js"></script><![endif]-->

        <!-- Le fav and touch icons -->
          <!--<link rel="shortcut icon" href="images/logo-SIPEC.ico">-->

        <!-- Les styles CSS -->
        <?php include_once("includes/css.inc.php"); ?>

        <!-- Les variables d'initialisation -->
        <?php // include_once("includes/initvar.inc.php"); ?>
    </head>

    <body onload="horloge();">

        <div id="status-bar"></div>
        <div id="page">
            <!-- Header -->
            <header id="header">
                <?php include_once("includes/header.inc.php"); ?>
            </header>

            <section id="connexion">              
                <?php include_once("includes/connexion.inc.php"); ?>                
            </section>
            
<!--            <section id="barreoutils">          
                <?php // include_once("includes/barreoutils.inc.php"); ?>                
            </section>-->

            <!-- Corps -->
            <section id="content">
                <!--  Slider -->
                <div id="slider-home">

                </div>

                <!--  Mon compte -->
                <div id="zoneeditPersonneUser">

                </div>

                <!--  Changer mot de passe -->
                <div id="zoneeditPasswordUser">

                </div>

                <!--  Zone d'affichage de message d'information -->
                <div id="zoneinfo" style="display: none" >

                </div>
               
                    <!-- Left -->
                    <aside id="content-left">
                        <?php include_once("includes/left.inc.php"); ?> 
                    </aside>

                    <!-- Right -->
                    <aside id="content-right">
                        <?php include_once("includes/right.inc.php"); ?>
                    </aside>
                </section>
               


            <!-- Pied de page -->
            <footer id="footer">
                <?php include_once("includes/footer.inc.php"); ?>
            </footer>
            <!-- Fin -->
        </div>

        <!-- Le javascript
               ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php include_once("includes/js.inc.php"); ?>
        <?php // ?>


    // try to redirect
    </body>
</html>


