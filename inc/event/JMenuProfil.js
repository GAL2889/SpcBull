/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JMenuProfil = {
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
    formAddMenuProfil: function(id) { //alert(id);
        $.get(JMenuProfil.urlajax, {
            action: 'getFormAddMenuProfil',
            id: id
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    ajoutMenuProfil: function(id) { //alert(id);
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JMenuProfil.urlajax, {
                action: 'addMenu',
                id: id//id=menu,idprofil
            }, function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    ajoutDesMenuProfil: function(id) { //alert(id); 
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
            $.get(JMenuProfil.urlajax, {
                action: 'addMenuMulti',
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
    supprimerDesMenuProfil: function(id) { //alert(id); 
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
            $.get(JMenuProfil.urlajax, {
                action: 'supprimerDesMenuProfil',
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
        $.get(JMenuProfil.urlajax, {
            action: 'getFormDetailsMenu',
            id: id //idprofil
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    suppMenuProfil: function(id, idprofil) {
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
                    $.get(JMenuProfil.urlajax, {
                        action: 'suppression',
                        conf: 'suppMenuProfil',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JMenuProfil.updateTips("<div style=height:30px;>Erreur de connexion</div>");
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
        $.get(JMenuProfil.urlajax, {
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


