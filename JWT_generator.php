<?php
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;

// Correct file path to the private key
$privateKey = file_get_contents('rsa_private_key.pem');

$payload = array(
    "iss" => "ZUB43281.api_user", // Snowflake issuer format: account.user
    "sub" => "ZUB43281.api_user", // Subject
    "iat" => time(),              // Issued at time
    "exp" => time() + (60 * 60),  // Expiration time (1 hour)
);

$jwt = JWT::encode($payload, $privateKey, 'RS256');

echo "Generated JWT: " . $jwt;
?>
