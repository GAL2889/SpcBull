var JOperationfinanciere = {
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
    validerOperationfinanciere: function(codeunique, retour, typevalid) { //alert(typevalid); 
        var idprov = "";
        var etat = 0;
        var paiefraisform = 0;
        var mont = 0;
        var idrub = '';
        var typeop = '';
        var idben = "";
        var chantier = "";
        var commentaire = "";
//        var numcheque = "";
        var numfichedepot = "";
//        var idemetteur = "";
        var tabDetailsRub = new Array(); //new Array();        
        var tabcheqoperation = new Array(); //new Array();
        
        
        if ($("#paiefraisform").val() !== undefined) {
            bValid = bValid && JOperationfinanciere.checkinput($("#montant"), " le montant");
            mont = $("#montant").val();
            idrub = $("#idrubrique").val();
            typeop = "PF";
            paiefraisform = 1;
        }

        if ($("#nature").val() === '1') {
            idprov = $("#idprovenance").val();
            idben = $("#idsource").val();
            chantier = "";
        }
        if ($("#nature").val() === '2') {
            idprov = $("#idsource").val();
            idben = $("#idbeneficiaire").val(); //alert(idben);
            chantier = $("#idchantier").val();
        } //alert(chantier)
//        if ($("#numcheque").val() !== undefined) {
//            numcheque = $("#numcheque").val();
//        }
        if ($("#numfichedepot").val() !== undefined) {
            numfichedepot = $("#numfichedepot").val();
        }
//        if ($("#idemetteur").val() !== undefined) {
//            idemetteur = $("#idemetteur").val();
//        }
        var bValid = true;
        if ($("#numcheque").val() !== undefined) { 
            if($("#numero").val()!==$("#numcheque").val() ){
                alert('Veuillez vérifier le n° de chèque que vous avez saisi');
                bValid = false;
            }        
        } 
        bValid = JPrincipal.verifdt($("#dateoperation").val());
        $('.ui-corner-all').removeClass("ui-state-error");
        bValid = bValid && JOperationfinanciere.checkcombo($("#idsource"), " la source de l'opération ");
//        bValid = bValid && JOperationfinanciere.checkinput($("#idtypeoperation"));
        bValid = bValid && JOperationfinanciere.checkcombo($("#idtypepiece"), " le type de la pièce justificative ");
        if (typevalid === '1') {
            bValid = bValid && JOperationfinanciere.checkinput($("#numero"), " le numéro de la pièce");
            if (paiefraisform === 0) {
                bValid = bValid && JOperationfinanciere.checkcombo($("#idrubrique1"), " la rubrique");
                bValid = bValid && JOperationfinanciere.checkinput($("#montant1"), " le montant de l'opération"); //alert('Merci Seigneur  ' +$("#commentaire").val() )
            }
            bValid = bValid && JOperationfinanciere.checkinput($("#dateoperation"), " la date de l'opération");
            bValid = bValid && JOperationfinanciere.checkinput($("#commentaire"), " le libellé de l'opération");
            commentaire = $("#commentaire").val();
            etat = $("#etat").val();
            if(etat==='9') etat = 0;

        } else {
            commentaire = "OPERATION ANNULEE";
            etat = 9;

        }

        if (paiefraisform === 0) {
            if(typevalid!=='0'){ 
                tabDetailsRub = JRubriques.valeurTabloDetailsRubrique();
            }else{
                tabDetailsRub = new Array('""|""|0|0');
            }
            bValid = bValid && JRubriques.doublonTabloDetailsRubrique();
        } else {
            tabDetailsRub = new Array(codeunique + "|" + idrub + "|" + mont + "|" + 0);
        } //alert('Merci Seigneur Jésus ' + $("#chaquevisible").val()) 
        if($("#chaquevisible").val() ===1){
            tabcheqoperation = JRubriques.valeurTabloChequeOperaton();
        }else{
             tabcheqoperation = new Array('""|""|""|0');
        }
        
//        alert(idprov)
        if (bValid) {
            $.get(JOperationfinanciere.urlajax, {
                action: 'validerOperationfinanciere',
                codeunique: codeunique,
                retour: retour,
                idsource: $("#idsource").val(),
                idtypeoperation: $("#idtypeoperation").val(),
                tabcheqoperation: tabcheqoperation,
                tabDetailsRub: tabDetailsRub,
                dateoperation: $("#dateoperation").val(),
                idtypepiece: $("#idtypepiece").val(),
                numero: $("#numero").val(),
                nature: $("#nature").val(),
                commentaire: commentaire,
                etat: etat,
                paiefraisform: paiefraisform,
                mont: mont,
                idrub: idrub,
                idprovenance: idprov,
                idbeneficiaire: idben,
//                numcheque: numcheque,
                numfichedepot: numfichedepot,
//                idemetteur: idemetteur,
                typevalid: typevalid,
                iddomaine: $("#iddomaine").val(),
                chantier: chantier
            }, function(data) {
//                alert(data);
                $("#zoneadd").html(data);
            }
            );
        }
    },
    validerPF: function(conf) { // alert(conf)
        var nbre = $("#nbreparam").val(); //alert(nbre)
        var j = 0;
            switch(conf){
                case 'validePF':
                    for (i = 1; i <= nbre; i++) {
            if (document.getElementById("chk" + i) !== null) {
                if (document.getElementById("chk" + i).checked === true) {
                    j++;
                }
            }
        }
                    break;
                    
                case 'OFvalide':
                    for (i = 1; i <= nbre; i++) {
            if (document.getElementById("chk" + i) !== null) { 
                if (document.getElementById("chk" + i).checked === false) {
                    j++;
                }
            }
        }
                    break;
            }
//        alert(j)
        var tab = new Array(j);
        var u = 0;
         switch(conf){
                case 'validePF':
                      for (i = 1; i <= nbre; i++) {
            if (document.getElementById("chk" + i) !== null) {
                if (document.getElementById("chk" + i).checked === true) {
                    tab[u] = $("#param" + i).val(); //alert($("#param"+i).val())
                    u++;
                }
            }
        }
                    break;
                    
                case 'OFvalide':
                      for (i = 1; i <= nbre; i++) {
            if (document.getElementById("chk" + i) !== null) {
                if (document.getElementById("chk" + i).checked === false) {
                    tab[u] = $("#param" + i).val(); //alert($("#param"+i).val())
                    u++;
                }
            }
        }
                    break;
            }
      

        var bValid = true;

        if (bValid) {
            $.get(JOperationfinanciere.urlajax, {
                action: 'validerPF',
                conf: conf,
                t: j,
                tab: tab
            }
            , function(data) { //alert(data)
                $("#zoneadd").html(data);
            }
            );
        }
    },
    suppOperationfinanciere: function(id, conf) {
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
                    $.get(JOperationfinanciere.urlajax, {
                        action: 'suppression',
                        conf: 'suppOperationfinanciere',
                        id: id
                    }, function(data) { //alert(data)
                        data = data.replace(/\s/g, "");
                        switch (data) {
                            case '0':
                                JOperationfinanciere.updateTips("<div style=height:30px;>Erreur de connexion</div>");
                                break;
                            case '1':
                                $("#zonesuppr").dialog("close");
                                $("#info").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><h4>Information!</h4>Suppression de la demandetravaux effectuée avec succès !.</div>').fadeIn(300);
                                JPrincipal.afficheContenu(0, conf, '', '');
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
    
    annulerOp: function(codeunique, retour, typevalid) { 
        $("#zoneannuler").dialog({
            title: "ANNULATION D'OPERATION",
            resizable: false,
            height: "auto",
            width: "400",
            modal: true,
            show: 'blind',
            hide: 'explode',
            position: "center",
            buttons: {
                OUI: function() {
                    JOperationfinanciere.validerOperationfinanciere(codeunique, retour, typevalid)
                    $(this).dialog("close");
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
            JOperationfinanciere.updateTips("<div style=height:30px;>Veuillez renseigner " + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o, lib) {//alert(o.val())
        if (o.val() === '0') {
            o.addClass("ui-state-error");
            JOperationfinanciere.updateTips("<div style=height:30px;>Veuillez choisir" + lib + ". SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JOperationfinanciere.updateTips(n);
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
    valeurTabloDetailsOperationfinanciere: function() { //alert('Merci Seigneur');
        var nbre = document.getElementById('tailleTabloDetailsOperationfinanciere').value;
        var j = 0;
        for (i = 1; i <= nbre; i++) { //alert($("#idIndic" + i).val());
            if (($("#iddemandetravaux" + i).val() !== '0'))
                j++;
        }
        var tabDetailsOperationfinanciere = new Array(j);
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
                tabDetailsOperationfinanciere[t] = iddetailcas + "|" + iddemandetravaux + "|" + montant;
                t++;
            }
        }
        return tabDetailsOperationfinanciere;
    },
    
    actualiseNumPiece: function(param) {//alert('Merci')
       var  tparam = param.split('|');
       var codeunique = tparam[0];
       var conf = tparam[1];
        $.get(JOperationfinanciere.urlajax, {
            action: "actualiseNumPiece",
            codeunique: codeunique,
            conf: conf,
            idtypepiece: $("#idtypepiece").val()
        }, function(data) {// alert(data)
            $("#zoneadd").html(data);

        }
        );
    },
    
    autrecheque: function() {//alert(conf)
        $.get(JOperationfinanciere.urlajax, {
            action: "autrecheque",
            idtypepiece: $("#idtypepiece").val()
        }, function(data) {
            $("#zoneadd").html(data);

        }
        );
    },
    onChangeCmbSource: function(typesource, conf) {//alert(conf)
        var libconf = '';
        switch (conf) {
            case 1:
                libconf = 'opentreeB';
                break;
            case 2:
                libconf = 'opentreeC';
                break;
            case 3:
                libconf = 'opsortieB';
                break;
            case 4:
                libconf = 'opsortieC';
                break;
            case 5:
                libconf = 'addopentreeB';
                break;
            case 6:
                libconf = 'addopentreeC';
                break;
            case 7:
                libconf = 'addopsortieB';
                break;
            case 8:
                libconf = 'addopsortieC';
                break;
            case 9:
                libconf = 'editopentreeB';
                break;
            case 10:
                libconf = 'editopentreeC';
                break;
            case 11:
                libconf = 'editopsortieB';
                break;
            case 12:
                libconf = 'editopsortieC';
                break;
            case 13:
                libconf = 'pointcaisse';
                break;
            case 14:
                libconf = 'pointbanque';
                break;
            case 15:
                libconf = 'validePF';
                break;
            case 16:
                libconf = 'paiefraisform';
                break;
            case 17:
                libconf = 'OFvalide';
                break;
        } //alert(conf)
        $.get(JOperationfinanciere.urlajax, {
            action: "onChangeCmbSource",
            conf: libconf,
            typesource: typesource,
            idsource: $("#idsource").val()


        }, function(data) { //alert(data);
            $("#zoneListeSite").html(data);
          appliqueDataTable();
            appliqueChosen();
//            appliqueDateDebuFinPicker();
        }
        );
    }
};