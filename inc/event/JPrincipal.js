var JPrincipal = {
    urlajax: 'ajax/ajaxIncludeForm.php',
    afficheMenu: function(ancre, rang) { //alert(ancre);
        $.get(JPrincipal.urlajax, {
            action: 'afficheMenu',
            rang: rang,
            ancre: ancre

        }, function(data) {
            $("#accordion2").html(data);
        }
        );
    },
    afficheOnglet: function(onglet, id) { //alert(ancre);
        $.get(JPrincipal.urlajax, {
            action: 'afficheOnglet',
            id: id,
            onglet: onglet

        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    majcoches: function(champ,listechamp) {
        var list = listechamp.split('|');
        var n = list.length; 
            if ((document.getElementById(champ).checked === true)) {
for (var i = 0; i < n; i++) { 
document.getElementById(list[i]).checked = false ;
        }
            }
        
    },
    enMajuscule: function(idchamp, nbCar) {
        var m = document.getElementById(idchamp).value;
        //var t= parseInt(m.length);

        if (parseInt(nbCar) > 0) {
            if (parseInt(m.length) <= parseInt(nbCar))
                document.getElementById(idchamp).value = document.getElementById(idchamp).value.toUpperCase();
        } else {
            document.getElementById(idchamp).value = document.getElementById(idchamp).value.toUpperCase();
        }

    },
            
    estNumerique: function(idchamp) { //alert(document.getElementById(idchamp).value)
        if (document.getElementById(idchamp).value !== '') { 
            var nbr = document.getElementById(idchamp).value;// alert(nbr)
            var filter = /^[0-9\ ]+$/;
            if (filter.test(nbr)) {
                return 1;
            }else{
                alert('La valeur saisie  n\'est pas numérique');   
                document.getElementById(idchamp).value = '';
                return 0;
            }
        }
        return 0;
    },
    totalscp: function() { //alert(JPrincipal.estNumerique('droitfixe'))
        var remb = (JPrincipal.estNumerique('montantremboursement')===1)? (parseInt(document.getElementById("montantremboursement").value)):0;  
        var droif = (JPrincipal.estNumerique('droitfixe')===1)? (parseInt(document.getElementById("droitfixe").value)):0;
        var taxet = (JPrincipal.estNumerique('taxetransportinterieur')===1)? (parseInt(document.getElementById("taxetransportinterieur").value)):0;
        var droitd = (JPrincipal.estNumerique('droitdouane')===1)? (parseInt(document.getElementById("droitdouane").value)):0;
        var monta = (JPrincipal.estNumerique('montantavis')===1)? (parseInt(document.getElementById("montantavis").value)):0;
        var tot = remb + droif + taxet + droitd + monta; 
        
        document.getElementById("montanttotal").value = tot;
    },
    selectionSousMenu: function(ancre) {
        JPrincipal.afficheMenu(ancre, 1);
    },
    afficheContenu: function(id, conf, listparam, retour) { //alert(id);
        $.get(JPrincipal.urlajax, {
            action: 'afficheContenu',
            id: id,
            listparam: listparam,
            retour: retour,
            conf: conf

        }, function(data) { //alert(data)
            $("#zoneListeSite").html(data);
            appliqueChosen();
            appliqueDataTable();

        }
        );
    },
    cocherTout: function() {
        var nb = $("#nbreparam").val();
        for (var i = 1; i <= nb; i++)
        {
            if (document.getElementById("chk" + i) != null) {
                document.getElementById("chk" + i).checked = true;
            }
        }
    },
    decocherTout: function() {
        var nb = $("#nbreparam").val();
        for (var i = 1; i <= nb; i++)
        {
            if (document.getElementById("chk" + i) != null) {
                document.getElementById("chk" + i).checked = false;
            }
        }
    },
    refreshTableSite: function() {
        $.ajaxSetup({
            async: false
        });
        document.getElementById("loading").style.visibility = "visible";
        $.get(JPrincipal.urlajax, {
            action: 'getAllValidation'
        }, function(data) {
            $("#zoneListeSite").html(data);
            $('.display').dataTable(
                    {
                        'bJQueryUI': true,
                        'sPaginationType': 'full_numbers',
                        "oLanguage": {
                            "sLengthMenu": "Recherche _MENU_ Enregistrements par page",
                            "aLengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
                            "sZeroRecords": "Aucun Enregistrement...!",
                            "sInfo": "",
                            "sInfoEmpty": "",
                            "sInfoFiltered": "",
                            "sSearch": "Rechercher:",
                            "oPaginate": {
                                "sFirst": "Premier",
                                "sLast": "Dernier",
                                "sPrevious": "Précedent",
                                "sNext": "Suivant"
                            }
                        }
                    }
            );
        });
        document.getElementById("loading").style.visibility = "hidden";
        $.ajaxSetup({
            async: true
        });
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JPrincipal.updateTips("<div class='alert'>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JPrincipal.updateTips("<div class='alert'>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JPrincipal.updateTips("<div class='alert'>" + n + "</div>");
            return false;
        } else {
            return true;
        }
    },
    updateTips: function(t) {
        $(".validateTips").html(t);
    },
    effacer: function() {
        $(".validateTips").html('').removeClass("ui-state-highlight");
        $('.ui-corner-all').removeClass("ui-state-error");
        $('.ui-corner-all').val("");
        $('input').removeClass("ui-state-error");
    },
    chargeCombo: function(idcombo, onchange, choixdefaut, largeur, donnee,idencour) { //alert('merci'+ idcombo);
        //"<select class='m-chosen  span4' id='" . $idcombo . "' onchange=" . $onchange . " style='height: 30px; width: " . $largeur . "px;' >";
        var combo = "<select class='m-chosen span4' id ='" + idcombo + "' name ='" + idcombo + "' style='height: 30px; width: " + largeur + "px;' onchange='" + onchange + "' >";
        combo += "<option value='0'>--" + choixdefaut + "--</option>";
        t = donnee.length; 
        t--;
        var dep = '';
        for (i = 0; i <= t; i++) { //alert('merci'+donnee[i]);
            var v = donnee[i].split('|');// alert('merci'+v[1]);
            if(v[0]===idencour) { dep = 'selected=selected'; }else dep = '';
           if(donnee[i]!=='') combo += "<option "+dep+" value='" + v[0] + "'>" + v[1] + "</option>";
        }
        combo += "</select>";
        return combo;
    },
    appliqueChosen: function() {
        $(function() {
            $(".m-chosen").chosen({
                //disable_search:true,
                no_results_text: "Aucun Resultat Pour "
                        //placeholder_text_multiple:"Choisir un Profil"
            });
        });

    },
    appliqueDataTable: function() {
        $('.display').dataTable(
                {
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

    },
            
    onChangeTxtDatePeriode: function(conf) { //alert(idconf)

        $.get(JPrincipal.urlajax, {
            action: "onChangeTxtDatePeriode",
            conf: conf,
            debut: $("#debut").val(),
            fin: $("#fin").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            JPrincipal.appliqueDataTable();
//            appliqueDateDebuFinPicker();
        }
        );
    },
    formatNombre: function(idchamp) { //alert('Merci ' + idchamp)
        var d = $('#'+idchamp).val();
        d = d.replace(/\s/g, "");
        d = parseFloat(d);
        $.get(JPrincipal.urlajax, {
            action: "formatNombre",
            valchamp: d,
            idchamp: idchamp          

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);
//            JPrincipal.appliqueDataTable();
//            appliqueDateDebuFinPicker();
        }
        );
    },
    
    onChangecmbTypePeriode: function(idconf) {
        var conf = "";
        switch (idconf) {
            case 1:
                conf = 'rapportfinancier';
                break;


        }
        $.get(JPrincipal.urlajax, {
            action: "onChangecmbTypePeriode",
            conf: conf,
            idtypeperiode: $("#idtypeperiodecritere").val()


        }, function(data) { //alert(data);
            $("#zoneadd").html(data);
//            JPrincipal.appliqueDataTable();
         appliqueChosen();
//            appliqueDateDebuFinPicker();
        }
        );
    },
    
    afficheRapport: function(conf) {
        $.get(JPrincipal.urlajax, {
            action: "afficheRapport",
            conf: conf,
            idmois: $("#idmois").val(),
            idannee: $("#idannee").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            JPrincipal.appliqueDataTable();
//            appliqueDateDebuFinPicker();
        }
        );
    },
    
    validerCritere: function(conf) {//alert(conf+' Merci')
        var idtypeperiode = $("#idtypeperiodecritere").val();
        var idmois = 0;
        var idannee = 0;
        var debut = "";
        var fin = "";
        if ($("#idmoiscritere").val() !== undefined)
            idmois = $("#idmoiscritere").val();
        if ($("#idanneecritere").val() !== undefined)
            idannee = $("#idanneecritere").val();
        if ($("#debutcritere").val() !== undefined)
            debut = $("#debutcritere").val();
        if ($("#fincritere").val() !== undefined)
            fin = $("#fincritere").val();
        $.get(JPrincipal.urlajax, {
            action: "validercritereselection",
            conf: conf,
            idtypeperiode: idtypeperiode,
            idmois: idmois,
            idannee: idannee,
            debut: debut,
            fin: fin

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            JPrincipal.appliqueDataTable();
        }
        );
    },
    
    ajoutFormModal: function(conf, retour,width,title,id) { //alert(conf)
       // if(width ==='') width = 700;
        $.get(JPrincipal.urlajax, {
            action: 'ajoutFormModal',
            id: id,
            retour: retour,
            conf: conf
        }
        , function(data) {
            $("#zonemodal").html(data);
            appliqueChosen();

        });
        $("#zonemodal").dialog({
            autoOpen: true,
            title: title,
            height: "auto",
            width: width,
            modal: true,
            show: "blind",
            position: "center",
            hide: "explode",
            resizable: "false"
        });
    },
    
    tabloplus: function(lescombo, idtablo, idtailletablo, lesidcombo, onchange, choixdefaut) { //alert('Merci '+lescombo)
       var tabcombo = lescombo.split('$$'); 
       var tabidcombo = lesidcombo.split('|');
       var idcombo = tabidcombo[0];
     
       var donneeCombo = tabcombo[0].split('-->'); 
     if(tabcombo.length > 1)  var donneeCombo1 = tabcombo[1].split('-->');

        var nbre = parseInt(document.getElementById(idtailletablo).value);
        nbre++; 
        document.getElementById(idtailletablo).value = nbre;
        //Ajout d'une ligne au tableau (en fin de tableau)
        var newRow = document.getElementById(idtablo).insertRow(-1);
        idcombo +=  nbre;
        var largeur = 270;
        var donnee = donneeCombo;
        if(tabidcombo.length > 1) var idcombo1 = tabidcombo[1] + nbre;
        var combo = "";

        //Insertion de cellules
        switch (idtablo) {
//onkeyup="JPrincipal.formatNombre('montant<?php echo $taille; ?>');"
            case 'tablodetailsOp':
                largeur = 200;
                combo = JPrincipal.chargeCombo(idcombo, onchange, choixdefaut, largeur, donnee);
                var newCell = newRow.insertCell(0);
                newCell.innerHTML = nbre;
                var newCell = newRow.insertCell(1);
                var champ = "montant" + nbre ; //alert(champ);
                newCell.align = "center";
                newCell.innerHTML = "<input type='hidden' style='height:0px; width:0px;' name='idop" + nbre + "' id='idop" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> " + combo;
                var newCell = newRow.insertCell(2); // 
                newCell.innerHTML = "<input type='text' style='height:30px; width:100px;' onkeyup='JPrincipal.formatNombre(" + champ + ");'  name='montant" + nbre + "' id='montant" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> ";
                var newCell = newRow.insertCell(3); // 
                newCell.innerHTML = "<label class='checkbox' title='Cocher si TTC'> TTC <input type='checkbox' value='0' name='ttc" + nbre + "' id='ttc" + nbre + "' />  </label> ";
                newCell = newRow.insertCell(4);
                //newCell.innerHTML = "<input type='button' onclick='JPrincipal.DeleteRows(this);' class='btn btn-small btn-danger' value='-'/>";

                break;
                
            case 'tablodetailsCP':
               //alert(idcombo1)
                var combobanq = JPrincipal.chargeCombo(idcombo, onchange, choixdefaut, 160, donnee);
                var comboclient = JPrincipal.chargeCombo(idcombo1, onchange, choixdefaut, 180, donneeCombo1);
                var newCell = newRow.insertCell(0);
                newCell.innerHTML = "<input type='text' style='height:30px; width:170px;'   name='numcheque" + nbre + "' id='numcheque" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> ";
                var newCell = newRow.insertCell(1);
                var champ = "montantcheque" + nbre ; 
                newCell.align = "center";
                newCell.innerHTML = "<input type='hidden' style='height:0px; width:0px;' name='idcheqop" + nbre + "' id='idcheqop" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> " + combobanq;
                var newCell = newRow.insertCell(2); // 
                newCell.innerHTML = comboclient;
                var newCell = newRow.insertCell(3); // 
                newCell.innerHTML = "<input type='text' style='height:30px; width:100px;' onkeyup='JPrincipal.formatNombre(" + champ + ");'  name='montantcheque" + nbre + "' id='montantcheque" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> ";
                newCell = newRow.insertCell(4);
//                newCell.innerHTML = "<input type='button' onclick='JPrincipal.DeleteRows(this);' class='btn btn-small btn-danger' value='-'/>";

                break;
        }
        appliqueChosen();
        //JPrincipal.RefreshIndex(document.getElementById(idtablo));
    },
 
 RefreshIndex: function(_tab) {

        for (var k = 1; k < _tab.rows.length; k++){ //alert(_tab.rows[k].cells[0].innerHTML);
            _tab.rows[k].cells[0].innerHTML = k;
        }
       appliqueChosen();
    },
  
  DeleteRows: function(r) {

        var i = r.parentNode.parentNode.rowIndex;
        var tab = r.parentNode.parentNode.parentNode.parentNode;
        tab.deleteRow(i);
        JPrincipal.RefreshIndex(tab);

    },
             onchangeCmbTypeUnite: function(conf) { //alert(conf)
        $.get(JPrincipal.urlajax, {
            action: "onchangeCmbTypeUnite",
            conf: conf,
            idtypeunite: $("#idtypeunite").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
             onchangeCmbTypeFamille: function(conf) { //alert(conf)
        $.get(JPrincipal.urlajax, {
            action: "onchangeCmbTypeFamille",
            conf: conf,
            idtypefamille: $("#idtypefamille").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            JPrincipal.appliqueDataTable();
            appliqueChosen();
        }
        );
    },
         
 verifdt: function (d){

var datej= new Date()
var anneej=datej.getFullYear()+"*";
anneej=anneej.substring(0,2)

if (d.length ==6) 
d=d.substring(0,2)+"/"+d.substring(4,2)+"/"+anneej+d.substring(6,4);

if (d.length ==8) 
d=d.substring(0,2)+"/"+d.substring(4,2)+"/"+d.substring(8,4);


if(!JPrincipal.isValidDate(d)){
alert("la date n'est pas valide ou n'est pas au bon format.\n format : jjmmaa ou jjmmaaaa ou jj/mm/aaaa");
 return false;
}else{
     return true;
//alert('Date correcte')
 }
	},

isValidDate:function (d) {
var dateRegEx = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;
return d.match(dateRegEx);
	} 


};