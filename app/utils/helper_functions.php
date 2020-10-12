<?php

/**
 * Formatea los valores representados en moneda de la manera deseada.
 * Ej. 50 --> $50,00
 * 
 * @param  string $value el valor a convertir
 * @return string valor formateado
 */
function moneyFormat($value)
{
    $prefix = ($value < 0) ? '-$' : '$'; 
    return $prefix . number_format($value, 2, ',', '');
}