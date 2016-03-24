$(function () {
    $.nette.init();

    if(reload) {
        setInterval(function() {
            $.nette.ajax({
                'url': '?do=redraw',
                'data': {
                }
            });
        }, 5000)
    }
});
