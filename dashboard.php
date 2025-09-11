<?php
require 'db.php';
$db = getDB();

// Total Appointments
$appointments = $db->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

// Total Stylists (hardcoded, you can make a 'stylists' table later)
$stylists = 15;

// Total Customers (unique phone numbers from bookings)
$customers = $db->query("SELECT COUNT(DISTINCT phone) FROM bookings")->fetchColumn();

// Revenue (sum of all payments)
$revenue = $db->query("SELECT IFNULL(SUM(amount),0) FROM payments")->fetchColumn();

// Monthly appointment counts
$monthlyData = $db->query("
  SELECT strftime('%m', date) as month, COUNT(*) as total
  FROM bookings
  GROUP BY strftime('%m', date)
")->fetchAll(PDO::FETCH_KEY_PAIR);

$chartData = [];
for ($m = 1; $m <= 12; $m++) {
  $chartData[] = $monthlyData[str_pad($m, 2, '0', STR_PAD_LEFT)] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Snip & Style Salon</title>
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <style>
      body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f8f9fa;
      }
      .sidebar {
        height: 100vh;
        background: linear-gradient(180deg, #7d3c98, #c2185b);
        color: #fff;
        padding-top: 20px;
        position: fixed;
        width: 250px;
        transition: all 0.3s;
      }
      .sidebar h2 {
        font-size: 22px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: bold;
      }
      .sidebar a {
        color: #fff;
        display: block;
        padding: 12px 20px;
        text-decoration: none;
        transition: background 0.3s;
      }
      .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
      }
      .content {
        margin-left: 250px;
        padding: 20px;
      }
      .card-custom {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
      }
      .card-custom:hover {
        transform: scale(1.02);
      }
      .card-title {
        font-weight: 600;
      }
      .topbar {
        background: #fff;
        padding: 15px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        border-radius: 10px;
      }
    </style>
  </head>
  <body>
    <div class="sidebar">
      <h2>Snip & Style</h2>
      <a href="dashboard.php">Dashboard</a>
      <a href="appoinment.php">Appointment Details</a>
      <a href="appoinment.php">Stylist Names</a>
      <a href="appoinment.php">Customers</a>
      <a href="appoinment.php">Paid Status</a>
    </div>

    <div class="content">
      <div class="topbar">
        <h4>Welcome, Admin</h4>
        <button class="btn btn-sm btn-outline-dark">Logout</button>
      </div>

      <div class="row g-4">
        <div class="col-md-3">
          <div class="card card-custom text-center p-3">
            <h5 class="card-title">Appointments</h5>
            <p class="display-6 text-primary"><?php echo $appointments; ?></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-custom text-center p-3">
            <h5 class="card-title">Stylists</h5>
            <p class="display-6 text-success"><?php echo $stylists; ?></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-custom text-center p-3">
            <h5 class="card-title">Customers</h5>
            <p class="display-6 text-danger"><?php echo $customers; ?></p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-custom text-center p-3">
            <h5 class="card-title">Revenue</h5>
            <p class="display-6 text-warning">Rs <?php echo $revenue; ?></p>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <div class="card card-custom p-4">
          <h5 class="mb-3">Monthly Appointments</h5>
          <canvas id="appointmentsChart" height="100"></canvas>
        </div>
      </div>
    </div>

    <br><br><br>
    <section>
      <center>
        <a href="index.html" 
          style="display: inline-flex; align-items: center; background:linear-gradient(145deg, #ff5f6d, #ffc371);color:white;
          padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;
          font-family: Poppins, sans-serif; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
          H O M E
        </a>
      </center>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx = document.getElementById('appointmentsChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'],
          datasets: [{
            label: 'Appointments',
            data: <?php echo json_encode($chartData); ?>,
            borderColor: '#7d3c98',
            backgroundColor: 'rgba(125, 60, 152, 0.2)',
            fill: true,
            tension: 0.3
          }]
        }
      });
    </script>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script> 
    <script src="js/bootstrap-4.4.1.js"></script>
  </body>
</html>
