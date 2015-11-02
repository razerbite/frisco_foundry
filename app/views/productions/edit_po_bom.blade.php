@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

<ul class="process">
  <li class="active">Job Order</li>
  <li>Working Drawing</li>
</ul>

<div class="clear"></div>

<hgroup class="header">
  <h3>Edit BOM<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <!-- <ul id="controls">
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_save.png/') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png/') }}"></li>
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_cancel.png/') }}"></a></li>
  </ul> -->
</hgroup>

<div class="brokenline"></div>

{{ Form::open(array('url'=>'job_order_po_bom/update','method' => 'PUT')) }}

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
      <td style="display:none;">{{ Form::text("materials[$index][id]", $material->id, ['class'=>'size']) }}</td>

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

  <!-- <div class="clear"></div>
    <button type="button" class="button02 add-material" data-link="{{ route('quotations.material.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
  <div class="clear"></div> -->
  <div class="clear"></div>
    <button type="button" class="button02 add-material" data-link="{{ route('quotations.material.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
  <div class="clear"></div>

<!-- INSERT BOM -->

{{ Form::hidden('id', $quotation->id) }}
{{ Form::hidden('id_customer', $quotation->customer->id) }}

<!-- <div class="jo_btn2"><button class="jo_btn23" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button></div> -->

<div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('job_order_po', ['id'=>$quotation->id]) }}';" >Cancel</button></div>

<div class="jo_btn"><button type="button" class="jo_btn23" onClick="window.location.href='{{ route('job_order_po', ['id'=>$quotation->id]) }}';" >Continue</button></div>

<div class="jo_btn">{{ Form::submit('Save') }}</div>

{{ Form::close() }}

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
