<?php
$db = new PDO('sqlite:'.__DIR__.'/salon.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("CREATE TABLE IF NOT EXISTS bookings (id INTEGER PRIMARY KEY AUTOINCREMENT, fullname TEXT, phone TEXT, email TEXT, service TEXT, date TEXT, time TEXT, feedback TEXT, paid INTEGER DEFAULT 0, created_at TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS payments (id INTEGER PRIMARY KEY AUTOINCREMENT, booking_id INTEGER, method TEXT, amount REAL, paid_at TEXT)");
echo "initialized";
?>