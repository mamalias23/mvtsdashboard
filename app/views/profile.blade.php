@extends('layouts.default')

@section('content-header')

<h1>
    My Profile
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li class="active">My Profile</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">My Profile</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('url'=>array('backend/user/profile'), 'files'=>true)) }}
                <div class="row">
                    <div class="col-md-4">
                        <label for="last_name" class="control-label">First Name</label>
                        {{
                            Form::text(
                                'first_name',
                                Sentry::getUser()->first_name,
                                array(
                                    'id'=>'first_name',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            )
                        }}
                    </div>

                    <div class="col-md-4">
                        <label for="last_name" class="control-label">Last Name</label>
                        {{
                            Form::text(
                                'last_name',
                                Sentry::getUser()->last_name,
                                array(
                                    'id'=>'last_name',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            )
                        }}
                    </div>

                    <div class="col-md-4">
                        <label for="middle_initial" class="control-label">M.I.</label>
                        {{
                            Form::selectRange(
                                'middle_initial',
                                'A',
                                'Z',
                                Sentry::getUser()->middle_initial,
                                array(
                                    'class'=>'form-control',
                                )
                            )
                        }}
                    </div>
                </div>

                <div class="row" style="margin-top:15px">
                    <div class="col-md-4">
                        <label for="gender" class="control-label">Gender</label>
                        <div class="form-group">
                            <label style="margin-right:20px">
                                {{
                                    Form::radio(
                                        'gender',
                                        'male',
                                        Sentry::getUser()->gender=='male' ? true:null,
                                        array(
                                            'class'=>'minimal-red',
                                        )
                                    )
                                }}
                                Male
                            </label>
                            <label>
                                {{
                                    Form::radio(
                                        'gender',
                                        'female',
                                        Sentry::getUser()->gender=='female' ? true:null,
                                        array(
                                            'class'=>'minimal-red',
                                        )
                                    )
                                }}
                                Female
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="birthdate" class="control-label">Birthdate</label>
                        {{
                            Form::text(
                                'birthdate',
                                Sentry::getUser()->birthdate,
                                array(
                                    'id'=>'birthdate',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                    'data-inputmask'=>"'alias': 'yyyy-mm-dd', 'clearIncomplete':'true'",
                                    'data-mask'=>''
                                )
                            )
                        }}
                    </div>
                    <div class="col-md-4">
                        <label for="mobile" class="control-label">Mobile Number</label>
                        {{
                            Form::text(
                                'mobile',
                                Sentry::getUser()->mobile_number,
                                array(
                                    'id'=>'mobile',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                    'data-mask-mobile'=>''
                                )
                            )
                        }}
                    </div>
                </div>

                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="full_address" class="control-label">Full Address</label>
                        {{
                            Form::text(
                                'full_address',
                                Sentry::getUser()->full_address,
                                array(
                                    'id'=>'full_address',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            )
                        }}
                    </div>
                </div>

                <div class="row" style="margin-top:15px">
                    <div class="col-md-4">
                        <label for="picture" class="control-label">Picture (dont select a file if you don't want to change)</label> <br />
                        <img src="/img/{{ Sentry::getUser()->picture ?: 'avatar-' . Sentry::getUser()->gender . '.png' }}" /> <br /><br />
                        {{
                            Form::file(
                                'picture',
                                array(
                                    'id'=>'picture',
                                    'class'=>'form-control'
                                )
                            )
                        }}
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
    });
</script>

@stop

@stop