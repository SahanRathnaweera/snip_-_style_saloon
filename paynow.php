<?php
require 'db.php';
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { echo "Invalid booking id"; exit; }
$db = getDB();
$stmt = $db->prepare('SELECT * FROM bookings WHERE id = ?');
$stmt->execute([$id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$booking) { echo "Booking not found"; exit; }
$prices = ['haircut'=>500,'coloring'=>1500,'styling'=>800,'facial'=>1200];
$amount = $prices[$booking['service']] ?? 500;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pay for Booking</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f9f9f9;
    }
    .payment-card {
      max-width: 500px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .payment-card h2 {
      margin-bottom: 20px;
    }
    .amount {
      font-size: 1.5rem;
      font-weight: bold;
      color: #28a745;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="payment-card">
      <h2 class="text-center">Payment Gateway</h2>
      <p><strong>Booking ID:</strong> <?php echo $booking['id'] ?></p>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($booking['fullname']) ?></p>
      <p><strong>Service:</strong> <?php echo htmlspecialchars($booking['service']) ?></p>
      <p><strong>Date & Time:</strong> <?php echo htmlspecialchars($booking['date']) ?> <?php echo htmlspecialchars($booking['time']) ?></p>
      <p class="amount text-center">Amount: Rs <?php echo $amount ?></p>
      <form method="post" action="process_payment.php">
        <input type="hidden" name="booking_id" value="<?php echo $booking['id'] ?>">
        <input type="hidden" name="amount" value="<?php echo $amount ?>">
        <div class="mb-3">
          <label for="method" class="form-label">Payment Method</label>
          <select name="method" id="method" class="form-select" required>
            <option value="">-- Select --</option>
            <option value="card">Credit/Debit Card</option>
            <option value="cash">Cash</option>
            <option value="bank">Bank Transfer</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Pay Now</button>
      </form>
    </div>
  </div>
</body>
</html>
