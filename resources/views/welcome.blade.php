@extends('layouts.app')

@section('content')
{{-- pocetni vju sajta, poziva ga index() metod FrontControllera --}}

@php
  //
  if(!isset($sort)){
    $sort = 'created_at';
  }
  if(!isset($ascdesc)){
    $ascdesc = 'DESC';
  }
  if(!isset($modeli)){
    $modeli = '';
  }
  if(!isset($markaautomobila)){
      $markaautomobila = '';
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
@endphp

{{-- div se koristi u welcome.js da se izmeri sirina ekrana --}}
<div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div> 

{{-- <div class="container"> --}}
  <div class="row">
    <div class="col-md-10 col-md-offset-1 col-xs-12">

      <h3 class="text-center naslovpretraga shadow">Pretraga <img src="{{ asset('img/searchcars1.png') }}" style="height:25px; width:25px;"></h3>
      
      {{-- osnovna forma za pretragu oglasa --}}
      <div class="formapretraga" hidden="true" style="background-color: #d9edf7; padding: 2px;">

        {{-- hendler za klik na ovu ikonu je u welcome.js i on divu formapretraga dodaje attr hidden="true"--}}
        <div class="row">
          <img src="{{ asset('img/closeplava.png') }}" style="margin-right: 20px;" class="pull-right closebtn zatvoriformuzapretragu">
        </div>
        {{-- include-ujemo vju formapretraga.blade.php u kom je forma za pretragu --}}
        @include('forma.formapretraga')

      </div>{{--kraj diva .formapretraga--}}

      <div class="panel panel-primary">
        @if(Session::has('success')) 
          <div class="text-center success-message" role="alert">
            <strong>
              {!! Session::get('success') !!}
            </strong>
          </div>
        @endif 
        <div class="panel-heading">
          <p class="text-center">Najnoviji Oglasi</p>
        </div>

        <div class="panel-body paneloglasinaslovna">
        {{--prikaz oglasa--}}
          <div class="oglasipocetna">
            <div class="row">
              @foreach($oglasi as $oglas)
                <a href="{{ url('/oglas/'.$oglas->id.'') }}" target="_blank" class="frontjedanoglaslink">
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
                        <small>Postavljen: {{ $oglas->created_at->format('d.m.Y.') }}</small>
                        @if($oglas->ostecen == 1)
                          &nbsp; <small style="color: red;"><b>Oštećen</b></small>
                        @elseif($oglas->ostecen == 2)
                          &nbsp; <small style="color: red;"><b>Oštećen 100%</b></small>
                        @endif
                        <br>
                        {{-- <b>{{ $oglas->marka }}/{{ $oglas->model }}</b>|  --}}
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
                      </p>  
                    </div>         
                  </div>  
                </div>{{--kraj diva .jedanoglas--}}
                </a>
              @endforeach

            <div class="divispodoglasa"></div>
            </div>{{--kraj diva row--}}
            
            {{-- ako je varijabla $ukupnooglasa(u njoj je ukupan br oglasa u 'oglasis' tablei) veca od 6 prikazujemo h1 koji sluzi kao btn
            za ucitavanje jos oglasa --}}
            {{-- <h1>{{$ukupnoolgasa}}</h1> --}}
            @if($ukupnoolgasa > 6)  
              <h3 class="text-center naslovjosoglasa shadow">Još Oglasa</h3>
            @endif 
          </div>{{--kraj diva .oglasipocetna--}}

        </div>{{-- kraj div-a .paneloglasinaslovna --}}
      </div>
    </div>
  </div>
{{-- </div> --}}

  <script type="text/javascript" src="{{ asset('js/autojq/welcome.js') }}"></script>
  <script type="text/javascript">
    var homeurl = '{{ url('/') }}';
    var josoglasaurl = '{{ route('josoglasa') }}';
    var ukupnooglasa = '{{ $ukupnoolgasa }}'; 
    var token = '{{ Session::token() }}';
    //ruta ka metodu izvadimodele FrontControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodelefront') }}'; 
    //
    var jedanoglasurl = '{{ route('oglas') }}';
  </script>
@endsection
