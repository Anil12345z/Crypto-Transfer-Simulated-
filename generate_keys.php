<?php
$config = [
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

$keys = openssl_pkey_new($config);
if (!$keys) die("❌ Failed to generate keys: " . openssl_error_string());

openssl_pkey_export($keys, $privateKey);
$details = openssl_pkey_get_details($keys);
$publicKey = $details['key'];

if (!is_dir("keys")) mkdir("keys", 0755, true);
file_put_contents("keys/private.pem", $privateKey);
file_put_contents("keys/public.pem", $publicKey);

echo "✅ Keys generated.";
