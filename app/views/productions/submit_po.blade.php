@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

<hgroup class="header">
  <h3>Job Orders<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
</hgroup>

<div class="brokenline"></div>

<div class="clear"></div>

<section class="information"><!--This is details-->
    <table class="table-B" id="search_submit_po">
      <thead>
        <tr>
          <th>J.O Number</th>
          <th>P.O Number</th>
          <th>Direct Award Number</th>
          <th>Company Name</th>
          <th>Date Created</th>
          <th>Date Needed</th>
          <th>Status</th>
        </tr>
      </thead>

      <tr>
        <td class="jo-column">Sample</td> 
        <td>Sample</td>
        <td>Sample</td>
        <td>Sample</td>
        <td>Sample</td>
        <td>Sample</td>
        <td>Sample</td>   
      </tr>
    </table>
</section>

<div class="clear"><!--clear--></div>

<!--buttons-->
<section id="buttons">
  <button class="form_button" onClick="window.location.href='#';">Submit for QA</button>
</section>  

<div class="clear"><!--clear for buttons--></div>

{{ HTML::style( asset('css/jquery.dataTables.min.css')) }}
{{ HTML::script( asset('js/vendor/jquery.dataTables.min.js')) }}
 @include('plugins.select2')

<script>
$(function() {
    $('#search_submit_po').dataTable({
    });
  });
</script>

@stop
