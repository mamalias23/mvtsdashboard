@extends('layouts.default')

@section('content-header')

<h1>
    School Year
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">School year</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">School Year</h3>
                <div class="box-tools pull-right">
                    <a href="#" class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach($years as $year)
                            <tr>
                                <td>
                                    {{ $year->school_year }}
                                    {{ $year->activated ? ' <i class="fa fa-check" style="color:green"></i>':'' }}
                                </td>
                                <td>
                                    @if($year->activated)
                                        <button type="button" class="btn btn-xs btn-success" disabled>Activate</button>
                                        <button type="button" class="btn btn-xs btn-danger" disabled>Delete</button>
                                    @else
                                        <a href="{{ route('backend.school-year.activate', array($year->id)) }}" class="btn btn-xs btn-success">Activate</a>
                                        <a href="{{ route('backend.school-year.destroy', array($year->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
                                    @endif
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url'=>'/backend/school-year')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New School year</h4>
            </div>
            <div class="modal-body">
                
                    {{ 
                        Form::text(
                            'school_year', 
                            null, 
                            array(
                                'id'=>'school_year', 
                                'class'=>'form-control',
                                'placeholder'=>'School Year',
                                'data-rule-required'=>'true',
                                'data-inputmask'=>"'mask': '9999-9999'",
                                'data-mask'=>''
                            )
                        ) 
                    }}
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" value="add" class="btn btn-primary">Add</button>
                <button type="submit" name="submit" value="add_activate" class="btn btn-primary">Add and Activate</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@stop