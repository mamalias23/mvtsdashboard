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

    public function getView($announcement_id)
    {
        $announcement = Announcement::find($announcement_id);
        return View::make('front-end.announcement', compact('announcement'));
    }

}