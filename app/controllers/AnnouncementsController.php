<?php

class AnnouncementsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('auth');
        $this->beforeFilter('admin', ['only'=>['approve']]);
    }
	/**
	 * Display a listing of the resource.
	 * GET /announcements
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
        $announcements = Announcement::where('school_year_id', $school_year_id)->orderBy('created_at', 'DESC')->get();
        return View::make('announcements.index', compact('announcements'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /announcements/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
	{
        if(Sentry::getUser()->groups()->first()->name=='Students' || Sentry::getUser()->groups()->first()->name=='Parents or Guardians') {
            return Redirect::to('/backend/dashboard')->withError('Permission Denied');
        }
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
        try {

            DB::beginTransaction();

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

            $groups = array();

            if(Input::get('group')) {
                foreach (Input::get('group') as $group) {
                    $groups[$group] = 1;
                }
            }

            $new_groups = json_encode($groups);

            $announcement = new Announcement;
            $announcement->sender_id = Sentry::getUser()->id;
            $announcement->school_year_id = $school_year_id;
            $announcement->title = Input::get('title');
            $announcement->body = Input::get('body');
            $announcement->receivers_group = Input::get('group') ? $new_groups:'';
            if(Sentry::getUser()->hasAccess('admin'))
                $announcement->status = 2;
            $announcement->save();

            $announcement = Announcement::find($announcement->id);
            $announcement->receivers()->sync(Input::get('users'));

//            if($announcement->status==2) {
//                foreach($announcement->receivers()->get() as $receiver) {
//                    SMS::message($receiver, $announcement);
//                }
//            }

            DB::commit();

            if(Sentry::getUser()->hasAccess('admin'))
                return Redirect::route('backend.school-year.announcements.create', array($school_year_id))->withSuccess('Announcement has been successfully sent');
            else
                return Redirect::route('backend.school-year.announcements.create', array($school_year_id))->withSuccess('Announcement has been successfully saved, and is currently pending. Please let the admin know');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
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
	public function edit($school_year_id, $id)
	{
        $announcement = Announcement::find($id);
        //dd($announcement->created_at);
        $groups = json_decode($announcement->receivers_group, true);
        return View::make('announcements.edit', compact('announcement', 'groups'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /announcements/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
	{
        try {

            DB::beginTransaction();

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

            $groups = array();

            if(Input::get('group')) {
                foreach (Input::get('group') as $group) {
                    $groups[$group] = 1;
                }
            }

            $new_groups = json_encode($groups);

            $announcement = Announcement::find($id);

            if(!$announcement) {
                return Redirect::back()->withError('Announcement not found');
            }

            if($announcement->sender_id == Sentry::getUser()->id || Sentry::getUser()->hasAccess('admin')) {

                $announcement->school_year_id = $school_year_id;
                $announcement->title = Input::get('title');
                $announcement->body = Input::get('body');
                $announcement->receivers_group = Input::get('group') ? $new_groups : '';
                //if(Sentry::getUser()->hasAccess('admin'))
                //$announcement->status = 2;
                $announcement->save();

                $announcement = Announcement::find($announcement->id);
                $announcement->receivers()->sync(Input::get('users'));
            } else {
                return Redirect::back()->withError('Permission denied!');
            }


            DB::commit();

            return Redirect::back()->withSuccess('Announcement has been successfully updated');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

    public function approve($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $announcement = Announcement::find($id);
            if(!$announcement) {
                return Redirect::back()->withError('Announcement not found');
            }

            if($announcement->status==2) {
                return Redirect::back()->withError('Announcement already approved!');
            }

            $announcement->status = 2;
            $announcement->save();

            //send the sms
//            foreach($announcement->receivers()->get() as $receiver) {
//                SMS::message($receiver, $announcement);
//            }

            DB::commit();

            return Redirect::back()->withSuccess('Announcement has been successfully approved, and sent through sms');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /announcements/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
		$announcement = Announcement::find($id);

        if(!$announcement) {
            return Redirect::back()->withError('Announcement not found');
        }

        if($announcement->sender_id == Sentry::getUser()->id || Sentry::getUser()->hasAccess('admin')) {
            $announcement->delete();
            return Redirect::back()->withSuccess('Announcement has been successfully deleted');
        } else {
            return Redirect::back()->withError('Permission denied!');
        }
	}

}