<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marque extends Model
{
    protected $table = 'marque';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    public function dosettes(): HasMany
    {
        return $this->hasMany(Dosette::class, "id_marque", "id");
    }

    public static function existeMarque($marque)
    {
        return self::where("nom", $marque)->exists();
    }
}
