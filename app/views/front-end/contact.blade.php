@extends('front-end.layouts.default')

@section('on-page-scripts')
    <script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
@stop

@section('content')

   <div class="row">

        <div class="col-md-8">

            <!-- Classic Heading -->
            <h4 class="classic-title"><span>Contact Us</span></h4>

            <!-- Start Contact Form -->
            <form role="form" class="contact-form" id="contact-form" method="post" onsubmit="return false">
                <div class="form-group">
                    <div class="controls">
                        <input type="text" placeholder="Name" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="email" class="email" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="controls">
                        <input type="text" class="requiredField" placeholder="Subject" name="subject">
                    </div>
                </div>

                <div class="form-group">
                    <div class="controls">
                        <textarea rows="7"  placeholder="Message" name="message"></textarea>
                    </div>
                </div>
                <button type="submit" id="submit" class="btn-system btn-large">Send</button><div id="success" style="color:#34495e;"></div>
            </form>
            <!-- End Contact Form -->

        </div>

        <div class="col-md-4">

            <!-- Classic Heading -->
            <h4 class="classic-title"><span>Information</span></h4>

            <!-- Some Info -->
            <p></p>

            <!-- Divider -->
            <div class="hr1" style="margin-bottom:10px;"></div>

            <!-- Info - Icons List -->
            <ul class="icons-list">
                <li><i class="fa fa-globe">  </i> <strong>Address:</strong> Mabini Street., Molave, Zambo Sur</li>
                <li><i class="fa fa-envelope-o"></i> <strong>Email:</strong> info@mvtsdashboard.org</li>
                <li><i class="fa fa-mobile"></i> <strong>Phone:</strong> +12 345 678 001</li>
            </ul>

            <!-- Divider -->
            <div class="hr1" style="margin-bottom:15px;"></div>

            <!-- Classic Heading -->
            <h4 class="classic-title"><span>Working Hours</span></h4>

            <!-- Info - List -->
            <ul class="list-unstyled">
                <li><strong>Monday - Saturday</strong> - 9am to 5pm</li>
                <li><strong>Sunday</strong> - Closed</li>
            </ul>

        </div>

    </div>

@stop