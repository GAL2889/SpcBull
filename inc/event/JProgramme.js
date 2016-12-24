/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JProgramme = {
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
            
   validerProgramme: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JProgramme.checkcombo($("#idanneeacademique"));
        bValid = bValid && JProgramme.checkinput($("#libelle"));

       if (bValid) {
            $.get(JProgramme.urlajax, {
                action: 'validerProgramme',
                id: id,
                libelle: $("#libelle").val(),
                idanneeacademique: $("#idanneeacademique").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
   validerDetailsProgramme: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JProgramme.checkcombo($("#idniveauprogram"));
//        bValid = bValid && JProgramme.checkcombo($("#idniveausuperieur"));
        bValid = bValid && JProgramme.checkinput($("#code"));
        bValid = bValid && JProgramme.checkinput($("#intitule"));
       if (bValid) {
            $.get(JProgramme.urlajax, {
                action: 'validerDetailsProgramme',
                id: id,
                idprogramme: $("#idprogramme").val(),
                idniveauprogram: $("#idniveauprogram").val(),
                idniveausuperieur: $("#idniveausuperieur").val(),
                code: $("#code").val(),
                intitule: $("#intitule").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    suppProgramme: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression du programme",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JProgramme.urlajax, {
                        action: 'suppression',
                        conf: 'suppprogram',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JProgramme.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du programme effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'program', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce programme\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    suppDetailsProgramme: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression d'un contenu",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JProgramme.urlajax, {
                        action: 'suppression',
                        conf: 'suppdetailsprogram',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JProgramme.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du contenu effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'detailsProgram', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce contenu\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
    
     onchangeCmbProgramme: function(conf) { 
        $.get(JProgramme.urlajax, {
            conf: conf,
            action: 'onchangeCmbProgramme',
            idprogramme: $("#idprogramme").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
     onchangeCmbTechnicien: function(conf) {
        $.get(JProgramme.urlajax, {
            conf: conf,
            action: 'onchangeCmbTechnicien',
            idprogramme: $("#idprogramme").val(),
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
            JProgramme.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JProgramme.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JProgramme.updateTips(n);
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
