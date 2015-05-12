@extends('layouts.default')

@section('content-header')

<h1>
    New Staff
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.school-year.staffs.index') }}">Other Staffs</a></li>
    <li class="active">New</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Choose from existing record</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.staffs.storeFromExisting', SchoolYear::getActivated()->id))) }}
                <div class="row">
                    <div class="col-md-12">
                        <label for="personels" class="control-label">Select Staff(s)</label>
                        {{ 
                            Form::select(
                                'staffs[]', 
                                $availableStaffs, 
                                null,
                                array(
                                    'id'=>'staffs', 
                                    'class'=>'form-control select-multiple',
                                    'data-rule-required'=>'true',
                                    'multiple'=>'multiple'
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
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">or Add a new Staff</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.staffs.store', SchoolYear::getActivated()->id))) }}
                <div class="row">
                    <div class="col-md-5">
                        <label for="first_name" class="control-label">First name</label>
                        {{ 
                            Form::text(
                                'first_name', 
                                null, 
                                array(
                                    'id'=>'first_name', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-5">
                        <label for="last_name" class="control-label">Last name</label>
                        {{ 
                            Form::text(
                                'last_name', 
                                null, 
                                array(
                                    'id'=>'last_name', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-2">
                        <label for="middle_initial" class="control-label">M.I.</label>
                        {{ 
                            Form::selectRange(
                                'middle_initial',
                                'A', 
                                'Z',
                                null,
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
                                        true,
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
                                        null,
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
                                null, 
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
                                null, 
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
                                null, 
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
                    <div class="col-md-6">
                        <label for="username" class="control-label">Username</label>
                        {{ 
                            Form::text(
                                'username', 
                                null, 
                                array(
                                    'id'=>'username', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="control-label">Password</label>
                        {{ 
                            Form::password(
                                'password', 
                                array(
                                    'id'=>'password', 
                                    'class'=>'form-control',
                                    'placeholder'=>'Default password: 12345678',
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