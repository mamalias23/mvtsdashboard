<?php

class SectionsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('curriculum_department', array('except'=>array('json')));
    }

	/**
	 * Display a listing of the resource.
	 * GET /sections
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{

        $availableTeachers = array();
        $availableTeachers[""] = "";
        $group = Sentry::findGroupByName('Teachers');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $teacher_exists_in_school_year = Teacher::where('school_year_id',$school_year_id)->where('user_id', $user->id)->first();
            if($teacher_exists_in_school_year) {
                $teacher_check = Section::where('school_year_id',$school_year_id)->where('teacher_id',$teacher_exists_in_school_year->id)->get();
                if($teacher_check->count()==0) {
                    $availableTeachers[$teacher_exists_in_school_year->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
                }
            }
        }

		$years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
		$sections = Section::where('school_year_id',$school_year_id)->orderBy('name')->get();
        return View::make('sections.index', compact('sections', 'availableTeachers', 'years'));
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

        $availableTeachers = array();
        $availableTeachers[""] = "";
        $group = Sentry::findGroupByName('Teachers');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $teacher_exists_in_school_year = Teacher::where('school_year_id',Input::get('school_year'))->where('user_id', $user->id)->first();
            if($teacher_exists_in_school_year) {
                $teacher_check = Section::where('school_year_id',Input::get('school_year'))->where('teacher_id',$teacher_exists_in_school_year->id)->get();
                if($teacher_check->count()==0) {
                    $availableTeachers[$teacher_exists_in_school_year->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
                }
            }
        }

        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        $sections = Section::where('school_year_id',Input::get('school_year'))->orderBy('name')->get();
        return View::make('sections.past-records', compact('sections', 'availableTeachers', 'years'));
    }

    public function json() {
        $sections = Section::where('year_level_id',Input::get('year_level'))->orderBy('name')->get();
        $out = array();
        $out[] = array('label'=>'', 'value'=>'');
        foreach ($sections as $section) {
            $out[] = array(
                'label'=>$section->name,
                'value'=>$section->id
            );
        }
        echo json_encode($out);
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /sections/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
	{
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
        return View::make('sections.create', compact('yearLevels', 'curriculumsArray'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sections
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
                    'year_level' => 'required',
                    'curriculum' => 'required',
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $section = new Section;
            $section->school_year_id = $school_year_id;
            $section->curriculum_id = Input::get('curriculum');
            $section->year_level_id = Input::get('year_level');
            $section->name = Input::get('name');
            $section->save();

            DB::commit();

            return Redirect::route('backend.school-year.sections.index', array($school_year_id))->withSuccess('Section has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

    public function storeAdviser($school_year_id)
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

        $section = Section::find($hidden_id);
        $section->teacher_id = Input::get('teacher_id');
        $section->save();

        return Redirect::back()->withSuccess('Section has been successfully updated.');

    }

	/**
	 * Display the specified resource.
	 * GET /sections/{id}
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
	 * GET /sections/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
	{
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

		$section = Section::find($id);
        if(!$section)
            return Redirect::back()->withError('Section not found');

        return View::make('sections.edit', compact('section', 'yearLevels', 'curriculumsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sections/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
	{
		try {

            DB::beginTransaction();

            $section = Section::find($id);
            
            if(!$section) {
                return Redirect::back()->withError('Section not found');
            }

            $validator = Validator::make(
                Input::all(),
                array(
                    'year_level' => 'required',
                    'curriculum' => 'required',
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $section->year_level_id = Input::get('year_level');
            $section->curriculum_id = Input::get('curriculum');
            $section->name = Input::get('name');
            $section->save();

            DB::commit();

            return Redirect::route('backend.school-year.sections.index', array($school_year_id))->withSuccess('Section has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /sections/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
		try {

            DB::beginTransaction();

            $section = Section::find($id);
            
            if(!$section) {
                return Redirect::back()->withError('Section not found');
            }

            $section->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.sections.index', array($school_year_id))->withSuccess('Section has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

    public function removeAdviser($school_year_id, $id)
    {
        $section = Section::find($id);
        if(!$section)
            return Redirect::route('backend.school-year.sections.index', array($school_year_id))->withError('Section not found!');

        $section->teacher_id = NULL;
        $section->save();

        return Redirect::back()->withSuccess('Section has been successfully updated.');
    }

}