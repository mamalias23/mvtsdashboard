<?php

class DashboardController extends BaseController {

	public function getIndex()
	{
		if(!Sentry::check()) {
			return Redirect::to('/backend/user/login');
		}

		return View::make('dashboard');

	}
 
}
