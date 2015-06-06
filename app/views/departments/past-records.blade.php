@extends('layouts.default')

@section('content-header')

<h1>
    Departments in {{ SchoolYear::find(Input::get('school_year'))->school_year }}
    <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button>
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Departments</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Departments</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Curriculum</th>
                            <th>Name</th>
                            <th>Head</th>
                        </tr>
                        @if($departments->count())
                            @foreach($departments as $department)
                                <tr>
                                    <td>
                                        {{ $department->curriculum->name }}
                                    </td>
                                    <td>
                                        {{ $department->name }}
                                    </td>
                                    <td>
                                        {{ $department->head ? $department->head->user->first_name . " " . $department->head->user->last_name : 'no head yet' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                           <tr>
                                <td colspan="3">
                                    No departments added for school year {{ SchoolYear::find(Input::get('school_year'))->school_year }}
                                </td>
                            </tr> 
                        @endif
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.departments.index', SchoolYear::getActivated()->id))) }}
            {{ 
                Form::hidden(
                    'hidden_id', 
                    null, 
                    array(
                        'id'=>'hidden_id',
                    )
                ) 
            }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New Department</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="curriculum" class="control-label">Select Curriculum</label>
                        {{ 
                            Form::select(
                                'curriculum', 
                                $curriculumsArray, 
                                null,
                                array(
                                    'id'=>'curriculum', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            ) 
                        }}
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="name" class="control-label">Name</label>
                        {{ 
                            Form::text(
                                'name', 
                                null, 
                                array(
                                    'id'=>'name', 
                                    'class'=>'form-control',
                                    'placeholder'=>'eg: Computer, Science',
                                    'data-rule-required'=>'true',
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

<div class="modal fade" id="modal-assign-head" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAssignHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.departments.storeHead', SchoolYear::getActivated()->id))) }}
            {{
                Form::hidden(
                    'hidden_id',
                    null,
                    array(
                        'id'=>'hidden_id_department',
                    )
                )
            }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelAssignHead">Assign Department Head</h4>
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
            {{ Form::open(array('route'=>array('backend.school-year.departments.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

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
        $(".add-by-modal").on("click", function(e) {
            e.preventDefault();
            $("#myModal").modal();
            $("#myModalLabel").html("New Department");
            $("#hidden_id").val('');
            $("#name").val('');
            $("#curriculum").val('');
        });

        $(".edit-by-modal").on("click", function(e) {
            e.preventDefault();
            $("#myModal").modal();
            $("#myModalLabel").html("Update Department");
            $("#hidden_id").val($(this).data('id'));
            $("#name").val($(this).data('name'));
            $("#curriculum").val($(this).data('curriculum'));
        });

        $(".assign-department-head").on("click", function(e) {
            e.preventDefault();
            $("#modal-assign-head").modal();
            $("#myModalLabelAssignHead").html("Assign Department Head");
            $("#hidden_id_department").val($(this).data('id'));
        });

        $(".view-past-records").on("click", function(e) {
            e.preventDefault();
            $("#pastRecords").modal();
        });
    });
</script>
@stop

@stop