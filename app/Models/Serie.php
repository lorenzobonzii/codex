<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Serie extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "titolo",
        "regia",
        "anno",
        "lingua",
        "copertina_o",
        "copertina_v",
        "anteprima",
        "trama",
        "attori",
        "nation_id",
        "created_at",
        "updated_at",
    ];
    protected $appends = ['url_copertina_v', 'url_copertina_o', 'url_copertina_o_min'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    public function nation()
    {
        return $this->belongsTo(Nation::class);
    }
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function getUrlCopertinaVAttribute()
    {
        return $this->copertina_v ? (preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_v) ? "https://codex.lorenzobonzi.it" . $this->copertina_v : "https://image.tmdb.org/t/p/original" . $this->copertina_v) : "https://codex.lorenzobonzi.it/assets/img/copertina_v_default.png";
    }
    public function getUrlCopertinaOAttribute()
    {
        return $this->copertina_o ? (preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_o) ? "https://codex.lorenzobonzi.it" . $this->copertina_o : "https://image.tmdb.org/t/p/original" . $this->copertina_o) : "https://codex.lorenzobonzi.it/assets/img/copertina_o_default.png";
    }
    public function getUrlCopertinaOMinAttribute()
    {
        return $this->copertina_o ? (preg_match('/^\/storage\/[a-zA-Z0-9.\/_]+$/', $this->copertina_o) ? "https://codex.lorenzobonzi.it" . $this->copertina_o : "https://image.tmdb.org/t/p/w500" . $this->copertina_o) : "https://codex.lorenzobonzi.it/assets/img/copertina_o_default.png";
    }

    public function setCopertinaVFromBase64($base64)
    {
        if (preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $base64, $matchings)) {
            $imageData = base64_decode($matchings['image']);
            $extension = $matchings['extension'];
            $filename = "img/series/copertine_v/" . $this->id . '.' . $extension;

            if (Storage::disk('public')->put($filename, $imageData)) {
                $this->copertina_v = Storage::url($filename);
                $this->save();
            }
        }
    }
    public function setCopertinaOFromBase64($base64)
    {
        if (preg_match("/^data:image\/(?<extension>(?:png|gif|jpg|jpeg));base64,(?<image>.+)$/", $base64, $matchings)) {
            $imageData = base64_decode($matchings['image']);
            $extension = $matchings['extension'];
            $filename = "img/series/copertine_o/" . $this->id . '.' . $extension;

            if (Storage::disk('public')->put($filename, $imageData)) {
                $this->copertina_o = Storage::url($filename);
                $this->save();
            }
        }
    }
}
