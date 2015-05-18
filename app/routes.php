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

Route::get('/', function()
{
	return Redirect::to('/backend/dashboard');
});

Route::get('/test', 'HomeController@showWelcome');

Route::group(array('prefix'=>'backend'), function() {

	Route::controller('dashboard', 'DashboardController');
	Route::controller('user', 'UserController');

	Route::get('school-year/{school_year}/activate', ['as' => 'backend.school-year.activate', 'uses' => 'SchoolYearController@activate']);
	Route::resource('school-year', 'SchoolYearController');
	Route::get('school-year/{school_year}/year-level/json', ['as' => 'backend.school-year.year-level.json', 'uses' => 'YearLevelController@json']);
    Route::resource('school-year.year-level', 'YearLevelController');
    Route::resource('school-year.curriculums', 'CurriculumsController');
    Route::post('school-year/{school_year}/personels/existing', ['as' => 'backend.school-year.personels.storeFromExisting', 'uses' => 'SchoolRecordsPersonelController@storeFromExisting']);
	Route::resource('school-year.personels', 'SchoolRecordsPersonelController');

    Route::post('school-year/{school_year}/departments/store-head', ['as' => 'backend.school-year.departments.storeHead', 'uses' => 'DepartmentsController@storeHead']);
	Route::get('school-year/{school_year}/departments/json', ['as' => 'backend.school-year.departments.json', 'uses' => 'DepartmentsController@json']);
    Route::delete('school-year/{school_year}/departments/{departments}/remove-head', ['as' => 'backend.school-year.departments.removeHead', 'uses' => 'DepartmentsController@removeHead']);
	Route::resource('school-year.departments', 'DepartmentsController');

    Route::get('school-year/{school_year}/sections/json', ['as' => 'backend.school-year.sections.json', 'uses' => 'SectionsController@json']);
	Route::resource('school-year.sections', 'SectionsController');
	Route::resource('school-year.subjects', 'SubjectsController');

	Route::post('school-year/{school_year}/teachers/{teachers}/advisory', ['as' => 'backend.school-year.teachers.advisory', 'uses' => 'TeachersController@advisory']);
	Route::post('school-year/{school_year}/teachers/{teachers}/subjects', ['as' => 'backend.school-year.teachers.subjects', 'uses' => 'TeachersController@subjects']);
	Route::post('school-year/{school_year}/teachers/existing', ['as' => 'backend.school-year.teachers.storeFromExisting', 'uses' => 'TeachersController@storeFromExisting']);
	Route::resource('school-year.teachers', 'TeachersController');

	Route::post('school-year/{school_year}/registrars/existing', ['as' => 'backend.school-year.registrars.storeFromExisting', 'uses' => 'RegistrarsController@storeFromExisting']);
	Route::resource('school-year.registrars', 'RegistrarsController');

	Route::post('school-year/{school_year}/guards/existing', ['as' => 'backend.school-year.guards.storeFromExisting', 'uses' => 'GuardsController@storeFromExisting']);
	Route::resource('school-year.guards', 'GuardsController');

	Route::post('school-year/{school_year}/staffs/existing', ['as' => 'backend.school-year.staffs.storeFromExisting', 'uses' => 'StaffsController@storeFromExisting']);
	Route::resource('school-year.staffs', 'StaffsController');

    Route::get('school-year/{school_year}/students/enroll', ['as' => 'backend.school-year.students.enroll', 'uses' => 'StudentsController@enroll']);
    Route::post('school-year/{school_year}/students/enroll', ['as' => 'backend.school-year.students.storeEnroll', 'uses' => 'StudentsController@storeEnroll']);
    Route::resource('school-year.students', 'StudentsController');

});
