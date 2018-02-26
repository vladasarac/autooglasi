@extends('layouts.app')

{{-- vju prikazuje jedan oglas u frontendu --}}

@section('content')

  {{-- div se koristi u oglas.js da se izmeri sirina ekrana --}}
  <div id="dpi" style="height: 1in; width: 1in; left: 100%; position: fixed; top: 100%;"></div> 
  
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
  @endphp

  {{-- skriveni div u kom prikazujemo galeriju slika oglasa kad user klikne zoomin ikonu koja se pojavljuje na .divnaslovnaslikaspoljni, kad 
  user hoveruje po njemu, kad se ikona klikne hendler iz oglas.js uklanja ovom divu hidden atribut --}}
    <div class="ceoekran" hidden="true">
      <div class="row">
        {{-- ikona x za zatvaranje div-a ceooglas, hendler za klik na nju u oglas.js, vraca div-u ceoekran atribut hidden --}}
        <img src="{{ asset('img/closeceoekran.png') }}" class="pull-right closebtn zatvorislikeceoekran">
      </div>
      <div class="row galerija">
        {{--  --}}
        {{-- @if($oglas->slike > 1)

        @endif --}}
      </div>
    </div>{{--kraj div-a .ceoekran--}}

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
      </div> {{--kraj div-a .formapretraga--}}

      {{-- div u kom su slike, glavna i ispod nje sve male slike(thumb-ovi ostalih slika oglasa) --}}
      {{-- <div class="oglasgore row" style="margin: 0px!important;"> --}}
        <div class="row col-md-6 levo paddinglevodesno" style="background-color: white;">
          <div class="row levounutrasnji borderlevodesno"> 
            {{-- naslov oglasa i logo marke vozila --}}
            @php
                $slugmarkeoglasa = str_slug($oglas->marka);
            @endphp
            <h3 class="naslovoglasa slovasenka"><img class="logomarkeoglasaprofil" src="{{ asset("img/autologo/$slugmarkeoglasa.png") }}"> {{ $oglas->naslov }}</h3>
            {{-- ako oglas ima slike prikazujemo prvu koju nadjemo u folderu tog oglasa kao naslovnu(tj sliku sa najmanjim brojem) takodje su
            na glavnoj slici strelice za levo i desno tj prethodnu i sledecu sliku a hendleri za njih su oglas.js--}}
            @if($oglas->slike != 0)
              @php
                for($i = 1; $i <= 12; $i++){
                  if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg")){
                    echo "<div class='divnaslovnaslikaspoljni'>";
                    echo "<div class='divnaslovnaslika'>";
                    echo "<div class='zoomin' imgid='".$i."' hidden='true'>";
                    echo "<img class='zoominicon' src='".url('/')."/img/zoomin.png'>";
                    echo "</div>";
                    //strelice tj ikonje za sledecu ili prethodnu sliku na glavnoj slici prikazujemo samo ako oglas ima vis eod jedne slike
                    if($oglas->slike > 1){
                      echo "<div class='prethodnaslika' id='".$i."' hidden='true'>";
                      echo "<img class='strelicenaslovnajslika' src='".url('/')."/img/prethodnaslika.png'>";
                      echo "</div>";
                      echo "<div class='sledecaslika' id='".$i."' hidden='true'>";
                      echo "<img class='strelicenaslovnajslika' src='".url('/')."/img/sledecaslika.png'>";
                      echo "</div>";
                    }
                    echo "<img src='".url('/')."/img/oglasi/".$oglas->folderslike."/".$oglas->id."/".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='naslovnaslikaoglas'>";
                    echo "</div></div>";
                    break;
                  }
                }
              @endphp
            {{-- ako nema slika prikazujemo no image fotografiju --}}
            @else
              <img src="{{ asset("img/no_image_available1.jpg") }}" class="naslovnaslikaoglas">
            @endif
            {{-- thumbove prikazujemo samo ako oglas ima dodate slike, klik an neki od thumbova umesto trenutne glavne slike prikazuje sliku ciji
            smo thumb kliknuli, hendler za to je u oglas.js --}}
            @if($oglas->slike != 0)
              <div class="row col-md-12 maleslike paddinglevo" style="background-color: white;">
                @php
                  for($i = 1; $i <= 12; $i++){
                    if(file_exists("img/oglasi/$oglas->folderslike/$oglas->id/$i.jpg")){
                      echo "<div class='col-md-3 col-xs-2' style='padding: 1px;'>";
                      echo "<img src='".url('/')."/img/oglasi/".$oglas->folderslike."/".$oglas->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='malanaslovnaslika ".$i."' imeslike='".$i."' id='".$i.".jpg'>";
                      echo "</div>";
                    }
                  }
                @endphp
              </div>
            @endif
          </div>  {{--kraj div-a row levounutrasnji--}}
        </div> {{--kraj div-a row col-md-6 levo paddinglevodesno--}}

        {{-- div u kom su osnovni podatci oglasa --}}
        <div class="col-md-3 desnoprvi" style="background-color: white; padding: 0px 0px 0px 15px;">
          <h4 class="slovasenka cenaoglas text-center">Cena: {{ $oglas->cena }} &euro;</h4>
          @if($oglas->ostecen == 1)
            <div class="alert alert-danger text-center">
              <strong>Vozilo je oštećeno</strong>
            </div>
          @elseif($oglas->ostecen == 2)
            <div class="alert alert-danger text-center">
              <strong>Vozilo nije u voznom stanju</strong>
            </div>
          @endif
          <p>
            <b>{{ $oglas->marka }}</b> {{ $oglas->model }}<br>
            <b>Godište: </b>{{ $oglas->godiste }}<br>
            <b>Kilometraža: </b>{{ $oglas->kilometraza }} km<br>
            <b>Karoserija: </b>{{ $oglas->karoserija }}<br>
            <b>Gorivo: </b>
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
            <br>
            <b>Kubikaža: </b>{{ $oglas->kubikaza }} cm<sup>3</sup><br>
            <b>Snaga KS / kW: </b>{{ $oglas->snagaks }} / {{ $oglas->snagakw }}<br>
            <b>Emisiona klasa: </b>{{ $oglas->emisionaklasa }}<br>
            <b>Pogon: </b>
              @if($oglas->pogon == 'p')
                prednji
              @elseif($oglas->pogon == 'z')
                zadnji 
              @elseif($oglas->pogon == '4x4')
                4 x 4  
              @elseif($oglas->pogon == '4x4r') 
                4 x 4 reduktor  
              @endif
            <br>
            <b>Menjač: </b>
              @if($oglas->menjac == 'm4')
                manuelni 4 brzine 
              @elseif($oglas->menjac == 'm5')
                manuelni 5 brzina 
              @elseif($oglas->menjac == 'm6')
                manuelni 6 brzina
              @elseif($oglas->menjac == 'pa')
                poluautomatski 
              @elseif($oglas->menjac == 'a')
                automatski
              @endif
            <br>  
            <b>Broj vrata: </b>
              @if($oglas->brvrata == 3)
                2/3 
              @elseif($oglas->brvrata == 4)
               4/5 
              @endif
            <br>
            <b>Broj sedišta: </b>{{ $oglas->brsedista }}<br>
            <b>Klima: </b>
            @if($oglas->klima == '0')
              nema klimu
            @elseif($oglas->klima == 'mk')
              manuelna klima 
            @elseif($oglas->klima == 'ak')
              automatska klima 
            @endif
            <br>
            <b>Strana volana: </b>{{ $oglas->strvolana == 'l' ? 'levi' : 'desni' }}<br>
            <b>Boja: </b>
            @if($oglas->boja == 'bez')
              bež
            @elseif($oglas->boja == 'ljubicasta')
              ljubičasta
            @elseif($oglas->boja == 'narandzasta')
              narandžasta
            @elseif($oglas->boja == 'zuta')
              žuta
            @else
              {{ $oglas->boja }}<br>
            @endif
            <br><b>Poreklo: </b>
            @if($oglas->poreklo == 'dt')
              domaće tablice
            @elseif($oglas->poreklo == 'st')
              strane tablice
            @elseif($oglas->poreklo == 'nik')
              na ime kupca
            @endif
            <br>
            <b>Broj pregleda oglasa: </b>{{ $oglas->brpregleda }}
          </p>
        </div>

        {{-- div u kom su osnovni podatci prodavca tj usera ciji je oglas --}}
        <div class="col-md-3 desnodrugi" style="background-color: white; padding: 0px 0px 0px 15px;">
          <h4 class="slovasenka cenaoglas text-center">Prodavac</h4>
          <p>
            @if($oglas->user->logo == 1)
              <img src="{{ asset('img/users/'.$oglas->user->id.'/1.jpg') }}?vreme={{ date('Y-m-d H:i:s') }}" alt=""><br>
            @endif
            <b>{{ $oglas->user->name }}</b><br>
            {{-- link ka metodu pretraga() FrontControllera, ako se odavde pozove pretraga() prikazace samo oglase korisnika ciji je id u 
            parametru oglasikorisnika --}}
            <a href="{{ url('/frontpretraga?oglasikorisnika='.$oglas->user_id.'&detpretr0ili1='.$detpretr0ili1.'&sort='.$sort.'&ascdesc='.$ascdesc.'&markaautomobila='.$markaautomobila.'&modelmarke='.$modelpretraga.'&gor='.$gor.'&godod='.$godod.'&goddo='.$goddo.'&cod='.$cod.'&cdo='.$cdo.'&kar='.$kar.'&kubod='.$kubod.'&kubdo='.$kubdo.'&ost='.$ost.'&emkl='.$emkl.'&snod='.$snod.'&sndo='.$sndo.'&kilod='.$kilod.'&kildo='.$kildo.'&poreklo='.$poreklo.'&pog='.$pog.'&menj='.$menj.'&brvr='.$brvr.'&brsed='.$brsed.'&strvol='.$strvol.'&kli='.$kli.'&boja='.$boja.'&por='.$por.'&airb='.$airb.'&cloc='.$cloc.'&abs='.$abs.'&esp='.$esp.'&asr='.$asr.'&alrm='.$alrm.'&kodk='.$kodk.'&zdr='.$zdr.'&blkm='.$blkm.'&cbr='.$cbr.'&mboj='.$mboj.'&svol='.$svol.'&mvol='.$mvol.'&tmpt='.$tmpt.'&prac='.$prac.'&sibr='.$sibr.'&pkr='.$pkr.'&elpo='.$elpo.'&elr='.$elr.'&gret='.$gret.'&elps='.$elps.'&gsed='.$gsed.'&szm='.$szm.'&xen='.$xen.'&led='.$led.'&senzzs='.$senzzs.'&senzzk='.$senzzk.'&senzzp='.$senzzp.'&krno='.$krno.'&kzv='.$kzv.'&aluf='.$aluf.'&nav='.$nav.'&rdio='.$rdio.'&cdp='.$cdp.'&dvd='.$dvd.'&wbs='.$wbs.'&grve='.$grve.'&koza='.$koza.'&prv='.$prv.'&knus='.$knus.'&gar='.$gar.'&garaz='.$garaz.'&serknj='.$serknj.'&rezklj='.$rezklj.'&tun='.$tun.'&old='.$old.'&test='.$test.'&taxi='.$taxi.'') }}">
              Svi oglasi korisnika
            </a><br>
            <b>Telefon: </b>{{ $oglas->user->telefon }}<br>
            @if($oglas->user->telefon2 != null)
              <b>Telefon 2: </b>{{ $oglas->user->telefon2 }}<br>
            @endif
            @if($oglas->user->telefon3 != null)
              <b>Telefon 3: </b>{{ $oglas->user->telefon3 }}<br>
            @endif
            @if($oglas->user->prikaziemail == 1)
              <b>E-mail: </b>{{ $oglas->user->email }}<br>
            @endif
            <b>Grad (mesto): </b>{{ $oglas->user->grad }}<br>
            <b>Adresa: </b>{{ $oglas->user->adresa }}
            
          </p>
        </div>{{--kraj div-a .desnodrugi--}}
      {{-- </div>kraj div-a .oglasgore --}}

      {{-- div u kom su ostali tj dodatni podatci oglasa tj kolone oprema, sigurnost, stanje i tekst 'oglasis' tabele --}}
      <div class="col-md-12 ispod" style="background-color: white; border-top: 1px solid #00adee;">
        <h4 class="naslovdivispod slovasenka">Oprema</h4>
        <p>{{ $oglas->oprema }}</p>
        <h4 class="naslovdivispod slovasenka">Sigurnost</h4>
        <p>{{ $oglas->sigurnost }}</p>
        <h4 class="naslovdivispod slovasenka">Stanje</h4>
        <p>{{ $oglas->stanje }}</p>
        <h4 class="naslovdivispod slovasenka">Tekst oglasa</h4>
        <p>{{ $oglas->tekst }}</p>
      </div>

      {{-- ako user ciji se oglas gleda ima dodatu lat, lng i zoom znaci da je dodao google map pa je prikazujemo --}}
      @if($oglas->user->lat != null && $oglas->user->lng != null && $oglas->user->zoom != null)
        {{-- googlemap --}}
        <div id="mapspoljnioglas">
          {{-- div u koji se ubacuje mapa --}}
          <div id="map" class="form-group "></div>
        </div>
      @endif
     
    </div> {{--kraj div-a .col-md-10 col-md-offset-1 col-xs-12--}}
  </div> {{--kraj div-a .row--}}

  

  {{-- <h3>{{ $oglas->naslov }}, id oglasa: {{ $oglas->id }}</h3>
  <h5>detpretr0ili1 - {{ $detpretr0ili1 }}, markaautomobila - {{ $markaautomobila }}, modelpretraga - {{ $modelpretraga }}</h5>
  <p>
  	{{ $oglas->marka }}, {{ $oglas->model }}
  </p> --}}
  
  <script type="text/javascript" src="{{ asset('js/autojq/oglas.js') }}"></script>
  <script type="text/javascript">
    //
    var homeurl = '{{ url('/') }}';
    var token = '{{ Session::token() }}';
    //ruta ka metodu izvadimodele FrontControllera koji koristi hendler za promenu u MarkaAutomobla selectu da izvuce imena modela neke marke
    var izvadimodeleurl = '{{ route('izvadimodelefront') }}'; 
    //variable koje oglas.js treba da bi radila galerija slika i menjanje slike u naslovnoj slici
    var folderslike = '{{ $oglas->folderslike }}';
    var oglasid = '{{ $oglas->id }}';
    var oglasslike = '{{ $oglas->slike }}';
    var userlat = '{{ $oglas->user->lat }}';
    var userlng = '{{ $oglas->user->lng }}';
    var userzoom = '{{ $oglas->user->zoom }}';
  </script>

@endsection




























