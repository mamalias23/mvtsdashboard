
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>MVTS DASHBOARD | MONITOR</title>
	<meta name="Resource-type" content="Document" />


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.5/jquery.fullPage.min.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('front-end/css/monitor/example3.css') }}" />

	<!--[if IE]>
		<script type="text/javascript">
			 var console = { log: function() {} };
		</script>
	<![endif]-->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="{{ asset('bower_components/jquery-textfill/source/jquery.textfill.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.5/vendors/jquery.easings.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.6.5/jquery.fullPage.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#fullpage').fullpage({
				loopBottom: true,
			@if($announcements->count())
				anchors: {{ json_encode($announcements->lists('id')) }},
		    @else
		        anchors: ["noAnnouncement"],
		    @endif
				menu: '#menu',
				css3: true,
				scrollingSpeed: 1000,
				paddingTop: '80px',
                paddingBottom: '120px'
			});

			setInterval(function() {
                $.fn.fullpage.moveSectionDown();
			}, 1000 * 30);

			$('.section').textfill({
                 maxFontPixels: 180
            });
		});
	</script>
    <style>
    .section {
        background: #ee3733;
        color:#eee;
    }
    .announcer {
        position: absolute;
        bottom: 0;
        right: 0;
        padding:10px;
        font-size: 30px;
        color:#000;
    }
    </style>
</head>
<body>

<ul id="menu">
@if($announcements->count())
    @foreach($announcements as $announcement)
        <li data-menuanchor="{{ $announcement->id }}"><a href="#{{ $announcement->id }}">{{ $announcement->title }}</a></li>
    @endforeach
@else
    <li data-menuanchor="noAnnouncement" class="active"><a href="#noAnnouncement">no announcement</a></li>
@endif
</ul>

<div id="fullpage">
@if($announcements->count())
    @foreach($announcements as $announcement)
        <div class="section">
            <span>{{ $announcement->body }}</span>
            <div class="announcer">By: {{ $announcement->created_by()->first_name . " " . $announcement->created_by()->last_name }} - {{ $announcement->updated_at->format('l @ h:i A') }}</div>
        </div>
    @endforeach
@else
    <div class="section">
        <span>No Announcement</span>
    </div>
@endif
</div>
<script src="{{ asset('bower_components/pusher/dist/pusher.min.js') }}"></script>
<script>
    (function($){

        $.extend({
            playSound: function(){
                return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".mp3' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
            }
        });

    })(jQuery);

    (function() {
        var pusher = new Pusher('a4b5ea994e8c612a010e');
        var channel = pusher.subscribe('demoChannel');
        channel.bind('NewAnnouncement', function(data) {
            setTimeout(function() {
                window.location.href = '/monitor';
            }, 3000);

            $.playSound("/notification");

        });
    })();
</script>
</body>
</html>