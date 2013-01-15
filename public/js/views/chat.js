(function($){
    $(document).ready(function() {
        var togglechatfn = function() {
            var $t = $(this);
            var $p = $t.parents('.chat');
            var $id = $p.attr('id');

            $p.toggleClass('open');
            $.ajax({
                url: '/ajax/chats/toggle',
                type: 'POST',
                dataType: 'json',
                data: { id: $id, status: $p.hasClass('open') },
                success: function(msg) {

                }
            });
        };
        var sendchatfn = function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) { //Enter keycode
                var $t = $(this);
                var $p = $t.parents('.chat');
                var $id = $p.attr('id');
                var $message = $t.val();
                $t.val('');
                $.ajax({
                    url: '/ajax/chats/send',
                    type: 'POST',
                    dataType: 'json',
                    data: { id: $id, message: $message },
                    success: function(o) {
                        $p.find('.body ul').append('<li><b>You:</b> '+ o.message +'</li>');
                        var height = $p.find('.body')[0].scrollHeight;
                        $p.find('.body').scrollTop(height);
                    }
                });
            }
        };
        var closechatfn = function() {
            var $t = $(this);
            var $p = $t.parents('.chat');
            var $id = $p.attr('id');

            $p.toggleClass('open');
            $.ajax({
                url: '/ajax/chats/close',
                type: 'POST',
                dataType: 'json',
                data: { id: $id },
                success: function(msg) {
                    $p.parent().remove();
                }
            });
            return false;

        };

        var openchatfn = function(id, name, dft) {
            var $id = 'chatid-'+ id;
            var template = _.template($('#chatBodyTmpl').html());
            $.ajax({
                url: '/ajax/chats/open',
                type: 'POST',
                dataType: 'json',
                data: { id: $id },
                success: function(msg) {
                    console.log(msg);
                    var chats = '';
                    $.each(msg.msg, function(i,v) {
                        var sendername = 'You';
                        if(v.sender_id == id) {
                            sendername = name;
                        }
                        chats += '<li><b>'+sendername+': </b>'+v.message+'</li>';
                    });
                    var newDom = $('<li/>', {});
                    var toggle = '';
                    if(dft) {
                        toggle = '';
                    }else {
                        toggle = 'open';
                    }
                    newDom.append(template({toggle: toggle, chatid: $id, receivername: name, chats: chats}));
                    newDom.find('.chat .title').click(togglechatfn);
                    newDom.find('.chat .title .chatclose').click(closechatfn);
                    newDom.find('.chat .message input').keypress(sendchatfn);

                    $('.chatitems').append(newDom);
                    var chatbody = newDom.find('.body');
                    if(chatbody.length !== 0) {
                        var sHeight = chatbody[0].scrollHeight;
                        chatbody.scrollTop(sHeight);
                    }
                }
            });
        };

        var timestamp = 0;
        window.getChat = function() {
        $.ajax({
                type: "GET",
                url: "/ajax/chats/update?timestamp="+timestamp,
                async: true,
                cache: false,
                dataType: 'JSON',
                timeout: 28000,
                success: function(data) {
                    $.each(data.o, function(i,v) {
                        var $id = 'chatid-'+v.id;
                        if($('#'+$id).length !== 0) {
                            var msg = '';
                            $.each(v.msgs, function(ii,vv) {
                                msg += '<li><b>'+v.name+': </b>'+vv.message+'</li>';
                            });
                            var chatbody = $('#'+$id).find('.body');
                            chatbody.find('ul').append(msg);
                            if(chatbody.length !== 0) {
                                var sHeight = chatbody[0].scrollHeight;
                                chatbody.scrollTop(sHeight);
                            }
                        }
                        else {
                            openchatfn(v.id, v.fullname, true);
                        }

                    });
                    timestamp = data.timestamp;
                    setTimeout("getChat()", 2000);
                },
                error: function() {
                    setTimeout("getChat()", 1000+Math.random()*3000);
                }
            });
        };

        // initializer
        $('.chat .title').click(togglechatfn);
        $('.chat .message input').keypress(sendchatfn);
        $('.chat .title .chatclose').click(closechatfn);

        var chatbody = $('.chat .body');
        if(chatbody.length !== 0) {
            var sHeight = chatbody[0].scrollHeight;
            chatbody.scrollTop(sHeight);
        }

        $('.openchat').click(function() {
            var $t = $(this);
            var id = $t.attr('data-id');
            var $name = $t.attr('title');
            if($('#'+'chatid-'+id).length === 0) {
                openchatfn(id, $name);
            }
            return false;
        });

        // trigger chat
        getChat();
    });


})(jQuery);