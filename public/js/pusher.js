(function() {
    var pusher = new Pusher('a4b5ea994e8c612a010e');
    pusher.channel_auth_endpoint='/backend/chats';
    var channel = pusher.subscribe('demoChannel');

    var socketId = null;
    pusher.connection.bind('connected', function() {
        socketId = pusher.connection.socket_id;
        jQuery.ajax({
            url: '/backend/chats',
            type: "post",
            data: {
                channel_name: 'demoChannel',
                socket_id: socketId // pass socket_id parameter to be used by server
            }
        });

        console.log(socketId);
    });

    channel.bind('userNewMessage', function(data) {
        //alert('connected!');
    });
})();