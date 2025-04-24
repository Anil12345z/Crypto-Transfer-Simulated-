<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);

    // Load wallet balances
    $wallets = json_decode(file_get_contents("wallets.json"), true);

    if (!isset($wallets[$from])) die("❌ Sender wallet doesn't exist.");
    if ($wallets[$from] < $amount) die("❌ Insufficient funds!");

    $wallets[$from] -= $amount;
    $wallets[$to] = ($wallets[$to] ?? 0) + $amount;

    file_put_contents("wallets.json", json_encode($wallets, JSON_PRETTY_PRINT));

    // Log the transaction
    $transaction = [
        'from' => $from,
        'to' => $to,
        'amount' => $amount,
        'timestamp' => time()
    ];

    $transactions = json_decode(file_get_contents("transactions.json"), true);
    $transactions[] = $transaction;
    file_put_contents("transactions.json", json_encode($transactions, JSON_PRETTY_PRINT));

    // Sign the transaction
    $privateKey = file_get_contents("keys/private.pem");
    if (!$privateKey) die("❌ Cannot load private key.");

    openssl_sign(json_encode($transaction), $signature, $privateKey, OPENSSL_ALGO_SHA256);
    $encodedSignature = base64_encode($signature);

    $qrData = urlencode($encodedSignature);
    echo "<h2>✅ Transaction Signed</h2>";
    echo "<strong>Transaction:</strong><pre>" . json_encode($transaction) . "</pre>";
    echo "<h4> Signature</h4>";
    echo "<strong></strong><textarea rows='5' cols='100'>$encodedSignature</textarea>";
    echo "<br>";
    echo "<br>";
    echo "<h4> QR Code </h4>";
    echo "<br><img src='https://api.qrserver.com/v1/create-qr-code/?data=$qrData&size=200x200' />";
    echo "<br><br><a href='index.php'>⬅️ Back</a>";
}
?>
