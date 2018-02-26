<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use App\Marka;
use App\User;
use App\Modeli;
use App\Oglasi;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Redirect;


class MarkaController extends Controller{

//samo autorizovani tj ulogovani useri imaju pristup metodima ovog kotrolera
public function __construct(){
  $this->middleware('auth');
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod prikazuje vju dodajmarku.blade.php iz 'auto\resources\views\admin' u kom je forma za dodavanje marki u 'markas' tabelu
public function index(Request $request){
  if($request->user()->is_admin()){	//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    //vadimo sve iz 'markas' tabele(order po name koloni),ovo nam treba da bi mogli da napravimo select u formi za dodavanje modela neke marke
    $marke = Marka::all()->sortBy("name");
    return view('admin.dodajmarku')->withMarke($marke);// ako jeste saljemo ga na vju dodajmarku.blade.php
  }else{ //ako nije admin saljemo ga na '/'
  	return redirect('/');
  }
}	

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//Metod se poziva kad se u dodajmarku.blade.php sabmituje forma za unos nove marke u 'markas' tabelu(takodje se uploaduje i logo marke koji se 
//-cuva u folderu 'auto\public\img\autologo')
public function store(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    //prvo validacija
    $this->validate($request, array(
      'imemarke' => 'required|max:255', // polje imemarke je obavezno i maksimalno 255 karaktera 
      'inputimages' => 'required'//slika je obavezna
    ));
    $marka = new Marka();
    $marka->name = $request->get('imemarke');//uzimamo ime marke koju je user uneo u formu to ide u name kolonu 'markas' tabele
    $image = $request->file('inputimages');//uzimamo sliku koju je user uploadovao
    $fileName = str_slug($request->get('imemarke')).'.png'; // napravi ime slike(slug od imena marke)
    $image_resize = Image::make($image->getRealPath());//koristeci Intervention\Image libratry resize-ujemo sliku
    $image_resize->resize(100, 100);
    //$image_resize->move("img/autologo/", $fileName); 
    $image_resize->save(public_path('img/autologo/' .$fileName));//cuvamo sliku tj logo u folderu 'auto\public\img\autologo'
    $marka->logo = $fileName;//ime slike upisujemo u logo kolonu 'markas' tabele
    $marka->save();//cuvamo userov unos u tabelu
    $ime = $request->get('imemarke');//ovde pravimo success poruku koju ubacujemo u Session da bi je vju prikazao
    $success = '<img src="img/greenclose.png" class="pull-right closebtnsuccess">Uspesno ste uneli marku: '.$ime.'<br><img src="img/autologo/'.$fileName.'">';
    Session::flash('success', $success);
    return redirect()->back();//vracamo se na dodajmarku.blade.php sa success porukom u sesiji
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se u dodajmarku.blade.php sabmituje forma za dodavanje novog modela neke marke, zatim ovaj metod upisuje red u 'modelis'-
//tabelu
public function storemodel(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    //prvo validacija
    $this->validate($request, array(
      'imemodela' => 'required|max:255', // polje imemodela je obavezno i maksimalno 255 karaktera
      'imemarke2' => 'required' 
    ));
    $model = new Modeli();
    $model->marka_id = $request->get('imemarke2');//uzimamo id marke(id kolona 'markas' tabele, to je select polje u formi za dodavanje modela)
    $model->ime = $request->get('imemodela');//uzimamo ime koje je uneto u input u formi 
    $model->save(); //upisujemo red u 'modelis' tabelu
    $idmarke = $request->get('imemarke2');//sada vadimo iz 'markas' kolone ime marke kojoj smo dodali model da bi success poruka bila lepsa...
    $marka2 = DB::table('markas')->where('id', $idmarke)->value('name');
    $successmodel = '<img src="img/greenclose.png" class="pull-right closebtnsuccess">Uspesno ste uneli model: '.$request->get('imemodela').' Za marku: '.$marka2;//pravimo succes message
    Session::flash('successmodel', $successmodel);//ubacujemo success message u sesiju
    //vadimo potrebne vrednosti iz 'markas' tabele tj logo, id i ime marke ciji smo model menjali da bi vju dodajmarke.blade.php znao da treba
    //da opet prikaze otvoren div sa formom za unos modela za istu tu marku i njen logo
    $markaime = $marka2;
    $markalogo2 = DB::table('markas')->where('id', $idmarke)->value('logo');
    $markaid2 = DB::table('markas')->where('id', $idmarke)->value('id');
    $marke = Marka::all()->sortBy("name");
    //pozivamo vju dodajmarke.blade.php i saljemo mu potrebne variable
    return view('admin.dodajmarku')->withMarke($marke)->withMarkaime($markaime)->withMarkalogo2($markalogo2)->withMarkaid2($markaid2);
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se u dodajmarku.blade.php klikne div.prikazimodelemarke koji je vidljiv ako je u formi za dodavanje modela odabrana neka
//marka, stize AJAX iz hendlera iz dodajmarke.js za klik na div .prikazimodelemarke i u AJAX-u id marke koji koristimo da iz 'modelis' tabeke
//po koloni marka_id izvucemo sve modele marke, hendler u dodajmarke.js posle od toga pravi ul koja prikazuje do sada unete moddele neke marke
//sa opcijom za njihovo editovanjwe
public function prikazimodele(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    $idmarke = $request['idmarke'];//uzimamo id marke koji je stigao AJAX-om
    //pretrazujemo 'modelis' tabelu po marka_id koloni koristeci pristigli id marke
    $modeli = Modeli::where('marka_id', $idmarke)->orderBy('ime', 'ASC')->get();
    return response()->json(['modeli' => $modeli]); //vracamo u dodajmarke.js podatke koje smo izvukli iz tabele 'modelis'
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod za editovanje modela, poziva se kad se u dodajmarku.blade.php sabmituje forma za editovanje modela koja je vidljiva kad kliknemo na -
//-ikonicu edit pored nekog modela(modeli su vidljivi u listi ispod forme za dodavanje novog modela marke), stize AJAX iz dodajmarke.js tj iz
//-hendlera za klik na btn #izmenimodel
public function izmenimodel(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    $staroimemodela = $request['staroimemodela'];//uzimamo staro ime modela koji se edituje(stigao AJAX-om)
    $idmodelazaedit = $request['idmodelazaedit'];//uzimamo id modela koji se edituje(stigao AJAX-om)
    $modelzaedit = Modeli::where('id', $idmodelazaedit)->first();//nalazimo u 'modelis' tabeli model za editovanje po id koji je stigao
    $modelzaedit->ime = $request['novoimemodela'];//prepravljamo ime kolonu novim imenom koje je stiglo AJAX-om
    $modelzaedit->save();//cuvamo promenu u 'miodelis' tabeli
    //takodje u 'oglasis' tabeli menjamo u koloni model ime modela do sada unetim oglasima koji su ovaj model
    Oglasi::where('model', $staroimemodela)->update(['model' => $request['novoimemodela']]);
    return response()->json(['modelzaedit' => $modelzaedit]);//vracamo odgovor hendleru u dodajmarke.js koji je poslao request 
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//kad se u dodajmarku.blade.php u ul koja prikazuje modele neke marke pored nekog modela klikne btn tj glyphicon za trash preko rute /deletemodel
//stize ovde AJAX u kom je id modela za brisanje kog ovaj metod brise
public function deletemodel(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    $idmodelazdelete = $request['idmodelazdelete'];//uzimamo id modela koji se brise(stigao AJAX-om)
    $modelazdelete = Modeli::where('id', $idmodelazdelete)->first();//nalazimo u 'modelis' tabeli model za brisanje po id koji je stigao
    $deleted = $modelazdelete->delete();
    //vracamo odgovor hendleru u dodajmarke.js koji je poslao request, ako je uspesno obrisao vrednost $deleted varijable je true
    return response()->json(['deleted' => $deleted]);
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod koji radi update 'markas' tabele i takodje rename-uje logo marke ili brise stari i uploaduje novi u 'public/img/autologo' folder ako je 
//admin menjao sliku logo-a marke, sve ovo kad se sabmituje forma za editovanje marke u dodajmarke.blade.php(forma se generise u dodajmarke.js
//tj hendler za klik na div .editmarke)
public function izmenimarku(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    //prvo validacija
    $this->validate($request, array(
      'novoimemarke' => 'required|max:255' // polje imemarke je obavezno i maksimalno 255 karaktera 
    ));
    //od novog imena marke pravimo ime za kolonu logo i za novu sliku tj logo
    $novilogo = str_slug($request->get('novoimemarke')).'.png';
    $marka = Marka::find($request->get('idmarke'));//nalazimo u 'markas' tabeli marku koju editujemo po id koloni
    $marka->name = $request->get('novoimemarke');//uzimamo novo ime marke koju je user uneo u formu to ide u name kolonu 'markas' tabele
    $marka->logo = $novilogo;//poso je novo ime moramo menjati i logo kolonu
    if($request->file('novilogo')){//ako je admin uploadovao novu sliku tj logo
      //brisemo stari logo, ime starog logoa je doslo u requestu posto u hidden polju forme ima upisano staro ime logoa
      unlink('img/autologo/' . $request->get('starilogo'));
      $image = $request->file('novilogo');//uzimamo sliku koju je user uploadovao
      $fileName = str_slug($request->get('novoimemarke')).'.png'; // napravi ime slike(slug od imena marke)
      $image_resize = Image::make($image->getRealPath());//koristeci Intervention\Image libratry resize-ujemo sliku
      $image_resize->resize(100, 100);
      $image_resize->save(public_path('img/autologo/' . $fileName));//cuvamo sliku tj logo u folderu 'auto\public\img\autologo'
      $marka->logo = $fileName;//ime slike upisujemo u logo kolonu 'markas' tabele
    }else{//ako admin nije menjao sliku onda samo rename-ujemo onu koja vec postoji
      rename('img/autologo/' . $request->get('starilogo'), 'img/autologo/' . $novilogo);
    }    
    $marka->save();//cuvamo userov unos u tabelu
    $novoime = $request->get('novoimemarke');//ovde pravimo success poruku koju ubacujemo u Session da bi je vju prikazao
    $staroime = $request->get('staroime');
    //takodje u 'oglasis' tabeli menjamo u koloni marka ime marke do sada unetim oglasima koji su ove marke 
    Oglasi::where('marka', $staroime)->update(['marka' => $novoime]);
    $successizmena = '<img src="img/greenclose.png" class="pull-right closebtnsuccess">Uspešno ste izmenili marku: '.$staroime.' u '.$novoime.'<br><img src="img/autologo/'.$novilogo.'?vreme='.date('Y-m-d H:i:s').'">';
    Session::flash('successizmena', $successizmena);
    //return redirect()->back();//vracamo se na dodajmarku.blade.php sa success porukom u sesiji
    $marke = Marka::all()->sortBy("name");
    return view('admin.dodajmarku')->withMarke($marke);
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//kad se sabmituje forma za brisanje marke u dodajmarke.blade.php koja je izgenerisana u hendleru za klik na div .editmarke u dodajmarke.js
//metod brise marku iz 'markas' tabele, brise logo marke iz foldera '\public\img\autologo' i takodje iz 'modelis' tabele brise sve modele marke
//koju brisemo
public function obrisimarku(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    $idmarke = $request->get('idmarkebrisanje');//uzimamo id marke koju brisemo koji je stigao kad je sabmitovana forma
    $marka = Marka::find($idmarke);//u 'markas' tabeli nalazimo marku koju zelimo da brisemo
    $ime = $marka->name;//uzimamo ime marke da bi napravili success message
    if($marka){//ako nadje marku brisemo je iz 'markas' tabele i brisemo logo
      $marka->delete();
      unlink('img/autologo/' . $request->get('starilogobrisanje'));
    }else{
      return redirect()->back();
    }//pravimo success message
    $successbrisanje = '<img src="img/greenclose.png" class="pull-right closebtnsuccess">Uspešno ste obrisali marku '.$ime.'!';
    Session::flash('successbrisanje', $successbrisanje);
    return redirect()->back();
  }else{//ako user koji poziva metod nije admin saljemo ga na '/'
    return redirect('/');
  }
}


}
