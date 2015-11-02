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
  <h3>Add New Job Order<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  <ul id="controls">
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_save.png/') }}"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="{{ asset('/images/dot.png/') }}"></li>
    <li><a href="#"><img class="icon" src="{{ asset('/images/icon_cancel.png/') }}"></a></li>
  </ul>
</hgroup>

<div class="brokenline"></div>

<section class="information"><!--This is details-->
  <hgroup>
    <h2>Job Order Details</h2>
  </hgroup>
  
  <form id="form_info" method="post" ><!--form start-->
    <ul class="data-entry">
      <li><label>Job Order Number</label></li>
      <li><input type="text" placeholder="PAT_LUC_MANU_0001"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Created</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post" ><!--form start-->
    <ul class="data-entry">
      <li><label>Purchase Order Number</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Modified</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Company  Name</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Revision Number</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <div class="clear"></div>
  
  <input type="submit" class="orange_button" value="Revise Job Order"/>

<div class="clear"></div>


<div class="brokenline02"></div>

<hgroup class="sow_header">
  <h2>Scope of Work</h2>
  <a href="#" class="add_sow">Add Another Scope of Work</a>
  <div class="clear"></div>
</hgroup>

<ul class="tab">
  <li class="active"><a href="#">SCOPE: Main</a></li>
  <li>--</li>
  <li>--</li>
</ul>

<br>

<form id="form_info" method="post" ><!--form start-->
  <ul class="data-entry02">
    <li><label>Work Type</label></li>
    <li><select>
        <option>Please Select</option>
        <option>Option 01</option>
        <option>Option 02</option>
      </select>
    </li>
  </ul>
</form>   
  
<table class="table-B"><!--This is table-->
  <th>Item Letter</th>
  <th>Scope Details</th>

  <tr>    
    <td style="width: 100px;">A</td>
    <td>
        1. Pull out from customer to Frisco shop <br>
        2. Surface Grinding on one side to meet the -0.01 tolerance <br>
        3. Delivery
    </td>

  </tr>
</table>

<div class="clear"></div>
  <button class="button02 add-more-details" onClick="window.location.href='#';">Add More Details</button>
<div class="clear"></div>

<br>
  
  <p><b>Bill of Materials (BM)</b></p>

  <form id="form_info" method="post" ><!--form start-->
    <ul class="data-entry02">
      <li><label>Measurements from:</label></li>
      <li>
        <select>
          <option>Please Select</option>
          <option>Choice 1</option>
          <option>Choice 2</option>
          <option>Choice 3</option>
        </select>
      </li>
    </ul>
  </form>   
    
    <table class="table-B">
      <th>Item ID</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>
      <th>Actions</th>
      <tr>    
        <td>A</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>
      
      <tr>    
        <td>B</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>   
      
      <tr>    
        <td>C</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>
      
      <tr>    
        <td>D</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>   
      
      <tr>    
        <td>E</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>
      
      <tr>    
        <td>D</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td>
          <select>
            <option><i>Please Select</i></option>
            <option>Approve</option>
            <option>Edit</option>
          </select>
        </td>
      </tr>   
    </table>
  
    <div class="clear"></div>
      <button class="button02 add-more-details" onClick="window.location.href='#';">Add More Materials</button>
    <div class="clear"></div>

<!--buttons-->
<section id="buttons">
  <button class="form_button02" onClick="window.location.href='drawing.html';">Save & Continue</button>
  <button class="form_button" onClick="window.location.href='#';">Cancel</button>
</section>  
<div class="clear"><!--clear for buttons--></div>

{{ Form::close() }}

@stop
