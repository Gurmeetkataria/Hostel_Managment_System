<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

// Fetch fees with student info
$fees = $conn->query("
    SELECT fees.*, students.name, students.room_id
    FROM fees
    LEFT JOIN students ON fees.student_id = students.id
    ORDER BY fees.id DESC
")->fetchAll(PDO::FETCH_ASSOC);

// Calculate total fees
$total_fees = $conn->query("SELECT SUM(amount) FROM fees")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Fees - Hostel Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    min-height: 100vh;
    background: linear-gradient(135deg, #141E30, #243B55);
    color: #fff;
    font-family: 'Poppins', sans-serif;
}

h3 {
    font-weight: 600;
    color: #f8f9fa;
    border-left: 5px solid #0dcaf0;
    padding-left: 10px;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

.card-glass {
    background: rgba(255, 255, 255, 0.08);
    border: none;
    backdrop-filter: blur(12px);
    border-radius: 16px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
    padding: 20px;
    transition: all 0.3s ease;
}

.card-glass:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 40px rgba(0, 200, 255, 0.3);
}

.table {
    color: #fff;
    border-collapse: separate;
    border-spacing: 0 8px;
}

thead {
    background: rgba(13, 202, 240, 0.8);
    color: #fff;
}

tbody tr {
    background-color: rgba(255, 255, 255, 0.08);
    transition: all 0.3s ease;
}

tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.2);
    transform: scale(1.01);
}

.table td, .table th {
    vertical-align: middle;
}

.btn {
    border-radius: 20px;
    padding: 5px 15px;
    transition: all 0.3s ease;
}

.btn-warning:hover { background-color: #e0a800; transform: translateY(-2px); }
.btn-danger:hover { background-color: #dc3545; transform: translateY(-2px); }

.badge {
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    h3 { font-size: 1.5rem; text-align: center; }
    .table { font-size: 0.9rem; }
}

@media (max-width: 576px) {
    .card-glass { padding: 15px; }
}

/* Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-thumb { background: #00aaff; border-radius: 10px; }
</style>
</head>

<body>
<div class="d-flex">
    <div style="width:250px;">
        <?php include '../includes/sidebar.php'; ?>
    </div>

    <div class="p-4" style="width:100%;">
        <div class="card-glass">
            <h3 style="color:white;">All Fees Records</h3>
            <div class="table-responsive">
                <table class="table align-middle mt-3">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Room ID</th>
                            <th>Amount</th>
                            <th>Month</th>
                            <th>Date Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($fees as $fee){ ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $fee['name']; ?></td>
                            <td><?php echo $fee['room_id']; ?></td>
                            <td><?php echo $fee['amount']; ?></td>
                            <td><?php echo $fee['month']; ?></td>
                            <td><?php echo $fee['date_paid']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <h5 style="color:white;">Total Fees Collected: <?php echo $total_fees ? $total_fees : 0; ?></h5>
        </div>
    </div>
</div>
</body>
</html>
