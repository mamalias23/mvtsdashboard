<?php

class UserController extends BaseController {

	public function getLogin()
	{
		return View::make('login');
	}

	public function postLogin()
	{
		try
		{
		    // Login credentials
		    $credentials = array(
		        'email'    => Input::get('email'),
		        'password' => Input::get('password'),
		    );

		    // Authenticate the user
		    $user = Sentry::authenticate($credentials, Input::get('remember_me'));

		    return Redirect::intended('/backend/dashboard');
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    Session::flash('error','Login field is required.');
		    return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    Session::flash('error','Password field is required.');
		    return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    Session::flash('error','Wrong password, try again.');
		    return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    Session::flash('error','User was not found.');
		    return Redirect::back();
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    Session::flash('error','User is not activated.');
		    return Redirect::back();
		}

		// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    Session::flash('error','User is suspended.');
		    return Redirect::back();
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    Session::flash('error','User is banned.');
		    return Redirect::back();
		}
	}

	public function getLogout() 
	{
		Sentry::logout();

		Session::flash('success','You have successfully logged out.');
		return Redirect::to('/backend/user/login');
	}
 
}
