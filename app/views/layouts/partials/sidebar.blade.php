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
                <li><a href="{{ route('backend.school-year.index') }}"><i class="fa fa-circle-o"></i> School Year</a></li>
                <li><a href="{{ route('backend.school-year.curriculums.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Curriculums</a></li>
                <li><a href="{{ route('backend.school-year.departments.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Departments</a></li>
                <li><a href="{{ route('backend.school-year.year-level.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Year Levels</a></li>
                <li><a href="{{ route('backend.school-year.sections.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Sections</a></li>
                <li><a href="{{ route('backend.school-year.subjects.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Subjects</a></li>
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
        <li class="{{ Request::is('backend/school-year/*/personels*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.personels.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-files-o"></i> <span>School Records Personel</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="{{ Request::is('backend/school-year/*/teachers*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.teachers.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-files-o"></i> <span>Teachers</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="{{ Request::is('backend/school-year/*/registrars*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.registrars.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-files-o"></i> <span>Registrars</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="{{ Request::is('backend/school-year/*/guards*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.guards.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-files-o"></i> <span>Guards</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="{{ Request::is('backend/school-year/*/staffs*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.staffs.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-files-o"></i> <span>Other Staffs</span><!--  <small class="label pull-right bg-green">Hot</small> -->
            </a>
        </li>
        <li class="treeview {{ Request::is('backend/school-year/*/students*') ? 'active':'' }}">
            <a href="javascript:;">
                <i class="fa fa-users"></i>
                <span>Students</span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ route('backend.school-year.students.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-list"></i> Lists</a></li>
                <li><a href="{{ route('backend.school-year.students.create', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-plus-circle"></i> New</a></li>
                <li><a href="{{ route('backend.school-year.students.enroll', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-user-plus"></i> Enroll</a></li>
            </ul>
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