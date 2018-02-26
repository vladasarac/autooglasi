@extends('layouts.app')

{{-- vju u kom je forma za kreiranje oglasa, vju vraca metod novioglas() OglasControllera --}}

@section('content')

  {{-- div se koristi u profil.js da se izmeri sirina ekrana --}}
  <div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div>  

  {{-- tabela prikazuje osnovne podatke korisnika --}}
  <div class="row jobs podatcikorisnika">
    <div class="col-md-9 ">
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
              <br><span class="job-type"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;{{ $user->telefon }}</span>
              <br><span class="job-type"><i class="fa fa-car" aria-hidden="true"></i> Broj Oglasa: {{ $user->brojoglasa }}</span> 	            
            </td>
            @if (Auth::check() && Auth::user()->role == 'admin')
              <td class="tbl-apply"><a class="orangebtn" href="/profil/{{ $user->id }}">Profil Korisnika</a></td>
            @else
              <td class="tbl-apply"><a class="orangebtn" href="/profil">Profil Korisnika</a></td>
            @endif
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1"> --}}

  {{-- ako je $user kog posalje metod novioglas() OglasControllera neaktivan nije moguce da on ili admin postave za njega oglas --}}
  @if($user->aktivan != 1)
    <div class="alert alert-danger" role="alert">
      Korisnikov profil nije aktiviran. Nije moguće postaviti oglas.
    </div>
  @else {{--ako je $user kog vrati metod novioglas() OglasControllera aktivan--}}

    <h3 class="text-center">Popunite formu i postavite oglas za vaše vozilo</h3><br>
    <div class="errorsuccess alert alert-danger text-center" role="alert">
      <b>Polja kojima je naslov crvene boje su OBAVEZNA.</b>
      <div class="errori"></div>
    </div>

    {{-- forma za dodavanje novog oglasa --}}
    <form role="form" method="POST" action="{{ url('/upisinovioglas') }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
      <div>
        <h3>Osnovne informacije o vozilu</h3><hr>
      </div>
      
      <div class="row">
        {{-- polje za naslov oglasa, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('naslovoglasa') ? ' has-error' : '' }}">
            <label for="naslovoglasa" id="naslovoglasalabel" class="control-label text-danger">Naslov Oglasa</label>
            <input type="text" class="form-control obaveznopolje" name="naslovoglasa" id="naslovoglasa" value="{{ old('naslovoglasa') }}">
            @if ($errors->has('naslovoglasa'))
              <span class="help-block">
                <strong>{{ $errors->first('naslovoglasa') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za marku, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('markaautomobila') ? ' has-error' : '' }}">
            <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-danger">Marka Automobila</label>
            <select name="markaautomobila" id="markaautomobila" value="{{ old('markaautomobila') }}" class="form-control obaveznopolje">
              <option></option>
              @foreach ($marke as $key => $marka)
                <option markaid="{{ $marka->id }}" value="{{ $marka->name }}">{{ $marka->name }}</option>
              @endforeach
            </select>
            @if ($errors->has('markaautomobila'))
              <span class="help-block">
                <strong>{{ $errors->first('markaautomobila') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za model, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('modelmarke') ? ' has-error' : '' }}">
            <label for="modelmarke" id="modelautomobilalabel" class="control-label text-danger" id="labelzamodel">Model</label>
            <div id="modelmarkeselect">
              <select name="modelmarke" id="modelmarke" value="{{ old('modelmarke') }}" class="form-control obaveznopolje">
                <option id="prazanoptionzamodele"></option>
              </select>
            </div>
            @if ($errors->has('modelmarke'))
              <span class="help-block">
                <strong>{{ $errors->first('modelmarke') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za cenu, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('cena') ? ' has-error' : '' }}">
            <label for="cena" id="cenalabel" class="control-label text-danger">Cena (Eur)</label>
            <input type="text" class="form-control obaveznopolje" name="cena" id="cena" value="{{ old('cena') }}">
            @if ($errors->has('cena'))
              <span class="help-block">
                <strong>{{ $errors->first('cena') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{-- polje za godiste, obavezno, ovde koristim laravelcollective paket --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('godiste') ? ' has-error' : '' }}">
            <label for="godiste" id="godistelabel" class="control-label text-danger">Godište</label>
            {{ Form::selectYear('godiste', 2017, 1930, 2017, ['class' => 'form-control obaveznopolje', 'id' => 'godiste']) }}
            @if ($errors->has('godiste'))
              <span class="help-block">
                <strong>{{ $errors->first('godiste') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za karoseriju, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('karoserija') ? ' has-error' : '' }}">
            <label for="karoserija" id="karoserijalabel" class="control-label text-danger">Karoserija</label>
            <select name="karoserija" id="karoserija" value="{{ old('karoserija') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="limuzina">Limuzina</option>
              <option value="hecbek">Hečbek</option>
              <option value="karavan">Karavan</option>
              <option value="kupe">Kupe</option>
              <option value="kabriolet">Kabriolet</option>
              <option value="minivan">Mini Van</option>
              <option value="suv">SUV</option>
              <option value="pickup">Pickup</option>
            </select>
            @if ($errors->has('karoserija'))
              <span class="help-block">
                <strong>{{ $errors->first('karoserija') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za kubikazu, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('kubikaza') ? ' has-error' : '' }}">
            <label for="kubikaza" id="kubikazalabel" class="control-label text-danger">Kubikaža (cm<sup>3</sup>)</label>
            <input type="text" class="form-control obaveznopolje" name="kubikaza" id="kubikaza">
            @if ($errors->has('kubikaza'))
              <span class="help-block">
                <strong>{{ $errors->first('kubikaza') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za snaguks, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('snagaks') ? ' has-error' : '' }}">
            <label for="snagaks" id="kslabel" class="control-label text-danger">Snaga KS</label>
            <input type="text" class="form-control obaveznopolje" name="snagaks" id="snagaks" value="{{ old('snagaks') }}">
            @if ($errors->has('snagaks'))
              <span class="help-block">
                <strong>{{ $errors->first('snagaks') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za snagukw, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('snagakw') ? ' has-error' : '' }}">
            <label for="snagakw" id="kwlabel" class="control-label text-danger">Snaga KW</label>
            <input type="text" class="form-control obaveznopolje" name="snagakw" id="snagakw" value="{{ old('snagakw') }}">
            @if ($errors->has('snagakw'))
              <span class="help-block">
                <strong>{{ $errors->first('snagakw') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">     
        {{-- polje za kilometrazu, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('kilometraza') ? ' has-error' : '' }}">
            <label for="kilometraza" id="kilometrazalabel" class="control-label text-danger">Kilometraža</label>
            <input type="text" class="form-control obaveznopolje" name="kilometraza" id="kilometraza">
            @if ($errors->has('kilometraza'))
              <span class="help-block">
                <strong>{{ $errors->first('kilometraza') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za gorivo, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('gorivo') ? ' has-error' : '' }}">
            <label for="gorivo" id="gorivolabel" class="control-label text-danger">Gorivo</label>
            <select name="gorivo" id="gorivo" value="{{ old('gorivo') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="benzin">Benzin</option>
              <option value="dizel">Dizel</option>
              <option value="benzingas">Benzin + Gas(TNG)</option>
              <option value="metan">Metan CNG</option>
              <option value="elektricni">Električni Pogon</option>
              <option value="hibrid">Hibridni Pogon</option>
            </select>
            @if ($errors->has('gorivo'))
              <span class="help-block">
                <strong>{{ $errors->first('gorivo') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za emisionu klasu, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('emisionaklasa') ? ' has-error' : '' }}">
            <label for="emisionaklasa" id="emisionaklasalabel" class="control-label text-danger">Emisiona Klasa</label>
            <select name="emisionaklasa" id="emisionaklasa" value="{{ old('emisionaklasa') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="euro1">Euro 1</option>
              <option value="euro2">Euro 2</option>
              <option value="euro3">Euro 3</option>
              <option value="euro4">Euro 4</option>
              <option value="euro5">Euro 5</option>
              <option value="euro6">Euro 6</option>
            </select>
            @if ($errors->has('emisionaklasa'))
              <span class="help-block">
                <strong>{{ $errors->first('emisionaklasa') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za pogon, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('pogon') ? ' has-error' : '' }}">
            <label for="pogon" id="pogonlabel" class="control-label text-danger">Pogon</label>
            <select name="pogon" id="pogon" value="{{ old('pogon') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="p">Prednji</option>
              <option value="z">Zadnji</option>
              <option value="4x4">4x4</option>
              <option value="4x4r">4x4 reduktor</option>
            </select>
            @if ($errors->has('pogon'))
              <span class="help-block">
                <strong>{{ $errors->first('pogon') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za menjac, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('menjac') ? ' has-error' : '' }}">
            <label for="menjac" id="menjaclabel" class="control-label text-danger">Menjač</label>
            <select name="menjac" id="menjac" value="{{ old('menjac') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="m4">Manuelni 4 brzine</option>
              <option value="m5">Manuelni 5 brzina</option>
              <option value="m6">Manuelni 6 brzina</option>
              <option value="pa">Poluautomatski</option>
              <option value="a">Automatski</option>
            </select>
            @if ($errors->has('menjac'))
              <span class="help-block">
                <strong>{{ $errors->first('menjac') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za ostecenje, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('ostecen') ? ' has-error' : '' }}">
            <label for="ostecen" id="ostecenlabel" class="control-label text-danger">Oštećen</label>
            <select name="ostecen" id="ostecen" value="{{ old('ostecen') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="0">Ne</option>
              <option value="1">Da</option>
              <option value="2">Nije u voznom stanju</option>
            </select>
            @if ($errors->has('ostecen'))
              <span class="help-block">
                <strong>{{ $errors->first('ostecen') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">     
        {{-- polje za br vrata, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('brvrata') ? ' has-error' : '' }}">
            <label for="brvrata" id="brvratalabel" class="control-label text-danger">Broj Vrata</label>
            <select name="brvrata" id="brvrata" value="{{ old('brvrata') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="3">2/3 vrata</option>
              <option value="4">4/5 vrata</option>
            </select>
            @if ($errors->has('brvrata'))
              <span class="help-block">
                <strong>{{ $errors->first('brvrata') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za br sedista, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('') ? ' has-error' : '' }}">
            <label for="brsedista" id="brsedistalabel" class="control-label text-danger">Broj Sedišta</label>
            <select name="brsedista" id="brsedista" value="{{ old('') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="2">2 Sedišta</option>
              <option value="3">3 Sedišta</option>
              <option value="4">4 Sedišta</option>
              <option value="5">5 Sedišta</option>
              <option value="6">6 Sedišta</option>
              <option value="7">7 Sedišta</option>
              <option value="8">8 Sedišta</option>
              <option value="9">9 Sedišta</option>
            </select>
            @if ($errors->has('brsedista'))
              <span class="help-block">
                <strong>{{ $errors->first('') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za stranu volana, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('stranavolana') ? ' has-error' : '' }}">
            <label for="stranavolana" id="stranavolanalabel" class="control-label text-danger">Strana Volana</label>
            <select name="stranavolana" id="stranavolana" value="{{ old('stranavolana') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="l">Levi Volan</option>
              <option value="d">Desni Volan</option>
            </select>
            @if ($errors->has('stranavolana'))
              <span class="help-block">
                <strong>{{ $errors->first('stranavolana') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za klimu, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('klima') ? ' has-error' : '' }}">
            <label for="klima" id="klimalabel" class="control-label text-danger">Klima</label>
            <select name="klima" id="klima" value="{{ old('klima') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="0">Nema Klimu</option>
              <option value="mk">Manuelna Klima</option>
              <option value="ak">Automatska Klima</option>
            </select>
            @if ($errors->has('klima'))
              <span class="help-block">
                <strong>{{ $errors->first('klima') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za boju, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('boja') ? ' has-error' : '' }}">
            <label for="boja" id="bojalabel" class="control-label text-danger">Boja</label>
            <select name="boja" id="boja" value="{{ old('boja') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="bela">Bela</option>
              <option value="bez">Bež</option>
              <option value="bordo">Bordo</option>
              <option value="braon">Braon</option>
              <option value="crna">Crna</option>
              <option value="crvena">Crvena</option>
              <option value="kameleon">Kameleon</option>
              <option value="ljubicasta">Ljubičasta</option>
              <option value="narandzasta">Narandžasta</option>
              <option value="plava">Plava</option>
              <option value="siva">Siva</option>
              <option value="srebrna">Srebrna</option>
              <option value="tirkiz">Tirkiz</option>
              <option value="teget">Teget</option>
              <option value="zelena">Zelena</option>
              <option value="zuta">Žuta</option>
            </select>
            @if ($errors->has('boja'))
              <span class="help-block">
                <strong>{{ $errors->first('boja') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za poreklo, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('poreklo') ? ' has-error' : '' }}">
            <label for="poreklo" id="poreklolabel" class="control-label text-danger">Poreklo</label>
            <select name="poreklo" id="poreklo" value="{{ old('poreklo') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="dt">Domace tablice</option>
              <option value="st">Strane tablice</option>
              <option value="nik">Na ime kupca</option>
            </select>
            @if ($errors->has('poreklo'))
              <span class="help-block">
                <strong>{{ $errors->first('poreklo') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div>
        <h3>Sigurnost</h3><hr>
      </div>

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="airbag" name="airbag" value="airbag"> Airbag
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="childlock" name="childlock" value="childlock"> Child lock
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="abs" name="abs" value="abs"> ABS
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas ">
              <input class="form-check-input checkboxnovioglas " type="checkbox" id="esp" name="esp" value="esp"> ESP
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="asr" name="asr" value="asr"> ASR
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="alarm" name="alarm" value="alarm"> Alarm
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="kodiranklj" name="kodiranklj" value="kodiranklj"> Kodiran ključ
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="blokada" name="blokada" value="blokada"> Blokada motora
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="centralna" name="centralna" value="centralna"> Centralna brava
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="zeder" name="zeder" value="zeder"> Zeder
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}
      
      <div>
        <h3>Oprema</h3><hr>
      </div>

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="metalik" name="metalik" value="metalik"> Metalik boja
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="servo" name="servo" value="servo"> Servo volan
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="multi" name="multi" value="multi"> Multi volan
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="tempomat" name="tempomat" value="tempomat"> Tempomat
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="racunar" name="racunar" value="racunar"> Putni računar
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="siber" name="siber" value="siber"> Šiber
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="panorama" name="panorama" value="panorama"> Panorama krov
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="elpodizaci" name="elpodizaci" value="elpodizaci"> El. podizači
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="elretrovizori" name="elretrovizori" value="elretrovizori"> El. retrovizori
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="gretrovizor" name="gretrovizor" value="gretrovizor"> Grejači retrovizora
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="elpodsed" name="elpodsed" value="elpodsed"> El. podesiva sedišta
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="grejanjesed" name="grejanjesed" value="grejanjesed"> Grejanje sedišta
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="svmagla" name="svmagla" value="svmagla"> Svetla za maglu
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="xenon" name="xenon" value="xenon"> Xenon svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="ledsvetla" name="ledsvetla" value="ledsvetla"> LED svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="svsenz" name="svsenz" value="svsenz"> Senzori za svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="kisasenz" name="kisasenz" value="kisasenz"> Senzori za kišu
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="parksenz" name="parksenz" value="parksenz"> Parking senzori
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="krnosac" name="krnosac" value="krnosac"> Krovni nosač
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="kuka" name="kuka" value="kuka"> Kuka za vuču
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="alufelne" name="alufelne" value="alufelne"> Alu. felne
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="navigacija" name="navigacija" value="navigacija"> Navigacija
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="radio" name="radio" value="radio"> Radio
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="cd" name="cd" value="cd"> CD Player
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="dvdtv" name="dvdtv" value="dvdtv"> DVD/TV
            </label>
          </div>
        </div>    
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="webasto" name="webasto" value="webasto"> Webasto
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="grejvetrobran" name="grejvetrobran" value="grejvetrobran"> Grejači vetrobrana
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="koza" name="koza" value="koza"> Kožna sedišta
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div>
        <h3>Stanje vozila</h3><hr>
      </div>

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="prvivlasnik" name="prvivlasnik" value="prvivlasnik"> Prvi vlasnik
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="novusr" name="novusr" value="novusr"> Kupljen nov u Srbiji
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="garancija" name="garancija" value="garancija"> Garancija
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="garaza" name="garaza" value="garaza"> Garažiran
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="servisknj" name="servisknj" value="servisknj"> Servisna knjiga
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="rezklj" name="rezklj" value="rezklj"> Rezervni ključ
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="tuning" name="tuning" value="tuning"> Tuning
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="oldtimer" name="oldtimer" value="oldtimer"> Oldtimer
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="test" name="test" value="test"> Test vozilo
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" id="taxi" name="taxi" value="taxi"> Taxi
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div>
        <h3>Tekst oglasa</h3><hr>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group form-group-sm">
            <textarea name="tekstoglasa" id="tekstoglasa" rows="5" class="form-control" placeholder="Ovde možete rečima opisati vaše vozilo i navesti dodatne informacije koje želite...">@if(old('tekstoglasa')){{ old('tekstoglasa') }}@endif</textarea>
          </div>
        </div>
      </div>


      <div>
        <h3>Dodajte slike</h3><hr>
      </div>
      {{-- btn-i tj inputi za upload slika nisu vidljivi useru tako da se slika uploaduje tako sto se klikne na label za to polje koji je
      u ovom slucaju slika siluete automobila, a zatim hendler u novioglas.js kad user ubaci sliku umesto te difoltne slike prikazuje na 
      njenom mest onu koju je user dodao --}}
      <div class="row">
        
        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika1" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika1holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika1" name="slika1" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika2" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika2holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika2" name="slika2" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika3" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika3holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika3" name="slika3" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika4" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika4holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika4" name="slika4" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika5" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika5holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika5" name="slika5" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika6" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika6holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika6" name="slika6" type="file"/>
          </div>
        </div>

      </div>{{--kraj diva .row--}}
      <div class="row">
        
        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika7" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika7holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika7" name="slika7" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika8" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika8holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika8" name="slika8" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika9" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika9holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika9" name="slika9" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika10" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika10holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika10" name="slika10" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika11" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika11holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika11" name="slika11" type="file"/>
          </div>
        </div>

        <div class="col-md-2">
          <div class="image-upload">
            <label for="slika12" class="slikaupload">
              <img style="width: 150px; height: 80px;" id="slika12holder" src="{{ asset('img/kolasilueta2.png') }}"/>
            </label>
            <input id="slika12" name="slika12" type="file"/>
          </div>
        </div>

      </div>{{--kraj diva .row--}}
      


      <hr>

      
      {{-- submit btn --}}
      <div class="row">
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <div id="submitbtndiv">
              <input type="submit" id="objavioglas" name="objavioglas" class="sabmint btn btn-success" value="Objavi Oglas">
            </div>
          </div>
        </div>
      </div>
        
      
    </form><br><br>

  @endif

  {{-- </div> kraj diva .sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1--}}

  <script type="text/javascript" src="{{ asset('js/autojq/novioglas.js') }}"></script>
  <script type="text/javascript">
    var token = '{{ Session::token() }}';
    //ruta ka metodu izvadimodele OglasControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodele') }}'; 
    //varijabla potrebna da bi novioglas.js mogao da napravi src atribute img-ovima koji prikazuju close ikone
    var slikeurl = '{{ url('/') }}';
    //ove varijable su potrebne da bi novioglas.js mogao da obbrise tabelu sa podatcima usera ciji je profil koja je na vrhu i nacrta div koji ce
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

  </script>
  

@endsection