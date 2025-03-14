<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Pays;

class Continent extends Model{

    protected $table = 'continent';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    public $incrementing = true; 
    public function pays(): HasMany
    {
    return $this->hasMany(Pays::class, "id_continent", "id");
    }

}
?>