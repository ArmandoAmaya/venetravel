/**
 * Ajax action to api rest
*/
function login() {
    var $ocrendForm = $(this), __data = {};
    $('#login_form').serializeArray().map(function(x){__data[x.name] = x.value;}); 

    var l = Ladda.create( document.querySelector( '#login_btn' ) );
    l.start();

    if(undefined == $ocrendForm.data('locked') || false == $ocrendForm.data('locked')) {
        $.ajax({
            type : 'POST',
            url : 'api/login',
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
$('#login_btn').click(function(e) {
    e.defaultPrevented;
    login();
});
$('form#login_form input').keypress(function(e) {
    e.defaultPrevented;
    if(e.which == 13) {
        login();

        return false;
    }
});