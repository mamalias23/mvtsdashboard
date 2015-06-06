@extends('layouts.default')

@section('content-header')

<h1>
    Subjects in {{ SchoolYear::find(Input::get('school_year'))->school_year }}
    <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button>
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
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Curriculum</th>
                            <th>Year Level</th>
                            <th>Department</th>
                            <th>Name</th>
                            <th>Major</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->year->curriculum->name }}</td>
                            <td>{{ $subject->year->level }} - {{ $subject->year->description }}</td>
                            <td>{{ $subject->department->name }}</td>
                            <td>{{ $subject->name }}</td>
                            <td>{{ $subject->major ? '<i class="fa fa-check-circle icon-success"></i> Yes' : '<i class="fa fa-times-circle icon-danger"></i> Nope' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="modal fade" id="pastRecords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.subjects.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Past Records</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="school_year" class="control-label">From School Year</label>
                        <select class="form-control" name="school_year">
                            <option value="">-----select-----</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}">{{ $year->school_year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">View</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@section('on-page-scripts')
<script>
    $(document).ready(function() {
        $(".view-past-records").on("click", function(e) {
            e.preventDefault();
            $("#pastRecords").modal();
        });
    });
</script>
@stop

@stop