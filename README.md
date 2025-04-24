# Crypto-Transfer-Simulated-
Crypto Transfer (Simulated) is a hands-on learning web application built with PHP and JavaScript, simulating secure cryptocurrency transactions using RSA digital signatures. It mimics real-world crypto systems with added wallet and transaction features for a more practical understanding.

### 🔐 Core Features:
- **RSA Digital Signatures**: Sign and verify transactions to ensure authenticity and prevent tampering.
- **QR Code Integration**: Instantly generate and scan QR codes for secure, fast sharing of signed transaction data.
- **Wallet System**:
  - 🔹 **Sender & Receiver Wallets** with real-time balance updates.
  - 🔹 **Balance Deduction** on successful transfers.
- **Dummy Bank**: Add mock money to any wallet for testing and simulation.
- **Transaction Verification**:
  - Verifies sender authenticity using the public key and signed message.
  - Confirms if the sender has enough balance before processing.
- **Transaction History**: All valid transactions saved to a JSON-based log file for easy review.

### 💡 Learning Objectives:
- Understand **public-private key encryption** and **digital signature validation**.
- Learn how real-world wallets deduct balance and verify sender authenticity.
- Explore how **QR codes** simplify transaction data transfer.
- Practice backend logic for **secure financial operations** in PHP.

File Structure -

project/
│
├── index.php
├── transfer.php
├── verify.php
├── gen_keys.php
├── bank.php ← 🆕 Add money from dummy bank
├── wallets.json ← 💰 Stores balances
├── keys/
│   ├── private.pem
│   └── public.pem

