@extends('layouts.default')

@section('content-header')

<h1>
    Announcements
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
                @if(Sentry::getUser()->groups()->first()->name!='Students' && Sentry::getUser()->groups()->first()->name!='Parents or Guardians')
                    <a href="{{ route('backend.school-year.announcements.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                @endif
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
                            <th>Created</th>
                            <th>Updated</th>
                            <th data-orderable="false">Action</th>
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
                                <td>{{ $announcement->created_at->diffForHumans() }}</td>
                                <td>{{ $announcement->updated_at->diffForHumans() }}</td>
                                <td>

                                    <a href="{{ route('backend.school-year.announcements.edit', array(SchoolYear::getActivated()->id, $announcement->id)) }}" class="btn btn-success btn-xs">View/Edit</a>

                                    @if($announcement->status==1 && Sentry::getUser()->hasAccess('admin'))
                                        <a href="{{ route('backend.school-year.announcements.approve', array(SchoolYear::getActivated()->id, $announcement->id)) }}" class="btn btn-info btn-xs">Approve</a>
                                    @endif
                                    @if(Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->id==$announcement->sender_id)
                                        <a href="{{ route('backend.school-year.announcements.destroy', array(SchoolYear::getActivated()->id, $announcement->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
                                    @endif
                                </td>
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

@stop