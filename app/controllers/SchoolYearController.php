<?php

class SchoolYearController extends BaseController {

	public function __construct() 
	{
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->beforeFilter('admin');
	}

	public function index()
	{
        $years = SchoolYear::orderBy('school_year')->get();
		return View::make('school-year.index', compact('years'));
	}

    public function store()
    {
        try {
            DB::beginTransaction();

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

            //if they selected a previous school year, that means they want to copy records
            if(Input::get('from_year')) {
                if(Input::has('copy')) { //ofcourse we copy only the one they'd checked
                    $copies = Input::get('copy');
                    ksort($copies);
                    foreach($copies as $copy) {

                        if($copy=='curriculums') {
                            $curriculums = Curriculum::where('school_year_id', Input::get('from_year'))->get();
                            foreach($curriculums as $curriculum) {
                                $newCurriculum = new Curriculum();
                                $newCurriculum->name = $curriculum->name;
                                $newCurriculum->user_id = $curriculum->user_id;
                                $newCurriculum->school_year_id = $year->id;
                                $newCurriculum->save();
                            }
                        } elseif($copy=='departments') {
                            $departments = Department::where('school_year_id', Input::get('from_year'))->get();
                            foreach($departments as $department) {
                                $newDepartment = new Department();
                                $newDepartment->curriculum_id = Curriculum::where('name', $department->curriculum->name)->where('school_year_id',$year->id)->get()->first()->id;
                                $newDepartment->school_year_id = $year->id;
                                if($department->teacher_id) {
                                    $teacher_user_id = $department->head->user_id;
                                    $teacher = Teacher::where('user_id', $teacher_user_id)->where('school_year_id', $year->id)->get()->first();
                                    if($teacher) {
                                        $newDepartment->teacher_id = $teacher->id;
                                    }
                                }
                                $newDepartment->name = $department->name;
                                $newDepartment->save();
                            }
                        } elseif($copy=='year_levels') {
                            $year_levels = YearLevel::where('school_year_id', Input::get('from_year'))->get();
                            foreach($year_levels as $year_level) {
                                $yearlevel = new YearLevel();
                                $yearlevel->curriculum_id = Curriculum::where('name', $year_level->curriculum->name)->where('school_year_id', $year->id)->get()->first()->id;
                                $yearlevel->school_year_id = $year->id;
                                $yearlevel->level = $year_level->level;
                                $yearlevel->description = $year_level->description;
                                $yearlevel->save();
                            }
                        } elseif($copy=='sections') {
                            $sections = Section::where('school_year_id', Input::get('from_year'))->get();
                            foreach($sections as $section) {
                                $newSection = new Section();
                                $newSection->curriculum_id = Curriculum::where('name', $section->curriculum->name)->where('school_year_id', $year->id)->get()->first()->id;
                                $newSection->school_year_id = $year->id;
                                $newSection->year_level_id = YearLevel::where('level', $section->year->level)->where('description', $section->year->description)->where('school_year_id', $year->id)->get()->first()->id;
                                if($section->teacher_id) {
                                    $teacher_user_id = $section->adviser->user_id;
                                    $teacher = Teacher::where('user_id', $teacher_user_id)->where('school_year_id', $year->id)->get()->first();
                                    if($teacher) {
                                        $newSection->teacher_id = $teacher->id;
                                    }
                                }
                                $newSection->name = $section->name;
                                $newSection->save();
                            }
                        } elseif($copy=='subjects') {
                            $subjects = Subject::where('school_year_id', Input::get('from_year'))->get();
                            foreach($subjects as $subject) {
                                $newSubject = new Subject();
                                $newSubject->year_level_id = YearLevel::where('level', $subject->year->level)->where('description', $subject->year->description)->where('school_year_id', $year->id)->get()->first()->id;
                                $newSubject->school_year_id = $year->id;
                                $newSubject->department_id = Department::where('name', $subject->department->name)->where('school_year_id',$year->id)->get()->first()->id;
                                $newSubject->name = $subject->name;
                                $newSubject->major = $subject->major;
                                $newSubject->save();
                            }
                        } elseif($copy=='school_records_personel') {
                            $personels = SchoolRecordPersonel::where('school_year_id', Input::get('from_year'))->get();
                            foreach($personels as $personel) {
                                $newPersonel = new SchoolRecordPersonel();
                                $newPersonel->school_year_id = $year->id;
                                $newPersonel->user_id = $personel->user_id;
                                $newPersonel->save();
                            }
                        } elseif($copy=='teachers') {
                            $teachers = Teacher::where('school_year_id', Input::get('from_year'))->get();
                            foreach($teachers as $teacher) {
                                $newTeacher = new Teacher();
                                $newTeacher->school_year_id = $year->id;
                                $newTeacher->user_id = $teacher->user_id;
                                $newTeacher->save();

                                //save also the subjects :( kapoy! haha
//                                if($teacher->subjects()->get()->count()) {
//                                    $oldSubjects = $teacher->subjects()->get();
//                                    $newSubjects = array();
//                                    foreach($oldSubjects as $oldSubject) {
//                                        $subject = Subject::where('school_year_id', $year->id)
//                                                ->where('name', $oldSubject->name)->get()->first(); //not a good practice :( query would be tricky if we ensure
//                                        if($subject)
//                                            $newSubjects[] = $subject->id;
//                                    }
//
//                                    $newTeacher->subjects()->sync($newSubjects);
//                                }
                            }
                        } elseif($copy=='registrars') {
                            $registrars = Registrar::where('school_year_id', Input::get('from_year'))->get();
                            foreach($registrars as $registrar) {
                                $newRegistrar = new Registrar();
                                $newRegistrar->school_year_id = $year->id;
                                $newRegistrar->user_id = $registrar->user_id;
                                $newRegistrar->save();
                            }
                        } elseif($copy=='guards') {
                            $guards = Guard::where('school_year_id', Input::get('from_year'))->get();
                            foreach($guards as $guard) {
                                $newGuard = new Guard();
                                $newGuard->school_year_id = $year->id;
                                $newGuard->user_id = $guard->user_id;
                                $newGuard->save();
                            }
                        } elseif($copy=='other_staffs') {
                            $staffs = Staff::where('school_year_id', Input::get('from_year'))->get();
                            foreach($staffs as $staff) {
                                $newStaff = new Staff();
                                $newStaff->school_year_id = $year->id;
                                $newStaff->user_id = $staff->user_id;
                                $newStaff->save();
                            }
                        }
                    }
                }

            }

            DB::commit();

            return Redirect::back()->withSuccess('School Year has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }

    }

    public function destroy($id)
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

    public function activate($id)
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