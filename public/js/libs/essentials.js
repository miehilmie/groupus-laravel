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
                var callback = option.callback || function() {};
                var w = $('html').width();
                var h = $('html').height();
                var wh = $(window).height();
                var width = option.width || (w - (w*0.2));
                var height = option.height || (wh - (wh*0.2));
                var wscale = (1-(width/w))/2;
                var hscale = (1-(height/wh))/2;
                var body = $('<div/>', {
                    id: 'holder',
                    css: {
                        left: (w*wscale) - 50 + 'px',
                        top: (wh*hscale) + 'px',
                        position: 'relative',
                        background: '#fff',
                        width: width +'px',
                        height:  height +'px',
                        'padding': '10px 60px'
                    },
                    click: function(e) {
                        e.stopPropagation();
                    }
                }).html('<div class="ajxLoading"></div>');

                var back = $('<div/>', {
                    css: {
                        'z-index': 99,
                        position: 'fixed',
                        left:0,
                        top:0,
                        width: w+'px',
                        height: h+'px',
                        background: 'rgba(0,0,0,0.6)'
                    },

                    click: function(e) {
                        back.trigger('close');
                    },
                }).append(body);

                $("html").live("keydown", function(c) {
                    c.which == 27 && back.trigger('close');
                }), 

                back.on('close', function() {
                    back.remove();
                })
                $('body').append(back);
                callback({ back: back, body: body }, $base);

            }); //  end click -->



        });
    }
})(jQuery);
