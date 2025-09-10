<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: booknow.html'); exit; }
$booking_id = intval($_POST['booking_id'] ?? 0);
$method = trim($_POST['method'] ?? '');
$amount = floatval($_POST['amount'] ?? 0);
if ($booking_id <= 0) { echo "Invalid"; exit; }
$db = getDB();
$stmt = $db->prepare('INSERT INTO payments (booking_id,method,amount,paid_at) VALUES (?,?,?,datetime("now"))');
$stmt->execute([$booking_id,$method,$amount]);
$stmt = $db->prepare('UPDATE bookings SET paid = 1 WHERE id = ?');
$stmt->execute([$booking_id]);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
    }
    .status-card {
      max-width: 500px;
      margin: 60px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }
    .status-card h2 {
      margin-bottom: 20px;
    }
    .success {
      color: #28a745;
      font-weight: bold;
    }
    .details {
      margin-top: 20px;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="status-card">
      <h2>Payment Successful</h2>
      <p class="success">Your payment has been processed successfully!</p>
      <div class="details">
        <p><strong>Booking ID:</strong> <?php echo $id ?></p>
        <p><strong>Amount:</strong> Rs <?php echo number_format($amount,2) ?></p>
        <p><strong>Method:</strong> <?php echo htmlspecialchars($method) ?></p>
      </div>
      <a href="index.html" class="btn btn-primary mt-3">Back to Home</a>
    </div>
  </div>
</body>
</html>
