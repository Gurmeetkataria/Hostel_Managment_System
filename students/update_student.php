<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

if(!isset($_GET['id'])){
    header("Location: view_students.php");
    exit;
}

$id = $_GET['id'];

// Fetch student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$student){
    die("Student not found!");
}

// Fetch available rooms
$rooms = $conn->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);

// Handle form update
if(isset($_POST['update_student'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $room_id = $_POST['room_id'];
    $fees_paid = $_POST['fees_paid'];
    $join_date = $_POST['join_date'];

    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, room_id=?, fees_paid=?, join_date=? WHERE id=?");
    $stmt->execute([$name, $email, $phone, $room_id, $fees_paid, $join_date, $id]);

    $message = "Student updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Student - Hostel Management</title>
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

/* === Heading === */
h3 {
    font-weight: 700;
    text-transform: uppercase;
    color: #fff;
    letter-spacing: 1px;
    text-shadow: 0 3px 10px rgba(253,246,246,0.2);
    margin-bottom: 25px;
    animation: fadeInDown 1s ease;
}

/* === Main Container === */
.p-4 {
    animation: fadeInUp 1s ease;
}

/* === Form Card === */
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

.form-control::placeholder {
    color: #ccc;
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

/* === Alert === */
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

    <!-- Main content -->
    <div class="p-4" style="width:100%;">
        <h3 style="color:white;">Update Student</h3>

        <?php if(isset($message)){ ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post" class="mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input type="text" name="name" value="<?php echo $student['name']; ?>" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo $student['email']; ?>" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" value="<?php echo $student['phone']; ?>" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Room</label>
                    <select name="room_id" class="form-select" required>
                        <?php foreach($rooms as $room){ ?>
                            <option value="<?php echo $room['id']; ?>" <?php if($student['room_id']==$room['id']) echo 'selected'; ?>>
                                <?php echo $room['room_no'] . " (" . $room['room_type'] . ")"; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Fees Paid</label>
                    <select name="fees_paid" class="form-select">
                        <option value="Yes" <?php if($student['fees_paid']=='Yes') echo 'selected'; ?>>Yes</option>
                        <option value="No" <?php if($student['fees_paid']=='No') echo 'selected'; ?>>No</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Join Date</label>
                    <input type="date" name="join_date" value="<?php echo $student['join_date']; ?>" class="form-control" required>
                </div>
            </div>

            <button type="submit" name="update_student" class="btn btn-primary">Update Student</button>
            <a href="view_students.php" class="btn btn-secondary ms-2">Back</a>
        </form>
    </div>
</div>
</body>
</html>
