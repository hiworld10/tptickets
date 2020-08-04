<?php

function moneyFormat($value)
{
    $prefix = ($value < 0) ? '-$' : '$'; 
    return $prefix . number_format($value, 2, ',', '');
}