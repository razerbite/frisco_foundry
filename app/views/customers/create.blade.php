@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>Add New Customer<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  </hgroup>

  <div class="brokenline"></div>

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

{{ Form::open(['url' => route('customers.store'), 'files'=>'true']) }}
  @include('customers.form')

<div class="clear"></div>
<div class="brokenline"></div>
<!--buttons-->
<section id="buttons">
  <input type="submit" class="form_button02" value="Save &amp; Finish">
  <button type="button" class="form_button" onClick="window.history.back()">Cancel</button>
</section>
<div class="clear"><!--clear for buttons--></div>

{{ Form::close() }}

@stop
