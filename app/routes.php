<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix'=>'backend'), function() {

	Route::controller('dashboard', 'DashboardController');
	Route::controller('user', 'UserController');

	Route::get('school-year/{school_year}/activate', ['as' => 'backend.school-year.activate', 'uses' => 'SchoolYearController@activate']);
	Route::resource('school-year', 'SchoolYearController');

    Route::get('school-year/{school_year}/year-level/past-record', ['as' => 'backend.school-year.year-level.pastRecords', 'uses' => 'YearLevelController@pastRecords']);
	Route::get('school-year/{school_year}/year-level/json', ['as' => 'backend.school-year.year-level.json', 'uses' => 'YearLevelController@json']);
    Route::resource('school-year.year-level', 'YearLevelController');

    Route::get('school-year/{school_year}/curriculums/past-record', ['as' => 'backend.school-year.curriculums.pastRecords', 'uses' => 'CurriculumsController@pastRecords']);
    Route::resource('school-year.curriculums', 'CurriculumsController');

    Route::get('school-year/{school_year}/personels/past-record', ['as' => 'backend.school-year.personels.pastRecords', 'uses' => 'SchoolRecordsPersonelController@pastRecords']);
    Route::post('school-year/{school_year}/personels/existing', ['as' => 'backend.school-year.personels.storeFromExisting', 'uses' => 'SchoolRecordsPersonelController@storeFromExisting']);
	Route::resource('school-year.personels', 'SchoolRecordsPersonelController');

    Route::get('school-year/{school_year}/departments/past-record', ['as' => 'backend.school-year.departments.pastRecords', 'uses' => 'DepartmentsController@pastRecords']);
    Route::post('school-year/{school_year}/departments/store-head', ['as' => 'backend.school-year.departments.storeHead', 'uses' => 'DepartmentsController@storeHead']);
	Route::get('school-year/{school_year}/departments/json', ['as' => 'backend.school-year.departments.json', 'uses' => 'DepartmentsController@json']);
    Route::delete('school-year/{school_year}/departments/{departments}/remove-head', ['as' => 'backend.school-year.departments.removeHead', 'uses' => 'DepartmentsController@removeHead']);
	Route::resource('school-year.departments', 'DepartmentsController');

    Route::get('school-year/{school_year}/sections/past-record', ['as' => 'backend.school-year.sections.pastRecords', 'uses' => 'SectionsController@pastRecords']);
    Route::post('school-year/{school_year}/sections/store-adviser', ['as' => 'backend.school-year.sections.storeAdviser', 'uses' => 'SectionsController@storeAdviser']);
    Route::get('school-year/{school_year}/sections/json', ['as' => 'backend.school-year.sections.json', 'uses' => 'SectionsController@json']);
    Route::delete('school-year/{school_year}/sections/{sections}/remove-adviser', ['as' => 'backend.school-year.sections.removeAdviser', 'uses' => 'SectionsController@removeAdviser']);
	Route::resource('school-year.sections', 'SectionsController');

    Route::get('school-year/{school_year}/subjects/past-record', ['as' => 'backend.school-year.subjects.pastRecords', 'uses' => 'SubjectsController@pastRecords']);
	Route::resource('school-year.subjects', 'SubjectsController');

    Route::get('school-year/{school_year}/teachers/past-record', ['as' => 'backend.school-year.teachers.pastRecords', 'uses' => 'TeachersController@pastRecords']);
	Route::post('school-year/{school_year}/teachers/{teachers}/advisory', ['as' => 'backend.school-year.teachers.advisory', 'uses' => 'TeachersController@advisory']);
	Route::post('school-year/{school_year}/teachers/{teachers}/subjects', ['as' => 'backend.school-year.teachers.subjects', 'uses' => 'TeachersController@subjects']);
	Route::post('school-year/{school_year}/teachers/existing', ['as' => 'backend.school-year.teachers.storeFromExisting', 'uses' => 'TeachersController@storeFromExisting']);
	Route::resource('school-year.teachers', 'TeachersController');

    Route::get('school-year/{school_year}/registrars/past-record', ['as' => 'backend.school-year.registrars.pastRecords', 'uses' => 'RegistrarsController@pastRecords']);
	Route::post('school-year/{school_year}/registrars/existing', ['as' => 'backend.school-year.registrars.storeFromExisting', 'uses' => 'RegistrarsController@storeFromExisting']);
	Route::resource('school-year.registrars', 'RegistrarsController');

    Route::get('school-year/{school_year}/guards/past-record', ['as' => 'backend.school-year.guards.pastRecords', 'uses' => 'GuardsController@pastRecords']);
	Route::post('school-year/{school_year}/guards/existing', ['as' => 'backend.school-year.guards.storeFromExisting', 'uses' => 'GuardsController@storeFromExisting']);
	Route::resource('school-year.guards', 'GuardsController');

    Route::get('school-year/{school_year}/staffs/past-record', ['as' => 'backend.school-year.staffs.pastRecords', 'uses' => 'StaffsController@pastRecords']);
	Route::post('school-year/{school_year}/staffs/existing', ['as' => 'backend.school-year.staffs.storeFromExisting', 'uses' => 'StaffsController@storeFromExisting']);
	Route::resource('school-year.staffs', 'StaffsController');

    Route::get('school-year/{school_year}/students/past-record', ['as' => 'backend.school-year.students.pastRecords', 'uses' => 'StudentsController@pastRecords']);
    Route::get('school-year/{school_year}/students/enroll', ['as' => 'backend.school-year.students.enroll', 'uses' => 'StudentsController@enroll']);
    Route::post('school-year/{school_year}/students/enroll', ['as' => 'backend.school-year.students.storeEnroll', 'uses' => 'StudentsController@storeEnroll']);
    Route::resource('school-year.students', 'StudentsController');

    Route::get('school-year/{school_year}/announcements/past-record', ['as' => 'backend.school-year.announcements.pastRecords', 'uses' => 'AnnouncementsController@pastRecords']);
    Route::get('school-year/{school_year}/announcements/{announcements}/approve', ['as' => 'backend.school-year.announcements.approve', 'uses' => 'AnnouncementsController@approve']);
    Route::resource('school-year.announcements', 'AnnouncementsController');

    Route::get('activities/lists', ['as' => 'backend.activities.lists', 'uses' => 'ActivitiesController@lists']);
    Route::resource('activities', 'ActivitiesController');

    Route::controller('my-advisory', 'AdvisoriesController');

    Route::resource('chats', 'ChatsController');

    Route::resource('pages', 'PagesController');

    Route::post('images/upload', function() {
        $image = Input::file('file');
        $filename = Uuid::generate(4);
        $saveUrl = base_path().'/public/images/uploads/'.$filename.'.jpg';

        Image::make($image->getRealPath())->save($saveUrl);

        $array = array(
            'filelink' => url('images/uploads/' .$filename. '.jpg')
        );

        return stripslashes(json_encode($array));
    });

});

Route::get('/test-sms', function() {

    //$sms = Twilio::from('+18124965904')->to('+639086082188')->message('this is a test message..');
    $sid = "AC147dceeb8ec57e4347457eb5ff74d3be"; // Your Account SID from www.twilio.com/user/account
    $token = "feed0a30cc3cdd7090ed5f4452215969"; // Your Auth Token from www.twilio.com/user/account

    $client = new Services_Twilio($sid, $token);
    $message = $client->account->messages->sendMessage(
        '+13344685575', // From a valid Twilio number
        '+639086082188', // Text this number
        "Hello monkey!"
    );

    return $message->sid;

});



Route::post('voice/reply', function() {
    return Response::view('sms.message')->header('Content-Type', 'text/xml');
});

Route::get('testxml', function()
{
    $data = [
            'Say' => 'Thank you for enquiring your announcement',
            'Sms' => 'Thanks'
    ];
    return Response::xml($data);
});

Route::get('/', function()
{
    return View::make('front-end.index');
});

Route::get('/pages/{slug}', 'FPagesController@showPage');
Route::get('contact', 'FPagesController@contact');
Route::get('monitor', 'FPagesController@monitor');
Route::controller('announcements', 'FAnnouncementsController');
