/**
 * Ajax action to api rest
*/
function add_habextras(data_id){
    var $ocrendForm = $(this), __data = {};
    $('#form_'+data_id+' input').serializeArray().map(function(x){__data[x.name] = x.value;}); 

    var l = Ladda.create( document.querySelector( '#btn_'+data_id ) );
    l.start();

    if(undefined == $ocrendForm.data('locked') || false == $ocrendForm.data('locked')) {
        $.ajax({
            type : "POST",
            url : "api/habextras/crear",
            dataType: 'json',
            data : __data,
            beforeSend: function(){ 
                $ocrendForm.data('locked', true) 
            },
            success : function(json) {
                emptyErrorSpans();
              
                if(json.success == 1) {
                    success_message(json.message);
                    location.reload();
                } else {
                    error_message(json.message);
                }
            },
            error : function(xhr, status) {
                parseErrors(xhr);
            },
            complete: function(){ 
                $ocrendForm.data('locked', false);
                l.stop();
            } 
        });
    }
} 

/**
 * Events
 */
$('.habextras_add_btn').click(function(e) {
    e.defaultPrevented;
    add_habextras($(this).data('btn-id'));
});
$('.habextras_add_form input').keypress(function(e) {
    e.defaultPrevented;
    if(e.which == 13) {
        add_habextras($(this).data('form-id'));

        return false;
    }
});
