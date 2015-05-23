@extends('layouts.default')

@section('content-header')

<h1>
    Sections
    <small></small>
</h1>
<ol class="breadcrumb">
<!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Sections</li>
</ol>

@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sections</h3>
                <div class="box-tools pull-right">
                    <a href="{{ route('backend.school-year.sections.create', array(SchoolYear::getActivated()->id)) }}" class="btn btn-xs btn-info">Add new</a>
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped dynamic">
                    <thead>
                        <tr>
                            <th>Curriculum</th>
                            <th>Year Level</th>
                            <th>Name</th>
                            <th>Adviser</th>
                            <th data-orderable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sections as $section)
                        <tr>
                            <td>{{ $section->curriculum->name }}</td>
                            <td>{{ $section->year->level }} - {{ $section->year->description }}</td>
                            <td>{{ $section->name }}</td>
                            <td>{{ $section->adviser ? '<a href="'.route('backend.school-year.teachers.show', array(SchoolYear::getActivated()->id, $section->adviser->id)).'">'.$section->adviser->user->first_name . " " . $section->adviser->user->last_name.'</a>' : 'No Adviser'; }}</td>
                            <td>
                                @if(!$section->adviser)
                                <a
                                    href="javascript:;"
                                    data-id="{{ $section->id }}"
                                    data-curriculum="{{ $section->curriculum_id }}"
                                    data-name="{{ $section->name }}"
                                    class="btn btn-xs btn-info assign-adviser"
                                >Assign Adviser</a>
                                @else
                                    <a href="{{ route('backend.school-year.sections.removeAdviser', array(SchoolYear::getActivated()->id, $section->id)) }}" class="btn btn-xs btn-warning" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to remove the adviser?">Remove Adviser</a>
                                @endif
                                <a href="{{ route('backend.school-year.sections.edit', array(SchoolYear::getActivated()->id, $section->id)) }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="{{ route('backend.school-year.sections.destroy', array(SchoolYear::getActivated()->id, $section->id)) }}" class="btn btn-xs btn-danger" data-method="delete" rel="nofollow" data-confirm="Are you sure you want to delete this?">Delete</a>
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

<div class="modal fade" id="modal-adviser" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAdviser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('route'=>array('backend.school-year.sections.storeAdviser', SchoolYear::getActivated()->id))) }}
            {{
                Form::hidden(
                    'hidden_id',
                    null,
                    array(
                        'id'=>'hidden_id_section',
                    )
                )
            }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabelAdviser">Assign Adviser</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-top:15px">
                    <div class="col-md-12">
                        <label for="teacher_id" class="control-label">Select Teacher</label>
                        {{
                            Form::select(
                                'teacher_id',
                                $availableTeachers,
                                null,
                                array(
                                    'id'=>'teacher_id',
                                    'class'=>'form-control',
                                    'data-rule-required'=>'true'
                                )
                            )
                        }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="submit" value="add" class="btn btn-primary">Save</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@section('on-page-scripts')
<script>
    $(document).ready(function() {
        $(".assign-adviser").on("click", function(e) {
            e.preventDefault();
            $("#modal-adviser").modal();
            $("#myModalLabelAdviser").html("Assign Adviser");
            $("#hidden_id_section").val($(this).data('id'));
        });
    });
</script>
@stop

@stop