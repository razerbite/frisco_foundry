@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

@include('sales.quotations.tabs')

<div class="clear"></div>
<hgroup class="header">
  <h3>Add Request for Quotation<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <ul id="controls">
    <li><a href="#" class="submit-form"><img class="icon" src="{{ asset('images/icon_save.png') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('images/dot.png') }}" ></li>
    <li><a href="{{ route('quotations.cancel', [$quotation->id]) }}" class="delete-modal" data-message="Are you sure you want to cancel this quotation?"><img class="icon" src="{{ asset('images/icon_cancel.png') }}"></a></li>
  </ul>
</hgroup>

<div class="brokenline"></div>
@include('partials.alert-messages')
<ul class="page-title">
  <li><img class="photoID" src="{{ asset('images/photo.png') }}"></li>
  <li>
    <h1>Customer ID: {{ sprintf("%03s", $quotation->customer->id) }} <br><span>{{ $quotation->customer->name }}</span></h1>
      {{ $quotation->customer->contactInfo->address_1 }}<br>
      {{ $quotation->customer->contactInfo->address_2 }}<br>
      ATTN: <b>{{ $quotation->attns->first()->full_name }}</b> - {{ $quotation->attns->first()->company_position }}
  </li>
</ul>

<section class="deets">
  <ul>
    <li>Date Generated</li>
    <li>Secretary</li>
    <li>Assigned Technical</li>
    <li>Revision No.</li>
  </ul>
  <ul>
    <li>{{ Carbon::parse($quotation->created_at)->toDayDateTimeString() }}</li>
    <li>{{ $quotation->secretary->full_name or 'User not found' }}</li>
    <li>{{ $quotation->technical->full_name or 'User not found' }}</li>
    <li>001</li>
  </ul>
</section>

<div class="clear"></div>
{{ Form::model($quotation, ['method'=>'PUT', 'files'=>'true']) }}
<section class="information"><!--This is details-->
  <hgroup>
    <h2>Step 3: Executive Approval</h2>
  </hgroup>

  <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry02">
        <li><label>Date Needed</label></li>
        <li>{{ Carbon::parse($quotation->date_needed)->format('F j, Y') }}</li>
      </ul>

      <ul class="data-entry02">
        <li><label>Customer PR/RFQ No.</label></li>
        <li>{{ $quotation->customer_pr_no }}</li>
      </ul>

      <ul class="data-entry02">
        <li><label>Description</label></li>
        <li>{{ $quotation->description }}</li>
      </ul>
  </div>


  <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry02">
        <li><label>Quantity</label></li>
        <li>{{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }}</li>
      </ul>

      <ul class="data-entry02">
        <li><label>Unit of Measure</label></li>
        <li>{{ $quotation->unit_of_measurement_value }}</li>
      </ul>
  </div>


<div class="clear"></div>

  <style>
    td input[type=text],
    td input[type=number] {
      width: 100% !important;
    }
    td input[type=number] {
      text-align: center;
    }
    .text-area {
      width: 100%;
      padding: 5px;
    }
  </style>

