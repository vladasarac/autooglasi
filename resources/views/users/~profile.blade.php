@extends('layouts.app')

{{--korisnikov profil i slicno poziva ga profil() metod UsersControllera, korisnik ovde moze da dopuni profil,  --}}

@section('content')
  
  @if(Session::has('successactivation')) 
    <div class="text-center success-message" role="alert">
      <strong>{!! Session::get('successactivation') !!}</strong>
    </div>
  @endif

  {{-- div koji na vrhu u maloj tabeli prikazuje osnovne podatke korisnika koje je uneo prilikom registracije i br. postavljenih oglasa --}}
  <div class="row jobs podatcikorisnika">
    <div class="col-md-9 ">
      <div class="job-posts table-responsive">
        <table class="table">
        <tbody class="profilkorisnika">
          <tr class="odd wow fadeInUp " data-wow-delay="1s">
          {{-- ako user ima dodat logo tj kolona logo 'users' tabele je 1, prikazi logo,atribut vreme je tu da bi refresovao sliku pri svakom ucitavanju--}}
          @if($user->logo == 1)
            <td class="tbl-logo"><img src="{{ asset('img/users/'.$user->id.'/1.jpg') }}?vreme={{ date('Y-m-d H:i:s') }}" alt=""></td>
          @else{{--ako nema sliku prikazujemo difolt sliku--}}
            <td class="tbl-logo"><img src="{{ asset('img/how-work3.png') }}" alt=""></td>
          @endif
            <td class="tbl-title"><h4>{{ $user->name }}<br><span class="job-type"><i class="icon-location"></i>{{ $user->grad }}</span></h4></td>
            <td>            
              <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}
              <br><span class="job-type"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;{{ $user->telefon }}</span>
              <br><span class="job-type"><i class="fa fa-car" aria-hidden="true"></i> Broj Oglasa: {{ $user->brojoglasa }}</span> 	            
            </td>
            <td class="tbl-apply"><a class="orangebtn" href="#">Obrisi Profil</a></td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <p>Ovde mozete dopuniti podatke vaseg profila.</p>
  @if(Session::has('success')) 
    <div class="success-message text-center" role="alert">
      <h2>{!! Session::get('success') !!}</h2>
    </div>
  @endif
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
    {{--klik na ovaj h1 prikazuje div sa formom za dopunu tj menjanje podataka korisnika, hendler u profil.js--}}
    <h1 class="text-center naslovdodajpodatkekorisnika">Dopuni / Izmeni Podatke Profila</h1>

    
    @if ($errors->has('imekorisnika') || $errors->has('grad') || $errors->has('telefonkorisnika') || $errors->has('adresakorisnika') || $errors->has('telefon2') || $errors->has('telefon3'))
      <div class="formadodajpodatkekorisnika">
    @else{{--ako nema errora tj forma je prosla validaciju div je nevidljiv, isto vazi kad se prvi put dodje na vju--}}
      <div class="formadodajpodatkekorisnika" hidden="true">
    @endif
    
      {{-- hendler za klik na ovu ikonu je u dodajmarke.js i on divu formadodajmodel dodaje attr hidden="true"--}}
      <img src="{{ asset('img/closeplava.png') }}" class="pull-right closebtn">
      {{-- forma za dodavanje marke i logo-a automobila gadja store() metod MarkaControllera --}}
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/editusera') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="userid" value="{{ $user->id }}">
        {{-- polje za unos tj promenu inmena korisnika --}}
        <div class="form-group{{ $errors->has('imekorisnika') ? ' has-error' : '' }}">
          <label for="imekorisnika" class="lepfont col-md-4 control-label">
            Ime <img src="{{ asset('img/redinfo.png') }}" class="infoikona" id="infoime">
          </label>
          <div class="col-md-6">
            <input id="imekorisnika" type="text" class="form-control" name="imekorisnika" value="{{ old('imekorisnika') ? old('imekorisnika') :  $user->name }}"> 
                
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('imekorisnika'))
              <span class="help-block">
                <strong>{{ $errors->first('imekorisnika') }}</strong>
              </span>
            @endif
          </div>
        </div>

        @php
          $gradovi = ["Aleksinac","Aranđelovac","Aleksandrovac","Beograd","Bor","Bačka Palanka",
                      "Bačka Topola","Bogatić","Bujanovac","Bečej",

                      "Novi Sad","Niš","Kragujevac"
          ];    
        @endphp
        {{--polje tj select za promenu grada, ja dodo--}}   
        <div class="form-group{{ $errors->has('grad') ? ' has-error' : '' }}">
          <label for="grad" class="lepfont col-md-4 control-label">
            Grad <img src="{{ asset('img/redinfo.png') }}" class="infoikona" id="infograd">
          </label>
          <div class="col-md-6">
            <select name="grad" id="grad" value="{{ old('grad') }}" class="form-control">
              <option></option>
              @foreach ($gradovi as $key => $grad)
                <option value="{{ $grad}}" {{ ($user->grad == $grad ? "selected":"") }}>{{ $grad }}</option>
              @endforeach
            </select>
            @if ($errors->has('grad'))
              <span class="help-block">
                <strong>{{ $errors->first('grad') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{-- polje za unos tj promenu telefona(ovo je telefon unet pri registraciji) korisnika --}}
        <div class="form-group{{ $errors->has('telefonkorisnika') ? ' has-error' : '' }}">
          <label for="telefonkorisnika" class="lepfont col-md-4 control-label">
            Telefon <img src="{{ asset('img/redinfo.png') }}" class="infoikona" id="infotelefon">
          </label>
          <div class="col-md-6">
            <input id="telefonkorisnika" type="text" class="form-control" name="telefonkorisnika" value="{{ old('telefonkorisnika') ? old('telefonkorisnika') :  $user->telefon }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('telefonkorisnika'))
              <span class="help-block">
                <strong>{{ $errors->first('telefonkorisnika') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{--polje tj select za biranje da li userov email vidljiv korisnicima--}}   
        <div class="form-group{{ $errors->has('prikaziemail') ? ' has-error' : '' }}">
          <label for="prikaziemail" class="lepfont col-md-4 control-label">
            Prikazi E-mail <img src="{{ asset('img/info.png') }}" class="infoikona" id="infoemail">
          </label>
          <div class="col-md-6">
            <select name="prikaziemail" id="prikaziemail" value="{{ old('prikaziemail') }}" class="form-control">
              <option value="0" {{ ($user->prikaziemail != 1 ? "selected":"") }}>Ne</option>
              <option value="1" {{ ($user->prikaziemail == 1 ? "selected":"") }}>Da</option>
            </select>
            @if ($errors->has('grad'))
              <span class="help-block">
                <strong>{{ $errors->first('grad') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{--polje tj select za biranje da li je user pravno ili privatno lice, po difoltu je privatno tj 0--}}   
        <div class="form-group{{ $errors->has('pravnolice') ? ' has-error' : '' }}">
          <label for="pravnolice" class="lepfont col-md-4 control-label">
            Pravno Lice <img src="{{ asset('img/info.png') }}" class="infoikona" id="infopravnolice">
          </label>
          <div class="col-md-6">
            <select name="pravnolice" id="pravnolice" value="{{ old('pravnolice') }}" class="form-control">
              <option value="0" {{ ($user->pravnolice != 1 ? "selected":"") }}>Ne</option>
              <option value="1" {{ ($user->pravnolice == 1 ? "selected":"") }}>Da</option>
            </select>
            @if ($errors->has('grad'))
              <span class="help-block">
                <strong>{{ $errors->first('grad') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{-- polje za unos tj promenu adrese korisnika --}}
        <div class="form-group{{ $errors->has('adresakorisnika') ? ' has-error' : '' }}">
          <label for="adresakorisnika" class="lepfont col-md-4 control-label">
            Adresa <img src="{{ asset('img/info.png') }}" class="infoikona" id="infoadresa">
          </label>
          <div class="col-md-6">
            <input id="adresakorisnika" type="text" class="form-control" name="adresakorisnika" value="{{ old('adresakorisnika') ? old('adresakorisnika') :  $user->adresa }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('adresakorisnika'))
              <span class="help-block">
                <strong>{{ $errors->first('adresakorisnika') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{-- polje za unos tj promenu telefona2 korisnika --}}
        <div class="form-group{{ $errors->has('telefon2') ? ' has-error' : '' }}">
          <label for="telefon2" class="lepfont col-md-4 control-label">
            Telefon 2 <img src="{{ asset('img/info.png') }}" class="infoikona" id="infotelefon2">
          </label>
          <div class="col-md-6">
            <input id="telefon2" type="text" class="form-control" name="telefon2" value="{{ old('telefon2') ? old('telefon2') :  $user->telefon2 }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('telefon2'))
              <span class="help-block">
                <strong>{{ $errors->first('telefon2') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{-- polje za unos tj promenu telefona3 korisnika --}}
        <div class="form-group{{ $errors->has('telefon3') ? ' has-error' : '' }}">
          <label for="telefon3" class="lepfont col-md-4 control-label">
            Telefon 3 <img src="{{ asset('img/info.png') }}" class="infoikona" id="infotelefon3">
          </label>
          <div class="col-md-6">
            <input id="telefon3" type="text" class="form-control" name="telefon3" value="{{ old('telefon3') ? old('telefon3') :  $user->telefon3 }}">
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('telefon3'))
              <span class="help-block">
                <strong>{{ $errors->first('telefon3') }}</strong>
              </span>
            @endif
          </div>
        </div>

        {{--polje za unos slike tj logo-a marke--}}
        <div class="form-group{{ $errors->has('inputimages') ? ' has-error' : '' }}"> 
          <label for="inputimages" class="lepfont col-md-4 control-label">
            Logo 
            <img src="{{ asset('img/info.png') }}" class="infoikona" id="infologo">
          </label>
          <div class="col-md-6">
            <div class="col-md-12">
              <input type="file" id="inputimages" name="inputimages"><br> 
              {{-- ako je user vec uploadovao neki logo prikazi ga --}}
              @if($user->logo == 1)
                <img src="{{ asset('img/users/'.$user->id.'/1.jpg') }}?vreme={{ date('Y-m-d H:i:s') }}" id="showimages" style="max-width:200px;max-height:200px;float:left;">
                {{--btn kojim user moze obrisati uneti logo ako ne zeli vise da ima logo, hendler je u profil.js koji salje AJAX obrisilogo()
                metodu UsersControllera koji brise userov logo--}}
                &nbsp;<button type="button" userid="{{ $user->id }}" class="obrisilogo btn btn-danger">Obrisi Logo</button>
              @else{{-- ako nije uploadovao logo stavi sivu sliku 100 x 100 px sa neta --}}
                <img src="http://placehold.it/100x100" id="showimages" style="max-width:200px;max-height:200px;float:left;">
              @endif
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

        {{--ovde je prikazan google-map i korisnik klikom na mapu tj svoju lokaciju moze uneti lat, lng i zoom--}}
        @if($user->lat && $user->lng && $user->zoom)
          <p class="lepfont text-center mapinfop"><span id="izmenimapu">Izmeni Mapu </span><img src="{{ asset('img/info.png') }}" class="infoikona" id="infomapa"></p>
        @else
          <p class="lepfont text-center mapinfop">Dodaj Mapu <img src="{{ asset('img/info.png') }}" class="infoikona" id="infomapa"></p>
        @endif
        {{--ako user vec ima dodatu mapu ali zeli da je obrise(ne da je maja nego da je totlano obrise) nudimo mu btn za to--}}
        @if($user->lat && $user->lng && $user->zoom)
          <p class="text-center"><button type="button" userid="{{ $user->id }}" class="obrisimapu btn btn-danger">Obrisi Mapu</button></p>
        @endif
        <p class="lepfont text-center">(Pronadjite vasu lokaciju na mapi, zumirajte i kliknite na nju)</p>
        <div id="mapspoljni">
          {{-- div u koji se ubacuje mapa --}}
          <div id="map-canvas" class="form-group "></div>
        </div>
        {{-- polje za unos latitude korisnika, zbog readonly atributa korisnik samo klikom na mapu moze uneti vrednost--}}
        <div class="formamapa form-group{{ $errors->has('lat') ? ' has-error' : '' }}">
          <label for="lat" class="lepfont col-md-1 control-label">Lat</label>
          <div class="col-md-2">
            <input id="lat" type="text" class="form-control" name="lat" value="{{ old('lat') ? old('lat') :  $user->lat }}" readonly>
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('lat'))
              <span class="help-block">
                <strong>{{ $errors->first('lat') }}</strong>
              </span>
            @endif
          </div>
          {{-- polje za unos latitude korisnika, zbog readonly atributa korisnik samo klikom na mapu moze uneti vrednost--}}
          <label for="lng" class="lepfont col-md-1 control-label">Lng</label>
          <div class="col-md-2">
            <input id="lng" type="text" class="form-control" name="lng" value="{{ old('lng') ? old('lng') :  $user->lng }}" readonly>
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('lng'))
              <span class="help-block">
                <strong>{{ $errors->first('lng') }}</strong>
              </span>
            @endif
          </div>
          {{-- polje za unos zoom-a mape, zbog readonly atributa korisnik samo klikom na mapu moze uneti vrednost--}}
          <label for="zoom" class="lepfont col-md-1 control-label">Zoom</label>
          <div class="col-md-2">
            <input id="zoom" type="text" class="form-control" name="zoom" value="{{ old('zoom') ? old('zoom') :  $user->zoom }}" readonly>
            {{-- prikazi error ako forma ne prodje validaciju u kontroleru --}}
            @if ($errors->has('zoom'))
              <span class="help-block">
                <strong>{{ $errors->first('zoom') }}</strong>
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

    </div>{{--kraj diva .--}}
    <br><br>
  </div>{{--kraj diva .sadrzaj--}}
  
  {{--hendleri za ovaj vju su u profil.js iz 'auto\public\js\autojq\profil.js'--}}
  <script type="text/javascript" src="{{ asset('js/autojq/profil.js') }}"></script>

  {{-- proveravamo da li je user uneo do sada mapu, ako jeste uzimamo njegov unos da bi profil.js znao da je uneto i prikazao GM sa userovim
  koordinatama, ako nije uneo podesavamo varijable latitiuda, longituda i zoom1 na null pa ce profil.js prikazati difoltnu mapu Srbije--}}
  @if($user->lat && $user->lng && $user->zoom)
    <script type="text/javascript">
      var latituda = {{ $user->lat }};
      var longituda = {{ $user->lng }};
      var zoom1 = {{ $user->zoom }};
    </script>
  @else
    <script type="text/javascript">
      var latituda = null;
      var longituda = null;
      var zoom1 = null; 
    </script>
  @endif
  
  <script type="text/javascript">   
    //varijable koriste hendleri u profil.js kad salju ajax
    var token = '{{ Session::token() }}';
    var urlbrisilogo = '{{ route('obrisilogo') }}'; 
    var urlbrisimapu = '{{ route('obrisimapu') }}'; 

      //kad korisnik doda sliku prikazi mu je
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
  </script>

@endsection