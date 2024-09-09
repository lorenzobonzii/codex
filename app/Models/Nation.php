<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nation extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "nome",
        "continente",
        "iso",
        "iso3",
        "prefisso_telefonico",
    ];

    public function films(){
        return $this->hasMany(Film::class);
    }
    public function series(){
        return $this->hasMany(Serie::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }

}
