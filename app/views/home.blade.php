@extends('layouts/dashboard')
@section('content')
  <ul class="divider">
    <li class="welcome"><h1>Welcome Back</h1><br>
      What do you want to do?</li>
      @include('partials.alert-messages')
  </ul><!--divider-->

  <button type="button" class="admin" onClick="window.location.href='{{ route('sales.index') }}';">Sales & Marketing</button>
  <button type="button" class="admin" onClick="window.location.href='{{ route('production.index') }}';">Production</button>
  <button type="button" class="admin">Logistics</button>
  <button type="button" class="admin">Accounting</button>
  <button type="button" class="admin">Generate Reports</button>
  <br>
  <button type="button" class="admin" onClick="window.location.href='{{ route('users.index') }}';">Admin Management</button>
@stop
