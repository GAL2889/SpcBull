/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JUserProfil = {
    urlajax: 'ajax/ajaxIncludeForm.php',
    cocherTout: function() {
        var nb = $("#nbreparam").val();
        for (var i = 1; i <= nb; i++)
        {
            if (document.getElementById("chk" + i) !== null) {
                document.getElementById("chk" + i).checked = true;
            }
        }
    },
    decocherTout: function() {
        var nb = $("#nbreparam").val();
        for (var i = 1; i <= nb; i++)
        {
            if (document.getElementById("chk" + i) !== null) {
                document.getElementById("chk" + i).checked = false;
            }
        }
},
    suppUserProfil: function(id,idprofil) {         //alert("aman !!!");
        $("#zonesuppr").dialog({
            title: "Suppression de profil pour l'utilisateur",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JUserProfil.urlajax, {
                        action: 'suppression',
                        conf: 'suppUserProfil',
                        id: id
                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");

                        switch (data) {
                            case '0':
                                $("#zonesuppr").dialog("close");
                                JUserProfil.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du profil de l\'utilisateur effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(idprofil, 'listeuserProfil', '', '');
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
    ajoutUserProfil: function(id) { //alert("aman !!!");
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) {
            $.get(JUserProfil.urlajax, {
                action: 'addUserProfil',
                id: id//id=idutilisateur,idprofil
            }, function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    monAlert: function() { //alert("aman !!!");
        alert("voici le refreesh !!!");
    },
    refreshTableSite: function() {//alert("voici le refreesh !!!");
//        $.ajaxSetup({
//            async: false
//        });
        /// document.getElementById("loading").style.visibility = "visible";
        $.get(JUserProfil.urlajax, {
            action: 'getAllUserProfil'
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
        if (o.val().length === 0) {
            o.addClass("ui-state-error");
            JUserProfil.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
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



