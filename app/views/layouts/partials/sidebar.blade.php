<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/avatar-male.png') }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Sentry::getUser()->first_name . " " . Sentry::getUser()->last_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="treeview active">
            <a href="javascript:;">
                <i class="fa fa-cogs"></i> <span>SETTINGS</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu menu-open">
                <li class="{{ Request::is('backend/school-year*') ? 'active':'' }}"><a href="{{ url('backend/school-year') }}"><i class="fa fa-circle-o"></i> School Year</a></li>
                <li class="{{ Request::is('backend/year-level*') ? 'active':'' }}"><a href="{{ url('backend/year-level') }}"><i class="fa fa-circle-o"></i> Year Levels</a></li>
            </ul>
        </li>
        <li class="header">MAIN NAVIGATION</li>
        <!-- <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
            </ul>
        </li> -->
        <!-- <li class="treeview">
            <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Layout Options</span>
                <span class="label label-primary pull-right">4</span>
            </a>
            <ul class="treeview-menu">
                <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
            </ul>
        </li> -->
        <li class="{{ Request::is('backend/school-records-personel*') ? 'active':'' }}">
            <a href="{{ url('backend/school-records-personel') }}">
                <!-- <i class="fa fa-th"></i>  --><span>School Records Personel</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li>
            <a href="#">
                <!-- <i class="fa fa-th"></i>  --><span>Test</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li>
            <a href="#">
                <!-- <i class="fa fa-th"></i>  --><span>Test</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li>
            <a href="#">
                <!-- <i class="fa fa-th"></i>  --><span>Test</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="header"><i class="fa fa-cogs"></i> USER SETTINGS</li>
        <li>
            <a href="#">
                <span>Profile</span>
            </a>
        </li>
        <li>
            <a href="{{ url('backend/user/logout') }}">
                <span>Logout</span>
            </a>
        </li>         
    </ul>
    </section>
<!-- /.sidebar -->
</aside>