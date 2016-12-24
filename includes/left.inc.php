<!--<div class="menu">-->
<div class="accordion" id="accordion2">
    <?php
    if (isset($_SESSION['userMenu'])) { 
        include_once 'nav/menuCollaboration.inc.php';
        include_once 'nav/menuTraitements.inc.php';
        include_once 'nav/menuParametre.inc.php';
        include_once 'nav/menuRapport.inc.php';

    }
    ?>
</div>
