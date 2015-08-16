function equal_cols(el)
{
    if($(window).width() > 750) {
        $(el).each(function(){
            var h = 0;
            var elm = $(this).children();
            $(elm).each(function () {
                $(this).css({'height': 'auto'});
                if ($(this).outerHeight() > h) {
                    h = $(this).outerHeight();
                }
            });
            $(elm).css({'height': h});
        });

    }
    else{
        $(el).each(function () {
            var elm = $(this).children();
            $(elm).each(function () {
                $(this).css({'height': 'auto'});
            });
        });
    }
}
function sendOptionBindings(){
    $(' div[data-opt] ').click(function() {
        var command = $(this).data('opt').split('.');
        $.post( location.href, {'step':command[0],'action':command[1]})
            .done(function( data ) {
                console.log(data);
            })
            .always(function() {
                refreshStepList();
            });
    });
}
function refreshStepList($this){
    var $this = $this || null;
    if ($this) {$this.addClass('glyphicon-refresh-animate');}
    $.get( location.protocol+'//'+location.host+location.pathname + "/steplist")
        .done(function( data ) {
            $('#tradelist').html(data);
            equal_cols('.pending-row');
            sendOptionBindings();
        })
        .always(function() {
            if ($this) {$this.removeClass('glyphicon-refresh-animate');}
        });
}

//----Bindings and Init
$( window ).resize(function() {
    equal_cols('.pending-row');
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$.post( "../api/token", function( data ) {
    var socket = io.connect('http://market.dev:6001', {
        'query': 'token=' + data
    });

    socket.on('App\\Events\\TradeStatusChangedEvent', function(message){
        refreshStepList();
        console.log('event');
    });

    socket.on("error", function(error) {
        if (error.type == "UnauthorizedError" || error.code == "invalid_token") {
            console.log("User's token has expired");
            location.reload();

        }
    });
});

$( document ).ready(function() {
    equal_cols('.pending-row');
    sendOptionBindings();

    $(' #refresh ').click(function() {
        refreshStepList($(this));
    });
});