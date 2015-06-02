@extends('layouts.default')

@section('content-header')

<h1>
    Edit Page
    <small></small>
</h1>
<ol class="breadcrumb">
    <li><a href="{{ url('backend') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('backend.pages.index') }}">Pages</a></li>
    <li class="active">Edit</li>
</ol>

@stop

@section('on-page-styles')

    <link href="{{ asset('bower_components/redactor/redactor/redactor.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .pages .row {
            margin-bottom: 15px;
        }
    </style>

@stop

@section('content')
{{ Form::open(array('route'=>array('backend.pages.update', $page->id), 'id'=>'frm', 'method'=>'PUT')) }}
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Page</h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body pages">
                <div class="row">
                    <div class="col-md-12" ng-init="title='{{ $page->title }}'">
                        <label for="first_name" class="control-label">Title</label>
                        {{
                            Form::text(
                                'title',
                                $page->title,
                                array(
                                    'id'=>'title',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                    'ng-model' => 'title',
                                )
                            )
                        }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="first_name" class="control-label">Slug</label>
                        {{
                            Form::text(
                                'slug',
                                $page->slug,
                                array(
                                    'id'=>'slug',
                                    'class'=>'form-control',
                                    'ng-model'=>'title | slugify',
                                    'readonly'=>'true'
                                )
                            )
                        }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="first_name" class="control-label">URL: </label>
                        {{ url() }}/pages/@{{ title | slugify }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="first_name" class="control-label">Body</label>
                        {{
                            Form::textarea(
                                'body',
                                $page->body,
                                array(
                                    'id'=>'body',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true',
                                )
                            )
                        }}
                    </div>
                </div>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <button type="submit" class="btn btn-success btn-lg">SAVE</button>
        </div>
    </div>
</div>
{{ Form::close() }}
@section('on-page-scripts')

    <script src="{{ asset('bower_components/redactor/redactor/redactor.min.js') }}"></script>
    <script>
        $(function()
        {
            $('#body').redactor({
                minHeight: 300, // pixels
                imageUpload: '/backend/images/upload'
            });
        });
    </script>

@stop

@stop