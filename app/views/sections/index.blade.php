@extends('layouts.default')

@section('content-header')

<h1>
    Sections
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Sections</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sections</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.sections.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Curriculum</th>
                            <th>Year Level</th>
                            <th>Name</th>
                            <th>Adviser</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->curriculum->name }}</td>
                            <td>{{ $section->year->level }} - {{ $section->year->description }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->adviser ? '<a href="'.route('backend.school-year.teachers.show', array(SchoolYear::getActivated()->id, $section->adviser->id)).'">'.$section->adviser->user->first_name . " " . $section->adviser->user->last_name.'</a>' : 'No Adviser'; }}</td>
                            <td>
                                <a href="{{ route('backend.school-year.sections.edit', array(SchoolYear::getActivated()->id, $section->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.sections.destroy', array(SchoolYear::getActivated()->id, $section->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
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