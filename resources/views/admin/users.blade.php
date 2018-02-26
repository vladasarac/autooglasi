@extends('layouts.app')

{{--vju prikazuje adminu korisnike(aktivne i neaktivne), poziva ga metod korisnici() UsersControllera, takodje se isti metod koristi da vadi
korisnike po imenu ili korisnika po id-u, to se desava kad se sabmituju inputi za pretragu--}}

@section('content')
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">

    @if(Session::has('successbrisanjeusera')) 
      <div class="text-center success-message" role="alert">
        <strong>{!! Session::get('successbrisanjeusera') !!}</strong>
      </div>
    @endif

    {{-- posto je div koji prikazuje formu po difoltu nevidljiv kad se klikne ovde uklanja mu se hidden="true", hendler u dodajmarke.js --}}
  	<h1 class="text-center naslovsvikorisnici">Svi Korisnici</h1>
  	<div class="divkorisnici">
    {{--korisnike mozemo pretraziti po imenu, hendler za klik na span .pretrazispanime je u users.js,uzima unos u input polje i onda radi
    window.location ali pre toga kaci na URL kao parametar unos u input polje--}}
      <p>Pretraži Korisnike Po Imenu</p>
      <div class="col-lg-5 input-group">     
        <input type="text" id="imekorisnika" class="form-control" placeholder="{{ (!empty($imekorisnika)) ? $imekorisnika : 'Ime Korisnika' }}" aria-describedby="basic-addon1">
        <span class="input-group-addon pretrazispanime" id="basic-addon1">Pretraži</span>
      </div>
      {{-- korisnike mozemo pretraziti i preko id-a, hendler za klik na span .pretrazispanid je u users.js, uzima unos u input polje za id
      i onda radi windows.location ali pre toga kaci na URL kao parametar unos u ovo polje --}}
      <p style="margin-top: 10px;">Pretraži Korisnike Po ID-u</p>
      <div class="col-lg-5 input-group">     
        <input type="text" id="idkorisnika" class="form-control" placeholder="{{ (!empty($idkorisnika)) ? $idkorisnika : 'ID Korisnika' }}" aria-describedby="basic-addon1">
        <span class="input-group-addon pretrazispanid" id="basic-addon1">Pretraži</span>
      </div>
      {{-- sortiranje korisnika --}}
      <p style="margin-top: 10px;">Sortiraj po: </p>
      <div class="col-lg-5 korisnicisortselect">
      {{--na promen optiona selecta poziva se hendler iz users.js koji pravi string URL koji koristi kao argment za window.location() tj poziva
      metod korisnici() UsersCOntrollera i salje mu parametar po kojoj koloni 'users' tabele da sortira rezltate--}}
        <select id="sortusers" class="form-control">
          <option></option>
          <option sortirajpo="name" ascdesc="ASC" {{ ($sort == 'name' && $ascdesc == 'ASC') ? 'selected' : '' }}>Imenu Uzlazno</option>
          <option sortirajpo="name" ascdesc="DESC" {{ ($sort == 'name' && $ascdesc == 'DESC') ? 'selected' : '' }}>Imenu Silazno</option>
          <option sortirajpo="id" ascdesc="ASC" {{ ($sort == 'id' && $ascdesc == 'ASC') ? 'selected' : '' }}>ID Uzlazno</option>
          <option sortirajpo="id" ascdesc="DESC" {{ ($sort == 'id' && $ascdesc == 'DESC') ? 'selected' : '' }}>ID Silazno</option>
          <option sortirajpo="grad" ascdesc="ASC" {{ ($sort == 'grad' && $ascdesc == 'ASC') ? 'selected' : '' }}>Gradu Uzlazno</option>
          <option sortirajpo="grad" ascdesc="DESC" {{ ($sort == 'grad' && $ascdesc == 'DESC') ? 'selected' : '' }}>Gradu Silazno</option>
          <option sortirajpo="created_at" ascdesc="ASC" {{ ($sort == 'created_at' && $ascdesc == 'ASC') ? 'selected' : '' }}>Datumu Prijave Uzlazno</option>
          <option sortirajpo="created_at" ascdesc="DESC" {{ ($sort == 'created_at' && $ascdesc == 'DESC') ? 'selected' : '' }}>Datumu Prijave Silazno</option>
        </select>  
      </div>
      {{-- kupan broj pronadjenih korisnika koje je vratio kontroler --}}
      <br><br><hr>
      <p>Ukupno pronadjeno {{ $userstotal }} korisnika</p>
      <hr>

      {{-- iteriramo kroz usere koje vrati metod korisnici() UsersControllera i za svakog prikazujemo tabelu istu kao na vrhu profil.blade.php --}}
  	  @foreach($users as $user)
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
            		<td class="tbl-title"><h4>{{ $user->name }}<br><span class="job-type"><i class="icon-location"></i>{{ $user->grad }}, id: {{ $user->id }}</span></h4></td>
            		<td>            
              		  <i class="fa fa-envelope-o" aria-hidden="true"></i> {{ $user->email }}
              		  <br><span class="job-type"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;{{ $user->telefon }}</span>
              		  <br><span class="job-type"><i class="fa fa-car" aria-hidden="true"></i> Broj Oglasa: {{ $user->brojoglasa }}</span> 	         
              		</td>
                    <td class="tbl-apply">
                      {{-- link tj btn ka userovom profilu gde admin moze da edtuje profil ako hoce --}}
                      <a class="orangebtn" target="blank" href="/profil/{{ $user->id }}"> &nbsp; &nbsp;Profil &nbsp;</a>
                      {{-- ako user nije aktivan admin ima mogucnost da ga klikom na ovaj link tj btn aktivira, kad se klikne hendler iz users.js
                      salje AJAX metodu manuelnaaktivacija UsersControllera --}}
                      @if($user->aktivan == 0)
                        <br><br class="ubaciaktivirajdeaktivirajlink{{ $user->id }}">
                        <a class="greenbtn aktivirajbtn" id="aktiviraj{{ $user->id }}" userid="{{ $user->id }}" target="blank" href="#">Aktiviraj</a>
                      {{--ako je user aktivan onda admin ima mogucnost da mu deaktivira profil klikom na ovaj link kad se klikne hendler iz users.js
                      salje AJAX metodu manuelnadeaktivacija UsersControllera--}}
                      @else
                        <br><br class="ubaciaktivirajdeaktivirajlink{{ $user->id }}">
                        <a class="redbtn deaktivirajbtn" id="deaktiviraj{{ $user->id }}" userid="{{ $user->id }}" target="blank" href="#">Deaktiviraj</a>
                      @endif
                    </td>
                    
                  </tr>
          		</tbody>
        	  </table>
      	    </div>
    	  </div>
  		</div>
  	  @endforeach	

      {{-- PAGINACIJA--}}
      {{-- ako je radjena pretraga po imenu tj puna je varijabla $imekorisnika jer ju je onda vratio metod korisnici() UsersControllera pagi-
      -naciji treba dodati argument 'imekorisnika' --}}
      @if(!empty($imekorisnika))
        <ul class="pager">
          {!! $users->appends(['sort' => $sort, 'ascdesc' => $ascdesc, 'imekorisnika' => $imekorisnika])->links() !!} 
        </ul>
      {{-- ako nije $imekorsnika vraceno iz kontrolera onda samo kao argumenti paginacije variable za sortiranje --}}
      @else
  	    <ul class="pager">
  	      {!! $users->appends(['sort' => $sort, 'ascdesc' => $ascdesc])->links() !!} 
        </ul>
      @endif
  	</div><br><hr><br><br><br><br><br><br><br>{{--kraj div-a .divkorisnici--}}
  	
  </div>{{--kraj div-a .sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1--}}

  {{--hendleri za ovaj vju su u users.js iz 'auto\public\js\autojq\users.js'--}}
  <script type="text/javascript" src="{{ asset('js/autojq/users.js') }}"></script>
  <script type="text/javascript">
    var token = '{{ Session::token() }}';
    //ruta ka metodu manuelnaaktivacija() UsersControllera kojim admin aktivira korisnika
    var urlmanuelnaaktivacija = '{{ url('/manuelnaaktivacija') }}';
    //ruta ka metodu manuelnadeaktivacija() UsersControllera kojim admin deaktivira korisnika
    var urlmanuelnadeaktivacija = '{{ url('/manuelnadeaktivacija') }}';
    var url = '{{ url('/korisnici') }}';
    var imekorisnikasort = ''; 
    // ako je radjena pretraga po imenu tj kontroler je vratio $imekorsnika onda saljemo i to u users.js da u slucaju sortiranja moze da napravi
    //tacno string koji salje kao URL za window.location()
    @if(!empty($imekorisnika))
      imekorisnikasort = '{{ $imekorisnika }}';
    @endif  
  </script>
  
@endsection