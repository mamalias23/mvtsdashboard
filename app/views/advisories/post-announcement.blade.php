@extends('layouts.default')

@section('content-header')

<h1>
    New Announcement
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ url('backend/my-advisory') }}">My Advisory</a></li>
    <li class="active">New Announcement</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">New Annoucement</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('url'=>array('backend/my-advisory/post-announcement'))) }}
                <input type="hidden" name="group[]" value="student_section_{{ $teacher->advisory->id }}" />
                @foreach($teacher->advisory->students()->get() as $student)
                    <input type="hidden" name="users[]" value="{{ $student->user->id }}" />
                @endforeach
                <div class="col-md-12">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Title</label>
                        {{
                            Form::text(
                                'title',
                                null,
                                array(
                                    'id'=>'title',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            )
                        }}
                    </div>

                    <div class="col-md-12">
                        <label class="control-label" for="body">Body</label>
                        {{
                            Form::textarea(
                                'body',
                                null,
                                array(
                                    'id'=>'body',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                    'rows'=>'20'
                                )
                            )
                        }}
                    </div>

                    <div class="col-md-12">
                        <div class="checkbox icheck">
                            <label>
                                {{
                                    Form::checkbox(
                                        'sms',
                                        1,
                                        false,
                                        array('class'=>'minimal-red')
                                    )
                                }} SMS
                            </label>
                        </div>
                    </div>

                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@section('on-page-scripts')

<script type="text/javascript">
    $(function () {
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });

        $('#tree').tree({
            onCheck: {
                ancestors: 'checkIfFull',
                descendants: 'check'
            },
            onUncheck: {
                ancestors: 'uncheck'
            },
            selectable: false,
            dnd:false,
            collapseUiIcon:'ui-icon-circle-plus',
            expandUiIcon:'ui-icon-circle-minus',
            collapsed:true
        });

    });

</script>

@stop

@stop