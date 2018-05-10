/* 
 Created on : 20/03/2014, 10:08:45 AM
 Author     : Andres
 */



$(document).ready(function() {

// <editor-fold defaultstate="collapsed" desc="Forms">

    handleAjaxForm = function(formId) {
        $("#" + formId).ajaxForm({
            dataType: "json",
            beforeSubmit: function(arr, $form, options) {
                if ($form.attr("confirmation")) {
                    if (!confirm($form.attr("confirmation"))) {
                        return false;
                    }
                }
                $(this).attr('wait_id', waiting(null));
            },
            resetForm: false,
            uploadProgress: function(event, position, total, percentComplete) {

            },
            success: function(response, status, xhr, $form) {
                if (status === "success") {
                    if (response.success === true) {
                        success(response.content, $form.attr("post_success") || null);
                        if (!$form.attr("post_success")) {
                            $($form)[0].reset();
                        }
                    } else {
                        fail(response.content, $form.attr("post_fail") || null);
                    }
                } else {
                    fail('Se produjo un error inesperado.', null);
                }
            },
            error: function() {
                fail('Se produjo un error inesperado.', null);
            },
            complete: function(response) {
                waiting($(this).attr('wait_id'));
                $(this).attr('wait_id', null);
            }
        });
    };

    handleAjaxQueryForm = function(resultForm) {
        $("#" + resultForm).ajaxForm({
            dataType: "json",
            beforeSubmit: function(arr, $form, options) {
                $("#" + resultForm + "_waiting").show();
            },
            resetForm: false,
            success: function(response, status, xhr, $form) {
                if (status === "success") {
                    if (response.success === true) {
                        $("#" + resultForm + "_table tbody").html(response.content);
                    } else {
                        fail(response.content, null);
                    }
                } else {
                    fail('Se produjo un error inesperado.', null);
                }
            },
            error: function() {
                fail('Se produjo un error inesperado.', null);
            },
            complete: function(response) {
                $("#" + resultForm + "_waiting").hide();
            }
        });
    };

    // </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Dialogs">

    htmlDialog = function(title, body) {
        var id = "tmp_html_dialog_" + new Date().getTime();
        element = "<div style='display: none;' id='" + id + "' title='" + title + "' oldPageTitle='" + $("title").text() + "'>" + body + "</div>";
        $("body").append(element);
        $('#' + id).dialog({
            title: title,
            closeText: "Cerrar ventana",
            modal: true,
            width: "70%",
            minWidth: "70%",
            maxWidth: "95%",
            height: "auto",
            open: function(event, ui) {
                $("title").text($("title").attr("title") + ' [' + title + ']');
            },
            beforeClose: function(event, ui) {
                $(this).remove();
            },
            close: function(event, ui) {
                $("title").text($(this).attr('oldPageTitle'));
            }
        });
    };

    success = function(msg, postAction) {
        var id = "tmp_success_dialog_" + new Date().getTime();
        element = "<div style='display: none' id='" + id + "' title='Exito'>\
                    <p><span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span>"
                + msg +
                "</p>\
                   </div>";
        $("body").append(element);
        $('#' + id).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            },
            beforeClose: function(event, ui) {
                $(this).remove();
                if (postAction !== null) {
                    if ((typeof postAction) === 'string') {
                        $.globalEval(postAction);
                    } else {
                        postAction();
                    }
                }
            }
        });
    };

    fail = function(msg, postAction) {
        var id = "tmp_fail_dialog_" + new Date().getTime();
        element = "<div style='display: none' id='" + id + "' title='Error'>\
                    <p><span class='ui-icon ui-icon-circle-close' style='float:left; margin:0 7px 50px 0;'></span>"
                + msg +
                "</p>\
                   </div>";
        $("body").append(element);
        $('#' + id).dialog({
            dialogClass: "no-close",
            modal: true,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            },
            beforeClose: function(event, ui) {
                $(this).remove();
                if (postAction !== null) {
                    if ((typeof postAction) === 'string') {
                        $.globalEval(postAction);
                    } else {
                        postAction();
                    }
                }
            }
        });
    };

    confirmation = function(msg, yesAction) {
        var id = "tmp_fail_dialog_" + new Date().getTime();
        element = "<div style='display: none' id='" + id + "' title='Pregunta'>\
                    <p><span class='ui-icon ui-icon-help' style='float:left; margin:0 7px 50px 0;'></span>"
                + msg +
                "</p>\
                   </div>";
        $("body").append(element);
        $('#' + id).dialog({
            modal: true,
            buttons: {
                Si: function() {
                    $(this).dialog("close");
                    if (yesAction !== null) {
                        yesAction();
                    }
                },
                No: function() {
                    $(this).dialog("close");
                }

            },
            beforeClose: function(event, ui) {
                $(this).remove();
            }
        });
    };

    alert_ = function(msg, postAction) {
        var id = "tmp_alert_dialog_" + new Date().getTime();
        element = "<div style='display: none' id='" + id + "' title='Alerta'>\
                    <p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 50px 0;'></span>"
                + msg +
                "</p>\
                   </div>";
        $("body").append(element);
        $('#' + id).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $(this).dialog("close");
                }
            },
            beforeClose: function(event, ui) {
                $(this).remove();
                if (postAction !== null) {
                    if ((typeof postAction) === 'string') {
                        $.globalEval(postAction);
                    } else {
                        postAction();
                    }
                }
            }
        });
    };

    waiting = function(waitId) {
        if (waitId === null) {
            var _id_ = "tmp_waiting_dialog_" + new Date().getTime();
            element = "<div style='display: none' id='" + _id_ + "' title='Procesando'><br/> <span class='waiting'>&nbsp;</span></div>";
            $("body").append(element);
            $('#' + _id_).dialog({
                modal: true,
                closeOnEscape: false,
                dialogClass: "no-close"
            });
            return _id_;
        } else {
            $('#' + waitId).dialog("close");
            $("#" + waitId).remove();
        }
    };

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Document">

    onbeforeunload = function() {
        if ($("body").attr("silentclose") === "false") {
            return "Los cambios no guardados se perderan.."
        }
    };

