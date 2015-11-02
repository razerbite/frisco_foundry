<!DOCTYPE html>
<html class="no-js">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Frisco Foundry @yield('title')</title>
    {{ HTML::style( asset('css/style.css') ) }}
    {{ HTML::style( asset('plugins/tb/css/bootstrap.min.css')) }}
    {{ HTML::script( asset('plugins/tb/jquery.min.js')) }}
    {{ HTML::script( asset('plugins/tb/js/bootstrap.min.js')) }}
    {{ HTML::script( asset('plugins/webshim/polyfiller.js')) }}
    {{ HTML::script( asset('js/bootbox.min.js')) }}
    {{ HTML::style('assets/css/jquery.dataTables.css') }}

    {{ HTML::script('assets/js/vendor/jquery.dataTables.js') }}

    <script>
      $(function() {
        webshim.polyfill('forms forms-ext');

        $('.submit-form').click(function(e) {
          e.preventDefault();
          document.forms[0].submit();
        });

        // set as global function
        deleteModal = function() {
          $('a.delete-modal').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var message = "Are you sure you want to delete this item?";

            if ($this.data('message'))
              message = $this.data('message');

            bootbox.confirm({
                message: message,
                size: 'medium',
                callback: function(result) {
                  if (result) {
                    window.location.href = $this.attr('href');
                  }
                }
            });
          });
        };

        deleteModal();
      });
    </script>

  </head>

  <body>
    <!--[if lt IE 7]> <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p> <![endif]-->

    <section id="wrapper">
      @yield('menu')
      <section id="content">

        <section id="top">
          <div class="logo"><img src="{{ asset('images/FF-logo.png') }}"></div>
          @include('partials.user-panel')
        </section>

        <section id="content-area" class="clearfix">

          @yield('content')

        </section> <!-- End of content area -->
      </section> <!-- End of content -->
    </section> <!-- End of wrapper -->

  </body>
</html>
