(function() {
    var pusher = new Pusher('a4b5ea994e8c612a010e');
    var channel = pusher.subscribe('demoChannel');
    channel.bind('userNewMessage', function(data) {
        console.log('yeah connected!');
        console.log(data);
    });
})();