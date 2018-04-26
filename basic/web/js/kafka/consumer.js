'use strict';
let app = require('express')();
let http = require('http').Server(app);
let io = require('socket.io')(http);
var Kafka = require('no-kafka');


io.on('connection', (socket) => {
  console.log('USER CONNECTED');

  socket.on('disconnect', function(){
    console.log('USER DISCONNECTED');
  });
 
});

http.listen(8091, () => {
  console.log('started on port 8091');
  var consumer = new Kafka.SimpleConsumer({
        connectionString: 'localhost:9092',
        clientId: 'no-kafka-client'
    }); 
 
// data handler function can return a Promise 
	var dataHandler = function (messageSet, topic, partition) {
		messageSet.forEach(function (m) {
			console.log(m.message.value.toString('utf8'));
			if(topic=="test")
			{
				io.emit('message', m.message.value.toString('utf8'));
			}
			else
			{
				io.emit('sampleMessage', m.message.value.toString('utf8'));
			}
		});
	};
 
	return consumer.init().then(function () {
		// Subscribe partitons 0 and 1 in a topic: 
		var v1= consumer.subscribe('test', [0, 1], dataHandler);
		var v2= consumer.subscribe('Sample', [0, 1], dataHandler);

		var arr=[];
		arr.push([v1,v2]);
		console.log("val:"+arr);
		return arr;
		
	});
});

