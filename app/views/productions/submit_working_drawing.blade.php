@extends('layouts.master')

@section('menu')
  @include('partials.sales-menu')
@stop

@section('content')

<ul class="process">
  <li>Job Order</li>
  <li class="active">Working Drawing</li>
  <li>Planning</li>
</ul>

<div class="clear"></div>

<!-- <ul id="submenu02">
  <li><a style="color: #ff5400; text-decoration: underline;" href="#">Freehand Drawings</a></li>
  <li>I</li>
  <li><a href="#">CAD</a></li>
</ul> -->
<ul id="submenu02">
  <li><a style="color: #ff5400; text-decoration: underline;" href="#">Freehand Drawings</a></li>
  <li>I</li>
  <li><a href="#">CAD</a></li>
</ul>

<div class="clear"></div>

<hgroup class="header">
  <h3>Working Drawing<br><span>Aenean quis velit a neque rutrum commodo</span></h3>
  
  <ul id="controls">
    <li><a href="#"><img class="icon" src="../images/icon_save.png"></a></li>
    <li style="margin: 0; padding: 0; text-align: center;"><img src="../images/dot.png" ></li>
    <li><a href="#"><img class="icon" src="../images/icon_trash.png"></a></li>
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
      <li><input type="text" value="JO_PAT_LUC_MANU_0001"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Date Created</label></li>
      <li><input type="text" value="April 28, 2015"></li>
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
      <li><input type="date" name="description"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Company Name</label></li>
      <li><input type="text"></li>
    </ul> 
  </form>
  
  <form id="form_info" method="post"><!--form start-->
    <ul class="data-entry">
      <li><label>Revision Number</label></li>
      <li><input type="text" Value="Rev-001"></li>
    </ul> 
  </form>

<div class="clear"></div>

<div class="brokenline02"></div>

<ul class="tab">
  <li class="active"><a href="#">SCOPE: Main</a></li>
  <li>--</li>
  <li>--</li>
</ul>

<br>

<p><b>Drawing Details</b></p>
    
    <table class="table-B">
      <th>Item Letter</th>
      <th>Quantity</th>
      <th>UoM</th>
      <th>Description</th>
      <th>Size</th>

      <th>Upload File</th>
      <tr>    
        <td>A</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td><a href="#inline" class="submit">+Upload File</a></td>
      </tr>
      
      <tr>    
        <td>B</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td><a href="#inline" class="submit">+Upload File</a></td>
      </tr>   
      
      <tr>    
        <td>C</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <td>40mm &#8960; x 155mm L</td>
        <td><a href="#inline" class="submit">+Upload File</a></td>
      </tr>   
      
      <tr>    
        <td>D</td>
        <td>10 pcs</td>
        <td>Segment</td>
        <td>TS4140</td>
        <!-- <td><a href="#inline" class="submit">+Upload File</a></td> -->
      </tr>   
    </table>

<div><h1>Working drawings table here</h1></div>
        <td><a href="#inline" class="submit">+Upload File</a></td>
      </tr>   
    </table>
    
<div class="clear"><!--clear--></div>

<section class="information"><!--This is details-->
  <form id="form_info" method="post"><!--form start-->            
  
    <ul class="data-entry02">
      <li><label>Drawings by</label></li>
      <li><input type="text"></li>
    </ul>
                        
                  
  </form>
  
  <form id="form_info" method="post"><!--form start-->            
    
    <ul class="data-entry02">
      <li><label>QC Draftsman</label></li>
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
</section>

<div class="clear"><!--clear--></div>

<!--buttons-->
<section id="buttons">
  <button class="form_button" onClick="window.location.href='../planner/add-plan.html';">Save & Continue</button>
  <button class="form_button" onClick="window.location.href='#';">Delete</button>
</section>  
<div class="clear"><!--clear for buttons--></div>

@stop
