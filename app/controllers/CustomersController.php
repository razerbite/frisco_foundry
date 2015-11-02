<?php

class CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /customers
	 *
	 * @return Response
	 */
	public function index()
	{
		// $relations = ['contactInfo', 'secretary', 'representatives'];
		// Can't paginate and eager load at same time
		$countrow = Customer::get()->count();
		$customers = Customer::paginate($countrow);

		return View::make('customers.index', compact('customers'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /customers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		$data['industryTypeList'] = $this->lookupSelect('industry_type');
		$data['customerStatusList'] = $this->lookupSelect('customer_status');
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');

		$redirect = Input::get('redirect') ? true : false;
		if ($redirect) {
			Session::put('redirect_to_rfq_after_create', true);
		}

		return View::make('customers.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /customers
	 *
	 * @return Response
	 */
	public function store()
	{
		$customer = Input::all();
		$contact = array_pull($customer, 'contactInfo');
		$numbers = array_pull($contact, 'number');
		$numberTypes = array_pull($contact, 'number_type');

		$customerRules = array(
			'name' => 'required',
			'industry_type' => 'required'
		);

		$contactRules = array(
			'email' => 'required|email'
		);

		$customerValidator = Validator::make($customer, $customerRules);
		$contactValidator = Validator::make($contact, $contactRules);

		if($customerValidator->fails()) {
			return Redirect::back()
					->withErrors($customerValidator)
					->withInput(Input::all());
		}

		if($contactValidator->fails()) {
			return Redirect::back()
					->withErrors($contactValidator)
					->withInput(Input::all());
		}

		// Add Customer
		$newCustomer = Customer::create($customer);


		foreach ($numbers as $index => $number) {
			$contactNumbers[] = new ContactNumber([
				'number' => $number,
				'type' => $numberTypes[$index]
			]);
		}

		$contactInfo = ContactInfo::create($contact);
		$contactInfo->contactNumbers()->saveMany($contactNumbers);

		// Attach Address
		$newCustomer->contactInfo()->save($contactInfo);

		return Redirect::route('customers.create.representative', ['id'=>$newCustomer->id])
											->with('message', 'Successfully added customer')
											->with('alert-class', 'success');
	}

	/**
	 * Display the specified resource.
	 * GET /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$relations = ['contactInfo', 'secretary', 'representatives', 'quotations'];
		$data['customer'] = Customer::find($id)->load($relations);

		return View::make('customers.show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /customers/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['customer'] = Customer::find($id)->load(['contactInfo', 'representatives']);

		$data['industryTypeList'] = $this->lookupSelect('industry_type');
		$data['customerStatusList'] = $this->lookupSelect('customer_status');
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');
		
		return View::make('customers.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();

		$contact = array_pull($input, 'contactInfo');
		$numbers = array_pull($contact, 'number');
		$numberTypes = array_pull($contact, 'number_type');

		// Edit Customer
		$customer = Customer::find($id);
		$customer->fill($input);
		$contactInfo = $customer->contactInfo;
		$contactInfo->fill($contact)->save();

		// Dirty solution, must fix
		/*$contactInfo->contactNumbers()->delete();
		$contactInfo->contactNumbers()->saveMany($contactNumbers);*/

		$customer->push();

		return Redirect::back()->with('message', 'Updated customer info')
							   ->with('alert-class', 'success');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Customer::destroy($id);

		return Redirect::route('customers.index')->with('message', 'Deleted customer')
													 ->with('alert-class', 'success');
	}

	public function createRepresentative($id)
	{
		$redirect = Input::get('redirect') ? true : false;
		if ($redirect) {
			Session::put('redirect_to_rfq', URL::previous());
		}

		$data['customer'] = Customer::find($id);
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');
		return View::make('customers.representatives.create', $data);
	}

	public function storeRepresentative($id)
	{
		$input = Input::all();
		$rules = [
			'first_name' => 'required',
			'last_name' => 'required',
			/*'middle_initial' => 'required',*/
			'company_position' => 'required',
			'contactInfo.email' => 'required|email'
		];

		$validator = Validator::make($input, $rules);
		if ($validator->fails())
			return Redirect::back()->withErrors($validator)->withInput();

		$contact = array_pull($input, 'contactInfo');
		$numbers = array_pull($contact, 'number');
		$numberTypes = array_pull($contact, 'number_type');

		$representative = CustomerRepresentative::create($input);
		$customer = Customer::find($id);

		foreach ($numbers as $index => $number) {
			$contactNumbers[] = new ContactNumber([
				'number' => $number,
				'type' => $numberTypes[$index]
			]);
		}


		$newContactInfo = ContactInfo::create($contact);
		$newContactInfo->contactNumbers()->saveMany($contactNumbers);
		$representative->contactInfo()->save($newContactInfo);
		$customer->representatives()->save($representative);

		if (Session::get('redirect_to_rfq_after_create')) {
			Session::pull('redirect_to_rfq_after_create');
			return Redirect::route('quotations.create',['customerId'=>$customer->id]);
		}

		if (Session::get('redirect_to_rfq')) {
			$url = Session::pull('redirect_to_rfq');
			return Redirect::to($url)
							->with('message', 'Successfully added representative')
							->with('alert-class', 'success');
		}
		return Redirect::route('customers.edit', ['id'=>$id])
						->with('message', 'Successfully added representative')
						->with('alert-class', 'success');
	}
	/**
	 * Get customers list
	 *
	 * @return json
	 * @author Leo
	 **/
	public function _getCustomerListDropdownData() {
		$data 		= Input::all();
		$hasData 	= false;

		if($data) {
			$q = $data['q'];
			$customers = Customer::where('name', 'LIKE',"%{$q}%")->get(array('id','name'));
			if($customers) {
				foreach($customers as $key=>$value):
					$hasData = true;
					$results[] = array(
						'id' 	=> $value['id'],
						'text' 	=> $value['name'],
					);
				endforeach;
			}
		}

		if(!$hasData) {
			$results[] = array(
				'id' 	=> " ",
				'text' 	=> "No results found, please refine your search parameter.",
			);
		}

		return Response::json($results);
	}

	public function destroyRepresentative($id)
	{
		$scope = CustomerRepresentative::find($id)->delete();

		return Redirect::back()
											->with('materialMessage', 'Successfully deleted scope')
											->with('alert-class', 'success');
	}

	public function editRepresentative($id)
	{
		$data['customer'] = Customer::find($id)->load(['contactInfo', 'representatives']);

		$data['industryTypeList'] = $this->lookupSelect('industry_type');
		$data['customerStatusList'] = $this->lookupSelect('customer_status');
		$data['contactNumberTypeList'] = $this->lookupSelect('contact_no_type');

		return View::make('customers.representatives.edit', $data);
	}

	public function updateRepresentative($id)
	{
		$input = Input::all();

		/*echo "<pre>";
		print_r($input);
		die();*/
		
		foreach ($input['array'] as $key => $value) {
			$record = CustomerRepresentative::find($value['id']);
			$record->first_name = $value['first_name'];
			$record->middle_initial = $value['middle_initial'];
			$record->last_name = $value['last_name'];
			$record->company_position = $value['company_position'];
			$record->save();

			$email = ContactInfo::find($value['email_id']);
			$email->email = $value['email'];
			$email->save();

			$number = ContactNumber::find($value['number_id']);
			$number->number = $value['number'];
			$number->save();

			/*$contact = Contact::find($email->contact_id);
			$contact->number = $value['new_number'];
			$contact->save();*/
		}

		return Redirect::back()->with('message', 'Updated representative info')
							   ->with('alert-class', 'success');
	}

	public function search($term)
	{
		/*$search = CustomerRepresentative::where('title', 'LIKE', '%'.$term.'%')->get();*/
		return 'Hello Search';
	}	

}
