@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3 style="margin: 0">List of Customers<br>
    <span>Ipsum odio volutpat nulla.</span></h3>
    <a href="{{ route('customers.create') }}" class="default_popup">Add New Customer</a>
  </hgroup>

  <div class="brokenline"></div>

  @include('partials.alert-messages')

{{--   <ul id="filter-search"><!--This is filter search-->
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

  <!-- {{Form::open(array('url'=>'/search'))}}
      {{Form::text('keyword', null, array('placeholder'=>'Search by keyword'))}}
      {{Form::submit('Search')}}
  {{Form::close()}} -->

  <div class="clear"><!--clear--></div>

   <section class="information"><!--This is details -->
    @if (!$customers->isEmpty())
      <table class="table-C" id="customer_list_dt">
        <thead>
          <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Office Address</th>
            <th>Industry Type</th>
            <th>Representative</th>
            <th>Secretary</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>

        <!-- <tr onClick="window.location.href='view-client.html';"></tr> -->
        @foreach($customers as $customer)
          <tr onClick="window.location.href='{{ route('customers.view', ['id'=>$customer->id]) }}';">
            <td>{{ sprintf("%03s", $customer->id) }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->address or 'N/A' }}</td>
            <td>{{ $customer->industry_type_value }}</td>
            <td>{{ $customer->representatives->first()->full_name or '' }}</td>
            <td>{{ $customer->secretary->full_name or 'User not found' }}</td>
            <td>{{ $customer->status_value }}</td>
            <td>
              <ul id="actions">
                <li><a href="{{ route('quotations.create', ['customerId'=>$customer->id]) }}">Add RFQ</a></li>
                @if (Entrust::can('direct_award'))
                  <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot02.png') }}"></li>
                  <li><a href="{{ route('quotations.create', ['customerId'=>$customer->id]) }}?award=true">Direct Award</a></li>
                @endif
              </ul>
            </td>
          </tr>
        @endforeach
      </table>

      {{ $customers->links() }}
      <br>
      <button class="button02" onClick="window.location.href='{{ route('customers.create') }}';">Add New Customer</button>
    @else
      <p class="alert alert-danger">No customers found</p>
    @endif
  </section>
  <div class="clear"><!--clear--></div>

  

<!--   {{ HTML::style( asset('plugins/jquery/datatables/demo_table_jui.css')) }}
  {{ HTML::script( asset('plugins/jquery/datatables/app.js')) }} -->

  {{ HTML::style( asset('css/jquery.dataTables.min.css')) }}
  {{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}
  
  <script>
    $(function() {
      $('#customer_list_dt').dataTable({
      });
    });
  </script>

@stop
