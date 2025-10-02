<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    // coin_id có thể là bitcoin, ethereum, ...
    protected $fillable = ['user_id','coin_id','coin_symbol','coin_name','coin_image'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
