@extends('layouts.app')

@section('content')
  {{-- div se koristi u welcome.js da se izmeri sirina ekrana --}}
  <div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div> 
  {{-- variable koje salje metod pretraga() FrontControlelra potrebne da bi forma bila popunjene vrednostima koje su unete kad je radjena
  pretraga u welcome.blade.php --}}
  @php
    if(!isset($sort)){
      $sort = 'created_at';
    }
    if(!isset($ascdesc)){
      $ascdesc = 'DESC';
    }
    if(!isset($markaautomobila)){
      $markaautomobila = '';
    }
    if(!isset($modeli)){
      $modeli = '';
    }
    if(!isset($modelpretraga)){
      $modelpretraga = '';
    }
    if(!isset($gor)){
      $gor = '';
    }
    if(!isset($godod)){
      $godod = '';
    }
    if(!isset($goddo)){
      $goddo = '';
    }
    if(!isset($cod)){
      $cod = '';
    }
    if(!isset($cdo)){
      $cdo = '';
    }
    if(!isset($kar)){
      $kar = '';
    }  
    if(!isset($kubod)){
      $kubod = '';
    }
    if(!isset($kubdo)){
      $kubdo = '';
    }
    if(!isset($ost)){
      $ost = '';
    }  
    if(!isset($detpretr0ili1)){
      $detpretr0ili1 = '';
    }
    if(!isset($emkl)){
      $emkl = '';
    }
    if(!isset($snod)){
      $snod = '';
    }
    if(!isset($sndo)){
      $sndo = '';
    }
    if(!isset($kilod)){
      $kilod = '';
    }
    if(!isset($kildo)){
      $kildo = '';
    }
    if(!isset($poreklo)){
      $poreklo = '';
    }
    if(!isset($pog)){
      $pog = '';
    }
    if(!isset($menj)){
      $menj = '';
    }
    if(!isset($brvr)){
      $brvr = '';
    }
    if(!isset($brsed)){
      $brsed = '';
    }
    if(!isset($strvol)){
      $strvol = '';
    }
    if(!isset($kli)){
      $kli = '';
    }
    if(!isset($boja)){
      $boja = '';
    }
    if(!isset($por)){
      $por = '';
    }
    if(!isset($airb)){
      $airb = '';
    }
    if(!isset($cloc)){
      $cloc = '';
    }
    if(!isset($abs)){
      $abs = '';
    }
    if(!isset($esp)){
      $esp = '';
    }
    if(!isset($asr)){
      $asr = '';
    }
    if(!isset($alrm)){
      $alrm = '';
    }
    if(!isset($kodk)){
      $kodk = '';
    }
    if(!isset($zdr)){
      $zdr = '';
    }
    if(!isset($blkm)){
      $blkm = '';
    }
    if(!isset($cbr)){
      $cbr = '';
    }
    if(!isset($mboj)){
      $mboj = '';
    }
    if(!isset($svol)){
      $svol = '';
    }
    if(!isset($mvol)){
      $mvol = '';
    }
    if(!isset($tmpt)){
      $tmpt = '';
    }
    if(!isset($prac)){
      $prac = '';
    }
    if(!isset($sibr)){
      $sibr = '';
    }
    if(!isset($pkr)){
      $pkr = '';
    }
    if(!isset($elpo)){
      $elpo = '';
    }
    if(!isset($elr)){
      $elr = '';
    }
    if(!isset($gret)){
      $gret = '';
    }
    if(!isset($elps)){
      $elps = '';
    }
    if(!isset($gsed)){
      $gsed = '';
    }
    if(!isset($szm)){
      $szm = '';
    }
    if(!isset($xen)){
      $xen = '';
    }
    if(!isset($led)){
      $led = '';
    }
    if(!isset($senzzs)){
      $senzzs = '';
    }
    if(!isset($senzzk)){
      $senzzk = '';
    }
    if(!isset($senzzp)){
      $senzzp = '';
    }
    if(!isset($krno)){
      $krno = '';
    }
    if(!isset($kzv)){
      $kzv = '';
    }
    if(!isset($aluf)){
      $aluf = '';
    }
    if(!isset($nav)){
      $nav = '';
    }
    if(!isset($rdio)){
      $rdio = '';
    }
    if(!isset($cdp)){
      $cdp = '';
    }
    if(!isset($dvd)){
      $dvd = '';
    }
    if(!isset($wbs)){
      $wbs = '';
    }
    if(!isset($grve)){
      $grve = '';
    }
    if(!isset($koza)){
      $koza = '';
    }
    if(!isset($prv)){
      $prv = '';
    }
    if(!isset($knus)){
      $knus = '';
    }
    if(!isset($gar)){
      $gar = '';
    }
    if(!isset($garaz)){
      $garaz = '';
    }
    if(!isset($serknj)){
      $serknj = '';
    }
    if(!isset($rezklj)){
      $rezklj = '';
    }
    if(!isset($tun)){
      $tun = '';
    }
    if(!isset($old)){
      $old = '';
    }
    if(!isset($test)){
      $test = '';
    }
    if(!isset($taxi)){
      $taxi = '';
    }
    if(!isset($oglasikorisnika)){
      $oglasikorisnika = '';
    }
    if(!isset($imekorisnika)){
      $imekorisnika = '';
    }
  @endphp

  {{--  --}}
  <div class="col-md-10 col-md-offset-1 col-xs-12" style="background-color: #d9edf7;">
    <div>
      {{-- @include('forma.formapretraga') --}}
    </div>
    

    <h3 class="text-center naslovpretraga shadow">Pretraga <img src="{{ asset('img/searchcars1.png') }}" style="height:25px; width:25px;"></h3>
      {{-- osnovna forma za pretragu oglasa koja je ovde popunjena onim sto je uneto u formu za pretragu oglasa u welcome.blade.php --}}
      <div class="formapretraga" hidden="true">

        {{-- hendler za klik na ovu ikonu je u rezpretrage.js i on divu formapretraga dodaje attr hidden="true"--}}
        <div class="row">
          <img src="{{ asset('img/closeplava.png') }}" style="margin-right: 20px;" class="pull-right closebtn zatvoriformuzapretragu">
        </div>
        {{-- include-ujemo vju formapretraga.blade.php u kom je forma za pretragu --}}
        @include('forma.formapretraga')

      </div>{{--kraj diva .formapretraga--}}

      {{-- sortiranje prikazanih oglasa, hendler za promenu selecta tj sortiranje je u adminoglasioilin.js --}}
      <div class="row" style="margin-top: 15px;">
        <div class="col-md-6">
          <label class="text-info text-center">
            Ukupno pronadjeno {{ $oglasaukupno }} oglasa
            @if($imekorisnika != '')
              korisnika {{ $imekorisnika }}
            @endif
          </label>
          <div class="form-group form-group-sm">
            <label for="markaautomobila" id="markaautomobilalabel" class="control-label text-info">Sortiraj oglase po:</label>
            <select class="sortiranjeoglasa">
              <option sort="created_at" ascdesc="DESC" {{ ($sort == 'created_at' && $ascdesc == 'DESC') ? 'selected' : ''}}>Datumu postavljanja silazno</option>
              <option sort="created_at" ascdesc="ASC" {{ ($sort == 'created_at' && $ascdesc == 'ASC') ? 'selected' : ''}}>Datumu postavljanja uzlazno</option>
              <option sort="godiste" ascdesc="DESC" {{ ($sort == 'godiste' && $ascdesc == 'DESC') ? 'selected' : ''}}>Godištu silazno</option>
              <option sort="godiste" ascdesc="ASC" {{ ($sort == 'godiste' && $ascdesc == 'ASC') ? 'selected' : ''}}>Godištu uzlazno</option>
              <option sort="cena" ascdesc="DESC" {{ ($sort == 'cena' && $ascdesc == 'DESC') ? 'selected' : ''}}>Ceni silazno</option>
              <option sort="cena" ascdesc="ASC" {{ ($sort == 'cena' && $ascdesc == 'ASC') ? 'selected' : ''}}>Ceni uzlazno</option>
              <option sort="kubikaza" ascdesc="DESC" {{ ($sort == 'kubikaza' && $ascdesc == 'DESC') ? 'selected' : ''}}>Kubikaži silazno</option>
              <option sort="kubikaza" ascdesc="ASC" {{ ($sort == 'kubikaza' && $ascdesc == 'ASC') ? 'selected' : ''}}>Kubikaži uzlazno</option>
              <option sort="brpregleda" ascdesc="DESC" {{ ($sort == 'brpregleda' && $ascdesc == 'DESC') ? 'selected' : ''}}>Broju pregleda silazno</option>
              <option sort="brpregleda" ascdesc="ASC" {{ ($sort == 'brpregleda' && $ascdesc == 'ASC') ? 'selected' : ''}}>Broju pregleda uzlazno</option>
            </select> 
          </div>
        </div>

        {{--  --}}
        {{-- <div class="col-md-6 pull-right">
          <label class="text-info text-center">Ukupno pronadjeno {{ $oglasaukupno }} oglasa</label>
        </div> --}}

      </div>

      {{--prikaz oglasa--}}
      <div class="oglasipocetna">
        <div class="row">
        @foreach($oglasi as $oglas)
        {{-- link ka oglas.blade.php tj ka ruti '/oglas/{oglasid?}' tj ka metodu prikazioglas() FrontControllera koji prikazuje oglas
        , na link kacim sve parametre pretrage da bi ih kontroler poslao u oglas.blade.php da bi forma za pretragu opet bila popunj-
        -ena vec unetim parametrima --}}
          <a class="frontjedanoglaslink" href="{{ url('/oglas/'.$oglas->id.'?detpretr0ili1='.$detpretr0ili1.'&sort='.$sort.'&ascdesc='.$ascdesc.'&markaautomobila='.$markaautomobila.'&modelmarke='.$modelpretraga.'&gor='.$gor.'&godod='.$godod.'&goddo='.$goddo.'&cod='.$cod.'&cdo='.$cdo.'&kar='.$kar.'&kubod='.$kubod.'&kubdo='.$kubdo.'&ost='.$ost.'&emkl='.$emkl.'&snod='.$snod.'&sndo='.$sndo.'&kilod='.$kilod.'&kildo='.$kildo.'&poreklo='.$poreklo.'&pog='.$pog.'&menj='.$menj.'&brvr='.$brvr.'&brsed='.$brsed.'&strvol='.$strvol.'&kli='.$kli.'&boja='.$boja.'&por='.$por.'&airb='.$airb.'&cloc='.$cloc.'&abs='.$abs.'&esp='.$esp.'&asr='.$asr.'&alrm='.$alrm.'&kodk='.$kodk.'&zdr='.$zdr.'&blkm='.$blkm.'&cbr='.$cbr.'&mboj='.$mboj.'&svol='.$svol.'&mvol='.$mvol.'&tmpt='.$tmpt.'&prac='.$prac.'&sibr='.$sibr.'&pkr='.$pkr.'&elpo='.$elpo.'&elr='.$elr.'&gret='.$gret.'&elps='.$elps.'&gsed='.$gsed.'&szm='.$szm.'&xen='.$xen.'&led='.$led.'&senzzs='.$senzzs.'&senzzk='.$senzzk.'&senzzp='.$senzzp.'&krno='.$krno.'&kzv='.$kzv.'&aluf='.$aluf.'&nav='.$nav.'&rdio='.$rdio.'&cdp='.$cdp.'&dvd='.$dvd.'&wbs='.$wbs.'&grve='.$grve.'&koza='.$koza.'&prv='.$prv.'&knus='.$knus.'&gar='.$gar.'&garaz='.$garaz.'&serknj='.$serknj.'&rezklj='.$rezklj.'&tun='.$tun.'&old='.$old.'&test='.$test.'&taxi='.$taxi.'&oglasikorisnika='.$oglasikorisnika.'') }}">
          {{-- prikaz jednog oglasa --}}
          <div class="col-md-6 jedanoglas">
            <div class="col-md-5">
              @if($oglas->slike != 0)
                @php
                  for($i = 1; $i <= 12; $i++){
                    if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg")){
                        echo "<img src='".url('/')."/img/oglasi/".$oglas->folderslike."/".$oglas->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='naslovnaslikapocetna'>";
                        break;
                    }
                  }
                @endphp
              @else
                <img src="{{ asset("img/no_image_available1.jpg") }}" class="naslovnaslikapocetna">
              @endif
            </div> {{--kraj div-a .col-md-5--}}
            <div class="col-md-7 divosnovnipodatcioglasanaslovna">
              <div>
                {{-- <b>{{ $oglas->naslov }}</b> --}}
                <b>{{ $oglas->marka }}/{{ $oglas->model }}</b>
                &nbsp; <span class="cenanaslovna pull-right">{{ $oglas->cena }} &euro;</span>
                <p class="posnovnipodatcioglasanaslovna">
                <small>Postavljen: <b>{{ $oglas->created_at->format('d.m.Y.') }}</b></small>
                @if($oglas->ostecen == 1)
                  &nbsp; <small style="color: red;"><b>Oštećen</b></small>
                @elseif($oglas->ostecen == 2)
                  &nbsp; <small style="color: red;"><b>Oštećen 100%</b></small>
                @endif
                <br>
                <b>
                <small class="small">
                  @if($oglas->gorivo == 'dizel')
                    Dizel
                  @elseif($oglas->gorivo == 'benzin')
                    Benzin
                  @elseif($oglas->gorivo == 'benzingas') 
                    Benzin+Gas
                  @elseif($oglas->gorivo == 'metan')
                    Metan CNG
                  @elseif($oglas->gorivo == 'elektricni')
                    Električni Pogon
                  @elseif($oglas->gorivo == 'hibrid')
                    Hibrid
                  @endif   
                </small>  
                </b>|<b><small class="small">{{ $oglas->godiste }} God.|{{ $oglas->kubikaza }} cm<sup>3</sup></small></b>
                <br>
                <b><small class="small">{{ $oglas->snagaks }}</b>KS/<b>{{ $oglas->snagakw }}</b>KW|<b>{{ $oglas->karoserija == 'hecbek' ? "hečbek" : $oglas->karoserija }} </small></b>
                <br>
                <small class="small">Kilometraža: <b>{{ $oglas->kilometraza }}</b> Km</small> 
                <hr style="margin: 0px;">
                <small>{{ $oglas->user->name }}</small> 
                <span class="pull-right"><span class="glyphicon glyphicon-eye-open"></span> {{ $oglas->brpregleda }}</span>   
                </p>  
              </div>         
            </div>  
          </div>{{--kraj diva .jedanoglas--}}
          </a>
        @endforeach
        </div>{{--kraj diva row--}}
      </div>{{--kraj diva .oglasipocetna--}}

    {{-- paginacija na koju kalemimo parametre pretrage koji su vraceni iz metoda pretraga() FrontControllera, takodje se dodaju i para-
    metri za sortiranje tj sort i ascdesc, ovo se radi da bi forma kad se ode na sledecu stranu paginacije bila popunjena unetim parametrima --}}
    <ul class="pager">
      {!! $oglasi->appends(['sort' => $sort, 'ascdesc' => $ascdesc, 'markaautomobila' => $markaautomobila, 'modelmarke' => $modelpretraga, 'gor' => $gor, 'godod' => $godod, 'goddo' => $goddo, 'cod' => $cod, 'cdo' => $cdo, 'kar' => $kar, 'kubod' => $kubod, 'kubdo' => $kubdo, 'ost' => $ost, 'detpretr0ili1' => $detpretr0ili1, 'emkl' => $emkl, 'snod' => $snod, 'sndo' => $sndo, 'kilod' => $kilod, 'kildo' => $kildo, 'poreklo' => $poreklo, 'pog' => $pog, 'menj' => $menj, 'brvr' => $brvr, 'brsed' => $brsed, 'strvol' => $strvol, 'kli' => $kli, 'boja' => $boja, 'por' => $por, 'airb' => $airb, 'cloc' => $cloc, 'abs' => $abs, 'esp' => $esp, 'asr' => $asr, 'alrm' => $alrm, 'kodk' => $kodk, 'zdr' => $zdr, 'blkm' => $blkm, 'cbr' => $cbr, 'mboj' => $mboj, 'svol' => $svol, 'mvol' => $mvol, 'tmpt' => $tmpt, 'prac' => $prac, 'sibr' => $sibr, 'pkr' => $pkr, 'elpo' => $elpo, 'elr' => $elr, 'gret' => $gret, 'elps' => $elps, 'gsed' => $gsed, 'szm' => $szm, 'xen' => $xen, 'led' => $led, 'senzzs' => $senzzs, 'senzzk' => $senzzk, 'senzzp' => $senzzp, 'krno' => $krno, 'kzv' => $kzv, 'aluf' => $aluf, 'nav' => $nav, 'rdio' => $rdio, 'cdp' => $cdp, 'dvd' => $dvd, 'wbs' => $wbs, 'grve' => $grve, 'koza' => $koza, 'prv' => $prv, 'knus' => $knus, 'gar' => $gar, 'garaz' => $garaz, 'serknj' => $serknj, 'rezklj' => $rezklj, 'tun' => $tun, 'old' => $old, 'test' => $test, 'taxi' => $taxi, 'oglasikorisnika' => $oglasikorisnika])->links() !!} 
    </ul>

  </div>{{--kraj div-a .col-md-10 col-md-offset-1 col-xs-12--}}

  
  <script type="text/javascript" src="{{ asset('js/autojq/rezpretrage.js') }}"></script>
  <script type="text/javascript">
    //
    var homeurl = '{{ url('/') }}';
    var token = '{{ Session::token() }}';
    //ruta ka metodu izvadimodele FrontControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodelefront') }}'; 
    //rutu saljemo u rezpretrage.js da bi mogao da salje request metodu pretraga() FrontControllera kad se promeni select za sortiranje oglasa
    var frontpretraga = '{{ route('frontpretraga') }}';
    //variable koje su potrebne hendleru u rezpretrage.js kad se radi sortiranje, tj parametri pretrage koje ce poslati metodu pretraga() 
    //FrontControllera
    var markaautomobila = '{{ $markaautomobila }}';
    var modelmarke = '{{ $modelpretraga }}';
    var gor = '{{ $gor }}';
    var godod = '{{ $godod }}';
    var goddo = '{{ $goddo }}';
    var cod = '{{ $cod }}';
    var cdo = '{{ $cdo }}';
    var kar = '{{ $kar }}';
    var kubod = '{{ $kubod }}';
    var kubdo = '{{ $kubdo }}';
    var ost = '{{ $ost }}';
    var detpretr0ili1 = '{{ $detpretr0ili1 }}';
    var emkl = '{{ $emkl }}';
    var snod = '{{ $snod }}';
    var sndo = '{{ $sndo }}';
    var kilod = '{{ $kilod }}';
    var kildo = '{{ $kildo }}';
    var poreklo = '{{ $poreklo }}';
    var pog = '{{ $pog }}';
    var menj = '{{ $menj }}';
    var brvr = '{{ $brvr }}';
    var brsed = '{{ $brsed }}';
    var strvol = '{{ $strvol }}';
    var kli = '{{ $kli }}';
    var boja = '{{ $boja }}';
    var por = '{{ $por }}';
    var airb = '{{ $airb }}';
    var cloc = '{{ $cloc }}';
    var abs = '{{ $abs }}';
    var esp = '{{ $esp }}';
    var asr = '{{ $asr }}';
    var alrm = '{{ $alrm }}';
    var kodk = '{{ $kodk }}';
    var zdr = '{{ $zdr }}';
    var blkm = '{{ $blkm }}';
    var cbr = '{{ $cbr }}';
    var mboj = '{{ $mboj }}';
    var svol = '{{ $svol }}';
    var mvol = '{{ $mvol }}';
    var tmpt = '{{ $tmpt }}';
    var prac = '{{ $prac }}';
    var sibr = '{{ $sibr }}';
    var pkr = '{{ $pkr }}';
    var elpo = '{{ $elpo }}';
    var elr = '{{ $elr }}';
    var gret = '{{ $gret }}';
    var elps = '{{ $elps }}';
    var gsed = '{{ $gsed }}';
    var szm = '{{ $szm }}';
    var xen = '{{ $xen }}';
    var led = '{{ $led }}';
    var senzzs = '{{ $senzzs }}';
    var senzzk = '{{ $senzzk }}';
    var senzzp = '{{ $senzzp }}';
    var krno = '{{ $krno }}';
    var kzv = '{{ $kzv }}';
    var aluf = '{{ $aluf }}';
    var nav = '{{ $nav }}';
    var rdio = '{{ $rdio }}';
    var cdp = '{{ $cdp }}';
    var dvd = '{{ $dvd }}';
    var wbs = '{{ $wbs }}';
    var grve = '{{ $grve }}';
    var koza = '{{ $koza }}';
    var prv = '{{ $prv }}';
    var knus = '{{ $knus }}';
    var gar = '{{ $gar }}';
    var garaz = '{{ $garaz }}';
    var serknj = '{{ $serknj }}';
    var rezklj = '{{ $rezklj }}';
    var tun = '{{ $tun }}';
    var old = '{{ $old }}';
    var test = '{{ $test }}';
    var taxi = '{{ $taxi }}';
    var oglasikorisnika = '{{ $oglasikorisnika }}';
  </script>

@endsection