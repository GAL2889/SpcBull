<script type="text/javascript" src="jquery/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script src="jquery/js/jquery-ui-1.10.2.custom.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-carousel.js"></script>
<script type="text/javascript" src="js/bootstrap-tooltip.js"></script>



<!--<script type="text/javascript" src="library/bootstrap/select/bootstrap-select.js"></script>-->
<!--<script type="text/javascript" src="library/bootstrap/select2/select2.js"></script>-->
<!--<script type="text/javascript" src="library/bootstrap/select3/bootstrap-select.js"></script>-->

<!--Début Multi sélect-->
<script type="text/javascript" src="library/bootstrap/multiselect/js/jquery.min.js"></script>
<script type="text/javascript" src="library/bootstrap/multiselect/js/bootstrap.min.js"></script>
<script type="text/javascript" src="library/bootstrap/multiselect/js/bootstrap-multiselect.js"></script>
<!--Fin Multi sélect-->


<script type="text/javascript" src="library/bootstrap/formhelpers/phone/bootstrap-formhelpers-phone.format.js"></script>
<script type="text/javascript" src="library/bootstrap/formhelpers/phone/bootstrap-formhelpers-phone.js"></script>
<!--<script type="text/javascript" src="js/bootstrap.file-input.js"></script>-->
<script type="text/javascript" src="library/bootstrap/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="library/bootstrap/bootstrap-inputmask/bootstrap-inputmask.js"></script>
<script type="text/javascript" src="library/bootstrap/bootstrap-dropdown/bootstrap-dropdown.js"></script>


<script type="text/javascript" src="/js/jquery.js"></script>

<script type="text/javascript" src="/js/jquery.table.addrow.js"></script>

<script src="library/bootstrap/bootstrap-editable/js/bootstrap-editable.js"></script>
<script>
    $.fn.editable.defaults.mode = 'popup';

    $('.myeditable').editable({});

</script>

<script type="text/javascript" language="javascript" src="js/datatable/jquery.dataTables.js"></script>
<script  src="js/html-form-input-mask.js"></script>
<script src="js/chosen.jquery.js"></script>


<script src="jquery/development-bundle/ui/jquery.ui.core.js" ></script>
<script src="jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.button.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.position.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="jquery/development-bundle/ui/i18n/jquery.ui.datepicker-fr.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.menu.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.autocomplete.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect-blind.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect-bounce.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect-clip.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect-drop.js"></script>
<script src="jquery/development-bundle/ui/jquery.ui.effect-explode.js"></script>

<script src="inc/event/JPrincipal.js"></script>
<script src="inc/event/JVisualisation.js"></script>
<script src="inc/event/JProfil.js"></script>
<script src="inc/event/JUSerProfil.js"></script>
<script src="inc/event/JMenuProfil.js"></script>
<script src="inc/event/JNotification.js"></script>
<script src="inc/event/JUtilisateurs.js"></script>
<script src="inc/event/JLocalite.js"></script>
<script src="inc/event/JPersonne.js"></script> 
<script src="inc/event/JDroitAcces.js"></script>
<script src="inc/event/JTitre.js"></script>
<script src="inc/event/JTraitement.js"></script>



<!--Démarrage du slider-->
<script type="text/javascript">
    $('#myCarousel1').carousel();
    $('#myCarousel2').carousel();
    
    
</script>

<script >
    window.setInterval("JNotification.actualiseNotification()", 1000);
</script>

