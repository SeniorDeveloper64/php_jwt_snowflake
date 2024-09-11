<?php
require 'vendor/autoload.php';

use phpseclib3\Crypt\RSA;

$privateKey = RSA::createKey(2048);
$publicKey = $privateKey->getPublicKey();

file_put_contents('rsa_private_key.pem', $privateKey);
file_put_contents('rsa_public_key.pem', $publicKey);

echo "RSA keys generated successfully.";
?>