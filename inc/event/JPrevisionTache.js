/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var JPrevisionTache = {
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
    validerPrevisionTache: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JPrevisionTache.checkinput($("#datejour"));
        bValid = bValid && JPrevisionTache.checkinput($("#tache"));
        bValid = bValid && JPrevisionTache.checkcombo($("#idpriorite"));
        bValid = bValid && JPrevisionTache.checkinput($("#datedebut"));
        bValid = bValid && JPrevisionTache.checkinput($("#datefin"));


        if (bValid) {
            $.get(JPrevisionTache.urlajax, {
                action: 'validerPrevision',
                id: id,
                datejour: $("#datejour").val(),
                tache: $("#tache").val(),
                datedebut: $("#datedebut").val(),
                datefin: $("#datefin").val(),
                idpriorite: $("#idpriorite").val(),
                idpersonnehelp: $("#idpersonnehelp").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    execPrevisionTache: function(id) {
        $("#zoneExec").dialog({
            title: "Suivi Tâche",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPrevisionTache.urlajax, {
                        action: 'executerTache',
                        conf: 'prevision',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPrevisionTache.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneExec").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>La tâche a été marquée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'prevision', '', '');
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
    suppPrevisionTache: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de la prévision",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPrevisionTache.urlajax, {
                        action: 'suppression',
                        conf: 'suppprevision',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPrevisionTache.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la prévision effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'suivitache', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette prévision\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    onChangeCmbMois: function(conf) {
        $.get(JPrevisionTache.urlajax, {
            conf: conf,
            action: 'onChangeCmbMois',
            idmois: $("#idmois").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },    
    onChangeCmbPersPrevision: function(conf) {
        $.get(JPrevisionTache.urlajax, {
            conf: conf,
            action: 'onChangeCmbPersPrevision',
            idmois: $("#idmois").val(),
            idpersonne: $("#idpersonne").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JPrevisionTache.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JPrevisionTache.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JPrevisionTache.updateTips(n);
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
