<?php

namespace App\Http\Controllers;

use App\Gambiarras\OracleConexaoPorUsuario;
use Exception;
use Illuminate\Support\Facades\DB;

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
        try {
            $data = DB::select('SELECT * FROM TESTE');
            echo 'tabela criada no usuário porto';
        } catch (Exception $e) {
            echo 'não funcionou<br/>' . $e->getMessage();
            die;
        }

        die;

        return view('home');
    }
}
