$(document).ready(function(){

//ovde su hendleri za vju adminoglasioilin.blade.php

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

//klik na h1 .naslovprikaziformuzapretragu koji kad se klikne div-u #adminoglasiformazapretragu uklanja atribut hidden="true"
$('body').on('click', '.naslovprikaziformuzapretragu', function(){
  $(this).removeClass('shadow');
  //uklanjamo atribut hidden i div .adminoglasiformazapretragu u kom je forma za pretragu oglasa na vrhu adminoglasioilin.blade.php
  $('#adminoglasiformazapretragu').removeAttr('hidden');
});
//klik na x ikonu iznad forme za pretragu oglasa kojim se forma opet sakriva
$('body').on('click', '.zatvoriformuzapretragu', function(){
  //divu koji prikazuje formu tj #adminoglasiformazapretragu dodajemo atribut hidden="true" a naslovu .naslovprikaziformuzapretragu vracamo
  //klasu shadow pa sada opet izgleda kao veliki btn
  $('#adminoglasiformazapretragu').attr('hidden', 'true');
  $('.naslovprikaziformuzapretragu').addClass('shadow');
});

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

//klik na h4 .svipodatcioglasa kod nekog neodobrenog ili odobrenog oglasa u adminoglasi.blade.php
$('body').on('click', '.svipodatcioglasa', function(){
  var id = $(this).attr('oglasid');
  var oilin = $(this).attr('oglasoilin'); 
  //alert(id);
  $(this).attr('hidden', 'true');
  $('#podatcioglasa'+id).removeAttr('hidden');
  if(oilin == 0){
    $('#oglas'+id).addClass('svetlijapozadinaneodobren');
  }else{
    $('#oglas'+id).addClass('svetlijapozadinaodobren');
  }
});

//zatvaranje ostalih podataka neodobrenog ili odobrenog oglasa
$('body').on('click', '.zatvorisvepodatkeoglasa', function(){
  var id = $(this).attr('oglasid');
  var oilin = $(this).attr('oglasoilin'); 
  //alert(id);
  $('#podatcioglasa'+id).attr('hidden', 'true');
  $('#svipodatci'+id).removeAttr('hidden');
  if(oilin == 0){
    $('#oglas'+id).removeClass('svetlijapozadinaneodobren');
  }else{
    $('#oglas'+id).removeClass('svetlijapozadinaodobren');
  }
});

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
  
//brisanje oglasa tj klik na btn obrisioglas u adminoglasi.blade.php pored nekog od prikazanih oglasa 
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
        $('#oglas'+o.idoglasa).remove();//ulanjamo prikaz obrisanog oglasa
      }else{//ako oglas nije obrisan tj o.delete != true, izbacujemo alert da oglas nije obrisan
        alert('Brisanje oglasa nije uspelo, pokušajte ponovo.')
      }
    });
  }
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //odobravanje neodobrenog oglasa tj klik na btn .odobrioglasadminoglasi koji admin vidi pored neodobrenih oglasa u adminoglasi.blade.php
  $('body').on('click', '.odobrioglasadminoglasi', function(){
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
        out += '<button type="button" style="margin-left: 3px;" id="zabranioglasbtn'+o.oglas.id+'" class="btn btn-warning zabranioglasadminoglasi" oglasid="'+o.oglas.id+'">';
        out += 'Zabrani Oglas';
        out += '</button>';
        $(out).insertAfter('#obrisioglasbtn'+o.oglas.id);
        $('#oglas'+o.oglas.id).css('background-color', '#c7edc7');//divu koji prikazuje odobreni oglas menjamo boju pozdine
      }else{ //ako je doslo do neke greske pa kolona odobren oglasa koji smo pokusali da odobrimo nije 1
        alert('Došlo je do greške, trenutno nije moguće odobriti oglas, pokušajte kasnije.');
      }
    });
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //zabranjivanje odobrenog oglasa tj klik na btn .zabranioglasadminoglasi koji admin vidi pored odobrenih oglasa u adminoglasi.blade.php
  $('body').on('click', '.zabranioglasadminoglasi', function(){
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
        //crtamo btn za odobravanje oglasa i stavljamo ga iza btn za brisanje oglasa
        var out = '';
        out += '<button type="button" style="margin-left: 3px;" id="odobrioglasbtn'+o.oglas.id+'" class="btn btn-success odobrioglasadminoglasi" oglasid="'+o.oglas.id+'">';
        out += 'Odobri Oglas';
        out += '</button>';
        $(out).insertAfter('#obrisioglasbtn'+o.oglas.id);
        $('#oglas'+o.oglas.id).css('background-color', '#f4dbd9');//divu koji prikazuje zabranjeni oglas menjamo boju pozdine
      }else{ //ako je doslo do neke greske pa kolona odobren oglasa koji smo pokusali da odobrimo nije 1
        alert('Došlo je do greške, trenutno nije moguće zabraniti oglas, pokušajte kasnije.');
      }
    });
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //kad se promeni option u selectu za marku automobila
  $('#markaautomobila').on('change', function(){
    var marka = $('option:selected', this).text();//uzimamo text optiona tj ime marke
    //alert(marka);
    var idmarke = $('option:selected', this).attr('markaid');//uzimamo id marke
    //ako je user izabrao opet prazan option za marku
    if(marka == ''){
      //generisemo opet prazan select za biranje modela kao na pocetku(jer je mozda user izabrao u polju za model ostalo... pa je onda
      //select za izbor modela pretvoren u text input pa sada vracamo u prvobitno stanje) 
      var out1 = '<select name="modelmarke" id="modelmarke" class="form-control">'; 
      out1 += '<option id="prazanoptionzamodele"></option></select>';
      $('#modelmarke').remove();//brisemo input za upis modela(bez obzira da li je select ili text input)
      $(out1).insertAfter('#modelautomobilalabel');//ubacujemo novi select za izbor modela ispod labela za naslov polja za model
      //$('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      //$('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
      //proveramodela = 0;//takodje opet varijable za proveru polja za model vracamo na 0 i za errormodela vracamo kako je bilo 
      //errormodela = '<br><b>"Model"</b> je obavezno polje!';
    }else{//ako je user selectovao neku marku saljemo AJAX u metod izvadimodele() OglasControllera koji vadi sve modele te marke
      $.ajax({ //saljemo metodu id marke , izvadimodelurl je definisan na dnu vjua to je ruta '/izvadimodele'
        method: 'POST',
        url: izvadimodeleurl,
        data: { idmarke: idmarke, _token: token }
      })
      //kad kontroler vrati odgovor pravimo optione za select modela i lepimo ih na select #modelmarke tako da se moze birati model
      .done(function(o){
         console.log(o);
         var out = '';
         out += '<select name="modelmarke" id="modelmarke" class="form-control">';
         out += '<option></option>';
         for(var i = 0; i < o['modeli'].length; i++){ 
           out += '<option value="'+o['modeli'][i]['ime']+'">'+o['modeli'][i]['ime']+'</option>'; 
         }
         //ako user medju ponudjenim modelima ne nadje sta mu treba moze izabrati ovu opciju i hendler za change selecta #modelmarke ako 
         //user izabere ovu opciju polje iz selecta pretvara u text input u koji user moze ukucati model
         out += '<option value="ostalo">Ostalo...</option>';
         out += '</select>';
         //alert(out);
         $('#modelmarke').remove();
         $('#modelmarkeselect').html(out);
      });
    }
    //alert(idmarke);   
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  //ako admin medju ponudjenim modelima ne nadje ono sto trazi (tj klikne opciju Ostalo...) select za model uklanjamo i umesto njega pravimo
  // text input koji se takodje zove modelmarke
  $('body').on('change', '#modelmarke', function(){
    var model = $('option:selected', this).text();//uzimamo text optiona tj ime modela
    if(model == 'Ostalo...'){
      var o = '<input type="text" class="form-control obaveznopolje" name="modelmarke" id="modelmarke">';
      $('#modelmarke').remove();//uklanjamo select za biranje modela
      $(o).insertAfter('#modelautomobilalabel');//ubacujemo izgenerisani text input umesto selecta
      //$('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      //$('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
      //errormodela = '<br><b>"Model"</b> je obavezno polje!';//vracamo errormodela i proveramodela na prvobitno stanje
      //proveramodela = 0;
    }
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
//menjanje opcije u selectu .sortiranjeoglasa u adminoglasioilin.blade.php tj sortiranje prikaza oglasa po nekoj koloni tabele 'oglasis'
$('.sortiranjeoglasa').on('change', function(){
  //uzimamo atribut sortirajpo odabranog optiona selecta u kom pise po kojoj koloni da se sortira
  var sort = $('option:selected', this).attr('sort');
  //uzimamo atribut ascdesc odabranog optiona selecta u kom pise da li da sortira uzlazno-ASC ili silazno-DESC
  var ascdesc = $('option:selected', this).attr('ascdesc');
  //
  if(method == 1){   
    var url = adminoglasioilinurl+'/'+oilin+'?sort='+sort+'&ascdesc='+ascdesc;
  }else{
    var url = adminoglasipretragaurl+'?sort='+sort+'&ascdesc='+ascdesc+'&oilin='+oilin+'&markaautomobila='+markaautomobila+'&modelmarke='+modelmarke+'&gorivo='+gorivo+'&godisteod='+godisteod+'&godistedo='+godistedo+'&poreklo='+poreklo+'&kubikazaod='+kubikazaod+'&kubikazado='+kubikazado;
  }
  //
  window.location.href = url;
});

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  

});













