@extends('layouts.app')

{{--vju se koristi da admin doda marke i modele automobila, poziva ga index() MarkaControllera, preko rute '/dodajmarke'--}}

@section('content')
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
    {{-- posto je div koji prikazuje formu po difoltu nevidljiv kad se klikne ovde uklanja mu se hidden="true", hendler u dodajmarke.js --}}
  	<h1 class="text-center naslovdodajmarku">Dodaj Marke Automobila</h1>
    {{--ako je forma sabmitovana a validacija u MarkaControleru vrati errore div je po difoltu vidljiv, takodje ako je uspesno upisana marka
    u bazu tj ako store() metod MarkaControllera vrati success poruku--}}
    @if ($errors->has('imemarke') || $errors->has('inputimages') || Session::has('success'))
    <div class="formadodajmarku">
    @else{{--ako nema errora tj forma je prosla validaciju div je nevidljiv, isto vazi kad se prvi put dodje na vju--}}
    <div class="formadodajmarku" hidden="true">
    @endif
      {{-- hendler za klik na ovu ikonu je u dodajmarke.js i on divu formadodajmodel dodaje attr hidden="true"--}}
      <img src="img/closeplava.png" class="pull-right closebtn">
      {{-- forma za dodavanje marke i logo-a automobila gadja store() metod MarkaControllera --}}
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/sotremarka') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{-- polje za unos imena marke --}}
        <div class="form-group {{ $errors->has('imemarke') ? ' has-error' : '' }}">
          <label for="imemarke" class="lepfont col-md-4 control-label">Ime Marke</label>
          <div class="col-md-6">
            <input id="imemarke" type="text" class="form-control" name="imemarke" value="{{ old('imemarke') }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('imemarke'))
              <span class="help-block">
                <strong>{{ $errors->first('imemarke') }}</strong>
              </span>
            @endif
          </div>
        </div><br>
        {{--polje za unos slike tj logo-a marke--}}
        <div class="form-group{{ $errors->has('inputimages') ? ' has-error' : '' }}"> 
          <label for="inputimages" class="lepfont col-md-4 control-label">Logo</label>
          <div class="col-md-6">
  	        <div class="col-md-12">
  	  	      <input type="file" id="inputimages" name="inputimages"><br>	
  	  	      <img src="http://placehold.it/100x100" id="showimages" style="max-width:200px;max-height:200px;float:left;">
  	        </div>
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
  	        @if ($errors->has('inputimages'))
              <br>
              <span class="help-block">
                <strong>{{ $errors->first('inputimages') }}</strong>
              </span>
            @endif
  	      </div>
  	    </div>
        {{-- submit btn --}}
  	    <div class="form-group"> 
  	      <label for="publish" class="lepfont col-md-4 control-label"></label>
  	      <div class="col-md-6">
  	        <input type="submit" name="publish" class="sabmint btn btn-success" value="Sacuvaj">
  	      </div>
  	    </div> 	
      </form>
      {{--ako store() metod MarkaControllera upise uspesno vraca se kroz Session succes poruka koju ovde prikazujemo--}}
      @if(Session::has('success')) 
        <div class="text-center success-message" role="alert">
          <strong>{!! Session::get('success') !!}</strong>
        </div>
      @endif
    </div>{{--kraj diva .dodajmarku--}}


    @php
      if(!isset($markaime)){
        $markaime = null;
      }
    @endphp
    {{--div u kom je forma za dodavanje modela marke, kad se klikne na ovaj h1 hendler u dodajmarke.js skida hidden atribut divu formadodajmodel
    u kom je forma za dodavanje modela--}}
    <h1 class="text-center naslovdodajmodele">Dodaj Modele / Edit Marke</h1>
    {{--ako je validacija forme u storemodel() MarkasControllera vratila error ili ako je uspesno upisan novi model pa je u sesiji success-
    poruka ili ako variabla $markaime nije null tj ako smo vju pozvali iz metoda storemodel() MarkaControllera div nece imati hidden="true" u
    - suprotnom ce biti sakriven dok se ne klikne naslov Dodaj Modele Marke--}}
    @if ($errors->has('imemodela') || $errors->has('imemarke2') || Session::has('successmodel') || Session::has('successizmena') || Session::has('successbrisanje') || $markaime != null)
    <div class="formadodajmodel">
    @else
    <div class="formadodajmodel" hidden="true">
    @endif    
      {{-- hendler za klik na ovu ikonu je u dodajmarke.js i on divu formadodajmodel dodaje attr hidden="true"--}}
      <img src="img/closeplava.png" class="pull-right closebtnmodel"> 
      {{--forma za dodavanje modela, preko rute '/storemodel' ide na storemodel() metod MarkasControllra--}}
      <form class="form-horizontal formazanovimodel" role="form" method="POST" action="{{ url('/storemodel') }}">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('imemarke2') ? ' has-error' : '' }}">
          <label for="imemarke2" class="lepfont col-md-4 control-label">Odaberi Marku</label>
          <div class="col-md-6">
            {{--select ce poslati id marke i ta vrednost ce se upisati u marka_id kolonu 'modelis' tabele--}}
            <select name="imemarke2" id="imemarke2" class="form-control">
                <option></option>
              @foreach($marke as $marka)
                <option logo="{{ $marka->logo }}" value="{{ $marka->id }}" {{ $marka->name == $markaime ? 'selected' : '' }}>
                  {{ $marka->name }}
                </option>
              @endforeach
            </select>
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('imemarke2'))
              <span class="help-block">
                <strong>{{ $errors->first('imemarke2') }}</strong>
              </span>
            @endif
            <br>
            {{-- ako smo upisali novi model, tj ako je vju pozvan iz metoda storemodel() MarkaControllera variabla imemarke2 ce postojati 
            tako da prikazujemo i logo marke kojoj smo uneli model --}}
            @if($markaime != null)
              <img class="text-center logomarke" src="img/autologo/{{$markalogo2}}?vreme={{ date('Y-m-d H:i:s') }}">
            @else
              <img hidden='true' class="text-center logomarke" src="img/autologo/alfa-romeo.png?vreme={{ date('Y-m-d H:i:s') }}">
            @endif
          </div>
        </div>
        <br id="ispodlogoamarke">
        {{-- polje za unos inmena modela --}}
        <div class="form-group{{ $errors->has('imemodela') ? ' has-error' : '' }}">
          <label for="imemodela" class="lepfont col-md-4 control-label">Ime Modela</label>
          <div class="col-md-6">
            <input id="imemodela" type="text" class="form-control" name="imemodela" value="{{ old('imemodela') }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('imemodela'))
              <span class="help-block">
                <strong>{{ $errors->first('imemodela') }}</strong>
              </span>
            @endif
          </div>
        </div> 
        {{-- submit btn --}}
        <div class="sabmitbtn form-group"> 
          <label for="publish" class="lepfont col-md-4 control-label"></label>
          <div class="col-md-6">
            <input type="submit" name="publish" class="sabmint btn btn-success" value="Sacuvaj">
          </div>
        </div>   
        {{--ako storemodel() metod MarkaControllera upise uspesno vraca se kroz Session successmodel poruka koju ovde prikazujemo--}}
        @if(Session::has('successmodel')) 
          <div class="text-center success-message" role="alert">
            <strong>
              {!! Session::get('successmodel') !!}
            </strong>
          </div>
        @endif    
        {{-- ako je editovana marka metod izmenimarku() MarkaControllera vraca successizmena u sesiji koju ovde prikazujemo --}}
        @if(Session::has('successizmena')) 
          <div class="text-center success-message" role="alert">
            <strong>
              {!! Session::get('successizmena') !!}
            </strong>
          </div>
        @endif 
        {{-- ako je brisana marka metod obrisimarku() MarkaControllera vraca successbrisanje u sesiji koju ovde prikazujemo --}}
        @if(Session::has('successbrisanje')) 
          <div class="text-center success-message" role="alert">
            <strong>
              {!! Session::get('successbrisanje') !!}
            </strong>
          </div>
        @endif 
    </form>  
    {{-- ako smo upisali novi model, tj ako je vju pozvan iz metoda storemodel() MarkaControllera variabla imemarke2 ce postojati --}}
    @if($markaime != null)
      <div class="text-center prikazimodelemarke" idmarke="{{ $markaid2 }}">
        <span>Do sada uneti modeli za marku: <strong>{{ $markaime }}</strong></span>
      </div>
      <div class="modeli"></div>
      <div class="text-center editmarke" imemarke="{{ $markaime }}" logo="{{ $markalogo2 }}" idmarke="{{ $markaid2 }}">
      <span>Izmeni marku: <strong>{{ $markaime }}</strong></span>
      </div>
      <div class="editmarkeforma"></div>
    @endif

  </div>{{--kraj diva .formadodajmodel--}}
    {{-- OVI BR-OVI SU TU DA BI FOOTER BIO NA MESTU, TO TREBA SREDITI ... --}}
   <br><hr><br><br><br><br><br><br><br>
  </div>


  <script type="text/javascript" src="{{ asset('js/autojq/dodajmarke.js') }}"></script>
  {{-- ovo malo javascriptta sluzi da se u polju tj img elementu ispod inputa za upload slike logo-a pojavi slika koju smo uploadovali --}}
  <script type="text/javascript">
      function readURL(input){
        if(input.files && input.files[0]){
          var reader = new FileReader();
          reader.onload = function(e){
            $('#showimages').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
        }
      }
      $("#inputimages").change(function(){
        readURL(this);
      });

    //ove varijable koristi dodajmarku.js kad korisnik hoce da vidi sve dodate modele neke marke tj kad klikne na div .prikazimodelemarke  
    var token = '{{ Session::token() }}';
    var url = '{{ route('prikazimodele') }}'; 
    //ruta za editovanje modela(forma i hendler za klik na submit su u dodajmarke.js)
    var izmenimodelurl = '{{ route('izmenimodel') }}'; 
    //ruta za brisanje modela kad se klikne trash btn tj glyphicon pored nekog modela(hendler je u dodajmarke.js)
    var deletemodelurl = '{{ route('deletemodel') }}'; 
    //ruta za formu koju generise hendler za klik na div editmarke(koji je takodje izgenerisan u dodajmarke.js kad se u selectu za marke u 
    //formi za dodavanje modela selectuje neka marka), ova forma je za editovanje postojece marke
    var izmenimarkuurl = '{{ route('izmenimarku') }}';
    //ruta za formu koju generise hendler za klik na div editmarke(koji je takodje izgenerisan u dodajmarke.js kad se u selectu za marke u 
    //formi za dodavanje modela selectuje neka marka), ova forma je za brisanje postojece marke
    var obrisimarkuurl = '{{ route('obrisimarku') }}';
    var slikeurl = '{{ url('/') }}';//varijabla potrebna da bi profil.js mogao da napravi src atribute img-ovima koji prikazuju close ikone
  </script>

@endsection