@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>Add New Representative<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  </hgroup>

  <div class="brokenline"></div>

  <section class="information clearfix">

    <ul class="page-title">
      <li><img class="photoID" src="{{ asset('/images/photo.png/') }}"></li>
      <li>
        <h1>Customer ID: {{ sprintf("%03s", $customer->id) }} <br><span>{{ $customer->name }}</span></h1>
          {{ $customer->contactInfo->address_1 }} <br>
          {{ $customer->contactInfo->address_2 }}
      </li>
    </ul>

    <section class="deets">
      <ul>
        <li>Date Generated</li>
        <li>Secretary</li>
        <li>Position</li>
      </ul>
      <ul>
        <li>{{ Carbon::parse($customer->created_at)->format('d/m/Y') }}</li>
        <li>{{ $customer->secretary->full_name or 'User not found' }}</li>
        <li>{{ $customer->secretary->position or '' }}</li>
      </ul>
    </section>
  </section>

  @include('partials.alert-messages')

  @if($errors->all())
    <div class="alert alert-danger bs-alert-old-docs">
      <ul class="errors" style="text-align: center;">
        @foreach($errors->all() as $message)
          <li><font color="red">{{ $message }}</font></li>
        @endforeach
      </ul>
    </div>
  @endif

{{ Form::open() }}
  @include('customers.representatives.form')

<div class="clear"></div>
<div class="brokenline"></div>
<!--buttons-->
<section id="buttons">
  <input type="submit" class="form_button02" value="Save &amp; Finish">
  <button class="form_button" onClick="window.history.back()">Cancel</button>
</section>
<div class="clear"><!--clear for buttons--></div>

{{ Form::close() }}

@stop
