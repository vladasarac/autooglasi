@extends('layouts.app')

{{--korisnikov profil i slicno poziva ga profil() metod UsersControllera, korisnik ovde moze da dopuni profil,  --}}

@section('content')

  {{-- div se koristi u profil.js da se izmeri sirina ekrana --}}
  <div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div>  

  @if(Session::has('successactivation')) 
    <div class="text-center success-message" role="alert">
      <strong>{!! Session::get('successactivation') !!}</strong>
    </div>
  @endif

  
 
  {{-- div koji na vrhu u maloj tabeli prikazuje osnovne podatke korisnika koje je uneo prilikom registracije i br. postavljenih oglasa --}}
  <div class="row jobs podatcikorisnika">
    <div class="col-md-9 podatciusera">
      <div class="job-posts table-responsive tabelauserpodatci">
        <table class="table">
        <tbody class="profilkorisnika">
          <tr class="odd wow fadeInUp " data-wow-delay="1s">
          {{-- ako user ima dodat logo tj kolona logo 'users' tabele je 1, prikazi logo,atribut vreme je tu da bi refresovao sliku pri svakom ucitavanju--}}
          @if($user->logo == 1)
          {{-- @if($user['logo'] == 1) --}}
            <td class="tbl-logo"><img src="{{ asset('img/users/'.$user->id.'/1.jpg') }}?vreme={{ date('Y-m-d H:i:s') }}" alt=""></td>
          @else{{--ako nema sliku prikazujemo difolt sliku--}}
            <td class="tbl-logo"><img src="{{ asset('img/how-work3.png') }}" alt=""></td>
          @endif
            <td class="tbl-title"><h4>{{ $user->name }}<br><span class="job-type"><i class="icon-location"></i>{{ $user->grad }}</span></h4></td>
            <td>            
              <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}
              <br>
              <span class="job-type"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;{{ $user->telefon }}</span>
              <br>
              <span class="job-type">
                <i class="fa fa-car" aria-hidden="true"></i> Broj Oglasa: <span id="brojoglasausera">{{ $user->brojoglasa }}</span>
              </span> 	            
            </td>
            {{--  --}}
            @if (Auth::check() && Auth::user()->role == 'admin' && $user->aktivan == 1)
              <td class="tbl-apply"><a class="greenbtn" href="/novioglas/{{ $user->id }}">Novi Oglas</a></td>
            @elseif(Auth::user()->id == $user->id && $user->aktivan == 1)
              <td class="tbl-apply"><a class="greenbtn" href="/novioglas">Novi Oglas</a></td>
            @endif
            <td class="tbl-apply">
            {{-- link za brisanje profila, gadja metod obrisikorisnika() UsersControllera --}}
              <a class="orangebtn" href="{{ url('obrisikorisnika/'.$user->id.'?_token='.csrf_token()) }}" onclick="return confirm('Da li ste sigurni da zelite da obrisete profil?');" id="obrisiprofilbtn">
                Obriši Profil
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  {{-- ako Session ima novioglasmessage i nije prazna variabla $novioglas koju vraca upisinovioglas() OglasControllera kad upis novi oglas tj user je
       upravo dodao novi oglas tj vju je pozvan iz metoda upisinovioglas() OglasControllera --}}
  @if(Session::has('novioglasmessage') && !empty($novioglas)) 
    <div class="success-message novioglasprofilusera col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1" role="alert">
      {{-- @if(Auth::check() && Auth::user()->role == 'admin')
        <a href="{{ route('profil', $user->id) }}">
      @else
        <a href="{{ route('profil') }}">
      @endif --}}
      <img src="{{ asset('img/greenclose.png') }}" class="pull-right closenovioglas">
        {{-- </a> --}}
      <h4 class="text-center">{!! Session::get('novioglasmessage') !!}</h4>
      <hr>
      {{-- prikazujemo useru novioglas koji je upravo uneo --}}
      <div class="novioglasprikaz">
        @php
          $slug = str_slug($novioglas->marka);
        @endphp
        <h4 class="text-center"><img class="logomarke" src="{{ asset("img/autologo/$slug.png") }}"> &nbsp; &nbsp;{{ $novioglas->naslov }}</h4> <hr>
        <h4><b>Osnovni Podatci</b></h4>
        <p>
          <b>Marka i Model: </b>{{ $novioglas->marka }} / {{ $novioglas->model }}, <b>Godiste: </b>{{ $novioglas->godiste }}, <b>Cena: </b>{{ $novioglas->cena }} eur, 
          <b>Karoserija: </b>{{ $novioglas->karoserija }}, <b>Kubikaža: </b>{{ $novioglas->kubikaza }} cm<sup>3</sup>, <b>Snaga KS/KW: </b>{{ $novioglas->snagaks }}/{{ $novioglas->snagakw }}, 
          <b>Kilometraža: </b>{{ $novioglas->kilometraza }} km, <b>Gorivo: </b>{{ $novioglas->gorivo }}, <b>Emisiona Klasa</b> 
          {{ $novioglas->emisionaklasa }},  
          <b>Pogon: </b>
          @if($novioglas->pogon == 'p')
            prednji,  
          @elseif($novioglas->pogon == 'z')
            zadnji,  
          @elseif($novioglas->pogon == '4x4')
            4 x 4,  
          @elseif($novioglas->pogon == '4x4r') 
            4 x 4 reduktor,  
          @endif
          <b>Menjač: </b>
          @if($novioglas->menjac == 'm4')
            manuelni 4 brzine,  
          @elseif($novioglas->menjac == 'm5')
            manuelni 5 brzina,  
          @elseif($novioglas->menjac == 'm6')
            manuelni 6 brzina, 
          @elseif($novioglas->menjac == 'pa')
            poluautomatski, 
          @elseif($novioglas->menjac == 'a')
            automatski,  
          @endif
          @if($novioglas->ostecen == 1)
            <b>Ostecenja: </b>vozilo je ošteceno,  
          @endif
          <b>Broj Vrata: </b>
          @if($novioglas->brvrata == 3)
            2/3, 
          @elseif($novioglas->brvrata == 4)
            4/5, 
          @endif
          <b>Broj Sedišta: </b>{{ $novioglas->brsedista }}, 
          <b>Strana Volana: </b>
          @if($novioglas->strvolana == 'l')
            levi volan, 
          @elseif($novioglas->strvolana == 'd')
            desni volan, 
          @endif
          <b>Klima: </b>
          @if($novioglas->klima == '0')
            nema klimu, 
          @elseif($novioglas->klima == 'mk')
            manuelna klima, 
          @elseif($novioglas->klima == 'ak')
            automatska klima, 
          @endif
          <b>Boja: </b>{{ $novioglas->boja }},
          <b>Poreklo Vozila: </b>
          @if($novioglas->poreklo == 'dt')
            domace tablice
          @elseif($novioglas->poreklo == 'st')
            strane tablice
          @elseif($novioglas->poreklo == 'nik')
            na ime kupca
          @endif
        </p> <hr>  
        <p>
          <b>Sigurnost: </b>{{ $novioglas->sigurnost }}
        </p> <hr>  
        <p>
          <b>Oprema: </b>{{ $novioglas->oprema }}
        </p> <hr>  
        <p>
          <b>Stanje Vozila: </b>{{ $novioglas->stanje }}
        </p> <hr>  
        <p>
          <b>Tekst Oglasa: </b>{{ $novioglas->tekst }}
        </p> <hr>  
        <h4><b>Slika: {{ $slike }}</b></h4><hr>
        @if($slike != 0)
          <div id="novioglasslikediv">
            @php
              $sada = date('Y-m-d H:i:s');
            @endphp
            @for($i = 1; $i <= 12; $i++)
              @if(file_exists("img/oglasi/$novioglas->folderslike/$novioglas->id/$i.jpg"))
                <img src="{{ asset("img/oglasi/$novioglas->folderslike/$novioglas->id/thumb$i.jpg?vreme=$sada") }}" class="novioglasslike">
              @endif
            @endfor
          </div>
        @else
          <h4>Oglas nema dodatih slika.</h4>
        @endif
      </div>
    </div>
  @endif  {{--kraj prikaza novog oglasa--}}

  @if(Session::has('success')) 
    <div class="success-message text-center" role="alert">
      <h2>{!! Session::get('success') !!}</h2>
    </div>
  @endif
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
    {{--klik na ovaj h1 prikazuje div sa formom za dopunu tj menjanje podataka korisnika, hendler u profil.js--}}
    <h1 class="text-center naslovdodajpodatkekorisnika shadow">Dopuni / Izmeni Podatke Profila</h1>

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

    </div>{{--kraj diva .formadodajpodatkekorisnika--}}
    

    {{-- Ako user ima neke oglasa ovde ih prikazujemo --}}
    @if($user->brojoglasa != 0)
      <h1 class="text-center naslovoglasikorisnika shadow">Do Sada Dodati Oglasi</h1>
      <div class="oglasikorisnikaprofil" hidden="true">
        {{-- hendler za klik na ovu ikonu je u dodajmarke.js i on divu oglasikorisnikaprofil dodaje attr hidden="true"--}}
        <img src="{{ asset('img/closeplava.png') }}" class="pull-right closeoglasikorisnikabtn"><br>
        @foreach($oglasi as $oglas)
          @php
            $slugmarkeoglasa = str_slug($oglas->marka);
          @endphp
          <div class="row" id="prikazoglasa{{ $oglas->id }}">
            <div class="col-lg-3">
              @if($oglas->slike != 0)
                @php
                  //for($i = 1; $i <= $oglas->slike; $i++){
                  for($i = 1; $i <= 12; $i++){
                    if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg")){
                      echo "<img src='".url('/')."/img/oglasi/".$oglas->folderslike."/".$oglas->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='naslovnaslika'>";
                      break;
                    }
                  }
                @endphp
                {{-- <img src="{{ asset("img/oglasi/$oglas->folderslike/$oglas->id/thumb.jpg") }}" class="naslovnaslika"> --}}
              @else
                <img src="{{ asset("img/no_image_available.jpg") }}" class="naslovnaslika">
              @endif           
            </div>  
            <div class="col-lg-6 podatcioglasa">
              <h4 class="naslovoglasaprofil">
                <img class="logomarkeoglasaprofil" src="{{ asset("img/autologo/$slugmarkeoglasa.png") }}"> &nbsp;
                <b>{{ $oglas->naslov }}</b> | 
                <b>Cena</b> - {{ $oglas->cena }} EUR
              </h4>
              <p id="datumiodobren{{ $oglas->id }}" class="podatcivozilaprofil">
                <b>Postavljen</b> - {{ $oglas->created_at->format('d.m.Y.') }} | 
                @if($oglas->odobren == 1)
                  <span id="spanoglasodobren{{ $oglas->id }}" class="text-success"><b>Ododbren</b></span>
                @else
                  <span id="spanoglasneodobren{{ $oglas->id }}" class="text-danger"><b>Neododbren</b></span>
                @endif
              </p>
              <p class="podatcivozilaprofil">
                <b>{{ $oglas->marka }}</b> - {{ $oglas->model }} | 
                <b>Godište</b> - {{ $oglas->godiste }}
              </p>
              <p class="podatcivozilaprofil">
                <b>Karoserija</b> - {{ $oglas->karoserija == 'hecbek' ? "hečbek" : $oglas->karoserija }} | 
                <b>Kilometraža</b> - {{ $oglas->kilometraza }} km
              </p>
              <p class="podatcivozilaprofil">
                <b>Kubikaža</b> - {{ $oglas->kubikaza }} cm<sup>3</sup> | 
                <b>Snaga KS/KW</b> - {{ $oglas->snagaks }}/{{ $oglas->snagakw }}
              </p>
              <p class="podatcivozilaprofil">
                <b>Gorivo</b> -
                @if($oglas->gorivo == 'dizel')
                  Dizel | 
                @elseif($oglas->gorivo == 'benzin')
                  Benzin | 
                @elseif($oglas->gorivo == 'benzingas') 
                  Benzin + Gas(TNG) | 
                @elseif($oglas->gorivo == 'metan')
                  Metan CNG | 
                @elseif($oglas->gorivo == 'elektricni')
                  Električni Pogon | 
                @elseif($oglas->gorivo == 'hibrid')
                  Hibrid | 
                @endif    
                <b>Slika</b> - {{ $oglas->slike }}
              </p>
            </div>
            {{-- btn za izmenu, brisanje i ako je admin odobravanje ili zabranjavinje oglasa --}}
            <div class="col-lg-3 tbl-apply">
              <a id="aktiviraj" class="bezdekoracije" userid="{{ $user->id }}" href="{{ url('izmenioglasforma/'.$oglas->id.'/'.$user->id) }}">
                <button type="button" class="btn btn-primary btn-block oglasbtnprofilblade">
                  Izmeni&nbsp;&nbsp; Oglas
                </button>
              </a>
              <button type="button" class="btn btn-danger btn-block obrisioglas oglasbtnprofilblade" idoglasa="{{ $oglas->id }}" id="obrisioglasbtn{{ $oglas->id }}">
                Obriši&nbsp;&nbsp;&nbsp; Oglas
              </button>
              {{-- ako je admin ulogovan i gleda neciji profil ima btn-e za odobravanje i zabranu oglasa --}}
              @if(Auth::check() && Auth::user()->role == 'admin')
                @if($oglas->odobren == 0)
                  <button type="button" id="odobrioglasbtn{{ $oglas->id }}" class="btn btn-success btn-block odobrioglas" oglasid="{{ $oglas->id }}">
                    Odobri&nbsp; Oglas
                  </button>
                @elseif($oglas->odobren == 1)
                  <button type="button" id="zabranioglasbtn{{ $oglas->id }}" class="btn btn-warning btn-block zabranioglas" oglasid="{{ $oglas->id }}">
                    Zabrani Oglas
                  </button>
                @endif  
              @endif       
            </div>             
          </div> {{-- kraj diva #prikazoglasa{{ $oglas->id }} --}}
          <hr id="hr{{ $oglas->id }}">
        @endforeach 
      </div>
    @else
      <h1 class="text-center naslovnemaoglasakorisnika">Nema Oglasa</h1>
    @endif 

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
    var slikeurl = '{{ url('/') }}';//varijabla potrebna da bi profil.js mogao da napravi src atribute img-ovima koji prikazuju close ikone
    var token = '{{ Session::token() }}';
    var urlbrisilogo = '{{ route('obrisilogo') }}'; 
    var urlbrisimapu = '{{ route('obrisimapu') }}'; 
    var urlodobrioglas = '{{ route('odobrioglas') }}';
    var urlzabranioglas = '{{ route('zabranioglas') }}';
    var urlobrisioglas = '{{ route('obrisioglas') }}';
    var urlobrisikorisnika = '{{ route('obrisikorisnika') }}';
    //ove varijable su potrebne da bi profil.js mogao da obbrise tabelu sa podatcima usera ciji je profil koja je na vrhu i nacrta div koji ce
    //se viseti umesto nje kad user mobilnim koristi sajt
    var userid = '{{ $user->id }}';
    var username = '{{ $user->name }}';
    var useremail = '{{ $user->email }}';
    var usergrad = '{{ $user->grad }}';
    var usertelefon = '{{ $user->telefon }}';
    var userbrojoglasa = '{{ $user->brojoglasa }}';
    var userlogo = '{{ $user->logo }}';
    var userauthcheck = '{{ Auth::check() }}';
    var userauthuserrole = '{{ Auth::user()->role }}';
    var useraktivan = '{{ $user->aktivan }}';
    var userauthuserid = '{{ Auth::user()->id }}';

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