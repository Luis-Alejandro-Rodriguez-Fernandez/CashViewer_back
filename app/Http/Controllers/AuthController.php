<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        try{
            DB::beginTransaction();
            $messages = $this->authMethods()->validateRegistroFrom($request);

            if (!empty($messages)) {
                return [
                    'error' => $messages
                ];
            }

            $user = User::query()->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            Cuenta::query()->create([
                'user_id' => $user->id,
                'familia_id' => null,
                'cuenta_id' => null,
                'nombre' => 'Cuenta Principal',
                'descripcion' => 'Esta es la cuenta principal sobre la que se realizarán los moviminetos que se añadan al sistema',
                'saldo' => 0,
                'activo' => 1
            ]);

            DB::commit();

            return [
                'token' => null,
                'user' => $user
            ];
        }catch (\Exception $e) {
            DB::rollBack();

            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function login(Request $request)
    {
        $messages = $this->authMethods()->validateLoginForm($request);

        if (!empty($messages)) {
            return [
                'error' => $messages
            ];
        }

        $user = Auth::user();

        return [
            'token' => $user->createToken('token')->plainTextToken,
            'user' => $user
        ];
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->currentAccessToken()->delete();
        }

        return [
            'user' => null
        ];
    }
}