// <editor-fold defaultstate="collapsed" desc="Creating and handling menu,actions and tabs">

    $("#bottomRightPannel").tabs({
        activate: function(event, ui) {
            $("title").text($("title").attr("title") + ' [' + ui.newTab.context.innerHTML + ']');
        }
    });

    $(document).on("click", "[finalAction='true']", function() {
        var _token_ = $(this).attr('token');
        var _value_ = $(this).attr('value') ? $(this).attr('value') : '';

        var _waiting_ = waiting(null);
        $.post(".", {token: _token_, value: _value_}, function(data, status) {
            waiting(_waiting_);
            if (status === 'success') {
                var result = $.parseJSON(data);
                if (result.success === true) {
                    if (result.foregroundRunMode === 'tab') {
                        var tab_a = "#tab_a_" + _token_;
                        if ($(tab_a).length <= 0) {
                            $("#tabNames").append(result.title);
                            $("#bottomRightPannel").append(result.body);
                            $("#bottomRightPannel").tabs("refresh");
                        }
                        $(tab_a).click();
                    } else if(result.foregroundRunMode === 'dialog') {
                        htmlDialog(result.title, result.body);
                    }
                } else {
                    fail(result.content, null);
                }
            } else {
                fail('Se produjo un error inesperado.', null);
            }
        });
    });

    $("#bottomRightPannel").delegate("span.ui-icon-close", "click", function() {
        var panelId = $(this).closest("li").remove().attr("aria-controls");
        $("#" + panelId).remove();
        $("#bottomRightPannel").tabs("refresh");
//        $("title").text('SIRS');
    });

    $("#bottomRightPannel").bind("keyup", function(event) {
        if (event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE) {
            var panelId = tabs.find(".ui-tabs-active").remove().attr("aria-controls");
            $("#" + panelId).remove();
            $("#bottomRightPannel").tabs("refresh");
//            $("title").text('SIRS');
        }
    });

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Creating and handling user options">

    $("#userName").click(function() {
        $("#userMenu").dialog({
            title: $(this).attr("title"),
            modal: true,
            resizable: false
        });
    });

    handleAjaxForm("logoutForm");

    if ($("#forcedLogOut").length > 0) {
        alert_($("#forcedLogOut").attr('info'), function() {
            $("#logoutForm").submit()
        });
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Handling styles">

    handleButtonStyles = function() {
        $("button[type=submit][class=submit]").button({
            icons: {primary: "ui-icon-check"},
            text: true
        });
        $("button[type=submit][class=delete]").button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });
        $("button[type=submit][class=edit]").button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });
        $("button[type=submit][class=refresh]").button({
            icons: {primary: "ui-icon-refresh"},
            text: false
        });
        $("button[type=submit][class=search]").button({
            icons: {primary: "ui-icon-search"},
            text: false
        });
        $("button[type=reset][class=reset]").button({
            icons: {primary: "ui-icon-cancel"},
            text: true
        });
        $("button[type=submit][class=print]").button({
            icons: {primary: "ui-icon-print"},
            text: true
        });
        $("button[type=submit][class=new]").button({
            icons: {primary: "ui-icon-document"},
            text: false
        });
    };

    handleButtonStyles();
// </editor-fold>

// </editor-fold>

});
