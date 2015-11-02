@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

@include('sales.quotations.tabs')

  <hgroup class="header">
    <h3>Legal & Letters<br><span>Aenean quis velit a neque rutrum commodo</span></h3>

  </hgroup>


  <div class="brokenline"></div>

  <section class="information">
    <form id="form_info" method="post">
      <ul class="data-entry">
        <li><label>Date</label></li>
        <li>{{ Carbon::now()->toFormattedDateString() }}</li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>Quotation Number</label></li>
        <li>{{ $quotation->rfq_id }}</li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>Company Name</label></li>
        <li>{{ $quotation->customer->name }}</li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>Company Address</label></li>
        <li>{{ $quotation->customer->contactInfo->address_1 }}<br>
      {{ $quotation->customer->contactInfo->address_2 }}<br></li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>ATTN:</label></li>
        <li>{{ $quotation->attns->first()->full_name }}
        <br>{{ $quotation->attns->first()->company_position }}</li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>RE:</label></li>
        <li>{{ $quotation->project_name }}</li>
      </ul>
    </form>

    <form id="form_info" method="post">
      <ul class="data-entry">
        <li><label>Reference Number</label></li>
        <li>PR10036536</li>
      </ul>

      <div class="clear"></div>

      <ul class="data-entry">
        <li><label>Quantity</label></li>
        <li>{{ $quotation->quantity }}</li>
      </ul>
    </form>


    <div class="brokenline02"></div>
    <br>

    <form id="form_info" method="post">
      <ul class="data-entry">
        <li style="width: 40px;"><label>Dear</label></li>
        <li>
          <select>
            <option>Please Select</option>
            <option>Sir</option>
            <option>Ma'am</option>
          </select>
        </li>
      </ul>
    </form>

    <div class="clear"><!--clear--></div>
    <br>

    <p class="legal_stuff">Thank you for giving us the opportunity to participate in ths endeavor.
    We are pleased to submit our quotation for the following for your perusal.</p>

    <p class="legal_stuff"><b>Scope of Work are the following:</b></p>
    <ul class="scope">
      @foreach ($quotation->scopes as $scope)
        <li>{{ $scope->scope }}</li>
      @endforeach
    </ul>

  {{ Form::open(array('route' => ['quotations.pdf', $quotation->rfq_id], 'target'=>'_blank')) }}
  <div id="inline">
    <h3>What paper size do you wish to print in?</h3>
    <ul>
      <li>
        <select name="size">
          <option value="letter">Letter</option>
          <option value="legal">Legal</option>
          <option value="a4">A4</option>
        </select>
      </li>
      <li>{{ Form::submit() }}</li>
    </ul>
  </div>
  {{ Form::close() }}
@stop
