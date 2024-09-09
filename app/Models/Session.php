<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Session extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "token",
        "inizio_sessione",
        "created_at",
        "updated_at",
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function esisteSessione($tk){
        return DB::table('sessions')->where('token', $tk)->exists();
    }
    public static function datiSessione($tk){
        if(Session::esisteSessione($tk)){
            return Session::where('token', $tk)->get()->first();
        } else {
            return null;
        }
    }
    public static function aggiornaSessione($user_id, $tk){
        $where = ["user_id" => $user_id, "token" => $tk];
        $arr = ["inizio_sessione" => time()];
        DB::table('sessions')->updateOrInsert($where, $arr);
    }
    public static function eliminaSessione($user_id){
        DB::table('sessions')->where("user_id", $user_id)->delete();
    }
}
