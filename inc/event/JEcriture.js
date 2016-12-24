/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JEcriture = {
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
    validerEcriture: function(id,retour) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JEcriture.checkinput($("#codejournal"));
        bValid = bValid && JEcriture.checkcombo($("#libelle"));

        if (bValid) {
            $.get(JEcriture.urlajax, {
                action: 'validerEcriture',
                id: id,
                retour: retour,
                codejournal: $("#codejournal").val(),
                libelle: $("#libelle").val()
            }
            , function(data) {//alert(data);
                $("#zoneadd").html(data);
            }
            );
        }
    },
  
    suppEcriture: function(id) {
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
                    $.get(JEcriture.urlajax, {
                        action: 'suppression',
                        conf: 'suppjrnal',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JEcriture.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'jrnal', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce journal\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
    genererEcriture: function() {
        $("#zoneGenEcr").dialog({
            title: "Génération des écritures",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JEcriture.urlajax, {
                        action: 'genererEcriture',
                        conf: 'generer'
                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                 $("#zoneGenEcr").dialog("close");
                                JEcriture.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneGenEcr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Les écritures ont été générées avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'generer', '', '');
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
   validerBrouillard: function() {
        $("#zonevalEcr").dialog({
            title: "Validation des écritures",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JEcriture.urlajax, {
                        action: 'validerBrouillard',
                        conf: 'validation'
                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                 $("#zonevalEcr").dialog("close");
                                JEcriture.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonevalEcr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Les écritures ont été validées avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'validEcr', '', '');
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
    onChangeCmbJournal: function(conf) {
        $.get(JEcriture.urlajax, {
            conf: conf,
            action: 'onChangeCmbJournal',
            idjournal: $("#idjournal").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();
        }
        );
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JEcriture.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JEcriture.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JEcriture.updateTips(n);
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



