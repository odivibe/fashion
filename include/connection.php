<?php

$host   = 'localhost';
$user   = 'root';
$dbname = 'fashiondb';
$pass   = '';
$conn = null;

// Set options
$options = array(
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
    );
    
try
{
    $conn = new PDO('mysql:host='.$host.';dbname='.$dbname; $user, $pass, $options); 
}
catch(PDOException $e)
{
    errorLog("Connection failed ".$e->getMessage());                
}
