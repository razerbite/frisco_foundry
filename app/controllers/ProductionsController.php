<?php

class ProductionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /customers
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('productions.index')->with('job_orders', DajobOrder::all())->with('quotations', Quotation::all());
	}

	public function cancel()
	{
		return Redirect::back();
	}

	public function da_create()
	{
		return View::make('productions.directaward-create');
	}

	public function da_store()
	{
		$job_order_da = Input::all();

		$jo_daRules = array(
			'date_created' => 'required',
			'date_needed' => 'required',
			'company_name' => 'required',
			'revision_number' => 'required',
			'type_of_work' => 'required',
			'measurements_from' => 'required'
		);

		$jo_daValidator = Validator::make($job_order_da, $jo_daRules);

		if($jo_daValidator->fails()) {
			return Redirect::back()
					->withErrors($jo_daValidator)
					->withInput(Input::all());
		}

		//HERE
		$job_order = new DajobOrder;
		$job_order->id = Input::get('id');
	    /*$job_order->jo_number = Input::get('jo_number');*/
	    /*$job_order->po_number= Input::get('po_number');*/
	    $job_order->company_name = Input::get('company_name');
	    $job_order->date_created = Input::get('date_created');
	    /*$job_order->date_modified = Input::get('date_modified');*/
	    $job_order->date_needed = Input::get('date_needed');
	    $job_order->revision_number= Input::get('revision_number');
	    $job_order->status_jo = 'Job Order';
	    $job_order->type_of_work= Input::get('type_of_work');
	    $job_order->measurements_from= Input::get('measurements_from');
	    $job_order->save();

	    $job_order_id = $job_order->id;

	    $job_order = new QuotationScope;
	   /* echo "<pre>";
		print_r($job_order_id);
		die();*/
	    /*$job_order->quotation_id = Input::get('quotation_id');*/
	    $job_order->quotation_id = $job_order_id;
	    $job_order->scope = Input::get('scope_da');
	    
	    $job_order->save();

	    $job_order = new QuotationMaterial;
	    $job_order->quotation_id = $job_order_id;
	    $job_order->quantity = Input::get('quantity');
	    $job_order->unit_of_measure = Input::get('uom');
	    $job_order->description = Input::get('description');
	    $job_order->size = Input::get('size');
	    $job_order->actions = Input::get('actions');

	    /*echo "<pre>";
		print_r($job_order->quantity);
		die();*/
	    $job_order->save();

	    return Redirect::to('production')
	        ->with('message', 'Job Order created successfully');
	}

	public function po_create()
	{
		return View::make('productions.purchaseorder-create');
	}

	public function view_production()
	{
		return View::make('productions.view');
	}

	public function submit_po()
	{
		return View::make('productions.submit_po');
	}

	public function view_job_order($id)
	{
		$data['job_order'] = Quotation::find($id);
		$data['scope_job_order'] = QuotationScope::where('quotation_id', $id)->first();
		$data['bom_job_order'] = QuotationMaterial::where('quotation_id', $id)->first();
		
		return View::make('productions.view', $data);
		/*$job_order_id = $data['job_order'] = DajobOrder::find($id);
		$test = $job_order_id->id;
		
		$data['scope_job_order'] = QuotationScope::where('quotation_id', $test)->first();
		$data['bom_job_order'] = QuotationMaterial::where('quotation_id', $test)->first();*/
		/*echo "<pre>";
		print_r($data['scope_job_order']);
		die();*/
		return View::make('productions.view', $data);
	}

	public function view_job_order_po($id)
	{

		$data['quotation'] = Quotation::find($id);
		
		return View::make('productions.view_po', $data);
	}

	public function delete_job_order($id)
	{
		DajobOrder::destroy($id);
		
		QuotationScope::where('quotation_id', $id)->delete();
		QuotationMaterial::where('quotation_id', $id)->delete();

		return Redirect::route('production.index')->with('message', 'Deleted author')
										 ->with('alert-class', 'success');
	}

	public function edit_job_order($id)
	{
		$job_order_id = $data['job_order'] = DajobOrder::find($id);
		$test = $job_order_id->id;
		
		$data['scope_job_order'] = QuotationScope::where('quotation_id', $test)->first();
		$data['bom_job_order'] = QuotationMaterial::where('quotation_id', $test)->first();

		return View::make('productions.edit', $data);
	}

	public function update_job_order()
	{
		$id = Input::get('id');
		$job_order = Input::all();

		/*$authorRules = array(
			'name' => 'required',
			'bio' => 'required'
		);

		$authorValidator = Validator::make($author, $authorRules);

		if($authorValidator->fails()) {
			return Redirect::back()
					->withErrors($authorValidator)
					->withInput(Input::all());
		}*/

		$job_order_da = Input::all();

		$jo_daRules = array(
			'date_created' => 'required',
			'date_needed' => 'required',
			'company_name' => 'required',
			'revision_number' => 'required',
			'type_of_work' => 'required',
			'measurements_from' => 'required'
		);

		$jo_daValidator = Validator::make($job_order_da, $jo_daRules);

		if($jo_daValidator->fails()) {
			return Redirect::back()
					->withErrors($jo_daValidator)
					->withInput(Input::all());
		}
		
	    $job_order = DajobOrder::find($id);
	    $job_order->company_name = Input::get('company_name');
	    $job_order->date_created = Input::get('date_created');
	    $job_order->date_needed = Input::get('date_needed');
	    $job_order->revision_number= Input::get('revision_number');
	    $job_order->status_jo = 'Job Order';
	    $job_order->type_of_work= Input::get('type_of_work');
	    $job_order->measurements_from= Input::get('measurements_from');
	    $job_order->save();

	    $job_order_id = $job_order->id;
	    
	    $scope_jo = QuotationScope::where('quotation_id', $job_order_id)->first();
	    $scope_jo->scope = Input::get('scope_da');
	    $scope_jo->save();

	    $bom_jo = QuotationMaterial::where('quotation_id', $job_order_id)->first();
	    $bom_jo->quantity = Input::get('quantity');
	    $bom_jo->unit_of_measure = Input::get('unit_of_measure');
	    $bom_jo->description = Input::get('description');
	    $bom_jo->size = Input::get('size');
	    $bom_jo->actions = Input::get('actions');
	    $bom_jo->save();

		return Redirect::to('production/back')
	        ->with('message', 'Job order updated successfully');
	}

	public function update_job_order_po()
	{
		$id = Input::get('id');
		/*$data['scope'] = QuotationScope::where('quotation_id', $id)->get();
		echo "<pre>";
		print_r($data['scope']);
		die();*/

		$id = Input::get('id');
		$job_order = Input::all();

		$job_order_da = Input::all();

		$jo_daRules = array(
			'created_at' => 'required',
			'date_needed' => 'required',
			'company_name' => 'required',
			'revision_number' => 'required',
			'type_of_work' => 'required',
			'measurements_from' => 'required'
		);

		$jo_daValidator = Validator::make($job_order_da, $jo_daRules);

		if($jo_daValidator->fails()) {
			return Redirect::back()
					->withErrors($jo_daValidator)
					->withInput(Input::all());
		}
		
	    $job_order = Quotation::find($id);
	    $job_order->created_at = Input::get('created_at');
	    $job_order->date_needed = Input::get('date_needed');
	    $job_order->type_of_work_id= Input::get('type_of_work');
	    $job_order->po_status = 'Job Order';
	    $job_order->po_number = 'PO_000'. $id;
	    $job_order->save();

	    $job_order_id = $job_order->customer->id;

	    $scope_jo = Customer::where('id', $job_order_id)->first();
	    $scope_jo->name = Input::get('company_name');
	    $scope_jo->save();

		return Redirect::to('production/back')
	        ->with('message', 'Job order updated successfully');
	}


	public function edit_job_order_po($id)
	{

		$data['quotation'] = Quotation::find($id);
		
		return View::make('productions.edit_po_scope', $data);
	}

	public function edit_job_order_scope($id)
	{
		
		$data['quotation'] = QuotationScope::where('quotation_id', $id)->get();

		return View::make('productions.edit_po_scope', $data);
	}

	public function update_job_order_po_scope()
	{
		$id = Input::get('id');
		$input = Input::all();

		foreach ($input['scopes'] as $key => $value) {
			$record = QuotationScope::find($value['id']);
			$record->scope = $value['scope'];
			$record->save();
		}

		return Redirect::to('production/back')
	        ->with('message', 'Job order updated successfully');
	}

	public function edit_job_order_bom($id)
	{

		$data['quotation'] = Quotation::find($id);
		
		return View::make('productions.edit_po_bom', $data);
	}

	public function update_job_order_po_bom()
	{
		$id = Input::get('id');
		$input = Input::all();

		foreach ($input['materials'] as $key => $value) {
			$record = QuotationMaterial::find($value['id']);
			$record->quantity = $value['quantity'];
			$record->unit_of_measure = $value['unit_of_measure'];
			$record->description = $value['description'];
			$record->size = $value['size'];
			$record->save();
		}

		return Redirect::to('production/back')
	        ->with('message', 'Job order updated successfully');
	}

	public function submit_to_working_drawing()
	{
		return View::make('productions.submit_working_drawing');
	}

	public function po_details(){
		
		$data 		= Input::all();
		$json['po_number'] = $data['po_number'];
		$record = Quotation::find($data['po_number']);
		$json['record'] = $record;
		//return View::make('productions.po_details');
		return json_encode($json);
		
	}

}
