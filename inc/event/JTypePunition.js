/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JTypePunition = {
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
            
   validerTypePunition: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JTypePunition.checkinput($("#libelle"));

       if (bValid) {
            $.get(JTypePunition.urlajax, {
                action: 'validerTypePunition',
                id: id,
                libelle: $("#libelle").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    suppTypePunition: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression du type de punition",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JTypePunition.urlajax, {
                        action: 'suppression',
                        conf: 'supptypepunition',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JTypePunition.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du type de punition effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'typepunition', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce type de punition \nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JTypePunition.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JTypePunition.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JTypePunition.updateTips(n);
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

