<?php

class SubjectsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('department_heads');
    }

    /**
	 * Display a listing of the resource.
	 * GET /subjects
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		$subjects = Subject::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        return View::make('subjects.index', compact('subjects', 'years'));
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

        $subjects = Subject::where('school_year_id',Input::get('school_year'))->orderBy('name')->get();
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        return View::make('subjects.past-records', compact('subjects', 'years'));
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /subjects/create
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

        $departments = Department::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $departmentLists = array();
        $departmentLists[''] = "";
        foreach ($departments as $department) {
        	$departmentLists[$department->id] = $department->name;
        }

        return View::make('subjects.create', compact('yearLevels', 'departmentLists', 'curriculumsArray'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /subjects
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
                    'department' => 'required',
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $subject = new Subject;
            $subject->school_year_id = $school_year_id;
            $subject->year_level_id = Input::get('year_level');
            $subject->department_id = Input::get('department');
            $subject->name = Input::get('name');
            $subject->major = Input::get('major', 0);
            $subject->save();

            DB::commit();

            return Redirect::route('backend.school-year.subjects.index', array($school_year_id))->withSuccess('Subject has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

	/**
	 * Display the specified resource.
	 * GET /subjects/{id}
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
	 * GET /subjects/{id}/edit
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

        $departments = Department::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $departmentLists = array();
        $departmentLists[''] = "";
        foreach ($departments as $department) {
        	$departmentLists[$department->id] = $department->name;
        }

		$subject = Subject::find($id);
        if(!$subject)
            return Redirect::back()->withError('Subject not found');

        return View::make('subjects.edit', compact('subject', 'yearLevels', 'departmentLists', 'curriculumsArray'));
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /subjects/{id}
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
                    'year_level' => 'required',
                    'department' => 'required',
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $subject = Subject::find($id);
            $subject->year_level_id = Input::get('year_level');
            $subject->department_id = Input::get('department');
            $subject->name = Input::get('name');
            $subject->major = Input::get('major', 0);
            $subject->save();

            DB::commit();

            return Redirect::route('backend.school-year.subjects.index', array($school_year_id))->withSuccess('Subject has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /subjects/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id)
	{
		try {

            DB::beginTransaction();

            $subject = Subject::find($id);
            
            if(!$subject) {
                return Redirect::back()->withError('Subject not found');
            }

            $subject->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.subjects.index', array($school_year_id))->withSuccess('Subject has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
	}

}