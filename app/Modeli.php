<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modeli extends Model
{  

   //
   protected $fillable = ['marka_id', 'ime'];
   //one-to-many relacija sa 'markas' tabelom posto model pripada samo jednoj marki
   public function marka(){
      return $this->belongsTo('App\Marka', 'marka_id');	
    }
}
