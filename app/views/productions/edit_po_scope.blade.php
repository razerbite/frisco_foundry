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
  <h3>Edit Scope<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <!-- <ul id="controls">
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_save.png/') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png/') }}"></li>
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_cancel.png/') }}"></a></li>
  </ul> -->
</hgroup>

<div class="brokenline"></div>

{{ Form::open(array('url'=>'job_order_po_scope/update','method' => 'PUT')) }}

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

<table class="table-B" id="scope-table"><!--This is table-->
  <thead>
  <tr>
    <th style="width: 60px;">Item Letter</th>
    <th>Scope Details</th>
    <!-- <th style="width: 60px;">Action</th> -->
    <th style="width: 60px;">Action</th>
  </tr>
  </thead>

  <tbody>
  @foreach ($quotation->scopes as $index => $scope)
    <tr>
      <td class="scope-index" style="text-align: left;">{{ Str::numToAlpha($index) }}</td>
      <!-- <td class="scope-details" style="color:black;">{{ $scope->scope }}</td> -->
      <td class="scope-details">{{ Form::textarea("scopes[$index][scope]", $scope->scope, ['class'=>'text-area2']) }}</td>
      <td class="scope-details" style="display:none;">{{ Form::textarea("scopes[$index][id]", $scope->id, ['class'=>'text-area2']) }}</td>

      <!-- <td class="scope-details" style="color:black;"><textarea name="scope" id="scope">{{ $scope->scope }}</textarea></td> -->
      <!-- <td style="text-align: left;">
        <a class="scope-delete delete-modal" href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}">
          <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
        </a>
      </td> -->
      <td style="text-align: left;">
        <a class="scope-delete delete-modal" href="{{ route('scope.delete', ['rfq'=>Str::slug($quotation->rfq_id), 'id'=>$scope->id]) }}">
          <img src="{{ asset('images/doc_delete.png') }}" title="Delete">
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<!-- <div class="clear"></div>
    <button type="button" class="button02 add-scope" data-link="{{ route('quotations.scope.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
<div class="clear"></div> -->   

<div class="clear"></div>
    <button type="button" class="button02 add-scope" data-link="{{ route('quotations.scope.add', ['rfq'=>Str::slug($quotation->rfq_id)]) }}">Add More</button>
<div class="clear"></div>   

<br>
<br>

<!-- INSERT BOM -->

{{ Form::hidden('id', $quotation->id) }}
{{ Form::hidden('id_customer', $quotation->customer->id) }}

<!-- <div class="jo_btn2"><button class="jo_btn23" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button></div>

<div class="jo_btn2"><button class="jo_btn23" onClick="window.location.href='{{ route('production.index') }}';">Cancel</button></div> -->

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
