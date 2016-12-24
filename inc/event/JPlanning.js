/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JPlanning = {
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
            
   validerPlanning: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JPlanning.checkinput($("#datejour"));
        bValid = bValid && JPlanning.checkcombo($("#idpersonne"));
//        bValid = bValid && JPlanning.checkcombo($("#iddetailsprogram"));
        bValid = bValid && JPlanning.checkinput($("#commentaire"));
        
       if (bValid) {
            $.get(JPlanning.urlajax, {
                action: 'validerPlanning',
                id: id,
                datejour: $("#datejour").val(),
                idpersonne: $("#idpersonne").val(),
                iddetailsprogram: $("#iddetailsprogram").val(),
                commentaire: $("#commentaire").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    suppPlanning: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression du planning",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPlanning.urlajax, {
                        action: 'suppression',
                        conf: 'suppplanning',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPlanning.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du planning effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'planning', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce planning\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
       suiviTechnicien: function(id) {
        $("#zoneSuiviTech").dialog({
            title: "Suivi du technicien",
            resizable: false,
            height: "auto",
            width: "500",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    var bValid = true;
                    $('.ui-corner-all').removeClass("ui-state-error");
                     bValid = bValid && JPlanning.checkinput($("#activitejour"));
                    if (bValid) {
                        $.get(JPlanning.urlajax, {
                            action: 'suiviTechnicien',
                            id: id,
                            activitejour: $("#activitejour").val(),
                            observation: $("#observation").val()
                        }, function(data) {
                            data = data.replace(/\s/g, "");
                            switch (data) {
                                case '0':
                                    JPlanning.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                    break;
                                case '1':
                                    $("#zoneSuiviTech").dialog("close");
                                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>L\'activité du jour a été renseignée avec succès !.</div>').fadeIn(300);
                                    JPrincipal.afficheContenu(0, 'suiviTech', '', '');
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
   onChangeDateFiltre: function(conf) {
        $.get(JPlanning.urlajax, {
            conf:conf,
            action: 'onChangeDateFiltre',
            datefiltre: $("#datefiltre").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
   onChangePeriode: function(conf) {
        $.get(JPlanning.urlajax, {
            conf:conf,
            action: 'onChangePeriode',
            debutperiode: $("#debutperiode").val(),
            finperiode: $("#finperiode").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();

        }
        );
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JPlanning.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JPlanning.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JPlanning.updateTips(n);
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
