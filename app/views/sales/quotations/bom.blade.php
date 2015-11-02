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
    <h2>Step 2: Bill of Materials</h2>
  </hgroup>


  <div class="clear"></div>

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

  <table class="table-B" id="scope-table"><!--This is table-->
    <thead>
    <tr>
      <th style="width: 60px;">Item Letter</th>
      <th>Scope Details</th>
      <th style="width: 60px;">Action</th>
    </tr>
    </thead>

    <tbody>
    @foreach ($quotation->scopes as $index => $scope)
      <tr>
        <td class="scope-index" style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
        <td class="scope-details">{{ Form::textarea("scopes[$index][scope]", $scope->scope, ['class'=>'text-area']) }}</td>
        <td style="text-align: center;">
          <a class="scope-delete delete-modal" href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}">
            <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
          </a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>

  <div class="clear"></div>
  <button type="button" class="button02 add-scope" data-link="{{ route('quotations.scope.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
  <div class="clear"></div>

  <div class="brokenline02"></div>

  <p><b>Bill of Materials (BM)</b></p>

  <style>
    td input[type=text],
    td input[type=number] {
      width: 100% !important;
    }
    input[type=number] {
      text-align: center;
    }
    .text-area {
      width: 100%;
      padding: 5px;
    }
  </style>

    <table class="table-B" id="materials-table">
      <thead>
      <tr>
        <th style="width: 40px;">Item Letter</th>
        <th style="width: 50px;">Quantity</th>
        <th style="width: 100px;">UoM</th>
        <th>Description</th>
        <th style="width: 150px;">Size</th>
        <th>Upload File</th>
        <th>Action</th>
      </tr>
      </thead>

      <tbody>
      @foreach ($quotation->materials as $index => $material)
        <tr>
          <td class="material-index" style="text-align: center;">{{ Str::numToAlpha($index) }}</td>
          <td>{{ Form::input('number', "materials[$index][quantity]", $material->quantity, ['class'=>'quantity']) }}</td>
          <td>{{ Form::text("materials[$index][unit_of_measure]", $material->unit_of_measure, ['class'=>'unit_of_measure']) }}</td>
          <td>{{ Form::text("materials[$index][description]", $material->description, ['class'=>'description']) }}</td>
          <td>{{ Form::text("materials[$index][size]", $material->size, ['class'=>'size']) }}</td>
          <td class="file-upload-cell">
          @if (isset($material->file_file_name))
            <div class="file-name">
              <a href="{{ $material->file->url() }}">{{ $material->file_file_name }}</a>
              {{-- <a href="#" class="change" style="float: right">X</a> --}}
            </div>
          @endif
            <div class="file-upload">
              {{ Form::file("materials[$index][file]", ['class'=>'file']) }}
            </div>
          </td>
        <td style="text-align: center;">
          <a class="material-delete delete-modal" href="{{ route('material.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$material->id]) }}">
            <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
          </a>
        </td>
        </tr>
      @endforeach
      </tbody>
    </table>

  <div class="clear"></div>
  <button type="button" class="button02 add-material" data-link="{{ route('quotations.material.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>

  <div class="clear"></div>
</section>

<div class="clear"></div>

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
<section class="information">
  <div id="form_info" method="post" ><!--form start-->
      <ul class="data-entry02">
        <li><label>Notes <b>(Optional)</b></label></li>
        <li> {{ Form::textarea('notes', '') }} </li>
      </ul>
  </div>
  <div class="clear"></div>
  @include('sales.quotations.notes')
</section>

<div class="clear"></div>

<section id="buttons">
  <button type="submit" class="form_button02">Save</button>
  @if(Entrust::can('view_approval'))
    <button type="button" class="form_button02" onClick="window.location.href='{{ route('quotations.approval', ['rfq'=>Str::slug($quotation->rfq_id)]) }}';">Continue</button>
  @endif
  <button type="button" class="form_button" onClick="window.location.href='{{ route('sales.index') }}';">Cancel</button>
</section>
{{ Form::close() }}
<div class="clear"><!--clear for buttons--></div>

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
