<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;
    protected $with = [
        'contactType'
    ];
    protected $fillable = [
        "person_id",
        "contact_type_id",
        "contatto",
        "created_at",
        "updated_at"
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }
}
