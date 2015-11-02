@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

@include('sales.quotations.tabs')

  <div class="clear"></div>
  <hgroup class="header">
    <h3>Add Request for Quotation<br><span>Aenean quis velit a neque rutrum commodo</span></h3>

    <ul id="controls">
      <li><a href="{{ route('quotations.for-print', ['rfq'=>Str::slug($quotation->rfq_id)]) }}"><img class="icon" src="{{ asset('images/icon_print.png') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot.png') }}" ></li>
      <li><a href="#" class="submit-form"><img class="icon" src="{{ asset('images/icon_save.png') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot.png') }}" ></li>
      <li><a href="{{ route('quotations.cancel', [$quotation->id]) }}" class="delete-modal" data-message="Are you sure you want to cancel this quotation?"><img class="icon" src="{{ asset('images/icon_cancel.png') }}"></a></li>
    </ul>

  </hgroup>

  <div class="brokenline"></div>
  @include('partials.alert-messages')
  <ul class="page-title">
    <li><img class="photoID" src="{{ asset('images/photo.png') }}"></li>
    <li>
      <h1>Customer ID: {{ sprintf("%03s", $quotation->customer->id) }} <br><span>{{ $quotation->customer->name }}</span></h1>
      {{ $quotation->customer->contactInfo->address_1 }}<br>
      {{ $quotation->customer->contactInfo->address_2 }}<br>
      ATTN: <b>{{ $quotation->attns->first()->full_name }}</b> - {{ $quotation->attns->first()->company_position }}
    </li>
  </ul>

  <section class="deets">
    <ul>
      <li>Date Generated</li>
      <li>Secretary</li>
      <li>Assigned Technical</li>
      <li>Revision No.</li>
    </ul>
    <ul>
      <li>{{ Carbon::parse($quotation->created_at)->toDayDateTimeString() }}</li>
      <li>{{ $quotation->secretary->full_name or '' }}</li>
      <li>{{ $quotation->technical->full_name or '' }}</li>
      <li>001</li>
    </ul>
  </section>

  <div class="clear"></div>

  <section class="information"><!--This is details-->
    <hgroup>
      <h2>Step 4: Summary of Request</h2>
    </hgroup>

    {{ Form::model($quotation, ['method'=>'PUT']) }}
    <div id="form_info" method="post"><!--form start-->
        <ul class="data-entry">
          <li><label>ATTN</label></li>
          <li><b>{{ $quotation->attns->first()->full_name }}</b> - {{ $quotation->attns->first()->company_position }}</li>
        </ul>
    </div>

    <div class="clear"></div>

    <div id="form_info" method="post" ><!--form start-->
        <ul class="data-entry02">
          <li><label>Date Needed</label></li>
          <li>{{ Carbon::parse($quotation->date_needed)->format('F j, Y') }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Customer PR/RFQ No.</label></li>
          <li>{{ $quotation->customer_pr_no }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Description</label></li>
          <li>{{ $quotation->description }}</li>
        </ul>
    </div>


    <div id="form_info" method="post" ><!--form start-->
        <ul class="data-entry02">
          <li><label>Quantity</label></li>
          <li>{{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Unit of Measure</label></li>
          <li>{{ $quotation->unit_of_measurement_value }}</li>
        </ul>
    </div>

  </section>

  <div class="brokenline02"></div>

  <section class="information"><!--This is details-->
    <p><b>Scope of Work (SoW)</b></p>
    <table class="table-B"><!--This is table-->
      <th style="width: 60px;">Item Letter</th>
      <th>Scope Details</th>
      <th style="width: 60px;">Action</th>

      @foreach ($quotation->scopes as $index => $scope)
        <tr>
          <td style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
          <td>{{ nl2br($scope->scope) }}</td>
          <td style="text-align: center;">
            <a href="{{ route('quotations.bom', ['rfq'=>Str::slug($quotation->rfq_id)]) }}"><img src="{{ asset('images/edit.png') }}" title="Delete"></a>
            <img src="{{ asset('images/dot02.png') }}">
            <a href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}" class="delete-modal"><img src="{{ asset('images/doc_delete.png') }}" title="Delete"></a>
          </td>
        </tr>
      @endforeach

    </table>


    <div class="clear"></div>
    <div id="form_info" method="post" ><!--form start-->
        <ul class="data-entry02">
          <li><label>Quotation Notes</label></li>
          <li style="width: 400px;">
            {{ nl2br($quotation->note) }}
          </li>
        </ul>
        <div class="clear"></div>
        <br>
        <ul class="total-quotation">
          <li><label style="font-size: 18px;">Quotation Price</label></li>
          <li>P {{ Form::text("price", number_format($quotation->price, 2, '.', ''), ['required', 'placeholder'=>'00.00', 'pattern'=>'^\d*(\.\d{2}$)?', 'title'=>'00.00', 'style'=>'font-weight: bold;']) }}
          </li>
        </ul>
    </div>

  </section>
  <div class="brokenline02"></div>

  @include('partials.error-messages')
  @if(Session::has('discountMessage'))
    <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ Session::get('discountMessage') }}
    </div>
  @endif

    <p><b>Add Discount</b></p>
    <table class="table-B"><!--This is table-->
      <th>Discount Amount</th>
      <th>Discount Type</th>
      <th>Modify by</th>
      <th>Discount Notes</th>
      <th style="width: 30px"></th>

      @foreach ($quotation->discounts as $index => $discount)
      <tr>
        <td>{{ Form::text("discounts[$index][amount]", number_format($discount->amount, 2, '.', ''), ['required', 'placeholder'=>'00.00', 'pattern'=>'^\d*(\.\d{2}$)?', 'title'=>'00.00']) }}</td>
        <td>
            {{ Form::select("discounts[$index][type_id]", [''=>'Please Select']+$discountTypeList, $discount->type_id) }}
        </td>
        <td>
            {{ Form::select("discounts[$index][modification_id]", [''=>'Please Select']+$discountModificationList, $discount->modification_id) }}
        </td>
        <td>{{ Form::text("discounts[$index][note]", $discount->note) }}</td>
        <td style="text-align: center;">
            <a href="{{ route('discount.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$discount->id]) }}" class="delete-modal"><img src="{{ asset('images/doc_delete.png') }}" title="Delete"></a>
          </td>
      </tr>
      @endforeach
    </table>
    <div class="clear"></div>
    <ul class="total-quotation">
      {{ Form::hidden('discount', 0); }}
      <li><label> {{ Form::checkbox('discount', 1) }} Include Discount and Warranty</label></li>
    </ul>
    <button type="button" class="button02" onClick="window.location.href='{{ route('quotations.discount.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Add More</button>

    <div class="clear"></div>

  <div class="brokenline"></div>

  <section class="information"><!--This is details-->
    <div id="form_info" method="post"><!--form start-->

      <ul class="data-entry02">
        <li><label>Prepared by</label></li>
        <li>{{ $quotation->secretary->full_name or 'User not found' }}</li>
      </ul>


      <ul class="data-entry02">
        <li><label>Reviewed by</label></li>
        <li>{{ $quotation->technical->full_name or 'User not found'}}</li>
      </ul>

    </div>

    <div id="form_info" method="post"><!--form start-->

      <ul class="data-entry02">
        <li><label>Approved by</label></li>
        <li>{{ $quotation->executive->full_name or 'User not found'}}</li>
      </ul>

      <!--ul class="data-entry02">
        <li><label>Reviewed on</label></li>
        <li>May 12, 2014; 3:00pm</li>
      </ul-->

      <ul class="data-entry02">
        <li style="vertical-align: top;"><label>Digital Signature</label></li>
        <li>
          @if (isset($quotation->signature_file_name))
              <div style="margin-top: 5px">
                <img src="{{ $quotation->signature->url() }}" alt="">
              </div>
          @endif
        </li>
      </ul>
    </div>
  </section>

  <div class="clear"><!--clear--></div>

  <!--buttons-->
  <section id="buttons-blue">
    <!-- <button type="button" class="form_button" onClick="">Convert to Purchase Order</button> -->
    <button type="button" class="form_button" onClick="window.location.href='{{ route('quotations.for-print', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Quotation for Client</button>
    <button type="button" class="form_button" onClick="window.location.href='{{ route('quotations.report', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Internal Report</button>
    <!-- <button type="button" class="form_button" onClick="">Send to Client</button> -->
  </section>
  <section id="buttons">
    <input type="submit" value="Save" class="form_button02">
    <button type="button" class="form_button" onClick="window.location.href='{{ route('sales.index') }}';">Cancel</button>
  </section>
  <div class="clear"><!--clear for buttons--></div>
  {{ Form::close() }}

@stop
