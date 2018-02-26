//$(document).ready(function(){
$(window).load(function(){


//ovde su hendleri za vju oglas.blade.php

//alert(oglastekst);

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

  //Funkcija proverava da li postoji slika kad prikazuje naslovnu sliku oglasa ili slike u glaeriji tj div-u .ceoekran
  function FileExist(urlToFile){
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
    if(xhr.status == "404") {
      //console.log(urlToFile+" - File doesn't exist");
      return false;
    }else{
      //console.log(urlToFile+" - File exists");
      return true;
    }
  }

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

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
  
  //ako je mali ekran
  var dpi_x = document.getElementById('dpi').offsetWidth;
  var widthekrana = $(window).width() / dpi_x;
  //alert(widthekrana);
  if(widthekrana < 10.5 || /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
    $(".maleslike").removeClass('paddinglevo').addClass('paddinglevodesno');
    $(".levounutrasnji").removeClass('borderlevodesno');
  }else{ // ako je veliki ekran
    //
    $(window).load(function(){ 
      //merenje sirina divova u oglas.blade.php
      var visinadivlevo = $('.paddinglevodesno').height();
      var sirinadivlevo = $('.paddinglevodesno').width();
      var sirinadivdesnoprvi = $('.desnoprvi').width();
      var sirinadivdesnodrugi = $('.desnodrugi').width();
      if(oglasslike > 0){
        //div-ovima .desnoprvi i .desnodrugi podesavamo visinu da bude ista kao i div-u .levo
        $('.desnoprvi').css({"height": visinadivlevo, "border-right": "1px solid #00adee", "padding-right": "2px"});
        $('.desnodrugi').css({"height": visinadivlevo, "border-right": "1px solid #00adee", "padding-right": "2px"});
        //sirina diva ispod ce biti zbir sirina div-ova .levo, .desnoprvi i .desnodrugi plus 2 margine po 15px tj 30px
        var sirinadivispod = sirinadivlevo + sirinadivdesnoprvi + sirinadivdesnodrugi + 30;
        $('.ispod').css({"width": sirinadivispod});
      }else{
        $('.levounutrasnji').removeClass('borderlevodesno');
      } 
    });
    
  }

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
  //davanje staticne visine divu koji prikazuje glavnu sliku u oglas.blade.com
  var divnaslovnaslikawidth = $('.divnaslovnaslika').width();//merimo sirinu div-a .divnaslovnaslika
  $('.divnaslovnaslika').css('height', divnaslovnaslikawidth-10);//visina je sirina - 10 px
//---------------------------------------------------------------------------------------------------------------------------------------
  //centriranje ikona za sledecu i prethodnu sliku na naslovnoj slici oglasa u oglas.blade.php
  var divnaslovnaslikaheight = $('.divnaslovnaslika').height();
  var top = divnaslovnaslikaheight / 2;
  $('.prethodnaslika').css('top', top);
  $('.sledecaslika').css('top', top);
//---------------------------------------------------------------------------------------------------------------------------------------
  //centriranje ikone za zoomin(lupe) naslovne slike
  var right = divnaslovnaslikawidth / 2.3;
  var top2 = divnaslovnaslikaheight / 2.3;
  $('.zoomin').css({"top": top2, "right": right});
//---------------------------------------------------------------------------------------------------------------------------------------
  //kad mis udje na naslovnu sliku tj na div .divnaslovnaslikaspoljni skidamo ikonama strelicama(.prethodnaslika i .sledecaslika) atribut
  //hidden takodje i ikoni za zoomin
  $('body').on('mouseenter', '.divnaslovnaslikaspoljni', function(){
    $('.prethodnaslika').removeAttr('hidden');
    $('.sledecaslika').removeAttr('hidden');
    $('.zoomin').removeAttr('hidden');
  });
  //kad mis izadje sa naslovne slike tj sa div .divnaslovnaslikaspoljni dajemo ikonama strelicama(.prethodnaslika i .sledecaslika) atribut
  //hidden takodje i ikoni za zoomin
  $('body').on('mouseleave', '.divnaslovnaslikaspoljni', function(){
    $('.prethodnaslika').attr('hidden', 'true');
    $('.sledecaslika').attr('hidden', 'true');
    $('.zoomin').attr('hidden', 'true');
  });
  //kad mis udje iznad ikona za sledecu ili prethodnu sliku uklanjamo ikonu za zoomin da ne bi smetala useru da gleda slike, kad izadje sa 
  //ikona za levo, desno slike opet je vracamo na ekran
  $('body').on('mouseenter', '.prethodnaslika', function(){
    $('.zoomin').attr('hidden', 'true');
  });
  $('body').on('mouseleave', '.prethodnaslika', function(){
    $('.zoomin').removeAttr('hidden');
  });
  $('body').on('mouseenter', '.sledecaslika', function(){
    $('.zoomin').attr('hidden', 'true');
  });
  $('body').on('mouseleave', '.sledecaslika', function(){
    $('.zoomin').removeAttr('hidden');
  });

//---------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonu za sledecu sliku (strelica desno) koja je vidljiva kad se hover-uje na divu koji prikazuje glavnu sliku oglasa
  $('body').on('click', '.sledecaslika', function(){
    //uzimamo ime trenutne slike koje je u atributu id strelice tj ikone
    var idtrenutneslike = parseInt($(this).attr('id'));
    //ime sledece slike je vece bar za 1 od trenutne pa dodajemo 1 imenu trenutne slike
    var idsledeceslike = idtrenutneslike + 1;  
    //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i povecavamo za 1 imesledeceslike (tj id) po iteraciji
    for(idsledeceslike; idsledeceslike <= 12; idsledeceslike++){
      //ako pronademo sliku
      if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslike+".jpg")){
        $(this).attr('id', idsledeceslike);//dajemo kliknutoj ikoni novi id koji je sada ime slike koju smo nasli
        $('.prethodnaslika').attr('id', idsledeceslike);//isto za ikonu tj strelicu koja ide na drugu stranu
        $('.zoomin').attr('imgid', idsledeceslike);//isto za ikonu za zoomin
        //maloj slici tj thumbu koji su ispo glavne slike koji trenutno ima klasu .opacity tj koja je do sada prikazivana kao glavna skidamo
        //klasu opacity posto se ta slika vise ne prikazuje kao glavna i ne treba da bude zamagljen
        $('.dodajopacity').removeClass('dodajopacity');
        //maloj slici tj thumbu koji se zove kao pronadjena slika tj ona koja je sad glavna dajemo kasu opacity tj zamagljujemo je
        $('.'+idsledeceslike).addClass('dodajopacity');   
        //menjamo src atribut glavne slike tj naslovneslikeoglasa da pokazuje ka pronadjenoj novoj naslovnoj slici
        $('.naslovnaslikaoglas').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslike+'.jpg?vreme='+new Date());
        break;
      }
    }
  });
  //klik na ikonu za prethodnu sliku (strelica levo) koja je vidljiva kad se hover-uje na divu koji prikazuje glavnu sliku oglasa
  $('body').on('click', '.prethodnaslika', function(){
    //uzimamo ime trenutne slike koje je u atributu id strelice tj ikone
    var idtrenutneslike2 = parseInt($(this).attr('id'));
    //ime prethodne slike je manje bar za 1 od trenutne pa oduzimamo 1 imenu trenutne slike
    var idprethodneslike = idtrenutneslike2 - 1;  
    //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i smanjujemo za 1 imesledeceslike (tj id) po iteraciji
    for(idprethodneslike; idprethodneslike >= 1; idprethodneslike--){
      //ako pronademo sliku
      if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslike+".jpg")){
        $(this).attr('id', idprethodneslike);//dajemo kliknutoj ikoni novi id koji je sada ime slike koju smo nasli
        $('.sledecaslika').attr('id', idprethodneslike);//isto za ikonu tj strelicu koja ide na drugu stranu
        $('.zoomin').attr('imgid', idprethodneslike);//isto za ikonu za zoomin
        //maloj slici tj thumbu koji su ispo glavne slike koji trenutno ima klasu .opacity tj koja je do sada prikazivana kao glavna skidamo
        //klasu opacity posto se ta slika vise ne prikazuje kao glavna i ne treba da bude zamagljen
        $('.dodajopacity').removeClass('dodajopacity');
        //maloj slici tj thumbu koji se zove kao pronadjena slika tj ona koja je sad glavna dajemo kasu opacity tj zamagljujemo je
        $('.'+idprethodneslike).addClass('dodajopacity');
        //menjamo src atribut glavne slike tj naslovneslikeoglasa da pokazuje ka pronadjenoj novoj naslovnoj slici
        $('.naslovnaslikaoglas').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslike+'.jpg?vreme='+new Date());
        break;
      }
    }
  });
