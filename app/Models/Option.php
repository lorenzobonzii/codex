<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use function PHPSTORM_META\elementType;

class Option extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "chiave",
        "valore",
        "created_at",
        "updated_at"
    ];

    public static function get($key){
        $option = Option::where('chiave',$key)->first();
        if ($option)
            return $option->valore;
        else
            return null;
    }
}
