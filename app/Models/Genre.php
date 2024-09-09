<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "id",
        "nome",
        "created_at",
        "updated_at",
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
    public function series()
    {
        return $this->belongsToMany(Serie::class);
    }
}
