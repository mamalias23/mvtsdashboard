@extends('layouts.default')

@section('content-header')

  <h1>
    My Advisory
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Advisory</li>
  </ol>

@stop

@section('content')

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">My Advisory</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
      </div>
    </div>
    <div class="box-body no-padding">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Section Name</th>
                    <th>Year Level</th>
                    <th>Curriculum</th>
                </tr>
                <tr>
                    <td>{{ $teacher->advisory->name }}</td>
                    <td>{{ $teacher->advisory->year->description }}</td>
                    <td>{{ $teacher->advisory->curriculum->name }}</td>
                </tr>
            </tbody>
        </table>
    </div><!-- /.box-body -->
  </div>
  <!-- /.box -->

  <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">My Students</h3>
        <div class="box-tools pull-right">
            <a href="{{ url('backend/my-advisory/add-students') }}" class="btn btn-xs btn-info">Add new</a>
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
                  @foreach($teacher->advisory->students()->get() as $student)
                      <tr>
                          <td>{{ $student->user->last_name }}</td>
                          <td>{{ $student->user->first_name }}</td>
                          <td>{{ $student->user->middle_initial }}</td>
                          <td>{{ $student->user->gender }}</td>
                          <td>{{ $student->user->mobile_number }}</td>
                          <td>{{ $student->user->full_address }}</td>
                          <td>{{ $student->user->username }}</td>
                          <td>
                              <a href="{{ route('backend.school-year.students.edit', array(SchoolYear::getActivated()->id, $student->id)) }}" class="btn btn-success btn-xs">Edit</a>
                              <a href="{{ url('backend/my-advisory/student', array($student->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to un-enroll this?">Un-enroll</a>
                          </td>
                      </tr>
                  @endforeach

              </tbody>
          </table>
      </div><!-- /.box-body -->
    </div>
    <!-- /.box -->

@stop