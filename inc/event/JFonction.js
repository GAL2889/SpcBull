/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var JFonction = {
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
            
   validerFonction: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JFonction.checkinput($("#libelle"));

       if (bValid) {
            $.get(JFonction.urlajax, {
                action: 'validerFonction',
                id: id,
                libelle: $("#libelle").val(),
                code: $("#code").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    
    suppFonction: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de la fonction",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JFonction.urlajax, {
                        action: 'suppression',
                        conf: 'suppfonction',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JFonction.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la fonction effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'fonction', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette fonction\nVous ne pouvez donc pas la supprimer.</div>').fadeIn(300);
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
            JFonction.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JFonction.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JFonction.updateTips(n);
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