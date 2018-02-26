{{-- vju je email koji create() metod AuthControllera salje useru da bi aktivirao svoj nalog kad se registruje --}}
<h1>Uspesno ste se registrovali na auto.dev</h1>
<p>vase korisnicko ime: {{ $user }}, <br>
   vas email: {{ $useremail }}<br>
   {{-- kad user klikne ovaj link salje ga na aktivacija() metod UsersControllera koji menja kolonu aktivan u 1 prvo izvlaci usera iz
   'users' tabele po koloni verification a taj string mu saljemo kao argument linka--}}
   <h2 style="color: orange;">Aktivirajte vas nalog kliom na ovaj <a href="http://auto.localhost/aktivacija/{{ $verification }}">link</a></h2>
    
</p>
