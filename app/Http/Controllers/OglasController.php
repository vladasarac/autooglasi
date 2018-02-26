<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Http\RedirectResponse;
use Redirect;
use DB;
use App\User;
use App\Marka;
use App\Modeli;
use App\Oglasi;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Filesystem\Filesystem;

class OglasController extends Controller
{


public function __construct(){
  $this->middleware('auth');
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod vraca vju novioglas.blade.php iz 'auto\resources\views\users' u kom je forma za dodavanje novog oglasa, ako je u requestu stigao id zna-
//ci da ga poziva admin koji ce za nekog usera postaviti oglas, ako nije znaci da ga poziva user koji je aktivan
public function novioglas(Request $request, $id = null){
  //vadimo sve marke iz 'markas' tabele za formu tj select input za marku automobila
  $marke = Marka::all()->sortBy("name");
  //ako je requester admin i ako je stigao id	
  if($request->user()->is_admin() && $id != null){ 
  	$user = User::where('id', $id)->first();  //iz 'users' tabele vadimo usera po id koji je stigao u requestu
  	return view('users.novioglas')->withUser($user)->withMarke($marke);  //pozivamo vju novioglas.blade.php i saljemo mu usera
  }elseif($request->user()->aktivan()){  //ako je requester aktivan tj nije admin	
    $user = $request->user(); //$user ce biti requester
    return view('users.novioglas')->withUser($user)->withMarke($marke);//pozivamo vju novioglas.blade.php i saljemo mu usera
  }else{  //u suprotnom saljemo requestera na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se u novioglas.blade.php u formi za dodavanje novog oglasa odaqbere marka pa onda ide AJAX iz novioglas.js koji preko
//ovog metoda vadi sve modele te marke iz 'modelis' tabele i popunjava select za model u formi
public function izvadimodele(Request $request){
  $idmarke = $request['idmarke'];
  //$modeli = Modeli::where('marka_id', $idmarke)->orderBy('LENGTH(ime)', 'ASC')->get();
  $modeli = Modeli::where('marka_id', $idmarke)->orderBy('ime', 'ASC')->get();
  return response()->json(['modeli' => $modeli]);	
}

//--------------------------------------------------------------------------------------------------------------------------------------
// UPIS NOVOG OGLASA U 'oglasis' TABELU
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se koristi da se napravi string koji se upisuje u kolonu sigurnost 'oglasis' tabele. Pozivaju ga metodi upisinovioglas() i izmenioglas()
private function sigurnost(Request $request){
  $sigurnost = '';
  //ako je cekirao Airbag checkbox onda dodajemo na variablu $sigurnost 'Airbag, ' itd za svaki checkbox
    if($request->get('airbag')){
      $sigurnost .= 'Airbag, ';
    }
    if($request->get('childlock')){
      $sigurnost .= 'Child lock, ';
    }
    if($request->get('abs')){
      $sigurnost .= 'ABS, ';
    }
    if($request->get('esp')){
      $sigurnost .= 'ESP, ';
    }
    if($request->get('asr')){
      $sigurnost .= 'ASR, ';
    }
    if($request->get('alarm')){
      $sigurnost .= 'Alarm, ';
    }
    if($request->get('kodiranklj')){
      $sigurnost .= 'Kodiran ključ, ';
    }
    if($request->get('blokada')){
      $sigurnost .= 'Blokada motora, ';
    }
    if($request->get('centralna')){
      $sigurnost .= 'Centralna brava, ';
    }
    if($request->get('zeder')){
      $sigurnost .= 'Zeder, ';
    }
    //odsecamo zadnji space i zarez
    $sigurnost = substr($sigurnost, 0, -2);
    return $sigurnost;
}
//metod se koristi da se napravi string koji se upisuje u kolonu oprema 'oglasis' tabele. Pozivaju ga metodi upisinovioglas() i izmenioglas()
private function oprema(Request $request){
  $oprema = '';
  //ako je cekirao Metalik boja checkbox onda dodajemo na variablu $sigurnost 'Metalik boja, ' itd za svaki checkbox
    if($request->get('metalik')){
      $oprema .= 'Metalik boja, ';
    }
    if($request->get('servo')){
      $oprema .= 'Servo volan, ';
    }
    if($request->get('multi')){
      $oprema .= 'Multi volan, ';
    }
    if($request->get('tempomat')){
      $oprema .= 'Tempomat, ';
    }
    if($request->get('racunar')){
      $oprema .= 'Putni računar, ';
    }
    if($request->get('siber')){
      $oprema .= 'Šiber, ';
    }
    if($request->get('panorama')){
      $oprema .= 'Panorama krov, ';
    }
    if($request->get('elpodizaci')){
      $oprema .= 'El. podizači, ';
    }
    if($request->get('elretrovizori')){
      $oprema .= 'El. retrovizori, ';
    }
    if($request->get('gretrovizor')){
      $oprema .= 'Grejači retrovizora, ';
    }
    if($request->get('elpodsed')){
      $oprema .= 'El. podesiva sedišta, ';
    }
    if($request->get('grejanjesed')){
      $oprema .= 'Grejanje sedišta, ';
    }
    if($request->get('svmagla')){
      $oprema .= 'Svetla za maglu, ';
    }
    if($request->get('xenon')){
      $oprema .= 'Xenon svetla, ';
    }
    if($request->get('ledsvetla')){
      $oprema .= 'LED svetla, ';
    }
    if($request->get('svsenz')){
      $oprema .= 'Senzori za svetla, ';
    }
    if($request->get('kisasenz')){
      $oprema .= 'Senzori za kišu, ';
    }
    if($request->get('parksenz')){
      $oprema .= 'Parking senzori, ';
    }
    if($request->get('krnosac')){
      $oprema .= 'Krovni nosač, ';
    }
    if($request->get('kuka')){
      $oprema .= 'Kuka za vuču, ';
    }
    if($request->get('alufelne')){
      $oprema .= 'Alu. felne, ';
    }
    if($request->get('navigacija')){
      $oprema .= 'Navigacija, ';
    }
    if($request->get('radio')){
      $oprema .= 'Radio, ';
    }
    if($request->get('cd')){
      $oprema .= 'CD Player, ';
    }
    if($request->get('dvdtv')){
      $oprema .= 'DVD/TV, ';
    }
    if($request->get('webasto')){
      $oprema .= 'Webasto, ';
    }
    if($request->get('grejvetrobran')){
      $oprema .= 'Grejači vetrobrana, ';
    }
    if($request->get('koza')){
      $oprema .= 'Kožna sedišta, ';
    }
    //odsecamo zadnji space i zarez
    $oprema = substr($oprema, 0, -2);
    return $oprema;
}
//metod se koristi da se napravi string koji se upisuje u kolonu stanje 'oglasis' tabele. Pozivaju ga metodi upisinovioglas() i izmenioglas()
private function stanje(Request $request){
  $stanje = '';
  //ako je cekirao Prvi vlasnik checkbox onda dodajemo na variablu $stanje 'Prvi vlasnik, ' itd za svaki checkbox
    if($request->get('prvivlasnik')){
      $stanje .= 'Prvi vlasnik, ';
    }
    if($request->get('novusr')){
      $stanje .= 'Kupljen nov u Srbiji, ';
    }
    if($request->get('garancija')){
      $stanje .= 'Garancija, ';
    }
    if($request->get('garaza')){
      $stanje .= 'Garažiran, ';
    }
    if($request->get('servisknj')){
      $stanje .= 'Servisna knjiga, ';
    }
    if($request->get('rezklj')){
      $stanje .= 'Rezervni ključ, ';
    }
    if($request->get('tuning')){
      $stanje .= 'Tuning, ';
    }
    if($request->get('oldtimer')){
      $stanje .= 'Oldtimer, ';
    }
    if($request->get('test')){
      $stanje .= 'Test vozilo, ';
    }
    if($request->get('taxi')){
      $stanje .= 'Taxi, ';
    }
    //odsecamo zadnji space i zarez
    $stanje = substr($stanje, 0, -2);
    return $stanje;
}

//metod upisuje novi oglas u 'oglasis' tabelu
public function upisinovioglas(Request $request){
  if($request->user()->is_admin() || $request->user()->aktivan()){
    //vadimo verifikacioni kod usera iz 'users' tabele posto se po njemu zove folder u 'auto\public\img\oglasi' u koji ovaj user koji postavlja 
    //oglas uploaduje slike
    $folderslike = User::where('id', $request->get('user_id'))->value('verification');
    //validacija za formu u novioglas.blade.php
    $this->validate($request, array(
      'naslovoglasa' => 'required|max:255',
      'markaautomobila' => 'required|max:255',
      'modelmarke' => 'required|max:255',
      'cena' => 'required|integer',
      'godiste' => 'required|integer',
      'karoserija' => 'required|max:255',
      'kubikaza' => 'required|integer',
      'snagaks' => 'required|integer',
      'snagakw' => 'required|integer',
      'kilometraza' => 'required|integer',
      'gorivo' => 'required|max:255',
      'emisionaklasa' => 'required|max:255',
      'pogon' => 'required|max:255',
      'menjac' => 'required|max:255',
      'ostecen' => 'required|integer',
      'brvrata' => 'required|integer',
      'brsedista' => 'required|integer',
      'stranavolana' => 'required|max:255',
      'klima' => 'required|max:255',
      'boja' => 'required|max:255',
      'poreklo' => 'required|max:255',
    ));
    //instanciramo oglas i popunjavamo kolone
    $novioglas = new Oglasi();
    $novioglas->user_id = $request->get('user_id');
    $novioglas->naslov = $request->get('naslovoglasa');
    $novioglas->marka = $request->get('markaautomobila');
    $novioglas->model = $request->get('modelmarke');
    $novioglas->cena = $request->get('cena');
    $novioglas->godiste = $request->get('godiste');
    $novioglas->karoserija = $request->get('karoserija');
    $novioglas->kubikaza = $request->get('kubikaza');
    $novioglas->snagaks = $request->get('snagaks');
    $novioglas->snagakw = $request->get('snagakw');
    $novioglas->kilometraza = $request->get('kilometraza');
    $novioglas->gorivo = $request->get('gorivo');
    $novioglas->emisionaklasa = $request->get('emisionaklasa');
    $novioglas->pogon = $request->get('pogon');
    $novioglas->menjac = $request->get('menjac');
    $novioglas->ostecen = $request->get('ostecen');
    $novioglas->brvrata = $request->get('brvrata');
    $novioglas->brsedista = $request->get('brsedista');
    $novioglas->strvolana = $request->get('stranavolana');
    $novioglas->klima = $request->get('klima');
    $novioglas->boja = $request->get('boja');
    $novioglas->poreklo = $request->get('poreklo');
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji sigurnost u formi u novioglas.blade.php, tj pozivamo metod 
    //sigurnost() koji je gre napisan da napravi string koji se upisuje u kolonu sigurnost
    $sigurnost = $this->sigurnost($request); 
    //return $sigurnost;
    //upisujemo sadrzaj variable $sigurnost u kolonu sigurnost 'oglasis' tabele
    $novioglas->sigurnost = $sigurnost;
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji Oprema u formi u novioglas.blade.php, tj pozivamo metod 
    //oprema() koji je gore napisan da napravi string koji se upisuje u kolonu oprema
    $oprema = $this->oprema($request);
    //upisujemo sadrzaj variable $sigurnost u kolonu sigurnost 'oglasis' tabele
    $novioglas->oprema = $oprema;
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji Stanje vozila u formi u novioglas.blade.php, tj pozivamo metod 
    //stanje() koji je gore napisan da napravi string koji se upisuje u kolonu stanje
    $stanje = $this->stanje($request); 
    //upisujemo sadrzaj variable $stanje u kolonu stanje 'oglasis' tabele
    $novioglas->stanje = $stanje;
    //ako je user upisao nesto, upisujemo userov unos u textarea #tekstoglasa u kolonu tekst 'oglasis' tabele
    if($request->get('tekstoglasa')){
      $novioglas->tekst = $request->get('tekstoglasa');
    }
    //u kolonu folderslike upisujemo userov verification code tj kolonu verification 'users' tabele posto se tako zove userov folder u 
    // public/img/oglasi u kom ce se za svaki userov novioglas praviti novi folder u koji ce ici slike za taj oglas
    $novioglas->folderslike = $folderslike;
    //cuvamo novioglas
    $novioglas->save();
    $oglasid = $novioglas->id;//uzimamo id upravo sacuvanog oglasa u 'oglasis' tabelu
    //pravimo folder za slike u /public/img/oglasi/(ovde je folder koji se zove kao verification code usera)/zatim folder kom je ime id novog oglasa
    $path = public_path().'/img/oglasi/' . $folderslike . '/' . $oglasid;
    File::makeDirectory($path, $mode = 0777, true, true);
    $slike = 1; // brojac za slike
    $brojslika = 0;
    //proveravamo koju je od slika user popunio i ako je popunjena dizemo brojac $slike za 1 i to ce biti ime slike koju upisujemo u folder koji
    // pravimo u folderu usera(koji se zove kao njegov verifikacioni kod) koji je u public/img/oglasi a sam folder za slike oglasa se zove kao 
    //id upravo unetog oglasa 
    for($slike; $slike <= 12; $slike++){
      if($request->file('slika'.$slike)){
        //$slike++;
        $slikaname = $slike.'.jpg';
        $request->file('slika'.$slike)->move('img/oglasi/'.$folderslike.'/'.$oglasid.'/', $slikaname);
        //pravimo thumbnail dimenzija 180 x 120 px za svaku sliku koji se zove thumb(ime slike broj od 1-12).jpg
        $img = Image::make('img/oglasi/'.$folderslike.'/'.$oglasid.'/'.$slike.'.jpg');
        $img->resize(180, 120);
        $img->save('img/oglasi/'.$folderslike.'/'.$oglasid.'/thumb'.$slike.'.jpg');
        $brojslika++;      
      }
    }
    //ako je user dodao slike uz oglas tj $like != 0 podesavamo kolonu slike 'oglasis' tabele na 12 ili koliko je vec slika dodao 
    if($slike != 0){
      //upisujemo u kolonu slike 'oglasis' tabele koliko slika ima oglas
      $dodajslikeoglas = Oglasi::find($oglasid);//nalazimo upravo dodati oglas preko id-a
      $dodajslikeoglas->slike = $brojslika;//menjamo kolonu slike na $slike (tj broj slika koji je user uploadovao)
      $dodajslikeoglas->save(); // save-ujemo
    }    
    //pravimo u Session-u poruku
    $novioglasmessage = 'Uspešno ste dodali novi oglas. U naredna 24 sata administrator će proveriti oglas i odobriti ga.';
    Session::flash('novioglasmessage', $novioglasmessage);
    // povecava se kolona brojoglasa 'users' tabele onom useru koji dodaje oglas tj useru ciji id je stigao od forme u novioglas.blade.php
    User::find($request->get('user_id'))->increment('brojoglasa');
    //redirectujem na rutu 'profil' tj na metod profil UsersControllera i aljem mu id usera kom je dodat oglas, broj slika i id novog oglasa
    return redirect()->route('profil', ['id' => $request->get('user_id'), 'slike' => $brojslika, 'novioglasid' => $oglasid]);
  }else{
    return redirect('/');
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod za odobravanje oglasa, kad admin u profil.blade.php pored nekog neodobrenog oglasa nekog usera klikne btn Odobri Oglas, iz profil.js ide -
//AJAX preko rute '/odobrioglas' u kom je id oglasa i ovaj metod odobrava oglas tj menja kolonu odobren 'oglasis' tabele iz 0 u 1
public function odobrioglas(Request $request){
  //samo admin moze da odobri oglas pa prvo proveravamo da li je requester admin
  if($request->user()->is_admin()){
    $oglasid = $request['oglasid'];
    $oglas = Oglasi::where('id', $oglasid)->first();
    $oglas->odobren = 1;
    $oglas->save();
    return response()->json(['oglas' => $oglas]);
  }else{  //ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod za zabranu oglasa, kad admin u profil.blade.php pored nekog odobrenog oglasa nekog usera klikne btn Zabrani Oglas, iz profil.js ide -
//AJAX preko rute '/zabranioglas' u kom je id oglasa i ovaj metod zabranjuje oglas tj menja kolonu odobren 'oglasis' tabele iz 1 u 0
public function zabranioglas(Request $request){
  //samo admin moze da odobri oglas pa prvo proveravamo da li je requester admin
  if($request->user()->is_admin()){
    $oglasid = $request['oglasid'];
    $oglas = Oglasi::where('id', $oglasid)->first();
    $oglas->odobren = 0;
    $oglas->save();
    return response()->json(['oglas' => $oglas]);
  }else{  //ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod za brisanje jednog oglasa, kad admin ili autor oglasa klikne btn Obrisi Oglas pored nekog oglasa nekog korisnika u profil.blade.php iz 
//-profil.js stize AJAX preko rute '/obrisioglas' u kom je id oglasakoji se brise i zatim se kolona brojoglasa 'users' tabele korisniku ciji je 
//-oglas obrisan smanjuje za 1
public function obrisioglas(Request $request){
  $oglasid = $request['oglasid'];
  $oglas = Oglasi::where('id', $oglasid)->first();//nalazimo oglas po id koji je stigao
  $userid = $oglas->user_id;//uzimamo id kreatora oglasa(da bi ga nasli u 'users' tabeli i smanjili mu kolonu brojoglasa za 1)
  // provera da li je requester admin ili kreator oglasa, ako jeste brisemo oglas i njegove slike
  if($request->user()->is_admin() || $oglas->user_id == $request->user()->id){
    //if($oglas->slike != 0){
      //unlink(public_path('img/oglasi/' . $oglas->folderslike . '/' . $oglas->id));
      File::deleteDirectory(public_path('img/oglasi/' . $oglas->folderslike . '/' . $oglas->id));
    //}
    $delete = $oglas->delete();
    if($delete){//ako uspe brisanje oglasa smanjujemo kolonu brojoglasa 'users' tabele za 1 useru ciji je oglas obrisan
      User::find($userid)->decrement('brojoglasa');
      $broglasa = DB::table('users')->where('id', $userid)->value('brojoglasa');
    }
    return response()->json(['delete' => $delete, 'idoglasa' => $oglasid, 'brojoglasa' => $broglasa]);  
  }else{//ako requester nije admin ili autor oglasa vracamo ga na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod vraca vju izmenioglas.blade.php iz 'auto\resources\views\users' u kom je forma za edtovanje oglasa kojoj mogu da pristupe autor oglasa-
//i admin, poziva se kad se u profil.blade.php pored nekog oglasa nekog korisnika klikne btn Izmeni Oglas, stizu id oglasa i id autora oglasa
public function izmenioglasforma(Request $request, $id = null, $userid = null){
  //nalazimo oglas i usera koji ga je postavio tj ciji je oglas
  $oglas = Oglasi::where('id', $id)->first();
  $user = User::where('id', $userid)->first();
  $marke = Marka::all()->sortBy("name");//vadimo sve marke iz 'markas' tabele da bi popunili select za marku u formi
  //DB::table('markas')->where('id', $idmarke)->value('name');
  $markaid = Marka::where('name', $oglas->marka)->value('id');//uzimamo id marke automobila iz oglasa koji se menja 
  $modelimarke = Modeli::where('marka_id', $markaid)->get();//uzimamo sve modele te marke da bi popunili select za modele u formi
  //brojimo koliko slika ima oglas u njegovom folderu
  $slike = File::files(public_path('img/oglasi/' . $oglas->folderslike . '/' . $oglas->id));
  if($slike !== false){
    $brslika = count($slike) / 2;//br slika delimo sa 2 posto svaka slika ima thumbnail
  }
  //proveravamo da li postoji taj oglas i taj user i da li je user kreator oglasa ili admin
  if($oglas && $user && $userid == $oglas->user_id && ($request->user()->is_admin() || $request->user()->id == $oglas->user_id)){
    //return($id.'/'.$userid);
    return view('users.izmenioglas')->withUser($user)->withOglas($oglas)->withMarke($marke)->withModelimarke($modelimarke)->withBrslika($brslika);
  }else{//ako nije vracamo ga na '/'
    return redirect('/');
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se koristi kad user ili admin u izmenioglas.blade.php kliknu trash ikonu iznad neke od vec dodatih slika nekog oglasa, stize AJAX iz
//izmenioglas.js u kom su userverification i id oglasa (da bi se mogao naci folder u kom su slike u img/oglasi) i id slike tj njen redni br da
//bi se mogao naci sam fajl za brisanje, brise se slika i njen thumbnail
public function obrisisliku(Request $request){
  $userverification = $request['userverification'];
  $oglasid = $request['oglasid'];
  $idslike = $request['idslike'];
  $oglas =  Oglasi::where('id', $oglasid)->first();
  //proveravamo da li je requester admin ili vlasnik oglasa
  if($oglas && ($request->user()->is_admin() || $request->user()->id == $oglas->user_id)){
    //proveravamo da li slika ciji je id tj redni br stigao postoji u folderu img/oglasi/userverification/oglasid
    if(file_exists(public_path('img/oglasi/'.$userverification.'/'.$oglasid.'/'.$idslike.'.jpg'))){
      //ako postoji brisemo sliku i njen thumbnail
      File::delete(public_path('img/oglasi/'.$userverification.'/'.$oglasid.'/'.$idslike.'.jpg'));
      File::delete(public_path('img/oglasi/'.$userverification.'/'.$oglasid.'/thumb'.$idslike.'.jpg'));
      //provera da li je obrisana slika
      if(!file_exists(public_path('img/oglasi/'.$userverification.'/'.$oglasid.'/'.$idslike.'.jpg'))){
        $oglas->decrement('slike');
        $brojslika = $oglas->slike;
        return response()->json(['delete' => 1, 'idslike' => $idslike, 'brojslika' => $brojslika]); 
      }else{//ako nije obrisana
        return response()->json(['delete' => 0]);
      }
    }else{//ako iz nekog razloga slika za brisanje ne postoji
      return response()->json(['delete' => 0]);
    }
  }else{//ako user nije admin ili vlasnik oglasa
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod updateuje oglas u 'oglasis' tabeli
public function izmenioglas(Request $request){
  if($request->user()->is_admin() || $request->user()->aktivan()){
    //vadimo verifikacioni kod usera iz 'users' tabele posto se po njemu zove folder u 'auto\public\img\oglasi' u koji ovaj user koji postavlja 
    //oglas uploaduje slike
    $folderslike = User::where('id', $request->get('user_id'))->value('verification');
    //validacija za formu u izmenioglas.blade.php
    $this->validate($request, array(
      'naslovoglasa' => 'required|max:255',
      'markaautomobila' => 'required|max:255',
      'modelmarke' => 'required|max:255',
      'cena' => 'required|integer',
      'godiste' => 'required|integer',
      'karoserija' => 'required|max:255',
      'kubikaza' => 'required|integer',
      'snagaks' => 'required|integer',
      'snagakw' => 'required|integer',
      'kilometraza' => 'required|integer',
      'gorivo' => 'required|max:255',
      'emisionaklasa' => 'required|max:255',
      'pogon' => 'required|max:255',
      'menjac' => 'required|max:255',
      'ostecen' => 'required|integer',
      'brvrata' => 'required|integer',
      'brsedista' => 'required|integer',
      'stranavolana' => 'required|max:255',
      'klima' => 'required|max:255',
      'boja' => 'required|max:255',
      'poreklo' => 'required|max:255',
    ));
    //instanciramo oglas i popunjavamo kolone
    $updateoglas =  Oglasi::where('id', $request->get('oglas_id'))->first();;
    $updateoglas->user_id = $request->get('user_id');
    $updateoglas->naslov = $request->get('naslovoglasa');
    $updateoglas->marka = $request->get('markaautomobila');
    $updateoglas->model = $request->get('modelmarke');
    $updateoglas->cena = $request->get('cena');
    $updateoglas->godiste = $request->get('godiste');
    $updateoglas->karoserija = $request->get('karoserija');
    $updateoglas->kubikaza = $request->get('kubikaza');
    $updateoglas->snagaks = $request->get('snagaks');
    $updateoglas->snagakw = $request->get('snagakw');
    $updateoglas->kilometraza = $request->get('kilometraza');
    $updateoglas->gorivo = $request->get('gorivo');
    $updateoglas->emisionaklasa = $request->get('emisionaklasa');
    $updateoglas->pogon = $request->get('pogon');
    $updateoglas->menjac = $request->get('menjac');
    $updateoglas->ostecen = $request->get('ostecen');
    $updateoglas->brvrata = $request->get('brvrata');
    $updateoglas->brsedista = $request->get('brsedista');
    $updateoglas->strvolana = $request->get('stranavolana');
    $updateoglas->klima = $request->get('klima');
    $updateoglas->boja = $request->get('boja');
    $updateoglas->poreklo = $request->get('poreklo');
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji sigurnost u formi u izmenioglas.blade.php, tj pozivamo metod 
    //sigurnost() koji je gre napisan da napravi string koji se upisuje u kolonu sigurnost
    $sigurnost = $this->sigurnost($request); 
    //return $sigurnost;
    //upisujemo sadrzaj variable $sigurnost u kolonu sigurnost 'oglasis' tabele
    $updateoglas->sigurnost = $sigurnost;
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji Oprema u formi u izmenioglas.blade.php, tj pozivamo metod 
    //oprema() koji je gore napisan da napravi string koji se upisuje u kolonu oprema
    $oprema = $this->oprema($request);
    //upisujemo sadrzaj variable $sigurnost u kolonu sigurnost 'oglasis' tabele
    $updateoglas->oprema = $oprema;
    //varijabla u koju upisujemo sta je user chekirao od checkboxova u sekciji Stanje vozila u formi u izmenioglas.blade.php, tj pozivamo metod 
    //stanje() koji je gore napisan da napravi string koji se upisuje u kolonu stanje
    $stanje = $this->stanje($request); 
    //upisujemo sadrzaj variable $stanje u kolonu stanje 'oglasis' tabele
    $updateoglas->stanje = $stanje;
    //ako je user upisao nesto, upisujemo userov unos u textarea #tekstoglasa u kolonu tekst 'oglasis' tabele
    if($request->get('tekstoglasa')){
      $updateoglas->tekst = $request->get('tekstoglasa');
    }
    //u kolonu folderslike upisujemo userov verification code tj kolonu verification 'users' tabele posto se tako zove userov folder u 
    // public/img/oglasi u kom ce se za svaki userov izmenioglas praviti novi folder u koji ce ici slike za taj oglas
    $updateoglas->folderslike = $folderslike;
    //cuvamo updateoglas
    $updateoglas->save();
    $oglasid = $updateoglas->id;//uzimamo id upravo updateovanog oglasa u 'oglasis' tabelu
    //pravimo folder za slike u /public/img/oglasi/(ovde je folder koji se zove kao verification code usera)/zatim folder kom je ime id novog oglasa
    $path = public_path().'/img/oglasi/' . $folderslike . '/' . $oglasid;
    //File::makeDirectory($path, $mode = 0777, true, true);
    $slike = 1; // brojac za slike
    $brojslika = 0;
    //proveravamo koju je od slika user popunio i ako je popunjena dizemo brojac $slike za 1 i to ce biti ime slike koju upisujemo u folder
    // koji pravimo u folderu usera(koji se zove kao njegov verifikacioni kod) koji je u public/img/oglasi a sam folder za slike oglasa se 
    // zove kao id upravo unetog oglasa 
    for($slike; $slike <= 12; $slike++){
      if($request->file('slika'.$slike)){
        //$slike++;
        $slikaname = $slike.'.jpg';
        $request->file('slika'.$slike)->move('img/oglasi/'.$folderslike.'/'.$oglasid.'/', $slikaname);
        //pravimo thumbnail dimenzija 180 x 120 px za svaku sliku koji se zove thumb(ime slike broj od 1-12).jpg
        $img = Image::make('img/oglasi/'.$folderslike.'/'.$oglasid.'/'.$slike.'.jpg');
        $img->resize(180, 120);
        $img->save('img/oglasi/'.$folderslike.'/'.$oglasid.'/thumb'.$slike.'.jpg');
        // povecavamo za 1 vrednost kolone slike 'oglasis' tabele u redu izmenjenog oglasa
        $updateoglas->increment('slike');    
      }
    }
    $brojslika = $updateoglas->slike;
    //ako je user dodao slike uz oglas tj $like != 0 podesavamo kolonu slike 'oglasis' tabele na 12 ili koliko je vec slika dodao 
    // if($slike != 0){
    //   //upisujemo u kolonu slike 'oglasis' tabele koliko slika ima oglas
    //   $dodajslikeoglas = Oglasi::find($oglasid);//nalazimo upravo dodati oglas preko id-a
    //   $dodajslikeoglas->slike = $brojslika;//menjamo kolonu slike na $slike (tj broj slika koji je user uploadovao)
    //   $dodajslikeoglas->save(); // save-ujemo
    // }    
    //pravimo u Session-u poruku
    $novioglasmessage = 'Uspešno ste izmenili oglas.';
    Session::flash('novioglasmessage', $novioglasmessage);
    // povecava se kolona brojoglasa 'users' tabele onom useru koji dodaje oglas tj useru ciji id je stigao od forme u novioglas.blade.php
    //User::find($request->get('user_id'))->increment('brojoglasa');
    //redirectujem na rutu 'profil' tj na metod profil UsersControllera i aljem mu id usera kom je dodat oglas, broj slika i id novog oglasa
    return redirect()->route('profil', ['id' => $request->get('user_id'), 'slike' => $brojslika, 'novioglasid' => $oglasid]);
  }else{
    return redirect('/');
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod vadi po 10 najnovijh odobrenih i neodobrenih oglasa i salje ih u vju adminoglasi.blade.php koji ih prikazuje u 2 kolone a na vrhovima
//kolona su linkovi ka adminoglasioilin() metodu koji prikazuje samo odobrene ili neodobrene oglase preko vjua adminoglasioilin.blade.php
public function adminoglasi(Request $request){
  if($request->user()->is_admin()){ 
    //vadimo neodobrene oglase
    $neodobreni = Oglasi::where('odobren', 0)->orderBy('created_at', 'DESC')->paginate(10);
    //vadimo odobrene oglase
    $odobreni = Oglasi::where('odobren', 1)->orderBy('created_at', 'DESC')->paginate(10);
    //saljemo odobrene i neodobrene oglase u vju
    return view('admin.adminoglasi')->withOdobreni($odobreni)->withNeodobreni($neodobreni); 
  }else{
    return redirect('/');
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod vadi odobrene ili neodobrene oglase i salje ih u vju adminoglasioilin.blade.php iz 'auto\resources\views\admin' koji prikazuje -
//odobrene ili neodobrene oglase, posto vju ima i formu za pretragu oglasa saljemo mu i sve marke iz 'markas' tabele
public function adminoglasioilin(Request $request, $oilin = null){
  if($request->user()->is_admin()){ 
    //ako user nije sortirao oglase u vjuu adminoglasioilin.blade.php po difoltu se sortira po koloni 'created_at' silazno
    $sort = 'created_at';
    $ascdesc = 'DESC';
    //ako je user sortirao tj kroz request stignu parametri $sort i $ascdesc onda sortiramo po onoj koloni koju admin hoce
    if($request->get('sort') && $request->get('ascdesc')){
      $sort = $request->get('sort');
      $ascdesc = $request->get('ascdesc');
    }
    // vadimo odobrene ili neodobrene oglase
    $oglasi = Oglasi::where('odobren', $oilin)->orderBy($sort, $ascdesc)->paginate(6);
    // ukupan broj oglasa bez paginacije
    $oglasaukupno = Oglasi::where('odobren', $oilin)->count();
    // vadimo sve marke posto postoji forma za pretragu pa da bi select za odabir marke bio popunjen
    $marke = Marka::all()->sortBy("name");
    // varijabla se koristi da vju adminoglasioilin.blade.php zna iz kog je metoda pozvan i tako prikaze paginaciju(posto ga poziva i 
    //metod adminoglasipretraga())
    $method = 1;
    // pozivamo vju i saljemo mu potrebne varijable
    return view('admin.adminoglasioilin')->withOilin($oilin)
                                         ->withMethod($method)
                                         ->withOglasi($oglasi)
                                         ->withOglasaukupno($oglasaukupno)
                                         ->withMarke($marke)
                                         ->withSort($sort)
                                         ->withAscdesc($ascdesc);
  }else{
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se u adminoglasioilin.blade.php sabmituje forma za pretaragu zabranjenih ili nezabranjenih vozila
public function adminoglasipretraga(Request $request){
  if($request->user()->is_admin()){ 
    //ako admin nije sortirao oglase u vjuu adminoglasioilin.blade.php po difoltu se sortira po koloni 'created_at' silazno
    $sort = 'created_at';
    $ascdesc = 'DESC';
    //ako je admin sortirao tj kroz request stignu parametri $sort i $ascdesc onda sortiramo po onoj koloni koju admin hoce
    if($request->get('sort') && $request->get('ascdesc')){
      $sort = $request->get('sort');
      $ascdesc = $request->get('ascdesc');
    }
    //varijabla proverava da li se traze odobreni(1) ili neodobreni(0) oglasi, to je hidden input u formi. On je podesen kad metod  
    //adminoglasioilin() pozove vju adminoglasioilin.blade.php
    $oilin = $request->get('oilin');
    //userov odabir u selectu za marku vozila
    $markaautomobila = $request->get('markaautomobila');
    //userov odabir u selectu za model marke vozila
    $modelpretraga = $request->get('modelmarke');
    //
    $modeli = '';
    //ako je admin pretrazio po marki automobila, vadimo sve modele te marke da bi imao u selectu za model sve modele pa ako zeli moze da 
    //ide detaljnije u pretragu
    if($markaautomobila){
      $idmarke = Marka::where('name', $markaautomobila)->value('id');
      $modeli = Modeli::where('marka_id', $idmarke)->get();
    }
    //ako je admin pretrazio po gorivu
    $gorivo = $request->get('gorivo');
    //adminov izbor u selectima za godinu od i godinu do
    $godisteod = $request->get('godisteod');
    $godistedo = $request->get('godistedo');
    //u zavisnosti da li je admin odabrao samo godinu od ili godinu do ili obe variabla $pretragagodista moze biti 1, 2 ili 3 i u zavisnosti 
    //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli godiste >= $godisteod, ako je 2 onda godiste <= $godistedo
    //ako je 3 onda se trazi WHERE godiste BETWEEN godisteod, $godistedo
    $pretragagodista = NULL;
    if($godisteod != '' && $godistedo == ''){
      $pretragagodista = 1;
    }elseif($godisteod == '' && $godistedo != ''){
      $pretragagodista = 2;
    }elseif($godisteod != '' && $godistedo != ''){
      $pretragagodista = 3;
    }
    //ako je admin u selectu za poreklo odabrao nesto
    $poreklo = $request->get('poreklo');
    //adminov izbor u selectima za godinu od i godinu do
    $kubikazaod = $request->get('kubikazaod');
    $kubikazado = $request->get('kubikazado');
    //u zavisnosti da li je admin odabrao samo kubikaza od ili kubikaza do ili obe variabla $pretragakubikaza moze biti 1, 2 ili 3 i u zavisnosti 
    //od toga ce query biti dopunjen , ako je 1 onda se trazi u 'oglasis' tabeli kubikaza >= $kubikazaod, ako je 2 onda kubikaza <= $kubikazado
    //ako je 3 onda se trazi WHERE kubikaza BETWEEN kubikazaod, $kubikazado
    $pretragakubikaza = NULL;
    if($kubikazaod != '' && $kubikazado == ''){
      $pretragakubikaza = 1;
    }elseif($kubikazaod == '' && $kubikazado != ''){
      $pretragakubikaza = 2;
    }elseif($kubikazaod != '' && $kubikazado != ''){
      $pretragakubikaza = 3;
    }
    //pravimo query u zavisnosti od toga sta je admin popunio u formi za pretragu odobrenih ili neodobrenih oglasa
    $oglasi = Oglasi::where('odobren', $oilin)
                    // ako je popunio polje marka u formi u adminoglasioilin.blade.php
                    ->when($request->markaautomobila, function($query) use ($request){
                      return $query->where('marka', $request->markaautomobila);
                    }) 
                    //ako je popunio polje model marke u formi u adminoglasioilin.blade.php
                    ->when($request->modelmarke, function($query) use ($request){
                      return $query->where('model', $request->modelmarke);
                    })
                    //ako je popunio polje gorivo u formi u adminoglasioilin.blade.php
                    ->when($request->gorivo, function($query) use ($request){
                      return $query->where('gorivo', $request->gorivo);
                    })
                    // ako je popunio godina od ili godina do ili oba
                    ->when($pretragagodista, function($query) use ($pretragagodista, $godisteod, $godistedo){
                      if($pretragagodista == 1){
                        return $query->where('godiste', '>=', $godisteod);
                      }elseif($pretragagodista == 2){
                        return $query->where('godiste', '<=', $godistedo);
                      }elseif($pretragagodista == 3){
                        return $query->whereBetween('godiste', [$godisteod, $godistedo]);
                      }         
                    })
                    //ako je popunio polje poreklo u formi u adminoglasioilin.blade.php
                    ->when($request->poreklo, function($query) use ($request){
                      return $query->where('poreklo', $request->poreklo);
                    })
                    // ako je popunio godina od ili godina do ili oba
                    ->when($pretragakubikaza, function($query) use ($pretragakubikaza, $kubikazaod, $kubikazado){
                      if($pretragakubikaza == 1){
                        return $query->where('kubikaza', '>=', $kubikazaod);
                      }elseif($pretragakubikaza == 2){
                        return $query->where('kubikaza', '<=', $kubikazado);
                      }elseif($pretragakubikaza == 3){
                        return $query->whereBetween('kubikaza', [$kubikazaod, $kubikazado]);
                      }         
                    })
                    ->orderBy($sort, $ascdesc)
                    ->paginate(6);
    //dd($oglasi);
    //isti query kao gore samo bez paginacije da bi vju znao koliko ukupno oglasa ima koji su pronadjeni bez paginacije
    $oglasaukupno = $oglasi->total();
    //vadimo sve narke koje su potrebne da bi se napravio select za Marku u formi za pretragu oglasa
    $marke = Marka::all()->sortBy("name");
    // varijabla se koristi da vju adminoglasioilin.blade.php zna iz kog je metoda pozvan i tako prikaze paginaciju(posto ga poziva i 
    //metod adminoglasioilin())
    $method = 2;
    //pozivamo vju adminoglasioilin.blade.php i saljemo mu sve potrebne podatke
    return view('admin.adminoglasioilin')
            ->withMethod($method)
            ->withOilin($oilin)
            ->withOglasi($oglasi)
            ->withOglasaukupno($oglasaukupno)
            ->withMarke($marke)
            ->withMarkaautomobila($markaautomobila)
            ->withModeli($modeli)
            ->withGorivo($gorivo)
            ->withModelpretraga($modelpretraga)
            ->withGodisteod($godisteod)
            ->withGodistedo($godistedo)
            ->withPoreklo($poreklo)
            ->withKubikazaod($kubikazaod)
            ->withKubikazado($kubikazado)
            ->withSort($sort)
            ->withAscdesc($ascdesc);
  }else{//ako requester nije admin
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------


}

