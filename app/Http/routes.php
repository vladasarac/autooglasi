<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
//
Route::get('/', 'FrontController@index');

Route::auth();

Route::get('/home', 'HomeController@index');
//ruta ide na index() metod AdminControllera koji prikazuje vju adminpanel.blade.php iz 'auto\resources\views\admin' koji je glavni admin vju
Route::get('/adminpanel', 'AdminController@index');
//ruta ide na index() metod MarkaControllera koji prikazuje vju dodajmarku.blade.php iz 'auto\resources\views\admin' koji sluzi da admin doda
//nove marke automobila u 'markas' tabelu
Route::get('/dodajmarke', 'MarkaController@index');
//ruta gadja store() metod MarkaControllera kad se u dodajmarke.blade.php sabmituje forma za dodavanje nove marke auta u 'markas' tabelu
Route::post('/sotremarka', 'MarkaController@store');
//ruta gadja storemodel() metod MarkaControllera kad se sabmituje forma za dodavanje novog modela neke marke u dodajmarke.blade.php
Route::post('/storemodel', 'MarkaController@storemodel');
//ruta se poziva kad user kline na div .prikazimodelemarke koji je ispod forme za dodavanje modela u dodajmarku.blade.php, div je vidljiv samo -
//-ako user u selectu u formi za dodavanje modela odabere neku marku, hendler iz dodajmarke.js salje AJAX u prikazimodele() MarkaControllera
Route::post('/prikazimodele', [
  'uses' => 'MarkaController@prikazimodele',
  'as' => 'prikazimodele'
]);
//kad se sabmituje forma za editovanje nekog modela, koja je vidljiva u dodajmarku.blade.php kad se edituje neki model, ide AJAX iz dodajmarke.js
// na metod izmenimodeel() MarkaControllera
Route::post('/izmenimodel', [
  'uses' => 'MarkaController@izmenimodel',
  'as' => 'izmenimodel'
]);
//kad se pored nekog modela u dodajmarke.blade.php klikne ikona za brisanje modela hendler iz dodajmarke.js preko ove rute salje AJAX deletemodel()
//metodu MarkaControllera koji brise taj model
Route::post('/deletemodel', [
  'uses' => 'MarkaController@deletemodel',
  'as' => 'deletemodel'
]);
//ruta se koristi kad se sabmituje forma za edit neke marke u dodajmarke.blade.php, ide na metod izmenimarku() MarkaControllera
Route::post('/izmenimarku', [
  'uses' => 'MarkaController@izmenimarku',
  'as' => 'izmenimarku'
]);
//ruta se koristi kad se sabmituje forma za brisanje neke marke u dodajmarke.blade.php, ide na metod obrisimarku() MarkaControllera
Route::post('/obrisimarku', [
  'uses' => 'MarkaController@obrisimarku',
  'as' => 'obrisimarku'
]);

//ruta ide na metod korisnici() UsersControllera a poziva se kad u adminpanel.blade.php admin klikne na ikonu za usere, metod vraca za sada po 5 -
//- korisnika
Route::get('/korisnici/{sort?}', 'UsersController@korisnici');

