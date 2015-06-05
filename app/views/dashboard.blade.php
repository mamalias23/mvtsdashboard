@extends('layouts.default')

@section('content-header')

  <h1>
    Dashboard
    <small>it all starts here</small>
  </h1>
  <ol class="breadcrumb">
    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Dashboard</li>
  </ol>

@stop

@section('content')

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Title</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
      </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ Student::where('school_year_id', SchoolYear::getActivated()->id)->get()->count() }}</h3>
                        <p>Total Students</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('backend.school-year.students.index', array(SchoolYear::getActivated()->id)) }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ Teacher::where('school_year_id', SchoolYear::getActivated()->id)->get()->count() }}</h3>
                        <p>Total Teachers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('backend.school-year.teachers.index', array(SchoolYear::getActivated()->id)) }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ SchoolRecordPersonel::where('school_year_id', SchoolYear::getActivated()->id)->get()->count() }}</h3>
                        <p>Total Personels</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('backend.school-year.personels.index', array(SchoolYear::getActivated()->id)) }}" class="small-box-footer">View all <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

    </div><!-- /.box-body -->
  </div>
  <!-- /.box -->

@stop