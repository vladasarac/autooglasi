@extends('layouts.app')

{{-- vju u kom je forma za izmenu oglasa, vju vraca metod izmenioglasforma() OglasControllera --}}

@section('content')
  
  {{-- div se koristi u izmenioglas.js da se izmeri sirina ekrana --}}
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

  {{-- <p>oglas user_id: {{ $oglas->user_id }}</p>
  <p>user id: {{ $user->id }}</p> --}}

  <h3 class="text-center">Popunite formu i izmenite oglas za vaše vozilo</h3><br>
  <div class="errorsuccess alert alert-danger text-center" role="alert">
    <b>Polja kojima je naslov crvene boje su OBAVEZNA.</b>
    <div class="errori"></div>
  </div>

  {{-- forma za dodavanje novog oglasa --}}
    <form role="form" method="POST" action="{{ url('/izmenioglas') }}" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
      <input type="hidden" name="oglas_id" id="oglas_id" value="{{ $oglas->id }}">
      <div>
        <h3>Osnovne informacije o vozilu</h3><hr>
      </div>

      <div class="row">
        {{-- polje za naslov oglasa, obavezno --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('naslovoglasa') ? ' has-error' : '' }}">
            <label for="naslovoglasa" id="naslovoglasalabel" class="control-label text-danger">Naslov Oglasa</label>
            <input type="text" class="form-control obaveznopolje" name="naslovoglasa" id="naslovoglasa" value="{{ $oglas->naslov }}">
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
                <option markaid="{{ $marka->id }}" value="{{ $marka->name }}" {{ $marka->name == $oglas->marka ? 'selected' : '' }}>
                  {{ $marka->name }}
                </option>
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
                @foreach($modelimarke as $modelmarke)
                  <option value="{{ $modelmarke->ime }}" {{ $modelmarke->ime == $oglas->model ? 'selected' : '' }}>
                    {{ $modelmarke->ime }}  
                  </option>
                @endforeach
                <option value="ostalo">Ostalo...</option>
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
            <input type="text" class="form-control obaveznopolje" name="cena" id="cena" value="{{ $oglas->cena }}">
            @if ($errors->has('cena'))
              <span class="help-block">
                <strong>{{ $errors->first('cena') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div> {{--kraj div-a row--}}

      <div class="row">
        {{-- polje za godiste, obavezno, ovde koristim laravelcollective paket --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm {{ $errors->has('godiste') ? ' has-error' : '' }}">
            <label for="godiste" id="godistelabel" class="control-label text-danger">Godište</label>
            {{ Form::selectYear('godiste', 2017, 1930, $oglas->godiste, ['class' => 'form-control obaveznopolje', 'id' => 'godiste']) }}
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
              <option value="limuzina" {{ $oglas->karoserija == 'limuzina' ? 'selected' : '' }}>Limuzina</option>
              <option value="hecbek" {{ $oglas->karoserija == 'hecbek' ? 'selected' : '' }}>Hečbek</option>
              <option value="karavan" {{ $oglas->karoserija == 'karavan' ? 'selected' : '' }}>Karavan</option>
              <option value="kupe" {{ $oglas->karoserija == 'kupe' ? 'selected' : '' }}>Kupe</option>
              <option value="kabriolet" {{ $oglas->karoserija == 'kabriolet' ? 'selected' : '' }}>Kabriolet</option>
              <option value="minivan" {{ $oglas->karoserija == 'minivan' ? 'selected' : '' }}>Mini Van</option>
              <option value="suv" {{ $oglas->karoserija == 'suv' ? 'selected' : '' }}>SUV</option>
              <option value="pickup" {{ $oglas->karoserija == 'pickup' ? 'selected' : '' }}>Pickup</option>
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
            <input type="text" class="form-control obaveznopolje" name="kubikaza" id="kubikaza" value="{{ $oglas->kubikaza }}">
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
            <input type="text" class="form-control obaveznopolje" name="snagaks" id="snagaks" value="{{ $oglas->snagaks }}">
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
            <input type="text" class="form-control obaveznopolje" name="snagakw" id="snagakw" value="{{ $oglas->snagakw }}">
            @if ($errors->has('snagakw'))
              <span class="help-block">
                <strong>{{ $errors->first('snagakw') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div> {{--kraj div-a row--}}

      <div class="row"> 
        {{-- polje za kilometrazu, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('kilometraza') ? ' has-error' : '' }}">
            <label for="kilometraza" id="kilometrazalabel" class="control-label text-danger">Kilometraža</label>
            <input type="text" class="form-control obaveznopolje" name="kilometraza" value="{{ $oglas->kilometraza }}" id="kilometraza">
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
              <option value="benzin" {{ $oglas->gorivo == 'benzin' ? 'selected' : '' }}>Benzin</option>
              <option value="dizel" {{ $oglas->gorivo == 'dizel' ? 'selected' : '' }}>Dizel</option>
              <option value="benzingas" {{ $oglas->gorivo == 'benzingas' ? 'selected' : '' }}>Benzin + Gas(TNG)</option>
              <option value="metan" {{ $oglas->gorivo == 'metan' ? 'selected' : '' }}>Metan CNG</option>
              <option value="elektricni" {{ $oglas->gorivo == 'elektricni' ? 'selected' : '' }}>Električni Pogon</option>
              <option value="hibrid" {{ $oglas->gorivo == 'hibrid' ? 'selected' : '' }}>Hibridni Pogon</option>
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
              <option value="euro1" {{ $oglas->emisionaklasa == 'euro1' ? 'selected' : '' }}>Euro 1</option>
              <option value="euro2" {{ $oglas->emisionaklasa == 'euro2' ? 'selected' : '' }}>Euro 2</option>
              <option value="euro3" {{ $oglas->emisionaklasa == 'euro3' ? 'selected' : '' }}>Euro 3</option>
              <option value="euro4" {{ $oglas->emisionaklasa == 'euro4' ? 'selected' : '' }}>Euro 4</option>
              <option value="euro5" {{ $oglas->emisionaklasa == 'euro5' ? 'selected' : '' }}>Euro 5</option>
              <option value="euro6" {{ $oglas->emisionaklasa == 'euro6' ? 'selected' : '' }}>Euro 6</option>
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
              <option value="p" {{ $oglas->pogon == 'p' ? 'selected' : '' }}>Prednji</option>
              <option value="z" {{ $oglas->pogon == 'z' ? 'selected' : '' }}>Zadnji</option>
              <option value="4x4" {{ $oglas->pogon == '4x4' ? 'selected' : '' }}>4x4</option>
              <option value="4x4r" {{ $oglas->pogon == '4x4r' ? 'selected' : '' }}>4x4 reduktor</option>
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
              <option value="m4" {{ $oglas->menjac == 'm4' ? 'selected' : '' }}>Manuelni 4 brzine</option>
              <option value="m5" {{ $oglas->menjac == 'm5' ? 'selected' : '' }}>Manuelni 5 brzina</option>
              <option value="m6" {{ $oglas->menjac == 'm6' ? 'selected' : '' }}>Manuelni 6 brzina</option>
              <option value="pa" {{ $oglas->menjac == 'pa' ? 'selected' : '' }}>Poluautomatski</option>
              <option value="a" {{ $oglas->menjac == 'a' ? 'selected' : '' }}>Automatski</option>
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
              <option value="0" {{ $oglas->ostecen == 0 ? 'selected' : '' }}>Ne</option>
              <option value="1" {{ $oglas->ostecen == 1 ? 'selected' : '' }}>Da</option>
              <option value="2" {{ $oglas->ostecen == 2 ? 'selected' : '' }}>Nije u voznom stanju</option>
            </select>
            @if ($errors->has('ostecen'))
              <span class="help-block">
                <strong>{{ $errors->first('ostecen') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div> {{--kraj div-a row--}}

      <div class="row">     
        {{-- polje za br vrata, obavezno --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('brvrata') ? ' has-error' : '' }}">
            <label for="brvrata" id="brvratalabel" class="control-label text-danger">Broj Vrata</label>
            <select name="brvrata" id="brvrata" value="{{ old('brvrata') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="3" {{ $oglas->brvrata == 3 ? 'selected' : '' }}>2/3 vrata</option>
              <option value="4" {{ $oglas->brvrata == 4 ? 'selected' : '' }}>4/5 vrata</option>
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
              <option value="2" {{ $oglas->brsedista == 2 ? 'selected' : '' }}>2 Sedišta</option>
              <option value="3" {{ $oglas->brsedista == 3 ? 'selected' : '' }}>3 Sedišta</option>
              <option value="4" {{ $oglas->brsedista == 4 ? 'selected' : '' }}>4 Sedišta</option>
              <option value="5" {{ $oglas->brsedista == 5 ? 'selected' : '' }}>5 Sedišta</option>
              <option value="6" {{ $oglas->brsedista == 6 ? 'selected' : '' }}>6 Sedišta</option>
              <option value="7" {{ $oglas->brsedista == 7 ? 'selected' : '' }}>7 Sedišta</option>
              <option value="8" {{ $oglas->brsedista == 8 ? 'selected' : '' }}>8 Sedišta</option>
              <option value="9" {{ $oglas->brsedista == 9 ? 'selected' : '' }}>9 Sedišta</option>
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
              <option value="l" {{ $oglas->strvolana == 'l' ? 'selected' : '' }}>Levi Volan</option>
              <option value="d" {{ $oglas->strvolana == 'd' ? 'selected' : '' }}>Desni Volan</option>
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
              <option value="0" {{ $oglas->klima == '0' ? 'selected' : '' }}>Nema Klimu</option>
              <option value="mk" {{ $oglas->klima == 'mk' ? 'selected' : '' }}>Manuelna Klima</option>
              <option value="ak" {{ $oglas->klima == 'ak' ? 'selected' : '' }}>Automatska Klima</option>
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
              <option value="bela" {{ $oglas->boja == 'bela' ? 'selected' : '' }}>Bela</option>
              <option value="bez" {{ $oglas->boja == 'bez' ? 'selected' : '' }}>Bež</option>
              <option value="bordo" {{ $oglas->boja == 'bordo' ? 'selected' : '' }}>Bordo</option>
              <option value="braon" {{ $oglas->boja == 'braon' ? 'selected' : '' }}>Braon</option>
              <option value="crna" {{ $oglas->boja == 'crna' ? 'selected' : '' }}>Crna</option>
              <option value="crvena" {{ $oglas->boja == 'crvena' ? 'selected' : '' }}>Crvena</option>
              <option value="kameleon" {{ $oglas->boja == 'kameleon' ? 'selected' : '' }}>Kameleon</option>
              <option value="ljubicasta" {{ $oglas->boja == 'ljubicasta' ? 'selected' : '' }}>Ljubičasta</option>
              <option value="narandzasta" {{ $oglas->boja == 'narandzasta' ? 'selected' : '' }}>Narandžasta</option>
              <option value="plava" {{ $oglas->boja == 'plava' ? 'selected' : '' }}>Plava</option>
              <option value="siva" {{ $oglas->boja == 'siva' ? 'selected' : '' }}>Siva</option>
              <option value="srebrna" {{ $oglas->boja == 'srebrna' ? 'selected' : '' }}>Srebrna</option>
              <option value="tirkiz" {{ $oglas->boja == 'tirkiz' ? 'selected' : '' }}>Tirkiz</option>
              <option value="teget" {{ $oglas->boja == 'teget' ? 'selected' : '' }}>Teget</option>
              <option value="zelena" {{ $oglas->boja == 'zelena' ? 'selected' : '' }}>Zelena</option>
              <option value="zuta" {{ $oglas->boja == 'zuta' ? 'selected' : '' }}>Žuta</option>
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
              <option value="dt" {{ $oglas->poreklo == 'dt' ? 'selected' : '' }}>Domace tablice</option>
              <option value="st" {{ $oglas->poreklo == 'st' ? 'selected' : '' }}>Strane tablice</option>
              <option value="nik" {{ $oglas->poreklo == 'nik' ? 'selected' : '' }}>Na ime kupca</option>
            </select>
            @if ($errors->has('poreklo'))
              <span class="help-block">
                <strong>{{ $errors->first('poreklo') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div> {{--kraj div-a row--}}

      <div>
        <h3>Sigurnost</h3><hr>
      </div>

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Airbag/', $oglas->sigurnost)  ? 'checked' : '' }} id="airbag" name="airbag" value="airbag"> Airbag
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Child lock/', $oglas->sigurnost)  ? 'checked' : '' }} id="childlock" name="childlock" value="childlock"> Child lock
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/ABS/', $oglas->sigurnost)  ? 'checked' : '' }} id="abs" name="abs" value="abs"> ABS
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/ESP/', $oglas->sigurnost)  ? 'checked' : '' }} id="esp" name="esp" value="esp"> ESP
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/ASR/', $oglas->sigurnost)  ? 'checked' : '' }} id="asr" name="asr" value="asr"> ASR
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Alarm/', $oglas->sigurnost)  ? 'checked' : '' }} id="alarm" name="alarm" value="alarm"> Alarm
            </label>
          </div>
        </div>
      </div> {{--kraj div-a row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Kodiran ključ/', $oglas->sigurnost)  ? 'checked' : '' }} id="kodiranklj" name="kodiranklj" value="kodiranklj"> Kodiran ključ
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Blokada motora/', $oglas->sigurnost)  ? 'checked' : '' }} id="blokada" name="blokada" value="blokada"> Blokada motora
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Centralna brava/', $oglas->sigurnost)  ? 'checked' : '' }} id="centralna" name="centralna" value="centralna"> Centralna brava
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Zeder/', $oglas->sigurnost)  ? 'checked' : '' }} id="zeder" name="zeder" value="zeder"> Zeder
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
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Metalik boja/', $oglas->oprema)  ? 'checked' : '' }} id="metalik" name="metalik" value="metalik"> Metalik boja
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Servo volan/', $oglas->oprema)  ? 'checked' : '' }} id="servo" name="servo" value="servo"> Servo volan
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Multi volan/', $oglas->oprema)  ? 'checked' : '' }} id="multi" name="multi" value="multi"> Multi volan
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Tempomat/', $oglas->oprema)  ? 'checked' : '' }} id="tempomat" name="tempomat" value="tempomat"> Tempomat
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Putni računar/', $oglas->oprema)  ? 'checked' : '' }} id="racunar" name="racunar" value="racunar"> Putni računar
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Šiber/', $oglas->oprema)  ? 'checked' : '' }} id="siber" name="siber" value="siber"> Šiber
            </label>
          </div>
        </div> 
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Panorama krov/', $oglas->oprema)  ? 'checked' : '' }} id="panorama" name="panorama" value="panorama"> Panorama krov
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/El. podizači/', $oglas->oprema)  ? 'checked' : '' }} id="elpodizaci" name="elpodizaci" value="elpodizaci"> El. podizači
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/El. retrovizori/', $oglas->oprema)  ? 'checked' : '' }} id="elretrovizori" name="elretrovizori" value="elretrovizori"> El. retrovizori
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Grejači retrovizora/', $oglas->oprema)  ? 'checked' : '' }} id="gretrovizor" name="gretrovizor" value="gretrovizor"> Grejači retrovizora
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/El. podesiva sedišta/', $oglas->oprema)  ? 'checked' : '' }} id="elpodsed" name="elpodsed" value="elpodsed"> El. podesiva sedišta
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Grejanje sedišta/', $oglas->oprema)  ? 'checked' : '' }} id="grejanjesed" name="grejanjesed" value="grejanjesed"> Grejanje sedišta
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Svetla za maglu/', $oglas->oprema)  ? 'checked' : '' }} id="svmagla" name="svmagla" value="svmagla"> Svetla za maglu
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Xenon svetla/', $oglas->oprema)  ? 'checked' : '' }} id="xenon" name="xenon" value="xenon"> Xenon svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/LED svetla/', $oglas->oprema)  ? 'checked' : '' }} id="ledsvetla" name="ledsvetla" value="ledsvetla"> LED svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Senzori za svetla/', $oglas->oprema)  ? 'checked' : '' }} id="svsenz" name="svsenz" value="svsenz"> Senzori za svetla
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Senzori za kišu/', $oglas->oprema)  ? 'checked' : '' }} id="kisasenz" name="kisasenz" value="kisasenz"> Senzori za kišu
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Parking senzori/', $oglas->oprema)  ? 'checked' : '' }} id="parksenz" name="parksenz" value="parksenz"> Parking senzori
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Krovni nosač/', $oglas->oprema)  ? 'checked' : '' }} id="krnosac" name="krnosac" value="krnosac"> Krovni nosač
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Kuka za vuču/', $oglas->oprema)  ? 'checked' : '' }} id="kuka" name="kuka" value="kuka"> Kuka za vuču
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Alu. felne/', $oglas->oprema)  ? 'checked' : '' }} id="alufelne" name="alufelne" value="alufelne"> Alu. felne
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Navigacija/', $oglas->oprema)  ? 'checked' : '' }} id="navigacija" name="navigacija" value="navigacija"> Navigacija
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Radio/', $oglas->oprema)  ? 'checked' : '' }} id="radio" name="radio" value="radio"> Radio
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/CD Player/', $oglas->oprema)  ? 'checked' : '' }} id="cd" name="cd" value="cd"> CD Player
            </label>
          </div>
        </div>
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/DVD/', $oglas->oprema)  ? 'checked' : '' }} id="dvdtv" name="dvdtv" value="dvdtv"> DVD/TV
            </label>
          </div>
        </div>    
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Webasto/', $oglas->oprema)  ? 'checked' : '' }} id="webasto" name="webasto" value="webasto"> Webasto
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Grejači vetrobrana/', $oglas->oprema)  ? 'checked' : '' }} id="grejvetrobran" name="grejvetrobran" value="grejvetrobran"> Grejači vetrobrana
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Kožna sedišta/', $oglas->oprema)  ? 'checked' : '' }} id="koza" name="koza" value="koza"> Kožna sedišta
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
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Prvi vlasnik/', $oglas->stanje)  ? 'checked' : '' }} id="prvivlasnik" name="prvivlasnik" value="prvivlasnik"> Prvi vlasnik
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Kupljen nov/', $oglas->stanje)  ? 'checked' : '' }} id="novusr" name="novusr" value="novusr"> Kupljen nov u Srbiji
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Garancija/', $oglas->stanje)  ? 'checked' : '' }} id="garancija" name="garancija" value="garancija"> Garancija
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Garažiran/', $oglas->stanje)  ? 'checked' : '' }} id="garaza" name="garaza" value="garaza"> Garažiran
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Servisna knjiga/', $oglas->stanje)  ? 'checked' : '' }} id="servisknj" name="servisknj" value="servisknj"> Servisna knjiga
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Rezervni ključ/', $oglas->stanje)  ? 'checked' : '' }} id="rezklj" name="rezklj" value="rezklj"> Rezervni ključ
            </label>
          </div>
        </div>  
      </div>{{--kraj diva .row--}}

      <div class="row">
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Tuning/', $oglas->stanje)  ? 'checked' : '' }} id="tuning" name="tuning" value="tuning"> Tuning
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Oldtimer/', $oglas->stanje)  ? 'checked' : '' }} id="oldtimer" name="oldtimer" value="oldtimer"> Oldtimer
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Test vozilo/', $oglas->stanje)  ? 'checked' : '' }} id="test" name="test" value="test"> Test vozilo
            </label>
          </div>
        </div>
        {{--  --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label class="form-check-label text-success checkboxnovioglas">
              <input class="form-check-input checkboxnovioglas" type="checkbox" {{ preg_match('/Taxi/', $oglas->stanje)  ? 'checked' : '' }} id="taxi" name="taxi" value="taxi"> Taxi
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
            <textarea name="tekstoglasa" id="tekstoglasa" rows="5" class="form-control" placeholder="Ovde možete rečima opisati vaše vozilo i navesti dodatne informacije koje želite...">{{ $oglas->tekst }}</textarea>
          </div>
        </div>
      </div>
      {{-- ako oglas nema dodatih slika crtamo 12 inputa za upload slika za oglas --}}
      @if($oglas->slike == 0)
        @php 
          $dodatihinputazaslike = 0; 
          $mds = 12 - $brslika;
        @endphp
        <h3 class="text-danger">Do sada dodatih slika - {{ $brslika }}</h3>   
        <h3>Dodajte slike</h3><hr>
        <div class="row">
          @for($i = 1; $i <= 12; $i++)
            @php 
              $dodatihinputazaslike++; 
            @endphp
            @if(!file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg"))
              <div class="col-md-2">
                <div class="image-upload">
                  <label for="slika{{ $i }}" class="slikaupload">
                    <b>Slika {{ $i }}</b><br>
                    <img style="width: 150px; height: 80px;" id="slika{{ $i }}holder" src="{{ asset('img/kolasilueta2.png') }}"/>
                  </label>
                  <input id="slika{{ $i }}" name="slika{{ $i }}" type="file"/>
                </div>
              </div>
        @if($i == 6)
          </div><div class="row">
        @endif
            @endif
          @endfor
        </div>
      {{--ako oglas ima dodate slike --}}
      @else

        <div>
          <h3>Izmenite slike</h3><hr>
        </div>
        {{-- ako oglas ima 12 dodatih slika neke se moraju obrisati da bi se nove dodale --}}
        @if($oglas->slike == 12)
          <h3 class="text-danger maxslika">
            Imate <b class="brojdodatihslika">{{ $brslika }}</b> dodatih slika, ukoliko želite da dodate nove morate obrisati neke od već dodatih.
          </h3>
        @else{{--ako ima dodate slike ali ne maksimalnih 12--}}
          <h3 class="text-danger">
            Do sada dodatih slika - <b class="brojdodatihslika">{{ $brslika }}</b>
          </h3>     
        @endif 
        {{-- for petlja se vrti 12 puta i pokusava da redom prikaze slike, ako slika postoji prikazuje je ako ne nista... --}}
        <div class="prikazdodatihslika">
          @for($i = 1; $i <= 12; $i++)
            @if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg"))
              <div class="imgdiv col-md-3" id="card{{ $i }}">  
                <div class="card">
                  <img src="{{ asset('img/trash.png') }}"  idslike="{{ $i }}" class="text-center deleteizmenioglasimg" id="brisisliku{{ $i }}">
                  <span class="pull-right"><b>Slika {{ $i }}</b></span>
                  @php
                    $vreme = date('Y-m-d H:i:s');
                  @endphp
                  <img src="{{ asset("img/oglasi/$oglas->folderslike/$oglas->id/thumb$i.jpg?vreme=$vreme") }}" idslike="{{ $i }}" class="izmenioglasslike"> 
                </div>
              </div>
            @endif
          @endfor
        </div>    
        <div class="row"></div>
        {{-- $mds sluzi da znamo koliko slika je moguce dodati, varijablu saljemo u izmenioglas.js da je koristi --}}
        @php 
          $mds = 12 - $brslika;
        @endphp
        <h3>
          Mozete dodati slika - <b id="mds">{{ $mds }}</b>
        </h3><hr>
        {{-- ako oglas ima 12 tj maksimalan broj slika ne prikazujemo ni jedan input za upload slika ali crtamo 2 diva u koji ce se smestati
        inputi ako user obrise neke slike --}}
        @if($oglas->slike == 12)
          @php 
            $dodatihinputazaslike = 0; 
          @endphp 
          <div class="row redzaslike1"></div>
        {{-- ako oglas ima dodate slike ali manje od 12 --}}
        @else
          <div class="row redzaslike1">
            @php 
              $dodatihinputazaslike = 0; 
            @endphp   
            {{-- ide for petlja 12 puta i ako ne postoji slika $i.jpg za nju se crta upload file input --}}
            @for($i = 1; $i <= 12; $i++)     
              @if(!file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg"))
                @php 
                  $dodatihinputazaslike++; 
                @endphp
              <div class="col-md-2">
                <div class="image-upload">
                  <label for="slika{{ $i }}" class="slikaupload">
                    <b>Slika {{ $i }}</b><br>
                    <img style="width: 150px; height: 80px;" id="slika{{ $i }}holder" src="{{ asset('img/kolasilueta2.png') }}"/>
                  </label>
                  <input id="slika{{ $i }}" name="slika{{ $i }}" type="file"/>
                </div>
              </div>
        {{-- ako je ovo 6. dodati input pravimo novi div .row u kom ce biti ostali inputi za upload slika --}}
        @if($dodatihinputazaslike == 6)
          </div>
          <div class="row redzaslike2">
        @endif
            @endif
            @endfor
          </div>   
        @endif  
        
      @endif

      {{-- {{ $dodatihinputazaslike }} --}}
      {{-- submit btn --}}
      <hr>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <div id="submitbtndiv">
              <input type="submit" id="objavioglas" name="objavioglas" class="sabmint btn btn-success" value="Izmeni Oglas">
            </div>
          </div>
        </div>
      </div>
    </form><br><br>


  <script type="text/javascript" src="{{ asset('js/autojq/izmenioglas.js') }}"></script>
  <script type="text/javascript">
    var token = '{{ Session::token() }}';  
    //ruta ka metodu izvadimodele OglasControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodele') }}'; 
    //ruta ka metodu za brisanje slike tj obrisisliku() OglasControllera koji se poziva kad se iznad neke dodate slike klikne kanta, ide AJAX
    //iz imenioglas.js 
    var obrisislikuurl = '{{ route('obrisisliku') }}';
    //ovo treba hendleru za brisanje slike iz izmenioglas.js da bi znao gde da doda novi input za upload slike posto kad jednu obrisemo onda
    //se pojavljuje input za upload nove slike
    var dodatihinputazaslike = '{{ $dodatihinputazaslike }}';
    //ovo nam treba kad brisemo sliku da nadjemo folder u kom je i usera kom pripada oglas kom brisemo sliku
    var userverification = '{{ $user->verification }}';
    var oglasid = '{{ $oglas->id }}';
    //
    var brslika = '{{ $brslika }}';
    var mds = '{{ $mds }}';
    //varijabla potrebna da bi izmenioglas.js mogao da napravi src atribute img-ovima
    var slikeurl = '{{ url('/') }}';
    //ove varijable su potrebne da bi izmenioglas.js mogao da obbrise tabelu sa podatcima usera ciji je profil koja je na vrhu i nacrta div koji ce
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