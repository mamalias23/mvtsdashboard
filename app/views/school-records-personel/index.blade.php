@extends('layouts.default')

@section('content-header')

<h1>
    School Records Personel
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">School Records Personel</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">School Records Personel</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.personels.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
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
                    @foreach($personels as $personel)
                        <tr>
                            <td>{{ $personel->user->last_name }}</td>
                            <td>{{ $personel->user->first_name }}</td>
                            <td>{{ $personel->user->middle_initial }}</td>
                            <td>{{ $personel->user->gender }}</td>
                            <td>{{ $personel->user->mobile_number }}</td>
                            <td>{{ $personel->user->full_address }}</td>
                            <td>{{ $personel->user->username }}</td>
                            <td>
                                <a href="{{ route('backend.school-year.personels.edit', array(SchoolYear::getActivated()->id, $personel->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.personels.destroy', array(SchoolYear::getActivated()->id, $personel->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
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