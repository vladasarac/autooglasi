@extends('layouts.app')

{{--vju se koristi da admin moze da radi sa oglasima korisnika--}}

@section('content')
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

    <h1>Admin Oglasi</h1><hr>
    <div class="row">
    {{-- div u kom se prikazuju neodobreni oglasi --}}
      <div class="col-lg-6 col-md-6 neodobrenioglasi">
        <h2 class="text-center text-danger linkkaadminoglasioilin" onclick="window.location.href='{{ url('/adminoglasioilin/0') }}'">Neodobreni Oglasi</h2><hr>
      {{-- ako nema neodobrenih oglasa tj kontroler nije vratio nijedan --}}
      @if(count($neodobreni) == 0) 
        <h3 class="text-info text-center">Nema neodobrenih oglasa.</h3>
      @else
        {{-- listamo neodobrene oglase i za svaki prikazujemo podatke --}}
        @foreach($neodobreni as $n)
          <div class="neodobrenoglas" id="oglas{{ $n->id }}">
            @php
              $slugmarkeoglasa = str_slug($n->marka);
            @endphp
            <h4>
          	  <img class="logomarkeoglasaprofil" src="{{ asset("img/autologo/$slugmarkeoglasa.png") }}"> &nbsp;
               &nbsp;
              @if($n->slike != 0)
                @php
                  for($i = 1; $i <= $n->slike; $i++){
                    if(file_exists("img/oglasi/$n->folderslike/$n->id/$i.jpg")){
                      echo "<img src='".url('/')."/img/oglasi/".$n->folderslike."/".$n->id."/thumb".$i.".jpg?vreme=".date('Y-m-d H:i:s')."' class='adminoglasislika img-thumbnail'>";
                      break;
                    }
                  }
                @endphp
              @else
                <img src="{{ asset("img/no_image_available.jpg") }}" class="img-thumbnail adminoglasislika">
              @endif  
              &nbsp;
              {{ $n->naslov }}      
 	        </h4>
 	        <div>
 	      	  <p>
 	      	    <b>Postavljen</b> {{ $n->created_at->format('d.m.Y') }}, 
 	      	    <b>Autor</b> <a href="/profil/{{ $n->user->id }}" target="blank"><b>{{ $n->user->name }}</b></a>
 	      	  </p>
 	      	  <p>
 	      	    <b>Cena</b> {{ $n->cena }} EUR, 
 	      	    <b>Godište</b> {{  $n->godiste }}	
 	      	  </p>
            {{-- kad se klikne ovaj h4 hendler iz adminoglasi.js skida hidden atribut sa diva u kom su svi podatci oglasa --}}
 	      	  <h4 class="text-center svipodatcioglasa shadow" oglasoilin="{{ $n->odobren }}" oglasid="{{ $n->id }}" id="svipodatci{{ $n->id }}">Ostali Podatci</h4>
            {{-- skriven div u kom su svi podatci oglasa i slike --}}
 	      	  <div id="podatcioglasa{{ $n->id }}" class="skriven" hidden="true">
 	      	    <img class="pull-right zatvorisvepodatkeoglasa" oglasid="{{ $n->id }}" oglasoilin="{{ $n->odobren }}" id="zatvorisvepodatke{{ $n->id }}" src="{{ asset("img/redclose.png") }}">
              {{-- btn - i za edit oglasa, brisanje oglasa i odobravanje oglasa --}}
              <br>
              <a id="aktiviraj" class="bezdekoracije" href="{{ url('izmenioglasforma/'.$n->id.'/'.$n->user_id) }}">
                <button type="button" class="btn btn-primary oglasbtnprofilblade">
                  Izmeni&nbsp;&nbsp; Oglas
                </button>
              </a>
              <button type="button" class="btn btn-danger obrisioglas oglasbtnprofilblade" idoglasa="{{ $n->id }}" id="obrisioglasbtn{{ $n->id }}">
                Obriši&nbsp;&nbsp;&nbsp; Oglas
              </button>
              <button type="button" id="odobrioglasbtn{{ $n->id }}" class="btn btn-success odobrioglasadminoglasi" oglasid="{{ $n->id }}">
                Odobri Oglas
              </button>
              <br>
              {{-- ako oglas ima slike prikazujemo ih --}}
              @if($n->slike != 0)
              <div class="divoglasslikeadminoglasi" id="n{{ $n->id }}slike">
                <b>Slika</b> {{ $n->slike }}<br>
                @php
                  $sada = date('Y-m-d H:i:s');
                @endphp
                @for($i = 1; $i <= 12; $i++)
                  @if(file_exists("img/oglasi/$n->folderslike/$n->id/$i.jpg"))
                    <img src="{{ asset("img/oglasi/$n->folderslike/$n->id/thumb$i.jpg?vreme=$sada") }}" class="oglasslikeadminoglasi">
                  @endif
                @endfor
              </div>
              @endif
              {{-- podatci oglasa tj kolone 'oglasis' tabele koje nisu prikazane na vrhu --}}
 	      	  	<p>
 	      	  	  <b>Marka i Model</b> {{ $n->marka }}/{{ $n->model }}
 	      	  	  <b>Karoserija</b> {{ $n->karoserija }}
 	      	  	  <b>Kubikaža</b> {{ $n->kubikaza }} 
 	      	  	  <b>Snaga KS/KW</b> {{ $n->snagaks }}/{{ $n->snagakw }}
                <b>Kilometraža</b> {{ $n->kilometraza }}
                <b>Gorivo</b> {{ $n->gorivo }}
                <b>EKlasa</b> {{ $n->emisionaklasa }}
                <b>Pogon</b> 
                @if($n->pogon == 'p')
                  prednji
                @elseif($n->pogon == 'z')
                  zadnji 
                @elseif($n->pogon == '4x4')
                  4 x 4  
                @elseif($n->pogon == '4x4r') 
                  4 x 4 reduktor  
                @endif
                <b>Menjač</b>
                @if($n->menjac == 'm4')
                  man. 4 brzine 
                @elseif($n->menjac == 'm5')
                  man. 5 brzina 
                @elseif($n->menjac == 'm6')
                  man. 6 brzina
                @elseif($n->menjac == 'pa')
                  poluautomatski 
                @elseif($n->menjac == 'a')
                  automatski
                @endif
                @if($n->ostecen == 1)
                  <b class="text-danger">vozilo je ošteceno</b> 
                @elseif($n->ostecen == 2)
                  <b class="text-danger">nije u voznom stanju</b> 
                @endif
                <b>Br Vrata</b>
                @if($n->brvrata == 3)
                  2/3 
                @elseif($n->brvrata == 4)
                 4/5 
                @endif
                <b>Br Sedišta</b> {{ $n->brsedista }}
                <b>Volan</b> {{ $n->strvolana == 'l' ? 'levi' : 'desni' }}
                <b>Klima</b>
                @if($n->klima == '0')
                  nema klimu
                @elseif($n->klima == 'mk')
                  manuelna klima 
                @elseif($n->klima == 'ak')
                  automatska klima 
                @endif
                <b>Boja</b> {{ $n->boja }}
                <b>Poreklo</b>
                @if($n->poreklo == 'dt')
                  domace tablice
                @elseif($n->poreklo == 'st')
                  strane tablice
                @elseif($n->poreklo == 'nik')
                  na ime kupca
                @endif
 	      	  	</p>
              <p><b>Sigurnost</b> {{ $n->sigurnost }}</p>
              <p><b>Oprema</b> {{ $n->oprema }}</p>
              <p><b>Stanje</b> {{ $n->stanje }}</p>
              <p><b>Tekst</b> {{ $n->tekst }} </p>
 	      	  </div>
 	        </div>
 	        <hr>
 	      </div>  {{--kraj div .neodobrenoglas--}} 
        @endforeach	

      @endif
      </div> {{--kraj div .neodobrenioglasi--}}
      
      {{-- div u kom se prikazuju odobreni oglasi --}}
      <div class="col-lg-6 col-md-6 odobrenioglasi">
        <h2 class="text-center text-success linkkaadminoglasioilin" onclick="window.location.href='{{ url('/adminoglasioilin/1') }}'">Odobreni Oglasi</h2><hr>
        {{-- ako nema odobrenih oglasa tj kontroler nije vratio nijedan --}}
        @if(count($odobreni) == 0) 
          <h3 class="text-info text-center">Nema odobrenih oglasa.</h3>
        @else
        {{-- listamo odobrene oglase i za svaki prikazujemo podatke --}}
        @foreach($odobreni as $o)
          <div class="odobrenoglas" id="oglas{{ $o->id }}">
            @php
              $slugmarkeoglasa = str_slug($o->marka);
            @endphp
            <h4>
          	  <img class="logomarkeoglasaprofil" src="{{ asset("img/autologo/$slugmarkeoglasa.png") }}"> &nbsp;
              &nbsp;
              @if($o->slike != 0)
                @php
                  for($i = 1; $i <= $o->slike; $i++){
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
 	        <div>
 	      	  <p>
 	      	    <b>Postavljen</b> - {{ $o->created_at->format('d.m.Y') }}, 
 	      	    <b>Autor</b> - <a href="/profil/{{ $o->user->id }}" target="blank"><b>{{ $o->user->name }}</b></a>
 	      	  </p>
 	      	  <p>
 	      	    <b>Cena</b> - {{ $o->cena }} EUR, 
 	      	    <b>Godište</b> - {{  $o->godiste }}	
 	      	  </p>
            {{-- kad se klikne ovaj h4 hendler iz adminoglasi.js skida hidden atribut sa diva u kom su svi podatci oglasa --}}
            <h4 class="text-center svipodatcioglasa shadow" oglasoilin="{{ $o->odobren }}" oglasid="{{ $o->id }}" id="svipodatci{{ $o->id }}">Ostali Podatci</h4>
            {{-- skriven div u kom su svi podatci oglasa i slike --}}
            <div id="podatcioglasa{{ $o->id }}" class="skriven" hidden="true">
              <img class="pull-right zatvorisvepodatkeoglasa" oglasid="{{ $o->id }}" oglasoilin="{{ $o->odobren }}" id="zatvorisvepodatke{{ $o->id }}" src="{{ asset("img/redclose.png") }}">
              {{-- btn - i za edit oglasa, brisanje oglasa i zabranjivanje oglasa --}}
              <br>
              <a id="aktiviraj" class="bezdekoracije" href="{{ url('izmenioglasforma/'.$o->id.'/'.$o->user_id) }}">
                <button type="button" class="btn btn-primary oglasbtnprofilblade">
                  Izmeni&nbsp;&nbsp; Oglas
                </button>
              </a>
              <button type="button" class="btn btn-danger obrisioglas oglasbtnprofilblade" idoglasa="{{ $o->id }}" id="obrisioglasbtn{{ $o->id }}">
                Obriši&nbsp;&nbsp;&nbsp; Oglas
              </button>
              <button type="button" id="zabranioglasbtn{{ $o->id }}" class="btn btn-warning zabranioglasadminoglasi" oglasid="{{ $o->id }}">
                Zabrani Oglas
              </button>
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
            </div>
          </div>
 	        {{-- </div> --}}
 	        <hr>	
          </div>  {{--kraj div .odobrenoglas--}}    
        @endforeach	

      @endif  
      </div> {{--kraj div .odobrenioglasi--}}

    </div> {{--kraj div .row--}}
    

    <br><hr><br><br><br><br><br><br><br>

  </div>  {{--kraj div .sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1--}}

  <script type="text/javascript" src="{{ asset('js/autojq/adminoglasi.js') }}"></script>
  <script type="text/javascript">
    var token = '{{ Session::token() }}';
    var urlbrisilogo = '{{ route('obrisilogo') }}'; 
    var urlodobrioglas = '{{ route('odobrioglas') }}';
    var urlzabranioglas = '{{ route('zabranioglas') }}';  
    var urlobrisioglas = '{{ route('obrisioglas') }}';
  </script>
@endsection