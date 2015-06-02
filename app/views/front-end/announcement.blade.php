@extends('front-end.layouts.default')

@section('page-title')
    <h2>{{ $announcement->title }}</h2>
@stop

@section('page-breadcrumb')
    <ul class="breadcrumbs">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('announcements') }}">Announcements</a></li>
        <li>{{ $announcement->title }}</li>
    </ul>
@stop

@section('content')
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
            <p>{{ $announcement->body }}</p>
        </div>
    </div>

    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES * * */
        var disqus_shortname = 'mvtsdashboard';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
    <!-- End Post -->
@stop