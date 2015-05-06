<?php

class DepartmentsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /departments
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		$departments = Department::where('school_year_id',$school_year_id)->orderBy('name')->get();
        return View::make('departments.index', compact('departments'));
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
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        if($hidden_id)
            $department = Department::find($hidden_id);
        else
            $department = new Department;
        $department->school_year_id = $school_year_id;
        $department->name = Input::get('name');
        $department->save();

        if($hidden_id)
            return Redirect::back()->withSuccess('Department has been successfully updated.');
        else
            return Redirect::back()->withSuccess('Department has been successfully added.');
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
		$department = Department::find($id);
        if(!$department)
            return Redirect::route('backend.school-year.departments.index', array($school_year_id))->withError('Department not found!');
        
        $temp = $department->name;
        $department->delete();

        return Redirect::back()->withSuccess('Department "'.$temp.'" has been successfully deleted.');
	}

}