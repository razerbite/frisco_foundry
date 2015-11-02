@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')
  <hgroup class="header">
    <h3>Edit role permissions<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  </hgroup>

  <div class="brokenline"></div>
  @include('partials.alert-messages')
  {{ Form::open() }}
  <section class="information"><!--This is Client Info-->

  <table class="table-B table-hover">
    <thead>
      <th style="width: 25%;">Permissions</th>
      @foreach ($roles as $role)
        <th style="text-align: center; width: {{75/$roles->count()}}%;">{{ $role->name }}</th>
      @endforeach
    </thead>
    <tbody>
      @foreach ($permissions as $permission)
        <tr>
          <td style="font-size: 1.1em">{{ $permission->display_name }}</td>
          @foreach ($roles as $index => $role)
            <td style="text-align: center;">
            {{ Form::checkbox("permissions[$role->name][{$permission->id}]", $permission->id, $role->can($permission)) }}
            </td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
  </table>

  </section>

  <!--buttons-->
  <section id="buttons">
    <input type="submit" value="Save" class="form_button02">
    <button type="button" class="form_button" onClick="window.location.href='{{ route('users.index') }}';">Cancel</button>
  </section>
  <div class="clear"><!--clear for buttons--></div>
  {{ Form::close() }}

@stop
