/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JProfil = {
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
   
     formEditProfil: function(id) {	//alert(id);
       $.get(JProfil.urlajax, { 
                action: 'getFormEditProfil',  
                id:id    
            }
            , function(data) { 
                $("#zoneadd").html(data);               
            }
            );     
    },
    
     editProfil: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");        
       if (bValid) { 
            $.get(JProfil.urlajax, {
                action: 'editprofil',  
                id:id,
                libprofil: $("#libprofil").val()
            }
            , function(data) { 
                $("#zoneadd").html(data);
                
            }
            );

        }
        
    },
         
    ajoutProfil: function() {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JProfil.checkinput($("#libprofil"));    

        if (bValid) {
            $.get(JProfil.urlajax, {
                action: 'addprofil',  
                libprofil:$("#libprofil").val()                
            }
            , function(data) { //alert(data)
                $("#zoneadd").html(data);                
            }
            );
        }
    },


    suppProfil: function(id) {         
        $("#zonesuppr").dialog({
            title: "Suppression de profil",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JProfil.urlajax, {
                        action: 'suppression',
                        conf: 'suppprofil',
                        id: id
                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JProfil.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
//                                JProfil.refreshTableSite();
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression du profil effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'profil', '', '');
                                break;
                            case '5':
                                $("#zonesuppr").dialog("close");
//                                JProfil.refreshTableSite();
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un utilisateur qui a ce profil\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'profil', '', '');
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

    formAddUserProfil: function(id) {
        $.get(JProfil.urlajax, {
            action: 'getFormAddUserProfil',
            id: id
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
     formDetailsUser: function(id) {
        $.get(JProfil.urlajax, {
            action: 'getFormDetailsUser',
            id: id //idprofil
        }, function(data) {
            $("#zoneadd").html(data);
        }
        );
    },
    
    refreshTableSite: function() {
        $.ajaxSetup({
            async: false
        });
        document.getElementById("loading").style.visibility = "visible";
        $.get(JProfil.urlajax, {
            action: 'getAllProfil'
        }, function(data) {
            $("#zoneListeSite").html(data);
            $('.display').dataTable(
                    {
                        'bJQueryUI': true,
                        'sPaginationType': 'full_numbers',
                        "oLanguage": {
                            "sLengthMenu": "Recherche _MENU_ Enregistrements par page",
                            "sZeroRecords": "Aucun Enregistrement...!",
                            "sInfo": "",
                            "sInfoEmpty": "",
                            "sInfoFiltered": "",
                            "sSearch": "Rechercher:",
                            "oPaginate": {
                                "sFirst": "Premier",
                                "sLast": "Dernier",
                                "sPrevious": "Précedent",
                                "sNext": "Suivant"
                            }
                        }
                    }
            );
        });
        document.getElementById("loading").style.visibility = "hidden";
        $.ajaxSetup({
            async: true
        });
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JMarque.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
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



