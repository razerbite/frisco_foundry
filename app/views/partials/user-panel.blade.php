<div class="rightside">
  <ul class="user">
    <li class="notify"><img src="{{ asset('images/icon-notification.png') }}"></li>
    <li class="account">Welcome back <span>{{ Auth::user()->first_name }}</span>!
      <ul class="sub">
        <li>{{ link_to_route('profile', 'Profile') }}</a></li>
        <li>{{ link_to_route('logout', 'Logout') }}</li>
      </ul>
    </li>
  </ul>
<div class="clear"></div>
</div>
