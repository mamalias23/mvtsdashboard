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
        //dd(\Carbon\Carbon::now()->timezone('Asia/Manila')->toDateString());
        $announcements = Announcement::where('receivers_group', 'LIKE', '{"all":1%')
                        //->where('updated_at', '>=', \Carbon\Carbon::now()->timezone('Asia/Manila')->toDateString())
                        ->orderBy('created_at', 'DESC')->get();
        return View::make('front-end.monitor', compact('announcements'));
    }

}