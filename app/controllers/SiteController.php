<?php

class SiteController extends \BaseController {

  /**
   * Show home
   * GET /site
   *
   * @return Response
   */
  public function home()
  {
    return View::make('home');
  }

  /**
   * Show login form
   * GET /login
   *
   * @return Response
   */
  public function login()
  {
    return View::make('login');
  }

  public function postLogin()
  {
    $validator = Validator::make(Input::all(), [
      'username' => 'required',
      'password' => 'required',
    ]);

    $user = Input::only('username', 'password');
    $user['status'] = 1; // Must be active

    if ($validator->passes()) {

      if (Auth::attempt($user, true)) {
        return Redirect::intended('/dashboard');
      } else {
        return Redirect::back()->withInput()->withErrors([
          'password' => ['Invalid username/password.']
        ]);
      }

    } else {
      return Redirect::back()
        ->withInput()
        ->withErrors($validator);
    }
  }

  public function logout()
  {
    Auth::logout();
    return Redirect::to('login');
  }

  public function profile()
  {
    return App::make('UsersController')->show(Auth::user()->id);
  }

  public function editProfile()
  {
    return App::make('UsersController')->edit(Auth::user()->id);
  }

  public function updateProfile()
  {
    return App::make('UsersController')->update(Auth::user()->id);
  }

}
