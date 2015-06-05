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
                <p style="color:darkgray">{{ Sentry::getUser()->getGroups()->first()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        @if(Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->hasAccess('curriculum_departments') || Sentry::getUser()->hasAccess('department_heads'))
            <li class="treeview active">
                <a href="javascript:;">
                    <i class="fa fa-cogs"></i> <span>SETTINGS</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu menu-open">
                    @if(Sentry::getUser()->hasAccess('admin'))
                        <li><a href="{{ route('backend.school-year.index') }}"><i class="fa fa-circle-o"></i> School Year</a></li>
                        <li><a href="{{ route('backend.school-year.curriculums.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Curriculums</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('curriculum_departments'))
                        <li><a href="{{ route('backend.school-year.departments.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Departments</a></li>
                        <li><a href="{{ route('backend.school-year.year-level.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Year Levels</a></li>
                        <li><a href="{{ route('backend.school-year.sections.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Sections</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('department_heads'))
                        <li><a href="{{ route('backend.school-year.subjects.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-circle-o"></i> Subjects</a></li>
                    @endif
                </ul>
            </li>
        @endif
        {{--<li>--}}
            {{--<a href="{{ route('backend.chats.index') }}">--}}
                {{--<i class="fa fa-weixin"></i> <span>Public Chat</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        @if(Sentry::getUser()->hasAccess('admin'))
            <li><a href="{{ route('backend.pages.index') }}"><i class="fa fa-files-o"></i> Pages</a></li>
        @endif
        <li class="{{ Request::is('backend/school-year/*/announcements*') ? 'active':'' }}">
            <a href="{{ route('backend.school-year.announcements.index', array(SchoolYear::getActivated()->id)) }}">
                <i class="fa fa-weixin"></i> <span>ANNOUNCEMENTS</span>
            </a>
        </li>
        <li><a href="{{ route('backend.activities.index') }}"><i class="fa fa-calendar"></i> Activities / Events</a></li>
        <li class="header">MAIN NAVIGATION</li>
        @if(Sentry::getUser()->hasAccess('admin'))
            <li class="{{ Request::is('backend/school-year/*/personels*') ? 'active':'' }}">
                <a href="{{ route('backend.school-year.personels.index', array(SchoolYear::getActivated()->id)) }}">
                    <i class="fa fa-files-o"></i> <span>School Records Personel</span><!--  <small class="label pull-right bg-green">Hot</small> -->
                </a>
            </li>
        @endif
        @if(Sentry::getUser()->hasAccess('school_records_personel'))
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
        @endif
        @if(Sentry::getUser()->hasAccess('registrar'))
            <li class="treeview {{ Request::is('backend/school-year/*/students*') ? 'active':'' }}">
                <a href="javascript:;">
                    <i class="fa fa-users"></i>
                    <span>Students</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('backend.school-year.students.index', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-list"></i> Lists</a></li>
                    <li><a href="{{ route('backend.school-year.students.create', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-plus-circle"></i> New</a></li>
                    <li><a href="{{ route('backend.school-year.students.enroll', array(SchoolYear::getActivated()->id)) }}"><i class="fa fa-user-plus"></i> Enroll</a></li>
                </ul>
            </li>
        @endif

        <?php
            $hasAdvisory = 0;
            $groupName = Sentry::getUser()->getGroups()->first()->name;
            $teacher = User::find(Sentry::getUser()->id)
                            ->teacher()
                            ->where('school_year_id', SchoolYear::getActivated()->id)
                            ->first();

            if($groupName=='Teachers' && $teacher) {
                if($advisory = $teacher->advisory) {
                    $hasAdvisory = 1;
                }
            }
        ?>
        @if($hasAdvisory)
            <li class="{{ Request::is('backend/my-advisory*') ? 'active':'' }}">
                <a href="{{ url('backend/my-advisory') }}">
                    <i class="fa fa-files-o"></i> <span>My Advisory</span><!--  <small class="label pull-right bg-green">Hot</small> -->
                </a>
            </li>
        @endif
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