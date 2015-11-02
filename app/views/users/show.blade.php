@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

  <hgroup class="header">
    <h3>View Account User<br><span>Aenean quis velit a neque rutrum commodo</span></h3>

    @if(Entrust::can('manage_users'))
    <ul id="controls">
      <li><a href="{{ route('users.edit', ['id'=>$user->id]) }}"><img class="icon" src="{{ asset('/images/icon_edit.png/') }}"></a></li>
      <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png') }}" ></li>
      <li><a href="{{ route('users.destroy', [$user->id]) }}" class="delete-modal" data-message="Are you sure you want to delete this user?"><img class="icon" src="{{ asset('/images/icon_trash.png') }}"></a></li>
    </ul>
    @elseif($user->id == Auth::user()->id)
    <ul id="controls">
      <li><a href="{{ route('profile.edit') }}"><img class="icon" src="{{ asset('/images/icon_edit.png/') }}"></a></li>
    </ul>
    @endif
  </hgroup>

  <div class="brokenline"></div>

  <ul class="page-title">
    <li><img class="photoID" src="{{ $user->photo->url('thumb') }}"></li>
    <li>
      <h1>{{ $user->full_name }}<br><span>{{ $user->roles[0]->name }}</span></h1>
    </li>
  </ul>

  <section class="deets">
    <ul>
      <li>Date Generated</li>
      <li>User ID</li>
    </ul>
    <ul>
      <li>{{ Carbon::parse($user->created_at)->toFormattedDateString() }}</li>
      <li>{{ $user->id }}</li>
    </ul>
  </section>

  <div class="clear"></div>
  <section class="information">
    @include('partials.alert-messages')
  </section>
  <section class="information02"><!--This is details-->
    <hgroup>
      <h2>Contact Information</h2>
    </hgroup>

    <form id="form_info" method="post" ><!--form start-->
        <ul class="data-entry02">
          <li><label>Address</label></li>
          <li>
            {{ $user->contactInfo->address_1 }}<br>
            {{ $user->contactInfo->address_2 }}<br>
          </li>
        </ul>

        <ul class="data-entry02">
          <li><label>Email Address</label></li>
          <li>{{{ $user->email }}}</li>
        </ul>

        <ul class="data-entry02">
          <li style="vertical-align: top;"><label>Contact Details</label></li>
          <li>
            <ul class="mini">
              @foreach ($user->contactInfo->contactNumbers as $contactNumber)
                <li><b>{{ $contactNumber->type_value }}</b></li>
              @endforeach
            </ul>
            <ul class="mini">
              @foreach ($user->contactInfo->contactNumbers as $contactNumber)
                <li>{{ $contactNumber->number }}</li>
              @endforeach
            </ul>
          </li>
        </ul>
    </form>
  </section>

  <div class="filler"></div>

  <section class="information02"><!--This is details-->
    <hgroup>
      <h2>Account Details</h2>
    </hgroup>
    <form id="form_info" method="post" >

      <ul class="data-entry02">
          <li><label>Account Name</label></li>
          <li>{{{ $user->username }}}</li>
      </ul>

      <ul class="data-entry02">
          <li><label>Status</label></li>
          <li>{{ $user->status_value }}</li>
      </ul>
    </form>
  </section>


  @if(Entrust::can('manage_users'))
  <section class="information">
    <!--buttons-->
    <section id="buttons" class="clearfix">
      <button class="form_button" onClick="window.location.href='{{ route('users.edit', ['id'=>$user->id]) }}';">Edit User Info</button>
      <a href="{{ route('users.destroy', [$user->id]) }}" class="form_button delete-modal" data-message="Are you sure you want to delete this user?">Delete</a>
    </section>
  </section>
  @elseif($user->id == Auth::user()->id)
    <section id="buttons" class="clearfix">
      <button class="form_button" onClick="window.location.href='{{ route('profile.edit') }}';">Edit User Info</button>
    </section>
  @endif

@stop
