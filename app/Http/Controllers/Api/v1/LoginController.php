<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\AppHelpers;
use App\Models\LoginAttempt;
use App\Models\Option;
use App\Models\Password;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Verifies the credentials of the User.
     */
    public function login(Request $request)
    {
        $user = $request->input('username');
        $hash = $request->input('hashedPassword');
        if ($hash == null) {
            return LoginController::controlloUtente($user);
        } else {
            return LoginController::controlloPassword($user, $hash);
        }
    }

    /**
     * Verifies the username of the User.
     * @unauthenticated
     */
    public function controlloUtente($user)
    {
        $sale = hash("sha512", trim(Str::random(200)));
        $username = User::getUsernameFromHash($user);
        if ($username && User::esisteUtenteAttivo($username)) {
            $user = User::where('user', $username)->first();
            $user->secret_jwt = hash("sha512", trim(Str::random(200)));
            $user->scadenza_sfida = time() + Option::get('durata_sfida');
            $user->save();
            $password = Password::passwordAttuale($user->id);
            $password->sale = $sale;
            $password->save();
            $dati = array("sale" => $sale);
        } else {
            $dati = abort(404, "USER NOT FOUND");
        }
        return AppHelpers::rispostaCustom($dati);
    }
    /**
     * Verifies the username and password of the User.
     * @unauthenticated
     */
    public function controlloPassword($user, $hash)
    {
        if (User::esisteUtente($user)) {
            $user = User::where('user', $user)->first();
            $secret_jwt = $user->secret_jwt;
            $scadenza_sfida = $user->scadenza_sfida;
            $numero_tentativo = LoginAttempt::contaTentativi($user->id) + 1;
            $max_tentativi = Option::get('max_tentativi');
            if (time() < $scadenza_sfida) {
                if ($numero_tentativo < $max_tentativi) {
                    $recordPassword = Password::passwordAttuale($user->id);
                    $password = $recordPassword->password;
                    $sale = $recordPassword->sale;
                    $password_nascosta = AppHelpers::nascondiPassword($password, $sale);
                    if ($hash == $password_nascosta) {
                        $tk = AppHelpers::creaTokenSessione($user->id, $secret_jwt);
                        Session::eliminaSessione($user->id);
                        Session::aggiornaSessione($user->id, $tk);
                        LoginAttempt::aggiungiTentativoSuccesso($user->id);
                        $dati = array("token_jwt" => $tk, "user_id" => $user->id);
                        return AppHelpers::rispostaCustom($dati);
                    } else {
                        LoginAttempt::aggiungiTentativoFallito($user->id);
                        abort(403, "INVALID CREDENTIALS");
                    }
                } else {
                    abort(403, "MAX ATTEMPTS REACHED");
                }
            } else {
                LoginAttempt::aggiungiTentativoFallito($user->id);
                abort(403, "TOKEN EXPIRED");
            }
        } else {
            abort(404, "USER NOT FOUND");
        }
    }

    /**
     * Verifies the validity of the Token.
     */
    public static function verificaToken($token)
    {
        $rit = null;
        $sessione = Session::datiSessione($token);
        if ($sessione != null) {
            $inizio_sessione = $sessione->inizio_sessione;
            $durata_sessione = Option::get('durata_sessione');
            $scadenza_sessione = $inizio_sessione + $durata_sessione;
            if (time() < $scadenza_sessione) {
                $user = User::where('id', $sessione->user_id)->first();
                if ($user != null) {
                    $secret_jwt = $user->secret_jwt;
                    $payload = AppHelpers::validaToken($token, $secret_jwt, $sessione);
                    if ($payload != null) {
                        $rit = $payload;
                    } else {
                        abort(403, 'INVALID PAYLOAD TOKEN');
                    }
                } else {
                    abort(403, 'INVALID USER TOKEN');
                }
            } else {
                abort(401, 'SESSION EXPIRED');
            }
        } else {
            abort(401, 'INVALID SESSION');
        }
        return $rit;
    }

    /**
     * Verifies the validity of the Token.
     */
    public function verifyToken(Request $request)
    {
        if (!empty(trim($_SERVER["HTTP_AUTHORIZATION"]))) {
            if (preg_match('/Bearer\s(\S+)/', trim($_SERVER["HTTP_AUTHORIZATION"]), $matches)) {
                $token = $matches[1];
                $result = $this->verificaToken($token);
                return $result;
            }
        }
        return null;
    }
}
