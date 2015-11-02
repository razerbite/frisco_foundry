<?php ini_set('max_execution_time', 0); ?>
<!DOCTYPE html>
<html>
<head>
  <title>FriscoFoundry</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  <style>
    body {
      font-size: 12pt;
      font-family: Helvetica, Arial, sans-serif;
    }
	
	.headergroup{font-size: 24px; font-weight: 500px; margin-top: 25px;}
	.headergroup span {font-size: 14px;}
	
	.col-6 ul {list-style: none; margin: 0 0 0 10px; padding: -10px;}
	.col-6 ul li {display: inline-block; width: 200px; text-align: left;}
	.col-6 ul li:nth-child(2) {width: 200px; text-align: left;}

  .col ul {list-style: none; margin: 0 0 0 10px; padding: -8px;}
  .col ul li {display: inline-block; width: 100px; text-align: left;}
  .col ul li:nth-child(2) {width: 200px; text-align: left;}
	
  .spacer { margin-bottom: 40px; }
  .column { float: left; }
  .col-12 { width: 100%; }
  .col-11 { width: 91.66666667%; }
  .col-10 { width: 83.33333333%; }
  .col-9 { width: 75%; }
  .col-8 { width: 66.66666667%; }
  .col-7 { width: 58.33333333%; }
  .col-6 { width: 50%; }
  .col-5 { width: 41.66666667%; }
  .col-4 { width: 33.33333333%; }
  .col-3 { width: 25%; }
  .col-2 { width: 16.66666667%; }
  .col-1 { width: 8.33333333%; }
  td { vertical-align: top; }
  dd {
    margin-bottom: 5px;
  }
  /* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

table {
    border-collapse: collapse;
    border-spacing: 0;
}
.frisco-data { border: solid; border-width: 1px; border-color: #EAE9EA; text-align: center; border-collapse: collapse;
    border-spacing: 0;}

.frisco-data td { border: solid; border-width: 1px; border-color: #EAE9EA; padding-top: 11.9px; padding-bottom: 11.9px; font-size: 13px; }
.frisco-data2 th { text-align: left; font-weight: bold; border: solid; border-width: 1px; border-color: #EAE9EA; padding-top: 11.9px; padding-bottom: 11.9px; font-size: 13px; padding-left: 5%; }
.frisco-data2 td { text-align: left; padding-left: 5%; border: solid; border-width: 1px; border-color: #EAE9EA; padding-top: 11.9px; padding-bottom: 11.9px; font-size: 13px; }
.frisco-data3 th { text-align: left; font-weight: bold; border: solid; border-width: 1px; border-color: #EAE9EA; padding-top: 11.9px; padding-bottom: 11.9px; font-size: 13px; padding-left: 10%; }
.frisco-data3 td { text-align: left; padding-left: 10%; border: solid; border-width: 1px; border-color: #EAE9EA; padding-top: 11.9px; padding-bottom: 11.9px; font-size: 13px; }
  </style>
</head>
<body>

<div class="container">
  <div class="row clearfix" style="float: left;">
      <table style="width:100%; background-color: #B0AD6D; text-align: center;">
        <tr>
          <td>
            <h1 style="text-align: center; font-size:18px; color: white;">FRISCO FOUNDRY and MACHINERY CORP.</h1>
          </tr>
        </td>
      </table>
	  
      <div style="width: 25%; text-align: center; padding-top: 26.5px; padding-bottom: 26.5px; display: inline-block; margin: 0; margin-right: -5px; border: solid; border-width: 1px; border-color: #EAE9EA;">
         <img width="150px" style="" src="{{ asset('images/FF-logo-xs.png') }}" />
      </div>
	  
      <div style="width: 74.5%; border: solid; border-width: 1px; border-color: #EAE9EA; text-align: center; padding-top: 20px; padding-bottom: 20px; display: inline-block; margin: 0; padding: 0;">
        <table style="width: 100%;">
          <tr class="frisco-data">
            <td>RFQ No. {{ $quotation->customer_pr_no }}</td>
            <td>Prepared By</td>
            <td>Approved By</td>
          </tr>
          <tr class="frisco-data">
            <td>Issuance No. 02</td>
            <td style="border-top:transparent; border-bottom: transparent;"><!--blank space--></td>
            <td style="border-top:transparent; border-bottom: transparent;"><!--blank space--></td>
          </tr>
          <tr class="frisco-data">
            <td>{{ Carbon::now()->toFormattedDateString() }}</td>
            <td style="border-top:transparent; border-bottom: transparent;">{{ $quotation->secretary->full_name  or '' }}</td>
            <td style="border-top:transparent; border-bottom: transparent;">{{ $quotation->executive->full_name or ''}}</td>
          </tr>
          <tr class="frisco-data">
            <td>Page 1 of 2</td>
            <td style="border-top: transparent;">Technical</td>
            <td style="border-top: transparent;">Executive</td>
          </tr>
        </table>
      </div>

  </div>
  <div class="row clearfix" style="float:left;">
    <div class="col-8 column">
      <hgroup class="headergroup">{{ $quotation->customer->name }}<br></hgroup>
       <table class="col-12">
        <tr>
         <td class="col" style="width: 100%;">
            <ul style="font-size: 14px;"> 
               <li><b>Date Needed:</b></li>
               <li>{{ Carbon::parse($quotation->date_needed)->format('F j, Y') }}</li>
               <li><b>Address: </b></li>
               <li>
                  {{ $quotation->customer->contactInfo->address_1 }}
                  {{ $quotation->customer->contactInfo->address_2 }}
               </li>
            </ul>
            <ul style="font-size: 14px;">
              <li><b>RFQ No. </b></li>
              <li>{{ $quotation->customer_pr_no }}</li>
              <li>
               @foreach ($quotation->customer->contactInfo->contactNumbers as $number)
                <b>{{$number->type_value}}:</b>
              <li>
                {{ $number->number }}<br /></li>
               @endforeach
              </li>
            </ul>
            <br>
         </td>
         </tr>
         </table>
		
		<!--john, I used lists instead of <dt>, makes it cleaner to look at-->
      <table class="col-12">
        <tr>
			<!--td class="col-6" style="width: 400px">
			   <dt> Project Name </dt>
			   <dd> {{ $quotation->project_name }} </dd>
			   <dt> Description </dt>
			   <dd> {{ $quotation->description }} </dd>
			</td-->
			
			<td class="col-6" style="width: 100%;">
				<!--ul>
				   <li> Project Name </li>
				   <li> {{ $quotation->project_name }} </li>
				</ul-->
				<ul>
				   <li><b> Quantity:</b></li>
           <li>  &nbsp; &nbsp;{{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }} </li>
        </ul>
        <ul>
				   <li><b> Description: </b></li>
           <li>  &nbsp;  &nbsp;{{ $quotation->description }} </li>
        </ul>
        <ul>
           <li><b>Due Date</b></li>
           <br>
           <li><b>Commitment, Completion:</b></li>
           <li> &nbsp; {{ $quotation->due_date }}, {{ $quotation->due_date_commitment }} </li>
        </ul>
        <ul>
           <li><b>Warranty:</b>  </li>
           @if ($quotation->warranty_duration_id === 1)
            <li>&nbsp;&nbsp; {{ $quotation->warranty }} Days</li>
           @elseif ($quotation->warranty_duration_id === 2)
            <li> &nbsp;&nbsp; {{ $quotation->warranty }} Months</li>
           @else
            <li> &nbsp;&nbsp;{{ $quotation->warranty }} Years</li>
           @endif
        </ul>
			</td>
			
			<!--td class="col-6" style="width: 300px">
			   <dt> Quantity </dt>
			   <dd> {{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }} </dd>
			   <dt> Unit of Measure </dt>
			   <dd> {{ $quotation->unit_of_measurement_value }} </dd>
			   <dt> Date Needed </dt>
			   <dd> {{ Carbon::parse($quotation->date_needed)->format('F j, Y') }} </dd>
			</td-->
			
			<td class="col-6" style="width: 30%;">
				<!--ul>
				   <li> Quantity</li>
				   <li> {{ $quotation->quantity }} {{ Str::plural('pc', $quotation->quantity) }} </li>
				</ul>
				<ul>
				   <li> Unit of Measure  </li>
				   <li> {{ $quotation->unit_of_measurement_value }} </li>
				</ul>
				<ul>
				   <li> Date Needed </li>
				   <li> {{ Carbon::parse($quotation->date_needed)->format('F j, Y') }} </li>
				</ul-->
			</td>
       </tr>
     </table>
     <dl class="dl-horizontal">


      </dl>
    </div>
    <div class="col-4 column">
    </div>
  </div>
  <div class="spacer clearfix"></div>

  <hr />

  <div class="col-12">

  <p>Dear {{ $quotation->attns->first()->full_name }},</p> <!--john, please change from first name to "sir/ma'am"-->

    <p>Thank you for giving us the opportunity to participate in ths endeavor.
    We are pleased to submit our quotation for the following for your perusal.</p>
    <p><b>Scope of Work are the following:</b></p>
    <ul class="scope">
      @foreach ($quotation->scopes as $scope)
        <li>{{ $scope->scope }}</li>
      @endforeach
    </ul>

  </div>

  <!-- NEW PAGE -->
  <!-- <div style="page-break-before: always;"></div>
  <table style="width:100%; background-color: #B0AD6D; text-align: center;">
    <tr>
      <td>
        <h1 style="text-align: center; font-size:18px; color: white;">FRISCO FOUNDRY and MACHINERY CORP.</h1>
      </tr>
    </td>
  </table>
  <div style="width: 25%; text-align: center; padding-top: 26.5px; padding-bottom: 26.5px; display: inline-block; margin: 0; margin-right: -5px; border: solid; border-width: 1px; border-color: #EAE9EA;">
     <img width="150px" style="" src="{{ asset('images/FF-logo-xs.png') }}" />
  </div>
  <div style="width: 74.5%; border: solid; border-width: 1px; border-color: #EAE9EA; text-align: center; padding-top: 20px; padding-bottom: 20px; display: inline-block; margin: 0; padding: 0;">
    <table style="width: 100%;">
      <tr class="frisco-data">
        <td>RFQ No. {{ $quotation->customer_pr_no }}</td>
        <td>Prepared By</td>
        <td>Approved By</td>
      </tr>
      <tr class="frisco-data">
        <td>Issuance No. 02</td>
        <td style="border-top:transparent; border-bottom: transparent;"></td>
        <td style="border-top:transparent; border-bottom: transparent;"></td>
      </tr>
      <tr class="frisco-data">
        <td>{{ Carbon::now()->toFormattedDateString() }}</td>
        <td style="border-top:transparent; border-bottom: transparent;">{{ $quotation->secretary->full_name  or '' }}</td>
        <td style="border-top:transparent; border-bottom: transparent;">{{ $quotation->executive->full_name or ''}}</td>
      </tr>
      <tr class="frisco-data">
        <td>Page 2 of 2</td>
        <td style="border-top: transparent;">Technical</td>
        <td style="border-top: transparent;">Executive</td>
      </tr>
    </table>
  </div> -->

  <!-- FOR EDIT -->

  <!-- SCOPE OF WORK -->
  
  
  <!-- <div class="row clearfix">
     <div class="col-md-12 column">
    <div>
      <h4>SCOPE OF WORK</h4>
      <table>
        <tr>
          <td style="font-weight: bold;">Type of Work:</td>
          <td style="padding-left: 10px;">{{ $quotation->type_of_work_value }}</td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 10px;">
      <tr class="frisco-data2">
        <th style="width: 30%;">Item Letter</th>
        <th style="width: 70%;">Scope</th>
      </tr>
      @foreach ($quotation->scopes as $index => $scope)
        <tr class="frisco-data2">
          <td>{{ Str::numToAlpha($index) }}</td>
          <td>{{ nl2br($scope->scope) }}</td>
        </tr>
      @endforeach
    </table>
    </div>
  </div> -->
  <!-- <div style="page-break-before: always;"></div> -->
  <!-- DISCOUNTS -->
 
  <div class="row clearfix">
    <div style="display: inline-block; width: 60%;">
      @if ($quotation->discount)
      <h4>Discounts</h4>
      @endif
      <div style="width:100%; display: inline-block;">
        @if ($quotation->discount)
        <table style="width: 100%;">
          <tr class="frisco-data3">
            <th>Amount</th>
            <th>Discount Type</th>
            <th>Modify by</th>
            <th>Notes</th>
          </tr>
          @foreach ($quotation->discounts as $index => $discount)
          <tr class="frisco-data3">
             <td>{{ number_format($discount->amount, 2, '.', '') }}</td>
              <td>{{ $discount->type }}</td>
              <td>{{ $discount->modification }}</td>
              <td>{{ $discount->note }}</td>
          </tr>
          @endforeach
        </table>
        @endif
      </div>
    </div>

    <div style="display: inline-block; width: 39.3%;">
      <h4>Total</h4>
      <div style="width: 100%; display: inline-block;">
        <table style="width: 100%;">
          <!--tr class="frisco-data3">
            <td style="width: 50%; border-left: transparent; border-right: transparent;">Materials Price:</td>
            <td style="width: 50%; font-weight: bold; border-left: transparent; border-right: transparent;">P{{number_format($quotation->materials_price, 2)}}</td>
          </tr-->

          <tr class="frisco-data3">
            <td style="width: 50%; border-left: transparent; border-right: transparent;">Quotation Price:</td>
            <td style="width: 50%; font-weight: bold; border-left: transparent; border-right: transparent;">P{{number_format($quotation->price, 2)}}</td>
          </tr>
          <tr class="frisco-data3">
            <td style="width: 50%; border-left: transparent; border-right: transparent;">Add VAT(12%)</td>
            <td style="width: 50%; font-weight: bold; border-left: transparent; border-right: transparent;">P{{number_format($quotation->materials_tax, 2)}}</td>
          </tr>
          <tr class="frisco-data3">
            <td style="width: 50%; border-left: transparent; border-right: transparent;">Total Amount:</td>
            <td style="width: 50%; font-weight: bold; border-left: transparent; border-right: transparent;">P{{number_format($quotation->price + $quotation->materials_tax, 2)}}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
    <!-- <div class="col-md-8 column">
      
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
        
        </tbody>
      </table>
      <p><small>* per piece discount subtracted before tax</small></p>
    
    </div> -->

    <!-- SUMMARY RIGHT SIDE  -->

   <!--  <h4>Total</h4>
    <table class="table">
      <tbody>
        <tr>
          <td>Materials Price:</td>
          <td><strong>P</strong></td>
        </tr>
        <tr>
          <td>Quotation Price:</td>
          <td><strong>P</strong></td>
        </tr>
        <tr>
          <td>Tax:</td>
          <td><strong>P</strong></td>
        </tr>
        <tr>
          <td>Total amount:</td>
          <td><strong>P</strong></td>
        </tr>
        @if($quotation->discount)
        <tr>
          <td>Lot price discounts:</td>
          <td><strong>P</strong></td>
        </tr>
        @endif
      </tbody>
      <tbody>
        <tr>
          <td><strong>Net amount</strong></td>
          <td><strong>P</strong></td>
        </tr>
      </tbody>

    </table>

    </div> -->




</body>
</html>
