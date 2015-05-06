@extends('layouts.default')

@section('content-header')

<h1>
    Update Subject
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.school-year.subjects.index', array(SchoolYear::getActivated()->id)) }}">Subject</a></li>
    <li class="active">Update</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Update Subject</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.subjects.update', SchoolYear::getActivated()->id, $subject->id), 'method'=>'PUT')) }}
                <div class="row">
                    <div class="col-md-4">
                        <label for="first_name" class="control-label">Select Year Level</label>
                        {{ 
                            Form::select(
                                'year_level', 
                                $yearLevels, 
                                $subject->year->id,
                                array(
                                    'id'=>'years', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-4">
                        <label for="first_name" class="control-label">Select Department</label>
                        {{ 
                            Form::select(
                                'department', 
                                $departmentLists, 
                                $subject->department->id,
                                array(
                                    'id'=>'department', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-4">
                        <label for="last_name" class="control-label">Name</label>
                        {{ 
                            Form::text(
                                'name', 
                                $subject->name, 
                                array(
                                    'id'=>'name', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                    	<div class="checkbox icheck">
							<label>
								{{ 
									Form::checkbox(
										'major', 
										1,
										$subject->major, 
										array('class'=>'minimal-red')
									) 
								}} This is a major subject
							</label>
						</div> 
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