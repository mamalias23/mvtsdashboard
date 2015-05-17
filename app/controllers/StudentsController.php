<?php

class StudentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /students
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
        //get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $students = $yearActivated->students()->get();
        return View::make('students.index', compact('students'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /students/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
	{
        $username = mt_rand();
        return View::make('students.create', compact('username'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /students
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
                'full_address' => Input::get('full_address'),
                'guardian'=>Input::get('is_guardian', 0),
                'mother'=>Input::get('is_mother', 0),
                'father'=>Input::get('is_father', 0),
                'guardian_full_name'=>Input::has('is_guardian') ? Input::get('guardian_full_name'):null,
                'guardian_mobile'=>Input::has('is_guardian') ? Input::get('guardian_mobile'):null,
                'mother_full_name'=>Input::has('is_mother') ? Input::get('mother_full_name'):null,
                'mother_mobile'=>Input::has('is_mother') ? Input::get('mother_mobile'):null,
                'father_full_name'=>Input::has('is_father') ? Input::get('father_full_name'):null,
                'father_mobile'=>Input::has('is_father') ? Input::get('father_mobile'):null,
            ));

            $user = Sentry::getUserProvider()->findByLogin(Input::get('username'));
            $group = Sentry::getGroupProvider()->findByName('Students');
            $user->addGroup($group);

            DB::commit();

            return Redirect::back()->withSuccess('Student Information has been successfully saved.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

    public function enroll($school_year_id)
    {
        $availableStudents = array();
        $group = Sentry::findGroupByName('Students');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $student_check = Student::where('school_year_id',$school_year_id)->where('user_id',$user->id)->get();
            if($student_check->count()==0) {
                $availableStudents[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }

        $curriculums = Curriculum::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $curriculumsArray = array();
        $curriculumsArray[''] = "";
        foreach ($curriculums as $curriculum) {
            $curriculumsArray[$curriculum->id] = $curriculum->name;
        }

        $years = YearLevel::where('school_year_id',$school_year_id)->orderBy('level')->get();
        $yearLevels = array();
        $yearLevels[''] = "";
        foreach ($years as $year) {
            $yearLevels[$year->id] = $year->description;
        }

        return View::make('students.enroll', compact('yearLevels', 'curriculumsArray', 'availableStudents'));
    }

    public function storeEnroll($school_year_id)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make(
                Input::all(),
                array(
                    'section'=>'required',
                    'students' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $students = Input::get('students');
            foreach ($students as $key => $student) {
                $user = User::find($student);
                $student = new Student;
                $student->school_year_id = $school_year_id;
                $student->user_id = $user->id;
                $student->section_id = Input::get('section');
                $student->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.students.index', array($school_year_id))->withSuccess('Student(s) has been successfully enrolled.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Display the specified resource.
	 * GET /students/{id}
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
	 * GET /students/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
	{
        $student = Student::find($id);
        if(!$student)
            return Redirect::back()->withError('Student not found');
        return View::make('students.edit', compact('student'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /students/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
	{
        try {

            DB::beginTransaction();

            $student = Student::find($id);

            if(!$student) {
                return Redirect::back()->withError('Student not found');
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
                    'username' => 'required|unique:users,username,'.$student->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($student->user->id);
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
            $user->guardian=Input::get('is_guardian', 0);
            $user->mother=Input::get('is_mother', 0);
            $user->father=Input::get('is_father', 0);
            $user->guardian_full_name=Input::has('is_guardian') ? Input::get('guardian_full_name'):null;
            $user->guardian_mobile=Input::has('is_guardian') ? Input::get('guardian_mobile'):null;
            $user->mother_full_name=Input::has('is_mother') ? Input::get('mother_full_name'):null;
            $user->mother_mobile=Input::has('is_mother') ? Input::get('mother_mobile'):null;
            $user->father_full_name=Input::has('is_father') ? Input::get('father_full_name'):null;
            $user->father_mobile=Input::has('is_father') ? Input::get('father_mobile'):null;
            $user->save();

            DB::commit();

            return Redirect::route('backend.school-year.students.index', array($school_year_id))->withSuccess('Student has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /students/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
        try {

            DB::beginTransaction();

            $student = Student::find($id);
            if(!$student) {
                return Redirect::back()->withError('Student not found');
            }
            $student->delete();

            DB::commit();

            return Redirect::route('backend.school-year.students.index', array($school_year_id))->withSuccess('Student has been successfully un-enrolled.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

}