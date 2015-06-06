@extends('layouts.default')

@section('content-header')

<h1>
    School Year
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">School year</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">School Year</h3>
                <div class="box-tools pull-right">
                    <a href="#" class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModal">Activate new School Year</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    <!-- <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <div class="box-body no-padding">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            {{--<th>Action</th>--}}
                        </tr>
                        @foreach($years as $year)
                            <tr>
                                <td>
                                    {{ $year->school_year }}
                                    {{ $year->activated ? ' <i class="fa fa-check" style="color:green"></i>':'' }}
                                </td>
                                {{--<td>--}}
                                    {{--@if($year->activated)--}}
                                        {{--<button type="button" class="btn btn-xs btn-success" disabled>Activate</button>--}}
                                        {{--<button type="button" class="btn btn-xs btn-danger" disabled>Delete</button>--}}
                                    {{--@else--}}
                                        {{--<a href="{{ route('backend.school-year.activate', array($year->id)) }}" class="btn btn-xs btn-success">Activate</a>--}}
                                        {{--<a href="{{ route('backend.school-year.destroy', array($year->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>--}}
                                    {{--@endif--}}
                                {{--</td>--}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('url'=>'/backend/school-year')) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Activate School year</h4>
            </div>
            <div class="modal-body">
                
                    {{ 
                        Form::text(
                            'school_year', 
                            null, 
                            array(
                                'id'=>'school_year', 
                                'class'=>'form-control',
                                'placeholder'=>'School Year',
                                'data-rule-required'=>'true',
                                'data-inputmask'=>"'mask': '9999-9999'",
                                'data-mask'=>''
                            )
                        ) 
                    }}

                    <br><br>
                    <p>Copy Records</p>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[0]',
                                            'curriculums',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'curriculums'
                                            )
                                        )
                                    }} Curriculums
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[2]',
                                            'departments',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'departments'
                                            )
                                        )
                                    }} Departments
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[3]',
                                            'year_levels',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'year_levels'
                                            )
                                        )
                                    }} Year Levels
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[4]',
                                            'sections',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'sections'
                                            )
                                        )
                                    }} Sections
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[5]',
                                            'subjects',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'subjects'
                                            )
                                        )
                                    }} Subjects
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[6]',
                                            'school_records_personel',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'school_records_personel'
                                            )
                                        )
                                    }} School Records Personel
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[1]',
                                            'teachers',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'teachers'
                                            )
                                        )
                                    }} Teachers
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[7]',
                                            'registrars',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'registrars'
                                            )
                                        )
                                    }} Registrars
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[8]',
                                            'guards',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'guards'
                                            )
                                        )
                                    }} Guards
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label>
                                    {{
                                        Form::checkbox(
                                            'copy[9]',
                                            'other_staffs',
                                            true,
                                            array(
                                                'class'=>'minimal-red',
                                                'id'=>'other_staffs'
                                            )
                                        )
                                    }} Other Staffs
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label for="from_year" class="control-label">From School Year</label>
                            <select class="form-control" name="from_year">
                                <option value="">-----select-----</option>
                                @foreach($years as $year)
                                    <option value="{{ $year->id }}">{{ $year->school_year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{--<button type="submit" name="submit" value="add" class="btn btn-primary">Add</button>--}}
                <button type="submit" name="submit" value="add_activate" class="btn btn-primary">Activate</button>
            </div>
            {{ Form::close() }}
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

        $("input#curriculums").on("ifUnchecked", function(event) {
            $("input#departments").iCheck("uncheck");
            $("input#year_levels").iCheck("uncheck");
        });

        $("input#departments").on("ifChecked", function(event) {
            $("input#curriculums").iCheck("check");
        });

        $("input#year_levels").on("ifChecked", function(event) {
            $("input#curriculums").iCheck("check");
        });

        $("input#year_levels").on("ifUnchecked", function(event) {
            $("input#sections").iCheck("uncheck");
            $("input#subjects").iCheck("uncheck");
        });

        $("input#subjects").on("ifChecked", function(event) {
            $("input#departments").iCheck("check");
            $("input#year_levels").iCheck("check");
        });

        $("input#sections").on("ifChecked", function(event) {
            $("input#year_levels").iCheck("check");
        });
    });
</script>

@stop

@stop