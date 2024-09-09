<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;
    protected $with = [
        'addressType',
        'municipality',
        'nation'
    ];
    protected $fillable = [
        "person_id",
        "address_type_id",
        "indirizzo",
        "civico",
        "municipality_id",
        "CAP",
        "nation_id",
        "created_at",
        "updated_at"
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }
}
