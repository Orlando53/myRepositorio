$('#btn-probar').click(function() {
    $.ajax({
        type: "POST",
        beforeSend: function() {
            dialogLoading('show');
        },
        complete: function() {
            dialogLoading('close');
        },
        success: function(data) {
            window.alert('data');
        }
    });
});