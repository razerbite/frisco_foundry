@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')
<script>
 $('#user_list').on('change',function() {
    alert("The text has been changed.");
});
</script>
<hgroup class="header">
  <h3>Job Orders<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <!-- <a href="javascript:void(0);" class="default_popup">Create New Job Order</a> -->
  <a href="javascript:void(0);" class="default_popup addNewRFQ">Create New Job Order</a>
</hgroup>

<div class="brokenline"></div>

<div class="clear"></div>

<table class="table-C" id="view_joborders">
  <thead>
    <tr>
          <th>J.O Number</th>
          <th>P.O Number</th>
          <th>Direct Award Number</th>
          <th>Company Name</th>
          <th>Date Created</th>
          <th>Date Needed</th>
          <th>Status</th>
    </tr>
  </thead>
    <?php $ctr = 1; ?>
    @foreach($job_orders as $job_order)
      <tr onClick="window.location.href='{{ route('job_order', ['id'=>$job_order->id]) }}';">
          <td><?php echo $ctr; ?></td>
          <td>{{ $job_order->po_number }}</td>
          <td>DA_000{{ $job_order->id }}</td>
          <td>{{ $job_order->company_name }}</td>
          <td>{{ $job_order->date_created }}</td>
          <td>{{ $job_order->date_needed }}</td>
          <td>{{ $job_order->status_jo }}</td>
      </tr>
    <?php $ctr++; ?>
    @endforeach

    <?php $ctr2 = $ctr; ?>
    @foreach($quotations as $quotation)
      <tr onClick="window.location.href='{{ route('job_order', ['id'=>$quotation->id]) }}';">
          <td><?php echo $ctr2; ?></td>
          <td>PO_000{{ $quotation->id }}</td>
          <td></td>
          <td>{{ $quotation->customer->name }}</td>
          <td>{{ date('Y-m-d', strtotime($quotation->created_at)) }}</td>
          <td>{{ $quotation->date_needed }}</td>
          <td>{{ $quotation->po_status }}</td>
      </tr>
    <?php $ctr2++; ?>
    @endforeach
</table>
<br>
<a href="javascript:void(0);" class="default_popup addNewRFQ2">Add New Job Order</a>

<div class="clear"><!--clear--></div>

<!--buttons-->
<section id="buttons">
  <button class="form_button" onClick="window.location.href='{{ route('production.submit_po') }}';">Submit for PO</button>
</section>  

<div class="clear"><!--clear for buttons--></div>

<div id="add_rfq_confirmation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" style="width:650px;">
    <div class="modal-content custom-modal-content">
     <div class="modal-header custom-modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <!-- <h4 class="modal-title" id="mySmallModalLabel">Confirmation</h4> -->

        <div class="existingCustomerSelection">
          <center>
            <h4>Create New Job Order</h4>
            <button type="button" class="btn btn-primary existingCustomerBtn">With Purchase Order No.</button> &nbsp;
            <button type="button" class="btn btn-success newCustomerBtn">Direct Award</button>
          </center>
        </div>

        <div class="searchCustomerWrapper ">
           <hgroup class="searchCustomerWrapper-header">
              <h3>With P.O Number</h3>
              <div class="clear"></div>
           </hgroup>

           <div>
              <span>Select Purchase Order:</span>
                <script>
                  $(function() {
                    var opts=$("#user_source").html(), opts2="<option></option>"+opts;
                      $("#user_list").each(function() { var e=$(this); e.html(e.hasClass("placeholder")?opts2:opts); });
                      $("#user_list").select2({allowClear: true});
                  });
                </script>
                <select id="user_list" name="patient_id" class="populate new_order_form" style="width:300px;" onchange="GetSelectedTextValue(this)"></select>
                <select id="user_source" style="display:none">
                  <option value="0">PO Number</option>
                  <?php foreach($quotations as $quotation): ?>
                     <option value="{{ $quotation->id }}">PO_000{{ $quotation->id }}</option>
                  <?php endforeach; ?>
                </select>
           </div>

           <div id="quotation_wrapper_details">
             Company Name: <p id="name"></p>
           </div>
           
            <div class="clear"></div>
            
           <!-- <table class="table-C" id="search_with_po">
              <thead>
                <tr>
                  <th style="font-size:12px; width: 20px;">P.O Number</th>
                  <th style="font-size:12px;">Company Name</th>
                  <th style="font-size:12px;">Date Created</th>
                  <th style="font-size:12px;">Date Needed</th>
                </tr>
              </thead>

              @foreach($quotations as $quotation)
                <tr onClick="window.location.href='{{ route('job_order_po', ['id'=>$quotation->id]) }}';">
                    <td>PO_000{{ $quotation->id }}</td>
                    <td>{{ $quotation->customer->name }}</td>
                    <td>{{ date('Y-m-d', strtotime($quotation->created_at)) }}</td>
                    <td>{{ $quotation->date_needed }}</td>
                </tr>
              @endforeach
            </table> -->
            
            <!-- <section id="buttons" class="popup_buttons">
              <button class="form_button02" onClick="window.location.href='{{ route('production.pocreate') }}';">Create</button>
              <button class="form_button" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button>
            </section>  -->

            <div class="clear"><!--clear for buttons--></div>
        </div>
      </div>
    </div>  
  </div>
</div>

{{ HTML::script( asset('js/quotation.js')) }}
{{ HTML::style('css/jquery.dataTables.min.css') }}
{{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}
 @include('plugins.select2')

<script>
function GetSelectedTextValue(){
  var po_number = $("#user_list").val();
  //$("#main_wrapper_management").html(default_ajax_loader);
    $.post("{{URL::route('production.po_details')}}", {po_number:po_number}, function(o){
      $('#name').html(o.record.project_name);
      console.log(o.record);
    }, "json");
}
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
    window.location = "{{ URL::route('production.dacreate') }}?redirect=true";
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
    $('#view_joborders').dataTable({
    });

    $('#search_with_po').dataTable({
    });
  });
</script>

@stop
