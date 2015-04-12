<?php

class SchoolRecordsPersonelController extends BaseController {

    public function __construct() 
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('admin');
    }

    public function getIndex()
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();
        if(!$yearActivated)
            return Redirect::back()->withError('Please activate a school year'); 

        $personels = $yearActivated->records_personel()->get();

        return View::make('school-records-personel.index', compact('personels'));
    }

    public function getNew()
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

    public function postNew()
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

            //get activated school year
            $yearActivated = SchoolYear::getActivated();
            if(!$yearActivated)
                return Redirect::back()->withError('Please activate a school year'); 

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
            $personel->school_year_id = $yearActivated->id;
            $personel->user_id = $user->id;
            $personel->save();

            DB::commit();

            return Redirect::to('backend/school-records-personel')->withSuccess('Personel has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
        

    }

    public function postNewFromExisting()
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

            //get activated school year
            $yearActivated = SchoolYear::getActivated();
            if(!$yearActivated)
                return Redirect::back()->withError('Please activate a school year'); 

            $personels = Input::get('personels');
            foreach ($personels as $key => $personel) {
                $user = User::find($personel);
                $personel = new SchoolRecordPersonel;
                $personel->school_year_id = $yearActivated->id;
                $personel->user_id = $user->id;
                $personel->save();
            }

            DB::commit();

            return Redirect::to('backend/school-records-personel')->withSuccess('Personel(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function getEdit($id)
    {
        $personel = SchoolRecordPersonel::find($id);
        if(!$personel)
            return Redirect::back()->withError('Personel not found');

        return View::make('school-records-personel.edit', compact('personel'));
    }

    public function postEdit($id)
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

            //get activated school year
            $yearActivated = SchoolYear::getActivated();
            if(!$yearActivated)
                return Redirect::back()->withError('Please activate a school year'); 

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

            return Redirect::to('backend/school-records-personel')->withSuccess('Personel has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

    public function getDelete($id) {
        try {

            DB::beginTransaction();

            $personel = SchoolRecordPersonel::find($id);
            if(!$personel) {
                return Redirect::back()->withError('Personel not found');
            }
            $personel->delete();

            DB::commit();
            return Redirect::to('backend/school-records-personel')->withSuccess('Personel has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }
 
}
