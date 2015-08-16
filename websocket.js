/*DEPENDENCIES*/
var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var socketioJwt   = require("socketio-jwt");
var Redis = require('ioredis');
var redis = new Redis();
var dotenv = require('dotenv').load();
var jwt_secret = process.env.JWT_SECRET;
/*END OF DEPENDENCIES*/

app.listen(6001, function() {
    console.log('Server is running!');
});
function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

//middleware -> JWT token validation
io.use(socketioJwt.authorize({
    secret: jwt_secret,
    handshake: true
}));

io.on('connection', function (socket) {
    console.log(socket.decoded_token.user_name + " connected. Location: " + socket.decoded_token.from);
    socket.join(socket.decoded_token.user_id);

    socket.on('disconnect', function () {
        console.log(this.decoded_token.user_name + " disconnected");
    });
});


redis.psubscribe('*', function(err, count) {});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);

    io.to(channel).emit(message.event, message.data);
    console.log(message.event+" fired to UserID: "+channel);
});