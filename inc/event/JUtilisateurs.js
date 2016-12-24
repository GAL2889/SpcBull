// JavaScript Document

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


var JUtilisateurs = {
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
    suppUtilisateurCoch: function() {
        var nb = $("#nbreparam").val();
        $("#zonesuppr").dialog({
            title: "Suppression des utilisateurs",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $(this).dialog("close");
                    JUtilisateurs.SuppressionUtilisateur(nb);
                },
                NON: function() {
                    $(this).dialog("close");
                }
            }
        });

    },
    SuppressionUtilisateur: function(nb) {
        $("#loading").show();
        var info = "";
        var nbCoche = 0;  // Nbre d'utilisateurs sélectionné pour suppression

        $.ajaxSetup({
            async: false
        });

        for (var i = 1; i <= nb; i++) { // Parcours de tous les utilisateurs
            if (document.getElementById("chk" + i) != null && document.getElementById("chk" + i).checked) { // Si une structure est cochée
                nbCoche++;
                $.get(JUtilisateurs.urlajax, {
                    action: 'suppUtilisateur',
                    id: $("#chk" + i).val()
                }, function(data) {//alert(data);
                    data = data.replace(/\s/g, "");
                    if (data == 0) {
                        info += "<span style='padding-left:40px;'>" + $("#param" + i).val() + " : erreur de connexion</span><br>";
                    } else if (data == 1) {

                    }
                });
            }
        }
        $.ajaxSetup({
            async: true
        });
        //  alert("salut");
        $("#loading").hide();

        if (nbCoche == 0) {
            $("#infosuppr").dialog({
                title: "Suppression des utilisateurs",
                resizable: false,
                height: "auto",
                width: "auto",
                modal: true,
                show: 'blind',
                hide: 'explode',
                position: "center",
                buttons: {
                    OK: function() {
                        $(this).dialog("close");
                    }
                }
            });
        }
        else {
            JUtilisateurs.refreshTableSite();
            if (info == "") {
                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Les utilisateurs ont été supprimés avec succès. </div>').fadeIn(1000);
            }
            else {
                $("#info").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>Info !</strong> Suppression non effectuée pour certains utilisateurs : <br>' + info + ' </div>').fadeIn(1000);
            }
        }
    },
    //Ajout de matériel
    ajoutUtilisateur: function() { //alert($("#idcodebudgetaire").val())
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JUtilisateurs.checkcombo($("#sexe"));
        bValid = bValid && JUtilisateurs.checkinput($("#nom"));
        bValid = bValid && JUtilisateurs.checkinput($("#prenom"));
        bValid = bValid && JUtilisateurs.checkinput($("#matricule"));
        bValid = bValid && JUtilisateurs.checkinput($("#datedenaissance"));
//        bValid = bValid && JUtilisateurs.checkRegexp($("#email"), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, 'Veuillez entrer un email valide comme : user@domain.com');
//        bValid = bValid && JUtilisateurs.checkinput($("#telephone"));
        bValid = bValid && JUtilisateurs.checkinput($("#login"));
        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse"));
        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse1"));
        bValid = bValid && JUtilisateurs.checkcombo($("#idstructure"));
        if (bValid) {
            $("#formaddUtilisateur").submit();
        }
    },
    formEditUtilisateur: function(id) {
        $.get(JUtilisateurs.urlajax, {
            action: 'getFormEditUtilisateur',
            id: id
        }, function(data) {
            alert(data)
            $("#zoneadd").html(data);
        }
        );
    },
    //Ajout de matériel
    editUtilisateur: function() { //alert($("#image").val())
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JUtilisateurs.checkcombo($("#sexe"));
        bValid = bValid && JUtilisateurs.checkinput($("#nom"));
        bValid = bValid && JUtilisateurs.checkinput($("#prenom"));
        bValid = bValid && JUtilisateurs.checkinput($("#matricule"));
        bValid = bValid && JUtilisateurs.checkinput($("#datedenaissance"));
//        bValid = bValid && JUtilisateurs.checkRegexp($("#email"), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, 'Veuillez entrer un email valide comme : user@domain.com');
//        bValid = bValid && JUtilisateurs.checkinput($("#telephone"));
        bValid = bValid && JUtilisateurs.checkinput($("#login"));
        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse1"));
        bValid = bValid && JUtilisateurs.checkcombo($("#idstruct"));
        if (bValid) {
            $("#formeditUtilisateur").submit();
        }
    },
    checkPassword: function() { //alert("amanda !!!");
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JUtilisateurs.checkinput($("#oldPassword"));
        bValid = bValid && JUtilisateurs.checkinput($("#newPassword"));
        bValid = bValid && JUtilisateurs.checkinput($("#confirmPass"));
        if (bValid) {
            $("#formPassword").submit();
        }
    },
    editUtilisateur1: function(id) {      //alert(actif + "  " + id)
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JUtilisateurs.checkcombo($("#sexe"));
        bValid = bValid && JUtilisateurs.checkinput($("#nom"));
        bValid = bValid && JUtilisateurs.checkinput($("#prenom"));
        bValid = bValid && JUtilisateurs.checkinput($("#matricule"));
        bValid = bValid && JUtilisateurs.checkinput($("#datedenaissance"));
        bValid = bValid && JUtilisateurs.checkRegexp($("#email"), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, 'Veuillez entrer un email valide comme : user@domain.com');
        bValid = bValid && JUtilisateurs.checkinput($("#telephone"));
        bValid = bValid && JUtilisateurs.checkinput($("#login"));
//        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse"));
//        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse1"));
        bValid = bValid && JUtilisateurs.checkcombo($("#idstructure"));
        if (bValid) {
            $.get(JUtilisateurs.urlajax, {
                action: 'editUtilisateur',
                id: id,
                sexe: $("#sexe").val(),
                nom: $("#nom").val(),
                prenom: $("#prenom").val(),
                matricule: $("#matricule").val(),
                datedenaissance: $("#datedenaissance").val(),
                email: $("#email").val(),
                telephone: $("#telephone").val(),
                login: $("#login").val(),
//                motdepasse: $("#motdepasse").val(),
//                motdepasse1: $("#motdepasse1").val(),
                idstructure: $("#idstructure").val(),
                fonction: $("#fonction").val()
            }, function(data) {//alert(data);
                $("#zoneadd").html(data);
            }
            );
        }

    },
    suppUtilisateur: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de l'utilisateur",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JUtilisateurs.urlajax, {
                        action: 'suppUtilisateur',
                        id: id
                    }, function(data) { //alert(data);
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JUtilisateurs.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                JPrincipal.afficheContenu(0,'utilisateur','','');
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de l\'utilisateur effectuée avec succès !.</div>').fadeIn(300);
                                break;
                            case'5':
                                $("#zonesuppr").dialog("close");
                                JUtilisateurs.refreshTableSite();
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Information!</h4>Il existe au moins un élément concerné par ce utilisateur!<br>Vous ne pouvez donc pas le supprimer.</div>').fadeIn(300).fadeout(5000);
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
    reinitPwd: function(id) { //alert(id)
        JUtilisateurs.effacer();
        $.get(JUtilisateurs.urlajax, {
            action: 'getFormresetPwd',
            id: id
        }, function(data) {
            $("#zoneresetPwd").html(data);
        });
        /* Action sur selection du combo pays */
        $("#zoneresetPwd").dialog({
            title: "Réinitialisation du mot de passe",
            autoOpen: true,
//            width: 460,
            width: "auto",
            height: "auto",
            modal: true,
            show: "blind",
            hide: "explode",
            resizable: false,
            position: "center",
            buttons: {
                "Enregistrer": function() {
                    var bValid = true;
                    $('.ui-corner-all').removeClass("ui-state-error");
                    bValid = bValid && JUtilisateurs.checkinput($("#motdepasse"));
                    if (bValid) {
                        Params = $("#formresetPwd").serialize();
                        $.get(JUtilisateurs.urlajax, Params, function(data) {
                            data = data.replace(/\s/g, ""); alert(data)
                            switch (data) {
                                case '0':
                                    JUtilisateurs.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                    break;
                                case '1':
                                    $("#zoneresetPwd").dialog("close");
                                    JUtilisateurs.refreshTableSite();
                                    $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Réinitialisation du mot de passe effectué avec succès !.</div>').fadeIn(300);
                                    break;
                            }


                        });
                    }

                },
                "Annuler": function() {
                    $(this).dialog("close");
                }
            }
        });
    },
    act: function(id) {
        $("#zoneact").dialog({
            title: "Activation de l'utilisateur",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JUtilisateurs.urlajax, {
                        action: 'actUtilisateur',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JUtilisateurs.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneact").dialog("close");
                                JUtilisateurs.refreshTableSite();
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Activation de l\'utilisateur effectuée avec succès !.</div>').fadeIn(300);
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
    desact: function(id) {
        $("#zonedesact").dialog({
            title: "Désactivation de l'utilisateur",
            resizable: false,
            height: "auto",
            width: "auto",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JUtilisateurs.urlajax, {
                        action: 'desactUtilisateur',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JUtilisateurs.updateTips("<div class='alert alert-warning'>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonedesact").dialog("close");
                                JUtilisateurs.refreshTableSite();
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Désactivation de l\'utilisateur effectuée avec succès !.</div>').fadeIn(300);
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
    editPersonneUser: function(iduser) {
        $.get(JUtilisateurs.urlajax, {
            action: 'getFormEditPersonneUser',
            iduser: iduser
        }, function(data) {
            $("#zoneeditPersonneUser").html(data);
            /* Action sur selection du combo pays */

            $("#zoneeditPersonneUser").dialog({
                title: "Modification des informations personnelles",
                autoOpen: true,
                height: "auto",
                width: "auto",
                modal: true,
                show: "blind",
                hide: "explode",
                resizable: false,
                position: "center",
                buttons: {
                    "Modifier": function() {
                        var bValid = true;
                        $('.ui-corner-all').removeClass("ui-state-error");
                        bValid = bValid && JUtilisateurs.checkinput($("#login"));
                        bValid = bValid && JUtilisateurs.checkinput($("#telephone"));
                        bValid = bValid && JUtilisateurs.checkRegexp($("#email"), /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
//                        bValid = bValid && JUtilisateurs.checkinput($("#email"));
                        if (bValid) {
                            /* Traitement de la requete*/
                            Params = $("#formeditPersonneUser").serialize();
                            $.get(JUtilisateurs.urlajax, Params, function(data) {
                                data = data.replace(/\s/g, "");
                                switch (data) {
                                    case '0':
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Vos informations n\'ont pas été modifiées : Erreur de connexion</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                }
                                            }
                                        });
                                        break;
                                    case '1':
                                        $("#zoneeditPersonneUser").dialog("close");
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Vos informations ont été modifiées avec succès : vous devez vous reconnecter</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                    document.location.href = "deconnect.php";
                                                }
                                            }
                                        });
                                        break;
                                    case '2':
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Veuillez choisir un autre identifiant </p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                    $("#login").focus();
                                                }
                                            }
                                        });
                                        break;
                                }
                            });
                        }
                    },
                    "Annuler": function() {
                        $(this).dialog("close");
                    }
                }
            });
        });
    },
    // Changer mot de passe
    editPasswordUser: function(iduser) {//alert('salut');
        $.get(JUtilisateurs.urlajax, {
            action: 'getFormEditPasswordUser',
            iduser: iduser
        }, function(data) {
            $("#zoneeditPasswordUser").html(data);
            $("#zoneeditPasswordUser").dialog({
                title: "Changement de mot de passe",
                autoOpen: true,
                height: "auto",
                width: "auto",
                modal: true,
                show: "blind",
                hide: "explode",
                resizable: false,
                position: "center",
                buttons: {
                    "Modifier": function() {
                        var bValid = true;
                        $('.ui-corner-all').removeClass("ui-state-error");
//                        bValid = bValid && JUtilisateurs.checkinput($("#login"));
                        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse"));
                        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse1"));
                        bValid = bValid && JUtilisateurs.checkinput($("#motdepasse2"));
                        if (bValid) {
                            /* Traitement de la requete*/
                            Params = $("#formeditPasswordUser").serialize();
                            $.get(JUtilisateurs.urlajax, Params, function(data) {
                                data = data.replace(/\s/g, "");
                                switch (data) {
                                    case '0':
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Mot de passe non modifié : Erreur de connexion</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                }
                                            }
                                        });
                                        break;
                                    case '1':
                                        $("#zoneeditPasswordUser").dialog("close");
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Votre mot de passe a été modifié avec succès : vous devez vous reconnecter</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                    document.location.href = "deconnect.php";
                                                }
                                            }
                                        });
                                        break;
                                    case '2':
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Vos nouveaux mots de passe ne concordent pas</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                    $("#motdepasse1").focus();
                                                }
                                            }
                                        });
                                        break;
                                    case '3':
                                        $("#zoneinfo").html('<p><span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 20px 0;"></span>Votre mot de passe actuel est incorrecte</p>');
                                        $("#zoneinfo").dialog({
                                            title: "Information !",
                                            resizable: false,
                                            height: "auto",
                                            width: "auto",
                                            modal: true,
                                            show: 'blind',
                                            hide: 'explode',
                                            position: "center",
                                            buttons: {
                                                OK: function() {
                                                    $(this).dialog("close");
                                                    $("#motdepasse").focus();
                                                }
                                            }
                                        });
                                        break;
                                }
                            });
                        }
                    },
                    "Annuler": function() {
                        $(this).dialog("close");
                    }
                }
            });
        });
    },
    checkinput: function(o) {
        if (o.val().length == 0) {
            o.addClass("ui-state-error");
            JUtilisateurs.updateTips("<div class='alert'>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JUtilisateurs.updateTips("<div class='alert'>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JUtilisateurs.updateTips("<div class='alert'>" + n + "</div>");
            return false;
        } else {
            return true;
        }
    },
    updateTips: function(t) {
        $(".validateTips").html(t);
    },
    effacer: function() {
        $(".validateTips").html('').removeClass("ui-state-highlight");
        $('.ui-corner-all').removeClass("ui-state-error");
        $('.ui-corner-all').val("");
        $('input').removeClass("ui-state-error");
    },
    refreshTableSite: function() {
        $.ajaxSetup({
            async: false
        });
        document.getElementById("loading").style.visibility = "visible";
        $.get(JUtilisateurs.urlajax, {
            action: 'getAllUtilisateurs'
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
    }
};