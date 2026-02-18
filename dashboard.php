<?php
session_start();
include 'includes/db_connect.php';

// Session check
if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit;
}

// Fetch statistics
$total_students = $conn->query("SELECT COUNT(*) FROM students")->fetchColumn();
$total_rooms = $conn->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$available_rooms = $conn->query("SELECT COUNT(*) FROM rooms WHERE status='Available'")->fetchColumn();
$total_fees = $conn->query("SELECT SUM(amount) FROM fees")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hostel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== GENERAL ===== */
        body {
            background: linear-gradient(135deg, #141e30, #243b55);
            font-family: 'Poppins', sans-serif;
            color: #f5f6fa;
            min-height: 100vh;
            margin: 0;
        }

        /* ===== HEADING ===== */
        h2 {
            text-align: center;
            font-weight: 700;
            font-size: 2.2rem;
            letter-spacing: 1px;
            color: #f8f9fa;
            text-transform: uppercase;
            position: relative;
            margin-bottom: 40px;
        }

        h2::after {
            content: "";
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        /* ===== LAYOUT ===== */
        .d-flex {
            display: flex;
        }

        .d-flex > div:first-child {
            background: linear-gradient(180deg, #0072ff, #00c6ff);
            min-height: 100vh;
            width: 250px;
            color: #fff;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.3);
        }

        .d-flex > div:first-child a {
            color: #fff;
            transition: all 0.3s ease;
        }

        .d-flex > div:first-child a:hover {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 6px;
            padding-left: 8px;
        }

        /* ===== MAIN CONTAINER ===== */
        #h2 {
            background: rgba(255, 255, 255, 0.08);
            flex-grow: 1;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            margin: 30px;
            padding: 40px;
            backdrop-filter: blur(12px);
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 20px;
            height: 180px;
            transition: all 0.35s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }

        .card .card-body {
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .card-text {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 10px;
        }
        #c-5{
            padding:10px;
        }
        /* ===== CARD COLORS ===== */
        .bg-primary {
            background: linear-gradient(135deg, #007bff, #00c6ff) !important;
        }

        .bg-success {
            background: linear-gradient(135deg, #00b09b, #96c93d) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #ffb347, #ffcc33) !important;
            color: #2d3436 !important;
        }

        .bg-danger {
            background: linear-gradient(135deg, #ff416c, #ff4b2b) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .d-flex {
                flex-direction: column;
            }
            .d-flex > div:first-child {
                min-height: auto;
                width: 100%;
            }
            #h2 {
                margin: 20px;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div style="width:250px;">
        <?php include 'includes/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="p-4" style="width:100%;" id="h2">
        <h2 style="color:white; text-shadow: 2px 2px 4px black;">Hostel Details</h2>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>
                        <p class="card-text"><?php echo $total_students; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Rooms</h5>
                        <p class="card-text"><?php echo $total_rooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Available Rooms</h5>
                        <p class="card-text"><?php echo $available_rooms; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body" id="c-5">
                        <h5 class="card-title">Total Fees Collected</h5>
                        <p class="card-text"><?php echo $total_fees ? $total_fees : 0; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
