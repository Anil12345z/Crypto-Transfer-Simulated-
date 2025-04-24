<?php
$wallets = file_exists("wallets.json") ? json_decode(file_get_contents("wallets.json"), true) : [];
$transactions = file_exists("transactions.json") ? json_decode(file_get_contents("transactions.json"), true) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crypto Transfer</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        textarea, input[type=text] { width: 100%; margin: 5px 0; padding: 10px; }
        input[type=submit] { padding: 10px 20px; }
        .wallets, .transactions { margin: 20px 0; padding: 10px; background: #f9f9f9; border: 1px solid #ddd; }
        .transaction { margin-bottom: 15px; padding: 10px; background-color: #eee; }
    </style>
</head>
<body>
    <h1>💸 Crypto Transfer (Simulated)</h1>

    <div class="wallets">
        <h3>💰 Wallet Balances</h3>
        <ul>
            <?php foreach ($wallets as $addr => $bal): ?>
                <li><strong><?= htmlspecialchars($addr) ?>:</strong> ₹<?= htmlspecialchars($bal) ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="bank.php">➕ Add Money from Dummy Bank</a>
    </div>

    <h2>✍️ Step 1: Create & Sign Transaction</h2>
    <form method="POST" action="transfer.php">
        <input type="text" name="from" placeholder="Sender Address (e.g., alice)" required>
        <input type="text" name="to" placeholder="Receiver Address (e.g., bob)" required>
        <input type="text" name="amount" placeholder="Amount" required>
        <input type="submit" value="Sign & Submit">
    </form>

    <h2>📜 Step 2: Verify Transaction</h2>
    <form method="POST" action="verify.php">
        <textarea name="message" placeholder="Paste transaction message here..."></textarea>
        <textarea name="signature" placeholder="Paste base64 signature here..."></textarea>
        <input type="submit" value="Verify Transaction">
    </form>

    <div class="transactions">
        <h3>📜 Transaction History</h3>
        <?php if (count($transactions) > 0): ?>
            <?php foreach ($transactions as $transaction): ?>
                <div class="transaction">
                    <strong>From:</strong> <?= htmlspecialchars($transaction['from']) ?> <br>
                    <strong>To:</strong> <?= htmlspecialchars($transaction['to']) ?> <br>
                    <strong>Amount:</strong> ₹<?= htmlspecialchars($transaction['amount']) ?> <br>
                    <strong>Timestamp:</strong> <?= date('Y-m-d H:i:s', $transaction['timestamp']) ?> <br>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No transactions found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
