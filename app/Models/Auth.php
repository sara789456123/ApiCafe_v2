<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Auth extends Model
{
    use HasFactory;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $hidden = ['mdp'];
    public $timestamps = false;

    protected $fillable = [
        'login',
        'mdp',
        'token',
        'admin',
        'ville',
        'rue',
        'cp',
        'pays',
    ];

    public function setMdpAttribute($value)
    {
        $this->attributes['mdp'] = Hash::make($value);
    }

    public function commandes()
    {
        return $this->hasMany(\App\Models\Commande::class, 'id_utilisateur', 'id');
    }

    public function validatePassword($password)
    {
        return Hash::check($password, $this->mdp);
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes(8));
        $this->token = $token;
        $this->save();
        return $token;
    }
}
