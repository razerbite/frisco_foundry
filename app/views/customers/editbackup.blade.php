@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>Edit Customer<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
    <ul id="controls">
      <li><a href="#"><img class="icon" src="{{ asset('/images/icon_edit.png/') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png') }}" ></li>
      <li><a href="#"><img class="icon" src="{{ asset('/images/icon_trash.png') }}"></a></li>
    </ul>
  </hgroup>

  <div class="brokenline"></div>

  @include('partials.alert-messages')

  @if($errors->all())
    <div class="alert alert-danger bs-alert-old-docs">
      <ul class="errors" style="text-align: center;">
        @foreach($errors->all() as $message)
          <li><font color="red">{{ $message }}</font></li>
        @endforeach
      </ul>
    </div>
  @endif

{{ Form::model($customer, ['files'=>'true']) }}
 @include('customers.form')

<section class="information"><!--This is Client Info-->
  <hgroup>
    <h2>Representatives</h2>
  </hgroup>
  @if(!$customer->representatives->isEmpty())
    <table class="table-B"><!--This is table-->
      <th>First Name</th>
      <th>Middle Name</th>
      <th>Last Name</th>
      <th>Company Position</th>
      <th>Contact Details</th>
      <th>Email</th>
      <th>Action</th>
      <?php $ctr = 0; ?>
      @foreach ($customer->representatives as $representative)
      <tr>
        <!-- <td>{{ $representative->full_name }} </td>
        <td>{{ $representative->company_position }}</td> -->
        <input type="hidden" name="array[{{ $ctr }}][id]" value="{{ $representative->id }}">
        <td><input type="text" name="array[{{ $ctr }}][first_name]" id="full_name" value=" {{$representative->first_name}}"></td>
        <td><input type="text" name="array[{{ $ctr }}][middle_initial]" id="full_name" value=" {{$representative->middle_initial}}"></td>
        <td><input type="text" name="array[{{ $ctr }}][last_name]" id="full_name" value=" {{$representative->last_name}}"></td>
        <td><input type="text" name="array[{{ $ctr }}][company_position]" id="company_position" value=" {{$representative->company_position}}"></td>
        <td>
          <ul class="mini">
          @foreach ($representative->contactInfo->contactNumbers as $number)
            <li><b>{{ $number->type_value }}</b></li>
          @endforeach
          </ul>
          <ul class="mini">
          @foreach ($representative->contactInfo->contactNumbers as $number)
            <!-- <li>{{ $number->number }}</li> -->
            <li style="width:200px;"><input type="text" name="array[{{ $ctr }}][number]" id="number" value=" {{$number->number}}" style="width:200px;"></li>
          @endforeach
          </ul>
        </td>
        <!-- <td>{{ $representative->contactInfo->email }}</td> -->
        <td style="width:200px;"><input type="text" name="array[{{ $ctr }}][email]" id="email" value=" {{$representative->contactInfo->email}}" style="width:200px;"></td>
        <td style="display:none;"><input type="text" name="array[{{ $ctr }}][email]" id="email" value=" {{$representative->email}}" style="width:200px;"></td>
        <td style="text-align:center;">
          <a href="{{ route('representative.delete', [$representative->id]) }}" class="delete-modal"><img src="{{ asset('images/doc_delete.png') }}" title="Delete"></a>
        </td>
      </tr>
      <?php $ctr++ ?>
      @endforeach
    </table>
  @else
    <div class="alert alert-danger">
      No representatives found
    </div>
  @endif
</section>

<section class="information">
  <button type="button" class="button02" onClick="window.location.href='{{ route('customers.create.representative', $customer->id) }}';">Add Representative</button>
</section>

<div class="clear"></div>
<div class="brokenline"></div>
<!--buttons-->
<section id="buttons">
  <input type="submit" class="form_button02" value="Save &amp; Finish">
  <button type="button" class="form_button" onClick="window.history.back()">Cancel</button>
</section>
<div class="clear"><!--clear for buttons--></div>

{{ Form::close() }}



@stop
