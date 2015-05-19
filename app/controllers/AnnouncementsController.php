<?php

class AnnouncementsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /announcements
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /announcements/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
	{
        return View::make('announcements.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /announcements
	 *
	 * @return Response
	 */
	public function store($school_year_id)
	{
        $validator = Validator::make(
            Input::all(),
            array(
                'title' => 'required',
                'body' => 'required',
                'users'=>'required',
            ),
            array(
                'users.required' => 'Oh crap! who will receive the announcement? please select receiver(s)',
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $announcement = new Announcement;
        $announcement->sender_id = Sentry::getUser()->id;
        $announcement->school_year_id = $school_year_id;
        $announcement->title = Input::get('title');
        $announcement->body = Input::get('body');
        if(Sentry::getUser()->hasAccess('admin'))
            $announcement->status = 2;
        $announcement->save();

        $announcement = Announcement::find($announcement->id);
        $announcement->receivers()->sync(Input::get('users'));

        if($announcement->status==2 && Input::has('sms')) {
            foreach($announcement->receivers()->get() as $receiver) {
                SMS::message($receiver, $announcement);
            }
        }

        if(Sentry::getUser()->hasAccess('admin'))
            return Redirect::route('backend.school-year.announcements.create', array($school_year_id))->withSuccess('Announcement has been successfully sent');
	    else
            return Redirect::route('backend.school-year.announcements.create', array($school_year_id))->withSuccess('Announcement has been successfully saved, and is currently pending. Please let the admin know');
    }

	/**
	 * Display the specified resource.
	 * GET /announcements/{id}
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
	 * GET /announcements/{id}/edit
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
	 * PUT /announcements/{id}
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
	 * DELETE /announcements/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}