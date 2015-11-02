@if(Session::has('message'))
  <div class="alert alert-{{ Session::get('alert-class', 'info') }}">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ Session::get('message') }}
  </div>
@endif
