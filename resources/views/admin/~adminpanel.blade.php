@extends('layouts.app')

{{--ovaj vju je admin panel--}}

@section('content')

  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

  	<h1>Admin Panel</h1>

  	<div class="content-area">
      <div class="row page-title text-center wow zoomInDown" data-wow-delay="1s">
        <h5>Our Process</h5>
        <h2>How we work for you?</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae illum dolorem, rem officia, id explicabo sapiente</p>
      </div>
    </div>

    <div class="row how-it-work text-center">
      {{--div je link ka ruti '/dodajmarke' tj ka vjuu dodajmarke.blade.php tj ka index() MarkaControllera, taj vju sluzi za dodavanje marki i modela automobila--}}
      <div class="col-md-4" onclick="window.location.href='{{ url('/dodajmarke') }}'">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
          <img src="{{ asset('img/automarkelogo.png') }}" alt="">
          <h3>Dodaj Marke i Modele</h3>
        </div>
      </div>
      <div class="col-md-4" onclick="window.location.href='{{ url('/korisnici') }}'">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
          <img src="{{ asset('img/users.png') }}" alt="">
          <h3>Korisnici</h3>
        </div>
      </div>
      <div class="col-md-4">
        <div class="single-work wow fadeInUp" data-wow-delay="0.8s">
          <img src="{{ asset('img/automarkelogo.png') }}" alt="">
          <h3>Dodaj Marke i Modele</h3>
        </div>
      </div>
    </div>

  </div>

  <script type="text/javascript">
  	// $(document).ready(function(){	
  	//   $('.how-it-work').on('click', function(){
  	//   	alert('radi');
  	//   })	
  	// });
  </script>

@endsection