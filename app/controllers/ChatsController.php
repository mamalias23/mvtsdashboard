<?php

class ChatsController extends \BaseController {

    protected $pusher;
    public function __construct()
    {
        //$this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('auth');

        $this->pusher = new Pusher('a4b5ea994e8c612a010e', '132b6e79df2108598a90', '121464');
    }
	/**
	 * Display a listing of the resource.
	 * GET /chats
	 *
	 * @return Response
	 */
	public function index()
	{
        $pusher = $this->pusher;
        $this->pusher->trigger('demoChannel', 'userNewMessage', ['message'=>'hello world']);

        if(Input::has('get')) {
            if(Input::get('get')=='channels') {
                return json_decode($this->pusher->get('/channels/demoChannel/users'));
            }
        }
		return View::make('chats.index', compact('pusher'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /chats/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /chats
	 *
	 * @return Response
	 */
	public function store()
	{
        $this->pusher->trigger(Input::get('channel_name'), 'userNewMessage', array('username'=>Sentry::getUser()->username), Input::get('socket_id'));
        $this->pusher->presence_auth(Input::get('channel_name'),Input::get('socket_id'), '123456', array('username'=>Sentry::getUser()->username));
        return $this->pusher->get('/channels/demoChannel');
	}

	/**
	 * Display the specified resource.
	 * GET /chats/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /chats/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /chats/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /chats/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}