<script type="text/javascript">
    function appliqueDataTable() {
        $('.display').dataTable(
                {
                     "iDisplayLength": 25,
		     "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    'bJQueryUI': true,
                    'sPaginationType': 'full_numbers',                  
                    "sLengthMenu": "Recherche _MENU_ Enregistrements par page",
                    "oLanguage": {
                        "sZeroRecords": "Aucun Enregistrement...!",
                        "sInfo": "",
                        "sInfoEmpty": "",
                        "sInfoFiltered": "",
                        "sSearch": "Rechercher :",
                        "oPaginate": {
                            "sFirst": "Premier",
                            "sLast": "Dernier",
                            "sPrevious": "Precedent",                           
                            "sNext": "Suivant"
                        }

                    }
                }
        );
    }
    appliqueDataTable();

    function augmenterDate(chainedate, nbjour)
    {
        // Date plus plus quelques jours
        var split_date = chainedate.split('/');
        // Les mois vont de 0 a 11 donc on enleve 1, cast avec *1
        var an = split_date[2];
        var mois = split_date[1] * 1 - 1;
        var jour = split_date[0] * 1 + parseInt(nbjour);
        var nouvdate = new Date(an, mois, jour);
        var nouvjour = nouvdate.getDate();
        nouvjour = ((nouvjour < 10) ? '0' : '') + nouvjour; // ajoute un zéro devant pour la forme  
        var nouvmois = nouvdate.getMonth() + 1;
        nouvmois = ((nouvmois < 10) ? '0' : '') + nouvmois; // ajoute un zéro devant pour la forme  
        var nouvan = nouvdate.getYear();
        nouvan = ((nouvan < 200) ? 1900 : 0) + nouvan; // necessaire car IE et FF retourne pas la meme chose  
        var nouvdate_text = nouvjour + '/' + nouvmois + '/' + nouvan;
//   alert(chainedate + ' + ' + nbjour + ' = ' + nouvdate_text);
        return nouvdate_text;
    }
    function appliqueChosen() {
//$(function(){           
            $(".m-chosen").chosen({
                //disable_search:true,
                no_results_text:"Aucun Resultat Pour "
               
            });
//    });
    }
    appliqueChosen();
    

    $("#mySel").selectpicker({
    
  });
  
  $("#mySel2").selectpicker({
    multiple:true
  });

var lastValue="";
$('.dropdown-menu li a').on('click',function(){
  var currentValue = "";
  currentValue = $(this).children('span').html()
  alert('optionClick')
  if(lastValue === currentValue) {
  	alert('value not changed')
  }
  else {
   alert("value changed")
  }
  lastValue = currentValue;
  currentValue = "";   
  
})
    
//    xx
    
</script>


<script type="text/javascript">
//  $(document).ready(function() {
      function appliquemultiselect() {
    $('.multiselect').multiselect({
      buttonClass: 'btn',
      buttonWidth: 'auto',
      buttonContainer: '<div class="btn-group" />',
      maxHeight: false,
      buttonText: function(options) {
        if (options.length == 0) {
          return 'Aucune sélection <b class="caret"></b>';
        }
        else if (options.length > 3) {
          return options.length + ' sélectionnés  <b class="caret"></b>';
        }
        else {
          var selected = '';
          options.each(function() {
            selected += $(this).text() + ', ';
          });
          return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
        }
      }
    });}

appliquemultiselect();
//  });
</script>

<script type="text/javascript">
    $(function() {
        $('.display1').dataTable(
                {
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": true,
                    'bJQueryUI': true
                }
        );
            
              
                
        $("#frmrelup").ajaxForm({
            
            type : 'POST',
            data : { idr: $("#idrelm").val() },
            
            beforeSubmit: function(){ 
               
                 $('.ui-corner-all').removeClass("ui-state-error");  
                 
                 return JReleve.checkcombo($("#idrelm")) && 
                         JReleve.checkinput($("#relfile"),"le fichier des relevés ");
           },

           beforeSend: function(){
               $("#m-info").html("Traitement en cours ... ");
           },
           success: function(){                    

           },
           complete: function(response){
               //$("#info").html("<font color='green'>"+response.responseText+"</font>"); 
               
               if(response.responseText == "done"){
                   //JPrincipal.afficheContenu(0, 'releveMensuel', '', '');
                   //alert("what the fuck !!");
                   JPrincipal.afficheContenu(0, 'releveMensuel', '', 'Accueil');
               }
               else{
                   $("#m-info").html("<font color='green'>"+response.responseText+"</font>");  
               }
               //JPrincipal.afficheContenu(0, 'releveMensuel', '', '');
           },
           error: function(){
               $("#m-info").html("<font color='red'> Impossible de charger le fichier </font>");
           }
        });
            

    });
</script>

<script type="text/javascript">
    $(function() {
        $('.displayDetail').dataTable(
                {
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": false,
                    "bInfo": false,
                    "bAutoWidth": false,
                    'bJQueryUI': true
                }
        );

    });
</script>

<script>
    $('.conteneur').tooltip({
        selector: "a[rel=tooltip]"
    });

    function horloge()
    {
        var tt = new Date().toLocaleTimeString(); // hh:mm:ss

        document.getElementById("timer").innerHTML = tt;
        setTimeout(horloge, 1000); // mise à jour du contenu "timer" toutes les secondes
    }
</script>

