<?php

class DepartmentsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('curriculum_department', array('except'=>array('json')));
    }

	/**
	 * Display a listing of the resource.
	 * GET /departments
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		$curriculums = Curriculum::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $curriculumsArray = array();
        $curriculumsArray[''] = "";
        foreach ($curriculums as $curriculum) {
        	$curriculumsArray[$curriculum->id] = $curriculum->name;
        }

        $availableTeachers = array();
        $availableTeachers[""] = "";
        $group = Sentry::findGroupByName('Teachers');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $teacher_exists_in_school_year = Teacher::where('school_year_id',$school_year_id)->where('user_id', $user->id)->first();
            if($teacher_exists_in_school_year) {
                $teacher_check = Department::where('school_year_id',$school_year_id)->where('teacher_id',$teacher_exists_in_school_year->id)->get();
                if($teacher_check->count()==0) {
                    $availableTeachers[$teacher_exists_in_school_year->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
                }
            }
        }
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
		$departments = Department::where('school_year_id',$school_year_id)->orderBy('name')->get();
        return View::make('departments.index', compact('departments', 'curriculumsArray', 'availableTeachers', 'years'));
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
        $curriculumsArray = array();
        $curriculumsArray[''] = "";
        foreach ($curriculums as $curriculum) {
            $curriculumsArray[$curriculum->id] = $curriculum->name;
        }

        $availableTeachers = array();
        $availableTeachers[""] = "";
        $group = Sentry::findGroupByName('Teachers');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $teacher_exists_in_school_year = Teacher::where('school_year_id',Input::get('school_year'))->where('user_id', $user->id)->first();
            if($teacher_exists_in_school_year) {
                $teacher_check = Department::where('school_year_id',Input::get('school_year'))->where('teacher_id',$teacher_exists_in_school_year->id)->get();
                if($teacher_check->count()==0) {
                    $availableTeachers[$teacher_exists_in_school_year->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
                }
            }
        }
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        $departments = Department::where('school_year_id',Input::get('school_year'))->orderBy('name')->get();
        return View::make('departments.past-records', compact('departments', 'curriculumsArray', 'availableTeachers', 'years'));
    }

	public function json() {
        $departments = Department::where('curriculum_id',Input::get('curriculum'))->orderBy('name')->get();
        $out = array();
        $out[] = array('label'=>'', 'value'=>'');
        foreach ($departments as $department) {
            $out[] = array(
                'label'=>$department->name,
                'value'=>$department->id
            );
        }
        echo json_encode($out);
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /departments/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /departments
	 *
	 * @return Response
	 */
	public function store($school_year_id)
	{
		$hidden_id = Input::get('hidden_id');

        $validator = Validator::make(
            Input::all(),
            array(
                'name' => 'required',
                'curriculum' => 'required',
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        if($hidden_id) {
            $department = Department::find($hidden_id);
        } else {
            $department = new Department;

            //check if exists
            if(Department::where('school_year_id', $school_year_id)->where('curriculum_id', Input::get('curriculum'))->where('name', 'LIKE', Input::get('name'))->get()->count()) {
                return Redirect::back()->withError('Department already exists.');
            }
        }
        $department->school_year_id = $school_year_id;
        $department->curriculum_id = Input::get('curriculum');
        $department->name = Input::get('name');
        $department->save();

        if($hidden_id)
            return Redirect::back()->withSuccess('Department has been successfully updated.');
        else
            return Redirect::back()->withSuccess('Department has been successfully added.');
	}

    public function storeHead($school_year_id)
    {
        $hidden_id = Input::get('hidden_id');

        $validator = Validator::make(
            Input::all(),
            array(
                'teacher_id' => 'required'
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $teacher = Teacher::find(Input::get('teacher_id'));
        if(!$teacher) {
            return Redirect::back()->withError('Teacher not found.');
        }

        $department = Department::find($hidden_id);
        $department->teacher_id = Input::get('teacher_id');
        $department->save();

        $user = Sentry::findUserById($teacher->user->id);
        $group = Sentry::getGroupProvider()->findByName('Department Heads');
        $user->addGroup($group);

        return Redirect::back()->withSuccess('Department has been successfully updated.');

    }

	/**
	 * Display the specified resource.
	 * GET /departments/{id}
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
	 * GET /departments/{id}/edit
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
	 * PUT /departments/{id}
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
	 * DELETE /departments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
        try {

            $department = Department::find($id);
            if(!$department)
                return Redirect::route('backend.school-year.departments.index', array($school_year_id))->withError('Department not found!');

            if($department->teacher_id) {
                $teacher = Teacher::find($department->teacher_id);
                $user = Sentry::findUserById($teacher->user->id);
                $group = Sentry::getGroupProvider()->findByName('Department Heads');
                $user->removeGroup($group);
            }

            $temp = $department->name;
            $department->delete();

            return Redirect::back()->withSuccess('Department "'.$temp.'" has been successfully deleted.');

        } catch(Exception $e) {
            return Redirect::to('/backend/school-year')->withError('Unable to delete department; maybe it is used? hmm please check');
        }
	}

    public function removeHead($school_year_id, $id)
    {
        $department = Department::find($id);
        if(!$department)
            return Redirect::route('backend.school-year.departments.index', array($school_year_id))->withError('Department not found!');

        $teacher = Teacher::find($department->teacher_id);
        $user = Sentry::findUserById($teacher->user->id);
        $group = Sentry::getGroupProvider()->findByName('Department Heads');
        $user->removeGroup($group);

        $department->teacher_id = NULL;
        $department->save();

        return Redirect::back()->withSuccess('Department has been successfully updated.');
    }

}