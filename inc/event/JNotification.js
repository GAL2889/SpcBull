/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JNotification = {
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
    actualiseNotification: function() {
        $.get(JNotification.urlajax, {
            action: 'actualiseNotification'
        }, function(data) {
            $("#notification").html(data);
        }
        );
    },
    formVoirDetailsNotif: function(id, conf,idexpediteur) {	//alert(id);
        $.get(JNotification.urlajax, {
            action: 'formVoirDetailsNotif',
            id: id,
            conf: conf,
            idexpediteur: idexpediteur
        }
        , function(data) { //alert(data) 
            $("#zoneadd").html(data);
        }
        );
    },
    formVoirMmElement: function(idelement,element, conf) { //alert(idelement);
        $.get(JNotification.urlajax, {
            action: 'formVoirMmElement',
            idelement: idelement,
            element: element,
            conf: conf
        }
        , function(data) { //alert(data) 
            $("#zoneadd").html(data);
        }
        );
    },
    formNotifier: function(idelement, element, idexpediteur, iddestinataire, retour, conf, titre, typenotification,idnotificationtraitee) {	//alert(idnotificationtraitee);
        //
        $.get(JNotification.urlajax, {
            action: 'getFormNotifier',
            idelement: idelement,
            element: element,
            idexpediteur: idexpediteur,
            iddestinataire: iddestinataire,
            retour: retour,
            conf: conf,
            typenotification: typenotification, //1: validation; 2: soumission; 3 : observation
            idnotificationtraitee:idnotificationtraitee,
            titre: titre
        }
        , function(data) { //alert(data)
            $("#zoneadd").html(data);
        }
        );

    },
    ajoutNotifier: function(idexpediteur, infosession, typenotification) {	
        var tableau = infosession.split('|');
        conf = tableau[4];
        idnotificationtraitee = tableau[6]; //alert(idnotificationtraitee);
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        if (typenotification === 3) {
            bValid = bValid && JNotification.checkcombo($("#memo"));
            if (bValid === false)
                alert('Vous devez renseigner lobservation');
        }

        if (bValid) {
            $.get(JNotification.urlajax, {
                action: 'ajoutNotifier',
                idnotificationtraitee: idnotificationtraitee,
                infosession: infosession,
                idexpediteur: idexpediteur,
                ampiliataire: $("#idampiliataire").val(),
                contenu: $("#memo").val(),
                typenotification: typenotification
            }
            , function(data) { //alert(data)
                $("#zoneadd").html(data);

            }
            );
        }
    },
    notifier: function(idelement, element, idacteur, iddestinataire, retour, config) { //alert(idelement);
        JNotification.effacer();//alert('Merci Seigneur')

        $.get(JNotification.urlajax, {
            action: 'getFormAddNotification',
            config: config
        }
        ,
                function(data) {
                    $("#zonemodal").html(data);
                });
        $(function() {

        });
        $("#zonemodal").dialog({
            title: "Demande de validation de : " + element,
            resizable: false,
            height: 350,
            width: 600,
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() { //alert('Merci Seigneur')
                    $.get(JNotification.urlajax, {
                        action: 'demandevalidation',
                        idelement: idelement,
                        element: element,
                        iddestinataire: iddestinataire,
                        idacteur: idacteur,
                        config: config,
                        memo: $("#memo").val()

                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");

                        if (data == 0) {
                            JNotification.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                        } else if (data == 1) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JNotification.refreshTableSite();
                            $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Demande de validation de : ' + element + ' envoyée avec succès !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data == 2) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JNotification.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>la demande de validation de : ' + element + ' que vous tentez d\'envoyer existe déjà !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data == 3) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JNotification.refreshTableSite();
                            $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Le budget de tous les collaborateurs de cette structure n\'ont pas été encore validés !.</div>').fadeIn(300);
                            document.location.href = retour;
                        } else if (data == 4) { //Message reourne 1 et demande de validation retourne 1
                            $("#zoneNotification").dialog("close");
                            JNotification.refreshTableSite();
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
    refreshTableSite: function() {
        $.ajaxSetup({
            async: false
        });
//        document.getElementById("loading").style.visibility = "visible";
        $.get(JNotification.urlajax, {
            action: 'getAllpmne'
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
            JNotification.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JNotification.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JStructure.updateTips(n);
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
    onchangeTxtLogin: function() { //alert(" lelogin");
        $.get(JNotification.urlajax, {
            action: 'onchangeTxtLogin',
            login: $("#login").val()
        }, function(data) {
            $("#log-cont").html(data);
            appliqueDataTable();

        }
        );

    },
    confirmation: function(titre, action, id, msg) {
        //alert(action)
        $("#zoneconfirmation").dialog({
            title: titre,
            resizable: false,
            height: 250,
            width: 450,
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JNotification.urlajax, {
                        action: action,
                        msg: msg,
                        id: id
                    }
                    , function(data) { //alert(data)

                        $("#zoneconfirmation").dialog("close");
                        $("#zoneadd").html(data);

                    }
                    );
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    }



};



/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


