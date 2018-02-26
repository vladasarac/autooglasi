<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Session;
use App\Marka;
use App\User;

class AdminController extends Controller{

//samo autorizovani tj ulogovani useri imaju pristup metodima ovog kotrolera
public function __construct(){
  $this->middleware('auth');
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//metod proverava da li je user koji je posla request admin i ako jeste salje ga na adminpanel vju (koji je glavni admin vju sa kog se ide na
//druge vjuove za administraciju sajta)
public function index(Request $request){
  if($request->user()->is_admin()){	//koristeci is_admin() metod User.php modela proveravamo da li je user admin
    return view('admin.adminpanel');// ako jeste saljemo ga na vju adminpanel.blade.php
  }else{ //ako nije admin saljemo ga na '/'
  	return redirect('/');
  }	 	
}

//----------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------------------------------------------------

//


}
