<!doctype html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><html lang="en" class="no-js"> <![endif]-->
<html lang="en">
<head>

  <!-- Basic -->
  <title>MVTS DashBoard</title>

  <!-- Define Charset -->
  <meta charset="utf-8">

  <!-- Responsive Metatag -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- Page Description and Author -->
  <meta name="description" content="Molave Vocational Technical School - Dashboard">
  <meta name="author" content="mamalias23">

  <!-- Bootstrap CSS  -->
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" media="screen">

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}" type="text/css" media="screen">

  <!-- Revolution Banner CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/settings.css') }}" media="screen" />

  <!-- Margo CSS Styles  -->
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/style.css') }}" media="screen">

  <!-- Responsive CSS Styles  -->
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/responsive.css') }}" media="screen">

  <!-- Css3 Transitions Styles  -->
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/animate.css') }}" media="screen">

  <!-- Color CSS Styles  -->
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/red.css') }}" title="red" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/jade.css') }}" title="jade" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/blue.css') }}" title="blue" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/beige.css') }}" title="beige" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/cyan.css') }}" title="cyan" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/green.css') }}" title="green" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/orange.css') }}" title="orange" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/peach.css') }}" title="peach" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/pink.css') }}" title="pink" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/purple.css') }}" title="purple" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/sky-blue.css') }}" title="sky-blue" media="screen" />
  <link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/colors/yellow.css') }}" title="yellow" media="screen" />

    @yield('on-page-styles')


  <!-- Margo JS  -->
  <script type="text/javascript" src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.migrate.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/modernizrr.js') }}"></script>
  <script type="text/javascript" src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.fitvids.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/owl.carousel.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/nivo-lightbox.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.isotope.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.appear.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/count-to.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.textillate.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.lettering.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.easypiechart.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.nicescroll.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/jquery.parallax.js') }}"></script>
  <script type="text/javascript" src="{{ asset('front-end/js/script.js') }}"></script>

  @yield('on-page-scripts')

  <!--[if IE 8]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
  <!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

