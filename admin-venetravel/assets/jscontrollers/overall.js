function emptyErrorSpans() {
    $('.error-message').html('');
}
function parseErrors(xhr) {
    emptyErrorSpans();
    
    var object = xhr.responseJSON;
    if(Object.keys(object).length) {
        $.each(object.errors, function( index, validator ) {
            $('span[pm-name="' + index + '"]').html(validator[0]);
        });
    } else {
        error_message('Internal problem');
    }
}
function error_message(message) {
    $.bootstrapGrowl(message, {
        ele: 'body', 
        type: 'danger', // (null, 'info', 'danger', 'success')
        offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
        align: 'right', // ('left', 'right', or 'center')
        width: 250, // (integer, or 'auto')
        delay: 2000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
        allow_dismiss: false, // If true then will display a cross to close the popup.
        stackup_spacing: 10 // spacing between consecutively stacked growls.
    });
}

function success_message(message) {
    $.bootstrapGrowl(message, {
        ele: 'body', 
        type: 'success', // (null, 'info', 'danger', 'success')
        offset: {from: 'top', amount: 20}, // 'top', or 'bottom'
        align: 'right', // ('left', 'right', or 'center')
        width: 250, // (integer, or 'auto')
        delay: 2000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
        allow_dismiss: false, // If true then will display a cross to close the popup.
        stackup_spacing: 10 // spacing between consecutively stacked growls.
    });
}

function deleteElement(controller, id) {
    swal({
        title: 'Eliminar este elemento',
        text: '¿Seguro que deseas eliminar este elemento?',
        type: 'error',
        showCancelButton: true,
        cancelButtonColor: '#666666',
        cancelButtonText: 'No, Cancelar',
        confirmButtonColor: '#1a3652',
        confirmButtonText: 'Si, Eliminar'
    }).then(function(res) {
        
        if (true == res.value) {

            window.location.href = controller +'/eliminar/'+id;
            
            swal({
                title: 'Eliminado',
                text: 'Eliminado de forma exitosa.',
                type: 'success',
                confirmButtonColor: '#1a3652',
                confirmButtonText: 'Ok, Cerrar'
            }).then(function() {},
            function(dismiss) {});
            
        }
        

    }, function(dismiss) {});    
}