<?php


namespace App\Helpers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class authClass
{

    public $messages = [
        'name_required' => 'El nombre es un campo obligatorio',
        'email_required' => 'El correo es un campo obligatorio',
        'password_required' => 'La contraseña es un campo obligatorio',
        'password_confirmation_required' => 'Debe confirmar la contraseña',
        'email_format_error' => 'El correo electónico debe ser válido',
        'password_format_error' => 'La contraseña debe tener al menos 8 caracteres, y debe incluir minusculas, mayusculas y números',
        'password_match' => 'Las contraseñas no coinciden',
        'email_exists' => 'El correo electrónico introducido ya está en uso',
        'credentials_validation_failed' => 'El correo o la contraseña son incorrectos'
    ];

    public function validateRegistroFrom(Request $request)
    {
        $messages = [];

        if (!isset($request->name)) {
            $messages[] = $this->messages['name_required'];
        }

        if (!isset($request->email)) {
            $messages[] = $this->messages['email_required'];
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $messages[] = $this->messages['email_format_error'];
        }

        if (!isset($request->password)) {
            $messages[] = $this->messages['password_required'];
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[a-zA-Z\d]).{8,}$/', $request->password)) {
            $messages[] = $this->messages['password_format_error'];
        }

        if (!isset($request->password_confirmation)) {
            $messages[] = $this->messages['password_confirmation_required'];
        }

        if ($request->password !== $request->password_confirmation) {
            $messages[] = $this->messages['password_match'];
        }

        if (DB::table('users')->where('email','like', $request->email)->get()->count() > 0) {
            $messages[] = $this->messages['email_exists'];
        }

        return $messages;
    }


    public function validateLoginForm(Request $request) {
        $messages = [];

        if (!isset($request->email)) {
            $messages[] = $this->messages['email_required'];
        }

        if (!isset($request->password)) {
            $messages[] = $this->messages['password_required'];
        }

        if(!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $messages[] = $this->messages['credentials_validation_failed'];
        }

        return $messages;
    }
}
