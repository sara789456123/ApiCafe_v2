<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Auth extends Model
{
    use HasFactory;

    protected $table = 'utilisateur';
    protected $primaryKey = 'login';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $hidden = ['mdp'];

    public function setMdpAttribute($value)
    {
        // Hash the password using Bcrypt
        $this->attributes['mdp'] = Hash::make($value);
    }

    public function validatePassword($password)
    {
        // Verify the provided password against the hashed password
        return Hash::check($password, $this->mdp);
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(16));
    }
}
