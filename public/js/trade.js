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
        var postData =(command[0]==5)?
                        {'step':command[0],'action':command[1],'feedback':$('#feedback').val(),'review':$('#review').val()}
                        :{'step':command[0],'action':command[1]};

        if(postData['step'] != 5 ||(postData['step'] == 5 && postData['feedback'] != "" && postData['review'] != "")){
            $.post( location.href, postData)
                .done(function( data ) {
                    console.log(data);
                })
                .always(function() {
                    refreshStepList($(' #refresh '));
                });
        }
        else{
            alert('Please fill out every field!');
        }

    });
}
function chooseFeedbackBindings(){
    $(' button[data-feedback] ').click(function() {
        $('#feedback').val($(this).data('feedback'));
        $(' button[data-feedback] ').removeClass('selected');
        $(this).addClass('selected');
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
            chooseFeedbackBindings();
        })
        .always(function() {
            if ($this) {$this.removeClass('glyphicon-refresh-animate');}
        });
}
function chatScrollTop(duration){
    $('#chat-area').stop().animate({ scrollTop: $("#chat-area")[0].scrollHeight}, duration);
}
function sendChatMessage() {
    var input = $('#chat');
    var message = input.val();
    if ($.trim(message).length > 0) {
        var me = input.data('name');
        input.val("");

        var bubble = $('<div class="chat-message left">' + me + ': ' + message + '</div>')
        bubble.css('color', 'blue');

        bubble.insertBefore($('#type-area'));
        stackFromBottom();
        chatScrollTop(500);

        $.post(window.location.href.split('?')[0] + "/chat", {message: message})
            .done(function (data) {
                //valami visszacsatolás a sikeres küldésrõl
                if (data) {
                    bubble.css('color', 'black');
                }
            })
            .fail(function (data) {
                //valami visszacsatolás a sikeres küldésrõl
                if (data) {
                    bubble.css('color', 'red');
                }
            });
    }
}

var paddingOk = false;
function stackFromBottom(){
    if(!paddingOk){
        var chatBox = $('#chat-area');
        var contentHeight = 0;

        chatBox.children('div').each(function () {
            contentHeight+=$(this).outerHeight(true);
        });

        var padding = chatBox[0].offsetHeight-contentHeight;
        var paddingTop = padding>10?padding:10
        if (padding < -60){paddingOk = true}

        chatBox.css('paddingTop', paddingTop);
    }

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
var token;
$.post( "/api/token/" + $('#chat').data('order'), function( data ){
    token = jwt_decode(data);
    var socket = io.connect(location.protocol+"//"+ location.host+":6001", {
        'query': 'token=' + data
    });

    socket.on('App\\Events\\TradeStatusChangedEvent', function(message){
        if (message.orderId == token.orderId && (!$( "#feedback" ).length || ($( "#feedback").val() == ""  && $( "#review").val() == "")))
        {
            refreshStepList()
        };
    });

    socket.on('App\\Events\\NewMessageEvent', function(message){
        if(token.orderId == message.orderId) {
            var typeArea = $('#type-area');
            $('<div class="chat-message right">' + message.sender + ': ' + message.message + '</div>').insertBefore(typeArea);
            typeArea.text('');

            stackFromBottom();
            if (!$("#chat").is(":focus")) {
                $('#chatAudio')[0].play();
            }
            chatScrollTop(500);
        }
    });

    socket.on('partner_typing', function(message){
        if(token.orderId == message.orderId){
            var typeArea = $('#type-area');
            typeArea.text(message.name + ' is typing...');
            setTimeout(function() {
                typeArea.text('');
            }, 2000);
        }

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
    chooseFeedbackBindings();
    stackFromBottom();

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

    $('<audio id="chatAudio"><source src="../sound/notify.mp3" type="audio/mpeg"><source src="../sound/notify.wav" type="audio/wav"></audio>').appendTo('body');
});