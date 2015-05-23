<?php

class SchoolRecordsPersonelController extends BaseController {

    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('admin');
    }

    public function index($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $personels = $yearActivated->records_personel()->get();
        return View::make('school-records-personel.index', compact('personels'));
    }

    public function create($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();

        $availablePersonels = array();
        $group = Sentry::findGroupByName('School Records Personel');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $records_personel_check = SchoolRecordPersonel::where('school_year_id',$yearActivated->id)->where('user_id',$user->id)->get();
            if($records_personel_check->count()==0) {
                $availablePersonels[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }
        return View::make('school-records-personel.new', compact('availablePersonels'));
    }

    public function store($school_year_id)
    {
        try {

            DB::beginTransaction();

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
                    // Find the group
                    $group = Sentry::findGroupByName('School Records Personel');
                    if($u->inGroup($group)) {
                        return Redirect::back()->withError("Information already exists, please check the name")->withInput();
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
                'full_address' => Input::get('full_address')
            ));

            $user = Sentry::getUserProvider()->findByLogin(Input::get('username'));
            $group = Sentry::getGroupProvider()->findByName('School Records Personel');
            $user->addGroup($group);

            $personel = new SchoolRecordPersonel;
            $personel->school_year_id = $school_year_id;
            $personel->user_id = $user->id;
            $personel->save();

            DB::commit();

            return Redirect::route('backend.school-year.personels.index', array($school_year_id))->withSuccess('Personel(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
        

    }

    public function storeFromExisting($school_year_id)
    {
        try {

            DB::beginTransaction();

            $validator = Validator::make(
                Input::all(),
                array(
                    'personels' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $personels = Input::get('personels');
            foreach ($personels as $key => $personel) {
                $user = User::find($personel);
                $personel = new SchoolRecordPersonel;
                $personel->school_year_id = $school_year_id;
                $personel->user_id = $user->id;
                $personel->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.personels.index', array($school_year_id))->withSuccess('Personel(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function edit($school_year_id, $id)
    {
        $personel = SchoolRecordPersonel::find($id);
        if(!$personel)
            return Redirect::back()->withError('Personel not found');

        return View::make('school-records-personel.edit', compact('personel'));
    }

    public function update($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $personel = SchoolRecordPersonel::find($id);
            
            if(!$personel) {
                return Redirect::back()->withError('Personel not found');
            }

            $validator = Validator::make(
                Input::all(),
                array(
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'gender' => 'required',
                    'full_address' => 'required',
                    'birthdate' => 'required|date',
                    'mobile' => 'required|size:13',
                    'username' => 'required|unique:users,username,'.$personel->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($personel->user->id);
            $user->username = Input::get('username');
            if(Input::get('password'))
                $user->password = Input::get('password');
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->middle_initial = Input::get('middle_initial');
            $user->gender = Input::get('gender');
            $user->birthdate = Input::get('birthdate');
            $user->mobile_number = Input::get('mobile');
            $user->full_address = Input::get('full_address');
            $user->save();

            DB::commit();

            return Redirect::route('backend.school-year.personels.index', array($school_year_id))->withSuccess('Personel has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function destroy($school_year_id, $id) {
        try {

            DB::beginTransaction();

            $personel = SchoolRecordPersonel::find($id);
            if(!$personel) {
                return Redirect::back()->withError('Personel not found');
            }
            $personel->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.personels.index', array($school_year_id))->withSuccess('Personel has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }
 
}
