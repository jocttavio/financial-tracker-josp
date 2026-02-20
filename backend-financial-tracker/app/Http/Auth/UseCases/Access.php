<?php

namespace App\Http\Auth\UseCases;


// use App\Models\Persona;
use App\Exceptions\CustomError;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
//se encarga de cachar los errores usando try catch ademas de 
//realizar las operaciones que se necesiten hacer ya sea
//guardar archivos y manipular los datos

class Access{

    public static function create($data)
    {
        try {
            DB::beginTransaction();
            $cuenta = new User();
            $cuenta->name = $data->name;
            $cuenta->password  = Hash::make($data->password);
            $cuenta->email = $data->email;
            $cuenta->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomError(
                "Ocurrio un error al registrar el acceso",
                404,
                $e
            );
        }
    }
}