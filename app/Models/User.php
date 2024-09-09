<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory, SoftDeletes, Filterable, Sortable;
    public $timestamps = true;

    protected $fillable = [
        "role_id",
        "state_id",
        "person_id",
        "user",
        "secret_jwt",
        "scadenza_sfida",
        "created_at",
        "updated_at"
    ];

    protected $hidden = [
        "secret_jwt"
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
    public function loginAttempts(): HasMany
    {
        return $this->hasMany(LoginAttempt::class);
    }
    public function passwords(): HasMany
    {
        return $this->hasMany(Password::class);
    }

    public static function getUsernameFromHash($username_hashed)
    {
        $user = User::where(DB::raw('SHA2(user, 512)'), $username_hashed)->first();
        if ($user)
            return $user->user;
        else
            return null;

        $users = User::all();
        foreach ($users as $user)
            if (hash("SHA512", $user->user) == $username_hashed)
                return $user->user;
        return null;
    }

    public static function esisteUtente($user)
    {
        $temp = DB::table('users')->where('user', '=', $user)->select('id')->get()->count();
        return ($temp > 0) ? true : false;
    }

    public static function esisteUtenteAttivo($user)
    {
        $temp = DB::table('users')->join('people', 'users.person_id', '=', 'people.id')->where('user', '=', $user)->select('users.id')->get()->count();
        return ($temp > 0) ? true : false;
    }
}
