<?php
require 'vendor/autoload.php';

// Snowflake account details
$account = 'ZUB43281';
$role = 'api_role';
$user = 'api_user';
$warehouse = 'COMPUTE_WH';
$database = 'MASCARINXT_MENUS';
$schema = 'PUBLIC';

// SQL query
$query = "SELECT * FROM mascarinxt_menus.public.restaurants LIMIT 10";

// Generate JWT
$privateKey = file_get_contents('rsa_private_key.pem');
$payload = array(
    "iss" => "$account.$user",
    "sub" => "$account.$user",
    "iat" => time(),
    "exp" => time() + (60 * 60),
);
$jwt = \Firebase\JWT\JWT::encode($payload, $privateKey, 'RS256');

// Snowflake REST API endpoint
$url = "https://$account.snowflakecomputing.com/api/v2/statements";

// cURL request
$headers = array(
    "Authorization: Bearer $jwt",
    "Content-Type: application/json"
);

$data = json_encode(array(
    "statement" => $query,
    "warehouse" => $warehouse,
    "role" => $role,
    "database" => $database,
    "schema" => $schema,
));

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => $headers,
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {
    echo 'Response: ' . $response;
}

curl_close($curl);
?>
