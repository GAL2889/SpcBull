<?php $listeParam = ""; 
 //Functions::afficheBoiteMsg($_SESSION['config']);
?>
<!-- Menu Rapports -->
<?php
if (Functions::valInArray("1", $_SESSION['userMenu'])) {
    ?>
<div class="accordion-group">
    <div class="accordion-heading area">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#Rapports" href="#" onclick="JPrincipal.afficheMenu('<?php echo "#Rapports" ?>',0);"  ><i class="icon-globe"></i> 
            <b>Rapports</b></a>
    </div>
    <!-- Sous Menu Saisie -->
    
    <div id="Rapports" class="accordion-body collapse <?php if ((isset($_SESSION['ancre']) && $_SESSION['ancre'] == "#Rapports")&&(isset($_SESSION['menuouvert']) && $_SESSION['menuouvert'] == 1)) echo 'in'; ?>">
        <div class="accordion-inner">
            <ul class="nav nav-list bs-docs-sidenav" id = "bs-docs">
                 <?php
                     if (Functions::valInArray("2", $_SESSION['userMenu'])) {
                    ?>
                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'statistiques') echo 'class="active"' ?> >
                <!--<li id="listatistiques">-->
                    <a href="#" onclick="JPrincipal.selectionSousMenu('#Rapports');JPrincipal.afficheContenu(0,'statistiques','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Statistiques</a>
                </li>
                 <?php
                    }
                     if (Functions::valInArray("3", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'envoye') echo 'class="active"' ?> >                
                    <a href="#" onclick="JPrincipal.selectionSousMenu('#Rapports'); JPrincipal.afficheContenu(0,'envoye','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Envoyées</a>
                </li>-->
                 <?php
                    }
                     if (Functions::valInArray("4", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'nonlus') echo 'class="active"' ?> >                
                    <a href="#" onclick=" JPrincipal.selectionSousMenu('#Rapports');JPrincipal.afficheContenu(0,'nonlus','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Non lues</a>
                </li>-->
                 <?php
                    }
                     if (Functions::valInArray("4", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'addnotification') echo 'class="active"' ?> >                
                    <a href="#" onclick=" JPrincipal.selectionSousMenu('#Rapports');JPrincipal.afficheContenu(0,'addnotification','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Nouveau</a>
                </li>-->
                 <?php
                    }
                    ?>
            </ul>
        </div>
    </div>  
</div>   
<!-- /Menu Rapports -->
   <?php
}

?>
