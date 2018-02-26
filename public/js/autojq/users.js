$(document).ready(function(){

//ovde su hendleri za vju users.blade.php iz 'auto/resources/views/admin'

//menjanje opcije u selectu #sortusers u users.blade.php tj sortiranje prikaza usera po nekoj koloni tabele 'users'
$('#sortusers').on('change', function(){
  //uzimamo atribut sortirajpo odabranog optiona selecta u kom pise po kojoj koloni da se sortira
  var sort = $('option:selected', this).attr('sortirajpo');
  //uzimamo atribut ascdesc odabranog optiona selecta u kom pise da li da sortira uzlazno-ASC ili silazno-DESC
  var ascdesc = $('option:selected', this).attr('ascdesc');
  //alert(imekorisnikasort);
  //proveravamo da li je korisnik uneo nesto u input za pretragu usera po imenu u users.blade.php tj da li je imekorisnikasort varijabla puna
  //ili prazna
  if(imekorisnikasort == ''){
  	//pravimo url koji cemo koristiti za window.locatio.href, varijabla url definisana na dnu vjua users.blade.php pa joj dodajemo sort i asdesc
    //koji ce biti parametri get requesta
    url = url+'?sort='+sort+'&ascdesc='+ascdesc;
    //alert(url);
  }else{
  	//ako je u users.blade.php radjena pretraga po imenu onda varijabla imekorisnikasort nije '' pa dodajemo u url ono sto je unetu u polje 
  	//za pretragu korisnika po imenu
    url = url+'?sort='+sort+'&ascdesc='+ascdesc+'&imekorisnika='+imekorisnikasort;
  }
  
  //idemo na url 'korisnici/{sort?}' tj na metod korisnici() UsersControllera
  window.location.href = url;
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//klik na btn tj span .pretrazispanime tj kao sabmit forme za pretragu korisnika po imenu u users.blade.php
$('.pretrazispanime').on('click', function(){
  //uzimamo adminov unos u input polje za pretragu po imenu
  var imekorisnika = $('#imekorisnika').val();
  if(imekorisnika != ''){//ako admin nista nije uneo onda ne rad nista
  	//ako je admin uneo nesto onda taj string kacimo na URL kao parametar imekorisnika koji ce prepoznati korisnici() UsersControllera pa ce pre
    //trazi 'users' tabel dodati WHERE za name kolonu
    url = url+'?imekorisnika='+imekorisnika;
    //idemo na rutu /korisnici koja gadja metod korisnici() UsersControllera
    window.location.href = url;
  }
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//klik na btn tj span .pretrazispanid tj kao sabmit forme za pretragu korisnika po id-u u users.blade.php
$('.pretrazispanid').on('click', function(){
  //uzimamo adminov unos u input polje za pretragu po id-u
  var idkorisnika = $('#idkorisnika').val();
  if(idkorisnika != ''){//ako admin nista nije uneo onda ne rad nista
    //ako je admin uneo nesto onda taj string kacimo na URL kao parametar idkorisnika koji ce prepoznati korisnici() UsersControllera pa ce pre
    //trazi 'users' tabel dodati WHERE za id kolonu
    url = url+'?idkorisnika='+idkorisnika;
    //idemo na rutu /korisnici koja gadja metod korisnici() UsersControllera
    window.location.href = url;
  }
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//manuelna aktivacija korisnika, tj klik na link(btn) .aktivirajbtn u users.blade.php kojim admin moze da aktivira neaktivnog korisnika
$('body').on('click', '.aktivirajbtn', function(e){
  e.preventDefault();
  //iz atributa userid uzimamo id korisnika koji cemo poslati AJAX-om u metod manuelnaaktivacija() UsersControllera
  var userid = $(this).attr('userid');
  //alert('user id: '+userid+', url: '+urlmanuelnaaktivacija);
  //saljemo AJAX preko rute '/manuelnaaktivacija', urlmanuenaaktivacija definisana na dnu users.blade.php
  $.ajax({ 
      method: 'POST',
      url: urlmanuelnaaktivacija,
      data: { userid: userid, _token: token }
    })//kad stigne odgovor od kontrolera tj kad obrise logo
    .done(function(o){
      console.log(o.user.aktivan);
      //posto je kontroler vratio objekat u kom su svi podatci usera koji je aktiviran proveravamo da li u aktivan koloni pise 1
      if(o.user.aktivan == 1){
        $('#aktiviraj'+userid).remove();//uklanjamo link koji smo kliknuli pri aktivaciji
        //pravimo link za deaktivaciju isog ovog usera i kacimo ga ispod br .ubaciaktivirajdeaktivirajlink+id tj ispod linka ka profilu usera
        var output = '<a class="redbtn deaktivirajbtn" id="deaktiviraj'+o.user.id+'" userid="'+o.user.id+'" target="blank" href="#">Deaktiviraj</a>'; 
        $(output).insertAfter('.ubaciaktivirajdeaktivirajlink'+o.user.id);
      }else{//ako ne pise u vracenom objektu iz kontrolera da je kolona aktivan 1
        alert('Došlo je do greške, nije moguće aktivirati korisnika, pokušajte ponovo.');
      }
    });
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//manuelna deaktivacija korisnika, tj klik na link(btn) .deaktivirajbtn u users.blade.php kojim admin moze da deaktivira aktivnog korisnika
$('body').on('click', '.deaktivirajbtn', function(e){
  e.preventDefault();
  //iz atributa userid uzimamo id korisnika koji cemo poslati AJAX-om u metod manuelnadeaktivacija() UsersControllera
  var userid = $(this).attr('userid');
  //alert('user id: '+userid+', url: '+urlmanuelnadeaktivacija);
  //saljemo AJAX preko rute '/manuelnadeaktivacija', urlmanuenadeaktivacija definisana na dnu users.blade.php
  $.ajax({ 
      method: 'POST',
      url: urlmanuelnadeaktivacija,
      data: { userid: userid, _token: token }
    })//kad stigne odgovor od kontrolera tj kad obrise logo
    .done(function(o){
      console.log(o.user.aktivan);
      //posto je kontroler vratio objekat u kom su svi podatci usera koji je deaktiviran proveravamo da li u aktivan koloni pise 0
      if(o.user.aktivan == 0){
        $('#deaktiviraj'+userid).remove();//uklanjamo link koji smo kliknuli pri deaktivaciji
        //pravimo link za aktivaciju isog ovog usera i kacimo ga ispod br .ubaciaktivirajdeaktivirajlink+id tj ispod linka ka profilu usera
        var output = '<a class="greenbtn aktivirajbtn" id="aktiviraj'+o.user.id+'" userid="'+o.user.id+'" target="blank" href="#">Aktiviraj</a>'; 
        $(output).insertAfter('.ubaciaktivirajdeaktivirajlink'+o.user.id);
      }else{//ako ne pise u vracenom objektu iz kontrolera da je kolona aktivan 1
        alert('Došlo je do greške, nije moguće deaktivirati korisnika, pokušajte ponovo.');
      }
    });
});


});