<script>
    // Application du datepicker
    $(function() {
        var dates1 = $("#datedebut, #datefin").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function(selectedDate) {
                var option = this.id == "datedebut" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker");
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
                dates1.not(this).datepicker("option", option, date);
            }
        });
        $("#datedebut, #datefin").datepicker($.datepicker.regional[ "fr" ]);
    });
</script>

<script>
    // Application du datepicker

    $("#datedebut").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#datefin").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#datefin").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#datedebut").datepicker("option", "maxDate", selectedDate);
        }
    });

    /*****************************************************/



    // Enleve le '0' des nb < 10
    function ConvNum(tabDeDate) {
        for (i = 0; i < tabDeDate.length; i++)
            tabDeDate[i] = (tabDeDate[i].charAt(0) == '0') ? tabDeDate[i].charAt(1) : tabDeDate[i];
        return tabDeDate;
    }

    //obtenir l'id du projet'
    function idprojet() {
        var idprojet = document.getElementById(idprojet).value;
        return idprojet;
    }

// Retourne true si valeur_date est postérieure à la date du jour
    function DateFuture(valeur_date)
    {
        var tabDate = valeur_date.split('/');
        var datAujourdhui = new Date();
        tabDate = ConvNum(tabDate);
        if (valeur_date.length > 0)
        {
            var datTest_Date = new Date(parseInt(tabDate[2]), parseInt(tabDate[1]) - 1, parseInt(tabDate[0]));
            if (datTest_Date <= datAujourdhui)
                return false;
        }
        return true;
    }

// Retourne 1 si valeur_date1 < valeur_date2
// 0 si valeur_date1 = valeur_date2
// -1 si valeur_date1 > valeur_date2
    function Compare_Dates(valeur_date1, valeur_date2)
    {
        var Chaine = valeur_date1;
        var tabDate1 = "";
        if (Chaine.indexOf('/') > 0)
            tabDate1 = valeur_date1.split('/');
        if (Chaine.indexOf('-') > 0)
            tabDate1 = valeur_date1.split('-');
        tabDate1 = ConvNum(tabDate1);
        var datTest_Date1 = new Date(parseInt(tabDate1[2]), parseInt(tabDate1[1]) - 1, parseInt(tabDate1[0]));

        var tabDate2 = "";
        Chaine = valeur_date2;
        if (Chaine.indexOf('/') > 0)
            tabDate2 = valeur_date2.split('/');
        if (Chaine.indexOf('-') > 0)
            tabDate2 = valeur_date2.split('-');
        tabDate2 = ConvNum(tabDate2);
        var datTest_Date2 = new Date(parseInt(tabDate2[2]), parseInt(tabDate2[1]) - 1, parseInt(tabDate2[0]));
        return (datTest_Date2 - datTest_Date1 === 0) ? "0" : (datTest_Date2 - datTest_Date1 < 0) ? "-1" : "1";
    }

