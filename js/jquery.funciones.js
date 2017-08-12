/*!
 * autor:       Orlando Puentes andrade
 * fecha:       julio 06 de 2017
 * objetivo:    declaracion de funciones 
 */
var URL_ACTUAL = URLactual();

function URLactual() {
    var url = "http://" + location.hostname + "/sstplus/";
    return url;
}

function dialogLoading(display) {
    $("#dlgLoading").remove();
    if (display == "show") {
        var dialog = "<div id='dlgLoading' style='text-align:center; z-index:100'><img style='width:100px;position:relative;' src='" + URL_ACTUAL + "media/image/ajaxload.gif' /></div>";
        $(dialog).appendTo("body");
        $("#dlgLoading").dialog({
            modal: true,
            resizable: false,
            closeOnEscape: false,
            width: 100,
            open: function() {
                $(this).prev().children().children().hide();
                //alert($(this).prev().children().children().attr("class"));
            }
        });
    }
}