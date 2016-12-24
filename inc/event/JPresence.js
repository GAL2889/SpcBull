/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var JPresence = {
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
    validerPresence: function(id,conf,retour) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JPresence.checkinput($("#datejour"));
        bValid = bValid && JPresence.checkcombo($("#idpersonne"));
//        bValid = bValid && JPresence.checkinput($("#heurearrive"));
//        bValid = bValid && JPresence.checkinput($("#heuredep"));

        if (bValid) {
            $.get(JPresence.urlajax, {
                action: 'validerPresence',
                id: id,
                conf: conf,
                retour: retour,
                idpersonne: $("#idpersonne").val(),
                datejour: $("#datejour").val(),
                heurearrive: $("#heurearrive").val(),
                heuredepart: $("#heuredep").val(),
                motif: $("#motif").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    masqueSaisieHeure: function(heure) {
//        var exp = new RegExp("^[a-zA-z]{2}[0-9]{3}[a-zA-z]{1}[0-9]{2}$", "gi");
//        var exp = new RegExp("^[0-9]{2}[hH]{1}[0-9]{2}$", "gi");
        var exp = new RegExp("^[0-9]{2}[:]{1}[0-9]{2}[:]{1}[0-9]{2}$", "gi");
        if (heure.match(exp)) {
            alert("OK");
            return true;
        } else {
            alert("NO");
            return false;
        }
    },
    suppPresence: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPresence.urlajax, {
                        action: 'suppression',
                        conf: 'supppresence',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPresence.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'presence', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette enregistrement\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    cloturerPresence: function(datejour) {
        $("#zonecloturepresence").dialog({
            title: "Clôturer la présence du "+ datejour,
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPresence.urlajax, {
                        action: 'cloturerPresence',
                        datejour: datejour
                    }, function(data) { //alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPresence.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                $("#zonecloturepresence").dialog("close");
                                break;
                            case '1':
                                $("#zonecloturepresence").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Présence clôturée avec succès !.</div>').fadeIn(300).fadeOut(2000);
                                JPrincipal.afficheContenu(0, 'presence', '', '');
                                break;
                            case '2':
                                $("#zonecloturepresence").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette enregistrement\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    saisirHeureDepart: function(datejour) {
        $("#zoneHeureDep").dialog({
            title: "Renseigner l\'heure de départ",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    var bValid = true;
                    $('.ui-corner-all').removeClass("ui-state-error");
                     bValid = bValid && JPresence.checkinput($("#heuredepart"));
                    if (bValid) {
                        $.get(JPresence.urlajax, {
                            action: 'updateHeureDep',
                            datejour: datejour,
                            heuredepart: $("#heuredepart").val()
                        }, function(data) {
                            data = data.replace(/\s/g, "");
                            switch (data) {
                                case '0':
                                    JPresence.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                    break;
                                case '1':
                                    $("#zoneHeureDep").dialog("close");
                                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>L\'heure de départ a été renseignée avec succès !.</div>').fadeIn(300);
                                    JPrincipal.afficheContenu(0, 'presence', '', '');
                                    break;
                            }
                        });
                    }
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    },
      validerFichePresence: function(datejour) {
        $("#zoneValide").dialog({
            title: "Validation fiche de présence",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPresence.urlajax, {
                        action: 'validerFiche',
                        conf: 'validPresence',
                        datejour: datejour
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPresence.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneValide").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>La fiche de présence a été validée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'validPresence', '', '');
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
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JPresence.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JPresence.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JPresence.updateTips(n);
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