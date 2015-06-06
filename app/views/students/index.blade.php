@extends('layouts.default')

@section('content-header')

<h1>
    {{ Form::open(array('route'=>array('backend.school-year.students.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}
    <div class="row" id="">
        <div class="col-md-2">Students</div>
        <div class="col-md-2">
            <label for="school_year" class="control-label sr-only">From School Year</label>
            <select class="form-control" name="school_year" id="school_year" onchange="this.form.submit()">
                <option value="{{ SchoolYear::getActivated()->id }}" @if(Input::get('school_year')==SchoolYear::getActivated()->id) selected="selected" @endif>{{ SchoolYear::getActivated()->school_year }}</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}" @if(Input::get('school_year')==$year->id) selected="selected" @endif >{{ $year->school_year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label for="curriculum" class="control-label sr-only">Select Curriculum</label>
            {{ 
                Form::select(
                    'curriculum', 
                    array(), 
                    null,
                    array(
                        'id'=>'curriculum', 
                        'class'=>'form-control'
                    )
                ) 
            }}
        </div>

        <div class="col-md-2">
            <label for="first_name" class="control-label sr-only">Select Year Level</label>
            {{ 
                Form::select(
                    'year_level', 
                    array(), 
                    null,
                    array(
                        'id'=>'years', 
                        'class'=>'form-control'
                    )
                ) 
            }}
        </div>
        <div class="col-md-2">
            <label for="first_name" class="control-label sr-only">Select Section</label>
            {{ 
                Form::select(
                    'sections', 
                    array(), 
                    null,
                    array(
                        'id'=>'sections', 
                        'class'=>'form-control'
                    )
                ) 
            }}
        </div>
    </div>
    {{ Form::close() }}

    <!-- <button type="button" class="btn btn-lg btn-warning view-past-records">VIEW PAST RECORDS</button> -->
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Students</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Students</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.students.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped" id="studentTable">
                    <thead>
                        <tr>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Middle initial</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Year</th>
                            <th>Section</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <!-- <tfoot>
                        <tr>
                            <th>Last name</th>
                            <th>First name</th>
                            <th>Middle initial</th>
                            <th>Gender</th>
                            <th>Mobile</th>
                            <th>Address</th>
                            <th>Username</th>
                            <th>Year</th>
                            <th>Section</th>
                        </tr>
                    </tfoot> -->
                    <tbody>
                    @foreach($students as $student)
                        @if(Input::get('curriculum') && Input::get('year_level') && Input::get('sections'))
                            @if($student->section->curriculum->id!=Input::get('curriculum') || $student->section->year->id!=Input::get('year_level') || $student->section->id!=Input::get('sections'))
                                <?php continue; ?>
                            @endif
                        @elseif(Input::get('curriculum') && Input::get('year_level') && !Input::get('sections'))
                            @if($student->section->curriculum->id!=Input::get('curriculum') || $student->section->year->id!=Input::get('year_level'))
                                <?php continue; ?>
                            @endif
                        @elseif(Input::get('curriculum') && !Input::get('year_level') && !Input::get('sections'))
                            @if($student->section->curriculum->id!=Input::get('curriculum'))
                                <?php continue; ?>
                            @endif
                        @endif
                        <tr>
                            <td>{{ $student->user->last_name }}</td>
                            <td>{{ $student->user->first_name }}</td>
                            <td>{{ $student->user->middle_initial }}</td>
                            <td>{{ $student->user->gender }}</td>
                            <td>{{ $student->user->mobile_number }}</td>
                            <td>{{ $student->user->full_address }}</td>
                            <td>{{ $student->user->username }}</td>
                            <td>{{ $student->section->year->description }}</td>
                            <td>{{ $student->section->name }}</td>
                            <td>
                                <a href="{{ route('backend.school-year.students.edit', array(SchoolYear::getActivated()->id, $student->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.students.destroy', array(SchoolYear::getActivated()->id, $student->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to un-enroll this?">Un-enroll</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>

<!-- <div class="modal fade" id="pastRecords" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.students.pastRecords', SchoolYear::getActivated()->id), 'method'=>'GET')) }}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Past Records</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="example1">
                    <div class="col-md-12">
                        <label for="school_year" class="control-label">From School Year</label>
                        <select class="form-control" name="school_year" id="school_year">
                            <option value="">-----select-----</option>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}">{{ $year->school_year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="curriculum" class="control-label">Select Curriculum</label>
                        {{ 
                            Form::select(
                                'curriculum', 
                                array(), 
                                null,
                                array(
                                    'id'=>'curriculum', 
                                    'class'=>'form-control'
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-12">
                        <label for="first_name" class="control-label">Select Year Level</label>
                        {{ 
                            Form::select(
                                'year_level', 
                                array(), 
                                null,
                                array(
                                    'id'=>'years', 
                                    'class'=>'form-control'
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-12">
                        <label for="first_name" class="control-label">Select Section</label>
                        {{ 
                            Form::select(
                                'sections', 
                                array(), 
                                null,
                                array(
                                    'id'=>'sections', 
                                    'class'=>'form-control'
                                )
                            ) 
                        }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">View</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div> -->
@section('on-page-scripts')
<script>
    $(document).ready(function() {
        $(".view-past-records").on("click", function(e) {
            e.preventDefault();
            $("#pastRecords").modal();
        });

        // Setup - add a text input to each footer cell
        // $('#studentTable tfoot th').each( function (i) {
        //     var title = $('#studentTable thead th').eq( $(this).index() ).text();
        //     var search = '<input type="text" placeholder="Search ' + title + '" />';
        //     $(this).html('');
        //     $(search).appendTo(this).keyup(function(){table.fnFilter($(this).val(),i)})
        //     //$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        // } );
     
        $('#studentTable').DataTable();
        // DataTable
        // $('#studentTable').DataTable( {
        //     initComplete: function () {
        //         this.api().columns().every( function () {
        //             var column = this;
        //             console.log(column);
        //             var select = $('<select><option value=""></option></select>')
        //                 .appendTo( $(column.footer()).empty() )
        //                 .on( 'change', function () {
        //                     var val = $.fn.dataTable.util.escapeRegex(
        //                         $(this).val()
        //                     );
     
        //                     column
        //                         .search( val ? '^'+val+'$' : '', true, false )
        //                         .draw();
        //                 } );
     
        //             column.data().unique().sort().each( function ( d, j ) {
        //                 select.append( '<option value="'+d+'">'+d+'</option>' )
        //             } );
        //         } );
        //     }
        // } );
     
        // Apply the search
        // table.columns().every( function () {
        //     var that = this;
     
        //     $( 'input', this.footer() ).on( 'keyup change', function () {
        //         that
        //             .search( this.value )
        //             .draw();
        //     } );
        // } );

        $('#example1').cascadingDropdown({
            selectBoxes: [
                {
                    selector: '#school_year'
                },
                {
                    selector: '#curriculum',
                    requires: ['#school_year'],
                    source: function(request, response) {
                        $.getJSON('/backend/school-year/<?php echo SchoolYear::getActivated()->id ?>/curriculums/json', request, function(data) {
                            response($.map(data, function(item, index) {
                                return {
                                    label: item.label,
                                    value: item.value
                                }
                            }));
                        });
                    },
                    selected:'{{ Input::get("curriculum") ?:"" }}'
                },
                {
                    selector: '#years',
                    requires: ['#curriculum'],
                    source: function(request, response) {
                        $.getJSON('/backend/school-year/<?php echo SchoolYear::getActivated()->id ?>/year-level/json', request, function(data) {
                            response($.map(data, function(item, index) {
                                return {
                                    label: item.label,
                                    value: item.value
                                }
                            }));
                        });
                    }
                },
                {
                    selector: '#sections',
                    requires: ['#years'],
                    source: function(request, response) {
                        $.getJSON('/backend/school-year/<?php echo SchoolYear::getActivated()->id ?>/sections/json', request, function(data) {
                            response($.map(data, function(item, index) {
                                return {
                                    label: item.label,
                                    value: item.value
                                }
                            }));
                        });
                    }
                }
            ]
        });
    });
</script>
@stop

@stop