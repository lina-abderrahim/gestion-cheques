<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;
    protected $fillable = ['cle', 'valeur', 'description'];
public static function getValeur($cle)
{
    return self::where('cle', $cle)->value('valeur');
}

public static function setValeur($cle, $valeur)
{
    return self::updateOrCreate(['cle' => $cle], ['valeur' => $valeur]);
}

}
