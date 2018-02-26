$(document).ready(function(){

//ovde su hendleri za vju welcome.blade.php

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

var dpi_x = document.getElementById('dpi').offsetWidth;
var widthekrana = $(window).width() / dpi_x;
if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
  $(".small").contents().unwrap();
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//funkciju koristi hendler za klik na h1 .naslovjosoglasa, koji ucitava dodatne oglase za welcome.blade.php. Funkcija proverava da li postoji -
//- slika kad prikazuje naslovnu sliku oglasa
function FileExist(urlToFile){
  var xhr = new XMLHttpRequest();
  xhr.open('HEAD', urlToFile, false);
  xhr.send();

  if(xhr.status == "404") {
    console.log(urlToFile+" - File doesn't exist");
    return false;
  }else{
    console.log(urlToFile+" - File exists");
    return true;
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//variable za offset i limit kad josoglasa() FrontControllera vadi dodatne oglase(za sada se prikazuje po 6 oglasa pa je zato skip = 6)
var skip = 6;
var take = 6;
//hendler za klik na h3 .naslovjosoglasa tj ucitavanje dodatnih oglasa na welcome.blade.php, salje se AJAX u metod josoglasa() FrontControllera-
//-preko rute '/josoglasa', kad stigne odgovor pronadjene oglase ubacujemo ispod vec prikazanih oglasa
$('body').on('click', '.naslovjosoglasa', function(){
  $(this).removeClass('shadow');
  // salje se AJAX metodu josoglasa() FrontControllera koji vadi dodatne oglase za welcome.blade.php 
  $.ajax({ 
      method: 'POST',
      url: josoglasaurl,
      data: { take: take, skip: skip, _token: token }
    })//kad stigne odgovor kontrolera
    .done(function(o){
      skip = skip + take;
      console.log(o);
      //alert('skip: '+skip+'broglasa: '+ukupnooglasa);
      var out = '';
      for(var i = 0; i < o['oglasi'].length; i++){
        var d = new Date(o['oglasi'][i]['created_at']);
        var dmonth = parseInt(d.getMonth());
        dmonth++;
        //link ka jednom oglasu koj je ujedno i prikaz osnovnih podataka oglasa
        out += '<div class="col-md-6 jedanoglas oglasizwelcomejs" id="'+o['oglasi'][i]['id']+'"">';
        out += '<div class="col-md-5">';
        if(o['oglasi'][i]['slike'] != 0){
          for(var is = 1; is <= 12; is++){
            //posto ne znamo koja je slika naslovna tj prva iteriramo kroz slike i za svaku pozivamo FileExists() funkciju koja je napravljena-
            //iznad da proveri da li slika postoji, kad prvi put nadje sliku koja postoji prikazuje je
            if(FileExist(homeurl+"/img/oglasi/"+o['oglasi'][i]['folderslike']+"/"+o['oglasi'][i]['id']+"/"+is+".jpg")){
              out += '<img src="'+homeurl+'/img/oglasi/'+o['oglasi'][i]['folderslike']+'/'+o['oglasi'][i]['id']+'/thumb'+is+'.jpg?vreme='+new Date()+'" class="naslovnaslikapocetna">';
              break;
            }
          }
        }else{
          out += '<img src="'+homeurl+'/img/no_image_available1.jpg" class="naslovnaslikapocetna">';
        }
        out += '</div>';//kraj div-a .col-md-5
        //prikaz podataka oglasa
        out += '<div class="col-md-7 divosnovnipodatcioglasanaslovna">';
        out += '<div>';
        out += '<b>'+o['oglasi'][i]['marka']+'/'+o['oglasi'][i]['model']+'</b>';
        out += '&nbsp; <span class="cenanaslovna pull-right">'+o['oglasi'][i]['cena']+' &euro;</span>';
        out += '<p class="posnovnipodatcioglasanaslovna">';
        out += '<small>Postavljen: '+d.getDate()+'.'+dmonth+'.'+d.getFullYear()+'.'+'</small>';
        if(o['oglasi'][i]['ostecen'] == 1){
          out += ' &nbsp; <small style="color: red;"><b>Oštećen</b></small>';
        }  
        else if(o['oglasi'][i]['ostecen'] == 2){
          out += '&nbsp; <small style="color: red;"><b>Oštećen 100%</b></small>';
        }
        out += '<br><b>';
        //ako je ekran mali tj smartfon i slicno...
        if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
          out +='';
        }else{
          out += '<small class="small">';
        }
          if(o['oglasi'][i]['gorivo'] == 'dizel'){
            out += 'Dizel';
          }
          if(o['oglasi'][i]['gorivo'] == 'benzin'){
            out += 'Benzin';
          }
          if(o['oglasi'][i]['gorivo'] == 'benzingas'){
            out += 'Benzin+Gas';
          }
          if(o['oglasi'][i]['gorivo'] == 'metan'){
            out += 'Metan CNG';
          }
          if(o['oglasi'][i]['gorivo'] == 'elektricni'){
            out += 'Električni Pogon';
          }
          if(o['oglasi'][i]['gorivo'] == 'hibrid'){
            out += 'Hibrid';
          }
          out += '|'+o['oglasi'][i]['godiste']+' God.|'+o['oglasi'][i]['kubikaza']+' cm<sup>3</sup></b></br>';
          out += '<b>'+o['oglasi'][i]['snagaks']+'</b>KS/<b>'+o['oglasi'][i]['snagakw']+'</b>KW|<b>'+o['oglasi'][i]['karoserija']+'</b>';
          out += '<br>Kilometraža: <b>'+o['oglasi'][i]['kilometraza']+'</b> Km';
        if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
          out +='';
        }else{
          out += '</small>';
        }  
        out += '</p>';
        out += '</div>';//kraj div-a 
        out += '</div>';//kraj div-a .divosnovnipodatcioglasanaslovna
        out += '</div>';//kraj div-a .jedanoglas
      }
      //ako smo ucitali sve oglase tj variabla skip je veca od ukupno odobrenih oglasa u tabeli 'oglasis' uklanjamo h3 .naslovjosoglasa 
      if(skip >= ukupnooglasa){
        $('.naslovjosoglasa').remove();
      }
      //nove oglase koje je poslao metod josoglasa() FrontControllera ubacujemo ispred div-a .divispodoglasa koji je prazan i nalazi se 
      //prvih prikazanih oglasa
      $(out).insertBefore('.divispodoglasa');
      //opet dodajemo senku btn naslovu .naslovjosoglasa
      $('.naslovjosoglasa').addClass('shadow');
    });
});

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  //kad se klikne na neki od div-ova koji prikazuje dodatne oglase u welcome.blade.php koje je izgenerisao hendler iznad ovog
  $('body').on('click', '.oglasizwelcomejs', function(){
    //uzimamo id oglasa
    var idoglasa =  $(this).attr('id');
    //pravimo link ka ruti /oglas/{oglasid?} tj ka metodu prikazioglas() FrontControlelra koji se otvara u novom tabu i dajemo mu URL na 
    // - koji ovaj ide tj prikazuje taj oglas u novom tabu
    window.open(jedanoglasurl+'/'+idoglasa, '_blank');
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  //klik na h3 .naslovpretraga koji kad se klikne div-u .formapretraga uklanja atribut hidden="true"
  $('body').on('click', '.naslovpretraga', function(){
    //uklanjamo h3 .naslovpretraga tj dajemo mu attr hidden true
    $(this).attr('hidden', 'true');
    //uklanjamo atribut hidden i div .adminoglasiformazapretragu u kom je forma za pretragu oglasa na vrhu adminoglasioilin.blade.php
    $('.formapretraga').removeAttr('hidden');
  });
  //klik na x ikonu iznad forme za pretragu oglasa kojim se forma opet sakriva
  $('body').on('click', '.zatvoriformuzapretragu', function(){
    //divu koji prikazuje formu tj .formapretraga dodajemo atribut hidden="true" 
    $('.formapretraga').attr('hidden', 'true');
    //a naslovu .naslovpretraga uklanjamo atribut hidden="true" pa je opet vidljiv
    $('.naslovpretraga').removeAttr('hidden');
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //kad se promni option u selectu za marku automobila
  $('#markaautomobila').on('change', function(){
    var marka = $('option:selected', this).text();//uzimamo text optiona tj ime marke
    //alert(marka);
    var idmarke = $('option:selected', this).attr('markaid');//uzimamo id marke
    //ako je user izabrao opet prazan option za marku
    if(marka == ''){
      //generisemo opet prazan select za biranje modela kao na pocetku(jer je mozda user izabrao u polju za model ostalo... pa je onda
      //select za izbor modela pretvoren u text input pa sada vracamo u prvobitno stanje) 
      var out1 = '<select name="modelmarke" id="modelmarke" class="form-control obaveznopolje">'; 
      out1 += '<option id="prazanoptionzamodele"></option></select>';
      $('#modelmarke').remove();//brisemo input za upis modela(bez obzira da li je select ili text input)
      $(out1).insertAfter('#modelautomobilalabel');//ubacujemo novi select za izbor modela ispod labela za naslov polja za model
      proveramodela = 0;//takodje opet varijable za proveru polja za model vracamo na 0 i za errormodela vracamo kako je bilo 
      errormodela = '<br><b>"Model"</b> je obavezno polje!';
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
         out += '<select name="modelmarke" id="modelmarke" class="form-control obaveznopolje">';
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
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
 
  //ako user medju ponudjenim modelima ne nadje ono sto trazi (tj klikne opciju Ostalo...) select za model uklanjamo i umesto njega pravimo
  // text input koji se takodje zove modelmarke
  $('body').on('change', '#modelmarke', function(){
    var model = $('option:selected', this).text();//uzimamo text optiona tj ime modela
    if(model == 'Ostalo...'){
      var o = '<input type="text" class="form-control obaveznopolje" name="modelmarke" id="modelmarke">';
      $('#modelmarke').remove();//uklanjamo select za biranje modela
      $(o).insertAfter('#modelautomobilalabel');//ubacujemo izgenerisani text input umesto selecta
    }
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  //ako user klikne btn detaljna pretraga u formi za pretragu oglasa
  $('body').on('click', '#detaljna', function(){
    $(this).remove();
    $('#detpretr0ili1').val(1);//menja se vrednost atributa value hidden inputa #detpretraga da bi i kontroler to znao
    $('.detaljnapretraga').removeAttr('hidden');//div-u .detaljnapretraga u kom su polja za detaljnu pretrragu se uklanja atribut hidden     
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------


});