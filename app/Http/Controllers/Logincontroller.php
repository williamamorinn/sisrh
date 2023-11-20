<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function auth(Request $request)
    {
        // dd($request);
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ],
        [
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'O e-mail informado não é valido',
            'password.required' => 'O campo senha é obrigatório'
        ]);

        if(Auth::attempt($credenciais)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->back()->with('erro_login', 'E-mail ou senha inválido');
        }
    }
    // Função para deslogar o usuário logado
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.index');
    }
}
