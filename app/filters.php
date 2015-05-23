<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if(!Sentry::check()) {
		return Redirect::to('/backend/user/login');
	}
});

Route::filter('admin', function()
{
	if(!Sentry::check()) {
		return Redirect::to('/backend/user/login');
	}
	$user = Sentry::getUser();
	if(!$user->hasAccess('admin')) {
		Session::flash('error','Permission Denied.');
		return Redirect::back();
	}

});

Route::filter('student', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('student')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('parents', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('parents')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('guard', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('guard')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('others', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('others')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('records_personel', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('school_records_personel')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('department_heads', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('department_heads')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('registrar', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('registrar')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('curriculum_department', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('curriculum_departments')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('teacher', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('teachers')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('alumni', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }
    $user = Sentry::getUser();
    if(!$user->hasAccess('alumni')) {
        Session::flash('error','Permission Denied.');
        return Redirect::back();
    }

});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('advisory', function()
{
    if(!Sentry::check()) {
        return Redirect::to('/backend/user/login');
    }

    $hasAdvisory = 0;
    $groupName = Sentry::getUser()->getGroups()->first()->name;
    $teacher = User::find(Sentry::getUser()->id)
        ->teacher()
        ->where('school_year_id', SchoolYear::getActivated()->id)
        ->first();

    if($groupName=='Teachers' && $teacher) {
        if($advisory = $teacher->advisory()) {
            $hasAdvisory = 1;
        }
    }

    if(!$hasAdvisory)
        return Redirect::back()->withError('Access Denied!');
});
