<!DOCTYPE html>
<html>
<head>
  <title>FriscoFoundry</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  {{ HTML::style( asset('plugins/tb/css/bootstrap.min.css')) }}

  <style>
    .spacer { margin-bottom: 40px; }
  </style>
</head>
<body>

<div class="container">
  <div class="row clearfix">
    <div class="page-header clearfix">
      <div class="col-md-2 column">
        <img alt="140x140" width="100%" src="{{ asset('images/FF-logo.png') }}" />
      </div>
      <div class="col-md-10 column">
        <h1>
          Frisco Foundry &amp; Machinery Corp. <br><small>Internal Quotation Request</small>
        </h1>
      </div>
    </div>
  </div>
  <div class="row clearfix">
    <div class="col-md-8 column">
      <h4>{{ $quotation->customer->name }} <br><small>Customer ID: {{ sprintf("%03s", $quotation->customer->id) }}</small></h4>

      <dl class="dl-horizontal">
        <dt> Project Name </dt>
        <dd> {{ $quotation->project_name }} </dd>
        <dt> RFQ ID </dt>
        <dd> {{ $quotation->rfq_id }} </dd>
        <dt> Customer PR/RFQ No. </dt>
        <dd> {{ $quotation->customer_pr_no }} </dd>
        <dt> Description </dt>
        <dd> {{ $quotation->description }} </dd>
        <dt> Quantity </dt>
        <dd> {{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }} </dd>
        <dt> Unit of Measure </dt>
        <dd> {{ $quotation->unit_of_measurement_value }} </dd>
        <dt> Date Needed </dt>
        <dd> {{ Carbon::parse($quotation->date_needed)->format('F j, Y') }} </dd>
      </dl>
    </div>
    <div class="col-md-4 column">
       <address>
          {{ $quotation->customer->contactInfo->address_1 }}<br />
          {{ $quotation->customer->contactInfo->address_2 }}<br />
          @foreach ($quotation->customer->contactInfo->contactNumbers as $number)
           <abbr title="{{$number->type_value}}">{{$number->type_value[0]}}:</abbr> {{ $number->number }}
          @endforeach

       </address>
    </div>
  </div>
  <div class="spacer clearfix"></div>
  <div class="row clearfix">
    <div class="col-md-12 column">
      <h4>Scope of Work</h4>
      <dl class="dl-horizontal">
        <dt>Type of Work</dt>
        <dd>{{ $quotation->type_of_work_value }}</dd>
      </dl>

      <table class="table table-bordered">
        <thead>
          <tr>
            <th> Item Letter </th>
            <th> Scope </th>
          </tr>
        </thead>
        <tbody>
        @foreach ($quotation->scopes as $index => $scope)
          <tr>
            <td style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
            <td>{{ nl2br($scope->scope) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @if(Entrust::can('view_approval'))
  <div class="row clearfix">
    <div class="col-md-12 column">
      <h4>Bill of Materials</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th> Item Letter </th>
            <th> Quantity </th>
            <th> UoM </th>
            <th> Description </th>
            <th> Size </th>
            <th> Price/Unit </th>
            <th> Total Materials Price</th>
          </tr>
        </thead>
        <tbody>
        <?php $total_bill_materials = 0; ?>
        @foreach ($quotation->materials as $index => $material)
          <tr>
            <td style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
            <td><span class="material-quantity">{{ $material->quantity }}</span> {{ Str::plural('pc', $material->quantity) }}</td>
            <td>{{ $material->unit_of_measure }}</td>
            <td>{{ $material->description }}</td>
            <td>{{ $material->size }}</td>
            <td>
              @if($material->getOriginal('price_per_unit') != $material->price_per_unit)
              <del>P{{ number_format($material->getOriginal('price_per_unit'), 2) }}</del>
              @endif
              <p>P{{ number_format($material->price_per_unit, 2) }}</p>
            </td>
            <td>
              <p>P{{ number_format($material->total_amount, 2) }}</p>
            </td>
          </tr>
          <?php $total_bill_materials += $material->total_amount ?>
        @endforeach
        </tbody>
      </table>
        <p style="text-align:right;"><b>Total Bill of Materials:</b> P{{ number_format($total_bill_materials,2) }}</p>
    </div>
  </div>

  <div class="row clearfix">
    <div class="col-md-12 column">
      <h4>Quotation Price</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th> Quotation Price </th>
            <th> Tax </th>
            <th> Total Quotation Price </th>
          </tr>
        </thead>
        <tbody>
        @foreach ($quotation->materials as $index => $material)
          <tr>
            <td>P{{ number_format($quotation->price, 2) }}</td>
            <td>P{{ number_format($quotation->materials_tax, 2) }}</td>
            <td>P{{ number_format($quotation->price + $quotation->materials_tax, 2) }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>
  </div>




  <div class="row clearfix">
    <div class="col-md-8 column">
      @if ($quotation->discount)
      <h4>Discounts</h4>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th> Amount </th>
            <th> Discount Type </th>
            <th> Modify by </th>
            <th width="50%"> Notes </th>
          </tr>
        </thead>
        <tbody>
        @foreach ($quotation->discounts as $index => $discount)
          <tr>
            <td>{{ number_format($discount->amount, 2, '.', '') }}</td>
            <td>{{ $discount->type }}</td>
            <td>{{ $discount->modification }}</td>
            <td>{{ $discount->note }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      <p><small>* per piece discount subtracted before tax</small></p>
    @endif
    </div>

<!--     <div class="col-md-4 column">
    <h4>Total</h4>
    <table class="table">
      <tbody>
        <tr>
          <td>Materials Price:</td>
          <td><strong>P{{number_format($quotation->materials_price, 2)}}</strong></td>
        </tr>
        <tr>
        <tr>
          <td>Quotation Price:</td>
          <td><strong>P{{number_format($quotation->price, 2)}}</strong></td>
        </tr>
        <tr>
          <td>Tax:</td>
          <td><strong>P{{number_format($quotation->materials_tax, 2)}}</strong></td>
        </tr>
        <tr>
          <td>Total amount:</td>
          <td><strong>P{{number_format($quotation->materials_price + $quotation->materials_tax, 2)}}</strong></td>
        </tr>
        @if($quotation->discount)
        <tr>
          <td>Lot price discounts:</td>
          <td><strong>P({{number_format($quotation->lot_discount, 2)}})</strong></td>
        </tr>
        @endif
      </tbody>
      <tbody>
        <tr>
          <td><strong>Net amount</strong></td>
          <td><strong>P{{number_format($quotation->materials_price_with_tax - $quotation->lot_discount, 2)}}</strong></td>
        </tr>
      </tbody>
    </table>
    </div> -->

  </div>
  @endif
  <div class="spacer clearfix"></div>
  <div class="row clearfix">
    <div class="col-md-4 column">
      <dl class="dl-horizontal">
        <dt>Prepared by</dt>
        <dd>{{ $quotation->secretary->full_name or '' }}</dd>
      </dl>
    </div>
    <div class="col-md-4 column">
      <dl class="dl-horizontal">
        <dt>Reviewed by</dt>
        <dd>{{ $quotation->technical->full_name or ''}}</dd>
      </dl>
    </div>
    <div class="col-md-4 column">
      <dl class="dl-horizontal">
        <dt>Approved by</dt>
        <dd>{{ $quotation->executive->full_name or ''}}</dd>
      </dl>
    </div>
  </div>
</div>


</body>
</html>
