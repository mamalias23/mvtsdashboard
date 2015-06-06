<?php

class CurriculumsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('admin', array('except'=>array('json')));
    }

	/**
	 * Display a listing of the resource.
	 * GET /curriculums
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		$curriculums = Curriculum::where('school_year_id',$school_year_id)->orderBy('name')->get();
		$years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        return View::make('curriculums.index', compact('curriculums', 'years'));
	}

	public function pastRecords($school_year_id)
	{
		$validator = Validator::make(
            Request::all(),
            array(
                'school_year' => 'required'
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

		$curriculums = Curriculum::where('school_year_id',Input::get('school_year'))->orderBy('name')->get();
		$years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
		$pastRecords = 1;
        return View::make('curriculums.past-records', compact('curriculums', 'years', 'pastRecords'));
	}

	public function json() {
        $curriculums = Curriculum::where('school_year_id',Input::get('school_year'))->orderBy('name')->get();
        $out = array();
        $out[] = array('label'=>'', 'value'=>'');
        foreach ($curriculums as $curriculum) {
            $out[] = array(
                'label'=>$curriculum->name,
                'value'=>$curriculum->id
            );
        }
        echo json_encode($out);
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /curriculums/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /curriculums
	 *
	 * @return Response
	 */
	public function store($school_year_id)
	{
		$hidden_id = Input::get('hidden_id');
		$user_id = $hidden_id ? Curriculum::find($hidden_id)->user->id : 0;
        $validator = Validator::make(
            Input::all(),
            array(
                'name' => 'required',
                'user_username' => 'required|unique:users,username,' . $user_id,
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        if(!$hidden_id) {
	        $user = Sentry::getUserProvider()->create(array(
	            'username'    => Input::get('user_username'),
	            'password' => Input::get('user_password') ?: '12345678',
	            'activated' => 1,
	            'first_name' => Input::get('first_name'),
	        ));

	        $user = Sentry::getUserProvider()->findByLogin(Input::get('user_username'));
	        $group = Sentry::getGroupProvider()->findByName('Curriculum departments');
	        $user->addGroup($group);
        }

        if($hidden_id) {
            $curriculum = Curriculum::find($hidden_id);

            $user = $curriculum->user;
            $user->username = Input::get('user_username');
            if(Input::get('user_password')) {
            	$user->password = Hash::make(Input::get('user_password'));
            }
            $user->first_name = Input::get('first_name');
            $user->save();

        } else {
            $curriculum = new Curriculum;

            //check if exists
            if(Curriculum::where('school_year_id', $school_year_id)->where('name', 'LIKE', Input::get('name'))->get()->count()) {
                return Redirect::back()->withError('Curriculum is already exists');
            }
        }
        $curriculum->school_year_id = $school_year_id;
        $curriculum->user_id = $user->id;
        $curriculum->name = Input::get('name');
        $curriculum->save();

        if($hidden_id)
            return Redirect::back()->withSuccess('Curriculum has been successfully updated.');
        else
            return Redirect::back()->withSuccess('Curriculum has been successfully added.');
	}

	/**
	 * Display the specified resource.
	 * GET /curriculums/{id}
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
	 * GET /curriculums/{id}/edit
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
	 * PUT /curriculums/{id}
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
	 * DELETE /curriculums/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
		$curriculum = Curriculum::find($id);
        if(!$curriculum)
            return Redirect::route('backend.school-year.curriculums.index', array($school_year_id))->withError('Curriculum not found!');
        
        $temp = $curriculum->name;
        $curriculum->delete();

        return Redirect::back()->withSuccess('Curriculum "'.$temp.'" has been successfully deleted.');
	}

}