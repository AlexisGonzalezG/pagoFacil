<?php

namespace App\Http\Controllers\pagoFacil;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class pagoFacil_controller extends Controller
{
    public function index(Request $request){
        return view("pagoFacil.index");
    }
                                                                                                    
    public function transaccion(Request $request){

        $data["method"] = "transaccion";
        $data["data"] = [
                "nombre" => $request["nombre"],
                "apellidos" => $request["apellidos"],
                "numeroTarjeta" => $request["numeroTarjeta"],
                "cvt" => $request["cvt"],
                "cp" => "48219",
                "mesExpiracion" => $request["mesExpiracion"],
                "anyoExpiracion" => $request["anyoExpiracion"],
                "monto" => $request["monto"],
                "idSucursal" => $request["idSucursal"],
                "idUsuario" => $request["idUsuario"],
                "idServicio" => "3",
                "email" => "alexiscohen21@gmail.com",
                "telefono" => "55555555",
                "celular" => "5548989876",
                "calleyNumero" => "Valle del Don",
                "colonia" => "Del Valle",
                "municipio" => "Tecamac",
                "estado" => "Sonora",
                "pais" => "México"
          ];


        $response = Http::asForm()->post('https://sandbox.pagofacil.tech/Wsrtransaccion/index/format/json?',$data);

        $id =  DB::table('transaccion')->insertGetId([
                'method' => 'transaccion',
                'nombre' => $request["nombre"],
                'apellidos' => $request["apellidos"],
                'numeroTarjeta' => $request["numeroTarjeta"],
                'cvt' => $request["cvt"],
                'cp' => '55555',
                'mesExpiracion' => $request["mesExpiracion"],
                'anyoExpiracion' => $request["anyoExpiracion"],
                'monto' => $request["monto"],
                'idSucursal' => $request["idSucursal"],
                'idUsuario' => $request["idUsuario"],
                'idServicio' => '3',
                'email' => 'alexiscohen21@gmail.com',
                'telefono' => '22222222',
                'celular' => '5548989876',
                'calleyNumero' => 'calleyNumero',
                'colonia' => 'colonia',
                'municipio' => 'municipio',
                'estado' => 'estado',
                'pais' => 'pais',
                'json' => $response

            ]);

            $insert = DB::table('response_transaccion')->insert([
                'id_transaccion' => $id,
                'autorizado' => $response['WebServices_Transacciones']['transaccion']['autorizado'],
                'transaccion' => $response['WebServices_Transacciones']['transaccion']['transaccion'],
                'nombre' => $request["nombre"],
                'apellidos' => $request["apellidos"],
                'numeroTarjeta' => $request["numeroTarjeta"],
                'TipoTC' => $response['WebServices_Transacciones']['transaccion']['TipoTC'],
                'monto' => $request["monto"]
            ]);
        
 
        return ['ok' => 100];
    }

    public function get_transaccions(Request $request){

        if($request["TipoTC"] == 1)
          $TipoTC = "Visa";

        if($request["TipoTC"] == 2)
          $TipoTC = "Master Card";

        if($request["TipoTC"] == 3)
          $TipoTC = "American Express";

          if($request["TipoTC"] == 0){
                $data = DB::table('response_transaccion')
                        ->orderby('id','ASC')
                        ->get();
            }
            else{
                $data = DB::table('response_transaccion')
                    ->orderby('id','ASC')
                    ->where('TipoTC',$TipoTC)
                    ->get();
            }

            if(count($data)>0){
                return ['ok' => 100,
                'data' => json_encode($data)];
            }
            else{
                return ['ok' => 0];
            }

    }

    public function delete_transaccion(Request $request){

        $select = DB::table('response_transaccion')
                    ->where('id',$request["id"])
                    ->get();

        $data = DB::table('response_transaccion')
                    ->where('id',$request["id"])
                    ->delete();
                    

                DB::table('transaccion')
                    ->where('id',$select[0]->id_transaccion)
                    ->delete();

        return ['ok' => 100];

    }

    public function transaccion_id(Request $request,$id){
        
        $select = DB::table('response_transaccion')
                    ->where('id',$id)
                    ->get();

            $data = DB::table('transaccion')
                    ->where('id',$select[0]->id_transaccion)
                    ->get();

            return ['ok' => 100,
                'data' => json_encode($data)];

    }   
}
