@extends('layouts/dashboard')
@section('content')
	<section class="header">
		<hgroup>
			<h1>Welcome</h1>
			<p>Enter your User Name and Password to get started</p>
		</hgroup>
		<img src="{{ asset('/images/key.png') }}">
		<div class="clear"></div>
	</section>

	@include('partials.error-messages')

	{{ Form::open(array('class'=>'signinform')) }}

		<ul>
			<li>User Name:</li>
			<li>{{ Form::text('username') }}</li>
		</ul>
		<div class="clear"></div>
		<ul>
			<li>Password:</li>
			<li>{{ Form::password('password') }}<br>{{ Form::submit('login', array('class'=>'signinbutton')) }}</li>
		</ul>
		<div class="clear"></div>

  {{ Form::close() }}

	<section id="forgot" style="display: none;">
		Forgot your Username or Password? <a href="forgot_email.html">Click Here</a>
	</section>
@stop
