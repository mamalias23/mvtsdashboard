<?php

class SectionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /sections
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		$sections = Section::where('school_year_id',$school_year_id)->orderBy('name')->get();
        return View::make('sections.index', compact('sections'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /sections/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
	{
        $years = YearLevel::where('school_year_id',$school_year_id)->orderBy('level')->get();
        $yearLevels = array();
        $yearLevels[''] = "";
        foreach ($years as $year) {
        	$yearLevels[$year->id] = $year->description;
        }
        return View::make('sections.create', compact('yearLevels'));
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
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $section = new Section;
            $section->school_year_id = $school_year_id;
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
		$years = YearLevel::where('school_year_id',$school_year_id)->orderBy('level')->get();
        $yearLevels = array();
        $yearLevels[''] = "";
        foreach ($years as $year) {
        	$yearLevels[$year->id] = $year->description;
        }

		$section = Section::find($id);
        if(!$section)
            return Redirect::back()->withError('Section not found');

        return View::make('sections.edit', compact('section', 'yearLevels'));
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
                    'name' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $section->year_level_id = Input::get('year_level');
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

}