//---------------------------------------------------------------------------------------------------------------------------------------
  //prva slika u div-u .maleslike dobija klasu dodajopacity
  $('.maleslike img').eq(0).addClass('dodajopacity');
  //davanje svim malimslikama (koje prikazuju ostale thumb slike oglasa ispod naslovne) istu visinu
  var maleslikeheight = $('.maleslike img').eq(0).height(); // uzimamo visinu prve
  $('.maleslike img').css('height', maleslikeheight); // svim ostalim dajemo tu visinu

//---------------------------------------------------------------------------------------------------------------------------------------
  // klik na neku od malih slika(thumb-ova) koje su prikazane ispod naslovne slike oglasa u oglas.blade.php
  $('body').on('click', '.malanaslovnaslika', function(){
    var idmaleslike = $(this).attr('id'); // uzimamo id koji je i ime slike + .jpg
    var imemaleslike = $(this).attr('imeslike'); // uzimamo vrednost atributa imeslike
    $('.dodajopacity').removeClass('dodajopacity');//uklanjamo klasu opacity slici koja ju je imala do sad tj odmagljujemo je 
    $(this).addClass('dodajopacity');//dodajemo klinutoj maloj slici opacity klasu tj zamagljujemo je 
    //glavnoj slici menjamo src tako da prikaze sliku ciji smo thumb kliknuli medju malimslikama
    $('.naslovnaslikaoglas').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idmaleslike+'?vreme='+new Date());
    //menjamo ikonama strelicama za sledecu i prethodnu sliku atribut id da odgovara imenu slike koja se trenutno prikazuje kao glavna
    $('.sledecaslika').attr('id', imemaleslike);
    $('.prethodnaslika').attr('id', imemaleslike);
    $('.zoomin').attr('imgid', imemaleslike);
  });

