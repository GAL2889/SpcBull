<!DOCTYPE HTML>
<?php
$connect["rep"] = false;
$connect["msg"] = "";
include_once("./includefiles.php");
//include_once("./inc/form/formConfiguration.php"); 
if (isset($_POST["submitConnect"]))
    include_once("commitConnect.php"); //TO treat a submit Action
?>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>GE-SCP </title>
        <link rel="stylesheet" type="text/css" href="css/jlogin.css" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" href="css/reveal.min.css">
        <!--<link rel="shortcut icon" href="images/logo-SIPEC.ico">-->
        <script type="text/javascript" language="javascript" src="js/jbootstrap.js"></script>
        <script type="text/javascript" language="javascript" src="js/jquery-1.5.js"></script>
        <script type="text/javascript" language="javascript" src="js/jLogin-1.0.js"></script>
        <script src="js/reveal.min.js"></script>
    </head>

      <body style="margin-top: 16%;"> 
<!--    <body style="margin-top: 16%; background: url('images/baniere acceil.jpg') center no-repeat  fixed  ;"> -->
        <div id="log-cont">
            <h4 style="color: white; margin-top: 0px; font-family:'elvetica Neue', Helvetica, Arial, sans-serif " ><font size=3 >Espace de connexion<br></font><small style="color: white;"><b><font size=3>GE-SCP</font></b></small></h4>
            <form action="" method="post" class="formConnectAdmin form-horizontal" style="margin: 20px">
                <?php
                if ($connect["rep"] == true) {
                    $_SESSION['ancre'] = '';
                    if ($_SESSION['user']['idprofil'] == 3) {
                        header("Location:index.php");
                    } else {
                        header("Location:index.php");
                    }
                } else {
                    echo $connect["msg"];
                }
                ?>

                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input type="text" id="login" name="login" class="span2" id="prependedInput" placeholder="Identifiant" style="width: 150px; height: 20px;" onchange=""/>
                        <!--JProfil.onchangeTxtLogin();-->
                    </div>
                </div>

                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        <input type="password" id="pass" name="pass" class="span2" id="prependedInput" placeholder="Mot de passe" style="width: 150px; height: 20px;"/>
                    </div>
                </div>

                <div class="control-group">
                    <center>
                        <input type="reset" value="Annuler" class="btn btn-small btn-primary"/>
                        <input  type="submit" value="Connecter" name="submitConnect" class="btn btn-small btn-primary" />                        
                    </center>
                </div>   

            </form>

        </div>
        <!--</div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!-- Le javascript
              ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <?php include_once("includes/js.inc.php"); ?>
    </body>
</html>
