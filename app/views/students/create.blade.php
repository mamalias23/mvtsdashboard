@extends('layouts.default')

@section('content-header')

<h1>
    New Student
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.school-year.students.index') }}">Students</a></li>
    <li class="active">New</li>
</ol>

@stop

@section('on-page-styles')

<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
  .toggle.ios label { border:0 }
</style>

@stop

@section('content')
{{ Form::open(array('route'=>array('backend.school-year.students.store', SchoolYear::getActivated()->id), 'id'=>'frm')) }}
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Student Information</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
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
                                $username,
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
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Guardian Information</h3>
                <div class="box-tools pull-right" ng-init="guardian={{ Input::old('is_guardian', 0) }}">
                    {{
                        Form::checkbox(
                            'is_guardian',
                            1,
                            null,
                            array(
                                'id'=>'is_guardian',
                                'class'=>'minimal-red',
                                'ng-model'=>'guardian',
                                'ng-true-value'=>1,
                                'ng-false-value'=>0,
                                'data-toggle'=>'toggle',
                                'data-style'=>'ios',
                                'data-onstyle'=>'success',
                                'data-on'=>'&nbsp;',
                                'data-off'=>'&nbsp;',
                                'data-size'=>'small',
                            )
                        )
                    }}
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="guardian_full_name" class="control-label">Full name</label>
                        {{
                            Form::text(
                                'guardian_full_name',
                                null,
                                array(
                                    'id'=>'guardian_full_name',
                                    'class'=>'form-control',
                                    'ng-disabled'=>'!guardian'
                                )
                            )
                        }}
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="guardian_mobile" class="control-label">Mobile Number</label>
                        {{
                            Form::text(
                                'guardian_mobile',
                                null,
                                array(
                                    'id'=>'guardian_mobile',
                                    'class'=>'form-control',
                                    'data-mask-mobile'=>'',
                                    'ng-disabled'=>'!guardian'
                                )
                            )
                        }}
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Mother Information</h3>
                    <div class="box-tools pull-right" ng-init="mother={{ Input::old() ? Input::old('is_mother', 0) : 1 }}">
                        {{
                            Form::checkbox(
                                'is_mother',
                                1,
                                null,
                                array(
                                    'id'=>'is_mother',
                                    'class'=>'minimal-red',
                                    'ng-model'=>'mother',
                                    'ng-true-value'=>1,
                                    'ng-false-value'=>0,
                                    'data-toggle'=>'toggle',
                                    'data-style'=>'ios',
                                    'data-onstyle'=>'success',
                                    'data-on'=>'&nbsp;',
                                    'data-off'=>'&nbsp;',
                                    'data-size'=>'small',
                                )
                            )
                        }}
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="mother_full_name" class="control-label">Full name</label>
                            {{
                                Form::text(
                                    'mother_full_name',
                                    null,
                                    array(
                                        'id'=>'mother_full_name',
                                        'class'=>'form-control',
                                        'data-rule-required'=>'true',
                                        'ng-disabled'=>'!mother'
                                    )
                                )
                            }}
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12">
                            <label for="mother_mobile" class="control-label">Mobile Number</label>
                            {{
                                Form::text(
                                    'mother_mobile',
                                    null,
                                    array(
                                        'id'=>'mother_mobile',
                                        'class'=>'form-control',
                                        'data-rule-required'=>'true',
                                        'data-mask-mobile'=>'',
                                        'ng-disabled'=>'!mother'
                                    )
                                )
                            }}
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div>
        </div>
    <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Father Information</h3>
                        <div class="box-tools pull-right" ng-init="father={{ Input::old() ? Input::old('is_father', 0) : 1 }}">
                            {{
                                Form::checkbox(
                                    'is_father',
                                    1,
                                    null,
                                    array(
                                        'id'=>'is_father',
                                        'class'=>'minimal-red',
                                        'ng-model'=>'father',
                                        'ng-true-value'=>1,
                                        'ng-false-value'=>0,
                                        'data-toggle'=>'toggle',
                                        'data-style'=>'ios',
                                        'data-onstyle'=>'success',
                                        'data-on'=>'&nbsp;',
                                        'data-off'=>'&nbsp;',
                                        'data-size'=>'small',
                                    )
                                )
                            }}
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="father_full_name" class="control-label">Full name</label>
                                {{
                                    Form::text(
                                        'father_full_name',
                                        null,
                                        array(
                                            'id'=>'father_full_name',
                                            'class'=>'form-control',
                                            'data-rule-required'=>'true',
                                            'ng-disabled'=>'!father'
                                        )
                                    )
                                }}
                            </div>
                        </div>
                        <div class="row" style="margin-top:15px">
                            <div class="col-md-12">
                                <label for="father_mobile" class="control-label">Mobile Number</label>
                                {{
                                    Form::text(
                                        'father_mobile',
                                        null,
                                        array(
                                            'id'=>'father_mobile',
                                            'class'=>'form-control',
                                            'data-rule-required'=>'true',
                                            'data-mask-mobile'=>'',
                                            'ng-disabled'=>'!father'
                                        )
                                    )
                                }}
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div>
            </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <button type="submit" class="btn btn-success btn-lg">SAVE</button>
        </div>
    </div>
</div>
{{ Form::close() }}
@section('on-page-scripts')

<script type="text/javascript">
    $(function () {
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });

        $("#is_guardian").change(function() {
            if($(this).is(":checked")) {
                $("#guardian_full_name").removeAttr('disabled');
                $("#guardian_mobile").removeAttr('disabled');
            } else {
                $("#guardian_full_name").attr('disabled','disabled');
                $("#guardian_mobile").attr('disabled','disabled');
            }
        });

        $("#is_mother").change(function() {
            if($(this).is(":checked")) {
                $("#mother_full_name").removeAttr('disabled');
                $("#mother_mobile").removeAttr('disabled');
            } else {
                $("#mother_full_name").attr('disabled','disabled');
                $("#mother_mobile").attr('disabled','disabled');
            }


        });

        $("#is_father").change(function() {
            if($(this).is(":checked")) {
                $("#father_full_name").removeAttr('disabled');
                $("#father_mobile").removeAttr('disabled');
            } else {
                $("#father_full_name").attr('disabled','disabled');
                $("#father_mobile").attr('disabled','disabled');
            }
        });

    });

    $('#frm').validate({
        rules:{
            'guardian_full_name':{
                required: {
                    depends: function(){
                        return $('#is_guardian').is(':checked')
                    }
                }
            },
            'guardian_mobile':{
                required: {
                    depends: function(){
                        return $('#is_guardian').is(':checked')
                    }
                }
            },
            'mother_full_name':{
                 required: {
                     depends: function(){
                         return $('#is_mother').is(':checked')
                     }
                 }
            },
            'mother_mobile':{
                required: {
                    depends: function(){
                        return $('#is_mother').is(':checked')
                    }
                }
            },
            'father_full_name':{
                required: {
                    depends: function(){
                        return $('#is_father').is(':checked')
                    }
                }
            },
            'father_mobile':{
                required: {
                    depends: function(){
                        return $('#is_father').is(':checked')
                    }
                }
            }
        }
    });
</script>

@stop

@stop