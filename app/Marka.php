<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marka extends Model
{

  protected $fillable = ['name', 'logo'];
  
  //one-to-many relacija sa 'modelis' tabelom, posto marka ima vise modela
  public function modelis(){
    return $this->hasMany('App\Modeli', 'marka_id');  
  } 
}
