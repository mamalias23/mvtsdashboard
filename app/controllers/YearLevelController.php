<?php

class YearLevelController extends BaseController {

    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('admin');
    }

    public function getIndex()
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated() ? SchoolYear::getActivated()->id:0;

        $years = YearLevel::where('school_year_id',$yearActivated)->orderBy('level')->get();
        return View::make('year-level.index', compact('years'));
    }

    public function postIndex()
    {

        $hidden_id = Input::get('hidden_id');

        $validator = Validator::make(
            Input::all(),
            array(
                'level' => 'required|unique:year_levels,level,'.$hidden_id,
                'description' => 'required',
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        //get activated school year
        $yearActivated = SchoolYear::getActivated();
        if(!$yearActivated)
            return Redirect::back()->withError('Please activate a school year'); 

        
        if($hidden_id)
            $year = YearLevel::find($hidden_id);
        else
            $year = new YearLevel;
        $year->school_year_id = $yearActivated->id;
        $year->level = Input::get('level');
        $year->description = Input::get('description');
        $year->save();

        if($hidden_id)
            return Redirect::back()->withSuccess('Year level has been successfully updated.');
        else
            return Redirect::back()->withSuccess('Year level has been successfully added.');
    }

    public function getDelete($id)
    {
        $year = YearLevel::find($id);
        if(!$year)
            return Redirect::to('/backend/year-level')->withError('Year level not found!');
        
        $tempYear = $year->description;
        $year->delete();

        return Redirect::back()->withSuccess('Year level "'.$tempYear.'" has been successfully deleted.');
    }
 
}