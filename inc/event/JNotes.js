/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JNotes = {
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
    validerNotes: function(id,retour) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JNotes.checkinput($("#idanneeacademik"));
        bValid = bValid && JNotes.checkcombo($("#idtypenote"));
        bValid = bValid && JNotes.checkinput($("#dateevaluation"));
        bValid = bValid && JNotes.checkinput($("#valeur"));
        bValid = bValid && JNotes.checkcombo($("#idpersonne"));

        if (bValid) {
            $.get(JNotes.urlajax, {
                action: 'validerNotes',
                id: id,
                idanneeacademik: $("#idanneeacademik").val(),
                idtypenote: $("#idtypenote").val(),
                dateevaluation: $("#dateevaluation").val(),
                valeur: $("#valeur").val(),
                idpersonne: $("#idpersonne").val(),
                retour:retour
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppNotes: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de la note",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JNotes.urlajax, {
                        action: 'suppression',
                        conf: 'suppnotes',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JNotes.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la note effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'notes', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette note \nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    onChangeDateEvaluation: function(conf) {
        $.get(JNotes.urlajax, {
            conf: conf,
            action: 'onChangeDateEvaluation',
            dateEval: $("#dateEval").val(),
            idanneeacademik: $("#idanneeacademik").val(),
            idtypenote: $("#idtypenote").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
    onChangeAnneeAcademik: function(conf) {
        $.get(JNotes.urlajax, {
            conf: conf,
            action: 'onChangeAnneeAcademik',
            idanneeacademik: $("#idanneeacademik").val(),
            dateEval: $("#dateEval").val(),
            idtypenote: $("#idtypenote").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
    onChangeTypeNote: function(conf) {
        $.get(JNotes.urlajax, {
            conf: conf,
            action: 'onChangeTypeNote',
            idtypenote: $("#idtypenote").val(),
            dateEval: $("#dateEval").val(),
            idanneeacademik: $("#idanneeacademik").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JNotes.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JNotes.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JNotes.updateTips(n);
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