</head>
<body>

	<!-- Container -->
	<div id="container">

        <!-- Start Header -->
        <div class="hidden-header"></div>
        <header class="clearfix">

            <!-- Start Top Bar -->
            <div class="top-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Start Contact Info -->
                            <ul class="contact-details">
                                <li><a href="#"><i class="fa fa-map-marker"></i> Mabini St., Molave, Zambo Sur</a>
                                </li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i> info{{ '@' . Config::get('app.domain') }}</a>
                                </li>
                                <li><a href="#"><i class="fa fa-phone"></i> 09485452243</a>
                                </li>
                            </ul>
                            <!-- End Contact Info -->
                        </div>
                        <div class="col-md-6">
                            <!-- Start Social Links -->
                                <ul class="social-list">
                                    <li>
                                        <a class="facebook itl-tooltip" data-placement="bottom" title="Facebook" href="#"><i class="fa fa-facebook"></i></a>
                                    </li>
                                    <li>
                                        <a class="twitter itl-tooltip" data-placement="bottom" title="Twitter" href="#"><i class="fa fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a class="google itl-tooltip" data-placement="bottom" title="Google Plus" href="#"><i class="fa fa-google-plus"></i></a>
                                    </li>
                                </ul>
                                <!-- End Social Links -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Top Bar -->

            <!-- Start Header ( Logo & Naviagtion ) -->
            <div class="navbar navbar-default navbar-top">
                <div class="container">
                    <div class="navbar-header">
                        <!-- Stat Toggle Nav Link For Mobiles -->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                           <i class="fa fa-bars"></i>
                       </button>
                       <!-- End Toggle Nav Link For Mobiles -->
                       <a class="navbar-brand" href="{{ url('/') }}"><img alt="" src="/images/mvtsdashboard.png"></a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <!-- Start Navigation List -->
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="{{ Request::is('/') ? 'active':'' }}" href="{{ url('/') }}">Home</a></li>
                            @if(count(Page::all()))
                                <li>
                                    <a class="{{ Request::is('pages*') ? 'active':'' }}" href="javascript:;">Pages</a>
                                    <ul>
                                        @foreach(Page::all() as $page)
                                            <li><a href="{{ url('pages/' . $page->slug) }}">{{ $page->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                            <li>
                                <a class="{{ Request::is('annoucements*') ? 'active':'' }}" href="{{ url('announcements') }}">Announcements</a>
                            </li>
                            <li><a class="{{ Request::is('monitor*') ? 'active':'' }}" href="{{ url('monitor') }}" target="_blank">Monitor Announcements</a></li>
                            <li><a class="{{ Request::is('contact*') ? 'active':'' }}" href="{{ url('contact') }}">Contact</a></li>
                            <li><a href="{{ url('/backend/user/login') }}">Login</a></li>
                        </ul>
                        <!-- End Navigation List -->
                    </div>
                </div>
            </div>
            <!-- End Header ( Logo & Naviagtion ) -->

        </header>
        <!-- End Header -->
        @if(Request::is('/'))
            <!-- Start HomePage Slider -->
            <section id="home">
                <!-- Carousel -->
                <div id="main-slide" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#main-slide" data-slide-to="0" class="active"></li>
                        <li data-target="#main-slide" data-slide-to="1"></li>
                        <li data-target="#main-slide" data-slide-to="2"></li>
                    </ol><!--/ Indicators end-->

                    <!-- Carousel inner -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img class="img-responsive" src="/images/slider/bg1.jpg" alt="slider">
                            <div class="slider-content">
                                <div class="col-md-12 text-center">
                                    <h2 class="animated2 white">
                                        <span>Welcome to <strong>MVTS</strong></span>
                                    </h2>
                                    <h3 class="animated3 white">
                                        <span>Molave Vocational Technical School</span>
                                    </h3>
                               </div>
                           </div>
                        </div><!--/ Carousel item end -->
                        <div class="item">
                            <img class="img-responsive" src="/images/slider/bg2.jpg" alt="slider">
                            <div class="slider-content">
                                <div class="col-md-12 text-center">
                                    <h2 class="animated4">
                                        <span><strong>MVTS</strong> for the highest</span>
                                    </h2>
                                    <h3 class="animated5">
                                       <span>The Key of your Success</span>
                                   </h3>
                               </div>
                           </div>
                        </div><!--/ Carousel item end -->
                        <div class="item">
                            <img class="img-responsive" src="/images/slider/bg3.jpg" alt="slider">
                            <div class="slider-content">
                                <div class="col-md-12 text-center">
                                    <h2 class="animated7 white">
                                        <span>The way of <strong>Success</strong></span>
                                    </h2>
                                </div>
                            </div>
                        </div><!--/ Carousel item end -->
                    </div><!-- Carousel inner end-->

                    <!-- Controls -->
                    <a class="left carousel-control" href="#main-slide" data-slide="prev">
                        <span><i class="fa fa-angle-left"></i></span>
                    </a>
                    <a class="right carousel-control" href="#main-slide" data-slide="next">
                        <span><i class="fa fa-angle-right"></i></span>
                    </a>
                </div><!-- /carousel -->
            </section>
            <!-- End HomePage Slider -->
        @endif
        @if(!Request::is('/') && !Request::is('contact'))
            <!-- Start Page Banner -->
            <div class="page-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            @yield('page-title')
                        </div>
                        <div class="col-md-6">
                            @yield('page-breadcrumb')
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Banner -->
        @endif
        @if(Request::is('contact'))
            <!-- Start Map -->
            <div id="map" data-position-latitude="8.090688199999999" data-position-longitude="123.49864750000006"></div>
            <script>
                (function ( $ ) {
                    $.fn.CustomMap = function( options ) {

                        var posLatitude = $('#map').data('position-latitude'),
                        posLongitude = $('#map').data('position-longitude');

                        var settings = $.extend({
                            home: { latitude: posLatitude, longitude: posLongitude },
                            text: '<div class="map-popup"><h4>Web Development | ZoOm-Arts</h4><p>A web development blog for all your HTML5 and WordPress needs.</p></div>',
                            icon_url: $('#map').data('marker-img'),
                            zoom: 15
                        }, options );

                        var coords = new google.maps.LatLng(settings.home.latitude, settings.home.longitude);

                        return this.each(function() {
                            var element = $(this);

                            var options = {
                                zoom: settings.zoom,
                                center: coords,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                mapTypeControl: false,
                                scaleControl: false,
                                streetViewControl: false,
                                panControl: true,
                                disableDefaultUI: true,
                                zoomControlOptions: {
                                    style: google.maps.ZoomControlStyle.DEFAULT
                                },
                                overviewMapControl: true,
                            };

                            var map = new google.maps.Map(element[0], options);

                            var icon = {
                                url: settings.icon_url,
                                origin: new google.maps.Point(0, 0)
                            };

                            var marker = new google.maps.Marker({
                                position: coords,
                                map: map,
                                icon: icon,
                                draggable: false
                            });

                            var info = new google.maps.InfoWindow({
                                content: settings.text
                            });

                            google.maps.event.addListener(marker, 'click', function() {
                                info.open(map, marker);
                            });

                            var styles = [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"on"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}];

                            map.setOptions({styles: styles});
                        });

                };
                }( jQuery ));

                jQuery(document).ready(function() {
                    jQuery('#map').CustomMap();
                });
                </script>
                <!-- End Map -->
        @endif
        <!-- Start Content -->
        <div id="content">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <!-- End content -->
        <!-- Start Footer -->
        <footer>
            <div class="container">
                <div class="row footer-widgets">
                    <!-- Start Subscribe & Social Links Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget social-widget">
                            <h4>Follow Us<span class="head-line"></span></h4>
                            <ul class="social-icons">
                                <li>
                                    <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li>
                                    <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .col-md-3 -->
                    <!-- End Subscribe & Social Links Widget -->
                    <!-- Start Twitter Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget twitter-widget">
                            <h4>Navigations<span class="head-line"></span></h4>
                            <ul>
                                <li>
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ url('announcements') }}">Announcements</a>
                                </li>
                                <li>
                                    <a href="{{ url('contact') }}">Contact</a>
                                </li>
                                <li>
                                    <a href="{{ url('/backend/user/login') }}">Login</a>
                                </li>
                            </ul>
                        </div>
                    </div><!-- .col-md-3 -->
                    <!-- End Twitter Widget -->
                    <!-- Start Flickr Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget twitter-widget">
                            <h4>Latest Announcement<span class="head-line"></span></h4>
                            <ul>
                            <?php
                            $announcements = Announcement::where('receivers_group', 'LIKE', '{"all":1%')->orderBy('created_at', 'DESC')->limit(5)->get();
                            ?>
                            @foreach($announcements as $announcement)
                                <li>
                                    <a href="{{ url('announcements/view/' . $announcement->id) }}">{{ $announcement->title }}</a>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div><!-- .col-md-3 -->
                    <!-- End Flickr Widget -->
                    <!-- Start Contact Widget -->
                    <div class="col-md-3">
                        <div class="footer-widget contact-widget">
                            <h4>Reach Us<span class="head-line"></span></h4>
                            <ul>
                                <li><span>Phone Number:</span> 09485452243</li>
                                <li><span>Email:</span> info{{ '@' . Config::get('app.domain') }}</li>
                            </ul>
                        </div>
                    </div><!-- .col-md-3 -->
                    <!-- End Contact Widget -->
                </div> <!-- .row -->
                <!-- Start Copyright -->
                <div class="copyright-section">
                    <div class="row">
                        <div class="col-md-6">
                            <p>&copy; 2015 MVTSDASHBOARD -  All Rights Reserved </p>
                        </div>
                        <div class="col-md-6">
                            <ul class="footer-nav">
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Copyright -->

            </div>
        </footer>
        <!-- End Footer -->

    </div>
    <!-- End Container -->

    <!-- Go To Top Link -->
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

    <div id="loader">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>

</body>
</html>