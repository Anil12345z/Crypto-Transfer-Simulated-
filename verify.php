<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'] ?? '';
    $signature = base64_decode($_POST['signature'] ?? '');

    if (!$message || !$signature) die("❌ Missing data.");

    $publicKey = file_get_contents("keys/public.pem");
    if (!$publicKey) die("❌ Cannot load public key.");

    // Verify the signature
    $verified = openssl_verify($message, $signature, $publicKey, OPENSSL_ALGO_SHA256);

    if ($verified == 1) {
        file_put_contents("keys/log.txt", $message . PHP_EOL, FILE_APPEND);
        echo "✅ Transaction is verified!";
        
        // Add transaction to history
        $transactions = json_decode(file_get_contents("transactions.json"), true);
        $transaction = json_decode($message, true);
        $transactions[] = $transaction;
        file_put_contents("transactions.json", json_encode($transactions, JSON_PRETTY_PRINT));
        
    } elseif ($verified == 0) {
        echo "❌ Invalid signature!";
    } else {
        echo "⚠️ Verification error: " . openssl_error_string();
    }

    echo "<br><br><a href='index.php'>⬅️ Back</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crypto Transfer - Verify</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        input[type=submit] { padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>📜 Verify Transaction</h1>

    <form method="POST" action="verify.php">
        <textarea name="message" placeholder="Paste transaction message here..."></textarea>
        <textarea name="signature" placeholder="Paste base64 signature here..."></textarea>
        <input type="submit" value="Verify Transaction">
    </form>

    <h2>📱 Scan QR Code for Signature</h2>
    <video id="qr-video" width="300" height="300"></video>
    <canvas id="qr-canvas" style="display:none;"></canvas>
    <button onclick="startScanner()">Start Scanner</button>

    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>
    <script>
        function startScanner() {
            const video = document.getElementById('qr-video');
            const canvas = document.getElementById('qr-canvas');
            const ctx = canvas.getContext('2d');
            const qrResult = document.querySelector('[name="signature"]');

            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then((stream) => {
                    video.srcObject = stream;
                    video.setAttribute("playsinline", true);
                    video.play();

                    requestAnimationFrame(scanQRCode);
                });

            function scanQRCode() {
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvas.height = video.videoHeight;
                    canvas.width = video.videoWidth;
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const code = jsQR(imageData.data, canvas.width, canvas.height);

                    if (code) {
                        qrResult.value = code.data;
                    }
                }

                requestAnimationFrame(scanQRCode);
            }
        }
    </script>
</body>
</html>
