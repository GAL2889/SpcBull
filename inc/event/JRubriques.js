var JRubriques = {
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
    valider: function(codeunique, conf, retour) { //alert(conf)
        var bValid = true;
        var idtypeoperation = '';
        var idtypesource = '';
        var motdepasse = '';
        var idutilisateur = '';
        var idprofil = '';
        var idpersonne = '';
        var login = '';
        var motdepasse = '';
        var prefixmatricule = '';
        var matriculeencours = '';
        var numencours = '';
        var libelle = '';
        var naturepiece = 0;
        var visiblerapport = 0;
        var visiblebanque = 0;
        var visiblecaisse = 0;
        var chequevisible = 0;
        var fichedepotvisible = 0;
        var seuilmin = 0;
        var niveauvisible = 0;
        var numcompte = "";
//          var idmere = "";
        var champ = "";
        var idmere = "";
        //var codeunique = "";
        $('.ui-corner-all').removeClass("ui-state-error");
        if (conf === 'validerRubriques') { //alert($("#idtypeoper").val())
            bValid = bValid && JRubriques.checkcombo($("#idtypeoper"), " la rubrique");
            var num = $("#numcompte").val();

            if (num.length > 2) {
//            bValid = bValid && JRubriques.checkcombo($("#idmere")," la mère");
                idmere = $("#idmere").val();
            }
            idtypeoperation = $("#idtypeoper").val();
            idmere = $("#idmere").val();
            numcompte = $("#numcompte").val();

            for (i = 1; i <= 3; i++) {
                if (document.getElementById("chkniveauvisible" + i).checked === true)
                    niveauvisible = i;
            }

        }

        if (conf === 'validerCompte') {
            var num = $("#numcompte").val();

            if (num.length > 2) {
//            bValid = bValid && JRubriques.checkcombo($("#idmere")," la mère");
                idmere = $("#idmere").val();
            }
//            bValid = bValid && JRubriques.checkcombo($("#idtypeoper"), " la rubrique");
            bValid = bValid && JRubriques.checkinput($("#numcompte"), " le n° de compte ");
            bValid = bValid && JRubriques.checkinput($("#libelle"), " l'intitulé du compte ");
            for (i = 1; i <= 3; i++) {
                if (document.getElementById("chkniveauvisible" + i).checked === true)
                    niveauvisible = i;
            }
            champ = idmere + "|" + $("#numcompte").val() + "|" + $("#libelle").val()+ "|" + niveauvisible+ "|" + $("#idtypeoper").val();
        }

        if (conf === 'validerSource') {
            bValid = bValid && JRubriques.checkcombo($("#idtypesource"), " le type de la source");
            if (document.getElementById("visiblerapport").checked === true)
                visiblerapport = 1;
            var mons = $("#seuilmin").val();
            seuilmin = mons.replace(/\s/g, "");
            idtypesource = $("#idtypesource").val();
        }
        if (conf === 'validerReinitPW') {
            bValid = bValid && JRubriques.checkinput($("#motdepasse"), " le mot de passe");
            idutilisateur = $("#idutilisateur").val();
            motdepasse = $("#motdepasse").val();
        }
        if (conf === 'validerProfilUser') {
            bValid = bValid && JRubriques.checkcombo($("#idprofil"), " le profil");
            idprofil = $("#idprofil").val();
            idutilisateur = $("#idutilisateur").val();
        }
        if (conf === 'validerparametre') {// 
            bValid = bValid && JRubriques.checkinput($("#matriculeencours"), " le N° ");
            prefixmatricule = $("#prefixmatricule").val();
            matriculeencours = $("#matriculeencours").val();
        }
        if (conf === 'validerNotification') {// 
            bValid = bValid && JRubriques.checkinput($("#iddestinataire"), " aumoins un destinataire");
            bValid = bValid && JRubriques.checkinput($("#objet"), " l'objet");
            bValid = bValid && JRubriques.checkinput($("#memo"), " le contenu");
            champ = codeunique + "|" + $("#iddestinataire").val() + "|" + $("#objet").val() + "|" + $("#memo").val() + "|" + $("#idexpediteur").val();
            champ += "|" + $("#typenotification").val() + "|" + $("#element").val() + "|" + $("#idelement").val() + "|" + retour;
        }
        if (conf === 'validerPersExterne') { //alert($("#idtypepersonne").val()) 
            bValid = bValid && JRubriques.checkinput($("#nom"), " le nom de la personne");
            bValid = bValid && JRubriques.checkcombo($("#idsexe"), " le sexe");
            bValid = bValid && JRubriques.checkinput($("#telephone"), " le téléphone");
            champ = codeunique + "|" + $("#idtypepersonne").val() + "|" + $("#nom").val() + "|" + $("#prenom").val() + "|" + $("#idsexe").val();
            champ += "|" + $("#societe").val() + "|" + $("#role").val() + "|" + $("#telephone").val() + "|" + $("#email").val() + "|" + $("#adresse").val() + "|" + retour;
        }
        //alert('Merci')
        if (conf === 'validerUtilisateur') {
            bValid = bValid && JRubriques.checkcombo($("#idpersonne"), " la personne");
            if (codeunique === '') {
                if ($("#motdepasse").val() !== $("#motdepasse1").val()) {
                    alert('Confirmation incorrecte');
                    bValid = false;
                }
            }
            idpersonne = $("#idpersonne").val();
            login = $("#login").val();
            motdepasse = $("#motdepasse").val();
        }
        if (conf === 'validerTypepiece') {// alert(conf)
            bValid = bValid && JRubriques.checkcombo($("#naturepiece"), " la nature de la pièce");
            numencours = $("#numencours").val();
            naturepiece = $("#naturepiece").val(); //alert(naturepiece)
            if (document.getElementById("visiblebanque").checked === true)
                visiblebanque = 1;
            if (document.getElementById("visiblecaisse").checked === true)
                visiblecaisse = 1;
            if (document.getElementById("chequevisible").checked === true)
                chequevisible = 1;
            if (document.getElementById("fichedepotvisible").checked === true)
                fichedepotvisible = 1;
        }
        if ((conf !== 'validerparametre') && (conf !== 'validerReinitPW') && (conf !== 'validerPersExterne') && (conf !== 'validerProfilUser') && (conf !== 'validerUtilisateur') && (conf !== 'validerNotification')) {
            bValid = bValid && JRubriques.checkinput($("#libelle"), " le libellé");
            libelle = $("#libelle").val();
        }
//        alert(conf)
//alert(visiblerapport)
        if (bValid) {
            $.get(JRubriques.urlajax, {
                action: conf,
                codeunique: codeunique,
                retour: retour,
                idtypeoperation: idtypeoperation,
                idtypesource: idtypesource,
                naturepiece: naturepiece,
                seuilmin: seuilmin,
                visiblerapport: visiblerapport,
                numencours: numencours,
                visiblebanque: visiblebanque,
                visiblecaisse: visiblecaisse,
                chequevisible: chequevisible,
                fichedepotvisible: fichedepotvisible,
                prefixmatricule: prefixmatricule,
                matriculeencours: matriculeencours,
                idutilisateur: idutilisateur,
                idprofil: idprofil,
                idpersonne: idpersonne,
                login: login,
                motdepasse: motdepasse,
                idmere: idmere,
                niveauvisible: niveauvisible,
                numcompte: numcompte,
                champ: champ,
                libelle: libelle
            }
            , function(data) { //alert(data)
                $("#zoneadd").html(data);
            }
            );
        }
    },
    supprimer: function(codeunique, conf) { //alert(codeunique)
        var retour = '';
        var lib = '';
        switch (conf) {
//            case 'suppRubriques':
//                retour = 'rubriques';
//                lib = 'rubrique';
//                break;

            case 'suppTypepiece':
                retour = 'typepiece';
                lib = 'type de pièce';
                break;

            case 'suppCompte':
                retour = 'compte';
                lib = 'compte';
                break;

            case 'suppDomaineActivite':
                retour = 'domaineactivite';
                lib = 'domaine d\'activité';
                break;


            case 'suppProvenance':
                retour = 'provenance';
                lib = 'provenance';
                break;

            case 'suppSourceoperation':
                retour = 'sourceoperation';
                lib = 'source d\'opération';
                break;
        }
        $("#zonesuppr").dialog({
            title: "Suppression de " + lib,
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    $.get(JRubriques.urlajax, {
                        action: 'suppression',
                        conf: conf,
                        id: codeunique
                    }, function(data) { //alert('M'+data+'N')
                        data = data.replace(/\s/g, "");//alert('M'+data+'N')
                        switch (data) {
                            case '0':
                                JRubriques.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':

                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression effectuée avec succès !.</div>').fadeIn(300);
                                //alert('Merci')
                                $("#zonesuppr").dialog("close");
                                JPrincipal.afficheContenu(0, retour, '', '');
                                break;
                            case '2':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cet élément\nVous ne pouvez donc pas le supprimer.</div>').fadeIn(300).fadeOut(5000);
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
    checkinput: function(o, lib) {
        if (o.val().length === 0) {
            o.addClass("ui-state-error");
            JRubriques.updateTips("<div style=height:30px;>Veuillez renseigner" + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o, lib) {
        if (o.val() === '0') {
            o.addClass("ui-state-error");
            JRubriques.updateTips("<div style=height:30px;>Veuillez sélectionner " + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JRubriques.updateTips(n);
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
    onChangeComboRubriques: function(ln) {
        var n = $("#tailleTabloDetailsRubriques").val();
        for (var i = 1; i <= n; i++) {
            if ((i !== ln) && ($("#idrubrique" + i).val() === $("#idrubrique" + ln).val())) {
                alert('Vous ne pouvez pas choisir la même rubrique plusieurs fois');
                document.getElementById('idrubrique' + ln).value = 0;
                break;
            }
        }
    },
    valeurTabloDetailsRubrique: function() { //alert('Merci Seigneur');        
        var nbre = document.getElementById('tailletablodetailsOp').value;
        var tab = new Array();
        var idop, idrub, montant, ttc;
        for (i = 1; i <= nbre; i++) {
            // alert("#idrubrique" + i + "  "+$("#idrubrique" + i).val());
                var m = $("#montant" + i).val();
                m = m.replace(/\s/g, "");
                
            if (($("#idrubrique" + i).val() !== '0')&& (m !== '0')&& (m !== '')) {
                idrub = $("#idrubrique" + i).val();
                idop = $("#idop" + i).val();
                montant = m;
                ttc = 0;
                if (document.getElementById("ttc" + i).checked === true)
                    ttc = 1;  //alert(idop+ "|"+idrub + "|"+montant+ "|" + ttc);
                tab.push(idop + "|" + idrub + "|" + montant + "|" + ttc);
            }
        }
        return tab;
    },
    valeurTabloChequeOperaton: function() { //alert('Merci Seigneur');        
        var nbre = document.getElementById('tailletablodetailsCP').value;
        var tab = new Array();
        var idbanque, idclient, montant, numcheque;
        for (i = 1; i <= nbre; i++) {
            // alert("#idrubrique" + i + "  "+$("#idrubrique" + i).val());
            if (($("#idbanque" + i).val() !== '0') && ($("#idclient" + i).val() !== '0') && ($("#numcheque" + i).val() !== '')) {
                idbanque = $("#idbanque" + i).val();
                idclient = $("#idclient" + i).val();
                numcheque = $("#numcheque" + i).val();
                var m = $("#montantcheque" + i).val();
                m = m.replace(/\s/g, "");
                montant = m;
                //alert(idop+ "|"+idrub + "|"+montant+ "|" + ttc);
                tab.push(idbanque + "|" + idclient + "|" + numcheque + "|" + montant);
            }
        }
        return tab;
    },
    doublonTabloDetailsRubrique: function() { //alert('Merci Seigneur');        
        var nbre = document.getElementById('tailletablodetailsOp').value;
        var idrub, j;
        var rep = true;
        var msg = '';
        for (i = 1; i <= nbre; i++) {
            if (($("#idrubrique" + i).val() !== '0')) {
                for (j = i + 1; j <= nbre; j++) { //alert($("#idrubrique" + i).val() + '  '+$("#idrubrique" + j).val())
                    if ($("#idrubrique" + i).val() === $("#idrubrique" + j).val())
                        msg += "ligne " + i + " et " + j + " \n";

                }
                idrub = $("#idrubrique" + i).val();

            }
        }
        if (msg !== '') {
            alert('Doublon \n' + msg);
            rep = false;
        }
        return rep;
    }
};