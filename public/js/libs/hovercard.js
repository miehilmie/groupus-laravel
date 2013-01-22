$.fn.guHovercard = function(option){
     return this.each(function(i,el) {
         var base = el, $base = $(el), $cache = null, $holder = null;
         var $container = null;
         var a = {
             init: function() {
               if($('#hovercard-container').length === 0) {
                  $('body').append($('<div/>', {
                     id: 'hovercard-container'
                  }));
               }

               $container = $('#hovercard-container');
               var id = $base.attr('data-id');

               $base.mouseenter(function() {
                  $('.hovercard-item').css({
                        left: '-100px',
                        top: '-100px'
                  });

                  $holder = $('#hovercard-hover-'+id);
                  if($holder.length === 0 ) {
                     $holder = $('<div/>', {
                        'id': 'hovercard-hover-'+id,
                        'class': 'hovercard-item',
                        css: {
                           left: '-100px',
                           top: '-100px'
                        }
                     }).html('<div class="inner"><div class="ajxLoading"></div></div><li class="hovercard-caret"><div class="caret-outer" ></div><div class="caret-inner" ></div></li>');
                     $container.append($holder);
                  }
                  a.register();
                  clearTimeout($holder.stop().data('timer'));

                  $holder.css({
                     left: $base.offset().left,
                     top: $base.offset().top - 100
                  });

                  var check = $('#hovercardid-'+id);
                  if(check.length !== 0) {
                     $cache = check;
                  }

                  if($cache === null) {
                     var templateRef = $base.attr('data-template');
                     var template = _.template($('#'+templateRef).html());
                     $.ajax({
                        url: '/ajax/users/'+id,
                        dataType: 'JSON',
                        type: 'GET',
                        success: function(res) {
                           var o = res.response;
                           $cache = $(template({name: o.name, id: o.id, img_url: o.img_url, starvalue: res.voteaverage }));
                           $holder.find('.inner').html($cache);
                        }
                     });
                  }
               }).mouseout(function() {
                     $holder.data('timer', setTimeout(function() {
                        $holder.css({
                           left: '-100px',
                           top: '-100px'
                        });
                     }, 700));
               });



            },
            register: function() {
               $holder.hover(function(e) {
                  clearTimeout($holder.stop().data('timer'));
               },function() {
                     $holder.css({
                        left: '-100px',
                        top: '-100px'
                     });
               });
            }
         };
         a.init();
     });

 };