//---------------------------------------------------------------------------------------------------------------------------------------
// GALERIJA SLIKA U oglas.blade.php u div-u .ceoekran
//---------------------------------------------------------------------------------------------------------------------------------------

  //kad se klikne na zoomin ikonu tj kad user hoce da gleda galeriju slika oglasa u punoj velicini
  $('body').on('click', '.zoomin', function(){
    //div-u .ceoekran koji je skriven uklnjamo atribut hidden(to je div koji prekriva ceo ekran u oglas.blade.php u kom se prikazuje galeri-
    //-ja velikih slika oglasa)
    $('.ceoekran').removeAttr('hidden');
    //uzimamo id tj ime slike(broj od 1 do 12) koja je trenutno prikazana kao glavna slika iz atrributa imgid zoom ikone tj lupe
    var imgid = $(this).attr('imgid');
    //generisemo HTML koji cemo ubaciti u div .galerija koji je u divu .ceoekran
    var gout = '';
    //ako oglas ima vise od jedne slike pravimo i strelice za prethodnu i sledecu sliku oglasa da bi user mogao da menja slike, strlice ima-
    //-ju atribut (tj div-ovi u kojima su) idslike u koji upisujemo ime trenutno prikazane slike da bi njihovi hendleri mogli da znaju koja
    //se slika trenutno prikazuje i na osnovu toga prikazu sledecu ili prethodnu
    if(oglasslike > 1){
      gout += '<div class="prethodnaslikagalerija" idslike="'+imgid+'">';
      gout += '<img class="strelicegalerija" src="'+homeurl+'/img/prethodnaslikagalerija.png">';
      gout += '</div>';
      gout += '<div class="sledecaslikagalerija" idslike="'+imgid+'">';
      gout += '<img class="strelicegalerija" src="'+homeurl+'/img/sledecaslikagalerija.png">';
      gout += '</div>';
    }
    //sama slika koju ubacujemo u div .galerija tj div .ceoekran
    gout += '<img src="'+homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+imgid+'.jpg" class="galerijajednaslika">'; 
    //izgenerisani HTML ubacujemo u div .galerija kooji je poddiv div-a .ceoekran
    $('.galerija').html(gout);
    //izracunavamo polovinu visine div-a .ceoekran da bi dali top ikonama za prethodnu i sledecu sliku, da bi stajale na polovini ekrana
    var galerijawidth = $('.ceoekran').height();
    var topgalerija = galerijawidth / 2;
    $('.prethodnaslikagalerija').css('top', topgalerija);
    $('.sledecaslikagalerija').css('top', topgalerija);
  });
