var JMouvement = {
    urlajax: 'ajax/ajaxIncludeForm.php',
          
      checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JMouvement.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
            
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JMouvement.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },        
            
       checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JMouvement.updateTips(n);
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
            
            
     validerMvt: function(id) {
        
        //alert("bonjour");
         
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        
        bValid = bValid && JMouvement.checkinput($("#txref"));
        bValid = bValid && JMouvement.checkinput($("#txobjet"));
        bValid = bValid && JMouvement.checkcombo($("#txdate"));

        if (bValid) {
            $.get(JMouvement.urlajax, {
                action: 'validerMvt',
                id: id,
                tref: $("#txref").val(),
                tobjet: $("#txobjet").val(),
                tdate: $("#txdate").val()
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },    
       
       suppMvt: function(id) {
           
        $("#zonesuppr").dialog({
            title: "Suppression de mouvement",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JMouvement.urlajax, {
                        action: 'suppression',
                        conf: 'suppreMvt',
                        id: id
                    }, function(data) {
                        
                        data = data.replace(/\s/g, "");
                        //alert("Bonjour tout le monde !!");
                        
                        switch (data) {
                            case '0':
                                JMouvement.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du cas effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'mvt', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à ce cas\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
                                break;
                        }
                    });
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });
    }
       
};