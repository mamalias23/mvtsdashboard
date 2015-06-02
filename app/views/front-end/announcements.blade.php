@extends('front-end.layouts.default')

@section('page-title')
    <h2>Announcements</h2>
@stop

@section('page-breadcrumb')

@stop

@section('content')
    @foreach($announcements as $announcement)
        <!-- Start Post -->
        <div class="blog-post standard-post">
            <!-- Post Content -->
            <div class="post-content">
                <div class="post-type"><i class="fa fa-weixin"></i></div>
                <h2><a href="{{ url('announcements/view/' . $announcement->id) }}">{{ $announcement->title }}</a></h2>
                <ul class="post-meta">
                    <li>By <a href="javascript:;">{{ $announcement->created_by()->first_name . " " . $announcement->created_by()->last_name }}</a></li>
                    <li>{{ $announcement->updated_at->timezone('Asia/Manila')->toDayDateTimeString(); }}</li>
                </ul>
                <p>{{ Str::words($announcement->body, 50) }}</p>
                <a class="main-button" href="{{ url('announcements/view/' . $announcement->id) }}">Read More <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
        <!-- End Post -->
    @endforeach
@stop