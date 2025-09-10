<?php
require 'db.php';
$db = getDB();
$rows = $db->query('SELECT * FROM bookings ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin - bookings</title>
</head>
<body>
<h2>Bookings</h2>
<table border="1" cellpadding="6" cellspacing="0">
<tr><th>id</th><th>fullname</th><th>phone</th><th>service</th><th>date</th><th>time</th><th>paid</th></tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?php echo $r['id'] ?></td>
<td><?php echo htmlspecialchars($r['fullname']) ?></td>
<td><?php echo htmlspecialchars($r['phone']) ?></td>
<td><?php echo htmlspecialchars($r['service']) ?></td>
<td><?php echo htmlspecialchars($r['date']) ?></td>
<td><?php echo htmlspecialchars($r['time']) ?></td>
<td><?php echo $r['paid'] ? 'Yes' : 'No' ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>