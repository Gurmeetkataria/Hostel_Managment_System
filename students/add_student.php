<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

$rooms = $conn->query("SELECT * FROM rooms ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rooms - Hostel Management</title>
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
            background: rgba(255, 255, 255, 0.1);
            border: none;
            backdrop-filter: blur(12px);
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
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

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
        }

        .btn-danger:hover {
            background-color: #dc3545;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            h3 {
                font-size: 1.5rem;
                text-align: center;
            }
            .table {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div style="width:250px;">
        <?php include '../includes/sidebar.php'; ?>
    </div>

    <!-- Main content -->
    <div class="p-4" style="width:100%;">
        <div class=" card-glass p-4">
            <h3 style="color:white;">View Rooms</h3>

            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'){ ?>
                <div class="alert alert-danger">Room deleted successfully!</div>
            <?php } ?>

            <div class="table-responsive">
                <table class="table align-middle mt-4">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Room No</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($rooms as $room){ ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $room['room_no']; ?></td>
                                <td><?php echo $room['room_type']; ?></td>
                                <td><?php echo $room['capacity']; ?></td>
                                <td>
                                    <?php if($room['status'] == 'Available'){ ?>
                                        <span class="badge bg-success"><?php echo $room['status']; ?></span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger"><?php echo $room['status']; ?></span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="update_room.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_room.php?id=<?php echo $room['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
