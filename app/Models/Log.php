<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id', 'action', 'cible', 'details'];

public static function enregistrer($userId, $action, $cible, $details = [])
{
    self::create([
        'user_id' => $userId,
        'action' => $action,
        'cible' => $cible,
        'details' => json_encode($details),
    ]);
}
public function user()
{
    return $this->belongsTo(User::class);
}


}
