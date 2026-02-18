<?php
// Session check
if(!isset($_SESSION['admin_id'])){
    header("Location: index.php");
    exit;
}
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons (Bootstrap Icons) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* ===== Sidebar Base ===== */
    .sidebar {
        background: linear-gradient(180deg, #0f2027, #203a43, #2c5364);
        height: 100vh;
        color: #f1f1f1;
        transition: all 0.3s ease;
        font-family: 'Poppins', sans-serif;
        box-shadow: 3px 0 15px rgba(0,0,0,0.4);
        overflow-y: auto;
    }

    /* ===== Scrollbar Styling ===== */
    .sidebar::-webkit-scrollbar {
        width: 8px;
    }
    .sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.2);
        border-radius: 5px;
    }
    .sidebar::-webkit-scrollbar-thumb:hover {
        background-color: rgba(255,255,255,0.3);
    }

    /* ===== Sidebar Heading ===== */
    .sidebar h5 {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 1.1rem;
        color: #fff;
        text-shadow: 0 0 10px rgba(0,255,255,0.3);
    }

    /* ===== Nav Links ===== */
    .nav-link {
        color: #cfd2dc !important;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 10px 14px;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
    }

    .nav-link i {
        font-size: 1.1rem;
        margin-right: 10px;
    }

    .nav-link:hover {
        background: linear-gradient(90deg, rgba(0,212,255,0.2), rgba(9,9,121,0.3));
        color: #ffffff !important;
        transform: translateX(4px);
        box-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
    }

    /* ===== Dropdown Links ===== */
    .nav-item .collapse .nav-link {
        font-size: 14px;
        padding-left: 35px;
        color: #aeb4c2 !important;
    }

    .nav-item .collapse .nav-link:hover {
        background: rgba(255,255,255,0.1);
        color: #fff !important;
        transform: none;
        box-shadow: none;
    }

    /* ===== Icons Rotation ===== */
    .rotate-icon {
        transition: transform 0.3s ease;
        font-size: 0.85rem;
    }

    .nav-link[aria-expanded="true"] .rotate-icon {
        transform: rotate(90deg);
        color: #00d9ff;
    }

    /* ===== Logout Button ===== */
    .text-danger {
        color: #ff6b6b !important;
        font-weight: 600;
    }

    .text-danger:hover {
        background-color: rgba(255, 107, 107, 0.1);
        color: #fff !important;
        box-shadow: 0 0 10px rgba(255,107,107,0.4);
    }

    /* ===== Collapsible Animation ===== */
    .collapse {
        transition: all 0.3s ease !important;
    }

    /* ===== Hover Effects on Parent Nav Item ===== */
    .nav-item:hover > .nav-link span i {
        color: #00d9ff;
    }

    /* ===== Responsive Sidebar ===== */
    @media (max-width: 992px) {
        .sidebar {
            height: auto;
            min-height: 100%;
        }
    }
</style>

<div class="sidebar p-3">
    <h5 class="text-center mb-4">🏠 Hostel Admin</h5>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="/hms/dashboard.php" class="nav-link">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>
        </li>

        <!-- Students Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#studentsMenu" role="button" aria-expanded="false" aria-controls="studentsMenu">
                <span><i class="bi bi-person-lines-fill me-2"></i>Students</span>
                <i class="bi bi-chevron-right rotate-icon"></i>
            </a>
            <ul class="nav flex-column collapse" id="studentsMenu">
                <li class="nav-item"><a href="/hms/students/add_student.php" class="nav-link">➕ Add Student</a></li>
                <li class="nav-item"><a href="/hms/students/view_students.php" class="nav-link">👀 View Students</a></li>
            </ul>
        </li>

        <!-- Rooms Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#roomsMenu" role="button" aria-expanded="false" aria-controls="roomsMenu">
                <span><i class="bi bi-door-closed me-2"></i>Rooms</span>
                <i class="bi bi-chevron-right rotate-icon"></i>
            </a>
            <ul class="nav flex-column collapse" id="roomsMenu">
                <li class="nav-item"><a href="/hms/rooms/add_room.php" class="nav-link">➕ Add Room</a></li>
                <li class="nav-item"><a href="/hms/rooms/view_rooms.php" class="nav-link">👀 View Rooms</a></li>
            </ul>
        </li>

        <!-- Fees Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#feesMenu" role="button" aria-expanded="false" aria-controls="feesMenu">
                <span><i class="bi bi-cash-stack me-2"></i>Fees</span>
                <i class="bi bi-chevron-right rotate-icon"></i>
            </a>
            <ul class="nav flex-column collapse" id="feesMenu">
                <li class="nav-item"><a href="/hms/fees/add_fees.php" class="nav-link">➕ Add Fees</a></li>
                <li class="nav-item"><a href="/hms/fees/view_fees.php" class="nav-link">👀 View Fees</a></li>
            </ul>
        </li>

        <li class="nav-item mt-3">
            <a href="/hms/logout.php" class="nav-link text-danger">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </a>
        </li>
    </ul>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
