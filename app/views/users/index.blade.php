@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

        <hgroup class="header">
          <h3>List of User Accounts<br><span>Ipsum odio volutpat nulla.</span></h3>
          <button onClick="window.location.href='{{ route('users.create') }}';">Add New Account User</button>
        </hgroup>

        <div class="brokenline"></div>
        @include('partials.alert-messages')

{{--         <ul id="filter-search"><!--This is filter search-->
          <li>
            <select name="filter" class="select">
              <option value="option 1">10</option>
              <option value="option 2">20</option>
              <option value="option 3">30</option>
            </select>
          </li>
          <li>items per page</li>
        </ul>

        <ul id="text-search"><!--This is text search-->
          <li><input type="search" name="Name"  value="Filter Information"></li>
        </ul> --}}

        <div class="clear"><!--clear--></div>

        <section class="information clearfix"><!--This is details-->

            <table class="table-C" id="user_account_list_dt">
              <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Account Type</th>
                    <th>Email Address</th>
                    <th>Status</th>
                </tr>
              </thead>

              @foreach ($users as $user)
              <tr onClick="window.location.href='{{ route('users.show', ['id'=>$user->id]) }}';">
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->roles->first()->name or 'ERROR' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status_value }}</td>
              </tr>
              @endforeach

            </table>

            <!-- {{ $users->links() }} -->
            <br>
            <button class="button02" onClick="window.location.href='{{ route('users.create') }}';">Add New Account User</button>
        </section>

        <div class="clear"><!--clear--></div>

  {{ HTML::style( asset('css/jquery.dataTables.min.css')) }}
  {{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}

  <script>
      $(function() {
        $('#user_account_list_dt').dataTable({
        });
      });
  </script>
@stop
