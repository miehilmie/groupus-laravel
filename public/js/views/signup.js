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
    $('#selUniversity').live('change', function(e) {

        var id = $(this).val();
        $.ajax({
            'url': '/ajax/universities/'+id+'/faculties',
            'type': 'GET',
            'dataType': 'JSON',
            'success': function(msg) {
                if(msg.err) {
                    $('#selFaculty').html('<option value="none">-- Select Faculty --</option>');
                }else {
                    var $el =$('#selFaculty');
                    $el.html('<option value="none">-- Select Faculty --</option>');
                    $.each(msg,function(i,v) {
                        $el.append('<option value="'+ v.id +'">'+ v.name +' ('+ v.abbrevation +')</option>');
                    });
                }
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