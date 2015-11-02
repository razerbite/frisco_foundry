<section class="information02"><!--This is Client Info-->
	<hgroup>
		<h2>Customer Representative</h2>
	</hgroup>

	<div id="form_info"><!--form start-->
			<ul class="data-entry02">
				<li style="vertical-align: top; padding-top: 3px;"><label>Representative</label></li>
				<li style="vertical-align: top;">
					{{ Form::text('first_name', null, ['placeholder'=>'First Name', 'style'=>'margin-bottom: 10px;']) }} <br>
					{{ Form::text('middle_initial', null, ['placeholder'=>'Middle Initial', 'style'=>'margin-bottom: 10px;']) }} <br>
					{{ Form::text('last_name', null, ['placeholder'=>'Last Name']) }}
				</li>
			</ul>

			<ul class="data-entry02">
				<li><label>Position</label></li>
				<li>
					{{ Form::text('company_position') }}
				</li>
			</ul>
	</div>
</section>

<section class="information02"><!--This is Client Info-->
	<hgroup>
		<h2>Contact Information</h2>
	</hgroup>

	<div id="form_info"><!--form start-->
		<ul class="data-entry02">
			<li><label>E-mail</label></li>
			<li>{{ Form::text('contactInfo[email]', null, ['required']) }}</li>
		</ul>

        @if(isset($representative))
          <ul class="data-entry02 contact-number">
          @foreach ($representative->contactInfo->contactNumbers as $i => $number)
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
            <li class="add-button" data-count="{{ $representative->contactInfo->contactNumbers->count() }}"><button type="button" class="button02">&nbsp; Add more</button></li>
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
</section>

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
