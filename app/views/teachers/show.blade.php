@extends('layouts.default')

@section('content-header')

<h1>
    Manage Teacher
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('backend.school-year.teachers.index', array(SchoolYear::getActivated()->id)) }}">Teachers</a></li>
    <li class="active">Manage Teacher</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Information</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Middle initial</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $teacher->user->last_name }}</td>
                        <td>{{ $teacher->user->first_name }}</td>
                        <td>{{ $teacher->user->middle_initial }}</td>
                        <td>{{ $teacher->user->gender }}</td>
                        <td>{{ $teacher->user->mobile_number }}</td>
                        <td>{{ $teacher->user->full_address }}</td>
                    </tr>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Subjects</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.teachers.subjects', SchoolYear::getActivated()->id, $teacher->id))) }}
                <div class="row">
                    <div class="col-md-12">
                        <label for="personels" class="control-label">Select Subject(s)</label>
                        {{ 
                            Form::select(
                                'subjects[]', 
                                $availableSubjects, 
                                $teacherSubjects,
                                array(
                                    'id'=>'subjects', 
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
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Advisory <h6>ignore this section if the teacher doesn't have advisory</h6></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.teachers.advisory', SchoolYear::getActivated()->id, $teacher->id))) }}
                <div class="row">
                    <div class="col-md-12">
                        <label for="personels" class="control-label">Select Section</label>
                        {{ 
                            Form::select(
                                'section', 
                                $sectionsArray, 
                                $teacher->advisory ? $teacher->advisory->id:null,
                                array(
                                    'id'=>'section', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
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
        <!-- /.box -->
    </div>
</div>

@section('on-page-scripts')

<script type="text/javascript">
    $(function () {

        
    });
</script>

@stop

@stop