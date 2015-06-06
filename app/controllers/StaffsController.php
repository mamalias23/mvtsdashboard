<?php

class StaffsController extends \BaseController {

    public function __construct()
    {
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('records_personel');
    }

	/**
	 * Display a listing of the resource.
	 * GET /staffs
	 *
	 * @return Response
	 */
	public function index($school_year_id)
	{
		//get activated school year
        $yearActivated = SchoolYear::find($school_year_id);
        $staffs = $yearActivated->staffs()->get();
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        return View::make('staffs.index', compact('staffs', 'years'));
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

        //get activated school year
        $yearActivated = SchoolYear::find(Input::get('school_year'));
        $staffs = $yearActivated->staffs()->get();
        $years = SchoolYear::where('id', '<>', $school_year_id)->orderBy('school_year')->get();
        return View::make('staffs.past-records', compact('staffs', 'years'));
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /staffs/create
	 *
	 * @return Response
	 */
	public function create($school_year_id)
    {
        //get activated school year
        $yearActivated = SchoolYear::getActivated();

        $availableStaffs = array();
        $group = Sentry::findGroupByName('Other Staffs');
        $users = Sentry::findAllUsersInGroup($group);
        foreach($users as $user) {
            $staff_check = Staff::where('school_year_id',$yearActivated->id)->where('user_id',$user->id)->get();
            if($staff_check->count()==0) {
                $availableStaffs[$user->id] = $user->first_name . " " . $user->middle_initial . ". " . $user->last_name;
            }
        }
        return View::make('staffs.create', compact('availableStaffs'));
    }

	/**
	 * Store a newly created resource in storage.
	 * POST /staffs
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
                    $group = Sentry::findGroupByName('Other Staffs');
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
            $group = Sentry::getGroupProvider()->findByName('Other Staffs');
            $user->addGroup($group);

            $staff = new Staff;
            $staff->school_year_id = $school_year_id;
            $staff->user_id = $user->id;
            $staff->save();

            DB::commit();

            return Redirect::route('backend.school-year.staffs.index', array($school_year_id))->withSuccess('Staff(s) has been successfully added.');

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
                    'staffs' => 'required',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $staffs = Input::get('staffs');
            foreach ($staffs as $key => $staff) {
                $user = User::find($staff);
                $staff = new Staff;
                $staff->school_year_id = $school_year_id;
                $staff->user_id = $user->id;
                $staff->save();
            }

            DB::commit();

            return Redirect::route('backend.school-year.staffs.index', array($school_year_id))->withSuccess('Staff(s) has been successfully added.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Display the specified resource.
	 * GET /staffs/{id}
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
	 * GET /staffs/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($school_year_id, $id)
    {
        $staff = Staff::find($id);
        if(!$staff)
            return Redirect::back()->withError('Staff not found');

        return View::make('staffs.edit', compact('staff'));
    }

	/**
	 * Update the specified resource in storage.
	 * PUT /staffs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($school_year_id, $id)
    {
        try {

            DB::beginTransaction();

            $staff = Staff::find($id);
            
            if(!$staff) {
                return Redirect::back()->withError('Staff not found');
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
                    'username' => 'required|unique:users,username,'.$staff->user->id,
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = Sentry::findUserById($staff->user->id);
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

            return Redirect::route('backend.school-year.staffs.index', array($school_year_id))->withSuccess('Staff has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	/**
	 * Remove the specified resource from storage.
	 * DELETE /staffs/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($school_year_id, $id) {
        try {

            DB::beginTransaction();

            $staff = Staff::find($id);
            if(!$staff) {
                return Redirect::back()->withError('Staff not found');
            }
            $staff->delete();

            DB::commit();
            
            return Redirect::route('backend.school-year.staffs.index', array($school_year_id))->withSuccess('Staff has been successfully deleted.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

}