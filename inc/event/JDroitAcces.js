/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JDroitAcces = {
    urlajax: 'ajax/ajaxIncludeForm.php',
    cocherTout: function(chk) {
        var nb = $("#nbreparam").val();
        var ch = "";
        for (var i = 1; i <= nb; i++)
        {
            ch = chk+ i;
            if (document.getElementById(ch) !== null) {
                document.getElementById(ch).checked = true;
            }
        }
    },
            
    decocherTout: function(chk) {
        var nb = $("#nbreparam").val();
        var ch = "";
        for (var i = 1; i <= nb; i++)
        {
            ch = chk+ i;
            if (document.getElementById(ch) !== null) {
                document.getElementById(ch).checked = false;
            }
        }
    },
    formAddDroitAcces: function(id) { //alert(id);
        $.get(JDroitAcces.urlajax, {
            action: 'getFormAddDroitAcces',
            id: id
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    ajoutDroitAcces: function(id,i) { //alert(id);
        var lect = 0;
        var ecri = 0;
        if(document.getElementById('chkL'+i).checked === true)lect = 1;
        if(document.getElementById('chkE'+i).checked === true)ecri = 1; 
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JDroitAcces.urlajax, {
                action: 'addDroit',
                lect:lect,
                ecri:ecri,
                id: id//id=element,idelement,idprofil
            }, function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    ajoutDesDroitAcces: function(id,element,retour) { //alert(id); 
        var bValid = true;
        var t = $("#nbreparam").val(); 
        var tab = new Array();
        var b = 0;
        var j = 0;
        j = parseInt(j);
        b = parseInt(b);
        for (i = 1; i <= t; i++) { 
            if (($("#chkL" + i).val() !== undefined)||($("#chkE" + i).val() !== undefined)){ //(i + ' '+$("#chkL" + i).val())
                j++;}
        }
//alert(t)
        for (i = 1; i <= t; i++) { //alert(i)
            if (($("#chkL" + i).val() !== undefined)||($("#chkE" + i).val() !== undefined)){ //alert('M'+i)
            var l = 0;
            var e = 0;
            var mL = document.getElementById('chkL' + i).checked;
            var mE = document.getElementById('chkE' + i).checked;
            if(mL === true) l = 1;
            if(mE === true) e = 1; 
            var L = $("#chkL" + i).val();
           
//            if ((e === 1)||(l === 1)) {                
                tab.push(id + "|" + element + "|" + L + "|" + l+ "|" + e); //alert(l);
            }
        }

        if (tab.length === 0)
            tab = "0|0";

        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JDroitAcces.urlajax, {
                action: 'addDroitMulti',
                tab: tab,
                retour: retour,
                id: id//idprofil
            }, function(data) {  //alert('M'+tab+'N');
                //alert(data)
                $("#zoneadd").html(data);
            }
            );
        }
    },    
    
    supprimerDesDroitAcces: function(id) { //alert(id); 
        var bValid = true;
        var t = $("#nbreparam").val();
        var tab = new Array();
        var b = 0;
        var j = 0;
        j = parseInt(j);
        b = parseInt(b);
        for (i = 1; i <= t; i++) {
            if ($("#chk" + i).val() !== undefined)
                j++;
        }
        for (i = 1; i <= j; i++) { //alert(i)
            var m = document.getElementById('chk' + i).checked;
            var v = $("#chk" + i).val();
            if (m === true) {
                b++;
                tab.push(id + "|" + v);
            }
        }

        if (tab.length === 0)
            tab = "0|0";

        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JDroitAcces.urlajax, {
                action: 'supprimerDesDroitAcces',
                tab: tab,
//                taille: b,
                id: id//idprofil
            }, function(data) {  //alert('M'+tab+'N');
                //alert(data)
                $("#zoneadd").html(data);
            }
            );
        }
    },
    formDetailsMenu: function(id) {
        $.get(JDroitAcces.urlajax, {
            action: 'getFormDetailsMenu',
            id: id //idprofil
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    suppDroitAcces: function(id, idprofil) {
        $("#zonesuppr").dialog({
            title: "Suppression du menu attribué",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JDroitAcces.urlajax, {
                        action: 'suppression',
                        conf: 'suppDroitAcces',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JDroitAcces.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du menu effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(idprofil, 'listemenuP', '', '');
                                break;
                        }
                    });
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    },
    refreshTableSite: function() {
        $.get(JDroitAcces.urlajax, {
            action: 'getAllMenu'
        }, function(data) {
            $("#zoneListeSite").html(data);
            $('.display').dataTable(
                    {
                        'bJQueryUI': true,
                        'sPaginationType': 'full_numbers',
                        "oLanguage": {
                            "sLengthMenu": "Recherche _MENU_ Enregistrements par page",
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
            JMarque.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    updateTips: function(t) {
        $(".validateTips").html(t).addClass("ui-state-highlight");
    },
    effacer: function() {
        $(".validateTips").html('').removeClass("ui-state-highlight");
        $('.ui-corner-all').removeClass("ui-state-error");
        $('.ui-corner-all').val("");
        $('input').removeClass("ui-state-error");
    },
            
    onChangeCmbElement: function(idconf) {
        var libconf = '';
        switch (idconf) {
            case 1:
                libconf = 'adddroitacces';
                break;
            case 2:
                libconf = 'opentreeC';
                break;
            case 3:
                libconf = 'opsortieB';
                break;
            case 4:
                libconf = 'opsortieC';
                break;
            case 5:
                libconf = 'addopentreeB';
                break;
            case 6:
                libconf = 'addopentreeC';
                break;
            case 7:
                libconf = 'addopsortieB';
                break;
            case 8:
                libconf = 'addopsortieC';
                break;
            case 9:
                libconf = 'editopentreeB';
                break;
            case 10:
                libconf = 'editopentreeC';
                break;
            case 11:
                libconf = 'editopsortieB';
                break;
            case 12:
                libconf = 'editopsortieC';
                break;
            case 13:
                libconf = 'pointcaisse';
                break;
            case 14:
                libconf = 'pointbanque';
            case 15:
                libconf = 'detailsDroitProfil';
                break;
        } //alert(conf)
        $.get(JDroitAcces.urlajax, {
            action: "onChangeCmbElement",
            conf: libconf,
            element: $("#element").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
           appliqueDataTable();
            appliqueChosen();

        }
        );
    },
    
    actualiseTotalTresorerie: function() {        
        var t = $("#nbreparam").val(); //alert('Merci '+t)
        var tot = 0;
        var totE = 0;
        var totS = 0;
//        var lignes=document.getElementById('tablotresorerie').getElementsByTagName('tr'); 
        //totE
         for (i = 1; i < t; i++) { 
             
            var m = document.getElementById('chkT' + i).checked;            
            if (m === true) {
               totE += parseInt ((document.getElementById("totE"+i).innerHTML).replace(/\s/g, ""));
               totS += parseInt ((document.getElementById("totS"+i).innerHTML).replace(/\s/g, ""));
               tot += parseInt ((document.getElementById("tot"+i).innerHTML).replace(/\s/g, ""));
                
            }
        }
        document.getElementById("totE"+t).innerHTML = totE;
        document.getElementById("totS"+t).innerHTML = totS;
        document.getElementById("tot"+t).innerHTML = tot;
        
    }
    
};


