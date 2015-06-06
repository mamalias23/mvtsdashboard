@extends('layouts.default')

@section('content-header')

<h1>
    Sections in {{ SchoolYear::find(Input::get('school_year'))->school_year }}
    <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button>
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
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->curriculum->name }}</td>
                            <td>{{ $section->year->level }} - {{ $section->year->description }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->adviser ? $section->adviser->user->first_name . " " . $section->adviser->user->last_name : 'No Adviser'; }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<div class="modal fade" id="modal-adviser" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAdviser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.sections.storeAdviser', SchoolYear::getActivated()->id))) }}
            {{
                Form::hidden(
                    'hidden_id',
                    null,
                    array(
                        'id'=>'hidden_id_section',
                    )
                )
            }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelAdviser">Assign Adviser</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="teacher_id" class="control-label">Select Teacher</label>
                        {{
                            Form::select(
                                'teacher_id',
                                $availableTeachers,
                                null,
                                array(
                                    'id'=>'teacher_id',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            )
                        }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" value="add" class="btn btn-primary">Save</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="pastRecords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.sections.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

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
        $(".assign-adviser").on("click", function(e) {
            e.preventDefault();
            $("#modal-adviser").modal();
            $("#myModalLabelAdviser").html("Assign Adviser");
            $("#hidden_id_section").val($(this).data('id'));
        });

        $(".view-past-records").on("click", function(e) {
            e.preventDefault();
            $("#pastRecords").modal();
        });
    });
</script>
@stop

@stop