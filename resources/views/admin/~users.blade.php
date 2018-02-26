@extends('layouts.app')

{{----}}

@section('content')
  {{-- <h1>Vju Korisnici tj Users.blade.php</h1> --}}
  <div class="sadrzaj col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
    {{-- posto je div koji prikazuje formu po difoltu nevidljiv kad se klikne ovde uklanja mu se hidden="true", hendler u dodajmarke.js --}}
  	<h1 class="text-center naslovsvikorisnici">Svi Korisnici</h1>
  	<div class="divkorisnici">
  	  @foreach($users as $user)
  	    {{-- <div class="korisnik">
  	      <p>{{ $user->name }}</p>
  	      <p>{{ $user->email }}</p>	
  	    </div> --}}
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
                    <td class="tbl-apply"><a class="orangebtn" target="blank" href="/profil/{{ $user->id }}">Idi Na Profil</a></td>
                  </tr>
          		</tbody>
        	  </table>
      	    </div>
    	  </div>
  		</div>
  	  @endforeach	
  	  <ul class="pager">
  	    {!! $users->links() !!} 
      </ul>
  	</div><br><hr><br><br><br><br><br><br><br>
  	
  </div>
@endsection