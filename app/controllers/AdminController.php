<?php

class AdminController extends BaseController {

    protected $layout = 'layouts.admin';

    public function index(){

        $this->layout->title = 'Admin';
        $this->layout->content = View::make('admin.index');
    }

    public function logout(){

        Session::flush();
        Auth::logout();
        return Redirect::to("/login")
          ->with('message', array('type' => 'success', 'text' => 'You have successfully logged out'));

    }

}
