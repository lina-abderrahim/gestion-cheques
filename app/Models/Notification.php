<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=['message','type','cheque_id','is_read'];

    public function cheque()
    {
        $this->belongsTo(cheque::class);
    }
}
