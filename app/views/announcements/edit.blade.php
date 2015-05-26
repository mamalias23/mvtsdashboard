@extends('layouts.default')

@section('content-header')

<h1>
    Update Announcement
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.school-year.announcements.index', array(SchoolYear::getActivated()->id)) }}">Announcements</a></li>
    <li class="active">Update</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Update Annoucement</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
            @if(Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->id == $announcement->sender_id)
                {{ Form::open(array('route'=>array('backend.school-year.announcements.update', SchoolYear::getActivated()->id, $announcement->id), 'method'=>'PUT')) }}
            @endif
                <div class="col-md-6">
                    <div class="col-md-12">
                        <label class="control-label" for="title">Title</label>
                        {{
                            Form::text(
                                'title',
                                $announcement->title,
                                array(
                                    'id'=>'title',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            )
                        }}
                    </div>

                    <div class="col-md-12">
                        <label class="control-label" for="body">Body</label>
                        {{
                            Form::textarea(
                                'body',
                                $announcement->body,
                                array(
                                    'id'=>'body',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                    'rows'=>'20'
                                )
                            )
                        }}
                    </div>

                    {{--<div class="col-md-12">--}}
                        {{--<div class="checkbox icheck">--}}
                            {{--<label>--}}
                                {{--{{--}}
                                    {{--Form::checkbox(--}}
                                        {{--'sms',--}}
                                        {{--1,--}}
                                        {{--true,--}}
                                        {{--array('class'=>'minimal-red')--}}
                                    {{--)--}}
                                {{--}} SMS - will be sent to receiver's mobile number--}}
                            {{--</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
                <div class="col-md-6">
                    <label>This announcement will be delivered to: </label>
                    <div id="tree">
                        <ul>
                            <li>
                                <input type="checkbox" id="all" name="group[]" value="all" {{ $announcement->receivers_group && array_key_exists('all', $groups) ? 'checked="true"':'' }} /><label for="all"><b>All</b></label>
                                <ul>
                                    <li class="collapsed">
                                        <input type="checkbox" id="school_records_personel" name="group[]" value="school_records_personel" {{ $announcement->receivers_group && array_key_exists('school_records_personel', $groups) ? 'checked="true"':'' }} /><label for="school_records_personel"><b>School Records Personel</b></label>
                                        @if(SchoolYear::getActivated()->records_personel()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->records_personel()->get() as $personel)
                                                    <li>
                                                        {{
                                                            Form::checkbox(
                                                                'users[]',
                                                                $personel->user->id,
                                                                $announcement->receivers->contains($personel->user->id),
                                                                array(
                                                                    'id'=>'personel-' . $personel->id
                                                                )
                                                            )
                                                        }}
                                                        <label for="personel-{{ $personel->id  }}">{{ $personel->user->first_name . " " . $personel->user->middle_initial . ". " . $personel->user->last_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="department_heads" name="group[]" value="department_heads" {{ $announcement->receivers_group && array_key_exists('department_heads', $groups) ? 'checked="true"':'' }} /><label for="department_heads"><b>Department Heads</b></label>
                                        @if(SchoolYear::getActivated()->departments()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->departments()->get() as $department)
                                                    @if($department->teacher_id)
                                                        <li>
                                                            {{
                                                                Form::checkbox(
                                                                    'users[]',
                                                                    $department->head->user->id,
                                                                    $announcement->receivers->contains($department->head->user->id),
                                                                    array(
                                                                        'id'=>'personel-' . $department->id
                                                                    )
                                                                )
                                                            }}
                                                            <label for="personel-{{ $department->id  }}">{{ $department->head->user->first_name . " " . $department->head->user->middle_initial . ". " . $department->head->user->last_name }} - {{ $department->curriculum->name }} - {{ $department->name }}</label>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="teachers" name="group[]" value="teachers" {{ $announcement->receivers_group && array_key_exists('teachers', $groups) ? 'checked="true"':'' }} /><label for="teachers"><b>Teachers</b></label>
                                        @if(SchoolYear::getActivated()->teachers()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->teachers()->get() as $teacher)
                                                    <li>
                                                        {{
                                                            Form::checkbox(
                                                                'users[]',
                                                                $teacher->user->id,
                                                                $announcement->receivers->contains($teacher->user->id),
                                                                array(
                                                                    'id'=>'personel-' . $teacher->id
                                                                )
                                                            )
                                                        }}
                                                        <label for="personel-{{ $teacher->id  }}">{{ $teacher->user->first_name . " " . $teacher->user->middle_initial . ". " . $teacher->user->last_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="registrars" name="group[]" value="registrars" {{ $announcement->receivers_group && array_key_exists('registrars', $groups) ? 'checked="true"':'' }} /><label for="registrars"><b>Registrars</b></label>
                                        @if(SchoolYear::getActivated()->registrars()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->registrars()->get() as $registrar)
                                                    <li>
                                                        {{
                                                            Form::checkbox(
                                                                'users[]',
                                                                $registrar->user->id,
                                                                $announcement->receivers->contains($registrar->user->id),
                                                                array(
                                                                    'id'=>'personel-' . $registrar->id
                                                                )
                                                            )
                                                        }}
                                                        <label for="personel-{{ $registrar->id  }}">{{ $registrar->user->first_name . " " . $registrar->user->middle_initial . ". " . $registrar->user->last_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="guards" name="group[]" value="guards" {{ $announcement->receivers_group && array_key_exists('guards', $groups) ? 'checked="true"':'' }} /><label for="guards"><b>Guards</b></label>
                                        @if(SchoolYear::getActivated()->guards()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->guards()->get() as $guard)
                                                    <li>
                                                        {{
                                                            Form::checkbox(
                                                                'users[]',
                                                                $guard->user->id,
                                                                $announcement->receivers->contains($guard->user->id),
                                                                array(
                                                                    'id'=>'personel-' . $guard->id
                                                                )
                                                            )
                                                        }}
                                                        <label for="personel-{{ $guard->id  }}">{{ $guard->user->first_name . " " . $guard->user->middle_initial . ". " . $guard->user->last_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="other_staffs" name="group[]" value="other_staffs" {{ $announcement->receivers_group && array_key_exists('other_staffs', $groups) ? 'checked="true"':'' }} /><label for="other_staffs"><b>Other Staffs</b></label>
                                        @if(SchoolYear::getActivated()->staffs()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->staffs()->get() as $staff)
                                                    <li>
                                                        {{
                                                            Form::checkbox(
                                                                'users[]',
                                                                $staff->user->id,
                                                                $announcement->receivers->contains($staff->user->id),
                                                                array(
                                                                    'id'=>'personel-' . $staff->id
                                                                )
                                                            )
                                                        }}
                                                        <label for="personel-{{ $staff->id  }}">{{ $staff->user->first_name . " " . $staff->user->middle_initial . ". " . $staff->user->last_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                    <li class="collapsed">
                                        <input type="checkbox" id="students" name="group[]" value="students" {{ $announcement->receivers_group && array_key_exists('students', $groups) ? 'checked="true"':'' }} /><label for="students"><b>Students</b></label>
                                        @if(SchoolYear::getActivated()->curriculums()->get()->count())
                                            <ul>
                                                @foreach(SchoolYear::getActivated()->curriculums()->get() as $curriculum)
                                                    <li class="collapsed">
                                                        <input type="checkbox" id="personel-{{ $curriculum->id  }}" name="group[]" value="student_curriculum_{{ $curriculum->id  }}" {{ $announcement->receivers_group && array_key_exists('student_curriculum_' . $curriculum->id, $groups) ? 'checked="true"':'' }} /><label for="personel-{{ $curriculum->id  }}"><b>{{ $curriculum->name }}</b></label>
                                                        @if($curriculum->year_levels()->get()->count())
                                                            <ul>
                                                                @foreach($curriculum->year_levels()->orderBy('level')->get() as $year)
                                                                    <li class="collapsed">
                                                                        <input type="checkbox" id="personel-{{ $year->id  }}" name="group[]" value="student_year_{{ $year->id  }}" {{ $announcement->receivers_group && array_key_exists('student_year_' . $year->id, $groups) ? 'checked="true"':'' }} /><label for="personel-{{ $year->id  }}"><b>{{ $year->description }}</b></label>
                                                                        @if($year->sections()->get()->count())
                                                                            <ul>
                                                                                @foreach($year->sections()->orderBy('name')->get() as $section)
                                                                                    <li class="collapsed">
                                                                                        <input type="checkbox" id="personel-{{ $section->id  }}" name="group[]" value="student_section_{{ $section->id  }}" {{ $announcement->receivers_group && array_key_exists('student_section_' . $section->id, $groups) ? 'checked="true"':'' }} /><label for="personel-{{ $section->id  }}"><b>{{ $section->name }}</b></label>
                                                                                        @if($section->students()->get()->count())
                                                                                            <ul>
                                                                                                 @foreach($section->students()->get() as $student)
                                                                                                    <li>
                                                                                                        {{
                                                                                                            Form::checkbox(
                                                                                                                'users[]',
                                                                                                                $student->user->id,
                                                                                                                $announcement->receivers->contains($student->user->id),
                                                                                                                array(
                                                                                                                    'id'=>'personel-' . $student->id
                                                                                                                )
                                                                                                            )
                                                                                                        }}
                                                                                                        <label for="personel-{{ $student->id  }}">{{ $student->user->first_name . " " . $student->user->middle_initial . ". " . $student->user->last_name }}</label>
                                                                                                    </li>
                                                                                                 @endforeach
                                                                                            </ul>
                                                                                        @endif
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(Sentry::getUser()->hasAccess('admin') || Sentry::getUser()->id == $announcement->sender_id)

                    <div class="row" style="margin-top:15px">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">SAVE</button>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}

                @endif

            </div><!-- /.box-body -->
        </div>
    </div>
</div>

@section('on-page-scripts')

<script type="text/javascript">
    $(function () {
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });

        $('#tree').tree({
            onCheck: {
                ancestors: 'checkIfFull',
                descendants: 'check'
            },
            onUncheck: {
                ancestors: 'uncheck'
            },
            selectable: false,
            dnd:false,
            collapseUiIcon:'ui-icon-circle-plus',
            expandUiIcon:'ui-icon-circle-minus',
            collapsed:true
        });


    });

</script>

@stop

@stop