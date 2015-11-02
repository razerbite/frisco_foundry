<?php

class SalesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /sales
	 *
	 * @return Response
	 */
	public function index()
	{
		$countrow = Quotation::get()->count();
		$quotations = Quotation::orderBy('id', 'DESC')->paginate($countrow);
		// Can't eager load and paginate at same time
		// ->load(['customer', 'attns', 'technical']);

		return View::make('sales.index', compact('quotations'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /sales/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /sales
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($rfq)
	{
		$quotation = Quotation::whereRfqId($rfq)->first();

		// Get status and redirect to
		// respective page
		switch ($quotation->status) {
			case '1':
				$route = 'request';
				break;
			case '2':
				$route = 'bom';
				break;
			case '3':
				$route = 'approval';
				break;
			case '4':
				$route = 'summary';
				break;
			default:
				$route = 'request';
				break;
		}

		return Redirect::route("quotations.{$route}", ['rfq'=>Str::slug($rfq)]);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sales/{id}
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
	 * DELETE /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$quotation = Quotation::find($id);

		$quotation->status = 0;
		$quotation->save();

		return Redirect::route('sales.index');
	}

	/**
	 * Generates quotation requests
	 *
	 * @param int $customerId
	 * @return Response
	 * @author Gat
	 **/
	public function createQuotation($customerId)
	{
		$directAward = Input::get('award') ? true : false;

		$customer = Customer::find($customerId);
		$secretary = Auth::user();

		// Check if customer has a representative
		if ($customer->representatives->isEmpty()) {
			return Redirect::route('customers.edit', ['id'=>$customerId])
										->with('message', 'Add a customer representative first')
										->with('alert-class', 'danger');
		}

		// Get Initials
		$initialsPatern = '~\b(\w)|.~';
		$customerInitials = preg_replace($initialsPatern, '$1', $customer->name);
		$secretaryInitials = preg_replace($initialsPatern, '$1', $secretary->full_name);

		// TEMPORARY
		// RFQ = Customer's Initials - DDMM - Secretary's Initials
		$rfq = $customerInitials . '-' . date('dm') . '-' . $secretaryInitials;

		// Append number if existing
		$quotations = Quotation::where('rfq_id', 'LIKE', "{$rfq}%");
		if ($quotations->count())
			$rfq = $rfq . '-' . $quotations->count();

		// Create quotation
		$quotation = Quotation::create([
			'customer_id' => $customer->id,
			'secretary_id' => $secretary->id,
			'rfq_id' => $rfq,
			'direct_award' => $directAward
		]);

		return Redirect::route('quotations.request', ['rfq' => Str::slug($rfq)]);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /sales/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editRequest($rfq)
	{
		$data['quotation'] = Quotation::where('rfq_id', 'LIKE', $rfq)->first()->load(['customer', 'notes', 'attns', 'technical']);
		$data['unitOfMeasurementsList'] = $this->lookupSelect('unit_of_measurement');
		$data['technicalsList'] = Role::find(3)->users()->get()->lists('full_name', 'id');
		$data['representativesList'] = $data['quotation']->customer->representatives()->get()->lists('full_name', 'id');

		return View::make('sales.quotations.request', $data);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /sales/quotation/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateRequest($rfq)
	{
		$input = Input::all();

		$quotation = Quotation::whereRfqId($rfq)->first();

		// Add ATTN
		$attn = array_pull($input, 'attn');
		$quotation->attns()->attach($attn);

		// Save only if not empty
		$note = new Note(['notes'=>array_pull($input, 'notes')]);
		if (!empty($note->notes))
			$quotation->notes()->save($note);

		// Set status for reviewal
		$quotation->status = 2;

		$quotation->fill($input);

		$quotation->save();

		return Redirect::back()
											->with('message', 'Updated quotation request')
											->with('alert-class', 'success');
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /sales/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editBillOfMaterials($rfq)
	{
		$relations = ['customer', 'notes', 'attns', 'technical', 'scopes', 'materials'];
		$data['quotation'] = Quotation::whereRfqId($rfq)->first()->load($relations);

		if ($data['quotation']->status < 2) {
			return Redirect::route('quotations.request', ['rfq'=>Str::slug($rfq)])
													->with('message', 'Pending request');
		}

		// Create scopes if empty
		if ($data['quotation']->scopes->isEmpty()) {
			$data['quotation']->scopes()->save(new QuotationScope());
			$data['quotation']->load('scopes');
		}

		// Create materials if empty
		if ($data['quotation']->materials->isEmpty()) {
			$data['quotation']->materials()->save(new QuotationMaterial());
			$data['quotation']->load('materials');
		}

		$data['typesOfWorkList'] = $this->lookupSelect('type_of_work');

		return View::make('sales.quotations.bom', $data);
	}

	public function updateBillOfMaterials($rfq)
	{
		$input = Input::all();
		$scopes = array_pull($input, 'scopes');
		$materials = array_pull($input, 'materials');

		// Get quotation data
		$quotation = Quotation::whereRfqId($rfq)->first()
							->load(['scopes', 'materials']);

		// Validate data
		$materialRules = [
			'quantity' => 'required|numeric|min:1',
			'unit_of_measure' => 'required',
			'description' => 'required',
			'size' => 'required',
			'file' => 'mimes:jpeg,png'
		];

		foreach ($materials as $material) {
			$validator = Validator::make($material, $materialRules);
			if ($validator->fails()) {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}

		foreach ($scopes as $scope) {
			$validator = Validator::make($scope, ['scope'=>'required']);
			if ($validator->fails()) {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}

		// Save only if not empty
		$note = new Note(['notes'=>array_pull($input, 'notes')]);
		if (!empty($note->notes))
			$quotation->notes()->save($note);

		foreach ($scopes as $index => $scope) {
			$quotation->scopes[$index]->fill($scope)->save();
		}

		foreach ($materials as $index => $material) {
			$quotation->materials[$index]->fill($material)->save();
		}

		// Set status for approval
		$quotation->status = 3;

		$quotation->fill($input);

		$quotation->save();

		return Redirect::back()
											->with('message', 'Updated bill of materials')
											->with('alert-class', 'success');
	}

	public function createScope($rfq)
	{
		$scope = new QuotationScope;
		$quotation = Quotation::whereRfqId($rfq)->first()->load(['scopes']);
		$quotation->scopes()->save($scope);

		if (Request::ajax()) {
			$data = [
				'letter' => Str::numToAlpha($quotation->scopes->count()),
				'count' => $quotation->scopes->count(),
				'deleteLink' => route('scope.delete', ['rfq'=>$rfq, 'id'=>Str::slug($scope->id)])
			];

			return Response::json($data);
		}

		return Redirect::back()
											->with('materialMessage', 'Successfully added scope')
											->with('alert-class', 'success');

	}

	public function destroyScope($rfq, $id)
	{
		$scope = QuotationScope::find($id)->delete();

		return Redirect::back()
											->with('materialMessage', 'Successfully deleted scope')
											->with('alert-class', 'success');
	}
	public function createMaterial($rfq)
	{
		$material = new QuotationMaterial;
		$quotation = Quotation::whereRfqId($rfq)->first()->load(['materials']);
		$quotation->materials()->save($material);

		if (Request::ajax()) {
			$data = [
				'letter' => Str::numToAlpha($quotation->materials->count()),
				'count' => $quotation->materials->count(),
				'deleteLink' => route('material.delete', ['rfq'=>$rfq, 'id'=>Str::slug($material->id)])
			];

			return Response::json($data);
		}

		return Redirect::back()
											->with('materialMessage', 'Successfully added material')
											->with('alert-class', 'success');

	}

	public function destroyMaterial($rfq, $id)
	{
		$material = QuotationMaterial::find($id)->delete();

		return Redirect::back()
											->with('materialMessage', 'Successfully deleted material')
											->with('alert-class', 'success');
	}

	public function createDiscount($rfq)
	{
		$quotation = Quotation::whereRfqId($rfq)->first()->load(['discounts']);
		$quotation->discounts()->save(new QuotationDiscount);

		return Redirect::back()
											->with('discountMessage', 'Successfully added discount')
											->with('alert-class', 'success');

	}

	public function destroyDiscount($rfq, $id)
	{
		$discount = QuotationDiscount::find($id)->delete();

		return Redirect::back()
											->with('discountMessage', 'Successfully removed discount')
											->with('alert-class', 'success');
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /sales/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editApproval($rfq)
	{
		$relations = ['customer', 'notes', 'attns', 'technical', 'scopes', 'materials'];
		$data['quotation'] = Quotation::whereRfqId($rfq)->first()->load($relations);

		$rules = [
			'quantity' => 'required|numeric|min:1',
			'unit_of_measure' => 'required',
			'description' => 'required',
			'size' => 'required'
		];

		// Check data needed is existing
		foreach ($data['quotation']->materials as $material) {
			$validator = Validator::make($material->toArray(), $rules);
			if ($validator->fails()) {
				return Redirect::route('quotations.bom', ['rfq'=>Str::slug($rfq)])
													->withErrors($validator);
			}
		}
		foreach ($data['quotation']->scopes as $scope) {
			$validator = Validator::make($scope->toArray(), ['scope'=>'required']);
			if ($validator->fails()) {
				return Redirect::route('quotations.bom', ['rfq'=>Str::slug($rfq)])
													->withErrors($validator);
			}
		}

		$data['executivesList'] = Role::find(4)->users()->get()->lists('full_name', 'id');
		$data['technicalsList'] = Role::find(3)->users()->get()->lists('full_name', 'id');
		$data['secretariesList'] = Role::find(2)->users()->get()->lists('full_name', 'id');
		$data['typesOfWorkList'] = $this->lookupSelect('type_of_work');
		$data['warrantyDurationList'] = $this->lookupSelect('warranty_duration');
		$data['commitmentRangeList'] = [
			'1-5 Days' => '1-5 Days',
			'5-10 Days' => '5-10 Days',
			'10-15 Days' => '10-15 Days'
		];

		return View::make('sales.quotations.approval', $data);
	}

	public function updateApproval($rfq)
	{
		$input = Input::all();
		$scopes = array_pull($input, 'scopes');
		$materials = array_pull($input, 'materials');

		// Get quotation data
		$quotation = Quotation::whereRfqId($rfq)->first()
								->load(['scopes', 'materials']);

		// Validate data
		foreach ($materials as $material) {
			$validator = Validator::make($material, ['price_per_unit' => 'required|numeric|min:1']);
			if ($validator->fails()) {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
		foreach ($scopes as $scope) {
			$validator = Validator::make($scope, ['scope' => 'required']);
			if ($validator->fails()) {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}

		// Save only if not empty
		$note = new Note(['notes'=>array_pull($input, 'notes')]);
		if (!empty($note->notes))
			$quotation->notes()->save($note);

		foreach ($materials as $index => $material) {
			$quotation->materials[$index]->fill($material)->save();
		}

		foreach ($scopes as $index => $scope) {
			$quotation->scopes[$index]->fill($scope)->save();
		}

		// Set status as approved
		$quotation->status = 4;

		$quotation->fill($input);
		$quotation->save();

		return Redirect::back()
											->with('message', 'Updated approvals')
											->with('alert-class', 'success');
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /sales/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editSummary($rfq)
	{
		$relations = ['customer', 'notes', 'attns', 'technical', 'scopes', 'materials', 'discounts'];
		$data['quotation'] = Quotation::whereRfqId($rfq)->first()->load($relations);

		if ($data['quotation']->status < 3) {
			return Redirect::route('quotations.request', ['rfq'=>Str::slug($rfq)])
													->with('message', 'Pending approval');
		}

		$rules = [
			'quantity' => 'required|numeric|min:1',
			'unit_of_measure' => 'required',
			'description' => 'required',
			'size' => 'required',
			'price_per_unit' => 'required|numeric|min:1'
		];

		// Check data needed is existing
		foreach ($data['quotation']->materials as $material) {
			$validator = Validator::make($material->toArray(), $rules);
			if ($validator->fails()) {
				return Redirect::route('quotations.approval', ['rfq'=>Str::slug($rfq)])
													->withErrors($validator);
			}
		}
		foreach ($data['quotation']->scopes as $scope) {
			$validator = Validator::make($scope->toArray(), ['scope'=>'required']);
			if ($validator->fails()) {
				return Redirect::route('quotations.approval', ['rfq'=>Str::slug($rfq)])
													->withErrors($validator);
			}
		}

		$data['discountTypeList'] = $this->lookupSelect('discount_type');
		$data['discountModificationList'] = $this->lookupSelect('discount_modification');

		// Create discount if empty
		if ($data['quotation']->discounts->isEmpty()) {
			$data['quotation']->discounts()->save(new QuotationDiscount());
			$data['quotation']->load('discounts');
		}

		return View::make('sales.quotations.summary', $data);
	}

	public function updateSummary($rfq)
	{
		$input = Input::all();
		$discounts = array_pull($input, 'discounts');

		// Get quotation data
		$quotation = Quotation::whereRfqId($rfq)->first()
														->load(['discounts']);

		// Make sure discount type and modification are set
		if ($input['discount']) {
			$rules = [
				'type_id' => 'required',
				'modification_id' => 'required'
			];
			foreach ($discounts as $discount) {
				$validator = Validator::make($discount, $rules);
				if ($validator->fails()) {
					return Redirect::back()->withInput()->withErrors($validator);
				}
			}
		}

		foreach ($discounts as $index => $discount) {
			$quotation->discounts[$index]->fill($discount)->save();
		}

		$quotation->fill($input);
		$quotation->save();

		return Redirect::back()
											->with('message', 'Updated summary')
											->with('alert-class', 'success');
	}

	/**
	 * Display the specified resource.
	 * GET /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showReport($rfq)
	{
		$relations = [
			'customer', 'secretary', 'technical', 'executive',
	    'attns', 'scopes', 'materials', 'discounts'
		];
		$quotation = Quotation::whereRfqId($rfq)->first()->load($relations);

		/*print_r($quotation);*/

		if ($quotation->discount) {

			// Get discount per piece first
			// Per lot discount after tax as per client
			foreach ($quotation->materials as $i => &$material) {
				foreach ($quotation->discounts as $discount) {
					// modification: 2 - Per piece
					if ($discount->modification_id == 2)
						$material->price_per_unit = $discount->applyDiscount($material->price_per_unit);
				}
			}

		}

		$data['quotation'] = $quotation;

		/*print_r($quotation);*/

		return View::make('sales.reports.quotation', $data);
	}

	/**
	 * Display the specified resource.
	 * GET /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showLetter($rfq)
	{
		$relations = [
			'customer', 'secretary', 'technical', 'executive',
	    'attns', 'scopes', 'materials', 'discounts'
		];
		$quotation = Quotation::whereRfqId($rfq)->first()->load($relations);
		$data['quotation'] = $quotation;

		return View::make('sales.quotations.print', $data);
	}

	/**
	 * Display the specified resource.
	 * GET /sales/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function showPdf($rfq)
	{
		$relations = [
			'customer', 'secretary', 'technical', 'executive',
	    'attns', 'scopes', 'materials', 'discounts'
		];
		$quotation = Quotation::whereRfqId($rfq)->first()->load($relations);

		$data['quotation'] = $quotation;
		/*print_r($quotation);*/

		$pdf = PDF::loadView('sales.reports.pdf', $data);
		return $pdf->setPaper(Input::get('size'))->stream();
	}

	public function _getQuotationTableList() {
		$countrow = Quotation::get()->count();
		$quotations = Quotation::orderBy('id', 'DESC')->paginate($countrow);

		return Datatables::of($quotations)
			->make();
		
	}
}
