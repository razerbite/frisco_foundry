@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3 style="margin: 0;">Requests for Quotation<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
    <a href="javascript:void(0);" class="default_popup addNewRFQ">Add New RFQ</a>
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

  <div class="clear"><!--clear--></div>

   <section class="information"> <!-- This is details -->
   @if (!$quotations->isEmpty())

      <table class="table-C" id="quotation_list_dt">
        <thead>
          <tr>
            <th>RFQ No.</th>
            <th>Project Name</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>ATTN</th>
            <th>End User(s)</th>
            <th>Assigned Tech</th>
            <th>Status</th>
          </tr>
        </thead>
        
        @foreach ($quotations as $quotation)
        <tr onClick="window.location.href='{{ route('quotations.view', ['rfq' => Str::slug($quotation->rfq_id)]) }}';">
          <td>{{ $quotation->rfq_id }}</td>
          <td>{{ $quotation->project_name }}</td>
          <td>{{ $quotation->description }}</td>
          <td>{{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }}</td>
          <td>{{ $quotation->attns->first()->full_name or 'N/A'}}</td>
          <td>{{ $quotation->secretary->full_name or 'User not found' }}</td>
          <td>{{ $quotation->technical->full_name or 'N/A'}}</td>
          <td>{{ $quotation->status_value }}</td>
        </tr>
        @endforeach

      </table>
      {{ $quotations->links(); }}
      <br>
      <a href="javascript:void(0);" class="default_popup addNewRFQ2">Add New RFQ</a>
      <!-- <a href="#inline" class="default_popup">Add New RFQ</a>  -->
      <!--button class="button02" onClick="window.location.href='add-request-quotation.html';">Add New RFQ</button -->
  @else
    <p class="alert alert-danger">No quotations found</p>
  @endif
  </section>
  <div class="clear"><!--clear--></div>

  <div id="add_rfq_confirmation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width:500px;">
      <div class="modal-content">
       <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
          <!-- <h4 class="modal-title" id="mySmallModalLabel">Confirmation</h4> -->

          <div class="existingCustomerSelection">
            <center>
              <h4>Is this an Existing Customer?</h4>
              <button type="button" class="btn btn-primary existingCustomerBtn" style="width:100px;">Yes</button> &nbsp;
              <button type="button" class="btn btn-success newCustomerBtn" style="width:100px;">No </button>
            </center>
          </div>

          <div class="searchCustomerWrapper">
            <h4>Search Customer</h4>
            <form>
              <input type="hidden" id="existing_customer" name="existing_customer" class="bigdrop" style="width:360px;" />
              <button type="button" class="btn btn-success proceedNewCustomerBtn" style="width:100px;">Proceed</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{ HTML::script( asset('js/quotation.js')) }}
<!--   {{ HTML::style( asset('plugins/jquery/datatables/demo_table_jui.css')) }}
  {{ HTML::script( asset('plugins/jquery/datatables/app.js')) }} -->

  {{ HTML::style( asset('css/jquery.dataTables.min.css')) }}
  {{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}
  @include('plugins.select2')

  <script>
  $(function() {
    // showQuotationList({
    //   "url" : "@{{ URL::route('quotation.list') }}"
    // });

    $('.addNewRFQ').on('click',function() {
      $('#add_rfq_confirmation').modal();
    });

    $('.addNewRFQ2').on('click',function() {
      $('#add_rfq_confirmation').modal();
    });

    $('#add_rfq_confirmation').on('hide.bs.modal',function() {
      $('.existingCustomerSelection').show();
      $('.searchCustomerWrapper').hide();
    });

    $('.newCustomerBtn').on('click',function() {
      window.location = "{{ URL::route('customers.create') }}?redirect=true";
    });

    $('.existingCustomerBtn').on('click',function() {
      $('.existingCustomerSelection').hide();
      $('.searchCustomerWrapper').show();
    });

    $('.searchCustomerWrapper').hide();
    $("#existing_customer").select2({
          placeholder: "",
          minimumInputLength: 1,
          ajax: {
              url       : "{{ URL::route('customers.get.data') }}",
              dataType  : "json",
              type      : "POST",
              allowClear: true,
              data: function (term, page) {
                  return {
                      q: term, // search term
                      page_limit: 10,
                  };
              },
              multiple: true,
              allowClear: true,
              results: function (data, page) {
                  return {results: data};
              }
          },
      });

      $('.proceedNewCustomerBtn').on('click',function() {
        var customer_id = $('#existing_customer').val();
        if(!hasValue(customer_id)) {
          alert("Please select client first.");
        }
        window.location.href = '{{url ("/sales/quotations/create/")}}' + '/' + customer_id;
      });
  })

  $(function() {
    $('#quotation_list_dt').dataTable({
    });
  });
  </script>
@stop
