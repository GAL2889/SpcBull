/*
 * @author Chris H.
 */

var JLocalite = {
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
    validerLocalite: function(id) {

        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JLocalite.checkcombo($("#idtypelocalite"));
        bValid = bValid && JLocalite.checkinput($("#idlocalitemere"));
        bValid = bValid && JLocalite.checkinput($("#libelle"));

        if (bValid) {
            $.get(JLocalite.urlajax, {
                action: 'validerLocalite',
                id: id,
                idtypelocalite: $("#idtypelocalite").val(),
                idlocalitemere: $("#idlocalitemere").val(),
                codelocalite: $("#codelocalite").val(),
                libelle: $("#libelle").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    supplocalite: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de localité",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JLocalite.urlajax, {
                        action: 'suppression',
                        conf: 'supplocalite',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JLocalite.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la localite effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'localite', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette localite\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JLocalite.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JLocalite.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JLocalite.updateTips(n);
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
    onchangeCmbDep: function() {
        $.get(JLocalite.urlajax, {
            action: 'onchangeCmbDep',
            idtypelocalite: $("#idtypelocalite").val()
        }, function(data) {
            $("#zoneadd").html(data);
            appliqueChosen();
            appliqueDataTable();

        }
        );

    },
    onchangeCmblm: function() {
        $.get(JLocalite.urlajax, {
            action: 'onchangeCmblm',
            idlocalitemere: $("#idlocalitemere").val()
        }, function(data) {
            $("#zoneadd").html(data);
            appliqueChosen();
            appliqueDataTable();

        }
        );
    }
};