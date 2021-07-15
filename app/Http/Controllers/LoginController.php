<?php

namespace App\Http\Controllers;

use App\Gambiarras\OracleConexaoPorUsuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $u = $request->input('username');
        $s = $request->input('password');

        list($sucesso, $conexao) = OracleConexaoPorUsuario::conectar($u, $s);

        if ($sucesso) {
            return redirect('/home');
        }
        dd('erro', $conexao);
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        dd($request);
    }
}
