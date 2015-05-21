<?php

class ActivitiesController extends \BaseController
{

    /**
     * Display a listing of the resource.
     * GET /activities
     *
     * @return Response
     */
    public function index()
    {
        return View::make('activities.index');
    }

    public function lists()
    {
        $out = array();
        $users = Sentry::findAllUsersWithAnyAccess(array('teachers', 'registrar', 'school_records_personel', 'others', 'guard'));

        foreach($users as $user) {

            $currentYear = intval(date("Y", strtotime("now")));
            $userMonth = date("m", strtotime($user->birthdate));
            $userDay = date("d", strtotime($user->birthdate));

            for($year = $currentYear; $year<=($currentYear+99); $year++) {
                $userBday = date("Y-m-d H:i:s", strtotime($year . "-" . $userMonth . "-" . $userDay . " 00:00:00"));
                $out[] = array(
                    'title' => $user->first_name . " " . $user->middle_initial . ". " . $user->last_name,
                    'body' => $user->first_name . " " . $user->middle_initial . ". " . $user->last_name . " Birthday",
                    'type' => 'warning',
                    'startsAt' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $userBday)->toIso8601String(),
                    'endsAt' => \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $userBday)->addHours(24)->toIso8601String(),
                    'editable'=>false,
                    'deletable'=>false,
                );

            }
        }


        $activities = Activity::get();
        foreach($activities as $activity) {
            $out[] = array(
                'id'=>$activity->id,
                'title'=>$activity->title,
                'body'=>$activity->body,
                'type'=>$activity->type,
                'startsAt'=>$activity->starts_at->toIso8601String(),
                'endsAt'=>$activity->ends_at->toIso8601String(),
                'editable'=>false,
                'deletable'=>Sentry::getUser()->id == $activity->user_id ? true:false,
            );
        }

        return $out;
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /activities/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /activities
	 *
	 * @return Response
	 */
	public function store()
	{
        $validator = Validator::make(
            Input::all(),
            array(
                'title' => 'required',
                'body' => 'required',
                'startsAt'=>'required',
                'endsAt'=>'required',
            )
        );

        if($validator->fails()) {
            return Response::json(array('error'=>'all fields are required'), 500);
        }

        if($validator->passes()) {
            $activity = new Activity;
            $activity->user_id = Sentry::getUser()->id;
            $activity->type = Input::get('type','info');
            $activity->title = Input::get('title');
            $activity->body = Input::get('body');
            $activity->starts_at = date('Y-m-d H:i:s', strtotime(Input::get('startsAt')));
            $activity->ends_at = date('Y-m-d H:i:s', strtotime(Input::get('endsAt')));
            $activity->save();

            $activity = Activity::find($activity->id);
            $activity->startsAt = $activity->starts_at->toIso8601String();
            $activity->endsAt = $activity->ends_at->toIso8601String();
            $activity->editable = false;
            $activity->deletable = true;

            return $activity;
        }
	}

	/**
	 * Display the specified resource.
	 * GET /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /activities/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /activities/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$activity = Activity::find($id);
        $activity->delete();
	}

}