var em, width, height;

$.fn.Dialog = function(options) {
    em = $(this);
    em.show();

    width = $(this).children('.body').width() + 30;
    height = $(this).children('.body').height() + 30;

    if(options == 'hide') {
        dialog.hide();
        return;
    }

    dialog.init();
    //dialog.show();
};


var dialog = {
    init: function() {
        em.children('.body').css({'margin-left': '-' + width / 2 + 'px', 'margin-top': '-' + height / 2 + 'px'});
        $(".dialog-close").on('click', function(){
            dialog.hide();
        });
        var length = $(".footer .btn-group a").length;
        $(".footer .btn-group a").css('width', 100/length+'%');
    },

    show: function(){
        em.animate({opacity: 1}, 300);
    },

    hide: function(){
        em.hide();
    }
};