<div class="brokenline02"></div>

  @if(Session::has('materialMessage'))
    <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{ Session::get('materialMessage') }}
    </div>
  @endif
  @include('partials.error-messages')

  <p><b>Scope of Work (SoW)</b></p>

  <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry">
        <li><label>Type of Work</label></li>
        <li>
          {{ Form::select('type_of_work_id', [''=>'Please Select']+$typesOfWorkList, null, ['required']) }}
        </li>
      </ul>
  </div>

  <table class="table-B"><!--This is table-->
    <th style="width: 60px;">Item Letter</th>
    <th>Scope Details</th>
    <th style="width: 60px;">Action</th>

    @foreach ($quotation->scopes as $index => $scope)
      <tr>
        <td style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
        <td>{{ Form::textarea("scopes[$index][scope]", $scope->scope, ['class'=>'text-area']) }}</td>
        <td style="text-align: center;">
          <a href="{{ route('quotations.bom', ['rfq'=>Str::slug($quotation->rfq_id)]) }}"><img src="{{ asset('images/edit.png') }}" title="Delete"></a>
          <img src="{{ asset('images/dot02.png') }}">
          <a href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}" class="delete-modal"><img src="{{ asset('images/doc_delete.png') }}" title="Delete"></a>
        </td>
      </tr>
    @endforeach

  </table>

  <div class="clear"></div>


  <div class="brokenline02"></div>

  <p><b>Bill of Materials (BM)</b></p>

  <table class="table-B">
      <th>Item Letter</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>
      <th>Upload File</th>
      <!-- <th>BM Price</th> -->
      <th>Quotation Price/Unit</th>
      <th>Total</th>
      @foreach ($quotation->materials as $index => $material)
      <tr>
        <td style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
        <td><span class="material-quantity">{{ $material->quantity }}</span> {{ Str::plural('pc', $material->quantity) }}</td>
        <td>{{ $material->unit_of_measure }}</td>
        <td>{{ $material->description }}</td>
        <td>{{ $material->size }}</td>
        <td>
          @if (isset($material->file_file_name))
            <a href="{{ $material->file->url() }}">{{ $material->file_file_name }}</a>
          @endif
        </td>
        <!-- <td><input type="text" value="N/A"></td> -->
        <td>P{{ Form::text("materials[$index][price_per_unit]", number_format($material->price_per_unit, 2, '.', ''), ['required', 'placeholder'=>'00.00', 'style'=>'width: 90% !important;', 'pattern'=>'^\d*(\.\d{2}$)?', 'title'=>'00.00', 'class'=>'material-price']) }}</td>
        <td><input type="text" placeholder="P 00.00" class="material-total" readonly></td>
      </tr>
      @endforeach

    </table>


  <div class="clear"></div>

  <ul class="total-quotation">
    <li><label>Total Price</label></li>
    <li><input id="total-price" type="text" value="P00.00" readonly></li>
  </ul>

  <ul class="total-quotation">
    {{ Form::hidden('vat_excempt', 0); }}
    <li><label style="display:none">{{ Form::checkbox('vat_excempt', 1, null, ['id'=>'vat']) }} Vat Exclusive</label></li>
  </ul>

  <div class="clear"></div>

  <p class="VAT"><span>*</span>All Prices are VAT Inclusive</p>
  <br>
  <div class="brokenline02"></div>

  <section class="information">
    <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry02">
        <li><label>Quotation Notes</label></li>
        <li> {{ Form::textarea('note') }} </li>
      </ul>
  </div>
  </section>

  <div class="brokenline02"></div>

  <p><b>Due Date</b></p>
  <div id="form_info02" method="post" ><!--form start-->
      <ul class="data-entry">
        <li><label>Commitment Completion</label></li>
        <li>{{ Form::input('date', 'due_date', null, ['required']) }}</li>
        <li>
          {{ Form::select('due_date_commitment', [''=>'Please Select']+$commitmentRangeList) }}
        </li>
      </ul>

      <ul class="data-entry">
        <li><label>Warranty</label></li>
        <li>{{ Form::number('warranty') }}</li>
        <li>
          {{ Form::select('warranty_duration_id', [''=>'Please Select']+$warrantyDurationList) }}
        </li>
      </ul>
  </div>

  <div class="brokenline02"></div>

  <section class="information"><!--This is details-->
    <div id="form_info" method="post"><!--form start-->

      <ul class="data-entry02">
        <li><label>Prepared by</label></li>
        <li>{{ $quotation->secretary->full_name  or 'User not found' }}</li>
      </ul>


      <ul class="data-entry02">
        <li><label>Reviewed by</label></li>
        <li>{{ Form::select('technical_id', [''=>'Please Select']+$technicalsList) }}</li>
      </ul>

    </div>

    <div id="form_info" method="post"><!--form start-->

      <ul class="data-entry02">
        <li><label>Approved by</label></li>
        <li><li>{{ Form::select('executive_id', [''=>'Please Select']+$executivesList, Auth::user()->id) }}</li></li>
      </ul>

      <!--ul class="data-entry02">
        <li><label>Reviewed on</label></li>
        <li>May 12, 2014; 3:00pm</li>
      </ul-->

      <ul class="data-entry02">
        <li style="vertical-align: top"><label>Digital Signature</label></li>
        <li>
          {{ Form::file('signature') }}
          @if (isset($quotation->signature_file_name))
            <div style="margin-top: 5px">
              <img src="{{ $quotation->signature->url() }}" alt="">
            </div>
        @endif
        </li>
      </ul>
    </div>
  </section>

  <div class="brokenline02"></div>

<section class="information">
  <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry02">
        <li><label>Notes <b>(Optional)</b></label></li>
        <li>
          {{ Form::textarea('notes', '') }}
        </li>
      </ul>
  </div>
  <div class="clear"></div>
<!--     <ul class="total-quotation">
      <li></li>
      <li><input type="checkbox"><label>Notify Secretary</label></li>
      <li><input type="checkbox"><label>Notify Technical</label></li>
    </ul>
 -->  @include('sales.quotations.notes')
</section>

<div class="clear"></div>

<section id="buttons">
  <input type="submit" value="Save" class="form_button02">
  @if(Entrust::can('view_summary'))
    <button type="button" class="form_button02" onClick="window.location.href='{{ route('quotations.summary', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Continue</button>
  @endif
  <button type="button" class="form_button" onClick="window.location.href='{{ route('sales.index') }}';">Cancel</button>
</section>

<div class="clear"><!--clear for buttons--></div>
{{ Form::close() }}

<script>
  Number.prototype.formatMoney = function(c, d, t){
  var n = this,
      c = isNaN(c = Math.abs(c)) ? 2 : c,
      d = d == undefined ? "." : d,
      t = t == undefined ? "," : t,
      s = n < 0 ? "-" : "",
      i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
      j = (j = i.length) > 3 ? j % 3 : 0;
     return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
   };

  $totalPrice = $('#total-price');
  $materialTotals = $('.material-total');
  var vat = $('#vat').prop('checked');

  $('#vat').change(function(){
    vat = !vat;
    updateTotal();
  });

  function updateTotal() {
    var total = 0;

    // Get total
    $materialTotals.each(function(i, el){
      total += parseFloat($(el).val().replace(',', '')) || 0;
    });

    // Vat
    var tax = (total / 1.12 ) * 0.12;
    if (vat)
      total += tax;

    $totalPrice.val(total.formatMoney(2));
  }

  $(function(){
    $('.material-price').each(function(i, el){
      var $this = $(el);
      var $parent = $this.closest('tr');
      var $total = $parent.find('.material-total');
      var quantity = parseFloat($parent.find('.material-quantity').text());
      var updateRowTotal = function(){
        var price = parseFloat($this.val().replace(',', '')) || 0;

        // Check if valid number
        if ((price != NaN) && (quantity != NaN))
          $total.val((price * quantity).formatMoney(2));

        updateTotal();
      };
      $this.keyup(updateRowTotal);
      updateRowTotal();
    });
    updateTotal();
  });

</script>

@stop
