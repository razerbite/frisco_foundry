<?php

class UsersController extends \BaseController {

	/**
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index()
	{
		$countrow = User::get()->count();
		$users = User::with('roles')->paginate($countrow);

		return View::make('users.index', compact('users'));
	}

	public function test()
	{


	}

	public function getLogin()
	{
		$this->layout->title = 'Login';

		return View::make('login');
	}

	public function authenticate()
	{
		$validator = Validator::make(Input::all(), [
			'username' => 'required',
			'password' => 'required',
		]);

		$credentials = Input::only('username', 'password');

		if ($validator->passes()) {

			if (Auth::attempt($credentials, true)) {
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

	public function getLogout()
	{
		Auth::logout();

		return Redirect::to('/user/login');
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create()
	{
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');
		$data['rolesList'] = Role::all()->lists('name', 'id');

		return View::make('users.create', $data);
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$role = array_pull($data, 'role');
		$contact = array_pull($data, 'contactInfo');
		$numbers = array_pull($contact, 'number');
		$numberTypes = array_pull($contact, 'number_type');

		$data['password'] = Hash::make($data['password']);

		$user = User::create($data);

		foreach ($numbers as $index => $number) {
			$contactNumbers[] = new ContactNumber([
				'number' => $number,
				'type' => $numberTypes[$index]
			]);
		}

		$contactInfo = ContactInfo::create($contact);
		$contactInfo->contactNumbers()->saveMany($contactNumbers);

		// Attach Address
		$user->contactInfo()->save($contactInfo);

		// Attach role
		$user->roles()->sync([$role]);

		return Redirect::route('users.index')
							->with('message', 'Successfully added user')
							->with('alert-class', 'success');
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::findOrFail($id)->load('roles', 'contactInfo');

		return View::make('users.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['user'] = User::find($id)->load('roles', 'contactInfo');
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');
		$data['rolesList'] = Role::all()->lists('name', 'id');

		return View::make('users.edit', $data);
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);
		$data = Input::all();
		$rules = User::getValidationRules($id);

		if (empty($data['password']) && empty($data['password_confirmation'])) {
			array_pull($rules, 'password');
			array_pull($data, 'password');
		}

		$validator = Validator::make($data, $rules);

		if ($validator->fails())
			return Redirect::back()->withErrors($validator)->withInput();

		if (isset($data['password']))
			$data['password'] = Hash::make($data['password']);

		$role = array_pull($data, 'role');
		$contact = array_pull($data, 'contactInfo');
		$numbers = array_pull($contact, 'number');
		$numberTypes = array_pull($contact, 'number_type');

		foreach ($numbers as $index => $number) {
			$contactNumbers[] = new ContactNumber([
				'number' => $number,
				'type' => $numberTypes[$index]
			]);
		}

		$user->fill($data);
		$contactInfo = $user->contactInfo;
		$contactInfo->fill($contact)->save();

		// Dirty hack
		$contactInfo->contactNumbers()->delete();
		$contactInfo->contactNumbers()->saveMany($contactNumbers);

		// Attach role
		$user->roles()->sync([$role]);

		$user->push();

		return Redirect::back()->with('message', 'Successfully updated')
													 ->with('alert-class', 'success');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if ($id == Auth::user()->id) {
			return Redirect::back()->with('message', 'Could not delete own account')
													 ->with('alert-class', 'danger');
		}

		User::destroy($id);

		return Redirect::route('users.index')->with('message', 'Deleted user')
													 ->with('alert-class', 'success');
		;
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editRolePermissions()
	{
		$roles = Role::all()->load('perms');
		$permissions = Permission::all();

		return View::make('users.role-permissions', compact('roles', 'permissions', 'rolePermissions'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRolePermissions()
	{
		$input = Input::all();

		foreach ($input['permissions'] as $role => $permissions) {
			Role::whereName($role)->first()->perms()->sync($permissions);
		}

		return Redirect::route('role.permissions.edit')
							->with('message', 'Successfully updated role permissions')
							->with('alert-class', 'success');
	}
}
