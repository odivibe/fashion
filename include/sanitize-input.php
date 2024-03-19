<?php

function sanitizeInput($value) 
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    $value = strtolower($value);
    return $value;
}

