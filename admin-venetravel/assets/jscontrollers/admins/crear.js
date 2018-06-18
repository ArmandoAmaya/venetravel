/**
 * Ajax action to api rest
*/
function admins(){
    var $ocrendForm = $(this), __data = {};
    $('#admins_form').serializeArray().map(function(x){__data[x.name] = x.value;}); 

    var l = Ladda.create( document.querySelector( '#admins_btn' ) );
    l.start();

    if(undefined == $ocrendForm.data('locked') || false == $ocrendForm.data('locked')) {
        $.ajax({
            type : "POST",
            url : "api/admins/crear",
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
$('#admins_btn').click(function(e) {
    e.defaultPrevented;
    admins();
});
$('form#admins_form input').keypress(function(e) {
    e.defaultPrevented;
    if(e.which == 13) {
        admins();

        return false;
    }
});
