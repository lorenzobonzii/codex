<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Password extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $hidden = [
        "password"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function passwordAttuale($user_id){
        return Password::where('user_id',$user_id)->orderBy('id',"DESC")->firstOrFail();
    }

    public static function passwordNonStorica($user_id){

    }
}