//ruta za verifikaciju tj aktivaciju naloga, koristi je registracija.blade.php to je vju koji se salje kao mail novo registrovanom useru i kad
//klikne link koji gadja ovu rutu salje ga na aktivacija() metod UsersControllera koji menja klonu aktivan 'users' tabele iz NULL u 1
Route::get('aktivacija/{verication}', 'UsersController@aktivacija');
//ruta se koristi kad admin u users.blade.php aktivira korisnika klikom na link Aktiviraj, iz users.js se preko rute salje AJAX u metod
//-manuelnaaktivacija() UsersControllera 
Route::post('/manuelnaaktivacija', 'UsersController@manuelnaaktivacija');
//ruta se koristi kad admin u users.blade.php deaktivira korisnika klikom na link Deaktiviraj, iz users.js se preko rute salje AJAX u metod
//-manuelnadeaktivacija() UsersControllera 
Route::post('/manuelnadeaktivacija', 'UsersController@manuelnadeaktivacija');
//ruta ide na profil() metod UsersControllera, ima opcioni parametar id posto je moze koristiti i admin kad u users.blade.php klikne btn link -
//-'Idi Na Profil' i onda stize id po kom metod vadi usera a ako je koristi user koji nije admin onda to znaci da je kliknuo link u navigaciji i -
//ako ja parametar id == null tj nije stigao u kontroller metod vadi trenutno ulogovanog usera  
// Route::get('/profil/{id?}', [
//   'uses' => 'UsersController@profil',
//   'as' => 'profil'
// ]);
Route::get('/profil/{id?}/{slike?}/{novioglasid?}', 'UsersController@profil')->name('profil');
//ruta gadja editusera() metod UsersControllera kad se sabmituje forma za dodavanje tj menjanje podataka usera u profil.blade.php
Route::post('/editusera', 'UsersController@editusera');
//kad se u formi za dodavanje ili izmenu podataka korisnika u profil.blade.php (ako user ima dodat logo) klikne btn Obrisi Logo, hendler u 
//-profil.js salje ajax obrisilogo() metodu UsersControllera koristeci ovu rutu
Route::post('/obrisilogo', [
  'uses' => 'UsersController@obrisilogo',
  'as' => 'obrisilogo'
]);
//kad se u formi za dodavanje ili izmenu podataka korisnika u profil.blade.php (ako user ima dodatu mapu) klikne btn Obrisi Mapu, hendler u 
//-profil.js salje ajax obrisimapu() metodu UsersControllera koristeci ovu rutu
Route::post('/obrisimapu', [
  'uses' => 'UsersController@obrisimapu',
  'as' => 'obrisimapu'
]);
//ruta ide na metod novioglas() OglasControllera koji ako je stigao id u requestu (to znaci da je admin pozvao metod i da ce admin za nekog usera
//postaviti oglas) vadi iz 'users' tabele usera po tom id-u a ako nije stigao id u requestu onda je user = $request->user(); i dalje metod tog
//usera salje u vju novioglas.blade.php u kom je forma za pravljenje novog oglasa 
Route::get('/novioglas/{id?}', 'OglasController@novioglas')->name('novioglas');
//ruta se koristi kad se u novioglas.blade.php sabmituje forma za novi oglas, gadja metod upisinovioglas() OglasControllera
Route::post('/upisinovioglas', 'OglasController@upisinovioglas')->name('upisinovioglas');
//ruta se koristi kad u novioglas.blade.php u selectu za odabir marke automobila odaberemo marku, onda preko ove rute ide iz novioglas.js
//AJAX ka metodu izvadimodele() OglasControllera koji vadi sve modele marke koju smo odabrali
Route::post('/izvadimodele', 'OglasController@izvadimodele')->name('izvadimodele');
//ruta ide na metod odobrioglas() OglasControllera koji odobrava oglas tj menja oglasu kolonu odobren iz 0 u 1, ide AJAX iz profil.js
Route::post('/odobrioglas', 'OglasController@odobrioglas')->name('odobrioglas');
//ruta ide na metod zabranioglas() OglasControllera koji zabranjuje oglas tj menja oglasu kolonu odobren iz 1 u 0, ide AJAX iz profil.js
Route::post('/zabranioglas', 'OglasController@zabranioglas')->name('zabranioglas');
//kad se klikne btn Obrisi Oglas u profil.blade.php pored nekog oglasa nekog usera preko ove rute ide AJAX u metod obrisioglas() OglasControlera
Route::post('/obrisioglas', 'OglasController@obrisioglas')->name('obrisioglas');
//kad se klikne btn Izmeni Oglas pored nekog od prikazanih oglasa nekog korisnika u profil.blade.php, gadja izmenioglasforma() OglasControlera
Route::get('izmenioglasforma/{id}/{userid}', 'OglasController@izmenioglasforma')->name('izmenioglasforma');
//ruta se koristi kad se u profil.blade.php klikne link za brisanje profila, koji je vidljiv adminu i vlasniku profila, ide na metod -
// - obrisikorisnika() UsersControllera koji brise korisnika, njegove oglase i logo korisnika i slike oglasa
Route::get('obrisikorisnika/{id?}', 'UsersController@obrisikorisnika')->name('obrisikorisnika');
//ruta gadja metod obrisisliku() OglasControllera kad se u izmenioglas.blade.php iznad neke od vec dodadih slika oglasa klikne trash ikonica,
// iz izmenioglas.js stize AJAX
Route::post('/obrisisliku', 'OglasController@obrisisliku')->name('obrisisliku');
//ruta se poziva kad se sabmituje forma za izmenu oglasa iz izmenioglas.blade.php i gadja izmenioglas() OglasControllera
Route::post('/izmenioglas', 'OglasController@izmenioglas')->name('izmenioglas');
//ruta gadja adminoglasi() OglasControllera koji adminu vraca vju adminoglasi.blade.php sa po 10 najnovijih odobrenih i neodobrenih oglasa
Route::get('/adminoglasi', 'OglasController@adminoglasi');
//kad se u adminoglasi.blade.php klikne link ka odobrenim ili neodobrenim oglasima ova ruta gadja metod adminoglasioilin() OglasControllera koji 
//vadi 6 (koristi paginate(6)) odobrenih ili neodobrenih oglasa i salje ih u vju adminoglasioilin.blade.php, takodje se koristi kad se klikcu linkovi za paginaciju ako je vju vracen iz metoda adminoglasioilin()
Route::get('/adminoglasioilin/{oilin?}', 'OglasController@adminoglasioilin')->name('adminoglasioilin');
//kad se u adminoglasioilin.blade.php sabmituje forma za pretragu odobrenih ili neodobrenih oglasa preko ove rute se gadja metod adminoglasipretraga() OglasControllera, takodje se koristi kad se klikcu linkovi za paginaciju ako je vju vracen iz metoda adminoglasipretraga()
Route::get('/adminoglasipretraga', 'OglasController@adminoglasipretraga')->name('adminoglasipretraga');
//ruta gadja metod josoglasa() FrontControllera koji vadi jos oglasa(osim prvih 6) za welcome.blade.php, ide AJAX iz welcome.js
Route::post('/josoglasa', 'FrontController@josoglasa')->name('josoglasa');
//ruta gadja metod izvadimodele() FrontControllera koji vadi sve modele neke marke, poziva ga hendler iz welcome.js kad se u formi za pretragu u 
//welcome.blade.php izabere neka marka
Route::post('/izvadimodelefront', 'FrontController@izvadimodele')->name('izvadimodelefront');
//ruta gadja metod pretraga() FrontControllera kad se sabmituje frontend pretraga oglasa u welcome.blade.php ili rezpretrage.blade.php 
Route::get('/frontpretraga', 'FrontController@pretraga')->name('frontpretraga');
//
Route::get('/oglas/{oglasid?}', 'FrontController@prikazioglas')->name('oglas');

