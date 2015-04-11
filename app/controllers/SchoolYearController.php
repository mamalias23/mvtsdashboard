<?php

class SchoolYearController extends BaseController {

	public function __construct() 
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('admin');
	}

	public function getIndex()
	{
        $years = SchoolYear::orderBy('school_year')->get();
		return View::make('school-year.index', compact('years'));
	}

    public function postIndex()
    {
        $validator = Validator::make(
            Input::all(),
            array(
                'school_year' => 'required|unique:school_year'
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $year = new SchoolYear;
        $year->school_year = Input::get('school_year');
        if(Input::get('submit')=='add_activate') {
            SchoolYear::where('activated',1)->update(['activated'=>0]);
            $year->activated = true;
        }
        $year->save();

        return Redirect::back()->withSuccess('School Year has been successfully added.');

    }

    public function getDelete($id)
    {
        try {

            $year = SchoolYear::find($id);
            if(!$year)
                return Redirect::to('/backend/school-year')->withError('School year not found!');
            if($year->activated)
                return Redirect::to('/backend/school-year')->withError('You cannot delete the activated school year');
            
            $tempYear = $year->school_year;
            $year->delete();

            return Redirect::back()->withSuccess('School year "'.$tempYear.'" has been successfully deleted.');

        } catch(Exception $e) {
            return Redirect::to('/backend/school-year')->withError('Unable to delete school year; maybe it is used? hmm please check');
        }
        
    }

    public function getActivate($id)
    {
        $year = SchoolYear::find($id);
        if(!$year)
            return Redirect::to('/backend/school-year')->withError('School year not found!');

        SchoolYear::where('activated',1)->update(['activated'=>0]);
        $year->activated = true;
        $year->save();

        return Redirect::back()->withSuccess('School year "'.$year->school_year.'" has been successfully activated.');
    }
 
}