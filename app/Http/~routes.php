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

Route::get('/', function () {
    return view('welcome');
});

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
//ruta ide na metod korisnici() UsersControllera a poziva se kad u adminpanel.blade.php admin klikne na ikonu za usere, metod vraca za sada po 5 -
//- korisnika
Route::get('/korisnici', 'UsersController@korisnici');


//ruta za verifikaciju tj aktivaciju naloga, koristi je registracija.blade.php to je vju koji se salje kao mail novo registrovanom useru i kad
//klikne link koji gadja ovu rutu salje ga na aktivacija() metod UsersControllera koji menja klonu aktivan 'users' tabele iz NULL u 1
Route::get('aktivacija/{verication}', 'UsersController@aktivacija');
//ruta ide na profil() metod UsersControllera, ima opcioni parametar id posto je moze koristiti i admin kad u users.blade.php klikne btn link -
//-'Idi Na Profil' i onda stize id po kom metod vadi usera a ako je koristi user koji nije admin onda to znaci da je kliknuo link u navigaciji i -
//ako ja parametar id == null tj nije stigao u kontroller metod vadi trenutno ulogovanog usera  
Route::get('/profil/{id?}', [
  'uses' => 'UsersController@profil',
  'as' => 'profil'
]);
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

