<?php

namespace App\Http\Controllers;

use App\Gambiarras\OracleConexaoPorUsuario;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        list($sucesso, $conexao) = OracleConexaoPorUsuario::conectar();

        $data = $conexao->select('SELECT * FROM TESTE');

        dd($data);

        return view('home');
    }
}
