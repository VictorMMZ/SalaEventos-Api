<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{
    public function login(Request $request)
    {
      $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if (!Auth::attempt($validated)) {

        return response()->json([
            'message' => 'Las credenciales no son válidas'
        ], 401);

    }

   $request->session()->regenerate();
    $user = Auth::user();

       if (!$user->totp_enabled) {
            return response()->json([
                'message' => 'Es necesario configurar el 2FA',
                'requires_2fa_setup' => true
            ]);
        }

        return response()->json([
            'message' => 'Es necesario introducir el código 2FA',
            'requires_2fa' => true
        ]);
    }

       
    

      public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

       return response()->json([
        'message' => 'Sesión cerrada correctamente'
    ]);
    }
}




