<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Opa extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'organization_name',
        'campus_name',
        'phone_number',
        'password',
        'photo',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
