@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>Edit User<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
    <ul id="controls">
      <li><a href="#" class="submit-form"><img class="icon" src="{{ asset('images/icon_save.png') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot.png') }}" ></li>
      <li><a href="{{ route('users.index') }}"><img class="icon" src="{{ asset('images/icon_cancel.png') }}"></a></li>
    </ul>
  </hgroup>

  <div class="brokenline"></div>

  {{ Form::model($user, ['files'=>'true']) }}
    @include('users.form')

  <!--buttons-->
  <section id="buttons">
  <input class="form_button" type="submit" value="Update">
  <button class="form_button" onClick="window.location.href='{{ route('users.index') }}';">Cancel</button>
  </section>
  <div class="clear"><!--clear for buttons--></div>
  {{ Form::close() }}

@stop
