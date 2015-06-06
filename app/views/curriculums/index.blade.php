@extends('layouts.default')

@section('content-header')

<h1>
    Curriculums
    <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button>
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Curriculums</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Curriculums</h3>
                <div class="box-tools pull-right">
                    <a href="javascript:;" class="btn btn-xs btn-info add-by-modal">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Action</th>
                        </tr>
                        @if($curriculums->count())
                            @foreach($curriculums as $curriculum)
                                <tr>
                                    <td>
                                        {{ $curriculum->name }}
                                    </td>
                                    <td>
                                        {{ $curriculum->user->username }}
                                    </td>
                                    <td>
                                        <a 
                                            href="javascript:;" 
                                            data-id="{{ $curriculum->id }}" 
                                            data-name="{{ $curriculum->name }}" 
                                            data-username="{{ $curriculum->name }}" 
                                            class="btn btn-xs btn-success edit-by-modal"
                                        >Edit</a>
                                        <a href="{{ route('backend.school-year.curriculums.destroy', array(SchoolYear::getActivated()->id, $curriculum->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                           <tr>
                                <td colspan="3">
                                    No curriculums added for school year {{ SchoolYear::getActivated()->school_year }}
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
            {{ Form::open(array('route'=>array('backend.school-year.curriculums.index', SchoolYear::getActivated()->id))) }}
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
                <h4 class="modal-title" id="myModalLabel">New Curriculum</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        {{ 
                            Form::text(
                                'name', 
                                null, 
                                array(
                                    'id'=>'name', 
                                    'class'=>'form-control',
                                    'placeholder'=>'Enter Curriculum name',
                                    'data-rule-required'=>'true',
                                    'ng-model'=>'name'
                                )
                            ) 
                        }}

                        <?php $name_model = "{{ name }}"; ?>

                        {{ 
                            Form::hidden(
                                'first_name', 
                                $name_model, 
                                array(
                                    'id'=>'first_name', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                </div>

                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        {{ 
                            Form::text(
                                'user_username', 
                                null, 
                                array(
                                    'id'=>'user_username', 
                                    'class'=>'form-control',
                                    'placeholder'=>'Username',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                </div>

                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        {{ 
                            Form::password(
                                'user_password', 
                                array(
                                    'id'=>'user_password', 
                                    'class'=>'form-control',
                                    'placeholder'=>'Default Password: 12345678',
                                    'data-rule-required'=>'false',
                                )
                            ) 
                        }}
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" value="add" class="btn btn-primary">View</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div class="modal fade" id="pastRecords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.curriculums.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

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
            $("#myModalLabel").html("New Curriculum");
            $("#hidden_id").val('');
            $("#name").val('');
            $("#user_username").val('');
            $("#user_password").val('');
            $("#user_password").attr('placeholder', 'Default Password: 12345678');
        });

        $(".edit-by-modal").on("click", function(e) {
            e.preventDefault();
            $("#myModal").modal();
            $("#myModalLabel").html("Update Curriculum");
            $("#hidden_id").val($(this).data('id'));
            $("#name").val($(this).data('name'));
            $("#first_name").val($(this).data('name'));
            $("#user_username").val($(this).data('username'));
            $("#user_password").val('');
            $("#user_password").attr('placeholder', 'Leave it blank if you don\'t want to change the password');
        });

        $(".view-past-records").on("click", function(e) {
            e.preventDefault();
            $("#pastRecords").modal();
        });
    });
</script>
@stop

@stop