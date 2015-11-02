@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

@include('sales.quotations.tabs')

<div class="clear"></div>
<hgroup class="header">
  <h3 style="margin: 0;">Add Request for Quotation<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <ul id="controls">
    <li><a href="#" class="submit-form"><img class="icon" src="{{ asset('images/icon_save.png') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot.png') }}" ></li>
    <li><a href="{{ route('quotations.cancel', [$quotation->id]) }}" class="delete-modal" data-message="Are you sure you want to cancel this quotation?"><img class="icon" src="{{ asset('images/icon_cancel.png') }}"></a></li>
  </ul>
</hgroup>

<div class="brokenline"></div>
@include('partials.alert-messages')
@include('partials.error-messages')
<ul class="page-title">
  <li><img class="photoID" src="{{ asset('images/photo.png') }}"></li>
  <li>
    <h1>Customer ID: {{ sprintf("%03s", $quotation->customer->id) }} <br><span>{{ $quotation->customer->name }}</span></h1>
      {{ $quotation->customer->contactInfo->address_1 or 'N/A' }}<br>
      {{ $quotation->customer->contactInfo->address_2 or 'N/A' }}
  </li>
</ul>

<section class="deets">
  <ul>
    <li>Date Generated</li>
    <li>Secretary</li>
    <li>Revision No.</li>
  </ul>
  <ul>
    <li>{{ Carbon::parse($quotation->created_at)->toFormattedDateString() }}</li>
    <li>{{ $quotation->secretary->full_name or 'User not found' }}</li>
    <li>001</li>
  </ul>
</section>

<div class="clear"></div>

<section class="information clearfix">

{{ Form::model($quotation, ['method'=>'PUT']) }}

<section class="information">
  <div id="form_info" style="width: 100%">
    <ul class="data-entry">
      <li><label>Project Name</label></li>
      <li>{{ Form::text('project_name', null, ['required']) }}</li>
    </ul>
  </div>
  <div id="form_info02">
      <ul class="data-entry" >
        <li><label>ATTN</label></li>
        <li>
          {{ Form::select('attn', [''=>'Please Select']+$representativesList) }}
        </li>
        <li><button onClick="window.location.href='{{ route('customers.create.representative', ['id'=>$quotation->customer->id]) }}?redirect=true';">+ Add More</button></li>
      </ul>
  </div>

  <div id="form_info02" >
      <ul class="data-entry" >
        <li><label>Assigned Technical</label></li>
        <li>
          {{ Form::select('technical_id', [''=>'Please Select']+$technicalsList) }}
        </li>

      </ul>
  </div>
</section>

<div class="clear"></div>

<section class="information"><!--This is details-->
  <hgroup>
    <h2>Step 1: Request for Quotation Details</h2>
  </hgroup>

    <div id="form_info" >
      <ul class="data-entry">
        <li><label>Quotation No.</label></li>
        <li>{{ $quotation->rfq_id }}</li>
      </ul>


      <ul class="data-entry">
        <li><label>Date Needed</label></li>
        <li>{{ Form::input('date', 'date_needed', null, ['required']) }}</li>
      </ul>
    </div>

  <div class="clear"></div>

  <div id="form_info" ><!--form start-->
      <ul class="data-entry">
        <li><label>Customer PR/RFQ No.</label></li>
        <li>{{ Form::text('customer_pr_no', null) }}</li>
      </ul>
  </div>

  <div class="clear"></div>

  <div id="form_info" ><!--form start-->
      <ul class="data-entry">
        <li><label>Quantity</label></li>
        <li>{{ Form::number('quantity', null, ['required']) }}</li>
      </ul>
  </div>
  <div id="form_info">
      <ul class="data-entry">
        <li><label>Unit of Measure</label></li>
        <li>
          {{ Form::select('unit_of_measurement', [''=>'Please Select']+$unitOfMeasurementsList) }}
        </li>
      </ul>
  </div>
      <div class="clear"></div>
  <div id="form_info">
      <ul class="data-entry02">
        <li><label>Description</label></li>
        <li>
          {{ Form::textarea('description') }}
        </li>
      </ul>
  </div>

  <div class="brokenline02"></div>

  <div id="form_info"><!--form start-->
      <ul class="data-entry02">
        <li><label>Notes <b>(Optional)</b></label></li>
        <li>
          {{ Form::textarea('notes', '') }}
        </li>
      </ul>
  </div>
</section>

<div class="clear"></div>

@include('sales.quotations.notes')

<div class="clear"></div>
<!--buttons-->
<section id="buttons">
  <!-- <button class="form_button02" onClick="window.location.href='#';">Save</button> -->
  <input type="submit" value="Save" class="form_button02">
  @if(Entrust::can('view_bom'))
    <button type="button" class="form_button02" onClick="window.location.href='{{ route('quotations.bom', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Continue</button>
  @endif
  <button type="button" class="form_button" onClick="window.location.href='{{ route('sales.index') }}';">Cancel</button>
</section>
<div class="clear"><!--clear for buttons--></div>
{{ Form::close() }}
</section>

@stop
