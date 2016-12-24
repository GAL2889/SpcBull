/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JRubriqueAssocie = {
    urlajax: 'ajax/ajaxIncludeForm.php',
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
    formAddRubriqueAssocie: function(id) { //alert(id);
        $.get(JRubriqueAssocie.urlajax, {
            action: 'getFormAddRubriqueAssocie',
            id: id
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    ajoutRubriqueAssocie: function(id) { //alert(id);
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JRubriqueAssocie.urlajax, {
                action: 'addRub',
                id: id//id=menu,idprofil
            }, function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    ajoutDesRubriqueAssocie: function(id) { //alert(id); 
        var bValid = true;
        var t = $("#nbreparam").val();
        var tab = new Array();
        var b = 0;
        var j = 0;
        j = parseInt(j);
        b = parseInt(b);
        for (i = 1; i <= t; i++) {
            if($("#chk"+i).val()!== undefined) j++;
        }
        
        for (i = 1; i <= j; i++) { //alert(i)
            var m = document.getElementById('chk' + i).checked;
            var v = $("#chk" + i).val();
            if (m === true) {
                b++;
                tab.push(id + "|" + v);
            }
        }
        
        if(tab.length ===0)tab = "0|0";
       
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JRubriqueAssocie.urlajax, {
                action: 'addRubMulti',
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
    supprimerDesRubriqueAssocie: function(id) { //alert(id); 
        var bValid = true;
        var t = $("#nbreparam").val();
        var tab = new Array();
        var b = 0;
        var j = 0;
        j = parseInt(j);
        b = parseInt(b);
        for (i = 1; i <= t; i++) {
            if($("#chk"+i).val()!== undefined) j++;
        }        
        for (i = 1; i <= j; i++) { //alert(i)
            var m = document.getElementById('chk' + i).checked;
            var v = $("#chk" + i).val();
            if (m === true) {
                b++;
                tab.push(id + "|" + v);
            }
        }
        
        if(tab.length ===0)tab = "0|0";
       
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JRubriqueAssocie.urlajax, {
                action: 'supprimerDesRubriqueAssocie',
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
        $.get(JRubriqueAssocie.urlajax, {
            action: 'getFormDetailsMenu',
            id: id //idprofil
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    suppRubriqueAssocie: function(id) {
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
                    $.get(JRubriqueAssocie.urlajax, {
                        action: 'suppression',
                        conf: 'suppRubriqueAssocie',
                        id: id
                    }, function(data) { //alert(data)
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JRubriqueAssocie.updateTips("<div style=height:30px;>Erreur de connexion</div>");
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
        $.get(JRubriqueAssocie.urlajax, {
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
    }
};


