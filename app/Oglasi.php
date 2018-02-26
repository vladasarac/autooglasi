<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oglasi extends Model
{
  //
  protected $fillable = ['user_id', 'naslov', 'marka', 'model', 'cena', 'godiste', 'karoserija', 'kubikaza', 'snagaks', 'snagakw', 'kilometraza', 'gorivo', 'emisionaklasa', 'pogon', 'menjac', 'ostecen', 'brvrata', 'brsedista', 'strvolana', 'klima', 'boja', 'poreklo', 'sigurnost', 'oprema', 'stanje', 'tekst', 'slike', 'brpregleda', 'odobren'];
  
  //one to many relacija sa User.php modelom tj tabelom 'users'
  public function user(){
    return $this->belongsTo('App\User', 'user_id');	
  }

}
