(function($){
    $('.bubbleTrigger').bubbleToggle(),

    $('.composeNewMsg').guPopup({
        height: 400,
        width: 800,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            var users = {};
            var template = _.template($('#newMessageTmpl').html());
            o.body.html(template());
            var keyupfn = function() {
                var $cur = $(this);
                var tm = _.template($('#searchUserTmpl').html());
                var ajName = $cur.val();
                if(ajName !== '') {
                    $.ajax({
                        url: '/ajax/users/search',
                        data: {id : ajName },
                        dataType: 'JSON',
                        type: 'POST',
                        success: function(msg) {
                            var all = '';
                            $.each(msg, function(i,v) {
                                all += tm({id: v.id, name: v.name, img_url: v.img_url });
                            });
                            $cur.parent().find('.ajaxSearchUserList').html(all);
                            $cur.parent().find('.ajaxSearchUserList li').click(function() {
                                $ch = $(this);
                                var did = $ch.attr('data-id');
                                var uname = $ch.attr('title');
                                $cur.after('<div class="msgtowrap clearfix"><span>'+uname+'</span><input type="hidden" name="msgto" value="'+did+'"/><a class="msgtoclose">X</a></div>');
                                $cur.parent().find('.msgtoclose').click(function() {
                                    $dd = $(this).parents('.msgtowrap');
                                    $dd.after('<input type="text" />');
                                    $('.ajaxSearchUser input').keyup(keyupfn);
                                    $dd.remove();

                                });
                                $cur.remove();
                                $ch.parent().html('');
                            });
                        }
                    });
                }else {
                    $cur.parent().find('.ajaxSearchUserList').html(ajName);
                }
            };
            $('.ajaxSearchUser input').keyup(keyupfn);

        }
    }),
    $('#addNewSubject').guPopup({
        width: 600,
        callback: function(options) {
            var o = options[0];
            var $base = options[1];

            var users = {};
            var template = _.template($('#newSubjectTmpl').html());

            $.ajax({
                url: '/ajax/subjects/available',
                dataType: 'JSON',
                type: 'GET',
                success: function(m) {
                    var select = '<option value="0">---- NONE ----</option>';
                    $.each(m, function(i,v) {
                        select += '<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    o.body.html(template({subjects: select}));
                }
            });
        }
    });
   var keyupfn = function() {
        var $cur = $(this);
        var tm = _.template($('#searchUserTmpl').html());
        var ajName = $cur.val();
        if(ajName !== '') {
            $.ajax({
                url: '/ajax/users/search',
                data: {id : ajName },
                dataType: 'JSON',
                type: 'POST',
                success: function(msg) {
                    var all = '';
                    $.each(msg, function(i,v) {
                        all += tm({id: v.id, name: v.name, img_url: v.img_url });
                    });
                    $cur.parent().find('.ajaxSearchUserList').html(all);
                    $cur.parent().find('.ajaxSearchUserList li').click(function() {
                        $ch = $(this);
                        var did = $ch.attr('data-id');
                        var uname = $ch.attr('title');
                        $cur.after('<div class="msgtowrap clearfix"><span>'+uname+'</span><input type="hidden" name="msgto" value="'+did+'"/><a class="msgtoclose">X</a></div>');
                        $cur.parent().find('.msgtoclose').click(function() {
                            $dd = $(this).parents('.msgtowrap');
                            $dd.after('<input type="text" />');
                            $('.ajaxSearchUser input').keyup(keyupfn);
                            $dd.remove();

                        });
                        $cur.remove();
                        $ch.parent().html('');
                    });
                }
            });
        }else {
            $cur.parent().find('.ajaxSearchUserList').html(ajName);
        }
    };
    $('.ajaxSearchUser input').keyup(keyupfn);
})(jQuery);
