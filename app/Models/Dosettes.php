<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosettes extends Model
{  
    use HasFactory;
  
    public $timestamps = false;
     
    protected $table = 'dosette';

    protected $fillable = [
        'nom',
        'intensite',
        'prix',
        'id_marque',
        'id_pays',
    ];
  

    public function marque()
    {
        return $this->belongsTo(Marque::class, 'id_marque');
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'id_pays');
    }
}
