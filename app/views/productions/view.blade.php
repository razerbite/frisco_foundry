@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')


<ul class="process">
  <li class="active">Job Order</li>
  <li><a href="quality.html">Working Drawing</a></li>
</ul>

<div class="clear"></div>

<hgroup class="header">
  <h3>View Job Order<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <ul id="controls">
    <li><a href="{{ route('job_order_po', ['id'=>$job_order->id]) }}"><img class="icon" src="../images/icon_edit.png"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="../images/dot.png" ></li>
    <li><a href="{{ route('job_order.delete', ['id'=>$job_order->id]) }}" class="delete-modal" data-message="Are you sure you want to delete this job order?"><img class="icon" src="../images/icon_cancel.png"></a></li>
  </ul>
</hgroup>

<div class="brokenline"></div>

<section class="information"><!--This is details-->
  <hgroup>
    <h2>Job Order Details</h2>
  </hgroup>
  
  <!-- <form id="form_info" method="post" >
    <ul class="data-entry">
      <li><label>Job Order Number</label></li>
      <li>{{ $job_order->jo_number }}</li>
    </ul> 
  </form> -->
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Created</label></li>
      <li>{{ date('Y-m-d', strtotime($job_order->created_at)) }}</li>
    </ul> 
  </form>
  
  <!-- <form id="form_info" method="post" >
    <ul class="data-entry">
      <li><label>Purchase Order Number</label></li>
      <li>{{ $job_order->po_number }}</li>
    </ul> 
  </form> -->
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Modified</label></li>
      <li>Sample Date</li>
    </ul> 
  </form>

  <form id="form_info" method="post" ><!--form start-->
    <ul class="data-entry">
      <li><label>Direct Award Number</label></li>
      <li>DA_000{{ $job_order->id }}</li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Needed</label></li>
      <li>{{ $job_order->date_needed }}</li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Company  Name</label></li>
      <li>{{ $job_order->company_name }}</li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Revision Number</label></li>
      <li>{{ $job_order->revision_number }}</li>
    </ul> 
  </form>
  
  <div class="clear"></div>
  
  <input type="submit" class="orange_button" value="Revise Job Order"/>

<div class="clear"></div>

<div class="brokenline02"></div>

<hgroup class="sow_header">
  <h2>Scope of Work</h2>
  <a href="#" class="add_sow">Add Another Scope of Work</a>
  <div class="clear"></div>
</hgroup>

<ul class="tab">
  <li class="active"><a href="#">SCOPE: Main</a></li>
  <li>--</li>
  <li>--</li>
</ul>

<br>

<form id="form_info" method="post" ><!--form start-->
  <ul class="data-entry02">
    <li><label>Work Type</label></li> 
     @if ($job_order->type_of_work === '1')
        <li>Fabrication</li>
        @elseif ($job_order->type_of_work === '2')
        <li>Repair</li>
        @elseif ($job_order->type_of_work === '3')
        <li>Supply</li>
        @elseif ($job_order->type_of_work === '4')
        <li>Fabrication & Repair</li>
        @elseif ($job_order->type_of_work === '5')
        <li>Supply & Repair</li>
        @elseif ($job_order->type_of_work === '6')
        <li>Fabrication, Repair, & Supply</li>
       @else
        <li>Please Select</li>
     @endif
  </ul>
</form>   
  
<table class="table-B"><!--This is table-->
    <th>Item Letter</th>
    <th>Scope Details</th>

    <tr>    
      <td style="width: 100px;">A</td>
      <td>{{ $scope_job_order->scope }}</td>
    </tr>
</table>

<br>
  
  <p><b>Bill of Materials (BM)</b></p>

  <form id="form_info" method="post" ><!--form start-->
    <ul class="data-entry02">
      <li><label>Measurements from:</label></li>
      <li>
        @if ($job_order->measurements_from === '1')
          <li>Choice 1</li>
          @elseif ($job_order->measurements_from === '2')
          <li>Choice 2</li>
          @elseif ($job_order->measurements_from === '3')
          <li>Choice 3</li>
         @else
          <li>Please Select</li>
       @endif
      </li>
    </ul>
  </form>   
    
    <table class="table-B">
      <th>Item ID</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>
      <th>Actions</th>

      <tr>    
        <td>A</td>
        <td>{{ $bom_job_order->quantity }}</td>
        <td>{{ $bom_job_order->unit_of_measure }}</td>
        <td>{{ $bom_job_order->description }}</td>
        <td>{{ $bom_job_order->size }}</td>
        @if ($bom_job_order->actions === '1')
          <td>Approve</td>
          @elseif ($bom_job_order->actions === '2')
          <td>Edit</td>
         @else
          <td>Please Select</td>
       @endif
      </tr>   
    </table>

<div class="clear"><!--clear--></div>

<section class="information"><!--This is details-->
  <form id="form_info" method="post"><!--form start-->            
    <ul class="data-entry02">
      <li><label>Drawings by</label></li>
      <li>Eng. Drew Magdayo</li>
    </ul>             
  </form>
  
  <form id="form_info" method="post"><!--form start-->            
    
    <ul class="data-entry02">
      <li><label>QC Draftsman</label></li>
      <li>Eng. Victor Garcia</li>
    </ul>             
      
  </form>
</section>

<div class="clear"><!--clear--></div>

<!--buttons-->
<section id="buttons">
  <button class="form_button02" onClick="window.location.href='{{ route('job_order_po', ['id'=>$job_order->id]) }}';">Edit Job Order</button>
  <button class="form_button" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button>
</section>  
<div class="clear"><!--clear for buttons--></div>

{{ Form::close() }}

@stop
