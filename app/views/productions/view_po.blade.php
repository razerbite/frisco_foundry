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

{{ Form::open(array('url'=>'job_order_po/update','method' => 'PUT')) }}

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_created','Date Created') }}</li>
        <li class="custom-input"><input type="date" name="created_at" id="created_at" value="{{ date('Y-m-d', strtotime($quotation->created_at)) }}"></li>
      </ul>
    </div>

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('date_needed','Date Needed') }}</li>
        <li class="custom-input"><input type="date" name="date_needed" id="date_needed" value="{{ $quotation->date_needed }}"></li>
      </ul>
    </div>

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('company_name','Company Name') }}</li>
        <li class="custom-input"><input type="text" id="company_name" name="company_name" value="{{ $quotation->customer->name }}"></li>
      </ul>
    </div>      

    <div id="form_info" class="custom-form-info">
      <ul>
        <li>{{ Form::label('revision_number','Revision Number') }}</li>
        <li class="custom-input"><input type="text" name="revision_number" id="revision_number" value=""></li>
      </ul>
    </div>
</section>

<div class="clear"></div>

<div class="brokenline02"></div>

<!-- SCOPE -->

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
    @if ($quotation->type_of_work_id === 1)
      <option value="1">Fabrication</option>
      @esleif ($quotation->type_of_work_id === 2)
      <option value="2">Repair</option>
      @elseif ($quotation->type_of_work_id === 3)
      <option value="3">Supply</option>
      @elseif ($quotation->type_of_work_id === 4)
      <option value="4">Fabrication & Repair</option>
      @elseif ($quotation->type_of_work_id === 5)
      <option value="5">Supply & Repair</option>
      @elseif ($quotation->type_of_work_id === 6)
      <option value="6">Fabrication, Repair, & Supply</option>
      @else
      <option value="7">Please </option>
    @endif
    <option value="1">Fabrication</option>
    <option value="2">Repair</option>
    <option value="3">Supply</option>
    <option value="4">Fabrication & Repair</option>
    <option value="5">Supply & Repair</option>
    <option value="6">Fabrication, Repair, & Supply</option>
  </select>
</div>

<a href="{{ route('job_order.edit_scope', ['id'=>$quotation->id]) }}"><img src="{{ asset('images/edit.png') }}" title="Edit" style="float:right; margin-right:10px;"></a>
<br>
<br>

<table class="table-B" id="scope-table"><!--This is table-->
  <thead>
  <tr>
    <th style="width: 60px;">Item Letter</th>
    <th>Scope Details</th>
    <!-- <th style="width: 60px;">Action</th> -->
  </tr>
  </thead>

  <tbody>
  @foreach ($quotation->scopes as $index => $scope)
    <tr>
      <td class="scope-index" style="text-align: left;">{{ Str::numToAlpha($index) }}</td>
      <!-- <td class="scope-details" style="color:black;">{{ $scope->scope }}</td> -->
      <!-- <td class="scope-details">{{ Form::textarea("scopes[$index][scope]", $scope->scope, ['class'=>'text-area2']) }}</td> -->
      <td>{{ $scope->scope}}</td>
      <!-- <td class="scope-details" style="color:black;"><textarea name="scope" id="scope">{{ $scope->scope }}</textarea></td> -->
      <!-- <td style="text-align: left;">
        <a class="scope-delete delete-modal" href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}">
          <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
        </a>
      </td> -->
    </tr>
  @endforeach
  </tbody>
</table>


<!-- <div class="clear"></div>
    <button type="button" class="button02 add-scope" data-link="{{ route('quotations.scope.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
<div class="clear"></div>  -->  


<br>
<br>

<!-- BOM -->

<p><b style="color:#919191; font-family: opensans-regular-webfont !important">Bill of Materials (BM)</b></p> 
  <div class="bill-mat">
  {{ Form::label('measurements_from','Measurements from:') }}
  {{ Form::select('measurements_from', ['Please Select', 'Choice 1', 'Choice 2', 'Choice 3']) }} 
  </div>

<a href="{{ route('job_order.edit_bom', ['id'=>$quotation->id]) }}"><img src="{{ asset('images/edit.png') }}" title="Edit" style="float:right; margin-right:10px;"></a>
<br>
<br>

<table class="table-B" id="materials-table">
  <thead>
  <tr>
    <th style="width: 40px;">Item Letter</th>
    <th style="width: 50px;">Quantity</th>
    <th style="width: 100px;">UoM</th>
    <th>Description</th>
    <th style="width: 150px;">Size</th>
    <!-- <th>Upload File</th> -->
    <!-- <th>Action</th> -->
  </tr>
  </thead>

  <tbody>
  @foreach ($quotation->materials as $index => $material)
    <tr>
      <td class="material-index" style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
      <td>{{$material->quantity}}</td>
      <td>{{$material->unit_of_measure}}</td>
      <td>{{$material->description}}</td>
      <td>{{$material->size}}</td>
     <!--  <td class="file-upload-cell">
      @if (isset($material->file_file_name))
        <div class="file-name">
          <a href="{{ $material->file->url() }}">{{ $material->file_file_name }}</a>
          {{-- <a href="#" class="change" style="float: right">X</a> --}}
        </div>
      @endif
        <div class="file-upload">
          {{ Form::file("materials[$index][file]", ['class'=>'file']) }}
        </div>
      </td> -->
    <!-- <td style="text-align: center;">
      <a class="material-delete delete-modal" href="{{ route('material.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$material->id]) }}">
        <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
      </a>
    </td> -->
    </tr>
  @endforeach
  </tbody>
</table>

<!--   <div class="clear"></div>
    <button type="button" class="button02 add-material" data-link="{{ route('quotations.material.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
  <div class="clear"></div> -->

{{ Form::hidden('id', $quotation->id) }}
{{ Form::hidden('id_customer', $quotation->customer->id) }}

<div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button></div>

<div class="jo_btn">{{ Form::submit('Save') }}</div>

<div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('production.workingdrawing') }}';">Continue</button></div>

{{ Form::close() }}

<div class="jo_btn"></div>

<script type="text/javascript">

$(function(){

  $('.add-scope').click(function(e) {
    e.preventDefault();

    var scope = $('#scope-table').find('tbody tr:last').clone();
    var $url = $(this).data('link');

    $.post($url, function(data) {

      scope.find('.scope-index').text(data.letter);
      scope.find('.scope-details textarea').val('').attr('name', 'scopes['+data.count+'][scope]');
      scope.find('.scope-delete').attr('href', data.deleteLink);
      $('#scope-table').find('tbody').append(scope)

      deleteModal();

    }).fail(function(){
      alert('Failed to create scope');
    });

  });
  $('.add-material').click(function(e) {
    e.preventDefault();

    var material = $('#materials-table').find('tbody tr:last').clone();

    var $url = $(this).data('link');
    $.post($url, function(data) {

      material.find('.material-index').text(data.letter);
      material.find('.file-name').remove();
      material.find('input').each(function(i,el){
        $this = $(this);
        $this.val('');
        var field = $this.attr('class').split(' ')[0];
        $this.attr('name', 'materials['+data.count+']['+field+']');
      });
      material.find('input[type=number]').val('0');
      material.find('.material-delete').attr('href', data.deleteLink);
      $('#materials-table').find('tbody').append(material)

      deleteModal();

    }).fail(function(){
      alert('Failed to create material');
    });

  });

});

</script>

@stop
