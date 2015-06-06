@extends('layouts.default')

@section('content-header')

<h1>
    Announcements in {{ SchoolYear::find(Input::get('school_year'))->school_year }}
    <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button>
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Announcements</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Announcements</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Created by</th>
                            <th>Title</th>
                        @if(!Sentry::getUser()->groups()->first()->name=='Students' && !Sentry::getUser()->groups()->first()->name=='Parents or Guardians')
                            <th>Status</th>
                        @endif
                            <th>SMS</th>
                            <th>Created</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($announcements as $announcement)
                        @if(Sentry::getUser()->id == $announcement->sender_id || Sentry::getUser()->hasAccess('admin') || ($announcement->receivers->contains(Sentry::getUser()->id) && $announcement->status==2))
                            <tr>
                                <td>{{ $announcement->created_by()->first_name . " " . $announcement->created_by()->middle_initial . ". " . $announcement->created_by()->last_name }}</td>
                                <td>{{ $announcement->title }}</td>
                            @if(!Sentry::getUser()->groups()->first()->name=='Students' && !Sentry::getUser()->groups()->first()->name=='Parents or Guardians')
                                <td>{{ $announcement->status==1 ? 'Pending':'Approved' }}</td>
                            @endif
                                <td>{{ $announcement->sms ? '<i class="fa fa-check-circle icon-success"></i> Yes' : '<i class="fa fa-times-circle icon-danger"></i> Nope' }}</td>
                                <td>{{ $announcement->created_at->tz('Asia/Manila')->diffForHumans() }}</td>
                                <td>{{ $announcement->updated_at->tz('Asia/Manila')->diffForHumans() }}</td>
                            </tr>
                        @endif
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
            {{ Form::open(array('route'=>array('backend.school-year.announcements.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

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