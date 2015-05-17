<?php

class YearLevelController extends BaseController {

    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('admin');
    }

    public function index($school_year_id)
    {
        $curriculums = Curriculum::where('school_year_id',$school_year_id)->orderBy('name')->get();
        $curriculumsArray = array();
        $curriculumsArray[''] = "";
        foreach ($curriculums as $curriculum) {
            $curriculumsArray[$curriculum->id] = $curriculum->name;
        }
        $years = YearLevel::where('school_year_id',$school_year_id)->orderBy('level')->get();
        return View::make('year-level.index', compact('years', 'curriculumsArray'));
    }

    public function json() {
        $years = YearLevel::where('curriculum_id',Input::get('curriculum'))->orderBy('level')->get();
        $out = array();
        $out[] = array('label'=>'', 'value'=>'');
        foreach ($years as $year) {
            $out[] = array(
                'label'=>$year->description,
                'value'=>$year->id
            );
        }
        echo json_encode($out);
    }

    public function store($school_year_id)
    {

        $hidden_id = Input::get('hidden_id');

        $validator = Validator::make(
            Input::all(),
            array(
                'curriculum' => 'required',
                'level' => 'required',
                'description' => 'required',
            )
        );

        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        if($hidden_id)
            $year = YearLevel::find($hidden_id);
        else
            $year = new YearLevel;
        $year->school_year_id = $school_year_id;
        $year->curriculum_id = Input::get('curriculum');
        $year->level = Input::get('level');
        $year->description = Input::get('description');
        $year->save();

        if($hidden_id)
            return Redirect::back()->withSuccess('Year level has been successfully updated.');
        else
            return Redirect::back()->withSuccess('Year level has been successfully added.');
    }

    public function destroy($school_year_id, $id)
    {
        $year = YearLevel::find($id);
        if(!$year)
            return Redirect::to('/backend/year-level')->withError('Year level not found!');
        
        $tempYear = $year->description;
        $year->delete();

        return Redirect::back()->withSuccess('Year level "'.$tempYear.'" has been successfully deleted.');
    }
 
}