// Vérifie le format d une date saisie
    function Verif_Date(idchamp)
    {
        var valeur_date = document.getElementById(idchamp).value;
        var Chaine = valeur_date;
        var tabDate = "";
        if (Chaine.indexOf('/') > 0)
            tabDate = valeur_date.split('/');
        if (Chaine.indexOf('-') > 0)
            tabDate = valeur_date.split('-');

        tabDate = ConvNum(tabDate);
        var datTest_Date = new Date(parseInt(tabDate[2]), parseInt(tabDate[1]) - 1, parseInt(tabDate[0]));
        if (valeur_date.length > 10)
        {
            alert('Ne dois pas dépasser 10 caractères.');
            document.getElementById(idchamp).value = '';
            return false;
        }
        for (i = 0; i < valeur_date.length; i++)
        {
            if (valeur_date.charAt(i) === ' ')
            {
                alert("La date ne doit pas contenir d\'espaces.");
                document.getElementById(idchamp).value = '';
                return false;
            }
        }
        if (valeur_date.length > 0)
        {
            if ((parseInt(tabDate[0]) !== datTest_Date.getDate()) || (parseInt(tabDate[1]) !== parseInt(datTest_Date.getMonth()) + 1))
            {
                alert("Date incorrecte");
                document.getElementById(idchamp).value = '';
                return false;
            }
            if ((tabDate[2].length !== 4) || (parseInt(tabDate[2]) < 1980) || (parseInt(tabDate[2]) > 2099))
            {
                alert("Veuillez saisir l'année sur 4 chiffres.\n\nElle doit être comprise entre 1980 et 2099.");
                document.getElementById(idchamp).value = '';
                return false;
            }
        }

        return true;
    }

    function ControleDates(iddebut, idfin) {
        if (Verif_Date(iddebut) && Verif_Date(idfin)) {
            if ((document.getElementById(iddebut).value !== '') && (document.getElementById(idfin).value !== '')) {
                switch (Compare_Dates(document.getElementById(iddebut).value, document.getElementById(idfin).value)) {
                    case "-1" :
                        alert('La date début ne peut être supérieure à celle de la fin');
                        document.getElementById(iddebut).value = '';
                        document.getElementById(idfin).value = '';
                        break;
                    case "0" :
//                        alert('KO:\nDate début = Date fin');
                        break;
                    case "1" :
//                        alert('OK:\nDate début < Date fin');
                        break;
                    default :
                        alert('Comparaison impossible');
                        break;
                }
            }
        }
    }



    /*****************************************************/

 function SommeMontantcas(i) {
        var chk = document.getElementById("chk" + i).value;
        var som = document.getElementById("Montant").value;
        if (document.getElementById("chk" + i).checked === true) {
            document.getElementById("Montant").value = Math.abs(chk) + Math.abs(som);
        } else if (document.getElementById("chk" + i).checked === false) {
            document.getElementById("Montant").value = Math.abs(som) - Math.abs(chk);
        }
    }
    function SommeMontantcasTotal() {
        var nbre = document.getElementById("nbreparam").value;
        //alert (nbre);
        var  tab = new  Array();
        document.getElementById("Montant").value = 0;
        for (var i = 1; i <= nbre; i++)
        {
            var chk = document.getElementById("chk" + i).value;
            var som = document.getElementById("Montant").value;
            if (document.getElementById("chk" + i).checked === true) {
                
                document.getElementById("Montant").value = Math.abs(chk) + Math.abs(som);
                tab[i]= document.getElementById("chk" + i).value; 
            } 
            else if (document.getElementById("chk" + i).checked === false) {
                document.getElementById("Montant").value = 0;
            }
            
        }
         alert(tab.join(""));
    }

    $(function() {
        var dates1 = $("#debut, #fin").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function(selectedDate) {
                var option = this.id == "debut" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker");
                date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings);
                dates1.not(this).datepicker("option", option, date);
            }
        });
        $("#debut, #fin").datepicker($.datepicker.regional[ "fr" ]);
    });




    $("#dategama").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#dategama").datepicker("option", "minDate", selectedDate);
        }
    });
// Application de datepicker à l'id datedenaissance
    $("#datedenaissance").datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        onClose: function(selectedDate) {
            $("#datedenaissance").datepicker("option", selectedDate);
        }
    });

    function appliqueDatePicker() { //alert('Merci');
        // Application de datepicker à la classe
        $(".date").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onClose: function(selectedDate) {
                $(".date").datepicker("option", "minDate", selectedDate);
            }
        });

    }
    appliqueDatePicker();
</script>

<script type="text/javascript" src="library/bootstrap/datepicker/bootstrap-datepicker.js"></script>
<script>
    $(document).ready(function() {
//        $("#idstructure").select2();
//        $("#idutilisateur").select2();
//        $("#idpatient").select2();
//        $("#idcategorie").select2();
//        $("#idtypepalu").select2();

        $('.selectpicker').selectpicker();

    });

//    function appliqueSelect() {
//        $(document).ready(function() {
//            $("#idstructure").select2();
//            $("#idutilisateur").select2();
//            $("#idpatient").select2();
//            $("#idcategorie").select2();
//            $("#idtypepalu").select2();
//            $('.selectpicker').selectpicker();
//
//        });
//    }
</script>

<script type="text/javascript">
    var rose = '';
    if (document.getElementById('formaddCotation'))
    {
        rose = ' fournisseurs';
        //alert('Merci Seigneur')
    }
    if (document.getElementById('formaddUtilisateur'))
        rose = ' fonctions';
    function selectCombo(rose) {
        $(document).ready(function() {
            $('.multiselect').multiselect({
                maxHeight: 200,
                enableFiltering: true,
                buttonClass: 'btn',
                buttonWidth: 'auto',
                buttonContainer: '<div class="btn-group" />',
                filterPlaceholder: 'Rechercher',
                buttonText: function(options) {
                    if (options.length == 0) {
                        return 'Choix des' + rose + ' <b class="caret"></b>';
                    }
                    else if (options.length > 2) {
                        return options.length + rose + ' sélectionnées <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            selected += $(this).text() + ', ';
                        });
                        return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
                    }
                }
            });
        });
    }
    selectCombo(rose);

    $('.dropdown-toggle').dropdown();

    
