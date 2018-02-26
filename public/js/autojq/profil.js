$(document).ready(function(){
  //ovde su hendleri za profil.blade.php vju	
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //posto tabela na vrhu profil.blade.php na malim ekranima lose izgleda ovde merimo ekran i ako se ispostavi da je mali uklanjamo tu tabelu
  //koja se nalazi u div - u .tabelauserpodatci i onda ovde generisemo div sa istim podatcima koji ce malo lepse izgledati na malom ekranu
  var dpi_x = document.getElementById('dpi').offsetWidth;
  var widthekrana = $(window).width() / dpi_x;
  //console.log('id:'+userid+', ime:'+username+', email:'+useremail+', grad:'+usergrad+', telefon'+usertelefon+', brojoglasa:'+userbrojoglasa+', logo'+userlogo);
  console.log('userauthcheck: '+userauthcheck+', userauthuserrole: '+userauthuserrole+', useraktivan: '+useraktivan+', userauthuserid'+userauthuserid);
  if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
    //ovo nam treba da nakacim parametar na src atribut slike zbog refresha
    var trenutnovreme = $.now();
    //uklanja se tabela koja je do sada prikazivala podatke korisnika
    $('.tabelauserpodatci').remove();
    var podatciuseraout = '';
    podatciuseraout += '<div class="text-center" style="background-color: #00adee; padding: 5px;">';
    if(userlogo == 1){
      podatciuseraout += '<img src="'+slikeurl+'/img/users/'+userid+'/1.jpg?vreme='+trenutnovreme+'">';
    }
    podatciuseraout += '<p><b>'+username+'</b>, email: <b>'+useremail+'</b><br>';
    podatciuseraout += 'grad: <b>'+usergrad+'</b>, tel: <b>'+usertelefon+'</b>, Br. Oglasa: <b>'+userbrojoglasa+'</b>';
    podatciuseraout += '</p>';
    if(userauthcheck && userauthuserrole == 'admin' && useraktivan == 1){
      podatciuseraout += '<a class="greenbtn" href="/novioglas/'+userid+'"><button type="button" class="btn btn-success">Novi Oglas</button></a>';
    }else if(userauthuserid == userid && useraktivan == 1){
      podatciuseraout += '<a class="greenbtn" href="/novioglas/'+userid+'"><button type="button" class="btn btn-success">Novi Oglas</button></a>';
    }
    podatciuseraout += " ";
    podatciuseraout += "<a class='brisanjeuserame' href='"+slikeurl+"/obrisikorisnika/"+userid+"?_token="+token+"' id='obrisiprofilbtn'>";
    podatciuseraout += '<button type="button" class="btn btn-danger">Obriši Profil</button>';
    podatciuseraout += '</a>';
    podatciuseraout += '</div>';
    $('.podatcikorisnika').html(podatciuseraout); 
    //alert(widthekrana);
  }   

  //ako user klikne btn za brisanje profila na malom ekranu ovde mu iskace confirm, posto nisam uspeo da ubudzim onclick atribut u generisani
  //html gore
  $('body').on('click', '.brisanjeuserame', function(e){
    if(!confirm("Da li ste sigurni da želite da obrišete profil?")){
      return false;  
    }
  });

//----------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------

  //hendleri za klikove na info ikone u formi za dopunu ili promenu podataka korisnika u profil.blade.php

  //klik na info ikonu kod polja za unos imena u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infoime', function(e){
    //iskluci dalje klikove na ikonu
    $('#infoime').bind('click', false);
    //uzimamo sirinu prvog inputa da bi mogli da odredimo sirine .infodiv-ova
    var width = $('#imekorisnika').width();
    width = width + 23;
    //alert(width);
    var infoime = '';//pravimo div koji se ubacuje ispod polja za unos imena
    infoime += '<div class="help-block infodiv" id="infoimediv" style="width: '+width+'px;">';
    infoime += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoriimekorisnikainfo">';
    infoime += 'Ovo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti imeOvo polje je obavezno! Mozete izmeniti ime.&nbsp;';
    infoime += '</div>';
    $(infoime).insertAfter($('#imekorisnika'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infoimediv
  $('body').on('click', '#zatvoriimekorisnikainfo', function(e){
    $('#infoimediv').remove();
    $('#infoime').unbind('click', false);
  });
//----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja za unos grada u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infograd', function(e){
    //iskluci dalje klikove na ikonu
    $('#infograd').bind('click', false);
    //uzimamo sirinu prvog inputa da bi mogli da odredimo sirine .infodiv-ova
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infograd = '';//pravimo div koji se ubacuje ispod polja za unos grada
    infograd += '<div class="help-block infodiv" id="infograddiv" style="width: '+width+'px;">';
    infograd += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvorigradkorisnikainfo">';
    infograd += 'Ovo polje je obavezno! Mozete promeniti grad.Ovo polje je obavezno! Mozete promeniti gradOvo polje je obavezno! Mozete promeniti gradOvo polje je obavezno! Mozete promeniti gradOvo polje je obavezno! Mozete promeniti grad&nbsp;';
    infograd += '</div>';
    $(infograd).insertAfter($('#grad'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infograddiv
  $('body').on('click', '#zatvorigradkorisnikainfo', function(e){
    $('#infograddiv').remove();
    $('#infograd').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja za unos telefona u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infotelefon', function(e){
    //iskluci dalje klikove na ikonu
    $('#infotelefon').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infotelefon = '';//pravimo div koji se ubacuje ispod polja za unos telefona
    infotelefon += '<div class="help-block infodiv" id="infotelefondiv" style="width: '+width+'px;">';
    infotelefon += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoritelefonkorisnikainfo">';
    infotelefon += 'Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.Ovo polje je obavezno! Mozete uneti samo brojeve.&nbsp;';
    infotelefon += '</div>';
    $(infotelefon).insertAfter($('#telefonkorisnika'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infotelefondiv
  $('body').on('click', '#zatvoritelefonkorisnikainfo', function(e){
    $('#infotelefondiv').remove();
    $('#infotelefon').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja prikazi E-mail u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infoemail', function(e){
    //iskluci dalje klikove na ikonu
    $('#infoemail').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infoemail = '';//pravimo div koji se ubacuje ispod polja za biranje da li je E-mail vidljiv korisnicima
    infoemail += '<div class="help-block infodivorange" id="infoemaildiv" style="width: '+width+'px;">';
    infoemail += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoriemailkorisnikainfo">';
    infoemail += 'Ukoliko odaberete opciju "Da" svaki korisnik koji pregleda neki od vasih oglasa videce i vasu email adresu koju ste uneli pri registraciji';
    infoemail += '</div>';
    $(infoemail).insertAfter($('#prikaziemail'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infoemaildiv
  $('body').on('click', '#zatvoriemailkorisnikainfo', function(e){
    $('#infoemaildiv').remove();
    $('#infoemail').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja Pravno Lice u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infopravnolice', function(e){
    //iskluci dalje klikove na ikonu
    $('#infopravnolice').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infopl = '';//pravimo div koji se ubacuje ispod polja za biranje - Pravno/Fizicko Lice
    infopl += '<div class="help-block infodivorange" id="infopravnolicediv" style="width: '+width+'px;">';
    infopl += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoripravnoliceinfo">';
    infopl += 'Ukoliko ste pravno a ne fizicko lice preporucljivo je da odaberete opciju "Da", mada nije obavezno.';
    infopl += '</div>';
    $(infopl).insertAfter($('#pravnolice'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infopravnolicediv
  $('body').on('click', '#zatvoripravnoliceinfo', function(e){
    $('#infopravnolicediv').remove();
    $('#infopravnolice').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja Adresa u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infoadresa', function(e){
    //iskluci dalje klikove na ikonu
    $('#infoadresa').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infoadresa = '';//pravimo div koji se ubacuje ispod polja za unos adrese
    infoadresa += '<div class="help-block infodivorange" id="infoadresadiv" style="width: '+width+'px;">';
    infoadresa += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoriadresainfo">';
    infoadresa += 'Polje nije obavezno. Ukoliko zelite da vas potencijalni kupci lakse pronadju mozete uneti vasu adresu ili adresu vaseg auto salona ili auto placa ukoliko ste vlasnik istog. Ukoliko unesete adresu bice vidljiva u svakom vasem oglasu.';
    infoadresa += '</div>';
    $(infoadresa).insertAfter($('#adresakorisnika'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infoadresadiv
  $('body').on('click', '#zatvoriadresainfo', function(e){
    $('#infoadresadiv').remove();
    $('#infoadresa').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja Telefon 2 u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infotelefon2', function(e){
    //iskluci dalje klikove na ikonu
    $('#infotelefon2').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infotelefon2 = '';//pravimo div koji se ubacuje ispod polja za unos Telefona 2
    infotelefon2 += '<div class="help-block infodivorange" id="infotelefon2div" style="width: '+width+'px;">';
    infotelefon2 += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoritelefon2info">';
    infotelefon2 += 'Polje nije obavezno. Ukoliko imate dva telefona na koji vas potencijalni kupci mogu kontaktirati drugi telefon mozete upisati ovde. U polje se mogu uneti samo brojevi. Ukoliko unesete telefon 2, bice vidljiv u svakom vasem oglasu.';
    infotelefon2 += '</div>';
    $(infotelefon2).insertAfter($('#telefon2'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infotelefon2div
  $('body').on('click', '#zatvoritelefon2info', function(e){
    $('#infotelefon2div').remove();
    $('#infotelefon2').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja Telefon 3 u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infotelefon3', function(e){
    //iskluci dalje klikove na ikonu
    $('#infotelefon3').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infotelefon3 = '';//pravimo div koji se ubacuje ispod polja za unos Telefona 2
    infotelefon3 += '<div class="help-block infodivorange" id="infotelefon3div" style="width: '+width+'px;">';
    infotelefon3 += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvoritelefon3info">';
    infotelefon3 += 'Polje nije obavezno. Ukoliko imate tri telefona na koji vas potencijalni kupci mogu kontaktirati treci telefon mozete upisati ovde. U polje se mogu uneti samo brojevi. Ukoliko unesete telefon 3, bice vidljiv u svakom vasem oglasu.';
    infotelefon3 += '</div>';
    $(infotelefon3).insertAfter($('#telefon3'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infotelefon3div
  $('body').on('click', '#zatvoritelefon3info', function(e){
    $('#infotelefon3div').remove();
    $('#infotelefon3').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod polja Logo u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infologo', function(e){
    e.preventDefault()
    //iskluci dalje klikove na ikonu
    $('#infologo').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infologo = '';//pravimo div koji se ubacuje ispod polja za unos Telefona 2
    infologo += '<div class="help-block infodivorange" id="infologodiv" style="width: '+width+'px;">';
    infologo += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvorilogoinfo">';
    infologo += 'Polje nije obavezno. Ukoliko zelite da pored svakog vaseg oglasa bude logo vase firme ili vasa slika mozete je ovde dodati. JPG je jedini dozvoljeni format.';
    infologo += '</div>';
    $(infologo).insertAfter($('#inputimages'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infologodiv
  $('body').on('click', '#zatvorilogoinfo', function(e){
    $('#infologodiv').remove();
    $('#infologo').unbind('click', false);
  });
  //----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na info ikonu kod google map-e u formi za dopunu i menjanje podataka korisnika u profil.blade.php
  $('body').on('click', '#infomapa', function(e){
    e.preventDefault()
    //iskluci dalje klikove na ikonu
    $('#infomapa').bind('click', false);
    var width = $('#imekorisnika').width();
    width = width + 23;
    var infomapa = '';//pravimo div koji se ubacuje ispod polja za unos Telefona 2
    infomapa += '<div class="help-block infodivmap" id="infomapdiv" style="width: '+width+'px;">';
    infomapa += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvorimapinfo">';
    infomapa += 'Ukoliko zelite da u svakom vasem oglasu bude prikazana mapa sa naznacenom vasom lokacijom ovde je mozete podesiti. Potrebno je da zumirate mapu dok vasa lokacija ne bude jasno vidljiva i zatim klikom na vasu lokaciju unosite potrebne parametre koji ce biti upisani u polja Lat, Lng i Zoom.';
    infomapa += '</div>';
    $(infomapa).insertAfter($('.mapinfop'));
  });
  //klik na x tj ikonicu za zatvaranje infodiva #infodivmap
  $('body').on('click', '#zatvorimapinfo', function(e){
    $('#infomapdiv').remove();
    $('#infomapa').unbind('click', false);
  });
 
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //-------------------------------------------------------------------------------------------------------------------------
  // FUNKCIJA ZA PRIKAZ GOOGLE MAP-e
  //-------------------------------------------------------------------------------------------------------------------------
  //var x = 44.818611; // koordinate srbije
  //console.log(latituda);
  var x;
  var y;
  var z;
  //ako varijable latituda, longituda i zoom1(definisane su pri dnu profil.blade.php) nisu null to znaci da je korisnik vec uneo mapu, pa ce 
  //prilikom crtanja mape biti koriscene te koordinate, u suprotnom zadajemo koordinate i zoom da se vidi cela Srbija
  if(latituda != null && longituda != null && zoom1 != null){
    //userove koordinate i zoom
    x = latituda;
    y = longituda;
    z = zoom1;
  }else{
    //cela srbija
    x = 44.1;
    y = 20.468056;
    z = 7;
  }
    
  var center = new google.maps.LatLng(x, y);
  var map;
  //funkcija koju dole pozivamo da iscrta mapu
  function initialize(){
    var mapOptions = {
      zoom: z,
      center: center,
      mapTypeId: google.maps.MapTypeId.TERRAIN 
      //mapTypeId: google.maps.MapTypeId.SATELLITE
      //mapTypeId: google.maps.MapTypeId.HYBRID // HYBRID je mesavina satelitskog snimka i mape tako da ima ucrtane granice imena gradova i slicno...
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  }
    
  //klik na naslov tj <h1> .naslovdodajpodatkekorisnika, kad se klikne treba da se pokaze forma koja je ispod njega a ima attr hidden="true"
  // posto forma ima mogucnost dodavanja google mape takodje se u ovom hendleru nalaze funkcije koje crtaju GM i hendleri za klik na nju
  $('.naslovdodajpodatkekorisnika').on('click', function(){
    $(this).removeClass('shadow');
  	//uklanjamo atribut hidden i div .formadodajpodatkekorisnika u kom je forma za dodavanje podataka korisnika postaj vidljiv
  	$('.formadodajpodatkekorisnika').removeAttr('hidden');
    //pozivamo initialize() funkciju da iscrta google map ispod forme za dopunu podataka korisnika
    initialize(); 
    //hendler za klik na googlemap-u  
    google.maps.event.addListener(map, 'click', function(event){ 
      $('#lat').val(event.latLng.lat()); // popuni input za latitiudu
      $('#lng').val(event.latLng.lng()); // popuni input za longitudu
      $('#zoom').val(map.getZoom()); // popuni input za zoom level
      placeMarker(event.latLng, map);//pozivamo funkciju placeMarker koja dodaje marker tamo gde korisnik klikne na mapi
    });
    //funkcija koja crta ikonu na mapi tamo gde korisnik klikne
    function placeMarker(position, map) {
      //var image = 'http://auto.dev/img/kolasacenomikona.png';
      var image = slikeurl+'/img/kolasacenomikona.png';
      var marker = new google.maps.Marker({
        position: position,
        map: map,
        icon: image
      });  
      map.panTo(position);
    }

  });
  
  //ako se google map prikazuje kad verifikacija u UsersControlleru vrati error, tj ne na klik na h1 .naslovdodajpodatkekorisnika onda ovde poziv-
  //-amo initialize() funkciju koja je crta
  initialize(); 
  //hendler za klik na googlemap-u  
  google.maps.event.addListener(map, 'click', function(event){ 
    $('#lat').val(event.latLng.lat()); // popuni input za latitiudu
    $('#lng').val(event.latLng.lng()); // popuni input za longitudu
    $('#zoom').val(map.getZoom()); // popuni input za zoom level
    placeMarker(event.latLng, map);//pozivamo funkciju placeMarker koja dodaje marker tamo gde korisnik klikne na mapi
    // var lat = toString($('#lat').val(event.latLng.lat()));
    // var lng = toString($('#lng').val(event.latLng.lat()));
    // alert(lat+', '+lng);
  });
  //funkcija koja crta ikonu na mapi tamo gde korisnik klikne
  function placeMarker(position, map) {
    var image = 'http://auto.dev/img/kolasacenomikona.png';
    var marker = new google.maps.Marker({
      position: position,
      map: map,
      icon: image
    });  
    map.panTo(position);
  }
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //ako user ima dodat logo onda u formi za dodavanje i izmenu podataka u profil.blade.php postoji pored logo-a btn Obrisi Logo, ovde je njegov-
  //hendler koji salje obrisilogo() metodu UsersControllera AJAX u kom je id usera koji ce obrisati logo 
  $('.obrisilogo').on('click', function(e){
    var userid = $(this).attr('userid');//iz atributa userid btn-a koji smo kliknuli uzimamo id usera
    //alert(userid);
    //saljemo AJAX obrisilogo() metodu UsersControllera preko rute obrisilogo(url i _token su definisani na dnu vjua profil.blade.php) i saljemo
    //id usera ciji logo se brise posto se folder u kom je logo zove po id-u usera
    $.ajax({ 
      method: 'POST',
      url: urlbrisilogo,
      data: { userid: userid, _token: token }
    })//kad stigne odgovor od kontrolera tj kad obrise logo
    .done(function(o){
      //console.log(o);
      if(o == 1){
        //ovo se ubacuje na vrh profil.blade.php u tabelu koja prikazuje osnovne podatke usera, tj menjamo sliku na difoltnu posto nema vise logo
        var output1 = '<img src="img/how-work3.png" alt="">';
        $('.tbl-logo').html(output1);
        //pravimo html koji ce se ubaciti u formu pored inputa za upload fajla, ovo je siva slika sa neta koju po difoltu prikazuejmo dok user
        //nema logo. pa posto ga je sada obrisao vracamo tu sliku
        var output2 = '<img src="http://placehold.it/100x100" id="showimages" style="max-width:200px;max-height:200px;float:left;">';
        //uklanjamo logo koji je do sada bio prikazan useru(tj njegov bivsi logo) u formi pored inputa za upload fajla
        $('#showimages').remove();
        //uklanjamao btn za brisanje logo-a posto user nema vise logo
        $('.obrisilogo').remove();
        //ubacujemo html iza inputa za upload fajla u formi u profil.blade.php
        $(output2).insertAfter($('#inputimages'));
      }
    });
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //ako user ima dodatu mapu onda u formi za dodavanje i izmenu podataka u profil.blade.php postoji iznad mape btn Obrisi MApu, ovde je njegov-
  //hendler koji salje obrisimapu() metodu UsersControllera AJAX u kom je id usera koji ce obrisati mapu tj koordinate iz 'users' tabele 
  $('.obrisimapu').on('click', function(e){
    var userid = $(this).attr('userid');//iz atributa userid btn-a koji smo kliknuli uzimamo id usera
    //saljemo AJAX obrisimapu() metodu UsersControllera preko rute obrisimapu(url i _token su definisani na dnu vjua profil.blade.php) i saljemo
    //id usera cija mapa se brise da bi ga nasli po njemu u 'users' tabeli i vratili kolone lat, lng i zoom na NULL
    $.ajax({ 
      method: 'POST',
      url: urlbrisimapu,
      data: { userid: userid, _token: token }
    })//kad stigne odgovor od kontrolera tj kad obrise logo
    .done(function(o){
      console.log(o);
      $('.obrisimapu').remove();
      var output = 'Dodaj Mapu';
      $('#izmenimapu').text(output);
      $('#lat').val(''); // isprazni input za latitiudu
      $('#lng').val(''); // isprazni input za longitudu
      $('#zoom').val(''); // isprazni input za zoom level
      //nove koordinate tj opet prikazujemo mapu cele srbije
      x = 44.1;
      y = 20.468056;
      z = 7;
      //pozivamo initialize() da nacrta mapu
      initialize(); 
      //hendler za klik na googlemap-u  
      google.maps.event.addListener(map, 'click', function(event){ 
        $('#lat').val(event.latLng.lat()); // popuni input za latitiudu
        $('#lng').val(event.latLng.lng()); // popuni input za longitudu
        $('#zoom').val(map.getZoom()); // popuni input za zoom level
        placeMarker(event.latLng, map);//pozivamo funkciju placeMarker koja dodaje marker tamo gde korisnik klikne na mapi
      });
      //funkcija koja crta ikonu na mapi tamo gde korisnik klikne
      function placeMarker(position, map) {
        var image = 'http://auto.dev/img/kolasacenomikona.png';
        var marker = new google.maps.Marker({
          position: position,
          map: map,
          icon: image
        });  
        map.panTo(position);
      }
    });
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na ikonu X .closebtn dodaje divu .formadodajpodatkekorisnika atribut hidden="true"
  $('.closebtn').on('click', function(){
  	$('.formadodajpodatkekorisnika').attr('hidden', 'true');
    $('.naslovdodajpodatkekorisnika').addClass('shadow');
    // $('#lat').val(''); // popuni input za latitiudu
    // $('#lng').val(''); // popuni input za longitudu
    // $('#zoom').val(''); // popuni input za zoom level
  	//takodje posto postoji mogucnost da smo nesto vec unosili u formu, brisemo div koji je vidljiv kad kontroller vrati success poruku
  	$('.success-message').remove();
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //zatvaranje diva koji u profil.blade.php prikazuje upravo uneti oglas korisnika
  $('body').on('click', '.closenovioglas', function(){
    $('.novioglasprofilusera').remove();
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //klik na h1 .naslovoglasikorisnika koji skida hidden atribut sa diva .oglasikorisnikaprofil koji prikazuje sve do sada dodate oglase korisnika 
  $('.naslovoglasikorisnika').on('click', function(){
    //skidamo hidden atribut
    $('.oglasikorisnikaprofil').removeAttr('hidden');  
    $(this).removeClass('shadow');//uklanjamo senku sa h1
  });
  //klik na x ikonu .closeoglasikorisnikabtn za zatvaranje diva .oglasikorisnikaprofil tj vracanje atributa hidden istom
  $('.closeoglasikorisnikabtn').on('click', function(){
    $('.oglasikorisnikaprofil').attr('hidden', 'true');
    $('.naslovoglasikorisnika').addClass('shadow');
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //odobravanje neodobrenog oglasa tj klik na btn .odobrioglas koji admin vidi pored neodobrenih oglasa u profil.blade.php
  $('body').on('click', '.odobrioglas', function(){
    var odobrioglasid =  $(this).attr('oglasid');
    //saljemo AJAX u metod odobrioglas() OglasControllera i u njemu id oglasa koji odobrava admin i _token
    $.ajax({ 
      method: 'POST',
      url: urlodobrioglas,
      data: { oglasid: odobrioglasid, _token: token }
    })//kad stigne odgovor od kontrolera
    .done(function(o){
      console.log(o.oglas.odobren);
      //ako je oglas uspesno odobren tj kolona odobren vracenog oglasa(posto metod odobrioglas vraca ceo odobren oglas) je 1
      if(o.oglas.odobren == 1){ 
        $('#odobrioglasbtn'+o.oglas.id).remove();//uklanjamo btn za odobravanje
        $('#spanoglasneodobren'+o.oglas.id).remove();//uklanjamo span koji pored datuma postavljanja ispisuje da je oglas neodobren
        //crtamo btn za zabranjivanje oglasa i stavljamo ga ispod btn za brisanje oglasa
        var out = '';
        out += '<button type="button" id="zabranioglasbtn'+o.oglas.id+'" class="btn btn-warning btn-block zabranioglas" oglasid="'+o.oglas.id+'">';
        out += 'Zabrani Oglas';
        out += '</button>';
        $(out).insertAfter('#obrisioglasbtn'+o.oglas.id);
        //<span id="spanoglasodobren{{ $oglas->id }}" class="text-success"><b>Ododbren</b></span>
        var out1 = '';
        out1 += '<span id="spanoglasodobren'+o.oglas.id+'" class="text-success"><b>Ododbren</b></span>';
        $(out1).appendTo($('#datumiodobren'+o.oglas.id));
      }else{ //ako je doslo do neke greske pa kolona odobren oglasa koji smo pokusali da odobrimo nije 1
        alert('Došlo je do greške, trenutno nije moguće odobriti oglas, pokušajte kasnije.');
      }
    });
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //zabranjivanje odobrenog oglasa tj klik na btn .zabranioglas koji admin vidi pored odobrenih oglasa u profil.blade.php
  $('body').on('click', '.zabranioglas', function(){
    var zabranioglasid =  $(this).attr('oglasid');
    //saljemo AJAX u metod zabranioglas() OglasControllera i u njemu id oglasa koji zabranjuje admin i _token
    $.ajax({ 
      method: 'POST',
      url: urlzabranioglas,
      data: { oglasid: zabranioglasid, _token: token }
    })//kad stigne odgovor od kontrolera
    .done(function(o){
      console.log(o.oglas.odobren);
      //ako je oglas uspesno odobren tj kolona odobren vracenog oglasa(posto metod zabrani vraca ceo odobren oglas) je 1
      if(o.oglas.odobren == 0){ 
        $('#zabranioglasbtn'+o.oglas.id).remove();//uklanjamo btn za odobravanje
        $('#spanoglasodobren'+o.oglas.id).remove();//uklanjamo span koji pored datuma postavljanja ispisuje da je oglas neodobren
        //crtamo btn za odobravanje oglasa i stavljamo ga ispod btn za brisanje oglasa
        var out = '';
        out += '<button type="button" id="odobrioglasbtn'+o.oglas.id+'" class="btn btn-success btn-block odobrioglas" oglasid="'+o.oglas.id+'">';
        out += 'Odobri Oglas';
        out += '</button>';
        $(out).insertAfter('#obrisioglasbtn'+o.oglas.id);
        //
        var out1 = '';
        out1 += '<span id="spanoglasneodobren'+o.oglas.id+'" class="text-danger"><b>Neododbren</b></span>';
        $(out1).appendTo($('#datumiodobren'+o.oglas.id));
      }else{ //ako je doslo do neke greske pa kolona odobren oglasa koji smo pokusali da odobrimo nije 1
        alert('Došlo je do greške, trenutno nije moguće zabraniti oglas, pokušajte kasnije.');
      }
    });
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  //brisanje oglasa tj klik na btn obrisioglas u profil.blade.php pored nekog od prikazanih oglasa korisnika
  $('body').on('click', '.obrisioglas', function(){
    var idoglasazabrisanje = $(this).attr('idoglasa');//uzimamo id oglasa
    if(confirm("Da li ste sigurni da želite da obrišete ovaj oglas?")){//ako admin ili user kliknu OK u confirm pop-up-u
      $.ajax({ //saljemo AJAX metodu obrisi oglas OglasControllera i u njemu id oglasa koji se brise
        method: 'POST',
        url: urlobrisioglas,
        data: { oglasid: idoglasazabrisanje, _token: token }
      })// kad kontroler vrati odgovor
      .done(function(o){
        console.log(o);
        if(o.delete == true){ // ako je obrisan oglas tj o.delete == true
          $('#prikazoglasa'+o.idoglasa).remove();//ulanjamo prikaz obrisanog oglasa
          $('#hr'+o.idoglasa).remove();
          //u tabeli koja na vrhu profil.blade.php prikazuje podatke usera ubacujemo novi broj oglasa usera ciji je oglas obrisan
          $('#brojoglasausera').html(o.brojoglasa);
        }else{//ako oglas nije obrisan tj o.delete != true, izbacujemo alert da oglas nije obrisan
          alert('Brisanje oglasa nije uspelo, pokušajte ponovo.')
        }
      });
    }
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------



});	





