<?php $listeParam = ""; 
 //Functions::afficheBoiteMsg($_SESSION['config']);
?>
<!-- Menu Traitements -->
<?php
if (Functions::valInArray("1", $_SESSION['userMenu'])) {
    ?>
<div class="accordion-group">
    <div class="accordion-heading area">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#Traitements" href="#" onclick="JPrincipal.afficheMenu('<?php echo "#Traitements" ?>',0);"  ><i class="icon-globe"></i> 
            <b>Traitements</b></a>
    </div>
    <!-- Sous Menu Saisie -->
    
    <div id="Traitements" class="accordion-body collapse <?php if ((isset($_SESSION['ancre']) && $_SESSION['ancre'] == "#Traitements")&&(isset($_SESSION['menuouvert']) && $_SESSION['menuouvert'] == 1)) echo 'in'; ?>">
        <div class="accordion-inner">
            <ul class="nav nav-list bs-docs-sidenav" id = "bs-docs">
                 <?php
                     if (Functions::valInArray("2", $_SESSION['userMenu'])) {
                    ?>
                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'expedition') echo 'class="active"' ?> >
                <!--<li id="liacteurs">-->
                    <a href="#" onclick="JPrincipal.selectionSousMenu('#Traitements');JPrincipal.afficheContenu(0,'expedition','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Expéditions</a>
                </li>
                 <?php
                    }
                     if (Functions::valInArray("3", $_SESSION['userMenu'])) {
                    ?>
                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'scp') echo 'class="active"' ?> >                
                    <a href="#" onclick="JPrincipal.selectionSousMenu('#Traitements'); JPrincipal.afficheContenu(0,'scp','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> SCP</a>
                </li>
                 <?php
                    }
                     if (Functions::valInArray("4", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'bureauechange') echo 'class="active"' ?> >                
                    <a href="#" onclick=" JPrincipal.selectionSousMenu('#Traitements');JPrincipal.afficheContenu(0,'bureauechange','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Bureaux</a>
                </li>-->
                 <?php
                    }
                     if (Functions::valInArray("4", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'elementscp') echo 'class="active"' ?> >                
                    <a href="#" onclick=" JPrincipal.selectionSousMenu('#Traitements');JPrincipal.afficheContenu(0,'elementscp','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Eléments</a>
                </li>-->
                 <?php
                    }
                     if (Functions::valInArray("4", $_SESSION['userMenu'])) {
                    ?>
<!--                <li <?php if (isset($_SESSION['config']) && $_SESSION['config'] == 'pays') echo 'class="active"' ?> >                
                    <a href="#" onclick=" JPrincipal.selectionSousMenu('#Traitements');JPrincipal.afficheContenu(0,'pays','<?php echo $listeParam; ?>','Accueil')"><i class="icon-chevron-right"></i> Pays</a>
                </li>-->
                 <?php
                    }
                    ?>
            </ul>
        </div>
    </div>  
</div>   
<!-- /Menu Traitements -->
   <?php
}

?>
