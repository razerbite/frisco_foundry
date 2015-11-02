@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>View Customer<br><span>Aenean quis velit a neque rutrum commodo</span></h3>

    <ul id="controls">
      <li><a href="{{ route('customers.edit', ['id'=>$customer->id]) }}"><img class="icon" src="{{ asset('/images/icon_edit.png/') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png') }}" ></li>
      <li><a href="{{ route('customers.destroy', [$customer->id]) }}" class="delete-modal" data-message="Are you sure you want to delete this customer?"><img class="icon" src="{{ asset('/images/icon_trash.png') }}"></a></li>
    </ul>
  </hgroup>

  <div class="brokenline"></div>

  <ul class="page-title">
    <li><img class="photoID" src="{{ asset('/images/photo.png') }}"></li>
    <li>
      <h1>Customer ID: {{ sprintf("%03s", $customer->id) }} <br><span>{{ $customer->name }}</span></h1>
        {{ $customer->address_1 }} <br>
        {{ $customer->address_2 }}
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
      <li>{{ $customer->secretary->full_name or 'User not found'}}</li>
      <li>{{ $customer->secretary->company_position or '' }}</li>
    </ul>
  </section>

  <div class="clear"></div>

  <section class="information02"><!--This is details-->
    <hgroup>
      <h2>Customer Details</h2>
    </hgroup>

    <div id="form_info" method="post" ><!--form start-->
        <ul class="data-entry02">
          <li><label>Industry Type</label></li>
          <li>{{ $customer->industry_type_value }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Status</label></li>
          <li>{{ $customer->status_value }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Email Address</label></li>
          <li>{{ $customer->contactInfo->email }}</li>
        </ul>

        <ul class="data-entry02">
          <li style="vertical-align: top;"><label>Contact Details</label></li>
          <li>
            <ul class="mini">
              @foreach ($customer->contactInfo->contactNumbers as $contactNumber)
                <li><b>{{ $contactNumber->type_value }}</b></li>
              @endforeach
            </ul>
            <ul class="mini">
              @foreach ($customer->contactInfo->contactNumbers as $contactNumber)
                <li>{{ $contactNumber->number }}</li>
              @endforeach
            </ul>
          </li>
        </ul>
    </div>
  </section>

  <div class="filler"></div>

  <section class="information02"><!--This is details-->
    <hgroup>
      <h2>Other Information</h2>
    </hgroup>

    <div id="form_info" method="post" >
        <ul class="data-entry02">
          <li><label>Company Logo</label></li>
          <li>
          @if (isset($customer->logo_file_name))
            <img src="{{ $customer->logo->url() }}">
          @else
            <i>No Logo Uploaded</i>
          @endif
          </li>
        </ul>
        <ul class="data-entry02">
          <li style="vertical-align: top;"><label>Description</label></li>
          <li style="width: 300px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam cursus volutpat tellus vel tincidunt.
            Vestibulum semper euismod pharetra. Nam faucibus rhoncus lectus. Nam tristique ut lorem vitae posuere. </li>
        </ul>
    </div>
  </section>

  <div class="clear"></div>

  @if (isset($customer->secretary))
  <section class="information"><!--This is Client Info-->
    <hgroup>
      <h2>Secretary</h2>
    </hgroup>

    <table class="table-B"><!--This is table-->
      <th>Name</th>
      <th>Company Position</th>
      <th>Contact Details</th>
      <th>Email</th>

      <tr>
        <td>{{ $customer->secretary->full_name }}</td>
        <td>{{ $customer->secretary->company_position }}</td>
        <td>
          <ul class="mini">
            @foreach ($customer->secretary->contactInfo->contactNumbers as $contactNumber)
              <li><b>{{ $contactNumber->type_value }}</b></li>
            @endforeach
          </ul>
          <ul class="mini">
            @foreach ($customer->secretary->contactInfo->contactNumbers as $contactNumber)
              <li>{{ $contactNumber->number }}</li>
            @endforeach
          </ul>
        </td>
        <td>{{ $customer->secretary->email }}</td>
      </tr>
    </table>
  </section>
  @endif

  <section class="information clearfix"><!--This is Client Info-->
    <hgroup>
      <h2>Representatives <a href="{{ route('representative.edit', ['id'=>$customer->id]) }}"><img src="{{ asset('images/edit.png') }}" title="Edit" style="float:right; margin-right:10px;"></a></h2>

    </hgroup>
    @if(!$customer->representatives->isEmpty())
      <table class="table-B" id="representative_list_dt"><!--This is table-->
        <thead>
          <tr>
            <th>Name</th>
            <th>Company Position</th>
            <th>Contact Details</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>

        @foreach ($customer->representatives as $representative)
        <tr>
          <td>{{ $representative->full_name }}</td>
          <td>{{ $representative->company_position }}</td>
          <td>
            <ul class="mini">
            @foreach ($representative->contactInfo->contactNumbers as $number)
              <li><b>{{ $number->type_value }}</b></li>
            @endforeach
            </ul>
            <ul class="mini">
            @foreach ($representative->contactInfo->contactNumbers as $number)
              <li>{{ $number->number }}</li>
            @endforeach
            </ul>
          </td>
          <td>{{ $representative->contactInfo->email }}</td>
          <td style="text-align:center;">
          <a href="{{ route('representative.delete', [$representative->id]) }}" class="delete-modal"><img src="{{ asset('images/doc_delete.png') }}" title="Delete"></a>
          </td>
        </tr>
        @endforeach
      </table>
    @else
      <div class="alert alert-danger">
        No representatives found
      </div>
    @endif
    <br>
  <section class="information">
    <button type="button" class="button02" onClick="window.location.href='{{ route('customers.create.representative', $customer->id) }}';">Add Representative</button>
  </section>
  </section>

  <section class="information"><!--This is Client Info-->
    <hgroup>
      <h2>Quotations</h2>
    </hgroup>

    @if (!$customer->quotations->isEmpty())
    <table class="table-B" id="customer_quotation_list_dt">
      <thead>
        <tr>
          <th>RFQ ID</th>
          <th>Project Name</th>
          <th>Start Date</th>
          <th>Description</th>
          <th>Project Status</th>
        </tr>
      </thead>

      @foreach ($customer->quotations as $quotation)
      <tr>
        <td>{{ $quotation->rfq_id }}</td>
        <td><a href="{{ route('quotations.view', ['rfq' => Str::slug($quotation->rfq_id)]) }}">{{ $quotation->project_name }}</a></td>
        <td>{{ Carbon::parse($customer->date_needed)->format('d/m/Y') }}</td>
        <td>{{ $quotation->description }}</td>
        <td>{{ $quotation->status_value }}</td>
      </tr>
      @endforeach
    </table>
    @else
      <div class="alert alert-danger">
        No quotations found
      </div>
    @endif
    <br>
    <section class="information">
      <button type="button" class="button02" onClick="window.location.href='{{ route('customers.create.representative', $customer->id) }}';">Add Representative</button>
    </section>
  </section>

  <div class="clear"><!--clear--></div>

  <!--buttons-->

  <section id="buttons">
    <a href="{{ route('customers.edit', ['id'=>$customer->id]) }}" class="form_button">Edit</a>
    <a href="{{ route('customers.destroy', [$customer->id]) }}" class="delete-modal form_button" data-message="Are you sure you want to delete this customer?">Delete</a>
  </section>
  <div class="clear"><!--clear for buttons--></div>

<!--   {{ HTML::style( asset('plugins/jquery/datatables/demo_table_jui.css')) }}
  {{ HTML::script( asset('plugins/jquery/datatables/app.js')) }} -->

  {{ HTML::style( asset('css/jquery.dataTables.min.css')) }}
  {{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}

  <script>
    $(function() {
      $('#customer_quotation_list_dt').dataTable({
      });
      $('#representative_list_dt').dataTable({
      });
    });
  </script>

@stop
