<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pays extends Model
{
    protected $table = 'pays';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    public function continent(): BelongsTo
    {
        return $this->belongsTo(Continent::class, "id_continent", "id");
    }

    public function dosettes(): HasMany
    {
        return $this->hasMany(Dosette::class, "id_pays", "id");
    }

    public static function existePays($pays)
    {
        return self::where("nom", $pays)->exists();
    }
}
