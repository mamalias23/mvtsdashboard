<?php

class TeachersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /teachers
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		//get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $teachers = $yearActivated->teachers()->get();
        return View::make('teachers.index', compact('teachers'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /teachers/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();

        $availableTeachers = array();
        $group = Sentry::findGroupByName('Teachers');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $teacher_check = Teacher::where('school_year_id',$yearActivated->id)->where('user_id',$user->id)->get();
            if($teacher_check->count()==0) {
                $availableTeachers[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }
        return View::make('teachers.create', compact('availableTeachers'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /teachers
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
            $group = Sentry::getGroupProvider()->findByName('Teachers');
            $user->addGroup($group);

            $teacher = new Teacher;
            $teacher->school_year_id = $school_year_id;
            $teacher->user_id = $user->id;
            $teacher->save();

            DB::commit();

            return Redirect::route('backend.school-year.teachers.index', array($school_year_id))->withSuccess('Teacher(s) has been successfully added.');

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
                    'teachers' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $teachers = Input::get('teachers');
            foreach ($teachers as $key => $teacher) {
                $user = User::find($teacher);
                $teacher = new Teacher;
                $teacher->school_year_id = $school_year_id;
                $teacher->user_id = $user->id;
                $teacher->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.teachers.index', array($school_year_id))->withSuccess('Teacher(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Display the specified resource.
	 * GET /teachers/{id}
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
	 * GET /teachers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
    {
        $teacher = Teacher::find($id);
        if(!$teacher)
            return Redirect::back()->withError('Teacher not found');

        return View::make('teachers.edit', compact('teacher'));
    }

	/**
	 * Update the specified resource in storage.
	 * PUT /teachers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $teacher = Teacher::find($id);
            
            if(!$teacher) {
                return Redirect::back()->withError('Teacher not found');
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
                    'username' => 'required|unique:users,username,'.$teacher->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($teacher->user->id);
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

            return Redirect::route('backend.school-year.teachers.index', array($school_year_id))->withSuccess('Teacher has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /teachers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id) {
        try {

            DB::beginTransaction();

            $teacher = Teacher::find($id);
            if(!$teacher) {
                return Redirect::back()->withError('Teacher not found');
            }
            $teacher->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.teachers.index', array($school_year_id))->withSuccess('Teacher has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

}