</script>

<script>
    // Full list of configuration options available here:
    // https://github.com/hakimel/reveal.js#configuration
    Reveal.initialize({
        controls: true,
        progress: true,
        history: true,
        center: true,
        // rtl: true,

        transition: 'linear'
                // transitionSpeed: 'slow',
                // backgroundTransition: 'linear'
    });

    

    function tabloindicateurplusd() { //alert('Merci Seigneur <?php echo $_SESSION['idIndic']; ?>') ;
        var nbre = document.getElementById('tailleTablo').value; //alert(nbre + ' Merci');
        nbre++;
        document.getElementById('tailleTablo').value = nbre;
        var ind = document.getElementById('indice').value;
        //ind += 2;
<?php
//$_SESSION['idIndic'] ++;
if (isset($_SESSION['idIndic']))
    $Idindic = "idIndic" . $_SESSION['idIndic']; //echo 'm'.$_SESSION['idIndic'];
?>
//        $('.ui-corner-all').removeClass("ui-state-error");$_SESSION['idIndic'] = 'idIndic2';
        document.getElementById('tabloindicateur');

        //Ajout d'une ligne au tableau (en fin de tableau)
        var newRow = document.getElementById('tabloindicateur').insertRow(-1);
        //Insertion de cellules
        var chpId = "idIndic" + nbre;
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = nbre;
        newCell.align = "center";
        var newCell = newRow.insertCell(1);

        newCell.innerHTML = "<input type='hidden' style='height:0px; width:0px;' name='idindicperf" + nbre + "' id='idindicperf" + nbre + "' class='text ui-widget-content ui-corner-all'  value='0' /> <?php
echo $Idindic . ' ' . $_GET['ind'];
echo Functions::LoadCombo_Table("indicateur", "id", "libelle", $Idindic, "Sélectionnez l'indicateur", "170", "", 0);
?>";
        newCell.align = "center";
        var newCell = newRow.insertCell(2);
        newCell.innerHTML = " <textarea onkeyup='enMajuscule('libindic', 1);' rows='1' style= 'width:150px;' name='libindic'  id='libindic' placeholder='Saisir l\'indicateur' ></textarea>";
        newCell.align = "center";
        var newCell = newRow.insertCell(3);
        newCell.innerHTML = '<input type="checkbox" style="height:30px; width:50px;" name="check' + nbre + '" id="check' + nbre + '" class="text ui-widget-content ui-corner-all" value="" />';

    }




</script>

<script>
    function activer() {
        document.formaddactivite.daterappel.disabled = false;
    }
</script>   
<script>
//    function SommeMontantcas(i) { alert(i);
//        var chk = document.getElementById("chk" + i).value;
//        var som = document.getElementById("Montant").value;
//        if (document.getElementById("chk" + i).checked === true) {
//            document.getElementById("Montant").value = Math.abs(chk) + Math.abs(som);
//        } else if (document.getElementById("chk" + i).checked === false) {
//            document.getElementById("Montant").value = Math.abs(som) - Math.abs(chk);
//        }
//    }
//    function SommeMontantcasTotal() {
//        var nbre = document.getElementById("nbreparam").value;
//       // alert (nbre);
//        for (var i = 1; i <= nbre; i++)
//        {
//            var chk = document.getElementById("chk" + i).value;
//            var som = document.getElementById("Montant").value;
//            if (document.getElementById("chk" + i).checked === true) {
//                document.getElementById("Montant").value = Math.abs(chk) + Math.abs(som);
//            } else if (document.getElementById("chk" + i).checked === false) {
//                document.getElementById("Montant").value = 0;
//            }
//        }
//
//    }
</script>
<script>
    function Controleentier(idexercice) {
        if (document.getElementById(idexercice).value !== '') {
            var exercice = document.getElementById(idexercice).value;
            var filter = /^[0-9]{5}$/;
            if (filter.test(exercice)) {
                alert('L\'exercice est un entier');
                document.getElementById(idexercice).value = "";
            }
        }
    }
</script>     

