window.onload = function () {
    $('#login-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'login/login.php',
            type: 'POST',
            data:$('#login-form').serialize(),
            success:function(){
                // Whatever you want to do after the form is successfully submitted
            }
        });
    });
}