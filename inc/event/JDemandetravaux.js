var JDemandetravaux = {
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
            if (document.getElementById("chk" + i) !== null) {
                document.getElementById("chk" + i).checked = false;
            }
        }
    },
    validerDemandetravaux: function(codeunique,retour) { //alert($("#iddemandeur").val());
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JDemandetravaux.checkinput($("#numero"));
        bValid = bValid && JDemandetravaux.checkinput($("#datedt"));
        bValid = bValid && JDemandetravaux.checkcombo($("#iddemandeur"));
        bValid = bValid && JDemandetravaux.checkcombo($("#idchantier"));
        bValid = bValid && JDemandetravaux.checkinput($("#libelle"));
//alert($("#idexecutant").val());
        if (bValid) {
            $.get(JDemandetravaux.urlajax, {
                action: 'validerDemandetravaux',
                codeunique: codeunique,
                retour: retour,
                numero: $("#numero").val(),
                datedt: $("#datedt").val(),
                iddemandeur: $("#iddemandeur").val(),
                idchantier: $("#idchantier").val(),
                libelle: $("#libelle").val(),
                idexecutant: $("#idexecutant").val(),
                moyeninfo: $("#moyeninfo").val()
            }
            , function(data) { //alert(data)
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppDemandetravaux: function(id) {
        $("#zonesuppr").dialog({
            title: "Suppression de libelle",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JDemandetravaux.urlajax, {
                        action: 'suppression',
                        conf: 'suppdemandetravaux',
                        id: id
                    }, function(data) {
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JDemandetravaux.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la demandetravaux effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, 'demandetravaux', '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cette demandetravaux\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
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
            JDemandetravaux.updateTips("<div style=height:30px;>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() == 0) {
            o.addClass("ui-state-error");
            JDemandetravaux.updateTips("<div style=height:30px;>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JDemandetravaux.updateTips(n);
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
     valeurTabloDetailsDemandetravaux: function() { //alert('Merci Seigneur');
        var nbre = document.getElementById('tailleTabloDetailsDemandetravaux').value;
        var j = 0;
        for (i = 1; i <= nbre; i++) { //alert($("#idIndic" + i).val());
            if (($("#iddemandetravaux" + i).val() !== '0'))
                j++;
        }
        var tabDetailsDemandetravaux = new Array(j);
        var iddetailcas = '';
        var iddemandetravaux = '';
        var montant = '';
        var t = 0;
        for (i = 1; i <= nbre; i++) {
            if (($("#iddemandetravaux" + i).val() !== '0')) {

                if ($("#montant" + i).val() === "") {
                    montant = "***";
                } else {
                    montant = $("#montant" + i).val();
                }
                iddetailcas = $("#iddetailcas" + i).val();
                iddemandetravaux = $("#iddemandetravaux" + i).val();
                tabDetailsDemandetravaux[t] = iddetailcas + "|" + iddemandetravaux + "|" + montant;
                t++;
            }
        }
        return tabDetailsDemandetravaux;
    }
};