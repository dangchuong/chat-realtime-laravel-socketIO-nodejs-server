var app = require('express')();
var http = require('http').createServer(app);
var io = require('socket.io')(http);

// app.get('/', function(req, res){
//   res.sendFile(__dirname + '/index.html');
// });

io.on('connection', function(socket){
  console.log('co ket noi den may chu' + socket.id);
  socket.on('client-send-message', function(data){
	io.sockets.emit('server-send-message', data);
  });
  socket.on('private-client-join-group', function(data){
    socket.join('room1');
    io.to('room1').emit('private-server-join-group', data);
  });
});

http.listen(7000, function(){
  console.log('listening on *:7000');
});
