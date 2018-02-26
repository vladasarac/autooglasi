$(document).ready(function(){

//ovde su hendleri za vju rezpretrage.blade.php

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

var dpi_x = document.getElementById('dpi').offsetWidth;
var widthekrana = $(window).width() / dpi_x;
if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
  $(".small").contents().unwrap();
}

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
      //$('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      //$('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
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

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
//menjanje opcije u selectu .sortiranjeoglasa u rezpretrage.blade.php tj sortiranje prikaza oglasa po nekoj koloni tabele 'oglasis'
$('.sortiranjeoglasa').on('change', function(){
  //uzimamo atribut sortirajpo odabranog optiona selecta u kom pise po kojoj koloni da se sortira
  var sort = $('option:selected', this).attr('sort');
  //uzimamo atribut ascdesc odabranog optiona selecta u kom pise da li da sortira uzlazno-ASC ili silazno-DESC
  var ascdesc = $('option:selected', this).attr('ascdesc');
  //pravimo url sa svim parametrima pretrage, oni su pobrojani na dnu vjua rezpretrage.blade.php
  //alert(oglasikorisnika);
  var url = frontpretraga+'?sort='+sort+'&ascdesc='+ascdesc+'&markaautomobila='+markaautomobila+'&modelmarke='+modelmarke+'&gor='+gor+'&godod='+godod+'&goddo='+goddo+'&cod='+cod+'&cdo='+cdo+'&kar='+kar+'&kubod='+kubod+'&kubdo='+kubdo+'&ost='+ost+'&detpretr0ili1='+detpretr0ili1+'&emkl='+emkl+'&snod='+snod+'&sndo='+sndo+'&kilod='+kilod+'&kildo='+kildo+'&poreklo='+poreklo+'&pog='+pog+'&menj='+menj+'&brvr='+brvr+'&brsed='+brsed+'&strvol='+strvol+'&kli='+kli+'&boja='+boja+'&por='+por+'&airb='+airb+'&cloc='+cloc+'&abs='+abs+'&esp='+esp+'&asr='+asr+'&alrm='+alrm+'&kodk='+kodk+'&zdr='+zdr+'&blkm='+blkm+'&cbr='+cbr+'&mboj='+mboj+'&svol='+svol+'&mvol='+mvol+'&tmpt='+tmpt+'&prac='+prac+'&sibr='+sibr+'&pkr='+pkr+'&elpo='+elpo+'&elr='+elr+'&gret='+gret+'&elps='+elps+'&gsed='+gsed+'&szm='+szm+'&xen='+xen+'&led='+led+'&senzzs='+senzzs+'&senzzk='+senzzk+'&senzzp='+senzzp+'&krno='+krno+'&kzv='+kzv+'&aluf='+aluf+'&nav='+nav+'&rdio='+rdio+'&cdp='+cdp+'&dvd='+dvd+'&wbs='+wbs+'&grve='+grve+'&koza='+koza+'&prv='+prv+'&knus='+knus+'&gar='+gar+'&garaz='+garaz+'&serknj='+serknj+'&rezklj='+rezklj+'&tun='+tun+'&old='+old+'&test='+test+'&taxi='+taxi+'&oglasikorisnika='+oglasikorisnika;
  //pozivamo taj url tj saljemo request metodu pretraga() FrontControllera
  window.location.href = url;

});


//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

});