<?php

class RegistrarsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('records_personel');
    }
	/**
	 * Display a listing of the resource.
	 * GET /registrars
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		//get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $registrars = $yearActivated->registrars()->get();
        return View::make('registrars.index', compact('registrars'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /registrars/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();

        $availableRegistrars = array();
        $group = Sentry::findGroupByName('Registrars');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $registrar_check = Registrar::where('school_year_id',$yearActivated->id)->where('user_id',$user->id)->get();
            if($registrar_check->count()==0) {
                $availableRegistrars[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }
        return View::make('registrars.create', compact('availableRegistrars'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /registrars
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
            $group = Sentry::getGroupProvider()->findByName('Registrars');
            $user->addGroup($group);

            $registrar = new Registrar;
            $registrar->school_year_id = $school_year_id;
            $registrar->user_id = $user->id;
            $registrar->save();

            DB::commit();

            return Redirect::route('backend.school-year.registrars.index', array($school_year_id))->withSuccess('Registrar(s) has been successfully added.');

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
                    'registrars' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $registrars = Input::get('registrars');
            foreach ($registrars as $key => $registrar) {
                $user = User::find($registrar);
                $registrar = new Registrar;
                $registrar->school_year_id = $school_year_id;
                $registrar->user_id = $user->id;
                $registrar->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.registrars.index', array($school_year_id))->withSuccess('Registrar(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Display the specified resource.
	 * GET /registrars/{id}
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
	 * GET /registrars/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
    {
        $registrar = Registrar::find($id);
        if(!$registrar)
            return Redirect::back()->withError('Registrar not found');

        return View::make('registrars.edit', compact('registrar'));
    }

	/**
	 * Update the specified resource in storage.
	 * PUT /registrars/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $registrar = Registrar::find($id);
            
            if(!$registrar) {
                return Redirect::back()->withError('Registrar not found');
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
                    'username' => 'required|unique:users,username,'.$registrar->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($registrar->user->id);
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

            return Redirect::route('backend.school-year.registrars.index', array($school_year_id))->withSuccess('Registrar has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /registrars/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id) {
        try {

            DB::beginTransaction();

            $registrar = Registrar::find($id);
            if(!$registrar) {
                return Redirect::back()->withError('Registrar not found');
            }
            $registrar->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.registrars.index', array($school_year_id))->withSuccess('Registrar has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

}