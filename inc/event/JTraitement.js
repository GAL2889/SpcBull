/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var JTraitement = {
    urlajax: 'ajax/ajaxIncludeForm.php',
    cocherTout: function() {
        var nb = $("#nbreparam").val();
        for (var i = 1; i <= nb; i++)
        {
            if (document.getElementById("chk" + i) !== null) {
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
    actualiseCadence: function(chp) {
        $('.ui-corner-all').removeClass("ui-state-error");
        var duree = parseFloat($("#dureepose").val());
        var qte = parseFloat($("#qtepose").val());
        var tp = parseFloat($("#tempspose").val());
        switch (chp) {
            case 'dureepose':
            case 'qtepose':
                tp = (qte > 0) ? duree / qte : 1;
                document.getElementById("tempspose").value = tp;
                break;
            case 'tempspose':
                document.getElementById("dureepose").value = 0;
                document.getElementById("qtepose").value = 0;
                break;
        }
        JTraitement.actualisetarif('H');
    },
    actualisetarif: function(type) {
        $('.ui-corner-all').removeClass("ui-state-error");
        var tva = parseFloat($("#tva").val());
        var pamod = parseFloat($("#prixachatmod").val());
        var fraismat = parseFloat($("#fraismat").val());
        var fraismod = parseFloat($("#fraismod").val());
        var benemat = parseFloat($("#beneficemat").val());
        var benemod = parseFloat($("#beneficemod").val());
        var tp = parseFloat($("#tempspose").val());
        var pamat = 0;
        var ttc = 0;
        var totpa = 0;
        var revmat = 0;
        var pvmat = 0;
        var revmod = pamod * (1 + fraismod / 100);
        var pvmod = revmod * (1 + benemod / 100);
        var totpr = 0;
        var fraisgene = 0;
        var totpvht = 0;
        var benegene = 0;



        switch (type) {
            case 'H':
                pamat = parseFloat($("#prixachatmat").val());
                revmat = pamat * (1 + fraismat / 100);
                pvmat = revmat * (1 + benemat / 100);
                totpvht = pvmat + (pvmod * tp);
                ttc = (totpvht * (1 + (tva / 100)));
                break;
            case 'T':
                ttc = parseFloat($("#totalttc").val());
                totpvht = (ttc > 0) ? (ttc / (1 + (tva / 100))) : 0;
                pvmat = totpvht - (pvmod * tp);
                revmat = (pvmat > 0) ? (pvmat / (1 + (benemat / 100))) : 0;
                pamat = (revmat > 0) ? (revmat / (1 + (fraismat / 100))) : 0;
                break;
        }
        //Val calculée
//        var pmatc = (pamat===0)?fraismat:pamat;
        totpa = pamat + (pamod * tp);
        totpr = revmat + (revmod * tp);
//        if(totpa ===0) totpa = 1;
//        if(totpr ===0) totpr = 1;
        fraisgene = ((((totpa > 0) ? ((totpr / totpa)) : 0) - 1) * 100);
        benegene = ((((totpr > 0) ? ((totpvht / totpr)) : 0) - 1) * 100);
        if ((fraisgene <= 0) || (benegene <= 0)) {
            var pmatc = 1;
            var pmodc = 1;
            var revmatc = pmatc * (1 + fraismat / 100);
            var totpac = pmatc + (pmodc * tp);
            var revmodc = pmodc * (1 + fraismod / 100);
            var totprc = revmatc + (revmodc * tp);
            var pvmatc = revmatc * (1 + benemat / 100);
            var pvmodc = revmodc * (1 + benemod / 100);
            var totpvhtc = pvmatc + (pvmodc * tp);
            fraisgene = ((((totpac > 0) ? ((totprc / totpac)) : 0) - 1) * 100);
            benegene = ((((totprc > 0) ? ((totpvhtc / totprc)) : 0) - 1) * 100);
        } //alert(fraisgene)
        document.getElementById("totPA").value = Math.round(totpa * 100) / 100;
        document.getElementById("fraisgene").value = Math.round(fraisgene * 100) / 100;
        document.getElementById("revMat").value = Math.round(revmat * 100) / 100;
        document.getElementById("revMod").value = Math.round(revmod * 100) / 100;
        document.getElementById("totPR").value = Math.round(totpr * 100) / 100;
        document.getElementById("PVhtMat").value = Math.round(pvmat * 100) / 100;
        document.getElementById("PVhtMod").value = Math.round(pvmod * 100) / 100;
        document.getElementById("totPVht").value = Math.round(totpvht * 100) / 100;
        document.getElementById("beneficegene").value = Math.round(benegene * 100) / 100;
        document.getElementById("totalttc").value = Math.round(ttc * 100) / 100;
        document.getElementById("prixachatmat").value = Math.round(pamat * 100) / 100;
        document.getElementById("prixachatmod").value = Math.round(pamod * 100) / 100;

    },
    validerPersonne: function(id) {
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JTraitement.checkinput($("#nom"), 'le nom');
        bValid = bValid && JTraitement.checkinput($("#prenom"), 'le prénom');
        bValid = bValid && JTraitement.checkcombo($("#idsexe"), 'le sexe');
        //        bValid = bValid && JTraitement.checkcombo($("#idsituationmatri"),'la situation matrimoniale');
        bValid = bValid && JTraitement.checkcombo($("#idcorps"), 'le corps de la personne');


        if (bValid) {
            $("#formaddeditPersonne").submit();
        }

    },
    valider: function(codeunique, ret) { //alert(ret)
        var tr = ret.split('|');
        var retour = tr[0];
        var bValid = true;
        $('.ui-corner-all').removeClass("ui-state-error");
        var champ = "";
        var photo = "";
        var photobd = "";
        switch (retour) {
            case 'acteurs':
                //controle des champs obligatoire
                bValid = bValid && JTraitement.checkinput($("#designation"), "la désignation");
                bValid = bValid && JTraitement.checkinput($("#perscontact"), "la personne à contacter");
                bValid = bValid && JTraitement.checkinput($("#adresse"), "l'adresse de l'acteur");
                bValid = bValid && JTraitement.checkinput($("#telephone"), "le telephone de l'acteur");
                //liste des champs à retourner
                champ = $("#designation").val() + "|" + $("#perscontact").val() + "|" + $("#adresse").val() + "|" + $("#telephone").val();

                break;
            case 'bureauechange': //alert('Merci')
                //controle des champs obligatoire
                bValid = bValid && JTraitement.checkinput($("#designation"), "la désignation");
                bValid = bValid && JTraitement.checkcombo($("#idlocalite"), "la localite");
                //liste des champs à retourner
                champ = $("#designation").val() + "|" + $("#idlocalite").val();
            case 'elementscp': //alert('Merci')
                //controle des champs obligatoire
                bValid = bValid && JTraitement.checkinput($("#designation"), "la désignation");
                bValid = bValid && JTraitement.checkcombo($("#idtypeelement"), " le type element");
                //liste des champs à retourner
                champ = $("#designation").val() + "|" + $("#idtypeelement").val();

                break;
            case 'actionnonlivraison': //alert('Merci')
                //controle des champs obligatoire
                bValid = bValid && JTraitement.checkinput($("#libelle"), "le libellé");
                bValid = bValid && JTraitement.checkinput($("#complement"), "le complément");
                bValid = bValid && JTraitement.checkcombo($("#typeactionnonlivraison"), " le type actionnonlivraison");
                //liste des champs à retourner
                champ = $("#libelle").val() + "|" + $("#complement").val() + "|" + $("#typeactionnonlivraison").val();

                break;
            case 'expedition': //alert('Merci')
                //controle des champs obligatoire
                var ong = (tr.length > 1) ? tr[1] : 1;
                bValid = bValid && JTraitement.checkinput($("#numelement"), "le Numéro du coli");
                bValid = bValid && JTraitement.checkcombo($("#idpaysorigine"), " le pays d'origine");
                bValid = bValid && JTraitement.checkcombo($("#idpaysdestion"), " le pays de destination");
                bValid = bValid && JTraitement.checkcombo($("#idbureauechange"), " le bureau d'échange");
                bValid = bValid && JTraitement.checkcombo($("#idexpediteur"), " Sélectionner l'expéditeur");
                bValid = bValid && JTraitement.checkcombo($("#iddestinataire"), " Sélectionner le destinataire");
                bValid = bValid && JTraitement.checkcombo($("#voieacheminement"), " Sélectionner la voie d'acheminement");
                champ = $("#dateexpedition").val() + "|" + $("#numelement").val() + "|" + $("#idpaysorigine").val();
                champ += "|" + $("#idpaysdestion").val() + "|" + $("#idbureauechange").val() + "|" + $("#idexpediteur").val();
                champ += "|" + $("#iddestinataire").val() + "|" + $("#voieacheminement").val() + "|" + $("#poids").val();
                champ += "|" + $("#valeurdeclaree").val() + "|" + $("#declarationdouaniere").val() + "|" + $("#certificatoufacture").val();
                champ += "|" + $("#montantremboursement").val() + "|" + $("#taxepercue").val() + "|" + $("#numccp").val();
                champ += "|" + $("#titulaireccp").val() + "|" + $("#idbureauccp").val() + "|" + $("#idlieuccp").val();
//                alert($("#compltactionnonlivraison").val());
                champ += "|" + $("#idactionlivraison").val() + "|" + ong;
                if($("#voieactionnonlivraison").val()!==undefined) champ += "|" + $("#voieactionnonlivraison").val();
                if($("#compltactionnonlivraison").val()!==undefined) champ += "|" + $("#compltactionnonlivraison").val();
                

                break;
            case 'scp': //alert('Merci')
                //controle des champs obligatoire
                // var ong = (tr.length >1)?tr[1]:1;
//                bValid = bValid && JTraitement.checkinput($("#numordre"), "le Numéro d'ordre");
                bValid = bValid && JTraitement.checkinput($("#numcolis"), "le Numéro de colis");//alert('Merci')
                bValid = bValid && JTraitement.checkcombo($("#idpaysorigine"), " le pays d'origine");
                bValid = bValid && JTraitement.checkcombo($("#idexpediteur"), " Sélectionner l'expéditeur");
                bValid = bValid && JTraitement.checkcombo($("#iddestinataire"), " Sélectionner le destinataire");
                bValid = bValid && JTraitement.checkinput($("#montantremboursement"), "Montant remboursement");
                bValid = bValid && JTraitement.checkinput($("#droitfixe"), "Le droit fixe");
                bValid = bValid && JTraitement.checkinput($("#taxetransportinterieur"), "Taxes de transport à l'intérieur");
                bValid = bValid && JTraitement.checkinput($("#droitdouane"), "Droit de douane");
                bValid = bValid && JTraitement.checkinput($("#montantavis"), "Montant de la présente d'avis");


                champ = $("#datescp").val() + "|" + $("#numordre").val() + "|" + $("#numcolis").val();
                champ += "|" + $("#idpaysorigine").val() + "|" + $("#idexpediteur").val() + "|" + $("#iddestinataire").val();
                champ += "|" + $("#montantremboursement").val() + "|" + $("#droitfixe").val() + "|" + $("#taxetransportinterieur").val();
                champ += "|" + $("#droitdouane").val() + "|" + $("#montantavis").val();

                alert(champ);
                break;


        }


        if (bValid) {
            $.get(JTraitement.urlajax, {
                action: 'validerTraitement',
                codeunique: codeunique,
                retour: retour,
//                photobd: photobd,
//                phot: $("#photo").val(),
                champ: champ

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
        var idret = '';
        switch (conf) {
            case 'supprmodereglement':
                retour = 'modereglement';
                lib = 'mode de règlement';
                break;

            case 'suppRubriques':
                retour = 'rubriques';
                lib = 'rubrique';
                break;

            case 'supprelementccial':
                retour = 'elementcommercial';
                lib = 'élément commercial';
                break;

            case 'supprbanque':
                retour = 'banque';
                lib = 'banque';
                break;
            case 'supprparamcomptelt':
                retour = 'paramcomptelt';
                lib = 'Paramétrage de N° de compte pour les éléments';
                break;
            case 'supprcivilite':
                retour = 'civilite';
                lib = 'civilité';
                break;

            case 'supprunite':
                retour = 'unite';
                lib = 'unité';
                break;

            case 'suppConditionReglement':
                retour = 'conditionreglement';
                lib = 'condition de règlement';
                break;

            case 'suppDepot':
                retour = 'depot';
                lib = 'dépôt';
                break;

            case 'suppTaxe':
                retour = 'taxe';
                lib = 'taxe';
                break;

            case 'suppRepresentant':
                retour = 'representant';
                lib = 'représentant';
                break;

            case 'supprpromotion':
                retour = 'promotion';
                lib = 'promotion';
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
                    $.get(JTraitement.urlajax, {
                        action: 'suppression',
                        conf: conf,
                        id: codeunique
                    }, function(data) {
                        data = data.replace(/\s/g, "");
// alert('M'+data +'N')

                        if (data == '1') {
//     alert('Merci')
                        }
                        switch (data) {
                            case '0':
                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Erreur de connexion</div>').fadeIn(300);
                                JTraitement.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
//                            case 1: 

                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression effectuée avec succès !.</div>').fadeIn(300).fadeOut(2000);
                                $("#zonesuppr").dialog("close");
                                JPrincipal.afficheContenu(idret, retour, '', '');
                                break;
                            case '3':

                                $("#info").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Il existe au moins un enregistrement lié à cet élément <br>Vous ne pouvez donc pas le supprimer.</div>').fadeIn(300);
                                $("#zonesuppr").dialog("close");
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
    checkinput: function(o, lib) { //alert(o.val().length );
        if (o.val().length === 0) {
            o.addClass("ui-state-error");
            JTraitement.updateTips("<div style=height:30px;>Veuillez renseigner " + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o, lib) {
        if (o.val() === '0') {
            o.addClass("ui-state-error");
            JTraitement.updateTips("<div style=height:30px;>Veuillez sélectionner " + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JTraitement.updateTips(n);
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
//    merci: function() {
//       alert('Merci ');
//    },
    onChangeComboAnnee: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboAnnee",
            conf: conf,
            idannee: $("#idannee").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboActionnonlivraison: function() {
        var ret = $("#ret4").val();
        var rt = ret.split('|');
        var conf = rt[0];
        var ong = rt[1];
        var id = rt[2];
        $.get(JTraitement.urlajax, {
            action: "onChangeComboActionnonlivraison",
            conf: conf,
            ong: ong,
            id: id,
            idactionlivraison: $("#idactionlivraison").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboTva: function(conf) { //alert(conf)
        var cf = "";
        switch (conf) {
            case 1:
                cf = "majelementccial";
                break;
        }
        $.get(JTraitement.urlajax, {
            action: "onChangeComboTva",
            conf: cf,
            idtva: $("#idtva").val()

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);
            //            appliqueDataTable();
            //            appliqueChosen();
        }
        );
    },
    actualisezoneLieuMvt: function(conf, id) { //alert(conf)
        var val = $("#datemvt").val() + "|" + $("#idelementccial").val() + "|" + $("#mesure").val() + "|";
        val += $("#idunitemesure").val() + "|" + $("#nbrelt").val() + "|" + $("#categmvt").val() + "|";
        val += $("#description").val() + "|" + $("#idtypelieuP").val() + "|" + $("#idtypelieuD").val() + "|";
        val += $("#idlieuP").val() + "|" + $("#idlieuD").val() + "|" + $("#idexecutantP").val() + "|" + $("#idexecutantD").val() + "|" + $("#commentaire").val();
        // alert(val);
        $.get(JTraitement.urlajax, {
            action: "actualisezoneLieuMvt",
            conf: conf,
            id: id,
            val: val
        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeTypeelementccial: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeTypeelementccial",
            conf: conf,
            idtypeeltccial: $("#idtypeeltccial").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangetab: function() {
        $('#myTab a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    },
    onChangeContact: function() { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeContact",
            //            conf: conf,
            idtypeacteur: $("#idtypeacteur").val(),
            idcontact1: $("#idcontact1").val(),
            idcontact2: $("#idcontact2").val()

        }, function(data) { //alert(data);
            $("#zoneinfocontact").html(data);
            //            JPrincipal.appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeProjet: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeProjet",
            conf: conf,
            idprojet: $("#idprojet").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboLocalite: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboLocalite",
            conf: conf,
            idlocalite: $("#idlocalite").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboPhase: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboPhase",
            conf: conf,
            idphase: $("#idphase").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboActivite: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboActivite",
            conf: conf,
            idactivite: $("#idactivite").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboTache: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboTache",
            conf: conf,
            idtache: $("#idtache").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboSession: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboSession",
            conf: conf,
            idsession: $("#idsession").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    onChangeComboCorps: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboCorps",
            conf: conf,
            idcorps: $("#idcorps").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    },
    actualiseDemandeur: function(conf) {
        var infodevis = $("#numdevis").val() + "|" + $("#datedevis").val() + "|" + $("#datelivraison").val();
        infodevis += "|" + $("#idetat").val() + "|" + $("#iddemandetravaux").val() + "|" + $("#commentaire").val();
        infodevis += "|" + $("#description").val() + "|" + $("#idcondreglt").val() + "|" + $("#iddepot").val();
        infodevis += "|" + $("#idrepresentant").val() + "|" + $("#reference").val() + "|" + $("#iddepot").val();

        $.get(JTraitement.urlajax, {
            action: "actualiseDemandeur",
            infodevis: infodevis,
            conf: conf,
            id: $("#id").val(),
            iddemandetravaux: $("#iddemandetravaux").val()

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);

        }
        );
    },
    actualiseEltccial: function() {

        $.get(JTraitement.urlajax, {
            action: "actualiseEltccial",
            idelementccial: $("#idelementccial").val()

        }, function(data) { //alert(data);
            $("#zoneaddetail").html(data);

        }
        );
    },
    actualiseDescription: function() {

        $.get(JTraitement.urlajax, {
            action: "actualiseDescription",
            resume: $("#resume").val()

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);

        }
        );
    },
    actualiseCompte: function() {

        $.get(JTraitement.urlajax, {
            action: "actualiseCompte",
            idtypeeltccial: $("#idtypeeltccial").val(),
            idfamille: $("#idfamille").val()

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);

        }
        );
    },
    actualiseParamFamille: function() { //alert('Merci')

        $.get(JTraitement.urlajax, {
            action: "actualiseParamFamille",
            idtypeeltccial: $("#idtypeeltccial").val(),
            idfamille: $("#idfamille").val()

        }, function(data) { //alert(data);
            $("#zoneadd").html(data);

        }
        );
    },
    actualiseTotal: function() {

        $.get(JTraitement.urlajax, {
            action: "actualiseTotal",
            quantite: $("#quantite").val(),
            remise: $("#remise").val(),
            idtva: $("#idtva").val(),
            idelementccial: $("#idelementccial").val()

        }, function(data) { //alert(data);
            $("#zoneaddetail").html(data);

        }
        );
    },
    onChangeComboNiveauIndicateur: function(conf) { //alert(conf)
        $.get(JTraitement.urlajax, {
            action: "onChangeComboNiveauIndicateur",
            conf: conf,
            idniveauindicateur: $("#idniveauindicateur").val()

        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
            appliqueDataTable();
            appliqueChosen();
        }
        );
    }
};