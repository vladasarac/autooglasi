$(document).ready(function(){

//ovde su hendleri za vju novioglas.blade.php
//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------
  
  //posto tabela na vrhu novioglas.blade.php na malim ekranima lose izgleda ovde merimo ekran i ako se ispostavi da je mali uklanjamo tu tabelu
  //koja se nalazi u div - u .tabelauserpodatci i onda ovde generisemo div sa istim podatcima koji ce malo lepse izgledati na malom ekranu
  var dpi_x = document.getElementById('dpi').offsetWidth;
  var widthekrana = $(window).width() / dpi_x;
  //console.log('id:'+userid+', ime:'+username+', email:'+useremail+', grad:'+usergrad+', telefon'+usertelefon+', brojoglasa:'+userbrojoglasa+', logo'+userlogo);
  //console.log('userauthcheck: '+userauthcheck+', userauthuserrole: '+userauthuserrole+', useraktivan: '+useraktivan+', userauthuserid'+userauthuserid);
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
    if(userauthcheck && userauthuserrole == 'admin'){
      podatciuseraout += '<a class="greenbtn" href="/profil/'+userid+'"><button type="button" class="btn btn-warning">Profil Korisnika</button></a>';
    }else{
      podatciuseraout += '<a class="greenbtn" href="/profil"><button type="button" class="btn btn-warning">Profil Korisnika</button></a>';
    }
    podatciuseraout += '</div>';
    $('.podatcikorisnika').html(podatciuseraout); 
    //alert(widthekrana);
  }  
  
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
  
  //varijable za proveru popunjenosti polja u formi za novi oglasi varijable sa error porukama za ta polja
  var provera = 0;
  var proveranaslova = 0;
  var errornaslova = '<br><b>"Naslov Oglasa"</b> je obavezno polje!';
  var proveramarke = 0;
  var errormarke = '<br><b>"Marka Automobila"</b> je obavezno polje!';
  var proveramodela = 0;
  var errormodela = '<br><b>"Model"</b> je obavezno polje!';
  var proveracena = 0;
  var errorcena = '<br><b>"Cena"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proveragodiste = 0;     
  var errorgodiste = '<br><b>"Godište"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proverakaroserija = 0;     
  var errorkaroserija = '<br><b>"Karoserija"</b> je obavezno polje!';
  var proverakubikaza = 0;     
  var errorkubikaza = '<br><b>"Kubikaža"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proveraks = 0;     
  var errorks = '<br><b>"Snaga KS"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proverakw = 0;     
  var errorkw = '<br><b>"Snaga KW"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proverakilometraza = 0;
  var errorkilometraza = '<br><b>"Kilometraža"</b> je obavezno polje, u njega možete uneti samo brojeve!';
  var proveragorivo = 0;
  var errorgorivo = '<br><b>"Gorivo"</b> je obavezno polje!';
  var proveraemisionaklasa = 0;
  var erroremisionaklasa = '<br><b>"Emisiona Klasa"</b> je obavezno polje!';
  var proverapogon = 0;
  var errorpogon = '<br><b>"Pogon"</b> je obavezno polje!';
  var proveramenjac = 0;
  var errormenjac = '<br><b>"Menjač"</b> je obavezno polje!';
  var proveraostecen = 0;
  var errorostecen = '<br><b>"Oštećen"</b> je obavezno polje!';
  var proverabrvrata = 0;
  var errorbrvrata = '<br><b>"Broj Vrata"</b> je obavezno polje!';
  var proverabrsedista = 0;
  var errorbrsedista = '<br><b>"Broj Sedišta"</b> je obavezno polje!';
  var proverastranavolana = 0;
  var errorstranavolana = '<br><b>"Strana Volana"</b> je obavezno polje!';
  var proveraklima = 0;
  var errorklima = '<br><b>"Klima"</b> je obavezno polje!';
  var proveraboja = 0;
  var errorboja = '<br><b>"Boja"</b> je obavezno polje!';
  var proveraporeklo = 0;
  var errorporeklo = '<br><b>"Poreklo"</b> je obavezno polje!';

  $('#objavioglas').prop('disabled', true);
  
//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
  
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
      $('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
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
    //alert(idmarke);
    
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
      $('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
      errormodela = '<br><b>"Model"</b> je obavezno polje!';//vracamo errormodela i proveramodela na prvobitno stanje
      proveramodela = 0;
    }
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  //kad unosimo vrednostu u polje za snagu u KS automatski se popunjava polje snaga KW
  $('#snagaks').on('keyup', function(){
    var snagaks = $(this).val();//uzimamo unos u polje #snagaks
    var snagakw = snagaks * 0.745699872;//mnozimo sa 0.74...
    snagakw = '' + snagakw;//pretvaramo snagakw u string da bi mogli da nadjemo tacku i uklonimo je
    // var tipsnagaks = typeof snagaks;
    // var tipsnagakw = typeof snagakw;
    //alert(tipsnagaks+','+tipsnagakw)
    //alert('snagaks: '+snagaks+', snagakw: '+snagakw);
    if(snagakw.indexOf('.') != -1){//ako snagakw ima tacku(a imace je uvek jer mnozimo sa brojem sa tackom)
      snagakw = snagakw.split('.')[0];//odsecamo string od tacke pa do kraja
    }
    $('#snagakw').val(snagakw);//ubacujemo vrednost u polje #snagakw
    //alert(snagaks);
  });
  //-------------------------------------------------------------------------------------------------------------------------------------
  //kad unosimo vrednostu u polje za snagu u KW automatski se popunjava polje snaga KS
  $('#snagakw').on('keyup', function(){
    var snagakw = $(this).val();//uzimamo unos u polje #snagakw
    var snagaks = snagakw * 1.34102;//mnozimo sa 1.34...
    snagaks = '' + snagaks;//pretvaramo snagakw u string da bi mogli da nadjemo tacku i uklonimo je
    if(snagaks.indexOf('.') != -1){//ako snagaks ima tacku(a imace je uvek jer mnozimo sa brojem sa tackom)
      snagaks = snagaks.split('.')[0];//odsecamo string od tacke pa do kraja
    }
    $('#snagaks').val(snagaks);//ubacujemo vrednost u polje #snagaks
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------

  var holder = '';
  //kad korisnik doda sliku prikazi mu je
  function readURL(input){
    if(input.files && input.files[0]){
      var reader = new FileReader();
      reader.onload = function(e){
        $('#'+holder).attr('src', e.target.result);
        //alert(holder);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  //hendler za change za svaku sliku koju user uploaduje(ima ih 12), poziva funkciju readURL da prikaze sliku useru umesto one difoltne
  // koju prikazuje u <labe> elementu
  $("#slika1").change(function(){
    holder = 'slika1holder';
    readURL(this);
  });
  $("#slika2").change(function(){
    holder = 'slika2holder';
    readURL(this);
  });
  $("#slika3").change(function(){
    holder = 'slika3holder';
    readURL(this);
  });
  $("#slika4").change(function(){
    holder = 'slika4holder';
    readURL(this);
  });
  $("#slika5").change(function(){
    holder = 'slika5holder';
    readURL(this);
  });
  $("#slika6").change(function(){
    holder = 'slika6holder';
    readURL(this);
  });  
  $("#slika7").change(function(){
    holder = 'slika7holder';
    readURL(this);
  });
  $("#slika8").change(function(){
    holder = 'slika8holder';
    readURL(this);
  });
  $("#slika9").change(function(){
    holder = 'slika9holder';
    readURL(this);
  });
  $("#slika10").change(function(){
    holder = 'slika10holder';
    readURL(this);
  });
  $("#slika11").change(function(){
    holder = 'slika11holder';
    readURL(this);
  });
  $("#slika12").change(function(){
    holder = 'slika12holder';
    readURL(this);
  });  

//---------------------------------------------------------------------------------------------------------------------------------------
//provera da li su obavezna polja u formi popunjena tj VALIDACIJA FORME ZA NOVI OGLAS
//---------------------------------------------------------------------------------------------------------------------------------------

  //hendler za btn za submit forme iz novioglas.blade.php
  $('#submitbtndiv').on('mouseenter', function(){

    //provera da li je posle gubitka fokusa polje naslov oglasa popunjeno ili je ostalo prazno
    var unosnaslov = $('#naslovoglasa').val();//uzimamo userov unos
    if(unosnaslov == ''){ // ako je prazno
      //varijabla proveranaslova se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveranaslova = 0;
      errornaslova = '<br><b>"Naslov Oglasa"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#naslovoglasalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#naslovoglasalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosnaslov != ''){//ako je uneto nesto
      //varijabla proveranaslova se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveranaslova = 1;
      errornaslova = '';//brisemo error poruku za ovo polje
      $('#naslovoglasalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#naslovoglasalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //------------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje marka automobila popunjeno ili je ostalo prazno
    var unosmarka = $('#markaautomobila').val();//uzimamo userov unos
    if(unosmarka == ''){// ako je prazno
      //varijabla proveramarke se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramarke = 0;     
      errormarke = '<br><b>"Marka Automobila"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#markaautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#markaautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosmarka != ''){//ako je uneto nesto
      //varijabla proveramarke se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramarke = 1;
      errormarke = '';//brisemo error poruku za ovo polje
      $('#markaautomobilalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#markaautomobilalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //------------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje marka automobila popunjeno ili je ostalo prazno
    var unosmodel = $('#modelmarke').val();//uzimamo userov unos
    if(unosmodel == ''){// ako je prazno
      //varijabla proverammodela se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramodela = 0;     
      errormodela = '<br><b>"Model"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#modelautomobilalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#modelautomobilalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosmodel != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramodela = 1;
      errormodela = '';//brisemo error poruku za ovo polje
      $('#modelautomobilalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#modelautomobilalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje cena automobila popunjeno ili je ostalo prazno
    var unoscena = $('#cena').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unoscena);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unoscena == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proveracena se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveracena = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorcena = '<br><b>"Cena"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#cenalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#cenalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unoscena != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveracena = 1;
      errorcena = '';//brisemo error poruku za ovo polje
      $('#cenalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#cenalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje godiste automobila popunjeno ili je ostalo prazno
    var unosgodiste = $('#godiste').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unosgodiste);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unosgodiste == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proveragodiste se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveragodiste = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorgodiste = '<br><b>"Godište"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#godistelabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#godistelabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosgodiste != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveragodiste = 1;
      errorgodiste = '';//brisemo error poruku za ovo polje
      $('#godistelabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#godistelabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje karoserija automobila popunjeno ili je ostalo prazno
    var unoskaroserija = $('#karoserija').val();//uzimamo userov unos
    if(unoskaroserija == ''){// ako je prazno
      //varijabla proverakaroserija se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakaroserija = 0;     
      errorkaroserija = '<br><b>"Karoserija"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#karoserijalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#karoserijalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unoskaroserija != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakaroserija = 1;
      errorkaroserija = '';//brisemo error poruku za ovo polje
      $('#karoserijalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#karoserijalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje kubikaza automobila popunjeno ili je ostalo prazno
    var unoskubikaza = $('#kubikaza').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unoskubikaza);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unoskubikaza == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proverakubikaza se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakubikaza = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorkubikaza = '<br><b>"Kubikaža"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#kubikazalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#kubikazalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unoskubikaza != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakubikaza = 1;
      errorkubikaza = '';//brisemo error poruku za ovo polje
      $('#kubikazalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#kubikazalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje snagaks automobila popunjeno ili je ostalo prazno
    var unosks = $('#snagaks').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unosks);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unosks == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proveraks se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraks = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorks = '<br><b>"Snaga KS"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#kslabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#kslabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosks != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraks = 1;
      errorks = '';//brisemo error poruku za ovo polje
      $('#kslabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#kslabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje snagakw automobila popunjeno ili je ostalo prazno
    var unoskw = $('#snagakw').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unoskw);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unoskw == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proverakw se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakw = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorkw = '<br><b>"Snaga KW"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#kwlabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#kwlabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unoskw != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakw = 1;
      errorkw = '';//brisemo error poruku za ovo polje
      $('#kwlabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#kwlabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje kilometraza automobila popunjeno ili je ostalo prazno
    var unoskilometraza = $('#kilometraza').val();//uzimamo userov unos
    var isNum = /^\d+$/.test(unoskilometraza);//koristimo regexp da proverimo da li su uneti samo brojevi
    if(unoskilometraza == '' || isNum == false){// ako je prazno ili ako nisu brojevi
      //varijabla proverakilometraza se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakilometraza = 0;     
      //pravimo error poruku koja ce biti deo globalnog error-a
      errorkilometraza = '<br><b>"Kilometraža"</b> je obavezno polje, u njega možete uneti samo brojeve!';
      $('#kilometrazalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#kilometrazalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unoskilometraza != '' && isNum == true){//ako je uneto nesto i jesu brojevi
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverakilometraza = 1;
      errorkilometraza = '';//brisemo error poruku za ovo polje
      $('#kilometrazalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#kilometrazalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje gorivo automobila popunjeno ili je ostalo prazno
    var unosgorivo = $('#gorivo').val();//uzimamo userov unos
    if(unosgorivo == ''){// ako je prazno
      //varijabla proveragorivo se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveragorivo = 0;     
      errorgorivo = '<br><b>"Gorivo"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#gorivolabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#gorivolabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosgorivo != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveragorivo = 1;
      errorgorivo = '';//brisemo error poruku za ovo polje
      $('#gorivolabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#gorivolabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje emisionaklasa automobila popunjeno ili je ostalo prazno
    var unosemisionaklasa = $('#emisionaklasa').val();//uzimamo userov unos
    if(unosemisionaklasa == ''){// ako je prazno
      //varijabla proveraemisionaklasa se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraemisionaklasa = 0;     
      erroremisionaklasa = '<br><b>"Emisiona Klasa"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#emisionaklasalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#emisionaklasalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosemisionaklasa != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraemisionaklasa = 1;
      erroremisionaklasa = '';//brisemo error poruku za ovo polje
      $('#emisionaklasalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#emisionaklasalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje pogon automobila popunjeno ili je ostalo prazno
    var unospogon = $('#pogon').val();//uzimamo userov unos
    if(unospogon == ''){// ako je prazno
      //varijabla proverpogon se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverapogon = 0;     
      errorpogon = '<br><b>"Pogon"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#pogonlabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#pogonlabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unospogon != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverapogon = 1;
      errorpogon = '';//brisemo error poruku za ovo polje
      $('#pogonlabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#pogonlabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje menjac automobila popunjeno ili je ostalo prazno
    var unosmenjac = $('#menjac').val();//uzimamo userov unos
    if(unosmenjac == ''){// ako je prazno
      //varijabla proveramenjac se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramenjac = 0;     
      errormenjac = '<br><b>"Menjač"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#menjaclabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#menjaclabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosmenjac != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveramenjac = 1;
      errormenjac = '';//brisemo error poruku za ovo polje
      $('#menjaclabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#menjaclabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje ostecen automobila popunjeno ili je ostalo prazno
    var unosostecen = $('#ostecen').val();//uzimamo userov unos
    if(unosostecen == ''){// ako je prazno
      //varijabla proveraostecen se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraostecen = 0;     
      errorostecen = '<br><b>"Oštećen"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#ostecenlabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#ostecenlabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosostecen != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraostecen = 1;
      errorostecen = '';//brisemo error poruku za ovo polje
      $('#ostecenlabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#ostecenlabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje brvrata automobila popunjeno ili je ostalo prazno
    var unosbrvrata = $('#brvrata').val();//uzimamo userov unos
    if(unosbrvrata == ''){// ako je prazno
      //varijabla proverabrvrata se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverabrvrata = 0;     
      errorbrvrata = '<br><b>"Broj Vrata"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#brvratalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#brvratalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosbrvrata != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverabrvrata = 1;
      errorbrvrata = '';//brisemo error poruku za ovo polje
      $('#brvratalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#brvratalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje brsedista automobila popunjeno ili je ostalo prazno
    var unosbrsedista = $('#brsedista').val();//uzimamo userov unos
    if(unosbrsedista == ''){// ako je prazno
      //varijabla proverabrsedista se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverabrsedista = 0;     
      errorbrsedista = '<br><b>"Broj Sedišta"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#brsedistalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#brsedistalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosbrsedista != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverabrsedista = 1;
      errorbrsedista = '';//brisemo error poruku za ovo polje
      $('#brsedistalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#brsedistalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje stranavolana automobila popunjeno ili je ostalo prazno
    var unosstranavolana = $('#stranavolana').val();//uzimamo userov unos
    if(unosstranavolana == ''){// ako je prazno
      //varijabla proverastranavolana se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverastranavolana = 0;     
      errorstranavolana = '<br><b>"Strana Volana"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#stranavolanalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#stranavolanalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosstranavolana != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proverastranavolana = 1;
      errorstranavolana = '';//brisemo error poruku za ovo polje
      $('#stranavolanalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#stranavolanalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje klima automobila popunjeno ili je ostalo prazno
    var unosklima = $('#klima').val();//uzimamo userov unos
    if(unosklima == ''){// ako je prazno
      //varijabla proveraklima se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraklima = 0;     
      errorklima = '<br><b>"Klima"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#klimalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#klimalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosklima != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraklima = 1;
      errorklima = '';//brisemo error poruku za ovo polje
      $('#klimalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#klimalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje boja automobila popunjeno ili je ostalo prazno
    var unosboja = $('#boja').val();//uzimamo userov unos
    if(unosboja == ''){// ako je prazno
      //varijabla proveraboja se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraboja = 0;     
      errorboja = '<br><b>"Boja"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#bojalabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#bojalabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosboja != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraboja = 1;
      errorboja = '';//brisemo error poruku za ovo polje
      $('#bojalabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#bojalabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------
    //provera da li je posle gubitka fokusa polje poreklo automobila popunjeno ili je ostalo prazno
    var unosporeklo = $('#poreklo').val();//uzimamo userov unos
    if(unosporeklo == ''){// ako je prazno
      //varijabla proveraporeklo se podesava na 0(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraporeklo = 0;     
      errorporeklo = '<br><b>"Poreklo"</b> je obavezno polje!';//pravimo error poruku koja ce biti deo globalnog error-a
      $('#poreklolabel').removeClass('text-success');//labelu za ovo polje uklanjamo text-success klasu
      $('#poreklolabel').addClass('text-danger');//i dajemo text-danger klasu
    }else if(unosporeklo != ''){//ako je uneto nesto
      //varijabla proverammodela se podesava na 1(hendler za mousenter na submit koristi ovo da zna da li moze da se sabmituje forma)
      proveraporeklo = 1;
      errorporeklo = '';//brisemo error poruku za ovo polje
      $('#poreklolabel').removeClass('text-danger');//labelu za ovo polje uklanjamo text-danger klasu
      $('#poreklolabel').addClass('text-success');//i dajemo text-success klasu
    }
    //-----------------------------------------------------------------------------------------------------------------------------------

    // alert(proveranaslova);
    var error = '<img src="'+slikeurl+'/img/redclose.png" class="pull-right zatvoriinfo" id="zatvorierrore">';
    //varijabla u kojoj se cuva html za error-e
    error += 'Pogrešno ste popunili formu'+errornaslova+errormarke+errormodela+errorcena+errorgodiste+errorkaroserija+errorkubikaza+errorks+errorkw+errorkilometraza+errorgorivo+erroremisionaklasa+errorpogon+errormenjac+errorostecen+errorbrvrata+errorbrsedista+errorstranavolana+errorklima+errorboja+errorporeklo;
    //proveravamo da li je kontrolna varijabla za svako polje forme 0 ili 1 tj ako je 0 onda polje ima gresku i variabla provera ce biti 0
    if(proveranaslova == 0 || proveramarke == 0 || proveramodela == 0 || proveracena == 0 || proveragodiste == 0 || proverakaroserija == 0 || proverakubikaza == 0 || proveraks == 0 || proverakw == 0 || proverakilometraza == 0 || proveragorivo == 0 || proveraemisionaklasa == 0 || proverapogon == 0 || proveramenjac == 0 || proveraostecen == 0 || proverabrvrata == 0 || proverabrsedista == 0 || proverastranavolana == 0 || proveraklima == 0 || proveraboja == 0 || proveraporeklo == 0){
      provera = 0;
    }else{//ako nema gresaka u popunjavanju forme
      provera = 1;
    }
    if(provera != 0){  
      $('#objavioglas').prop('disabled', false); // dozvoljavamo klik na submit btn tj na btn #objavioglas 
      $('.errorsuccess').removeClass('alert-danger').addClass('alert-success');//div koji prikazuej error-e postaje div koji prikazuje succes poruku
      var uspesanoglas = '<b id="uspehporuka">Uspešno ste popunili formu za dodavanje oglasa.</b><div class="errori"></div>';
      $('.errorsuccess').html(uspesanoglas);
    }else{ // ako je bilo gresaka pri popuni forme tj variabla provera je 0
      $('#objavioglas').prop('disabled', true);// disable-ujemo subnmit btn tj btn #objavioglas
      $('#uspehporuka').remove();// pravimo opet div na vrhu koji ce prikazati errore
      $('.errorsuccess').removeClass('alert-success').addClass('alert-danger');
      var losoglas = '<b>Polja kojima je naslov crvene boje su OBAVEZNA.</b><div class="errori"></div>';
      //$('<b>Polja kojima je naslov crvene boje su OBAVEZNA.</b>').insertBefore('.errori');
      $('.errorsuccess').html(losoglas);
      $('.errori').html(error);
      window.scrollTo(0,0); //radimo scrol na vrh ekrana
      //alert('provera:'+provera+', proveranaslova:'+proveranaslova+', proveramarke:'+proveramarke+',proveramodela:'+proveramodela+', proveracena:'+proveracena+', proveragodiste:'+proveragodiste+', proverakaroserija:'+proverakaroserija+', proverakubikaza:'+proverakubikaza);
    }
  });

//---------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------
  
  //uklanjanje div-a koji na vrhu novioglas.blade.php prikazuje errore kad user pokusa da submituje lose popunjemu formu
  $('body').on('click', '#zatvorierrore', function(){
    $('.errori').html('');    
  });



});