<?php

class AdvisoriesController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('advisory');
    }

	public function getIndex()
	{
        $user = User::find(Sentry::getUser()->id);
        $teacher = $user->teacher()->where('school_year_id', SchoolYear::getActivated()->id)->first();
		return View::make('advisories.index', compact('user', 'teacher'));
	}

    public function getAddStudents()
    {
        $availableStudents = array();
        $group = Sentry::findGroupByName('Students');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $student_check = Student::where('school_year_id',SchoolYear::getActivated()->id)->where('user_id',$user->id)->get();
            if($student_check->count()==0) {
                $availableStudents[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }

        $username = mt_rand();
        return View::make('advisories.add-student', compact('username', 'availableStudents'));
    }

    public function postAddStudentsOld()
    {
        try {

            DB::beginTransaction();

            $user = User::find(Sentry::getUser()->id);
            $teacher = $user->teacher()->where('school_year_id', SchoolYear::getActivated()->id)->first();

            $validator = Validator::make(
                Input::all(),
                array(
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
                $student->school_year_id = SchoolYear::getActivated()->id;
                $student->user_id = $user->id;
                $student->section_id = $teacher->advisory->id;
                $student->save();
            }

            DB::commit();

            return Redirect::to('backend/my-advisory')->withSuccess('Student(s) has been successfully enrolled.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function postAddStudents()
    {
        try {

            DB::beginTransaction();

            $user = User::find(Sentry::getUser()->id);
            $teacher = $user->teacher()->where('school_year_id', SchoolYear::getActivated()->id)->first();

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

            //check if exists
            $users = User::where('first_name', 'LIKE', Input::get('first_name'))
                ->where('last_name', 'LIKE', Input::get('last_name'))
                ->where('middle_initial', 'LIKE', Input::get('middle_initial'))
                ->get();

            if($users->count()) {
                foreach($users as $u) {
                    $u = Sentry::findUserById($u->id);
                    // Find the Student group
                    $student = Sentry::findGroupByName('Students');
                    if($u->inGroup($student)) {
                        return Redirect::back()->withError("Student Info already exists, please check the name")->withInput();
                    }
                }
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

            //enroll
            $student = new Student;
            $student->school_year_id = SchoolYear::getActivated()->id;
            $student->user_id = $user->id;
            $student->section_id = $teacher->advisory->id;
            $student->save();

            DB::commit();

            return Redirect::back()->withSuccess('Student has been successfully enrolled.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function deleteStudent($id)
    {
        try {

            DB::beginTransaction();

            $student = Student::find($id);
            if(!$student) {
                return Redirect::back()->withError('Student not found');
            }
            $student->delete();

            DB::commit();

            return Redirect::back()->withSuccess('Student has been successfully un-enrolled.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function getPostAnnouncement()
    {
        $user = User::find(Sentry::getUser()->id);
        $teacher = $user->teacher()->where('school_year_id', SchoolYear::getActivated()->id)->first();
        return View::make('advisories.post-announcement', compact('user','teacher'));
    }

    public function postPostAnnouncement()
    {
        try {

            DB::beginTransaction();

            $user = User::find(Sentry::getUser()->id);
            $teacher = $user->teacher()->where('school_year_id', SchoolYear::getActivated()->id)->first();

            $validator = Validator::make(
                Input::all(),
                array(
                    'title' => 'required',
                    'body' => 'required'
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $groups = array();

            if(Input::get('group')) {
                foreach (Input::get('group') as $group) {
                    $groups[$group] = 1;
                }
            }

            $new_groups = json_encode($groups);

            $announcement = new Announcement;
            $announcement->sender_id = Sentry::getUser()->id;
            $announcement->school_year_id = SchoolYear::getActivated()->id;
            $announcement->title = Input::get('title');
            $announcement->body = Input::get('body');
            $announcement->sms = Input::get('sms', 0);
            $announcement->receivers_group = Input::get('group') ? $new_groups:'';
            $announcement->status = 2;
            $announcement->save();

            $announcement = Announcement::find($announcement->id);
            $announcement->receivers()->sync(Input::get('users'));

            if($announcement->status==2) {
                if($announcement->sms) {
                    foreach ($announcement->receivers()->get() as $receiver) {
                        SMS::message($receiver, $announcement);
                    }
                }
            }

            DB::commit();

            return Redirect::back()->withSuccess('Announcement has been successfully sent');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

}