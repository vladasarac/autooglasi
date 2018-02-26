<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Http\RedirectResponse;
use Redirect;
use App\User;
use App\Oglasi;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Filesystem\Filesystem;

class UsersController extends Controller
{


public function __construct(){
  $this->middleware('auth');
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod za sada vraca po 5 korisnika u users.blade.php iz 'auto\resources\views\admin', taj vju je vidljiv samo adminu
public function korisnici(Request $request, $sort = null){
  if($request->user()->is_admin()){ 
    //po difoltu su varijable za sortiranje podesene da sortira po imenu uzlazno ako admin u users.blade.php ne odluci drugacije
    $sort = 'name';
    $ascdesc = 'ASC';
    //ako je radjena pretraga po imenu korsnika u users.blade.php tj ako u URL-u postoji parametar imekorisnika, onda cemo dodati u query
    //WHERE name LIKE %imekorisnika%, hendler za klik na .pretrazispanime btn tj span koji tom slucaju poziva ovaj metod je u users.js 
    if($request->get('imekorisnika')){
      $imekorisnika = $request->get('imekorisnika');
      //ako je radjeno sortiranje onda postoji u URL-u sort pa bazdarimo varijable za kolonu po kojoj se sortira i za asc ili desc order
      //ako user nije sortrao onda po difoltu sortiramo po imenu uzlazno
      if($request->get('sort')){
        $sort = $request->get('sort');
        $ascdesc = $request->get('ascdesc');
      }
      //vadimo iz 'users' korisnike kojima je role kolona 'author' a name kolona LIKE userov unos u polj za pretragu po imenu u users.blade.php
      $users = User::where('role', 'author')->where('name', 'LIKE', '%'.$imekorisnika.'%')->orderBy($sort, $ascdesc)->paginate(4);
      //vadimo ukupan broj usera koji zadovoljavaju WHERE parametre bez paginacije
      $userstotal = User::where('role', 'author')->where('name', 'LIKE', '%'.$imekorisnika.'%')->orderBy($sort, $ascdesc)->count();
      //u users.blade.php osim $users vracamo i varjable za sortiranje i imekorisnika tj userov unos u input za pretragu po imenu da bi pag-
      //inacija mogla da napravi linkove kako treba tj da im nakaci parametre i $userstotal
      return view('admin.users')->withUsers($users)
                                ->withSort($sort)
                                ->withAscdesc($ascdesc)
                                ->withImekorisnika($imekorisnika)
                                ->withUserstotal($userstotal);
    }
    //ako je radjena pretraga po id-u u users.blade.php korsnika tj ako u URL-u postoji parametar idkorisnika, onda cemo dodati u query
    //WHERE id = idkorisnika, hendler za klik na .pretrazispanid btn tj span koji tom slucaju poziva ovaj metod je u users.js 
    if($request->get('idkorisnika')){
      $idkorisnika = $request->get('idkorisnika');
      //ako je radjeno sortiranje onda postoji u URL-u sort pa bazdarimo varijable za kolonu po kojoj se sortira i za asc ili desc order
      //ako user nije sortrao onda po difoltu sortiramo po imenu uzlazno
      if($request->get('sort')){
        $sort = $request->get('sort');
        $ascdesc = $request->get('ascdesc');     
      }
      //vadimo iz 'users' korisnike kojima je role kolona 'author' a id kolona = userov unos u polj za pretragu po id-u u users.blade.php
      $users = User::where('role', 'author')->where('id', $idkorisnika)->orderBy($sort, $ascdesc)->paginate(4);
      //vadimo ukupan broj usera koji zadovoljavaju WHERE parametre bez paginacije
      $userstotal = User::where('role', 'author')->where('id', $idkorisnika)->orderBy($sort, $ascdesc)->count();
      //u users.blade.php osim $users vracamo i varjable za sortiranje i idkorisnika tj userov unos u input za pretragu po id-u da bi pag-
      //inacija mogla da napravi linkove kako treba tj da im nakaci parametre i $userstotal
      return view('admin.users')->withUsers($users)
                                ->withSort($sort)
                                ->withAscdesc($ascdesc)
                                ->withIdkorisnika($idkorisnika)
                                ->withUserstotal($userstotal);
    }
    //ako je radjeno samo sortiranje a ne i pretraga po imenu ili id-u onda postoji u URL-u sort pa bazdarimo varijable za kolonu po kojoj se
    //-sortira i za asc ili desc order ako user nije sortrao onda po difoltu sortiramo po imenu uzlazno
    if($request->get('sort')){
      $sort = $request->get('sort');
      $ascdesc = $request->get('ascdesc');
    }
    //ako nije radjena pretraga vadimo sve usere kojima je rola author
    $users = User::where('role', 'author')->orderBy($sort, $ascdesc)->paginate(4);
    //vadimo ukupan broj usera bez paginacije
    $userstotal = User::where('role', 'author')->orderBy($sort, $ascdesc)->count();
    //u users.blade.php vracamo osim $users i varijable za sortiranje da bi paginacija mogla da se pravilno napravi i $userstotal
    return view('admin.users')->withUsers($users)
                              ->withSort($sort)
                              ->withAscdesc($ascdesc)
                              ->withUserstotal($userstotal);
  }else{
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod poziva ruta 'aktivacija/{verication}' kada user koji se registrovao primi aktivacioni email link u njemu ide na ovaj metod koji kolonu
//aktivan 'users' tabele menja u 1
public function aktivacija(Request $request, $verification_code){
  //nalazimo usera po koloni 'verification' a to je stiglo kroz link kao argument	
  $user = User::where('verification', $verification_code)->first();
  $user->aktivan = 1;// menjamo kolonu aktivan u 1
  $user->save(); // cuvamo promenu
  $successactivation = 'Uspesno ste aktivirali vas nalog.';//pravimo succes message
  Session::flash('successactivation', $successactivation);
  return redirect()->route('profil')->withUser($user);//saljemo usera na vju profile.blade.php iz 'auto\resources\views\users'
  //return view('/users/profile')->withUser($user);//saljemo usera na vju profile.blade.php iz 'auto\resources\views\users'
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//Metod se koristi da admin klikom na link Aktiviraj u users.blade.php aktivira nekog usera, stize AJAX iz users.js preko rute
// '/manuelnaaktivacija' i u njemu userid usera kog aktiviramo
public function manuelnaaktivacija(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user koji poziva metod admin
    $userid = $request['userid'];//nalazimo usera kog zelimo da aktiviramo pomocu userid-a koji je stigao AJAX-om
    $user =  User::where('id', $userid)->first();
    $user->aktivan = 1;//menjamo kolonu aktivan iz 0 u 1
    $user->save();//cuvamo
    //vracamo AJAX-u json u kom je objekat sa svim podatcima aktiviranog usera
    return response()->json(['user' => $user]);
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//Metod se koristi da admin klikom na link Deaktiviraj u users.blade.php deaktivira nekog usera, stize AJAX iz users.js preko rute
// '/manuelnadeaktivacija' i u njemu userid usera kog deaktiviramo
public function manuelnadeaktivacija(Request $request){
  if($request->user()->is_admin()){//koristeci is_admin() metod User.php modela proveravamo da li je user koji poziva metod admin
    $userid = $request['userid'];//nalazimo usera kog zelimo da deaktiviramo pomocu userid-a koji je stigao AJAX-om
    $user =  User::where('id', $userid)->first();
    $user->aktivan = 0;//menjamo kolonu aktivan iz 1 u 0
    $user->save();//cuvamo
    //vracamo AJAX-u json u kom je objekat sa svim podatcima deaktiviranog usera
    return response()->json(['user' => $user]);
  }else{//ako nije admin saljemo ga na '/'
    return redirect('/');
  }
}
//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod prikazuje vju profil.blade.php iz 'auto\resources\views\users', moze biti pozvan bez argumenta ili sa argumentom tj id-em usera, bez 
//argumenta se poziva kad sam korisnik klikne u navigaciji link 'Profil' i onda metod vadi trenutno ulogovanog usera i salje podatke u 
//profil.blade.php a ako stigne argument to znaci da je admin u users.blade.php pored nekog usera kliknuo btn 'Profil' i onda stize id usera,
//takodje postoje opcioni parametri $slike i $novioglasid oni su tu da bi ako se metod poziva iz metoda upisinovioglas() OglasControllera 
//poslao u vju profil.blade.php i broj slika koje je user dodao novom oglasu i da bi preko id-a novog oglasa on bio izvadjen iz 'oglasis' 
//tabele i bio prikazan na vrhu vjua, takodje se metod poziva i iz izmenioglas() OglasControllera kad user izmeni neki oglas, ista procedura
//kao za novioglas
public function profil(Request $request, $id = null, $slike = null, $novioglasid = null){
  $slike = $slike;
  //ako je metod pozvan iz upisinovioglas() OglasControllera onda ova variabla nije == NULL i vadimo novi oglas po id -u koji je stigao
  if($novioglasid){
    $novioglas = Oglasi::where('id', $novioglasid)->first();
  }else{
    $novioglas = null;
  }
  //ako postoji $id tj nije null i ako je user admin
  if($request->user()->is_admin()){
    if($request->user()->is_admin()){//proveravamo da li je requester admin
      $userId = $id;//vadimo usera iz 'users' tabele (po id koloni, uzimamo id ulogovanog usera)
      $user = User::where('id', $userId)->first();
      //posto profil.blade.php prikazuje i do sada unete oglase korisnika ovde ih vadimo iz 'oglasis' tabele(ovo je moglo i u vjuu da se uradi
      // koristeci $user->oglasis ali je orderovao od najstarijih ka novijim a ja sam hteo obrnuto)
      $oglasi = Oglasi::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
      //idemo na vju profile.blade.php i saljemo usera, sve njegove oglase i ako je metod zvan iz upisinoviogla() OglasControllera i $slike i $novio-
      //-oglas ako nije to u pitanju ove dve varijable ce biti null
      return view('/users/profile')->withUser($user)->withOglasi($oglasi)->withSlike($slike)->withNovioglas($novioglas);
    }else{
      return redirect('/');//ako nije admin salji ga na '/'
    }
  }else{
    if($request->user()->aktivan()){//user mora biti aktivan tj ako metod aktivan() User.php modela vrati true
      $userId = Auth::id();//vadimo usera iz 'users' tabele (po id koloni, uzimamo id ulogovanog usera)
      $user = User::where('id', $userId)->first();
      //posto profil.blade.php prikazuje i do sada unete oglase korisnika ovde ih vadimo iz 'oglasis' tabele(ovo je moglo i u vjuu da se uradi
      // koristeci $user->oglasis ali je orderovao od najstarijih ka novijim a ja sam hteo obrnuto)
      $oglasi = Oglasi::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
      //idemo na vju profile.blade.php i saljemo usera, sve njegove oglase i ako je metod zvan iz upisinoviogla() OglasControllera i $slike i $novio-
      //-oglas ako nije to u pitanju ove dve varijable ce biti null
      return view('/users/profile')->withUser($user)->withOglasi($oglasi)->withSlike($slike)->withNovioglas($novioglas);
    }else{ // ako nije aktivan redirect na '/'
      return redirect('/');
    }
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad se sabmituje forma za dopunu i izmenu userovih podataka u profil.blade.php
public function editusera(Request $request){
  //dd($request);
  //nalazimo usera u 'users' tabeli po id-u koji je stigao iz forme(ima hidden input sa id korisnika)
  $user = User::find($request['userid']);
  //ako nadje nesto i ako je user aktivan ili ako je admin moze se ici dalje u editovanje
  if($user && ($request->user()->aktivan() || $request->user()->is_admin())){
    //prvo validacija polja u formi
    $this->validate($request, array(
      'imekorisnika' => 'required|max:255',
      'grad' => 'required',
      'telefonkorisnika' => 'required|digits_between:9,20', //
      'adresakorisnika' => 'max:255',
      'telefon2' => 'digits_between:9,20',
      'telefon3' => 'digits_between:9,20'
    ));
    //ako je user uploadovao sliku tj logo
    if($request->file('inputimages')){
      //ako user menja sliku znaci da u folderu 'auto\public\img\users' postoji folder kom je ime id usera, ako prvi put uploaduje logo taj fol-
      //der ne postoji
      $path = public_path('/img/users/').$user->id;
      //ako ne postoji folder sa imenom userovog id-a pravimo ga
      if(!File::exists($path)){
        File::makeDirectory($path);
      }else{// ako postoji folder sa imenom userovog id-a znaci da vec u njemu ima slika tj logo i brisemo je
        File::cleanDirectory($path);
      } 
      //uzimamo sliku koja je uploadovana
      $image = $request->file('inputimages');
      $fileName = '1.jpg'; //zvace se 1.jpg(ali posto je ime foldera jedinstveno bice opusteno...)
      $image_resize = Image::make($image->getRealPath());//koristeci Intervention\Image libratry resize-ujemo sliku
      $image_resize->resize(100, 100);
      $image_resize->save(public_path('img/users/'.$user->id.'/'.$fileName));//cuvamo sliku tj logo u folderu 'auto\public\img\user\.user->id'
      $user->logo = 1;//u kolonu logo 'users' tabele upisujemo 1(po difoltu je 0) sto znaci da user ima logo 
    }
    //podesavamo ime korisnika tj name kolonu 'users' tabele unosom u polje imekorisnika
    $user->name = $request['imekorisnika'];
    $user->grad = $request['grad'];//podesavamo grad korisnika tj grad kolonu 'users' tabele unosom u polje grad
    $user->telefon = $request['telefonkorisnika'];
    //ako je user rekao 'da' u select-u za prikaziemail tj stiglo je 1 iz forme, koloni prikazi email dajemo vrednost 1
    if($request['prikaziemail'] != 0){
      $user->prikaziemail = 1;
    }else{//ako je rekao ne onda joj dajemo verednost 0
      $user->prikaziemail = 0;
    }
    //ako je user rekao 'da' u select-u za pravnolice tj stiglo je 1 iz forme, koloni pravnolice dajemo vrednost 1
    if($request['pravnolice'] != 0){
      $user->pravnolice = 1;
    }else{//ako je rekao ne onda joj dajemo verednost 0
      $user->pravnolice = 0;
    }
    //ako je user uneo nesto u polje adresakorisnika tu vrednost upisujemo u adresa kolonu 'users' tabele
    if($request['adresakorisnika'] != ''){
      $user->adresa = $request['adresakorisnika'];
    }else{//ako je stiglo prazno polje u kolonu adresa upisujemo null
      $user->adresa = null;
    }
    //ako je user uneo broj u polje telefon2 tu vrednost upisujemo u telefon2 kolonu 'users' tabele
    if($request['telefon2'] != ''){
      $user->telefon2 = $request['telefon2'];
    }else{//ako je stiglo prazno polje u kolonu adresa upisujemo null
      $user->telefon2 = null;
    }
    //ako je user uneo broj u polje telefon3 tu vrednost upisujemo u telefon3 kolonu 'users' tabele
    if($request['telefon3'] != ''){
      $user->telefon3 = $request['telefon3'];
    }else{//ako je stiglo prazno polje u kolonu adresa upisujemo null
      $user->telefon3 = null;
    }
    //ako je user kliknuo na svoju lokaciju na google map onda su polja lat, lng i zoom popunjena tako da ovde istoimene kolone podesavamo na
    //vrednosti tj koordinate koje su stigle iz forme 
    if($request['lat'] != '' && $request['lng'] != '' && $request['zoom'] != ''){
      $user->lat = $request['lat'];
      $user->lng = $request['lng'];
      $user->zoom = $request['zoom'];
    }
    //cuvamo promene
    $user->save();
    //podesavamo success poruku
    $success = 'Uspešno ste dopunili podatke vaseg profila.';
    Session::flash('success', $success);
    return redirect()->back();//redirectujemo nazad na profil.blade.php
  }else{ // 
    return redirect('/');
  }
  
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se koristi ako user ima dodat logo ali zeli da ga obrise, ako ima logo u formi u profil.blade.php pored slike logo-a ima btn ObrisiLogo
//(.obrisilogo) koji kad se klikne poziva hendler iz profil.js koji salje AJAX u ovaj metod i u njemu id usera kom treba obrisati logo 
public function obrisilogo(Request $request){
  //nalazimo usera u 'users' tabeli po id-u koji je stigao AJAX-om
  $user = User::find($request['userid']);
  $user->logo = 0;//menjamo logo kolonu 'users' tabele u 0
  $user->save();//cuvamo promenu u bazi
  //putanja ka folderu u 'auto\public\img\users' u kom je bio logo usera koji brise logo
  $path = public_path('/img/users/').$user->id;
  File::cleanDirectory($path);//brisemo sliku iz foldera
  return response()->json(1);//vracamo hendleru u profil.js 1
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se koristi ako user ima dodatu mapu ali zeli da je obrise, ako ima mapu u formi u profil.blade.php iznad mape ima btn Obrisi Mapu
//(.obrisimapu) koji kad se klikne poziva hendler iz profil.js koji salje AJAX u ovaj metod i u njemu id usera kom treba obrisati mapu 
public function obrisimapu(Request $request){
  //nalazimo usera u 'users' tabeli po id-u koji je stigao AJAX-om
  $user = User::find($request['userid']);
  $user->lat = null;//menjamo lat, lng i zoom kolone na null
  $user->lng = null;
  $user->zoom = null;
  $user->save();//cuvamo promenu u bazi
  return response()->json(1);//vracamo hendleru u profil.js 1
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------

//metod se poziva kad u profil.blade.php admin ili vlasnik profila klikne btn Obrisi Profil, metod dobija id i onda nalazi usera u 'users' tabeli
//brise ga, njegove oglase(posto je users_id kolona 'oglasis' tabele foreign key od id kolone 'users' tabele pa radi on delete cascade), logo
//usera ako ga ima i folder u koji se smestaju slike za oglase
public function obrisikorisnika(Request $request, $id = null){
  $userid = $id;//uzimamo id koji je stigao u URL-u
  $user = User::find($userid);//nalazimo usera
  $username = $user->name;//ime nam treba za Session::flash
  $path = public_path('/img/users/').$user->id; //putanja ka folderu sa logom usera
  $pathslikeoglasi = public_path('/img/oglasi/').$user->verification; // putanja ka folderu za slike oglasa usera
  //proveravamo da li je user admin ili vlasnik profia koji se brise
  if($request->user()->is_admin() || $user->id == $request->user()->id){
    if($user->id == $id){
      User::destroy($userid);
    }else{
      $user->delete();
    }
    //ako postoji folder sa userovim logom tj ako je user nekad dodao logo brisemo taj folder
    if(File::isDirectory($path)){
      File::deleteDirectory($path);
    }
    //brisemo folder sa slikama za oglase
    File::deleteDirectory($pathslikeoglasi);
    //ako je requester admin saljemo ga na rutu '/korisnici'
    if($request->user()->is_admin()){
      $successbrisanjeusera = 'Uspešno ste obrisali profil korisnika '.$username.'.';
      Session::flash('successbrisanjeusera', $successbrisanjeusera);
      return redirect('/korisnici');
    //ako je user brisao svoj profil saljemo ga na '/'  
    }else{
      return redirect('/');
    }
  }else{//ako requester nije admin ili vlasnik profila vracamo ga na '/'
    return redirect('/');
  }
}

//--------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------





}
