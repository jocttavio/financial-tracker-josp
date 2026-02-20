<?php

namespace App\Http\Auth\useCases;

use App\Models\Cuenta;
use App\Exceptions\CustomError;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class updatePassword{

    public static function update($data)
    {
        try {
            DB::beginTransaction();

            $cuenta = Cuenta::where('cuenta_id', $data->cuenta_id)->first();

            $cuenta->update([
                "clave"    => Hash::make($data->new_password),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CustomError(
                "Ocurrio un error al actualizar la contraseña",
                404,
                $e
            );
        }
    }
}