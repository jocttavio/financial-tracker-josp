<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait LogExceptionTrait
{
    public function reportApiException($exception)
    {
      // Logs personalizados
      $originalException = $exception;
      
      // Buscar la excepción original si existe una excepción previa      
      while ($previous = $originalException->getPrevious()) {
        $originalException = $previous;
      }
      
      // Obtener la clase, mensaje, archivo y línea del error original
      $exceptionClass = get_class($originalException);
      $errorMessage = $originalException->getMessage();
      $errorFile = $originalException->getFile();
      $errorLine = $originalException->getLine();
      
      // Formatear el mensaje del error original
      $formattedError = "[$exceptionClass] Error original: \"$errorMessage\"\nen el archivo $errorFile en la línea $errorLine.";
      
      Log::error($formattedError);
    }
}