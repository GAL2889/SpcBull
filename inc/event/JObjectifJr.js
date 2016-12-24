/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var JObjectifJr = {
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
    validerObjectifJr: function(id) {
        var j = 0;
        var tabDetailsTache = JObjectifJr.valeurTabloDetailsTache();
        j = tabDetailsTache.length;
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JObjectifJr.checkinput($("#datejour"));
        bValid = bValid && JObjectifJr.checkinput($("#libelle"));
//        bValid = bValid && JObjectifJr.checkinput($("#heuredebut"));
//        bValid = bValid && JObjectifJr.checkinput($("#heurefin"));

        if (bValid) {
            $.get(JObjectifJr.urlajax, {
                action: 'validerObjectif',
                id: id,
                datejour: $("#datejour").val(),
                libelle: $("#libelle").val(),
                heuredebut: $("#heuredebut").val(),
                heurefin: $("#heurefin").val(),
                tabDetailsTache: tabDetailsTache,
                nbreTache: j
            }
            , function(data) {
                $("#zoneadd").html(data);
            }
            );
        }
    },
    atteindrObjectifJr: function(id) {
        $("#zoneObj").dialog({
            title: "Suivi Objectif",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JObjectifJr.urlajax, {
                        action: 'atteindreObjectif',
                        conf: 'objectif',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JObjectifJr.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneObj").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>L\objectif a été marqué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'objectif', '', '');
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
    validationObjectifJr: function(id) {
        $("#zoneValide").dialog({
            title: "Valider l'objectif",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JObjectifJr.urlajax, {
                        action: 'validationObjectif',
                        conf: 'objectif',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JObjectifJr.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zoneValide").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>L\objectif a été validé avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'objectif', '', '');
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
    suppObjectifJr: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de l'objectif",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JObjectifJr.urlajax, {
                        action: 'suppression',
                        conf: 'suppobjectif',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JObjectifJr.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de l\'objectif effectué avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'suivitache', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cet objectif\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
    valeurTabloDetailsTache: function() {
        var nbre = document.getElementById('tailleTabloDetailsObj').value;
        var j = 0;
        for (i = 1; i <= nbre; i++) { //alert($("#idIndic" + i).val());
            if (($("#idprevisiontache" + i).val() !== '0'))
                j++;
        }
        var tabDetailsTache = new Array(j);
        var iddetailsobjectif = '';
        var idprevisiontache = '';
        var commentaire = '';
        var heuredebut = '';
        var heurefin = '';
        var t = 0;
        for (i = 1; i <= nbre; i++) {
            if (($("#idprevisiontache" + i).val() !== '0')) {

                if ($("#commentaire" + i).val() === "") {
                    commentaire = "";
                } else {
                    commentaire = $("#commentaire" + i).val();
                }
                iddetailsobjectif = $("#iddetailsobjectif" + i).val();
                idprevisiontache = $("#idprevisiontache" + i).val();
                heuredebut = $("#heuredebut" + i).val();
                heurefin = $("#heurefin" + i).val();
                tabDetailsTache[t] = iddetailsobjectif + "|" + idprevisiontache + "|" + commentaire + "|" + heuredebut + "|" + heurefin;
                t++;
            }
        }
        return tabDetailsTache;
    },
    tabloplusPlus: function(listCombo, idtablo, idtailletablo, idcombo, onchange, choixdefaut) {
        var donneeCombo = listCombo.split('-->');

        var nbre = parseInt(document.getElementById(idtailletablo).value);//alert(nbre + ' Merci');
        nbre++;
        document.getElementById(idtailletablo).value = nbre;

        //Ajout d'une ligne au tableau (en fin de tableau)
        var newRow = document.getElementById(idtablo).insertRow(-1);
        idcombo += nbre;
        var largeur = 210;
        var donnee = donneeCombo;
        var combo = "";

        //Insertion de cellules

        combo = JPrincipal.chargeCombo(idcombo, onchange, choixdefaut, largeur, donnee);
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = nbre;
        newCell.align = "center";
        var newCell = newRow.insertCell(1); // 
        newCell.innerHTML = "<input type='hidden' style='height:0px; width:0px;' name='iddetailsobjectif" + nbre + "' id='iddetailsobjectif" + nbre + "' class='text ui-widget-content ui-corner-all'  value='' /> " + combo;

        newCell.align = "center";
        var newCell = newRow.insertCell(2);
        newCell.innerHTML = " <textarea rows='3' style='width:210px;' name='commentaire" + nbre + "'  id='commentaire" + nbre + "' placeholder='mon commentaire' ></textarea>  ";

        newCell.align = "center";
        var newCell = newRow.insertCell(3);
        newCell.innerHTML = " <input style='width:60px;' name='heuredebut" + nbre + "'  id='heuredebut" + nbre + "' placeholder='00:00:00' value='' />";

        newCell.align = "center";
        var newCell = newRow.insertCell(4);
        newCell.innerHTML = " <input style='width:60px;' name='heurefin" + nbre + "'  id='heurefin" + nbre + "' placeholder='00:00:00' value='' />";


    },
    onChangeCmbUserObjectif: function(conf) {
        $.get(JObjectifJr.urlajax, {
            conf: conf,
            action: 'onChangeCmbUserObjectif',
            datefiltre: $("#datefiltre").val(),
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
            JObjectifJr.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JObjectifJr.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JObjectifJr.updateTips(n);
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
    OnchangeDateJrPrev: function() {
        $.get(JObjectifJr.urlajax, {
            action: 'OnchangeDateJrPrev',
            datejour: $("#datejour").val()
        }, function(data) {
            $("#zoneadd").html(data);
            appliqueDataTable();

        }
        );
    }
};


