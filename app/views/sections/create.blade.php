@extends('layouts.default')

@section('content-header')

<h1>
    New Section
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.school-year.sections.index', array(SchoolYear::getActivated()->id)) }}">Section</a></li>
    <li class="active">New</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">New Section</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {{ Form::open(array('route'=>array('backend.school-year.sections.store', SchoolYear::getActivated()->id))) }}
                <div class="row" id="example1">
                    <div class="col-md-4">
                        <label for="curriculum" class="control-label">Select Curriculum</label>
                        {{ 
                            Form::select(
                                'curriculum', 
                                $curriculumsArray, 
                                null,
                                array(
                                    'id'=>'curriculum', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-4">
                        <label for="first_name" class="control-label">Select Year Level</label>
                        {{ 
                            Form::select(
                                'year_level', 
                                array(), 
                                null,
                                array(
                                    'id'=>'years', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                    <div class="col-md-4">
                        <label for="last_name" class="control-label">Name</label>
                        {{ 
                            Form::text(
                                'name', 
                                null, 
                                array(
                                    'id'=>'name', 
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            ) 
                        }}
                    </div>
                </div>
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success">SAVE</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
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

        $('#example1').cascadingDropdown({
            selectBoxes: [
                {
                    selector: '#curriculum'
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
                }
            ]
        });
    });
</script>

@stop

@stop