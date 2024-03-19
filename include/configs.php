<?php
session_start();

ini_set("display_errors", 0);

ini_set("date.timezone", "Africa/Lagos");

// Define ROOT_PATH
define('ROOT_PATH', realpath(dirname(__FILE__)));

// Define BASE_URL dynamically based on environment (localhost or Ngrok)
if ($_SERVER['HTTP_HOST'] === 'localhost') 
{
    define('BASE_URL', 'http://localhost/fashion/');
} 
/*elseif ($_SERVER['HTTP_HOST'] === 'your-ngrok-subdomain.ngrok.io') 
{
    define('BASE_URL', 'https://your-ngrok-subdomain.ngrok.io');
}
else 
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] === "on") 
    {
        $src_link = "https";
    }
    else
    {
        $src_link = "http";
    }

    $src_link.= "://";
    $src_link .= $_SERVER["HTTP_HOST"]."/fashion/";

    // Set live server URL
    define('BASE_URL', $src_link);
}*/






