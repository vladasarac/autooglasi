<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AutoBerza</title>
    <meta name="description" content="company is a free job board template">
    <meta name="author" content="vlada">
    <meta name="keyword" content="html, css, bootstrap, job-board">
    

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontello.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">        
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.transitions.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('responsive.css') }}">
    <script src="{{ asset('js/vendor/modernizr-2.6.2.min.js') }}"></script>
    <script>window.jQuery || document.write('<script src="{{ asset('js/vendor/jquery-1.10.2.min.js') }}"><\/script>')</script>
    {{-- GOOGLE MAP, za sada koristim ovaj sa API KEY-om --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> --}}
    {{-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDakIM1RlW2zEifS6fNwK6oityHdLLqxLc"></script>
  </head>
  <body>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="{{ asset('img/logo.png') }}" alt=""></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <div class="button navbar-right">
            @if (Auth::guest())
            {{-- dodao sam da preko javascript onclick metoda buttoni na klik idu na odredjene rute(za login logout registtraciju itd...) --}}
              <button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s" onclick="window.location.href='{{ url('/login') }}'">
                Login
              </button>
              {{--<button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s">
                <a href="{{ url('/login') }}">Login</a>
              </button> --}}
              <button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s" onclick="window.location.href='{{ url('/register') }}'">
                Registracija
              </button>
              {{-- <button class="navbar-btn nav-button wow fadeInRight" data-wow-delay="0.6s">
                <a href="{{ url('/register') }}">Registracija</a>
              </button> --}}
            @else
              <button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s" onclick="window.location.href='{{ url('/logout') }}'">
                Izloguj Se
              </button>
              {{-- <button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s">
                <a href="{{ url('/logout') }}">Izloguj Se</a>
              </button> --}}
              <button class="navbar-btn nav-button wow bounceInRight login" data-wow-delay="0.8s" onclick="window.location.href='{{ url('/#') }}'">
                Oglasi
              </button>
              {{-- <button class="navbar-btn nav-button wow fadeInRight" data-wow-delay="0.6s">
                <a href="#">Oglasi</a>
              </button> --}}
            @endif
          </div>
          {{--linkovi ako je ulogovani user admin--}}
          @if (Auth::check() && Auth::user()->role == 'admin')
            <ul class="main-nav nav navbar-nav navbar-right">
              <li class="wow fadeInDown" data-wow-delay="0s"><a class="{{ Request::is('/') ? 'active' : '' }}" href="/">Home</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.1s"><a class="{{ Request::is('adminpanel') ? 'active' : '' }}" href="{{ url('/adminpanel') }}">Admin</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="{{ Request::is('dodajmarke') ? 'active' : '' }}" href="{{ url('/dodajmarke') }}">Marke</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.3s"><a class="{{ Request::is('korisnici') ? 'active' : '' }}" href="{{ url('/korisnici') }}">Korisnici</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.4s"><a href="#">Nesto</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.5s"><a href="#">Drugo</a></li>
            </ul>
          @else
          {{--linkovi ako je ulogovani user obican korisnik tj. NIJE admin--}}
            <ul class="main-nav nav navbar-nav navbar-right">
              <li class="wow fadeInDown" data-wow-delay="0s"><a class="{{ Request::is('/') ? 'active' : '' }}" href="/">Home</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.1s"><a href="#">Job</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.2s"><a href="#">Employeers</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.3s"><a href="#">About us</a></li>
              <li class="wow fadeInDown" data-wow-delay="0.4s"><a href="#">Blog</a></li>
              {{--ako je user ulogovan, autor i aktiviran mu je nalog--}}
              @if (Auth::check() && Auth::user()->role == 'author'&& Auth::user()->aktivan == 1)
                <li class="wow fadeInDown" data-wow-delay="0.5s"><a href="#">Novi Oglas</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.5s"><a class="{{ Request::is('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profil</a></li>
              @endif
            </ul>
          @endif
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    
    <div class="content-area">
      <div class="container">
        @yield('content')
      </div>
    </div>

    {{-- OVAJ FOOTER TREEBA DOSTA PREPRAVITI POSTO JE OGROMAN A NE SLUZI NICEMU --}}
    {{-- <div class="footer-area">
           
    </div> --}}


    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    {{-- <script>window.jQuery || document.write('<script src="{{ asset('js/vendor/jquery-1.10.2.min.js') }}"><\/script>')</script> --}}
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>  
    <script>
      //ja dodao da bi nav imao marginu sa desne strane od 7 px posto se u GoogleChrome-u kvarilo
      $(window).load(function(){
        setTimeout(function() {
          $('.navbar').css('margin-right', '7px');
          //$('.navbar-collapse').css('margin-right', '155px');
        }, 1500);          
      });
    </script>  
  </body>
</html>