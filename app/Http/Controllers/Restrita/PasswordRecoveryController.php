<?php

declare(strict_types=1);

namespace App\Http\Controllers\Restrita;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Services\SiteService;
use App\Orchid\Mail\PasswordRecoveryEmail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRecoveryController extends Controller
{
    public function sendRecovery(SiteService $site)
    {
        if (request()->method() === 'POST') {

            $username_or_email = request()->input('username_or_email');

            $user = User::where('email', $username_or_email)
                ->orWhere('username', $username_or_email)
                ->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'username_or_email' => __('The details you entered did not match our records. Please double-check and try again.'),
                ]);
            }

            if (!$user->email) {
                throw ValidationException::withMessages([
                    'username_or_email' => __('O usuário inserido não possui e-mail. Por favor, entre em contato com o responsável pelo sistema.'),
                ]);
            }

            try {
                $site->configEmail();

                $site_name = config('app.name');
                $email_recovery = new PasswordRecoveryEmail($user);
                $email_recovery->subject("Recuperação de senha área restrita - $site_name");

                Mail::to($user->email)->send($email_recovery);

                session()->flash('send-recover-status-success', "Um email de recuperação foi enviado para {$user->email}.");
                return redirect(route('platform.password.send-recovery'));
            }
            catch (Exception $e) {
                if (env('APP_DEBUG')) {
                    throw $e;
                }

                throw ValidationException::withMessages([
                    'username_or_email' => __('Falha ao enviar e-mail de recuperação. Por favor, entre em contato com o responsável pelo sistema.'),
                ]);
            }
        }

        return view('platform::password-recovery.send-recovery');
    }

    public function recoverPassword(int $id)
    {
        if (request()->method() === 'POST') {
            if (!request()->hasValidSignature()) {
                throw ValidationException::withMessages([
                    'password' => __('Erro: esse link expirou ou é inválido. Por favor, tente gerar um novo link. Se o problema persistir, entre em contato com o responsável pelo sistema.'),
                ]);
                // abort(401);
            }

            $password = request()->input('password');
            $password_confirm = request()->input('password_confirm');

            if (!$password) {
                throw ValidationException::withMessages([
                    'password' => __('Digite sua nova senha.'),
                ]);
            }
            if ($password != $password_confirm) {
                throw ValidationException::withMessages([
                    'password_confirm' => __('Confirme sua nova senha corretamente.'),
                ]);
            }

            $user = User::where('id', $id)
                ->first();
            
            if (!$user) {
                throw ValidationException::withMessages([
                    'password' => __('Usuário não encontrado.'),
                ]);
            }

            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            session()->flash('recover-status-success', "Senha resetada com sucesso.");
            return redirect(route('platform.login'));
        }

        return view('platform::password-recovery.recover-password');
    }
}
