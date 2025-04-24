<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);

    $wallets = json_decode(file_get_contents("wallets.json"), true);
    if (!isset($wallets[$address])) $wallets[$address] = 0;

    $wallets[$address] += $amount;
    file_put_contents("wallets.json", json_encode($wallets, JSON_PRETTY_PRINT));

    echo "✅ Added ₹$amount to $address's wallet.";
    echo "<br><br><a href='index.php'>⬅️ Back</a>";
}
?>
<form method="POST">
    <h2>🏦 Dummy Bank - Add Money</h2>
    <input name="address" placeholder="Wallet Address (e.g., alice)" required>
    <input name="amount" placeholder="Amount" required>
    <input type="submit" value="Add Money">
</form>
