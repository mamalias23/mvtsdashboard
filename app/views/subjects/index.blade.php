@extends('layouts.default')

@section('content-header')

<h1>
    Subjects
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Subjects</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Subjects</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.subjects.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Year Level</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Major</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->year->level }} - {{ $subject->year->description }}</td>
                            <td>{{ $subject->department->name }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->major ? '<i class="fa fa-check-circle icon-success"></i> Yes' : '<i class="fa fa-times-circle icon-danger"></i> Nope' }}</td>
                            <td>
                                <a href="{{ route('backend.school-year.subjects.edit', array(SchoolYear::getActivated()->id, $subject->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.subjects.destroy', array(SchoolYear::getActivated()->id, $subject->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

@stop