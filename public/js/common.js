(function($){
    $.fn.serializeObject = function()
    {
       var o = {};
       var a = this.serializeArray();
       $.each(a, function() {
           if (o[this.name]) {
               if (!o[this.name].push) {
                   o[this.name] = [o[this.name]];
               }
               o[this.name].push(this.value || '');
           } else {
               o[this.name] = this.value || '';
           }
       });
       return o;
    };
    /**
    *   Author: Muhammad Hilmi
    **/
    $.fn.bubbleToggle = function(option){
        return this.each(function(i,el) {
            var base = el, $base = $(el);
            var a = {
                isItemClick: function(e) {
                    return (a.active && a.active.has(e.target).length > 0);
                },
                isFlyoutClick: function(e) {
                    return (a.active && $('#'+a.active.attr('data-target')).has(e.target).length > 0);
                },
                toggleDisplay: function(e) {
                    if(a.isFlyoutClick(e))
                        return;

                    if(a.isItemClick(e)) {
                        a.closeDropdown();
                    }
                    else {
                        a.closeDropdown();
                        a.active = $base, a.active.parent().addClass("open")
                    }
                },
                closeDropdown: function() {
                    $base.parent().removeClass("open"), a.active = false;
                }
                ,
                close: function(e) {
                    if(a.isFlyoutClick(e) || $base.has(e.target).length > 0)
                        return;

                    a.closeDropdown();
                },
                init: function() {
                    $("html").live("keydown", function(c) {
                        c.which == 27 && a.close(c);
                    }),            
                    $base.click(a.toggleDisplay),
                    $(document).click(a.close);
                }
            }
            a.init();
        });
        
    }
    /**
    *   Author: Muhammad Hilmi
    **/
    $.fn.guPopup = function(option) {
        return this.each(function(i, el) {
            $base = $(el);
            $base.click(function(e) {
                e.preventDefault();
                var w = $('html').width();
                var h = $('html').height();
                var wh = $(window).height();
                var content = $('#'+ $base.attr('data-href'));
                if( !content.length ) { 
                    alert('Please specify data-href');
                    return;
                }

                var back = $('<div/>', {
                    css: {
                        'z-index': 99,
                        position: 'absolute',
                        left:0,
                        top:0,
                        width: w+'px',
                        height: h+'px',
                        background: 'rgba(0,0,0,0.6)'
                    },

                    click: function(e) {
                        back.trigger('close');
                    },
                }).append($('<div/>', {
                    id: 'holder',
                    css: {
                        left: (w*0.1) + 'px',
                        top: (wh*0.1) + 'px',
                        position: 'relative',
                        background: '#fff',
                        width: (w - (w*0.2) - 120)+'px',
                        height: (wh - (wh*0.2) - 20)+'px',
                        'padding': '10px 60px'
                    },
                    click: function(e) {
                        e.stopPropagation();
                    }
                }).html(content.html()));
                $("html").live("keydown", function(c) {
                    c.which == 27 && back.trigger('close');
                }), 

                back.on('close', function() {
                    back.remove();
                })
                $('body').append(back);

                // var url = '';
                // switch(cmd) {
                //     case 'subject':
                //         url = '/ajax/subjects/new';
                //         break;
                //     case 'message':
                //         url = '/ajax/messages/new';
                //         break;
                // }
                // $.ajax({
                //     url: url,
                //     success: function(msg) {
                //         console.log(msg);
                //     }
                // });
            });



        });
    }
})(jQuery);
