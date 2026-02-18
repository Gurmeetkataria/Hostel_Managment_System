<?php
session_start();
include '../includes/db_connect.php';

if(!isset($_SESSION['admin_id'])){
    header("Location: ../index.php");
    exit;
}

// Fetch students for dropdown
$students = $conn->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['add_fees'])){
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $month = $_POST['month'];
    $date_paid = $_POST['date_paid'];

    $stmt = $conn->prepare("INSERT INTO fees (student_id, amount, month, date_paid) VALUES (?, ?, ?, ?)");
    $stmt->execute([$student_id, $amount, $month, $date_paid]);

    // Update student's fees_paid status
    $stmt2 = $conn->prepare("UPDATE students SET fees_paid='Yes' WHERE id=?");
    $stmt2->execute([$student_id]);

    $message = "Fees added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Fees - Hostel Management</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
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
    letter-spacing: 1px;
    text-shadow: 0 3px 10px rgba(253, 246, 246, 0.2);
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

.alert-success {
    background: rgba(0, 255, 120, 0.15);
    color: #9cffb3;
    border: 1px solid rgba(0,255,120,0.3);
    border-radius: 10px;
    text-align: center;
    font-weight: 500;
    animation: fadeIn 1s ease;
}

@keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

@media (max-width: 768px){
    h3 { font-size: 1.6rem; }
    form { padding: 20px; }
    .btn-primary { font-size: 0.9rem; padding: 10px; }
}

@media (max-width: 576px){
    .p-4 { padding: 1rem !important; }
}

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
        <h3 style="color:white;">Add Fees</h3>

        <?php if(isset($message)){ ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post" class="mt-4">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Student</label>
                   <select name="student_id" class="form-select" required style="color:black; background-color:white;">
    <option value="">Select Student</option>
    <?php foreach($students as $student){ ?>
        <option value="<?php echo $student['id']; ?>">
            <?php echo $student['name']; ?> (<?php echo $student['room_id']; ?>)
        </option>
    <?php } ?>
</select>

                </div>
                <div class="col-md-6 mb-3">
                    <label>Amount</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Month</label>
                    <input type="text" name="month" class="form-control" placeholder="October" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Date Paid</label>
                    <input type="date" name="date_paid" class="form-control" required>
                </div>
            </div>

            <button type="submit" name="add_fees" class="btn btn-primary">Add Fees</button>
            <a href="view_fees.php" class="btn btn-secondary ms-2">View Fees</a>
        </form>
    </div>
</div>
</body>
</html>
