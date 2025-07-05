<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traite;

class Cheque extends Model
{
    use HasFactory;


    protected $casts = [
        'date_echeance' => 'date',
    ];
    
    protected $fillable = [
        'numero',
        'montant',
        'type',
        'date_echeance',
        'statut',
        'banque',
        'tiers',
        'commentaire',
        'user_id'
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function traite()
{
    return $this->hasOne(Traite::class);
}

    public function notifications()
{
    return $this->hasMany(Notification::class);
}


}
