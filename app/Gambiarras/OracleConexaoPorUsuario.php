<?php

namespace App\Gambiarras;

use Exception;
//use Illuminate\Support\Facades\Config;
//use Illuminate\Support\Facades\DB;
//use PDO;

class OracleConexaoPorUsuario
{
    public static function conectar(string $usuario = '', string $senha = ''): bool
    {
        if (trim($usuario) === '') {
            $usuario = session('username');
        }

        if (trim($senha) === '') {
            $senha = session('password');
        }

        try {
            /*Config::set("database.connections.oracle", [
                "driver" => "oracle",
                "database" => env('DB_DATABASE', ''),
                "hostname" => env('DB_HOST', ''),
                "username" => $usuario,
                "password" => $senha,
                "options" => [
                    PDO::ATTR_PERSISTENT => true,
                ],
            ]);

            $conexao = DB::connection('oracle');*/

            session([
                'username' => $usuario,
                'password' => $senha,
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }

        return false;
    }
}
