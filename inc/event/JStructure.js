var JStructure = {
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
            
   validerStructure: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JStructure.checkinput($("#denomination"));
        bValid = bValid && JStructure.checkcombo($("#idtypestructure"));
        bValid = bValid && JStructure.checkcombo($("#idlocalite"));
        bValid = bValid && JStructure.checkcombo($("#idstructuremere"));
        bValid = bValid && JStructure.checkcombo($("#idchefstructure"));

        if (bValid) {
            $.get(JStructure.urlajax, {
                action: 'validerStructure',
                id: id,
                denomination: $("#denomination").val(),
                sigle: $("#sigle").val(),
                idtypestructure: $("#idtypestructure").val(),
                idlocalite: $("#idlocalite").val(),
                idstructuremere: $("#idstructuremere").val(),
                idchefstructure: $("#idchefstructure").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    suppStructure: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de structure",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JStructure.urlajax, {
                        action: 'suppression',
                        conf: 'suppstructure',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JStructure.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la structure effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'structure', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette structure\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JStructure.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JStructure.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
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
    }
};