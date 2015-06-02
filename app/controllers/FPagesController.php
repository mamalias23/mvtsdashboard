<?php

class FPagesController extends \BaseController {

    public function showPage($slug)
    {
        $page = Page::where('slug', $slug)->get()->first();

        return View::make('front-end.pages', compact('page'));
    }

}