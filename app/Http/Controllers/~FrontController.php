<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Oglasi;
use App\User;
use App\Marka;
use App\Modeli;

class FrontController extends Controller
{

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod ucitava pocetnu stranicu sajta, poziva ga ruta '/', vadi prvih 6 odobrenih oglasa (tj najnovijih) iz 'oglasis' tabele i salje u 
//vju welcome.blade.php na prikazivanje, takodje vadi ukupan broj odobrenih oglasa i marke iz 'markas' tabele da bi se popunio select za
//marku u formi za pretragu koja je na vrhu vjua
public function index(){
  $oglasi = Oglasi::where('odobren', 1)->orderBy('created_at', 'DESC')->paginate(6);
  $ukupnooglasa = Oglasi::where('odobren', 1)->count();
  //vadimo marke iz 'markas' tabele da bi se popunio select za marku u welcome.blade.php
  $marke = Marka::all()->sortBy("name");
  return view('welcome')->withOglasi($oglasi)->withUkupnoolgasa($ukupnooglasa)->withMarke($marke);
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva iz hendlera za klik na h1.naslovjosoglasa u welcome.blade.php koji je u welcome.js, salje AJAX preko rute '/josoglasa'
//iz requesta uzima skip(offset) i take(limit) i pravi query tj vadi odobrene oglase iz 'oglasis' tabele koje zatim hendler iz welcome.js
//prikazuje ispod prvih 6 oglasa koje vadi index() metod ovog kontrolera
public function josoglasa(Request $request){
  $skip = $request['skip'];
  $take = $request['take'];
  $oglasi = Oglasi::where('odobren', 1)->orderBy('created_at', 'DESC')->skip($skip)->take($take)->get();
  return response()->json(['oglasi' => $oglasi]);
  //dd($oglasi);
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se u welcome.blade.php u formi za pretragu oglasa odaqbere marka pa onda ide AJAX iz welcome.js koji preko
//ovog metoda vadi sve modele te marke iz 'modelis' tabele i popunjava select za model u formi
public function izvadimodele(Request $request){
  $idmarke = $request['idmarke'];
  $modeli = Modeli::where('marka_id', $idmarke)->orderBy('ime', 'ASC')->get();
  return response()->json(['modeli' => $modeli]);	
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//kad se sabmituje forma za pretragu oglasa u frontendu preko rute '/frontpretraga' poziva se ovaj metod
public function pretraga(Request $request){
  //
  $sort = 'created_at';
  $ascdesc = 'DESC';
  //userov odabir u selectu za marku vozila
  $markaautomobila = $request->get('markaautomobila');
  //userov odabir u selectu za model marke vozila
  $modelpretraga = $request->get('modelmarke');
  //
  $modeli = '';
  //ako je user pretrazio po marki automobila, vadimo sve modele te marke da bi imao u selectu za model sve modele pa ako zeli moze da 
  //ide detaljnije u pretragu
  if($markaautomobila){
    $idmarke = Marka::where('name', $markaautomobila)->value('id');
    $modeli = Modeli::where('marka_id', $idmarke)->get();
  }
  //ako je user pretrazio po gorivu
  $gor = $request->get('gor');
  //userov izbor u selectima za godinu od i godinu do
  $godod = $request->get('godod');
  $goddo = $request->get('goddo');
  //u zavisnosti da li je user odabrao samo godinu od ili godinu do ili obe variabla $pretragagodista moze biti 1, 2 ili 3 i u zavisnosti 
  //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli godiste >= $godisteod, ako je 2 onda godiste <= $godistedo
  //ako je 3 onda se trazi WHERE godiste BETWEEN godisteod, $godistedo
  $pretragagodista = NULL;
  if($godod != '' && $goddo == ''){
    $pretragagodista = 1;
  }elseif($godod == '' && $goddo != ''){
    $pretragagodista = 2;
  }elseif($godod != '' && $goddo != ''){
    $pretragagodista = 3;
  }
  //u zavisnosti da li je user odabrao samo cenu od ili cenu do ili obe variabla $pretragacena moze biti 1, 2 ili 3 i u zavisnosti 
  //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli cena >= $cenaod, ako je 2 onda cena <= $cenado
  //ako je 3 onda se trazi WHERE cena BETWEEN cenaod, $cenado
  //userov izbor u selectima za cenu od i cenu do
  $cod = $request->get('cod');
  $cdo = $request->get('cdo');
  $pretragacena = NULL;
  if($cod != '' && $cdo == ''){
    $pretragacena = 1;
  }elseif($cod == '' && $cdo != ''){
    $pretragacena = 2;
  }elseif($cod != '' && $cdo != ''){
    $pretragacena = 3;
  }
  //userov odabir u selectu za karoseriju vozila
  $kar = $request->get('kar');
  //u zavisnosti da li je user odabrao samo kubikaza od ili kubikaza do ili obe variabla $pretragakubikaza moze biti 1, 2 ili 3 i u zavisnosti 
  //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli kubikaza >= $kubikazaod, ako je 2 onda kubikaza <= $kubikazado
  //ako je 3 onda se trazi WHERE kubikaza BETWEEN kubikazaod, $kubikazado
  //userov izbor u selectima za godinu od i godinu do
  $kubod = $request->get('kubod');
  $kubdo = $request->get('kubdo');
  $pretragakubikaza = NULL;
  if($kubod != '' && $kubdo == ''){
    $pretragakubikaza = 1;
  }elseif($kubod == '' && $kubdo != ''){
    $pretragakubikaza = 2;
  }elseif($kubod != '' && $kubdo != ''){
    $pretragakubikaza = 3;
  }
  //user moze izabrati da ne vidi ostecene automobile(1), da vidi i ostecene i neostecene(2), da vidi samo neostecene(3) ili samo one koji ni
  //su u voznom stanju(4)
  $ost = $request->get('ost');
  if($ost == 1){
    $pretragaostecen = 1;
  }elseif($ost == 2){
    $pretragaostecen = 2;
  }elseif($ost == 3){
    $pretragaostecen = 3;
  }elseif($ost == 4){
    $pretragaostecen = 4;
  }

  //ako je user kliknuo btn 'detaljna pretraga' onda ce biti 1 ako je radio malu pretragu bice 0
  $detpretr0ili1 = $request->get('detpretr0ili1');
  //OVA POLJA POSTOJE SAMO AKO JE RADJENA DETAJNA PRETRAGA
  //ako je user birao koju emisionu klasu zeli da vidi
  $emkl = $request->get('emkl'); 
  //u zavisnosti da li je user odabrao samo snaga od ili snaga do ili obe variabla $pretragasnaga moze biti 1, 2 ili 3 i u zavisnosti 
  //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli snaga >= $snagaod, ako je 2 onda snaga <= $snagado
  //ako je 3 onda se trazi WHERE snaga BETWEEN snagaod, $snagado
  //userov izbor u selectima za snaga od i snaga do
  $snod = $request->get('snod');
  $sndo = $request->get('sndo');
  $pretragasnaga = NULL;
  if($snod != '' && $sndo == ''){
    $pretragasnaga = 1;
  }elseif($snod == '' && $sndo != ''){
    $pretragasnaga = 2;
  }elseif($snod != '' && $sndo != ''){
    $pretragasnaga = 3;
  }
  //u zavisnosti da li je user odabrao samo kilometraza od ili kilometraza do ili obe variabla $pretragakilometraza moze biti 1, 2 ili 3 i u
  //zavisnosti od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli kilometraza >= $kilometrazaod, ako je 2 onda 
  //kilometraza <= $kilometrazado ako je 3 onda se trazi WHERE kilometraza BETWEEN kilometrazaod, $kilometrazado userov izbor u selectima za
  //kilometraza od i kilometraza do
  $kilod = $request->get('kilod');
  $kildo = $request->get('kildo');
  $pretragakilometraza = NULL;
  if($kilod != '' && $kildo == ''){
    $pretragakilometraza = 1;
  }elseif($kilod == '' && $kildo != ''){
    $pretragakilometraza = 2;
  }elseif($kilod != '' && $kildo != ''){
    $pretragakilometraza = 3;
  }
  //ako je user odabrao nesto u selctu za pogon
  $pog = $request->get('pog'); 
  //ako je user odabrao nesto u selctu za menjac
  $menj = $request->get('menj'); 
  //ako je user odabrao nesto u selctu za broj vrata
  $brvr = $request->get('brvr');  
  //ako je user odabrao nesto u selctu za broj sedista
  $brsed = $request->get('brsed'); 
  //ako je user odabrao nesto u selctu za stranu volana
  $strvol = $request->get('strvol'); 
  //ako je user odabrao nesto u selctu za Klimu
  $kli = $request->get('kli');
  //ako je user odabrao nesto u selctu za Boju
  $boja = $request->get('boja'); 
  //ako je user odabrao nesto u selctu za Poreklo
  $por = $request->get('por'); 
  //ako je user cekirao Airbag u detaljnoj pretrazi
  $airb = NULL;
  if($request->get('airb')){
    $airb = 1;
  }
  //ako je user cekirao Child lock u detaljnoj pretrazi
  $cloc = NULL;
  if($request->get('cloc')){
    $cloc = 1;
  }
  //ako je user cekirao ABS u detaljnoj pretrazi
  $abs = NULL;
  if($request->get('abs')){
    $abs = 1;
  }
  //ako je user cekirao ESP u detaljnoj pretrazi
  $esp = NULL;
  if($request->get('esp')){
    $esp = 1;
  }
  //ako je user cekirao ASR u detaljnoj pretrazi
  $asr = NULL;
  if($request->get('asr')){
    $asr = 1;
  }
  //ako je user cekirao Alarm u detaljnoj pretrazi
  $alrm = NULL;
  if($request->get('alrm')){
    $alrm = 1;
  }

  //ako je user cekirao Xenon Svetla u detaljnoj pretrazi
  $xen = NULL;
  if($request->get('xen')){
    $xen = 1;
  }
  //ako je user cekirao LED Svetla u detaljnoj pretrazi
  $led = NULL;
  if($request->get('led')){
    $led = 1;
  }
  //ako je user cekirao Kozna Sedista u detaljnoj pretrazi
  $koza = NULL;
  if($request->get('koza')){
    $koza = 1;
  }
  

  //pravimo query u zavisnosti od toga sta je admin popunio u formi za pretragu odobrenih ili neodobrenih oglasa
  $oglasi = Oglasi::where('odobren', 1)
                  // ako je popunio polje marka u formi u adminoglasioilin.blade.php
                  ->when($request->markaautomobila, function($query) use ($request){
                    return $query->where('marka', $request->markaautomobila);
                  }) 
                  //ako je popunio polje model marke u formi u adminoglasioilin.blade.php
                  ->when($request->modelmarke, function($query) use ($request){
                    return $query->where('model', $request->modelmarke);
                  })
                  //ako je popunio polje gorivo u formi u adminoglasioilin.blade.php
                  ->when($request->gor, function($query) use ($request){
                    return $query->where('gorivo', $request->gor);
                  })
                  // ako je popunio godina od ili godina do ili oba
                  ->when($pretragagodista, function($query) use ($pretragagodista, $godod, $goddo){
                    if($pretragagodista == 1){
                      return $query->where('godiste', '>=', $godod);
                    }elseif($pretragagodista == 2){
                      return $query->where('godiste', '<=', $goddo);
                    }elseif($pretragagodista == 3){
                      return $query->whereBetween('godiste', [$godod, $goddo]);
                    }         
                  })
                  // ako je popunio cenu od ili cena do ili oba
                  ->when($pretragacena, function($query) use ($pretragacena, $cod, $cdo){
                    if($pretragacena == 1){
                      return $query->where('cena', '>=', $cod);
                    }elseif($pretragacena == 2){
                      return $query->where('cena', '<=', $cdo);
                    }elseif($pretragacena == 3){
                      return $query->whereBetween('cena', [$cod, $cdo]);
                    }         
                  })
                  //ako je popunio polje poreklo u formi u adminoglasioilin.blade.php
                  ->when($request->kar, function($query) use ($request){
                    return $query->where('karoserija', $request->kar);
                  })
                  // ako je popunio godina od ili godina do ili oba
                  ->when($pretragakubikaza, function($query) use ($pretragakubikaza, $kubod, $kubdo){
                    if($pretragakubikaza == 1){
                      return $query->where('kubikaza', '>=', $kubod);
                    }elseif($pretragakubikaza == 2){
                      return $query->where('kubikaza', '<=', $kubdo);
                    }elseif($pretragakubikaza == 3){
                      return $query->whereBetween('kubikaza', [$kubod, $kubdo]);
                    }         
                  })
                  //ako je user odlucio da ne vidi ostecena vozila onda je $pretragaostecen == 1, ako zeli da vidi i ostecena i neostecena on
                  //da je $pretragaostecen == 2, ako samo zeli ostecene onda je $pretragaostecen == 3 ako zeli samo koji nisu u voznom stanju
                  //onda je $pretragaostecen == 4
                  ->when($pretragaostecen, function($query) use ($pretragaostecen){
                    if($pretragaostecen == 1){
                      return $query->where('ostecen', 0);
                    }elseif($pretragaostecen == 2){
                      return $query->whereIn('ostecen', [0, 1, 2]);
                    }elseif($pretragaostecen == 3){
                      return $query->whereIn('ostecen', [1, 2]);
                    }elseif($pretragaostecen == 4){
                      return $query->where('ostecen', 2);
                    }
                  })
                  //ako je popunio polje emisiona klasa u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->emkl, function($query) use ($request){
                    return $query->where('emisionaklasa', $request->emkl);
                  })
                  // ako je popunio snaga od ili snaga do ili oba(DETALJNA PRETRAGA)
                  ->when($pretragasnaga, function($query) use ($pretragasnaga, $snod, $sndo){
                    if($pretragasnaga == 1){
                      return $query->where('snagaks', '>=', $snod);
                    }elseif($pretragasnaga == 2){
                      return $query->where('snagaks', '<=', $sndo);
                    }elseif($pretragasnaga == 3){
                      return $query->whereBetween('snagaks', [$snod, $sndo]);
                    }         
                  })
                  // ako je popunio kilometraza od ili kilometraza do ili oba(DETALJNA PRETRAGA)
                  ->when($pretragakilometraza, function($query) use ($pretragakilometraza, $kilod, $kildo){
                    if($pretragakilometraza == 1){
                      return $query->where('kilometraza', '>=', $kilod);
                    }elseif($pretragakilometraza == 2){
                      return $query->where('kilometraza', '<=', $kildo);
                    }elseif($pretragakilometraza == 3){
                      return $query->whereBetween('kilometraza', [$kilod, $kildo]);
                    }         
                  })
                  //ako je popunio polje pogon u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->pog, function($query) use ($request){
                    return $query->where('pogon', $request->pog);
                  })
                  //ako je popunio polje menjac u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->menj, function($query) use ($request){
                    return $query->where('menjac', $request->menj);
                  })
                  //ako je popunio polje brojvrata u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->brvr, function($query) use ($request){
                    return $query->where('brvrata', $request->brvr);
                  })
                  //ako je popunio polje broj sedista u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->brsed, function($query) use ($request){
                    return $query->where('brsedista', $request->brsed);
                  })
                  //ako je popunio polje strana volana u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->strvol, function($query) use ($request){
                    return $query->where('strvolana', $request->strvol);
                  })
                  //ako je popunio polje Klima u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->kli, function($query) use ($request){
                    return $query->where('klima', $request->kli);
                  })
                  //ako je popunio polje Boja u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->boja, function($query) use ($request){
                    return $query->where('boja', $request->boja);
                  })
                  //ako je popunio polje Poreklo u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->por, function($query) use ($request){
                    return $query->where('poreklo', $request->por);
                  })
                  //ako je cekirao checkbox Airbag u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->airb, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Airbag%');
                  })
                  //ako je cekirao checkbox Child lock u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->cloc, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Child lock%');
                  })
                  //ako je cekirao checkbox ABS u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->abs, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ABS%');
                  })
                  //ako je cekirao checkbox ESP u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->esp, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ESP%');
                  })
                  //ako je cekirao checkbox ASR u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->asr, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ASR%');
                  })
                  //ako je cekirao checkbox Alarm u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->alrm, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Alarm%');
                  })
                  //ako je cekirao checkbox kozna sedita u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->koza, function($query) use ($request){
                    return $query->where('oprema', 'like', '%Kožna sedišta%');
                  })
                  //ako je cekirao checkbox xenon svetla u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->xen, function($query) use ($request){
                    return $query->where('oprema', 'like', '%Xenon svetla%');
                  })
                  //ako je cekirao checkbox LED svetla u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->led, function($query) use ($request){
                    return $query->where('oprema', 'like', '%LED svetla%');
                  })
                  ->orderBy($sort, $ascdesc)
                  ->paginate(36);
  //ukupan br oglasa bez paginacije
  $oglasaukupno = Oglasi::where('odobren', 1)
                  // ako je popunio polje marka u formi u adminoglasioilin.blade.php
                  ->when($request->markaautomobila, function($query) use ($request){
                    return $query->where('marka', $request->markaautomobila);
                  }) 
                  //ako je popunio polje model marke u formi u adminoglasioilin.blade.php
                  ->when($request->modelmarke, function($query) use ($request){
                    return $query->where('model', $request->modelmarke);
                  })
                  //ako je popunio polje gorivo u formi u adminoglasioilin.blade.php
                  ->when($request->gor, function($query) use ($request){
                    return $query->where('gorivo', $request->gor);
                  })
                  // ako je popunio godina od ili godina do ili oba
                  ->when($pretragagodista, function($query) use ($pretragagodista, $godod, $goddo){
                    if($pretragagodista == 1){
                      return $query->where('godiste', '>=', $godod);
                    }elseif($pretragagodista == 2){
                      return $query->where('godiste', '<=', $goddo);
                    }elseif($pretragagodista == 3){
                      return $query->whereBetween('godiste', [$godod, $goddo]);
                    }         
                  })
                  // ako je popunio cenu od ili cena do ili oba
                  ->when($pretragacena, function($query) use ($pretragacena, $cod, $cdo){
                    if($pretragacena == 1){
                      return $query->where('cena', '>=', $cod);
                    }elseif($pretragacena == 2){
                      return $query->where('cena', '<=', $cdo);
                    }elseif($pretragacena == 3){
                      return $query->whereBetween('cena', [$cod, $cdo]);
                    }         
                  })
                  //ako je popunio polje poreklo u formi u adminoglasioilin.blade.php
                  ->when($request->kar, function($query) use ($request){
                    return $query->where('karoserija', $request->kar);
                  })
                  // ako je popunio godina od ili godina do ili oba
                  ->when($pretragakubikaza, function($query) use ($pretragakubikaza, $kubod, $kubdo){
                    if($pretragakubikaza == 1){
                      return $query->where('kubikaza', '>=', $kubod);
                    }elseif($pretragakubikaza == 2){
                      return $query->where('kubikaza', '<=', $kubdo);
                    }elseif($pretragakubikaza == 3){
                      return $query->whereBetween('kubikaza', [$kubod, $kubdo]);
                    }         
                  })
                  ->when($pretragaostecen, function($query) use ($pretragaostecen){
                    if($pretragaostecen == 1){
                      return $query->where('ostecen', 0);
                    }elseif($pretragaostecen == 2){
                      return $query->whereIn('ostecen', [0, 1, 2]);
                    }elseif($pretragaostecen == 3){
                      return $query->whereIn('ostecen', [1, 2]);
                    }elseif($pretragaostecen == 4){
                      return $query->where('ostecen', 2);
                    }
                  })
                  //ako je popunio polje emisiona klasa u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->emkl, function($query) use ($request){
                    return $query->where('emisionaklasa', $request->emkl);
                  })
                  // ako je popunio snaga od ili snaga do ili oba(DETALJNA PRETRAGA)
                  ->when($pretragasnaga, function($query) use ($pretragasnaga, $snod, $sndo){
                    if($pretragasnaga == 1){
                      return $query->where('snagaks', '>=', $snod);
                    }elseif($pretragasnaga == 2){
                      return $query->where('snagaks', '<=', $sndo);
                    }elseif($pretragasnaga == 3){
                      return $query->whereBetween('snagaks', [$snod, $sndo]);
                    }         
                  })
                  // ako je popunio kilometraza od ili kilometraza do ili oba(DETALJNA PRETRAGA)
                  ->when($pretragakilometraza, function($query) use ($pretragakilometraza, $kilod, $kildo){
                    if($pretragakilometraza == 1){
                      return $query->where('kilometraza', '>=', $kilod);
                    }elseif($pretragakilometraza == 2){
                      return $query->where('kilometraza', '<=', $kildo);
                    }elseif($pretragakilometraza == 3){
                      return $query->whereBetween('kilometraza', [$kilod, $kildo]);
                    }         
                  })
                  //ako je popunio polje pogon u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->pog, function($query) use ($request){
                    return $query->where('pogon', $request->pog);
                  })
                  //ako je popunio polje menjac u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->menj, function($query) use ($request){
                    return $query->where('menjac', $request->menj);
                  })
                  //ako je popunio polje brojvrata u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->brvr, function($query) use ($request){
                    return $query->where('brvrata', $request->brvr);
                  })
                  //ako je popunio polje broj sedista u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->brsed, function($query) use ($request){
                    return $query->where('brsedista', $request->brsed);
                  })
                  //ako je popunio polje strana volana u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->strvol, function($query) use ($request){
                    return $query->where('strvolana', $request->strvol);
                  })
                  //ako je popunio polje Klima u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->kli, function($query) use ($request){
                    return $query->where('klima', $request->kli);
                  })
                  //ako je popunio polje Boja u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->boja, function($query) use ($request){
                    return $query->where('boja', $request->boja);
                  })
                  //ako je popunio polje Poreklo u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->por, function($query) use ($request){
                    return $query->where('poreklo', $request->por);
                  })
                  //ako je cekirao checkbox Airbag u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->airb, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Airbag%');
                  })
                  //ako je cekirao checkbox Child lock u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->cloc, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Child lock%');
                  })
                  //ako je cekirao checkbox ABS u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->abs, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ABS%');
                  })
                  //ako je cekirao checkbox ESP u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->esp, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ESP%');
                  })
                  //ako je cekirao checkbox ASR u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->asr, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%ASR%');
                  })
                  //ako je cekirao checkbox Alarm u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->alrm, function($query) use ($request){
                    return $query->where('sigurnost', 'like', '%Alarm%');
                  })
                  //ako je cekirao checkbox kozna sedita u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->koza, function($query) use ($request){
                    return $query->where('oprema', 'like', '%Kožna sedišta%');
                  })
                  //ako je cekirao checkbox xenon svetla u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->xen, function($query) use ($request){
                    return $query->where('oprema', 'like', '%Xenon svetla%');
                  })
                  //ako je cekirao checkbox LED svetla u formi u adminoglasioilin.blade.php(DETALJNA PRETRAGA)
                  ->when($request->led, function($query) use ($request){
                    return $query->where('oprema', 'like', '%LED svetla%');
                  })
                  ->count();
  //vadimo sve narke koje su potrebne da bi se napravio select za Marku u formi za pretragu oglasa
  $marke = Marka::all()->sortBy("name");
  //ucitavamo vju rezpretrage.blade.php i aljemo mu sve potrebne variable
  return view('rezpretrage')
            ->withOglasi($oglasi)
            ->withOglasaukupno($oglasaukupno)
            ->withMarke($marke)
            ->withMarkaautomobila($markaautomobila)
            ->withModeli($modeli)
            ->withGor($gor)
            ->withModelpretraga($modelpretraga)
            ->withGodod($godod)
            ->withGoddo($goddo)
            ->withCod($cod)
            ->withCdo($cdo)
            ->withKar($kar)
            ->withKubod($kubod)
            ->withKubdo($kubdo)
            ->withOst($ost)
            ->withDetpretr0ili1($detpretr0ili1)
            ->withEmkl($emkl)
            ->withSnod($snod)
            ->withSndo($sndo)
            ->withKilod($kilod)
            ->withKildo($kildo)
            ->withPog($pog)
            ->withMenj($menj)
            ->withBrvr($brvr)
            ->withBrsed($brsed)
            ->withStrvol($strvol)
            ->withKli($kli)
            ->withBoja($boja)
            ->withPor($por)
            ->withAirb($airb)
            ->withCloc($cloc)
            ->withAbs($abs)
            ->withEsp($esp)
            ->withAsr($asr)
            ->withAlrm($alrm)
            ->withKoza($koza)
            ->withXen($xen)
            ->withLed($led)
            ->withSort($sort)
            ->withAscdesc($ascdesc);
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------


}
