/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JPersonne = {
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
    validerPersonne: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JPersonne.checkinput($("#nom"));
        bValid = bValid && JPersonne.checkinput($("#prenom"));
        bValid = bValid && JPersonne.checkcombo($("#idsexe"));
        bValid = bValid && JPersonne.checkcombo($("#idsituationmatri"));
        bValid = bValid && JPersonne.checkinput($("#datenaissance"));
        bValid = bValid && JPersonne.checkinput($("#lieunaissance"));

        bValid = bValid && JPersonne.checkinput($("#matricule"));
        bValid = bValid && JPersonne.checkinput($("#dateembauche"));
        if ($("#idtypepersonne").val() == 2) {
            bValid = bValid && JPersonne.checkinput($("#dateprobdepart"));
        }
        bValid = bValid && JPersonne.checkcombo($("#idtypepersonne"));
        if ($("#idtypepersonne").val() == 1) {
            bValid = bValid && JPersonne.checkcombo($("#idfonction"));
        }
        bValid = bValid && JPersonne.checkinput($("#telephone"));
//        bValid = bValid && JPersonne.checkinput($("#email"));
        bValid = bValid && JPersonne.checkinput($("#adresse"));
        
        if($("#fraisformation")!==undefined){
            var fr = $("#fraisformation").val(); //alert(document.getElementById('fraisformation').value + ' Merci  '+ fr.replace(/\s/g, "") );
            document.getElementById('fraisformation').value = fr.replace(/\s/g, "");
        }

        if (bValid) {
            $("#formaddeditPersonne").submit();
        }

    },
    suppPersonne: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression d'une personne",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPersonne.urlajax, {
                        action: 'suppression',
                        conf: 'supppersonne',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPersonne.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la personne effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'personne', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette personne\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
    onchangeCmbTypePersone: function(conf) {
        $.get(JSuiviTache.urlajax, {
            conf: conf,
            action: 'onchangeCmbTypePersone',
            idtypepersonne: $("#idtypepersonne").val()
        }, function(data) {
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();

        }
        );
    },
    desactiver: function(id) {
        $("#zonedesactUser").dialog({
            title: "Mis en veille de l'agent",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPersonne.urlajax, {
                        action: 'desactiverPers',
                        id: id
                    }, function(data) {//alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPersonne.updateTips("<div class='alert alert-warning'>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonedesactUser").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Mis en veille de l\'agent effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'personne', '', '');
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
    activer: function(id) {
        $("#zoneactiUser").dialog({
            title: "Activation de l'agent",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JPersonne.urlajax, {
                        action: 'activerPers',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPersonne.updateTips("<div class='alert alert-warning'>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneactiUser").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Activation de l\'agent effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'personne', '', '');
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
    fraisFormation: function(id) {
        $("#zoneFrais").dialog({
            title: "Frais de formation",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    var frais = $("#fraisformation").val();
                    frais = frais.replace(/\s/g, "");
                    $.get(JPersonne.urlajax, {
                        action: 'validerFrais',
                        id: id,
                        fraisformation: frais
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JPersonne.updateTips("<div class='alert alert-warning'>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneFrais").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Frais de formation de l\'agent renseigné avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'personne', '', '');
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
    onChangeDateEmbauche: function() {
        var date_initial = $("#dateembauche").val();
        var result = date_initial.split("-");
        var date_convert = result[0] + "/" + result[1] + "/" + result[2];
        var date_finale = augmenterDate(date_convert, 1460);
        var resultat = date_finale.split("/");
        var date_F = resultat[0] + "-" + resultat[1] + "-" + resultat[2];
        document.getElementById('dateprobdepart').value = date_F;

    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JPersonne.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JPersonne.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JPersonne.updateTips(n);
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