//---------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonu .zatvorislikeceoekran koja je vidljiva u div-u ceoekran u oglas.blade.php kad user gleda galeriju slika oglasa
  $('body').on('click', '.zatvorislikeceoekran', function(){
    $('.ceoekran').attr('hidden', 'true');
  });
//---------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonu za prethodnu sliku u galeriji tj na div .prethodnaslikagalerija
  $('body').on('click', '.prethodnaslikagalerija', function(){
    //uzimamo ime trenutne slike koje je u atributu idslike strelice tj ikone
    var idtrenutneslikegalerija = parseInt($(this).attr('idslike'));
    //ime prethodne slike je manje bar za 1 od trenutne pa oduzimamo 1 imenu trenutne slike
    var idprethodneslikegalerija = idtrenutneslikegalerija - 1;  
    //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i smanjujemo za 1 imesledeceslike (tj id) po iteraciji
    for(idprethodneslikegalerija; idprethodneslikegalerija >= 1; idprethodneslikegalerija--){
      //ako pronademo sliku
      if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslikegalerija+".jpg")){
        $(this).attr('idslike', idprethodneslikegalerija);//dajemo kliknutoj ikoni novi idslike koji je sada ime slike koju smo nasli
        $('.sledecaslikagalerija').attr('idslike', idprethodneslikegalerija);//isto za ikonu tj strelicu koja ide na drugu stranu
        //menjamo src atribut glavne slike tj .galerijajednaslika da pokazuje ka pronadjenoj novoj glavnoj slici
        $('.galerijajednaslika').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslikegalerija+'.jpg?vreme='+new Date());
        break;
      }
    }
  });
  //---------------------------------------------------------------------------------------------------------------------------------------
  //klik na ikonu za sledecu sliku u galeriji tj na div .prethodnaslikagalerija
  $('body').on('click', '.sledecaslikagalerija', function(){
    //uzimamo ime trenutne slike koje je u atributu idslike strelice tj ikone
    var idtrenutneslikegalerija2 = parseInt($(this).attr('idslike'));
    //ime prethodne slike je vece bar za 1 od trenutne pa dodajemo 1 imenu trenutne slike
    var idsledeceslikegalerija = idtrenutneslikegalerija2 + 1;  
    //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i smanjujemo za 1 imesledeceslike (tj id) po iteraciji
    for(idsledeceslikegalerija; idsledeceslikegalerija <= 12; idsledeceslikegalerija++){
      //ako pronademo sliku
      if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslikegalerija+".jpg")){
        $(this).attr('idslike', idsledeceslikegalerija);//dajemo kliknutoj ikoni novi idslike koji je sada ime slike koju smo nasli
        $('.prethodnaslikagalerija').attr('idslike', idsledeceslikegalerija);//isto za ikonu tj strelicu koja ide na drugu stranu
        //menjamo src atribut glavne slike tj .galerijajednaslika da pokazuje ka pronadjenoj novoj glavnoj slici
        $('.galerijajednaslika').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslikegalerija+'.jpg?vreme='+new Date());
        break;
      }
    }
  });
