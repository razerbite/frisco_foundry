@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

@if($errors->all())
    <div class="alert alert-danger bs-alert-old-docs">
      <ul class="errors" style="text-align: center;">
        @foreach($errors->all() as $message)
          <li><font color="red">{{ $message }}</font></li>
        @endforeach
      </ul>
    </div>
@endif

<ul class="process">
  <li class="active">Job Order</li>
  <li>Working Drawing</li>
</ul>

<div class="clear"></div>

<hgroup class="header">
  <h3>Edit Job Order<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <!-- <ul id="controls">
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_save.png/') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png/') }}"></li>
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_cancel.png/') }}"></a></li>
  </ul> -->
</hgroup>

<div class="brokenline"></div>

<section class="information"><!--This is details-->
  <hgroup>
    <h2>Job Order Details</h2>
  </hgroup>

{{ Form::open(array('url'=>'job_order/update','method' => 'PUT')) }}

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_created','Date Created') }}</li>
        <li class="custom-input"><input type="date" name="date_created" id="date_created" value="{{ $job_order->date_created }}"></li>
      </ul>
    </div>

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_needed','Date Needed') }}</li>
        <li class="custom-input"><input type="date" name="date_needed" id="date_needed" value="{{ $job_order->date_needed }}"></li>
      </ul>
    </div>

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('company_name','Company Name') }}</li>
        <li class="custom-input"><input type="text" name="company_name" id="company_name" value="{{ $job_order->company_name }}"></li>
      </ul>
    </div>      

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('revision_number','Revision Number') }}</li>
        <li class="custom-input"><input type="text" name="revision_number" id="revision_number" value="{{ $job_order->revision_number }}"></li>
      </ul>
    </div>
</section>

    <div class="clear"></div>

    <div class="brokenline02"></div>

    <hgroup class="sow_header">
      <h2 style="color: #AFAC6D;font: bold 18px opensans-regular-webfont;float: left;padding: 2.5px 0px;">Scope of Work</h2>
      <a href="#" class="add_sow">Add Another Scope of Work</a>
      <div class="clear"></div>
    </hgroup>

    <ul class="tab">
      <li class="active"><a href="#">SCOPE: Main</a></li>
      <li>--</li>
      <li>--</li>
    </ul>

    <br>
    <div class="DA-scope">
    {{ Form::label('type_of_work','Work Type') }}

    <select name="type_of_work" id="type_of_work">
       @if ($job_order->type_of_work === '1')
        <option value="Fabrication">Fabrication</option>
        @elseif ($job_order->type_of_work === '2')
        <option value="Repair">Repair</option>
        @elseif ($job_order->type_of_work === '3')
        <option value="Supply">Supply</option>
        @elseif ($job_order->type_of_work === '4')
        <option value="Fabrication & Repair">Fabrication & Repair</option>
        @elseif ($job_order->type_of_work === '5')
        <option value="Supply & Repair">Supply & Repair</option>
        @elseif ($job_order->type_of_work === '6')
        <option value="Fabrication, Repair, & Supply">Fabrication, Repair, & Supply</option>
       @else
        <option value="Please Select">Please Select</option>
     @endif
      <option value="1">Fabrication</option>
      <option value="2">Repair</option>
      <option value="3">Supply</option>
      <option value="4">Fabrication & Repair</option>
      <option value="5">Supply & Repair</option>
      <option value="6">Fabrication, Repair, & Supply</option>
    </select>

    </div>
    <table class="table-B"><!--This is table-->
      <th class="letter-details" style="width: 60px;">Item Letter</th>
      <th class="scope-details">Scope Details</th>

      <!--Insert foreach here-->
      <tr>
        <td><input type="text" name="item_letter_scope" id="item_letter_scope" value="A"></td>
        <td><textarea name="scope_da" id="scope_da" style="width:100%!important">{{ $scope_job_order->scope }}</textarea></td>
      </tr>
    </table>

    <div class="clear"></div>
        <button onClick="window.location.href='#';" class="add_more">Add More Details</button>
    <div class="clear"></div>   
  
  <br>
  <br>

  <p><b style="color:#919191; font-family: opensans-regular-webfont !important">Bill of Materials (BM)</b></p> 
  <div class="bill-mat">
  {{ Form::label('measurements_from','Measurements from:') }}
  <select name="measurements_from" id="measurements_from">
       @if ($job_order->type_of_work === '1')
        <option value="Choice 1">Choice 1</option>
        @elseif ($job_order->type_of_work === '2')
        <option value="Choice 2">Choice 2</option>
        @elseif ($job_order->type_of_work === '3')
        <option value="Choice 3">Choice 3</option>
       @else
        <option value="Please Select">Please Select</option>
     @endif
      <option value="1">Choice 1</option>
      <option value="2">Choice 2</option>
      <option value="3">Choice 3</option>
    </select>
  </div>

  <table class="table-B"><!--This is table-->
      <th>Item Letter</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>
      <th>Action</th>

      <!--Insert foreach here-->
      <tr>
        <td><input type="text" name="item_letter" id="item_letter" value="A"></td>
        <td><input type="text" name="quantity" id="quantity" value="{{ $bom_job_order->quantity }}"></td>
        <td><input type="text" name="unit_of_measure" id="unit_of_measure" value="{{ $bom_job_order->unit_of_measure }}"></td>
        <td><input type="text" name="description" id="description" value="{{ $bom_job_order->description }}"></td>
        <td><input type="text" name="size" id="size" value="{{ $bom_job_order->size }}"></td>
        <td>
          <select name="actions" id="actions">
            @if ($bom_job_order->actions === '1')
              <option value="Approve">Approve</option>
              @elseif ($bom_job_order->actions === '2')
              <option value="Edit">Edit</option>
             @else
              <option value="Please Select">Please Select</option>
            @endif
            <option value="1">Approve</option>
            <option value="2">Edit</option>
          </select>
        </td>
      </tr>
    </table>

      <div class="clear"></div>
        <button class="add_more" onClick="window.location.href='#';">Add More Materials</button>
      <div class="clear"></div>

      {{ Form::hidden('id', $job_order->id) }}
      {{ Form::hidden('id_scope', $scope_job_order->quotation_id) }}
      {{ Form::hidden('id_bom', $scope_job_order->quotation_id) }}

  <div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('job_order', ['id'=>$job_order->id]) }}';" >Cancel</button></div>

  <div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('production.workingdrawing') }}';" >Continue</button></div>

  <div class="jo_btn">{{ Form::submit('Save') }}</div>

  {{ Form::close() }}

@stop
