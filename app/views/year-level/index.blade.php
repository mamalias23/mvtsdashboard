@extends('layouts.default')

@section('content-header')

<h1>
    Year Levels
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Year levels</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Year Levels</h3>
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
                            <th>Level</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        @if($years->count())
                            @foreach($years as $year)
                                <tr>
                                    <td>
                                        {{ $year->level }}
                                    </td>
                                    <td>
                                        {{ $year->description }}
                                    </td>
                                    <td>
                                        <a 
                                            href="javascript:;" 
                                            data-id="{{ $year->id }}" 
                                            data-level="{{ $year->level }}" 
                                            data-description="{{ $year->description }}" 
                                            class="btn btn-xs btn-success edit-by-modal"
                                        >Edit</a>
                                        <a href="javascript:;" data-href="{{ url('backend/year-level/delete/'.$year->id) }}" data-message="Are you sure you want to delete?" class="btn btn-xs btn-danger delete-record">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                           <tr>
                                <td colspan="3">
                                    No year level added for school year {{ SchoolYear::getActivated()->school_year }}
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
            {{ Form::open(array('url'=>'/backend/year-level')) }}
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
                <h4 class="modal-title" id="myModalLabel">New Year level</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        {{ 
                            Form::number(
                                'level', 
                                null, 
                                array(
                                    'id'=>'level', 
                                    'class'=>'form-control',
                                    'placeholder'=>'Year level',
                                    'data-rule-required'=>'true',
                                    'min'=>1,
                                    'max'=>10,
                                )
                            ) 
                        }}
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        {{ 
                            Form::text(
                                'description', 
                                null, 
                                array(
                                    'id'=>'description', 
                                    'class'=>'form-control',
                                    'placeholder'=>'eg: First Year, Second Year',
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

@section('on-page-scripts')
<script>
    $(document).ready(function() {
        $(".add-by-modal").on("click", function(e) {
            e.preventDefault();
            $("#myModal").modal();
            $("#myModalLabel").html("New Year level");
            $("#hidden_id").val('');
            $("#level").val('');
            $("#description").val('');
        });

        $(".edit-by-modal").on("click", function(e) {
            e.preventDefault();
            $("#myModal").modal();
            $("#myModalLabel").html("Update Year level");
            $("#hidden_id").val($(this).data('id'));
            $("#level").val($(this).data('level'));
            $("#description").val($(this).data('description'));
        });
    });
</script>
@stop

@stop