<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Frisco Foundry')</title>
    {{ HTML::style( asset('css/login/style.css') ) }}
    {{ HTML::style( asset('plugins/tb/css/bootstrap.min.css')) }}
    {{ HTML::script( asset('plugins/tb/jquery.min.js')) }}
    {{ HTML::script( asset('plugins/tb/js/bootstrap.min.js')) }}
  </head>

  <body>
    <!--[if lt IE 7]> <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p> <![endif]-->

    <section id="top">
      <div class="logo"><img src="{{ asset('images/FF-logo.png') }}"></div>
      @if (Auth::check())
        @include('partials.user-panel')
      @endif
    </section>

    <section id="wrapper">
      <section id="signincontent">
        @yield('content')
      </section>
    </section>

    <footer>
        <section class="copyright">
          <p>Copyright &copy;2012-2014, Frisco Foundry, Inc</p>
          <ul>
            <li>Powered by:</li>
            <li><a href="#">Razerbite Solutions</a></li>
          </ul>
          <div class="clear"></div>
        </section>
    </footer>

  </body>
</html>
