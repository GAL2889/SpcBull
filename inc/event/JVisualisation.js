var JVisualisation = {
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
    refreshTableSite: function() {
        $.ajaxSetup({
            async: false
        });
        document.getElementById("loading").style.visibility = "visible";
        $.get(JVisualisation.urlajax, {
            action: 'getAllBudget'
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
        if (o.val().length === 0) {
            o.addClass("ui-state-error");
            JVisualisation.updateTips("<div class='alert'>Veuillez remplir ce champ. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkcombo: function(o) {
        if (o.val() === 0) {
            o.addClass("ui-state-error");
            JVisualisation.updateTips("<div class='alert'>Veuillez effectuer un choix. SVP!</div>");
            return false;
        } else {
            return true;
        }
    },
    checkRegexp: function(o, regexp, n) {
        if (!(regexp.test(o.val()))) {
            o.addClass("ui-state-error");
            JVisualisation.updateTips("<div class='alert'>" + n + "</div>");
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
    imprimer: function(conf) { //alert(conf)
        $.get(JVisualisation.urlajax, {
            action: 'getImpressionPDF',
            conf: conf
        }, function(data) { //alert(data);
            $("#zoneadd").html(data);
        }
        );
    },
    imprimerLigne: function(conf,id) { //alert(conf)
        $.get(JVisualisation.urlajax, {
            action: 'getImpressionPDF',
            conf: conf,
            id:id
        }, function(data) { //alert(data)
            $("#zoneadd").html(data);
        }
        );
    },
    exportexcel: function(conf) { //alert(conf)
        $.get(JVisualisation.urlajax, {
            action: 'getExportExcel',
            conf: conf
        }, function(data) { //alert(data)
            $("#zoneadd").html(data);
        }
        );
    },
    imprimerLettre: function(conf, idlot) { //alert(conf)
        $.get(JVisualisation.urlajax, {
            action: 'getImpressionPDF',
            conf: conf,
            idlot: idlot
        }, function(data) { //alert(data)
            $("#zoneListeSite").html(data);
        }
        );
    }
};