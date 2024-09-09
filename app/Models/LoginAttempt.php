<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoginAttempt extends Model
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "ip",
        "authenticated",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function contaTentativi($user_id)
    {
        return LoginAttempt::where('user_id', $user_id)->where('authenticated', NULL)->get()->count();
    }

    public static function aggiungiTentativoSuccesso($user_id)
    {
        LoginAttempt::where('user_id', $user_id)->delete();
        return LoginAttempt::aggiungiTentativo($user_id, 1);
    }

    public static function aggiungiTentativoFallito($user_id, $authenticated = NULL)
    {
        LoginAttempt::where('user_id', $user_id)->where('authenticated', true)->delete();
        return LoginAttempt::aggiungiTentativo($user_id, null);
    }


    protected static function aggiungiTentativo($user_id, $authenticated = NULL)
    {
        return LoginAttempt::create([
            'user_id' => $user_id,
            'authenticated' => $authenticated,
            'ip' => request()->ip()
        ]);
    }
}
