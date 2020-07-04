<?php

namespace core;

class Error
{
    /**
     * Manipulador de errores. Convierte todos los errores en excepiones y arroja 
     * un ErrorException, el cual posteriormente será manejado por exceptionHandler().
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Manipulador de excepciones. Muestra la información del excepción con el propósito 
     * de encontrar el error con mayor facilidad.
     */
    public static function exceptionHandler($exception)
    {
        // 404 para not found y 500 para errores generales
        $code = $exception->getCode();

        if ($code != 404) {
            $code = 500;
        }

        // Setear el código de la excepción
        http_response_code($code);

        // Mostrar los detalles de la excepción en el navegador
        echo "<h1>Error</h1>";
        echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
        echo "<p>Code: " . $code . "</p>";
        echo "<p>Message: '" . $exception->getMessage() . "'</p>";
        echo "<p>Thrown in '" . $exception->getFile() . "' on line <b>" . $exception->getLine() . "</b></p>";
        echo "<p>Stack trace:<pre><big>" . $exception->getTraceAsString() . "</big></pre></p>";
    }
}
