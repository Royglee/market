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
function chatScrollTop(duration){
    $('#chat-area').animate({ scrollTop: $("#chat-area")[0].scrollHeight}, duration);
}

function sendChatMessage(){
    var input = $('#chat');
    var message = input.val();
    var me = input.data('name');
    input.val("");

    var bubble = $('<div>'+ me +': '+ message +'</div>')
    bubble.css('color','blue');

    $('#chat-area').append(bubble);
    chatScrollTop(1000);

    $.post( window.location.href.split('?')[0]+"/chat", { message:  message})
        .done(function( data ) {
            //valami visszacsatolás a sikeres küldésrõl
            if(data){
                bubble.css('color','black');
            }
        })
        .fail(function( data ) {
            //valami visszacsatolás a sikeres küldésrõl
            if(data){
                bubble.css('color','red');
            }
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

//----Socket.io Connection and events
var lastEvent = 0;
$.post( "/api/token/" + $('#chat').data('order'), function( data ){
    var socket = io.connect(location.protocol+"//"+ location.host+":6001", {
        'query': 'token=' + data
    });

    socket.on('App\\Events\\TradeStatusChangedEvent', function(message){
        refreshStepList();
    });

    socket.on('App\\Events\\NewMessageEvent', function(message){
        $('#chat-area').append($('<div>' +message.sender+': '+ message.message +'</div>'));
        $('.type-area').addClass('hidden');
        chatScrollTop(1000);
    });

    socket.on('partner_typing', function(message){
        var typeArea = $('.type-area');
        typeArea.removeClass('hidden').text(message + ' is typing...').delay(1000);
        setTimeout(function() {
            typeArea.addClass('hidden');
        }, 2000)
    });

    socket.on("error", function(error) {
        if (error.type == "UnauthorizedError" || error.code == "invalid_token") {
            console.log("User's token has expired");
            location.reload();

        }
    });

    $('#chat').keypress(function(event) {
        if ((Date.now() - 2000) > lastEvent){
            socket.emit('typing');
            lastEvent = Date.now();
        }
    });
});
//---- End of Socket.io

$( document ).ready(function() {
    equal_cols('.pending-row');
    sendOptionBindings();
    chatScrollTop(0);

    $(' #refresh ').click(function() {
        refreshStepList($(this));
    });

    $('#chat-send').click(function(){
        sendChatMessage();
    });
    $('#chat').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            sendChatMessage();
        }
    });
});