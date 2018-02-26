$(document).ready(function(){

//ovde su hendleri za vju adminoglasi.blade.php

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




});


