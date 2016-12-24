<div id="zoneListeSite" data-spy="scroll">
<?php
//$actuliaison = principale::actualiseCodeuniqueLiaison("droitacces");
if ((isset($_SESSION['config'])) && ($_SESSION['config'] != 'Accueil')) {   //Functions::afficheBoiteMsg('Merci Seigneur');
    $retour = 'Accueil';
    if (isset($_SESSION['retour']))
        $retour = $_SESSION['retour'];
    principale::afficheContenu($_SESSION['config'], 'Accueil');
} else {
    ?>

    <h1>Bienvenue !</h1>
    <p>  
        Cette plateforme est un ERP destinée exclusivement à la gestion du système d'information de la TECMAVS Cie.
        la gestion des finances, la gestion commerciale et la gestion des ressources humaines.</p> 
    <div  style=" height: 20px;">
    </div>
    <div id="zoneListeSite0" >
        <!--Slider-->
        <div id="myCarousel2" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <img src="images/ImgTec/images (1).jpg" alt="Merci" style="width: 750px; height: 200px;">
                    <div class="carousel-caption" style="height: 10px;">
                        <h4>SI-TECMAVS</h4>
                        <p> Système d'information pour la TECMAVS Cie</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/ImgTec/images (2).jpg" alt="Dieu" style="width: 750px; height: 200px;">
                    <div class="carousel-caption" style="height: 10px;">
                        <h4>SI-TECMAVS</h4>
                        <p> Système d'information pour la TECMAVS Cie</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/ImgTec/images (3).jpg" alt="Dieu" style="width: 750px; height: 200px;">
                    <div class="carousel-caption" style="height: 10px;">
                        <h4>SI-TECMAVS</h4>
                        <p> Système d'information pour la TECMAVS Cie</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/ImgTec/images (4).jpg" alt="Dieu" style="width: 750px; height: 200px;">
                    <div class="carousel-caption" style="height: 10px;">
                        <h4>SI-TECMAVS</h4>
                        <p> Système d'information pour la TECMAVS Cie</p>
                    </div>
                </div>
                <div class="item">
                    <img src="images/ImgTec/images (5).jpg" alt="Dieu" style="width: 750px; height: 200px;">
                    <div class="carousel-caption" style="height: 10px;">
                        <h4>SI-TECMAVS</h4>
                        <p> Système d'information pour la TECMAVS Cie</p>
                    </div>
                </div>
                

            </div>
            <a class="left carousel-control" href="#myCarousel2" data-slide="next">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel2" data-slide="prev">&rsaquo;</a>
        </div>

        <!--Fin slider-->

    </div>        
    
    </div>

    <?php
}
?>