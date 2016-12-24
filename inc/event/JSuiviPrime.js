/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var JSuiviPrime = {
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
    validerSuiviPrime: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JSuiviPrime.checkinput($("#datejour"));
        bValid = bValid && JSuiviPrime.checkcombo($("#idpersonne"));
        bValid = bValid && JSuiviPrime.checkcombo($("#sens"));
        bValid = bValid && JSuiviPrime.checkinput($("#montant"));
        bValid = bValid && JSuiviPrime.checkinput($("#motif"));

        if (bValid) {
            $.get(JSuiviPrime.urlajax, {
                action: 'validerSuiviPrime',
                id: id,
                idpersonne: $("#idpersonne").val(),
                datejour: $("#datejour").val(),
                sens: $("#sens").val(),
                motif: $("#motif").val(),
                montant: $("#montant").val(),
                calculer: document.getElementById('calculer').checked
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppSuiviPrime: function(id) {
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
                    $.get(JSuiviPrime.urlajax, {
                        action: 'suppression',
                        conf: 'suppprime',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JSuiviPrime.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'prime', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette enregistrement\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JSuiviPrime.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JSuiviPrime.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JSuiviPrime.updateTips(n);
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