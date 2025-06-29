<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traite extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cheque_id',
        'date_impression',
        'fichier_pdf',
    ];

    public function cheque()
    {
        return $this->belongsTo(Cheque::class);
    }
}
