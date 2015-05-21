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
            @if(Sentry::getUser()->hasAccess('admin'))
                <a href="javascript:;" class="btn btn-xs btn-info" ng-click="addEvent()">Add new</a>
            @endif
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
                delete-event-html="'<i class=\'glyphicon glyphicon-remove\' style=\'color:red\'></i>'"
                on-edit-event-click="eventEdited(calendarEvent)"
                on-delete-event-click="eventDeleted(calendarEvent)"
                auto-open="false"
                day-view-start="00:00"
                day-view-end="23:00"
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
          <p>
            @{{ event.body }}
          </p>
      </div>
      <div class="modal-footer">
          <button class="btn btn-warning" ng-click="cancel()">OK</button>
      </div>
 </script>

  <script type="text/ng-template" id="myAddModalContent.html">
       <div class="modal-header">
           <h3 class="modal-title">Add new Activity / Event</h3>
       </div>
       <div class="modal-body">
           <div class="row">
                <div class="col-md-12">
                    <label for="title" class="control-label">Title</label>
                    <input type="text" ng-model="event.title" class="form-control" name="title" />
                </div>
                <div class="col-md-12" style="margin-top: 15px">
                    <label for="body" class="control-label">Body</label>
                    <textarea ng-model="event.body" class="form-control" rows="15" name="body"></textarea>
                </div>
                <div class="col-md-6" style="margin-top: 15px">
                    <label class="control-label">Starts @</label>
                    <p class="input-group" style="max-width: 250px">
                        <input type="text" class="form-control" readonly datepicker-popup="medium" ng-model="event.startsAt" is-open="event.startOpen" close-text="Close" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default" ng-click="toggle($event, 'startOpen', event)"><i class="glyphicon glyphicon-calendar"></i></button>
                        </span>
                    </p>
                    <timepicker ng-model="event.startsAt" hour-step="1" minute-step="15" show-meridian="true"></timepicker>
                </div>

                <div class="col-md-6" style="margin-top: 15px">
                    <label class="control-label">Ends @</label>
                    <p class="input-group" style="max-width: 250px">
                        <input type="text" class="form-control" readonly datepicker-popup="medium" ng-model="event.endsAt" is-open="event.endOpen" close-text="Close" />
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default" ng-click="toggle($event, 'endOpen', event)"><i class="glyphicon glyphicon-calendar"></i></button>
                        </span>
                    </p>
                    <timepicker ng-model="event.endsAt" hour-step="1" minute-step="15" show-meridian="true"></timepicker>
                </div>

           </div>
       </div>
       <div class="modal-footer">
           <button class="btn btn-primary" ng-click="submitEvent()">Save</button>
           <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
       </div>
  </script>

@stop