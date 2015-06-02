<?php

class FAnnouncementsController extends \BaseController {

    public function __construct()
    {
    }

    public function getIndex()
    {
        $announcements = Announcement::where('receivers_group', 'LIKE', '{"all":1%')->orderBy('created_at', 'DESC')->get();
        return View::make('front-end.announcements', compact('announcements'));
    }

}