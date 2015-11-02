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

  <section class="information02"><!--This is Client Info-->
    <hgroup>
      <h2>Account Details</h2>
    </hgroup>

    <div id="form_info"><!--form start-->
        <ul class="data-entry02">
          <li><label>Username</label></li>
          <li>{{ Form::text('username') }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>E-mail</label></li>
          <li>{{ Form::email('email', null, ['required']) }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Password</label></li>
          <li>{{ Form::password('password') }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Re-type Password</label></li>
          <li>{{ Form::password('password_confirmation') }}</li>
        </ul>

        <ul class="data-entry02">
          <li><label>Account Type</label></li>
          <li>
              {{ Form::select('role', [''=>'Please Select']+$rolesList, null, ['style'=>'width: 120px;', 'required']) }}
          </li>
        </ul>

        <ul class="data-entry02">
          <li><label>Status</label></li>
          <li>
            <label>{{ Form::radio('status', 1 ) }} Active</label> &nbsp;&nbsp;&nbsp;
            <label>{{ Form::radio('status', 0 ) }} Inactive</label>
          </li>
        </ul>
    </div>
  </section>

  <div class="filler"></div>

  <section class="information02"><!--This is Client Info-->
    <hgroup>
      <h2>User Information</h2>
    </hgroup>

    <div id="form_info"><!--form start-->

<!--         <ul class="data-entry02">
          <li><label>User ID</label></li>
          <li><input type="text" name="description" value="FFM-001"></li>
        </ul>
 -->
        <ul class="data-entry02">
          <li><label>Name</label></li>
          <li style="vertical-align: top;">
            {{ Form::text('first_name', null, ['placeholder'=>'First Name', 'style'=>'margin-bottom: 10px;']) }} <br>
            {{ Form::text('middle_initial', null, ['placeholder'=>'Middle Initial', 'style'=>'margin-bottom: 10px;']) }} <br>
            {{ Form::text('last_name', null, ['placeholder'=>'Last Name']) }}
          </li>
        </ul>

        <ul class="data-entry02">
          <li><label>Company Position</label></li>
          <li>
            {{ Form::text('company_position') }}
          </li>
        </ul>

    </div>

  </section>


  <div class="clear"></div>

  <div class="clearfix">

  <section class="information02"><!--This is Client Info-->
    <hgroup>
      <h2>Contact Information</h2>
    </hgroup>
    <div id="form_info">
        <ul class="data-entry02">
          <li style="vertical-align: top; padding-top: 3px;"><label>Address</label></li>
          <li style="vertical-align: top;">
            {{ Form::text('contactInfo[address_1]', null, ['style'=>'margin-bottom: 10px;', 'required']) }}<br>
            {{ Form::text('contactInfo[address_2]', null, ['style'=>'margin-bottom: 10px;']) }}<br>
            {{ Form::text('contactInfo[zip]', null, ['placeholder'=>'Zipcode', 'style'=>'width: 67px;']) }}
          </li>
        </ul>



        @if(isset($user))
          <ul class="data-entry02 contact-number">
          @foreach ($user->contactInfo->contactNumbers as $i => $number)
            <div class="contact-row" style="margin-bottom: 5px;">
            <li><label>@if($i==0)Contact Details @endif</label></li>
            <li>{{ Form::text("contactInfo[number][{$i}]", $number->number, ['style'=>'width: 130px;', 'required']) }}</li>
            <li>
              {{ Form::select("contactInfo[number_type][{$i}]", [''=>'Please Select']+$contactNumberTypeList, $number->type, ['style'=>'width: 120px;', 'required']) }}
            </li>
            <li>
              <ul id="controls" style="float: left; margin: 0;">
                <li>
                  <a href="#" class="delete-contact"><img class="icon" style="width: 20px; height: 40px" src="{{ asset('images/icon_trash.png') }}"></a>
                </li>
              </ul>
            </li>
            </div>
          @endforeach
          </ul>
          <ul class="data-entry02">
            <li></li>
            <li class="add-button" data-count="{{ $user->contactInfo->contactNumbers->count() }}"><button type="button" class="button02">&nbsp; Add more</button></li>
          </ul>

        @else
          {{ ''; $count = Input::old('contactInfo.number') ? count(Input::old('contactInfo.number')) : 1; }}
          @for ($i = 0; $i < $count; $i++)
          <ul class="data-entry02 contact-number">
            <div class="contact-row" style="margin-bottom: 5px;">
            <li>@if($i==0)<label>Contact Details</label>@endif</li>
            <li>{{ Form::text("contactInfo[number][{$i}]", Input::old('contactInfo.number.'.$i), ['style'=>'width: 130px;', 'required', 'class'=>'number']) }}</li>
            <li>
              {{ Form::select("contactInfo[number_type][{$i}]", [''=>'Please Select']+$contactNumberTypeList, Input::old('contactInfo.number_type.'.$i), ['style'=>'width: 120px;', 'required', 'class'=>'type']) }}
            </li>
            <li>
              <ul id="controls" style="float: left; margin: 0;">
                <li>
                  <a href="#" class="delete-contact"><img class="icon" style="width: 20px; height: 40px" src="{{ asset('images/icon_trash.png') }}"></a>
                </li>
              </ul>
            </li>
            </div>
          </ul>
          @if($i==0)
            <ul class="data-entry02">
              <li></li>
              <li class="add-button" data-count="{{ $count }}"><button type="button" class="button02">&nbsp; Add more</button></li>
            </ul>
          @endif
          @endfor
        @endif

    </div>
    <div class="clear"></div>
  </section>
  <div class="filler"></div>
  <section class="information02"><!--This is Client Info-->
    <hgroup>
      <h2>Add Photo</h2>
    </hgroup>

    <div id="form_info" method="post" >
        <ul class="data-entry02">
          <li><label>Upload Photo</label></li>
          <li style="vertical-align: top;">
            {{ Form::file('photo') }}
            @if (isset($user))
            <div>
              <img class="photoID" src="{{ $user->photo->url('medium') }}">
            </div>
            @endif
          </li>
        </ul>
    </div>

  </section>

  </div>

  <style type="text/css">
  #form_info img, #form_info02 img {
    width: auto;
    height: auto;
  }
  </style>

  <script type="text/javascript">
    $(function() {
      var count = $('.add-button').data('count') - 1;
      console.log(count);
      $('.add-button button').click(function(e) {
        e.preventDefault();

        var $contactNumbers = $('ul.contact-number');
        var $contactRow = $contactNumbers.find('.contact-row').first().clone();

        $contactRow.find('input[type=text]').attr('name', 'contactInfo[number]['+(++count)+']');
        $contactRow.find('select').attr('name', 'contactInfo[number_type]['+(count)+']');
        $contactRow.find('label').text('');
        $contactRow.find('button').remove();
        $contactRow.find('input').val('');

        $contactRow.appendTo($contactNumbers);

        $('.delete-contact').click(function(e) {
          e.preventDefault();
          $(this).parents('.contact-row').remove();
        });
      });

      $('.delete-contact').click(function(e) {
        e.preventDefault();
        $(this).parents('.contact-row').remove();
      });

    });
  </script>
