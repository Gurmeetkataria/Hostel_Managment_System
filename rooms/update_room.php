<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_rooms.php");
    exit;
}

$id = $_GET['id'];

// Fetch room data
$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$room){
    die("Room not found!");
}

// Handle update
if(isset($_POST['update_room'])){
    $room_no = $_POST['room_no'];
    $room_type = $_POST['room_type'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE rooms SET room_no=?, room_type=?, capacity=?, status=? WHERE id=?");
    $stmt->execute([$room_no, $room_type, $capacity, $status, $id]);

    $message = "Room updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Room - Hostel Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* === Page Background === */
body {
    background: linear-gradient(135deg, #141e30, #243b55);
    font-family: 'Poppins', sans-serif;
    color: #fff;
    min-height: 100vh;
    overflow-x: hidden;
}

h3 {
    font-weight: 700;
    text-transform: uppercase;
    color: #fff;
    letter-spacing: 1px;
    text-shadow: 0 3px 10px rgba(253,246,246,0.2);
    margin-bottom: 25px;
    animation: fadeInDown 1s ease;
}

.p-4 {
    animation: fadeInUp 1s ease;
}

form {
    background: rgba(255, 255, 255, 0.1);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    box-shadow: 0 0 25px rgba(0,0,0,0.4);
    transition: all 0.4s ease;
}

form:hover {
    transform: translateY(-3px);
    box-shadow: 0 0 40px rgba(0, 200, 255, 0.3);
}

label {
    font-weight: 500;
    color: #e6e6e6;
    margin-bottom: 6px;
}

.form-control, .form-select {
    background: rgba(255, 255, 255, 0.15);
    border: none;
    border-radius: 10px;
    color: #fff;
    padding: 12px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    background: rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 10px rgba(0, 180, 255, 0.5);
    color: #fff;
}

.btn-primary {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    padding: 12px 0;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,114,255,0.4);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0072ff, #00c6ff);
    box-shadow: 0 6px 20px rgba(0,114,255,0.5);
    transform: translateY(-2px);
}

.btn-secondary {
    border-radius: 12px;
    padding: 12px 0;
    font-weight: 500;
}

.alert-success {
    background: rgba(0, 255, 120, 0.15);
    color: #9cffb3;
    border: 1px solid rgba(0,255,120,0.3);
    border-radius: 10px;
    text-align: center;
    font-weight: 500;
    animation: fadeIn 1s ease;
}

/* === Animations === */
@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* === Responsive === */
@media (max-width: 768px) {
    h3 { font-size: 1.6rem; text-align: center; }
    form { padding: 20px; }
    .btn-primary, .btn-secondary { font-size: 0.9rem; padding: 10px; }
}

@media (max-width: 576px) {
    .p-4 { padding: 1rem !important; }
}

/* Scrollbar */
::-webkit-scrollbar { width: 8px; }
::-webkit-scrollbar-thumb { background: #00aaff; border-radius: 10px; }
</style>
</head>

<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div style="width:250px;">
        <?php include '../includes/sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <h3 style="color:white;">Update Room</h3>

        <?php if(isset($message)){ ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post" class="mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Room No</label>
                    <input type="text" name="room_no" value="<?php echo $room['room_no']; ?>" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Room Type</label>
                    <select name="room_type" class="form-select" required>
                        <option value="Single" <?php if($room['room_type']=='Single') echo 'selected'; ?>>Single</option>
                        <option value="Double" <?php if($room['room_type']=='Double') echo 'selected'; ?>>Double</option>
                        <option value="Triple" <?php if($room['room_type']=='Triple') echo 'selected'; ?>>Triple</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Capacity</label>
                    <input type="number" name="capacity" value="<?php echo $room['capacity']; ?>" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Available" <?php if($room['status']=='Available') echo 'selected'; ?>>Available</option>
                        <option value="Full" <?php if($room['status']=='Full') echo 'selected'; ?>>Full</option>
                        <option value="Under Maintenance" <?php if($room['status']=='Under Maintenance') echo 'selected'; ?>>Under Maintenance</option>
                    </select>
                </div>
            </div>

            <button type="submit" name="update_room" class="btn btn-primary">Update Room</button>
            <a href="view_rooms.php" class="btn btn-secondary ms-2">Back</a>
        </form>
    </div>
</div>
</body>
</html>
