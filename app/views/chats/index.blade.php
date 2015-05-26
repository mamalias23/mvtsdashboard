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
    <div class="row">
        <div class="col-md-9">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Messages</h3>
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
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Participants</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                  </div>
                </div>
                <div class="box-body">
                </div><!-- /.box-body -->
              </div>
              <!-- /.box -->
        </div>
    </div>


@stop

@section('on-page-scripts')

@stop