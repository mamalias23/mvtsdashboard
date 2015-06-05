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
		        'username'    => Input::get('username'),
		        'password' => Input::get('password'),
		    );

		    // Authenticate the user
		    $user = Sentry::authenticate($credentials, Input::get('remember_me'));

		    return Redirect::intended('/backend/dashboard');
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    Session::flash('error','Username field is required.');
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

    public function getProfile()
    {
        return View::make('profile');
    }

    public function postProfile()
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
                    'picture' => 'image',
                )
            );

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

            $user = User::find(Sentry::getUser()->id);
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->middle_initial = Input::get('middle_initial');
            $user->gender = Input::get('gender');
            $user->birthdate = Input::get('birthdate');
            $user->mobile_number = Input::get('mobile');
            $user->full_address = Input::get('full_address');

            if(Input::file('picture')) {
                $image = Input::file('picture');
                $filename = Sentry::getUser()->id;
                $saveUrl = base_path().'/public/img/'.$filename.'.jpg';
                Image::make($image->getRealPath())
                        ->fit(215)
                        ->save($saveUrl);

                $user->picture = $filename . '.jpg';
            }

            $user->save();

            DB::commit();

            return Redirect::back()->withSuccess('Profile has been successfully updated.');

        } catch(Exception $e) {
            DB::rollback();
            return Redirect::back()->withError('Something went wrong, it might be our code :( <br /><br />' . $e->getMessage())->withInput();
        }
    }

	public function getLogout() 
	{
		Sentry::logout();

		Session::flash('success','You have successfully logged out.');
		return Redirect::to('/backend/user/login');
	}
 
}
