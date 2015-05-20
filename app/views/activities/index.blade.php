@extends('layouts.default')

@section('content-header')

  <h1>
    Activities / Events
  </h1>
  <ol class="breadcrumb">
    <!-- <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Examples</a></li> -->
    <li class="active">Activities / Events</li>
  </ol>

@stop

@section('content')

    <div class="box" ng-controller="ActivitiesController">
        <div class="box-header with-border">
            <h3 class="box-title">Activities / Events</h3>
            <div class="box-tools pull-right">
                <a href="javascript:;" class="btn btn-xs btn-info" ng-click="test()">Add new</a>
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <h2 class="text-center">@{{ calendarTitle }}</h2>
            <div class="row">

                <div class="col-md-6 text-center">
                  <div class="btn-group">

                    <button
                      class="btn btn-primary"
                      mwl-date-modifier
                      date="calendarDay"
                      decrement="calendarView">
                      Previous
                    </button>
                    <button
                      class="btn btn-default"
                      mwl-date-modifier
                      date="calendarDay"
                      set-to-today>
                      Today
                    </button>
                    <button
                      class="btn btn-primary"
                      mwl-date-modifier
                      date="calendarDay"
                      increment="calendarView">
                      Next
                    </button>
                  </div>
                </div>

                <br class="visible-xs visible-sm">

                <div class="col-md-6 text-center">
                  <div class="btn-group">
                    <label class="btn btn-primary" ng-model="calendarView" btn-radio="'year'">Year</label>
                    <label class="btn btn-primary" ng-model="calendarView" btn-radio="'month'">Month</label>
                    <label class="btn btn-primary" ng-model="calendarView" btn-radio="'week'">Week</label>
                    <label class="btn btn-primary" ng-model="calendarView" btn-radio="'day'">Day</label>
                  </div>
                </div>

              </div>
              <br />
            <mwl-calendar
                events="events"
                view="calendarView"
                view-title="calendarTitle"
                current-day="calendarDay"
                on-event-click="eventClicked(calendarEvent)"
                edit-event-html="'<i class=\'glyphicon glyphicon-pencil\'></i>'"
                delete-event-html="'<i class=\'glyphicon glyphicon-remove\'></i>'"
                on-edit-event-click="eventEdited(calendarEvent)"
                on-delete-event-click="eventDeleted(calendarEvent)"
                auto-open="true"
                day-view-start="06:00"
                day-view-end="22:00"
                day-view-split="30">
            </mwl-calendar>
        </div><!-- /.box-body -->
    </div>
  <!-- /.box -->

 <script type="text/ng-template" id="myModalContent.html">
      <div class="modal-header">
          <h3 class="modal-title">@{{ event.title }}</h3>
      </div>
      <div class="modal-body">
          @{{ event }}
      </div>
      <div class="modal-footer">
          <button class="btn btn-primary" ng-click="ok()">OK</button>
          <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
      </div>
 </script>

@stop