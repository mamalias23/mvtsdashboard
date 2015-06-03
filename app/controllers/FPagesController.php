<?php

class FPagesController extends \BaseController {

    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)->get()->first();

        return View::make('front-end.pages', compact('page'));
    }

    public function contact()
    {
        return View::make('front-end.contact');
    }

    public function monitor()
    {
        $announcements = Announcement::where('receivers_group', 'LIKE', '{"all":1%')->orderBy('created_at', 'DESC')->get();
        return View::make('front-end.monitor', compact('announcements'));
    }

}