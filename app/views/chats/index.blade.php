@extends('layouts.default')

@section('content-header')

  <h1>
    Chat
  </h1>
  <ol class="breadcrumb">
    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Chat</li>
  </ol>

@stop

@section('content')

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Chat</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
      </div>
    </div>
    <div class="box-body">
    <section id="messages">
        {{--<div class="from-them-user">Samsun V. Acapulco</div>--}}
        {{--<div class="from-them">--}}
            {{--<p>this is a test test test test</p>--}}
        {{--</div>--}}
        {{--<div class="clear"></div>--}}
        {{--<div class="from-me-user">Samsun V. Acapulco</div>--}}
        {{--<div class="from-me">--}}
            {{--<p>this is a test test test test</p>--}}
        {{--</div>--}}
    </section>

      <input type="text" class="form-control" id="chatMessage" placeholder="Enter your message here!" />

    </div><!-- /.box-body -->
  </div>
  <!-- /.box -->

@stop

@section('on-page-scripts')
<script src="{{ asset('brainsocket/brain-socket.min.js') }}"></script>
<script type="text/javascript">
$(function(){
    window.app = {};

    var user_id = <?php echo Sentry::getUser()->id ?>;

    app.BrainSocket = new BrainSocket(
        new WebSocket('ws://<?php echo Config::get("app.domain"); ?>:8080'),
        new BrainSocketPubSub()
    );

    app.BrainSocket.Event.listen('generic.event',function(msg){
        console.log(msg);
        if(msg.client.data.user_id == user_id){
            $('#messages').append('<div class="from-me"><p>'+msg.client.data.message+'</p></div><div class="clear"></div>');
        }else{
            $('#messages').append('<div class="from-them-user">'+msg.client.data.user_name+'</div><div class="from-them"><p>'+msg.client.data.message+'</p></div><div class="clear"></div>');
        }

        var el = document.getElementById("messages");
        el.scrollTop = el.scrollHeight;
    });

    app.BrainSocket.Event.listen('app.success',function(msg)
    {
        console.log(msg);
    });

    app.BrainSocket.Event.listen('app.error',function(msg)
    {
        console.log(msg);
    });

    $('#chatMessage').keypress(function(event) {
        if(event.keyCode == 13){
            if($.trim($(this).val())!='')
            app.BrainSocket.message('generic.event',
                    {
                        'message':$(this).val(),
                        'user_id': <?php echo Sentry::getUser()->id ?>,
                        'user_name': '<?php echo Sentry::getUser()->first_name . " " . Sentry::getUser()->last_name ?>'
                    }
            );
            $(this).val('');
        }
        return event.keyCode != 13;
    });
});
</script>
@stop