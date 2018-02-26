@extends('layouts.app')

{{--vju se koristi da admin moze da radi sa odobrenim ili neodobrenim oglasima korisnika, vraca ga metod adminoglasioilin() OglasControllera
i u njega salje odobrene ili neodobrene oglase, takodje ima formu za pretragu oglasa koja gadja metod adminoglasipretraga() koji kad prona-
dje oglase takodje vraca ovaj vju--}}

@section('content')
  
  {{-- ako je vju vracen iz metoda adminoglasioilin() OglasControllera onda ove varijable ne postoje pa je to izazivalo error pa ih zbog
  toga ovde definisem --}}
  @php
  if(!isset($markaautomobila)){
    $markaautomobila = '';
  }
  if(!isset($modeli)){
    $modeli = '';
  }
  if(!isset($modelpretraga)){
    $modelpretraga = '';
  }
  if(!isset($gorivo)){
    $gorivo = '';
  }
  if(!isset($godisteod)){
    $godisteod = '';
  }
  if(!isset($godistedo)){
    $godistedo = '';
  }
  if(!isset($poreklo)){
    $poreklo = '';
  }
  if(!isset($kubikazaod)){
    $kubikazaod = '';
  }
  if(!isset($kubikazado)){
    $kubikazado = '';
  }
  @endphp
  
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
 
  {{--if koji proverava da li je vju pozvan iz metoda adminoglasioilin() ili iz adminoglasipretraga() OglasControllera--}}
  @if($method ==1)
    {{-- ako je pozvan iz metoda adminoglasioilin() onda se forma ne vidi tj div u kom je ima atribut hidden a h1 ima shadow klasu --}}
    <h1 class="text-center naslovprikaziformuzapretragu shadow">Pretraga Oglasa</h1>
    <div id="adminoglasiformazapretragu" hidden="true">
  @else
    {{-- ako je pozvan iz metoda adminoglasipretraga() onda se forma vidi tj div u kom je nema atribut hidden a h1 nema shadow klasu jer 
    je user vec pretrazivao oglase --}}
    <h1 class="text-center naslovprikaziformuzapretragu">Pretraga Oglasa</h1>
    <div id="adminoglasiformazapretragu">
  @endif {{--kraj if-a koji proverava da li je vju pozvan iz metoda adminoglasioilin() ili iz adminoglasipretraga()--}}

    {{-- hendler za klik na ovu ikonu je u admioglasoilin.js i on divu adminoglasiformazapretragu dodaje attr hidden="true"--}}
    <div class="row">
      <img src="{{ asset('img/closeplava.png') }}" style="margin-right: 20px;" class="pull-right closebtn zatvoriformuzapretragu">
    </div>
      
    {{-- forma za pretragu odobrenih ili neodobrenih oglasa --}}
    <form role="form" method="GET" action="{{ url('/adminoglasipretraga') }}">
      {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
      <input type="hidden" name="oilin" id="oilin" value="{{ $oilin }}"> 
      <div class="row">

        {{-- polje za marku --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm">
            <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-info">Marka Automobila</label>
            <select name="markaautomobila" id="markaautomobila" class="form-control obaveznopolje">
              <option></option>
              @foreach ($marke as $marka)
                <option markaid="{{ $marka->id }}" value="{{ $marka->name }}" {{ $markaautomobila == $marka->name ? 'selected' : '' }}>{{ $marka->name }}</option>
              @endforeach
            </select>
            @if ($errors->has('markaautomobila'))
              <span class="help-block">
                <strong>{{ $errors->first('markaautomobila') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za model --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm">
            <label for="modelmarke" id="modelautomobilalabel" class="control-label text-info" id="labelzamodel">Model</label>
            <div id="modelmarkeselect">
              <select name="modelmarke" id="modelmarke" class="form-control obaveznopolje">
                @if($modeli == '')
                  <option id="prazanoptionzamodele"></option>
                @else
                  <option></option>
                  @foreach($modeli as $model)
                    <option value="{{ $model->ime }}" {{ $modelpretraga == $model->ime ? 'selected' : '' }}>{{ $model->ime }}</option>
                  @endforeach
                  <option value="ostalo">Ostalo...</option>
                @endif
              </select>
            </div>
            @if ($errors->has('modelmarke'))
              <span class="help-block">
                <strong>{{ $errors->first('modelmarke') }}</strong>
              </span>
            @endif
          </div>
        </div>
        {{-- polje za gorivo --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('gorivo') ? ' has-error' : '' }}">
            <label for="gorivo" id="gorivolabel" class="control-label text-info">Gorivo</label>
            <select name="gorivo" id="gorivo" value="{{ old('gorivo') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="benzin" {{ $gorivo == 'benzin' ? 'selected' : '' }}>Benzin</option>
              <option value="dizel" {{ $gorivo == 'dizel' ? 'selected' : '' }}>Dizel</option>
              <option value="benzingas" {{ $gorivo == 'benzingas' ? 'selected' : '' }}>Benzin + Gas(TNG)</option>
              <option value="metan" {{ $gorivo == 'metan' ? 'selected' : '' }}>Metan CNG</option>
              <option value="elektricni" {{ $gorivo == 'elektricni' ? 'selected' : '' }}>Električni Pogon</option>
              <option value="hibrid" {{ $gorivo == 'hibrid' ? 'selected' : '' }}>Hibridni Pogon</option>
            </select>
          </div>
        </div>
        @php
          $g = 2017;
        @endphp
        {{-- polje za godiste od --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('') ? ' has-error' : '' }}">
            <label for="godisteod" id="godisteod" class="control-label text-info">Godište od</label>
            <select name="godisteod" id="godisteod" value="{{ old('') }}" class="form-control">
              <option></option>
              @for($g; $g >= 1930; $g--)
                <option value="{{ $g }}" {{ $g == $godisteod ? 'selected' : '' }}>{{ $g }}</option>
              @endfor
            </select>
            @if ($errors->has('godisteod'))
              <span class="help-block">
                <strong>{{ $errors->first('') }}</strong>
              </span>
            @endif
          </div>
        </div>
        @php
          $g1 = 2017;
        @endphp
        {{-- polje za godiste do --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm {{ $errors->has('') ? ' has-error' : '' }}">
            <label for="godistedo" id="godistedo" class="control-label text-info">Godište do</label>
            <select name="godistedo" id="godisteod" value="{{ old('') }}" class="form-control">
              <option></option>
              @for($g1; $g1 >= 1930; $g1--)
                <option value="{{ $g1 }}"  {{ $g1 == $godistedo ? 'selected' : '' }}>{{ $g1 }}</option>
              @endfor
            </select>
            @if ($errors->has('godistedo'))
              <span class="help-block">
                <strong>{{ $errors->first('') }}</strong>
              </span>
            @endif
          </div>
        </div>

      </div>{{--kraj div-a .row--}} 

      <div class="row">

        {{-- polje za poreklo --}}
        <div class="col-md-3">
          <div class="form-group form-group-sm">
            <label for="poreklo" id="poreklolabel" class="control-label text-info">Poreklo</label>
            <select name="poreklo" id="poreklo" value="{{ old('poreklo') }}" class="form-control obaveznopolje">
              <option></option>
              <option value="dt" {{ $poreklo == 'dt' ? 'selected' : '' }}>Domace tablice</option>
              <option value="st" {{ $poreklo == 'st' ? 'selected' : '' }}>Strane tablice</option>
              <option value="nik" {{ $poreklo == 'nik' ? 'selected' : '' }}>Na ime kupca</option>
            </select>
          </div>
        </div>
        {{-- polje za kubikazu od --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label for="kubikazaod" id="kubikazaodlabel" class="control-label text-info">Kubikaža od</label>
            <select name="kubikazaod" id="kubikazaod" class="form-control obaveznopolje">
              <option></option>
              <option value="500" {{ $kubikazaod == '500' ? 'selected' : '' }}>500 cm<sup>3</sup></option>
              <option value="1150" {{ $kubikazaod == '1150' ? 'selected' : '' }}>1150 cm<sup>3</sup></option>
              <option value="1300" {{ $kubikazaod == '1300' ? 'selected' : '' }}>1300 cm<sup>3</sup></option>
              <option value="1600" {{ $kubikazaod == '1600' ? 'selected' : '' }}>1600 cm<sup>3</sup></option>
              <option value="1800" {{ $kubikazaod == '1800' ? 'selected' : '' }}>1800 cm<sup>3</sup></option>
              <option value="2000" {{ $kubikazaod == '2000' ? 'selected' : '' }}>2000 cm<sup>3</sup></option>
              <option value="2500" {{ $kubikazaod == '2500' ? 'selected' : '' }}>2500 cm<sup>3</sup></option>
              <option value="3000" {{ $kubikazaod == '3000' ? 'selected' : '' }}>3000 cm<sup>3</sup></option>
              <option value="3500" {{ $kubikazaod == '3500' ? 'selected' : '' }}>3500 cm<sup>3</sup></option>
              <option value="4000" {{ $kubikazaod == '4000' ? 'selected' : '' }}>4000 cm<sup>3</sup></option>
              <option value="4500" {{ $kubikazaod == '4500' ? 'selected' : '' }}>4500 cm<sup>3</sup></option>
            </select>
          </div>
        </div>
        {{-- polje za kubikazu od --}}
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <label for="kubikazado" id="kubikazadolabel" class="control-label text-info">Kubikaža do</label>
            <select name="kubikazado" id="kubikazado" class="form-control obaveznopolje">
              <option></option>
              <option value="500" {{ $kubikazado == '500' ? 'selected' : '' }}>500 cm<sup>3</sup></option>
              <option value="1150" {{ $kubikazado == '1150' ? 'selected' : '' }}>1150 cm<sup>3</sup></option>
              <option value="1300" {{ $kubikazado == '1300' ? 'selected' : '' }}>1300 cm<sup>3</sup></option>
              <option value="1600" {{ $kubikazado == '1600' ? 'selected' : '' }}>1600 cm<sup>3</sup></option>
              <option value="1800" {{ $kubikazado == '1800' ? 'selected' : '' }}>1800 cm<sup>3</sup></option>
              <option value="2000" {{ $kubikazado == '2000' ? 'selected' : '' }}>2000 cm<sup>3</sup></option>
              <option value="2500" {{ $kubikazado == '2500' ? 'selected' : '' }}>2500 cm<sup>3</sup></option>
              <option value="3000" {{ $kubikazado == '3000' ? 'selected' : '' }}>3000 cm<sup>3</sup></option>
              <option value="3500" {{ $kubikazado == '3500' ? 'selected' : '' }}>3500 cm<sup>3</sup></option>
              <option value="4000" {{ $kubikazado == '4000' ? 'selected' : '' }}>4000 cm<sup>3</sup></option>
              <option value="4500" {{ $kubikazado == '4500' ? 'selected' : '' }}>4500 cm<sup>3</sup></option>
            </select>
          </div>
        </div>

      </div>{{--kraj div-a .row--}} 

      {{-- submit btn --}}
      <div class="row">
        <div class="col-md-2">
          <div class="form-group form-group-sm">
            <div id="submitbtndiv">
              <input type="submit" id="objavioglas" name="objavioglas" class="sabmint btn btn-success" value="Pretraži">
            </div>
          </div>
        </div>
      </div>

    </form>
  </div> {{--kraj div-a #adminoglasiformazapretragu--}}
  

  {{-- ako admin hoce da radi sa odobrenim oglasima tj adminoglasioilin() je dobio u requestu $oilin == 1 --}}
  @if($oilin == 1)
    <h1>Odobreni Oglasi ({{$oglasaukupno}})</h1>
  @else {{-- ako admin hoce da radi sa neodobrenim oglasima tj adminoglasioilin() je dobio u requestu $oilin == 0 --}}
  	<h1>Neodobreni Oglasi ({{$oglasaukupno}})</h1>
  @endif

  <div class="row">
    @if(count($oglasi) == 0) 

      @if($oilin == 1)
        <h1>Nema Odobrenih Oglasa</h1>
      @else 
        <h1>Nema Neodobrenih Oglasa</h1>
      @endif

    @else
      {{-- sortiranje prikazanih oglasa, hendler za promenu selecta tj sortiranje je u adminoglasioilin.js --}}
      <div class="row">
        <div class="col-md-3">
          <div class="form-group form-group-sm">
            <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-info">Sortiraj oglase po:</label>
            <select class="sortiranjeoglasa">
              <option sort="created_at" ascdesc="DESC" {{ ($sort == 'created_at' && $ascdesc == 'DESC') ? 'selected' : ''}}>Datumu postavljanja silazno</option>
              <option sort="created_at" ascdesc="ASC" {{ ($sort == 'created_at' && $ascdesc == 'ASC') ? 'selected' : ''}}>Datumu postavljanja uzlazno</option>
              <option sort="godiste" ascdesc="DESC" {{ ($sort == 'godiste' && $ascdesc == 'DESC') ? 'selected' : ''}}>Godištu silazno</option>
              <option sort="godiste" ascdesc="ASC" {{ ($sort == 'godiste' && $ascdesc == 'ASC') ? 'selected' : ''}}>Godištu uzlazno</option>
              <option sort="cena" ascdesc="DESC" {{ ($sort == 'cena' && $ascdesc == 'DESC') ? 'selected' : ''}}>Ceni silazno</option>
              <option sort="cena" ascdesc="ASC" {{ ($sort == 'cena' && $ascdesc == 'ASC') ? 'selected' : ''}}>Ceni uzlazno</option>
            </select> 
          </div>
        </div>
      </div>

      {{-- prikazivanje oglasa koje je vratio kontroller --}}
      <div class="col-lg-6 col-md-6 {{ $oilin == 0 ? 'neodobrenioglasi' : 'odobrenioglasi'}}">
        @php
          $b = 0;
        @endphp
        @foreach($oglasi as $o)
          <div class="{{ $oilin == 0 ? 'neodobrenoglas' : 'odobrenoglas'}} oilinoglasdiv" id="oglas{{ $o->id }}">
            @php
              $slugmarkeoglasa = str_slug($o->marka);
            @endphp
            <h4>
              <img class="logomarkeoglasaprofil" src="{{ asset("img/autologo/$slugmarkeoglasa.png") }}"> &nbsp;
               &nbsp;
              @if($o->slike != 0)
                @php
                  //for($i = 1; $i <= $o->slike; $i++){
                  for($i = 1; $i <= 12; $i++){
                    if(file_exists("img/oglasi/$o->folderslike/$o->id/$i.jpg")){
                      echo "<img src='".url('/')."/img/oglasi/".$o->folderslike."/".$o->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='adminoglasislika img-thumbnail'>";
                      break;
                    }
                  }
                @endphp
              @else
                <img src="{{ asset("img/no_image_available.jpg") }}" class="img-thumbnail adminoglasislika">
              @endif  
              &nbsp;
              {{ $o->naslov }}      
            </h4>

            <div class="podatcioglasaspoljni">
              <p>
                <b>Postavljen</b> - {{ $o->created_at->format('d.m.Y') }}, 
                <b>Autor</b> - <a href="/profil/{{ $o->user->id }}" target="blank"><b>{{ $o->user->name }}</b></a>
              </p>
              <p>
                <b>Cena</b> - {{ $o->cena }} EUR, 
                <b>Godište</b> - {{  $o->godiste }} 
              </p>
              {{-- kad se klikne ovaj h4 hendler iz adminoglasi.js skida hidden atribut sa diva u kom su svi podatci oglasa --}}
              <h4 class="text-center svipodatcioglasa shadow" oglasoilin="{{ $o->odobren }}" oglasid="{{ $o->id }}" id="svipodatci{{ $o->id }}">
                Ostali Podatci
              </h4>
              {{-- skriven div u kom su svi podatci oglasa i slike --}}
              <div id="podatcioglasa{{ $o->id }}" class="skriven" hidden="true">
                <img class="pull-right zatvorisvepodatkeoglasa" oglasid="{{ $o->id }}" oglasoilin="{{ $o->odobren }}" id="zatvorisvepodatke{{ $o->id }}" src="{{ asset("img/redclose.png") }}">
                {{-- btn - i za edit oglasa, brisanje oglasa i zabranjivanje ili odobravanje oglasa --}}
                <br>
                <a id="aktiviraj" class="bezdekoracije" href="{{ url('izmenioglasforma/'.$o->id.'/'.$o->user_id) }}">
                  <button type="button" class="btn btn-primary oglasbtnprofilblade">
                    Izmeni&nbsp;&nbsp; Oglas
                  </button>
                </a>
                <button type="button" class="btn btn-danger obrisioglas oglasbtnprofilblade" idoglasa="{{ $o->id }}" id="obrisioglasbtn{{ $o->id }}">
                  Obriši&nbsp;&nbsp;&nbsp; Oglas
                </button>
                {{-- ako je oglas odobren btn za zabranu oglasa a ako je neodobren btn za odobravanje oglasa --}}
                @if($oilin == 1)
                  <button type="button" id="zabranioglasbtn{{ $o->id }}" class="btn btn-warning zabranioglasadminoglasi" oglasid="{{ $o->id }}">
                    Zabrani Oglas
                  </button>
                @else
                  <button type="button" id="odobrioglasbtn{{ $o->id }}" class="btn btn-success odobrioglasadminoglasi" oglasid="{{ $o->id }}">
                    Odobri Oglas
                  </button>
                @endif    
                <br>
                {{-- ako oglas ima slike prikazujemo ih --}}
                @if($o->slike != 0)
                <div class="divoglasslikeadminoglasi" id="o{{ $o->id }}slike">
                  <b>Slika</b> {{ $o->slike }}<br>
                  @php
                    $sada = date('Y-m-d H:i:s');
                  @endphp
                  @for($i = 1; $i <= 12; $i++)
                    @if(file_exists("img/oglasi/$o->folderslike/$o->id/$i.jpg"))
                      <img src="{{ asset("img/oglasi/$o->folderslike/$o->id/thumb$i.jpg?vreme=$sada") }}" class="oglasslikeadminoglasi">
                    @endif
                  @endfor
                </div>
                @endif
                {{-- podatci oglasa tj kolone 'oglasis' tabele koje nisu prikazane na vrhu --}}
                <p>
                  <b>Marka i Model</b> {{ $o->marka }}/{{ $o->model }}
                  <b>Karoserija</b> {{ $o->karoserija }}
                  <b>Kubikaža</b> {{ $o->kubikaza }} 
                  <b>Snaga KS/KW</b> {{ $o->snagaks }}/{{ $o->snagakw }}
                  <b>Kilometraža</b> {{ $o->kilometraza }}
                  <b>Gorivo</b> {{ $o->gorivo }}
                  <b>EKlasa</b> {{ $o->emisionaklasa }}
                  <b>Pogon</b> 
                  @if($o->pogon == 'p')
                    prednji
                  @elseif($o->pogon == 'z')
                    zadnji 
                  @elseif($o->pogon == '4x4')
                    4 x 4  
                  @elseif($o->pogon == '4x4r') 
                    4 x 4 reduktor  
                  @endif
                  <b>Menjač</b>
                  @if($o->menjac == 'm4')
                    man. 4 brzine 
                  @elseif($o->menjac == 'm5')
                    man. 5 brzina 
                  @elseif($o->menjac == 'm6')
                    man. 6 brzina
                  @elseif($o->menjac == 'pa')
                    poluautomatski 
                  @elseif($o->menjac == 'a')
                    automatski
                  @endif
                  @if($o->ostecen == 1)
                    <b class="text-danger">vozilo je ošteceno</b> 
                  @elseif($o->ostecen == 2)
                    <b class="text-danger">nije u voznom stanju</b>
                  @endif
                  <b>Br Vrata</b>
                  @if($o->brvrata == 3)
                    2/3 
                  @elseif($o->brvrata == 4)
                   4/5 
                  @endif
                  <b>Br Sedišta</b> {{ $o->brsedista }}
                  <b>Volan</b> {{ $o->strvolana == 'l' ? 'levi' : 'desni' }}
                  <b>Klima</b>
                  @if($o->klima == '0')
                    nema klimu
                  @elseif($o->klima == 'mk')
                    manuelna klima 
                  @elseif($o->klima == 'ak')
                    automatska klima 
                  @endif
                  <b>Boja</b> {{ $o->boja }}
                  <b>Poreklo</b>
                  @if($o->poreklo == 'dt')
                    domace tablice
                  @elseif($o->poreklo == 'st')
                    strane tablice
                  @elseif($o->poreklo == 'nik')
                    na ime kupca
                  @endif
                </p>
                <p><b>Sigurnost</b> {{ $o->sigurnost }}</p>
                <p><b>Oprema</b> {{ $o->oprema }}</p>
                <p><b>Stanje</b> {{ $o->stanje }}</p>
                <p><b>Tekst</b> {{ $o->tekst }} </p>
              </div> {{--kraj div .skriven--}}
            </div>  {{--kraj div .podatcioglasaspoljni--}}

          </div><hr> {{--kraj div .oilinoglasdiv--}}
          {{-- povecavamo brojac za 1 --}}
          @php
            $b++;
          @endphp  
          {{-- ako je prikazao 3 oglasa pravimo novi div col-lg-6 koji ce biti pored prvog da bi bile 2 --}}
          @if($b == 3)
            </div> {{--kraj div .col-lg-6 col-md-6 neodobrenioglasi--}}
            <div class="col-lg-6 col-md-6 {{ $oilin == 0 ? 'neodobrenioglasi' : 'odobrenioglasi'}}">
          @endif
        @endforeach
      </div> {{--kraj div .col-lg-6 col-md-6 neodobrenioglasi--}}
  </div> {{--kraj div .row--}}

   {{-- linkovi za paginaciju ako je vju pozvan iz metoda adminoglasioilin() OglasControllera --}}
    @if($method == 1)
      <ul class="pager">
        {!! $oglasi->appends(['sort' => $sort, 'ascdesc' => $ascdesc])->links() !!} 
      </ul>
    @else
      {{-- linkovi za paginaciju ako je vju pozvan iz metoda adminoglasipretraga() OglasControllera tj. ako je admin sabmitovao formu za pretragu --}}
      <ul class="pager">
        {!! $oglasi->appends(['sort' => $sort, 'ascdesc' => $ascdesc, 'oilin' => $oilin, 'markaautomobila' => $markaautomobila, 'modelmarke' => $modelpretraga, 'gorivo' => $gorivo, 'godisteod' => $godisteod, 'godistedo' => $godistedo, 'poreklo' => $poreklo, 'kubikazaod' => $kubikazaod, 'kubikazado' => $kubikazado])->links() !!} 
      </ul>
    @endif
      

    @endif
  

  </div> {{--kraj div .sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1--}}  

  <script type="text/javascript" src="{{ asset('js/autojq/adminoglasioilin.js') }}"></script>
  <script type="text/javascript">
    var token = '{{ Session::token() }}';
    var urlbrisilogo = '{{ route('obrisilogo') }}'; 
    var urlodobrioglas = '{{ route('odobrioglas') }}';
    var urlzabranioglas = '{{ route('zabranioglas') }}';  
    var urlobrisioglas = '{{ route('obrisioglas') }}';
    //ruta ka metodu izvadimodele OglasControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodele') }}'; 
    //varijable potrebne hendleru za promenu selecta za sortiranje prikazanih oglasa 
    var oilin = '{{ $oilin }}';
    var method = '{{ $method }}'; // ako je 1 onda ce se pozivati metod adminoglasioilin() a ako je 2 onda adminoglasipretraga()
    var adminoglasioilinurl = '{{ route('adminoglasioilin') }}';
    var adminoglasipretragaurl = '{{ route('adminoglasipretraga') }}';
    //ako je admin nesto pretrazivao ove variable nece biti '' tj neke od njih zavisno od toga koja je polja popunio u formi za pretragu 
    var markaautomobila = '{{ $markaautomobila }}';
    var modelmarke = '{{ $modelpretraga }}';
    var gorivo = '{{ $gorivo }}';
    var godisteod = '{{ $godisteod }}';
    var godistedo = '{{ $godistedo }}';
    var poreklo = '{{ $poreklo }}';
    var kubikazaod = '{{ $kubikazaod }}';
    var kubikazado = '{{ $kubikazado }}';
  </script>
@endsection