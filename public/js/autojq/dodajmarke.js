$(document).ready(function(){	
  //ovde su hendleri za dodajmarku.blade.php vju	

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na naslov tj <h1> .naslovdodajmarku, kad se klikne treba da se pokaze forma koja je ispod njega a ima attr hidden="true"
  $('.naslovdodajmarku').on('click', function(){
  	$('.formadodajmarku').removeAttr('hidden');//uklanjamo atribut hidden i div .formadodajmarku u kom je forma za dodavanje marke postaj vidljiv
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na ikonu X .closebtn dodaje divu .formadodajmarku atribut hidden="true"
  $('.closebtn').on('click', function(){
  	$('.formadodajmarku').attr('hidden', 'true');
  	//takodje posto postoji mogucnost da smo nesto vec unosili u formu, brisemo div koji je vidljiv kad kontroller vrati success poruku
  	$('.success-message').remove();
  });

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na ikonu X .closebtnsuccess uklanja div success-message koji prikazuje succeess poruke koje kontroler vraca u session-u
  $('.closebtnsuccess').on('click', function(){
    $('.success-message').remove();
  });
   
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na naslov tj <h1> .formadodajmodel, kad se klikne treba da se pokaze forma koja je ispod njega a ima attr hidden="true"
  $('.naslovdodajmodele').on('click', function(){
    $('.formadodajmodel').removeAttr('hidden');//uklanjamo atribut hidden i div .formadodajmodel u kom je forma za dodavanje modela postaj vidljiv
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na ikonu X .closebtnmodel dodaje divu .formadodajmodel atribut hidden="true"
  $('.closebtnmodel').on('click', function(){
    $('.formadodajmodel').attr('hidden', 'true');
    //takodje posto postoji mogucnost da smo nesto vec unosili u formu, brisemo div koji je vidljiv kad kontroller vrati success poruku
    $('.success-message').remove();
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //kad se u formi za dodavanje modela u selectu za biranje marke kojoj dodajemo model promeni marka menjamo i logo koji je prikazan tj menjamo-
  //src atribut img-a .logomarke, takodje se pojavljuje <p>.prikazimodelemarke koji ce kad se klikne poslati AJAX i prikazati sve do sada unete
  //modele marke i oni ce moci da se edituju
  $('#imemarke2').on('change', function(){
    var logo = $('option:selected', this).attr('logo');//uzmamo naziv slike(logo kolona markas tabele) koji je u atributu logo
    var marka = $('option:selected', this).text();//uzimamo text optiona tj ime marke
    var idmarke = $(this).val();//uzimamo id marke da bi <p> imao atribut idmarke(koj ce trebati kad se salje ajax)
    //uklanjamo div .modeli koji mozda postoji ako je user gledao do sada unete modele neke marke, taj div postoji ako je user kliknuo na 
    //div .prikazimodelemarke 
    $('.modeli').remove();
    $('.editmarke').remove();//uklanjamo div editmarke da bi umesto njega bio nacrtan novi za novoodabranu marku
    $('.editmarkeforma').remove();//takodje i div u koji se smesta forma za edit marke
    if(logo == undefined){//ako je logo undefined tj birali smo neku marku pa smo opet izabrali prazno polje u selectu
      $('.logomarke').attr('hidden', 'true');   //dodaj opet atribut hidden za img .logomarke
      $('.prikazimodelemarke').remove();//uklanjamo <p> .prikazimodelemarke
    }else{
      $('.prikazimodelemarke').remove();//uklanjamo <p> .prikazimodelemarke, ako je user vec birao neku marku pre...
      //menjamo src atribut img-a .logomarke koja prikazuje logo marke kojoj dodajemo model
      $('.logomarke').attr("src", "img/autologo/"+logo+"?vreme="+new Date()+"");
      $('.logomarke').removeAttr('hidden');//takodje uklanjamo atribut hidden(koji img .logomarke ima po difoltu)
      //pravimo div koj ce kad se klikne prikazivati sve do sada unete modele marke koju je user odabrao
      var output = '<div class="text-center prikazimodelemarke" idmarke="'+idmarke+'">';
      output += '<span>';
      output += 'Do sada uneti modeli za marku: <strong>'+marka+'</strong>';
      output += '</span>';
      output += '</div>';
      //div u koji ce se ubaciti html kad metod prikazimodele() MarkaControllera vrati sve modele neke marke
      output += '<div class="modeli"></div>';
      $(output).insertAfter($('.formazanovimodel'));
      //ovde generisemo html za div koji se ubacuje ispod sekcije koja prikazuje do sada unete modele odabrane marke, div ce se pona-
      //-sati kao btn koji kad kliknemo ispod njega se pojavljuje forma za editovanje vec unete marke
      var output1 = '';
      output1 += '<div class="text-center editmarke" imemarke="'+marka+'" logo="'+logo+'" idmarke="'+idmarke+'">';
      output1 += '<span>Izmeni marku: <strong>'+marka+'</strong></span>';
      output1 += '</div>';
      output1 += '<div class="editmarkeforma"></div>';
      $(output1).insertAfter($('.modeli'));
    }
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //kad se klikne div .prikazimodelemarke koji je izgenerisan u hendleru za change selecta marke u formi za dodavanje modela u dodajmarku.blade.php
  $('body').on('click', '.prikazimodelemarke', function(e){
    $('.prikazimodelemarke').bind('click', false);//zabranjujemo ponovni klik na div .prikazimodelemarke
    //uzmi id marke koja je trenutno u opticaju(tj odabrana u selectu) iz atributa .idmarke diva .prikazimodelemarke
    var idmarke = $(this).attr('idmarke');
    //saljemo AJAX prikazimodele() metodu MarkaCOntrollera preko rute 'prikazimodele', varijable url i token su definisane na dnu vjua 
    //dodajmarke.blade.php, takodje saljemo id marke cije modele treba izvuci iz 'modelis' tabele
    $.ajax({ 
      method: 'POST',
      url: url,
      data: { idmarke: idmarke, _token: token }
    })//kad stigne odgovor od metoda prikazimodele() MarkaControllera 
    .done(function(o){
      console.log(o); 
      var output = '';//varijabla u koju ce se ubaciti HTML
      if(o['modeli'].length == 0){//ako nista nije nadjeno u 'modelis' taberli za neku marku
        output += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvorilistumodela" id="zatvorilistumodela">';
        output += '<h3 class="text-center text-danger">Za ovu marku nema unetih modela.</h3>';
      }else{
        //ako je nesto nadjeno prikazujemo to u <ul>
        output += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvorilistumodela" id="zatvorilistumodela">';
        output += '<ul class="list-group row ulmodela">';
        for(var i = 0; i < o['modeli'].length; i++){   
          //za svaki nadjeni model pravimo li
          output += '<li id="'+o['modeli'][i]['id']+'" class="list-group-item col-xs-6 col-lg-3 col-sm-3 col-md-3 listamodela">';
          output += '<p class="puli"><small id="model'+o['modeli'][i]['id']+'">'+o['modeli'][i]['ime']+'</small></p>';
          //btn tj glyphicon koji ce kad se klikne prikazivati polje za editovanje modela tj promenu imena, atribut idmodela sadrzi idmodela
          //koji ce biti potreban hendleru kad salj AJAX metodu za editovanje modela u 'modelis' tabeli
          output += '<a href="#" idmodela="'+o['modeli'][i]['id']+'" imemodela="'+o['modeli'][i]['ime']+'" class="editmodel btn btn-primary btn-xs">';
          output += '<span class="glyphicon glyphicon-edit"></span>';
          output += '</a>';
          //btn tj glyphicon koji kad se klikne poziva hendler koji brise model koji zelimo da obrisemo
          output += '&nbsp; <a href="#" idmodela="'+o['modeli'][i]['id']+'" class="deletemodel btn btn-primary btn-xs">';  
          output += '<span class="glyphicon glyphicon-trash"></span>';
          output += '</a>';
          output += '</li>';    
        }
        output += '</ul>';
      }
      //ubacujemo izgenerisani HTML u div .modeli koji je izgenerisan kad je odabrana neka marka u select-u u formi za dodavanje modela
      $('.modeli').html(output);
    });
  });
//----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonicu #zatvorilistumodela tj zatvaranje liste koja prikazuje modele marke koja je izgenerisana u hendleru za klik na div .prikazimodelemarke
  $('body').on('click', '#zatvorilistumodela', function(){
    $('.prikazimodelemarke').unbind('click', false);//dozvoli ponovo click na div.prikazimodelemarke
    $('.modeli').html('');//isprazni div koji prikazuje listu modela
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na neki od linkova (tj btn-a).editmodel koji su vidljivi u <ul> koja prikazuje do sada unete modele neke marke(izgenerisani su u he-
  //-ndleru iznad ovog tj u hendleru za klik na div.prikazimodelemarke)
  $('body').on('click', '.editmodel', function(e){
    e.preventDefault();
    //postoji mogucnost da je neki model ec editovan pa ako postoji forma .editmodelforma uklanjamo je
    $('.editmodelforma').remove();
    var idmodela = $(this).attr('idmodela');//iz atributa 'idmodela' btna.editmodel uzimamo id modela koji editujemo
    var imemodela = $('#model'+idmodela).text();//iz <small>klase.model+id uzimamo ime modela
    //alert(imemodela);
    var o = ''; 
    //pravimo formu za editovanje modela u HTML-u koja ima polje za novo ime modela i submit btn ima atribut idmodelazaedit u kom je id modela
    //posto to treba metodu izmenimodel() MarkaControllera koji edituje 'modelis' tabelu, takodje i hidden input u kom je staro ime modela
    o += '<form class="form-horizontal editmodelforma text-center" role="form" method="POST" action="#">';
    o += '<input type="hidden" name="staroimemodela" id="staroimemodela" value="'+imemodela+'">';
    o += '<div class="form-group">';
    o += '<label for="imemodelaedit" id="editmodellabel" class="lepfont col-md-3 col-md-offset-1 control-label">Novo Ime Modela</label>';
    o += '<div class="col-md-4">';
    o += '<input id="imemodelaedit" type="text" class="form-control text-center" name="imemodelaedit" value="'+imemodela+'">';
    o += '</div>';
    o += '<div class="col-md-2">';
    o += '<input type="submit" name="izmenimodel" id="izmenimodel" idmodelazaedit="'+idmodela+'" class="editmodelbtn btn btn-success" value="Sačuvaj Izmene">';
    o += '</div>';
    o += '</div>';
    o += '</form>';
    $(o).insertBefore($('.ulmodela'));//izgenerisani HTML ubacujemo iznad <ul>.ulmodela koja prikazuje do sada unete modele neke marke
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //kad se sabmituje forma za editovanje modela koja je napravljena u prethodnom hendleru tj klik na submit btn #izmenimodel
  $('body').on('click', '#izmenimodel', function(e){
    e.preventDefault();//spreci sabmit forme
    //uzimamo iz hidden inputa forme za izmenu modela staro ime modela da bi kontroler mogao da menja kolonu model 'oglasis' tabele
    var staroimemodela = $('#staroimemodela').val(); 
    var novoimemodela = $('#imemodelaedit').val();//uzimamo userov unos u polje #imemodelaedit tj novo ime modela
    var idmodelazaedit = $(this).attr('idmodelazaedit');//iz atributa idmodelazaedit kliknutog submit btn-a uzimamo id modela
    //saljemo AJAX izmenimodel() metodu MarkaCotntrollera, url tj izmenimodelurl je definisan na dnu dodajmarke.blade.php a u kontroler salje-
    //mo novo ime modela, staro ime modela i id modela kao i _token(koji je takodje definisan na dnu vjua dodajmarku.blade.php)
    $.ajax({ 
      method: 'POST',
      url: izmenimodelurl,
      data: { novoimemodela: novoimemodela, staroimemodela: staroimemodela, idmodelazaedit: idmodelazaedit, _token: token }
    })//kad stigne odgovor od metoda prikazimodele() MarkaControllera 
    .done(function(o){
      //console.log(o);
      $('#model'+idmodelazaedit).text(novoimemodela);//u listi koja prikazuje do sada unete modele menjamo ime editovanog modela 
      $('.editmodelforma').remove();//uklanjamo formu za editovanje
    });
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na btn tj glyphicon za delete modela ispod nekog modela u ul koji prikazuje modele neke marke, salje AJAX metodu deletemodel() 
  //MarkaControllera koji brise model
  $('body').on('click', '.deletemodel', function(e){
    e.preventDefault();
    //uzimamo id modela koji brisemo
    var idmodelazdelete = $(this).attr('idmodela');
    //alert(idmodelazdelete);
    //saljemo AJAX preko rute '/deletemodela', varijabla deletemodelurl je definisana na dnu vjua dodajmarku.blade.php 
    $.ajax({ 
      method: 'POST',
      url: deletemodelurl,
      data: { idmodelazdelete: idmodelazdelete, _token: token }
    })//kad stigne odgovor od metoda deletemodel() MarkaControllera 
    .done(function(o){
      //console.log(o);
      //ako obrise model iz 'modelis' tabele uspesno vraca true
      if(o.deleted == true){
        $('#'+idmodelazdelete).remove();//uklanjamo iz ul koja prikazuje modele marke li kom je id jednak id-u obrisanog modela
      }else{
        alert('Došlo je do greške, nije moguće obrisati model, pokušajte ponovo.');
      }
    });
  });
  
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //klik na div .editmarke generise formu za editovanje unete marke tj njenog imena i logo-a i formu za brisanje marke, sve to ubacujemo u div 
  //.editmarkeforma koji je napravljen kad i div .editmarke tj u hendleru za promenu opcije selecta #imemarke2
  $('body').on('click', '.editmarke', function(e){
    var idmarke = $(this).attr('idmarke');
    var marka = $(this).attr('imemarke');
    var logo = $(this).attr('logo');
    marka = $.trim(marka);
    //alert('imemarke: '+marka);
    //pravimo formu za editovanje marke
    var output = '';  
    output += '<form class="form-horizontal formazaizmenumarke" role="form" method="POST" action="'+izmenimarkuurl+'" enctype="multipart/form-data">';
    output += '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriizmenimarku" id="zatvoriizmenimarku">';
    output += '<input type="hidden" name="_token" value="'+token+'">';
    output += '<input type="hidden" name="idmarke" id="idmarke" value="'+idmarke+'">';
    output += '<input type="hidden" name="starilogo" id="starilogo" value="'+logo+'">';
    output += '<input type="hidden" name="staroime" id="staroime" value="'+marka+'">';
    output += '<div class="form-group">';
    output += '<label for="novoimemarke" class="lepfont col-md-4 control-label">Ime Marke</label>';
    output += '<div class="col-md-6">';
    output += '<input id="novoimemarke" type="text" class="form-control" name="novoimemarke" value="'+marka+'">';
    output += '</div>';
    output += '</div>';
    output += '<div class="form-group">';
    output += '<label for="novilogo" class="lepfont col-md-4 control-label">Logo</label>';
    output += '<div class="col-md-6">';
    output += '<div class="col-md-12">';
    output += '<input type="file" id="novilogo" name="novilogo"><br>'; 
    output += '</div>';
    output += '</div>';
    output += '</div>';
    output += '<div class="form-group">'; 
    output += '<label for="publish" class="lepfont col-md-4 control-label"></label>';
    output += '<div class="col-md-6">';
    output += '<input type="submit" name="publish" class="editmarkebtn btn btn-success" value="Sačuvaj Izmene">';
    output += '</div>';
    output += '</div>';
    output += '</form>';
    //forma za brisanje marke
    output += '<form class="form-horizontal formazabrisanjemarke" role="form" method="POST" action="'+obrisimarkuurl+'" ';
    //output += 'onsubmit="return confirm("Is the form filled out correctly?");"';
    output += '>';
    output += '<input type="hidden" name="_token" value="'+token+'">';
    output += '<input type="hidden" name="idmarkebrisanje" id="idmarkebrisanje" value="'+idmarke+'">';
    output += '<input type="hidden" name="starilogobrisanje" id="starilogobrisanje" value="'+logo+'">';
    output += '<div class="form-group">'; 
    output += '<label for="publish" class="lepfont col-md-4 control-label"></label>';
    output += '<div class="col-md-6">';
    output += '<input type="submit" class="obrisimarkubtn btn btn-danger" value="&nbsp;&nbsp;Obriši Marku&nbsp;&nbsp;">';
    output += '</div>';
    output += '</div>';
    output += '</form>';
    $('.editmarkeforma').html(output);
  });
//----------------------------------------------------------------------------------------------------------------------------------------------
  //kad se sabmituje forma za brisanje marke koja je napravljena u hendleru iznad ovog izbacujemo adminu Confirm koji mora da klikne da bi
  //obrisao marku
  $('body').on('submit', '.formazabrisanjemarke', function(e){
    if(confirm('Da li ste sigurni da želite da obrisete ovu marku?')){
      
    }else{
      return false;
    }
  });
//----------------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonicu #zatvoriizmenimarku tj zatvaranje forme za editovanje marke koja je izgenerisana u hendleru za klik na div .editmarke
  $('body').on('click', '#zatvoriizmenimarku', function(){
    $('.editmarkeforma').html('');
  });

});