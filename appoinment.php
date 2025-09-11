<?php
require 'db.php';
$db = getDB();
$rows = $db->query("SELECT * FROM bookings ORDER BY date DESC, time DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Appointments | Snip & Style Salon</title>
  <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .page-header {
      background: linear-gradient(90deg, #7d3c98, #c2185b);
      color: #fff;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
    }
    .table thead {
      background: #7d3c98;
      color: #fff;
    }
    .table tbody tr:hover {
      background-color: rgba(125, 60, 152, 0.05);
      transition: 0.2s;
    }
    .status-confirmed {
      background-color: #28a745;
      color: #fff;
      padding: 4px 10px;
      border-radius: 15px;
      font-size: 0.9rem;
    }
    .status-pending {
      background-color: #ffc107;
      color: #000;
      padding: 4px 10px;
      border-radius: 15px;
      font-size: 0.9rem;
    }
    .status-cancelled {
      background-color: #dc3545;
      color: #fff;
      padding: 4px 10px;
      border-radius: 15px;
      font-size: 0.9rem;
    }
    .action-btn {
      border-radius: 20px;
      padding: 5px 12px;
      font-size: 0.85rem;
    }
    .search-bar {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid mt-4">
    <div class="page-header">
      <h2>Appointments</h2>
      <p>View and manage all customer bookings</p>
    </div>

    <div class="row mb-3">
      <div class="col-md-6 search-bar">
        <input type="text" id="searchInput" class="form-control" placeholder="Search by name, service, or date...">
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Customers</th>
            <th>Service</th>
            
            <th>Date</th>
            <th>Time</th>
            <th>Paid Status</th>
            <th>Contact</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="appointmentsTable">
          <?php foreach ($rows as $row): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['fullname']); ?></td>
              <td><?php echo htmlspecialchars($row['service']); ?></td>
              
              <td><?php echo htmlspecialchars($row['date']); ?></td>
              <td><?php echo htmlspecialchars($row['time']); ?></td>
              <td>
                <?php if ($row['paid']): ?>
                  <span class="status-confirmed">Confirmed</span>
                <?php else: ?>
                  <span class="status-pending">Pending</span>
                <?php endif; ?>
              </td>
              <td><?php echo htmlspecialchars($row['phone']); ?></td>
              <td>
                <button class="btn btn-primary btn-sm action-btn">Edit</button>
                <button class="btn btn-danger btn-sm action-btn">Cancel</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
      let filter = this.value.toLowerCase();
      let rows = document.querySelectorAll("#appointmentsTable tr");
      rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
      });
    });
  </script>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script> 
  <script src="js/bootstrap-4.4.1.js"></script>
</body>
</html>
