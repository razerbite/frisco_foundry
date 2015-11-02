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
  <h3>Add New Job Order: Direct Award<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
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

  {{ Form::open(array('url'=>'production/da/store','method' => 'POST')) }}
    {{ Form::hidden('quotation_id', '4') }}
    
    <!--GET QUOTATION NO/ID to link on sales scope module or enter QUOTATION CODE-->

    <!-- <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('jo_number','Job Order Number') }}</li>
        <li class="custom-input">{{ Form::text('jo_number', Input::old('jo_number')) }}</li>
      </ul>
    </div> -->

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_created','Date Created') }}</li>
        <li class="custom-input">{{ Form::input('date','date_created', Input::old('date_created')) }}</li>
      </ul>
    </div>

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_needed','Date Needed') }}</li>
        <li class="custom-input">{{ Form::input('date','date_needed', Input::old('date_needed')) }}</li>
      </ul>
    </div>

    <!-- <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('po_number','Purchase Order Number') }}</li>
        <li class="custom-input" >{{ Form::text('po_number', Input::old('po_number')) }}</li>
      </ul>
    </div> -->

    <!-- <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_modified','Date Modified') }}</li>
        <li class="custom-input">{{ Form::input('date','date_modified', Input::old('date_modified')) }}</li>
      </ul>
    </div> -->

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('company_name','Company Name') }}</li>
        <li class="custom-input">{{ Form::text('company_name', Input::old('company_name')) }}</li>
      </ul>
    </div>      

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('revision_number','Revision Number') }}</li>
        <li class="custom-input">{{ Form::text('revision_number', Input::old('revision_number')) }}</li>
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
    {{ Form::select('type_of_work', ['Please Select', 'Fabrication', 'Repair', 'Supply', 'Fabrication & Repair', 'Supply & Repair', 'Fabrication, Repair, & Supply']) }}
    </div>

    <table class="table-B" id="myTablescope"><!--This is table-->
      <th class="letter-details" style="width: 60px;">Item Letter</th>
      <th class="scope-details">Scope Details</th>

      <!--Insert foreach here-->
      <tr>
        <td>{{ Form::text('item_letter', Input::old('item_letter')) }}</td>
        <td>{{ Form::textarea('scope_da',null,['class'=>'form-control', 'rows' => 1, 'cols' => 40]) }}</td>
      </tr>
    </table>

    <!-- <div class="clear"></div>
        <button onClick="javascript:addmore_detailsscope(); return false;" class="add_more">Add More Details</button>
    <div class="clear"></div>  -->  
  
  <br>
  <br>
  
  <p><b style="color:#919191; font-family: opensans-regular-webfont !important">Bill of Materials (BM)</b></p> 
  <div class="bill-mat">
  {{ Form::label('measurements_from','Measurements from:') }}
  {{ Form::select('measurements_from', ['Please Select', 'Choice 1', 'Choice 2', 'Choice 3']) }} 
  </div>

  <table class="table-B" id="myTablebom"><!--This is table-->
      <th>Item Letter</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>
      <th>Action</th>

      <!--Insert foreach here-->
      <tr>
        <td>{{ Form::text('item_letter', Input::old('item_letter')) }}</td>
        <td>{{ Form::text('quantity', Input::old('quantity')) }}</td>
        <td>{{ Form::text('uom', Input::old('uom')) }}</td>
        <td>{{ Form::text('description', Input::old('description')) }}</td>
        <td>{{ Form::text('size', Input::old('size')) }}</td>
        <td>{{ Form::select('actions', ['Please Select', 'Approve', 'Edit']) }}</td>
      </tr>
    </table>

  
  
  <!-- <div class="clear"></div>
    <button class="add_more" onClick="javascript:addmore_detailsbom(); return false;">Add More Materials</button>
  <div class="clear"></div> -->

  <div class="jo_btn">{{ Form::submit('Save & Continue') }}</div>

    {{ Form::close() }}

    <div class="jo_btn2"><button class="jo_btn23" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button></div>

<script type="text/javascript">

  function addmore_detailsscope()
  {
   $('#myTablescope').append('<tr><td><input type="text" name="item_letter" id="item_letter"></td><td><textarea style="width:100%;" name="scope_da" id="scope_da"></textarea></td></tr>');
  }

  function addmore_detailsbom()
  {
    $('#myTablebom').append('<tr><td><input type="text" name="item_letter" id="item_letter"></td><td><input type="text" name="quantity" id="quantity"></td><td><input type="text" name="uom" id="uom"></td><td><input type="text" name="description" id="description"></td><td><input type="text" name="size" id="size"></td><td><select name="actions" id="actions"><option>Please Select</option><option>Approve</option><option>Edit</option></select></td></tr>');
  }
  
</script>
@stop
