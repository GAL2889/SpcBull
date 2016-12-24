/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JContrat = {
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
    validerContrat: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JContrat.checkcombo($("#idpersonne"));
        bValid = bValid && JContrat.checkinput($("#numcontrat"));
        bValid = bValid && JContrat.checkinput($("#datecontrat"));
        bValid = bValid && JContrat.checkRegexp($("#montantpropose"), /^([0-9])+$/, "Veuillez entrer un nombre. SVP!");
        bValid = bValid && JContrat.checkRegexp($("#montantretenu"), /^([0-9])+$/, "Veuillez entrer un nombre. SVP!");
        bValid = bValid && JContrat.checkinput($("#datedebut"));
        bValid = bValid && JContrat.checkinput($("#datefin"));

        if (bValid) {
            $.get(JContrat.urlajax, {
                action: 'validerContrat',
                id: id,
                idpersonne: $("#idpersonne").val(),
                numcontrat: $("#numcontrat").val(),
                datecontrat: $("#datecontrat").val(),
                montantpropose: $("#montantpropose").val(),
                montantretenu: $("#montantretenu").val(),
                datedebut: $("#datedebut").val(),
                datefin: $("#datefin").val(),
                datelivraison: $("#datelivraison").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    validerEcheancier: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JContrat.checkinput($("#idcontrat"));
        bValid = bValid && JContrat.checkinput($("#tache"));
        bValid = bValid && JContrat.checkinput($("#datepaiement"));
        bValid = bValid && JContrat.checkRegexp($("#montant"), /^([0-9])+$/, "Veuillez entrer un nombre. SVP!");

        if (bValid) {
            $.get(JContrat.urlajax, {
                action: 'validerEcheancier',
                id: id,
                idcontrat: $("#idcontrat").val(),
                tache: $("#tache").val(),
                datepaiement: $("#datepaiement").val(),
                montant: $("#montant").val(),
                observation: $("#observation").val(),
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppContrat: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression du contrat",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JContrat.urlajax, {
                        action: 'suppression',
                        conf: 'suppcontrat',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JContrat.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du contrat effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'contrat', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce contrat\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JContrat.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JContrat.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JContrat.updateTips(n);
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
