<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traite;

class Cheque extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'montant',
        'type',
        'date_echeance',
        'statut',
        'banque',
        'tiers',
        'commentaire',
        'user_id',
        'traite_id'
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

}
