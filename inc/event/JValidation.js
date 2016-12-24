var JValidation = {
    urlajax: 'ajax/ajaxIncludeForm.php',
    afficheMenu: function(ancre) { //alert(conf)
        $.get(JValidation.urlajax, {
            action: 'afficheMenu',         
            ancre: ancre

        }, function(data) {
            $("#accordion2").html(data);
        }
        );
    },
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
    validerDemandeValidation: function(iddemandevalidation, idelement, element, info, iddemandeur) {//alert(info)
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        //bValid = bValid && JValidation.checkcombo($("#exercice"));

        if (bValid) { //alert('Merci');
            $.get(JValidation.urlajax, {
                action: 'validerDemandeValidation',
                iddemandevalidation: iddemandevalidation,
                element: element,
                info: info,
                idelement: idelement,
                iddemandeur: iddemandeur
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    enregistrerValidation: function() { //alert(id)
        $.get(JValidation.urlajax, {
            action: 'enregistrerValidation'

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);
        }
        );
    },
    editValidation: function(idstructure, id, etat) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JValidation.checkcombo($("#exercice"));

        if (bValid) { //alert('Merci');
            $.get(JValidation.urlajax, {
                action: 'editValidation',
                idstructure: idstructure,
                id: id,
                etat: etat,
                exercice: $("#exercice").val()

            }, function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppValidation: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression du budget",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JValidation.urlajax, {
                        action: 'suppValidation',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JValidation.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;

                            case '1':
                                $("#zonesuppr").dialog("close");
                                JValidation.refreshTableSite();
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du budget effectuée avec succès !.</div>').fadeIn(300);
                                break;
                            case '5':
                                $("#zonesuppr").dialog("close");
                                JValidation.refreshTableSite();
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins une prévision concernée par ce budget!\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
        $.ajaxSetup({
            async: false
        });
        document.getElementById("loading").style.visibility = "visible";
        $.get(JValidation.urlajax, {
            action: 'getAllValidation'
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
            JValidation.updateTips("<div class='alert'>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() === 0) {
            o.addClass("ui-state-error");
            JValidation.updateTips("<div class='alert'>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JValidation.updateTips("<div class='alert'>" + n + "</div>");
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
            
    demandeValidation: function(idelement, element, idacteur, iddestinataire, retour,config) { //alert(idelement);
        JValidation.effacer();//alert('Merci Seigneur')
        $.get(JValidation.urlajax, { 
            action: 'getFormAddValMemo',
            config:config
        }
        , function(data) {  
            $("#zoneNotification").html(data);
        });
        $("#zoneNotification").dialog({
            title: "Demande de validation de : " + element,
            resizable: false,
            height: 300,
            width: 500,
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() { //alert('Merci Seigneur')
                    $.get(JValidation.urlajax, {
                        action: 'demandevalidation',
                        idelement: idelement,
                        element: element,
                        iddestinataire: iddestinataire,
                        idacteur: idacteur,
                        config:config,
                        memo:$("#memo").val()

                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");

                        if (data === 0) { 
                            JValidation.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                        } else if (data === 1) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Demande de validation de : ' + element + ' envoyée avec succès !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data === 2) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>la demande de validation de : ' + element + ' que vous tentez d\'envoyer existe déjà !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data === 3) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Le budget de tous les collaborateurs de cette structure n\'ont pas été encore validés !.</div>').fadeIn(300);
                            document.location.href = retour;
                        }else if (data === 4) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Le budget de cette structure a été déja soumis !.</div>').fadeIn(300);
                            document.location.href = retour;
                        }

                    });
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    },
    
    annulerValidation: function(iddemandevalidation,idelement, element, idacteur, iddestinataire, retour,config) { //alert(idelement);
        JValidation.effacer();//alert('Merci Seigneur')
        $.get(JValidation.urlajax, { 
            action: 'getFormAddValMemo',
            config:config
        }
        , function(data) {  
            $("#zoneAnnulerdemandevalidation").html(data);
        });
        $("#zoneAnnulerdemandevalidation").dialog({
            title: "Annuler la demande de validation de : " + element,
            resizable: false,
            height: 300,
            width: 500,
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() { //alert('Merci Seigneur')
                    $.get(JValidation.urlajax, {
                        action: 'annulervalidation',
                        idelement: idelement,
                        element: element,
                        iddestinataire: iddestinataire,
                        idacteur: idacteur,
                        config:config,
                        iddemandevalidation:iddemandevalidation,
                        memo:$("#memo").val()

                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");

                        if (data === 0) { 
                            JValidation.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                        } else if (data === 1) {
                            $("#zoneAnnulerdemandevalidation").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Annulation de la demande de validation du : ' + element + ' envoyée avec succès !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data === 2) {
                            $("#zoneAnnulerdemandevalidation").dialog("close");
                            JValidation.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>  !.</div>').fadeIn(300);
                            document.location.href = retour;
                        }

                    });
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    },
   
    accepterRetour: function(iddemandevalidation) {//alert(info)
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (bValid) { //alert('Merci');
            $.get(JValidation.urlajax, {
                action: 'accepterRetour',
                iddemandevalidation: iddemandevalidation
            }
            , function(data) {//alert(data)
                $("#zoneListeSite").html(data);
            }
            );
        }
    }
};