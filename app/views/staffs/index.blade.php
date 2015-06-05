@extends('layouts.default')

@section('content-header')

<h1>
    Other Staffs
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Other Staffs</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Other Staffs</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.staffs.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Middle initial</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($staffs as $staff)
                        <tr>
                            <td>{{ $staff->user->last_name }}</td>
                            <td>{{ $staff->user->first_name }}</td>
                            <td>{{ $staff->user->middle_initial }}</td>
                            <td>{{ $staff->user->gender }}</td>
                            <td>{{ $staff->user->mobile_number }}</td>
                            <td>{{ $staff->user->full_address }}</td>
                            <td>{{ $staff->user->username }}</td>
                            <td>
                                <a href="{{ route('backend.school-year.staffs.edit', array(SchoolYear::getActivated()->id, $staff->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.staffs.destroy', array(SchoolYear::getActivated()->id, $staff->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
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