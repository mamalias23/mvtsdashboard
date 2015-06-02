@extends('front-end.layouts.default')

@section('content')

    <!-- Divider -->
    <div class="hr1 margin-top"></div>
    <div class="row">
        <div class="col-md-12">
            <!-- Start Recent Posts Carousel -->
            <div class="latest-posts">
                <h4 class="classic-title"><span>Latest News</span></h4>
                <div class="latest-posts-classic custom-carousel touch-carousel" data-appeared-items="2">
                    <!-- Posts 1 -->
                    <div class="post-row item">
                        <div class="left-meta-post">
                            <div class="post-date"><span class="day">28</span><span class="month">Dec</span></div>
                            <div class="post-type"><i class="fa fa-picture-o"></i></div>
                        </div>
                        <h3 class="post-title"><a href="#">Standard Post With Image</a></h3>
                        <div class="post-content">
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit. <a class="read-more" href="#">Read More...</a></p>
                        </div>
                    </div>
                    <!-- Posts 2 -->
                    <div class="post-row item">
                        <div class="left-meta-post">
                            <div class="post-date"><span class="day">26</span><span class="month">Dec</span></div>
                            <div class="post-type"><i class="fa fa-picture-o"></i></div>
                        </div>
                        <h3 class="post-title"><a href="#">Link Post</a></h3>
                        <div class="post-content">
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit. <a class="read-more" href="#">Read More...</a></p>
                        </div>
                    </div>
                    <!-- Posts 3 -->
                    <div class="post-row item">
                        <div class="left-meta-post">
                            <div class="post-date"><span class="day">26</span><span class="month">Dec</span></div>
                            <div class="post-type"><i class="fa fa-picture-o"></i></div>
                        </div>
                        <h3 class="post-title"><a href="#">Iframe Video Post</a></h3>
                        <div class="post-content">
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit. <a class="read-more" href="#">Read More...</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Recent Posts Carousel -->

        </div>
    </div>

@stop