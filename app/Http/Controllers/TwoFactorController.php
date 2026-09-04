<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use App\Models\User;


class TwoFactorController extends Controller
{
    public function setup()
    {
        /** necesario para que el IDE reconozca el tipo de $user  */
        /** @var User $user */
        $user = Auth::user();

        if ($user->totp_enabled) {
            return response()->json([
                'message' => '2FA ya está configurado'
            ], 400);
        }
        $google2fa = new Google2FA();

        if (!$user->totp_secret) {
        $secret = $google2fa->generateSecretKey();
       
        // Guardar el secreto en el usuario
        $user->totp_secret = $secret;
        $user->save();}else{
            $secret = $user->totp_secret;
        }

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'qr_code_url' => $qrCodeUrl
        ]);
    }

public function verifySetup(Request $request)
{
    /** necesario para que el IDE reconozca el tipo de $user */
    /** @var User $user */
    $user = Auth::user();

    $google2fa = new Google2FA();

    $validated = $request->validate([
        'totp_code' => 'required|string'
    ]);

    $isValid = $google2fa->verifyKey(
        $user->totp_secret,
        $validated['totp_code']
    );

    if ($isValid) {
         $user->totp_enabled = true;
        $user->save();
        $request->session()->put('2fa_verified', true);
        

        return response()->json([
            'message' => '2FA configurado correctamente'
        ]);
    }

    return response()->json([
        'message' => 'Código 2FA inválido'
    ], 400);
}

   public function verify(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    $google2fa = new Google2FA();

    $validated = $request->validate([
        'totp_code' => 'required|string'
    ]);

    $isValid = $google2fa->verifyKey(
        $user->totp_secret,
        $validated['totp_code']
    );

    if ($isValid) {
        $request->session()->put('2fa_verified', true);

        return response()->json([
            'message' => 'Código 2FA válido',
        ]);
    }

    return response()->json([
        'message' => 'Código 2FA inválido'
    ], 400);
}
}