//---------------------------------------------------------------------------------------------------------------------------------------
  //ako user scroll-uje kad udje u galeriju tj kad scroll-uje misem po div-u .ceoekran pravimo isti efekat kao da klikce strelice za sledecu -
  //- prethodnu sliku, tj menjamo sliku koja se trenutno prikazuje, kad scroll-uje na gore prikazujemo prethodnu a kad scroll-uje na dole pri-
  //-kazujemo sledecu sliku u galeriji
  $('.ceoekran').bind('mousewheel DOMMouseScroll', function(event){
    //ako scroll-uje na gore prikazujemo prethodnu sliku
    if(event.originalEvent.wheelDelta > 0 || event.originalEvent.detail < 0) {
      //uzimamo ime trenutne slike koje je u atributu idslike strelice tj ikone
      var idtrenutneslikegalerija = parseInt($('.prethodnaslikagalerija').attr('idslike'));
      //ime prethodne slike je manje bar za 1 od trenutne pa oduzimamo 1 imenu trenutne slike
      var idprethodneslikegalerija = idtrenutneslikegalerija - 1;  
      //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i smanjujemo za 1 imesledeceslike (tj id) po iteraciji
      for(idprethodneslikegalerija; idprethodneslikegalerija >= 1; idprethodneslikegalerija--){
        //ako pronademo sliku
        if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslikegalerija+".jpg")){
          $('.prethodnaslikagalerija').attr('idslike', idprethodneslikegalerija);//dajemo ikoni za prethodnu sliku novi idslike koji je sada ime slike koju smo nasli
          $('.sledecaslikagalerija').attr('idslike', idprethodneslikegalerija);//isto za ikonu tj strelicu koja ide na drugu stranu
          //menjamo src atribut glavne slike tj .galerijajednaslika da pokazuje ka pronadjenoj novoj glavnoj slici
          $('.galerijajednaslika').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idprethodneslikegalerija+'.jpg?vreme='+new Date());
          break;
        }
      }
    }else{ // ako scroll-uje na dole prikazujemo sledecu sliku
      //uzimamo ime trenutne slike koje je u atributu idslike strelice tj ikone
      var idtrenutneslikegalerija2 = parseInt($('.sledecaslikagalerija').attr('idslike'));
      //ime prethodne slike je vece bar za 1 od trenutne pa dodajemo 1 imenu trenutne slike
      var idsledeceslikegalerija = idtrenutneslikegalerija2 + 1;  
      //trazimo u folderu za slike oglasa ime sledece slike koristeci for loop i smanjujemo za 1 imesledeceslike (tj id) po iteraciji
      for(idsledeceslikegalerija; idsledeceslikegalerija <= 12; idsledeceslikegalerija++){
        //ako pronademo sliku
        if(FileExist(homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslikegalerija+".jpg")){
          $('.sledecaslikagalerija').attr('idslike', idsledeceslikegalerija);//dajemo ikoni za sledecu sliku novi idslike koji je sada ime slike koju smo nasli
          $('.prethodnaslikagalerija').attr('idslike', idsledeceslikegalerija);//isto za ikonu tj strelicu koja ide na drugu stranu
          //menjamo src atribut glavne slike tj .galerijajednaslika da pokazuje ka pronadjenoj novoj glavnoj slici
          $('.galerijajednaslika').attr('src', homeurl+'/img/oglasi/'+folderslike+'/'+oglasid+'/'+idsledeceslikegalerija+'.jpg?vreme='+new Date());
          break;
        }
      }
    }
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  // ako user ciji se oglas gleda ima dodatu lat, lng i zoom znaci da je dodao google map pa je prikazujemo
  $(window).load(function(){   
    if(userlat != '' && userlng != '' && userzoom != ''){
      //dajemo div-u #mapspoljnioglas u kom je mapa u oglas.blade.php visinu istu kao i div-u koji prikazuje slike oglasa
      var visinadivlevo1 = $('.paddinglevodesno').height();
      $('#mapspoljnioglas').css({"height": visinadivlevo1, "width": "100%"});
      $('#map').css({"margin-left": "0px!important", "width" : "100%"});//podesavamo dimenzije div-a #map koji priakzuje mapu
      //alert('ima mapu');
      //na dnu oglas.blade.php su definisane ove varijable
      x = userlat;
      y = userlng;
      z = parseInt(userzoom);
      var center = new google.maps.LatLng(x, y);
      var map;
      //funkcija koju dole pozivamo da iscrta mapu
      function initialize(){
        var mapOptions = {
          zoom: z,
          center: center,
          mapTypeId: google.maps.MapTypeId.TERRAIN 
          //mapTypeId: google.maps.MapTypeId.SATELLITE
          // HYBRID je mesavina satelitskog snimka i mape tako da ima ucrtane granice imena gradova i slicno...
          //mapTypeId: google.maps.MapTypeId.HYBRID 
        };
        //mapa se ubacuje u div #map
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        //dodajemo marker na mapu tamo gde je user kliknuo kad je postavljao mapu
        var marker = new google.maps.Marker({
          position: center,
          map: map
        });
      }
      //pozivamo funkciju za prikaz mape
      initialize(); 
    }
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------


});

