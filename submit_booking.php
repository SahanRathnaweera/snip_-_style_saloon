<?php
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $service = trim($_POST['service'] ?? '');
  $date = trim($_POST['date'] ?? '');
  $time = trim($_POST['time'] ?? '');
  $feedback = trim($_POST['feedback'] ?? '');

  if (strlen($fullname) < 5) { header('Location: booknow.html'); exit; }
  if (!preg_match('/^[0-9]{10}$/', $phone)) { header('Location: booknow.html'); exit; }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { header('Location: booknow.html'); exit; }
  if ($service === '') { header('Location: booknow.html'); exit; }

  $db = getDB();
  $stmt = $db->prepare('INSERT INTO bookings (fullname,phone,email,service,date,time,feedback,created_at) VALUES (?,?,?,?,?,?,?,datetime("now"))');
  $stmt->execute([$fullname,$phone,$email,$service,$date,$time,$feedback]);
  $id = $db->lastInsertId();
  header('Location: paynow.php?id='.$id);
  exit;
}
header('Location: booknow.html');
?>