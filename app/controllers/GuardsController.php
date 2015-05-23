<?php

class GuardsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('records_personel');
    }

	/**
	 * Display a listing of the resource.
	 * GET /guards
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		//get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $guards = $yearActivated->guards()->get();
        return View::make('guards.index', compact('guards'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /guards/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();

        $availableGuards = array();
        $group = Sentry::findGroupByName('Guards');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $guard_check = Guard::where('school_year_id',$yearActivated->id)->where('user_id',$user->id)->get();
            if($guard_check->count()==0) {
                $availableGuards[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }
        return View::make('guards.create', compact('availableGuards'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /guards
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
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
                    'full_address' => 'required',
                    'birthdate' => 'required|date',
                    'mobile' => 'required|size:13',
                    'username' => 'required|unique:users,username',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            //check if exists
            $users = User::where('first_name', 'LIKE', Input::get('first_name'))
                ->where('last_name', 'LIKE', Input::get('last_name'))
                ->where('middle_initial', 'LIKE', Input::get('middle_initial'))
                ->get();

            if($users->count()) {
                foreach($users as $u) {
                    $u = Sentry::findUserById($u->id);
                    // Find the group
                    $group = Sentry::findGroupByName('Guards');
                    if($u->inGroup($group)) {
                        return Redirect::back()->withError("Information already exists, please check the name")->withInput();
                    }
                }
            }

            $user = Sentry::getUserProvider()->create(array(
                'username'    => Input::get('username'),
                'password' => Input::get('password') ?: '12345678',
                'activated' => 1,
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'middle_initial' => Input::get('middle_initial'),
                'gender' => Input::get('gender'),
                'birthdate' => Input::get('birthdate'),
                'mobile_number' => Input::get('mobile'),
                'full_address' => Input::get('full_address')
            ));

            $user = Sentry::getUserProvider()->findByLogin(Input::get('username'));
            $group = Sentry::getGroupProvider()->findByName('Guards');
            $user->addGroup($group);

            $guard = new Guard;
            $guard->school_year_id = $school_year_id;
            $guard->user_id = $user->id;
            $guard->save();

            DB::commit();

            return Redirect::route('backend.school-year.guards.index', array($school_year_id))->withSuccess('Guard(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
        

    }

    public function storeFromExisting($school_year_id)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make(
                Input::all(),
                array(
                    'guards' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $guards = Input::get('guards');
            foreach ($guards as $key => $guard) {
                $user = User::find($guard);
                $guard = new Guard;
                $guard->school_year_id = $school_year_id;
                $guard->user_id = $user->id;
                $guard->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.guards.index', array($school_year_id))->withSuccess('Guard(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Display the specified resource.
	 * GET /guards/{id}
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
	 * GET /guards/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
    {
        $guard = Guard::find($id);
        if(!$guard)
            return Redirect::back()->withError('Guard not found');

        return View::make('guards.edit', compact('guard'));
    }

	/**
	 * Update the specified resource in storage.
	 * PUT /guards/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $guard = Guard::find($id);
            
            if(!$guard) {
                return Redirect::back()->withError('Guard not found');
            }

            $validator = Validator::make(
                Input::all(),
                array(
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
                    'full_address' => 'required',
                    'birthdate' => 'required|date',
                    'mobile' => 'required|size:13',
                    'username' => 'required|unique:users,username,'.$guard->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($guard->user->id);
            $user->username = Input::get('username');
            if(Input::get('password'))
                $user->password = Input::get('password');
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->middle_initial = Input::get('middle_initial');
            $user->gender = Input::get('gender');
            $user->birthdate = Input::get('birthdate');
            $user->mobile_number = Input::get('mobile');
            $user->full_address = Input::get('full_address');
            $user->save();

            DB::commit();

            return Redirect::route('backend.school-year.guards.index', array($school_year_id))->withSuccess('Guard has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /guards/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id) {
        try {

            DB::beginTransaction();

            $guard = Guard::find($id);
            if(!$guard) {
                return Redirect::back()->withError('Guard not found');
            }
            $guard->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.guards.index', array($school_year_id))->withSuccess('Guard has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

}