(function() {
    $('input[name=usertype]').live('click',function() {
        var t = $(this);
        $('.info-wrapper').each(function(i,v) {
            var x = $(v);
            x.hide();
            if(x.attr('data') == t.val()) {
               x.show();
            }
        });
    });
    $('#register-form').live('submit',function() {
        var disable = true;
        // client side validation
        if(!disable)
        {
            alert('@todo: you need to write client side validation on js/signup.js');
            $("#register-form").serializeObject();
            return false;
        }

        return true;

    });
})();