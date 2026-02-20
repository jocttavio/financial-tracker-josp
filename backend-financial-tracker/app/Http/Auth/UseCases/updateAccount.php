<?php

namespace App\Http\Auth\useCases;

use App\Models\Cuenta;
use App\Models\Persona;
use App\Exceptions\CustomError;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class updateAccount{

    public static function update($data)
    {
        try {
            DB::beginTransaction();

            $cuenta     = Cuenta::where('cuenta_id',    $data->cuenta_id)->first();
            $persona    = Persona::where('persona_id', $data->persona_id)->first();

            $cuenta->update([
                "cuenta"    => $data->cuenta,
            ]);

            $persona->update([
                "nombre"            => $data->nombre,
                "primer_apellido"   => $data->primerApellido,
                "segundo_apellido"  => $data->segundoApellido,
                "nombre_completo"   => $data->nombre . " " . $data->primerApellido . " " . $data->segundoApellido,
                "correo"            => $data->correo,
                "telefono"          => $data->telefono,
            ]);  

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomError(
                "Ocurrio un error al actualizar la cuenta",
                404,
                $e
            );
        }
    }
}