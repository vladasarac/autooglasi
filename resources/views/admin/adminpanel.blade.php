@extends('layouts.app')

{{--ovaj vju je admin panel--}}

@section('content')
  
  <div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div>

  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

  	<h1>Admin Panel</h1>

  	{{-- <div class="content-area">
      <div class="row page-title text-center wow zoomInDown" data-wow-delay="1s">
        <h5>Our Process</h5>
        <h2>How we work for you?</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae illum dolorem, rem officia, id explicabo sapiente</p>
      </div>
    </div> --}}

    <div class="row how-it-work text-center">
      {{--div je link ka ruti '/dodajmarke' tj ka vjuu dodajmarke.blade.php tj ka index() MarkaControllera, taj vju sluzi za dodavanje marki i modela automobila--}}
      <div class="col-md-4" onclick="window.location.href='{{ url('/dodajmarke') }}'">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
          <img class="adminpanelikona" src="{{ asset('img/automarkelogo.png') }}" alt="">
          <h3>Dodaj Marke i Modele</h3>
        </div>
      </div>
      <div class="col-md-4" onclick="window.location.href='{{ url('/korisnici') }}'">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
          <img class="adminpanelikona" src="{{ asset('img/users.png') }}" alt="">
          <h3>Korisnici</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s" onclick="window.location.href='{{ url('/adminoglasi') }}'">
          <img class="adminpanelikona" src="{{ asset('img/searchcars.png') }}" alt="">
          <h3>Oglasi Korisnika</h3>
        </div>
      </div>
    </div>

  </div>

  <script type="text/javascript">
  	$(document).ready(function(){
      var dpi_x = document.getElementById('dpi').offsetWidth;
      var widthekrana = $(window).width() / dpi_x;
      if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
        $('.adminpanelikona').width(80 + '%').height(80 + '%'); 
        //alert(widthekrana);
      }	      
  	});
  </script>

@endsection